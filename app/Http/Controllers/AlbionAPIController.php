<?php

namespace App\Http\Controllers;

use App\Models\BattleInfo;
use App\Models\BuildInfo;
use App\Models\DeathInfo;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class AlbionAPIController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function searchIGN(Request $request)
    {
        if ($request->ajax()) {
            $ign = $request->input('ign');
            $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/search?q=" . $ign;
            $response = Http::get($url);
            $players = (array)json_decode($response->body())->players;
            $sinagMembers = [];
            foreach ($players as $player) {
                if ($player->GuildId == config('app.ingame_guild_id')) {
                    array_push($sinagMembers, $player);
                }
            }
           return ['ao_characters' => $sinagMembers];
        }
    }

    public function searchDeathLog(Request $request) {
        $id = $request->input('id');
        $deaths = [];
        if ($id) {
            $deaths = DeathInfo::where('character_id', $id)->orderByRaw('FIELD(status, 0) desc')->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->paginate(5);
            foreach ($deaths as $death) {
                $newGears = [];
                $notAllowed = 0;
                $gears = explode(',', $death->equipment);
                foreach ($gears as $gear) {
                    $search = BuildInfo::where('equipment', 'like', '%' . substr(explode("@", $gear)[0], 3) . '%')->get();
                    if (count($search) == 0) {
                        $gear = '!' . $gear;
                    }
                    array_push($newGears, $gear);
                }
                $death->equipment = implode(",", $newGears);
                $death->allowed_gears = count($newGears) - $notAllowed;
                $death->regearing_officer = $death->regearingOfficer;
                $death->member_info = $death->memberInfo;

            }
        }
        return [ 'result' => $deaths ];
    }

    public function parseItems(Request $request) {
        $file = File::get('assets/itemdata.json');
        $data =  json_decode($file, true);
        $forInsert = [];
        foreach($data as $item) {
            if ($item['LocalizedNames'] && $item['UniqueName'] && !Str::contains($item['UniqueName'], 'NONTRADABLE')) {
                array_push($forInsert, [
                    'item_id' => $item['UniqueName'],
                    'item_name' => $item['LocalizedNames']['EN-US']
                ]);
            }
        }
        ItemInfo::upsert($forInsert, ['item_id']);
    }

    public function getItemList(Request $request) {
        $keyword = $request->input('keyword');
        $isElder = $request->input('equip') ? true : false;
        if (!$keyword) {
            return ['item' => null];
        }
        if ($request->ajax()) {
            if (empty($keyword) || strlen($keyword) < 3) {
                return abort(500, 'error');
            }
            $whereClauses = [['item_name', 'LIKE', '%'.$keyword.'%']];
            if ($isElder) {
                array_push($whereClauses, ['item_id', 'LIKE', 'T8_%']);
            }


            $item = ItemInfo::where($whereClauses)->orWhere('item_id', 'LIKE', '%'.$keyword.'%');
            $item = $item->first();
            if (!$item) {
                return abort(404, 'error');
            }
            return ['item' => $item];
        }
    }

    public function fetchDeathLogByBattleId(Request $request) {
        if (!$request->input('battleIds')) {
            return;
        }

        Log::info(Auth()->user()->username . " attempts to open killboard for battle(s): " . $request->input('battleIds'));
        $result = [];
        $battleIds = explode(',', $request->input('battleIds'));
        $formattedBattleIds = [];
        foreach($battleIds as $battleId) {

            array_push($formattedBattleIds, trim($battleId));
            $offset = 0;
            $events = [];
            do {
                $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/events/battle/". trim($battleId) ."?offset=" . $offset ."&limit=51";
                $battle = Http::get($url);
                $events = (array)json_decode($battle->body());
                foreach ($events as $event) {
                    $this->handleEvent($event, trim($battleId));
                    if ($event->Victim->GuildId == config('app.ingame_guild_id')) {
                        $rawData = [
                            'id' => $event->EventId,
                            'battle_id' => trim($battleId),
                            'character_id' => $event->Victim->Id,
                            'name' => $event->Victim->Name,
                            'guild' => $event->Victim->GuildName,
                            'equipment' => $this->parseEquipment($event->Victim->Equipment)->implode(","),
                            'killer_name' => $event->Killer->Name,
                            'killer_guild' => $event->Killer->GuildName,
                            'killer_equipment' => $this->parseEquipment($event->Killer->Equipment)->implode(","),
                            'death_fame' => $event->TotalVictimKillFame,
                            'timestamp' => $event->TimeStamp,
                            'regear_cost' =>  $this->fetchRegearCost($this->parseEquipment($event->Victim->Equipment)),
                        ];
                        $death = DeathInfo::firstOrCreate(
                            ['id' => $event->EventId],
                            $rawData);
                        array_push($result, $death);

                    }
                }

                $offset += 51;
            } while (count($events) > 1);


        }

        Log::info(Auth()->user()->username . " fetched " . count($result) . " death events.");
        // $battleTotalCost = DeathInfo::whereIn('battle_id', $formattedBattleIds)->get()->count();
        $prompt = "<@" . Auth()->user()->id . "> opened [regears](https://sinag.deceius.com) for this [battleboard](https://east.albionbattles.com/multilog?ids=" . implode(",", $formattedBattleIds) . "). @everyone";
        if (App::environment('production')) {
            DiscordAlert::message($prompt);
        }
        Log::info($prompt);
    }

    public function fetchRegearCost($forRegears) {
        $result = [];
        $url = "https://west.albion-online-data.com/api/v2/stats/prices/" . $forRegears->implode(",") ."?qualities=1";
        $battle = Http::get($url);
        $costData = (array)json_decode($battle->body());
        foreach ($forRegears as $item) {
            $costArray = [];
            foreach ($costData as $data) {
               if ($data->item_id == $item) {
                if ($data->buy_price_max > 0) {
                    array_push($costArray, $data->buy_price_max);
                }
               }
            }

            $avgCost = (array_sum($costArray) == 0) ? 0 : array_sum($costArray)/count($costArray);
            array_push($result, $avgCost);
        }
       return array_sum($result);

    }

    function parseEquipment($equipment) {
        return collect([
            $equipment->MainHand ? $equipment->MainHand->Type : "!no_equip",
            $equipment->OffHand ? $equipment->OffHand->Type : "!no_equip",
            $equipment->Head ? $equipment->Head->Type : "!no_equip",
            $equipment->Armor ? $equipment->Armor->Type : "!no_equip",
            $equipment->Shoes ? $equipment->Shoes->Type : "!no_equip",
            $equipment->Cape ? $equipment->Cape->Type : "!no_equip",
        ]);

    }
    public function loadCharacter(Request $request)
    {

        if ($request->ajax()) {
            $id = $request->input('id');
            $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/players/" . $id;
            $response = Http::get($url);
            $object = (array)json_decode($response->body());
            return ['character' => $object];
        }
    }

    function handleEvent($event, $battleId) {
        Log::info('Event Logged :: ' . $event->EventId);
        $battleInfo = BattleInfo::firstOrCreate(
            ['id' => $event->EventId],
            [
                'id' => $event->EventId,
                'battle_id' => $battleId,

                'killer_character_id' => $event->Killer->Id,
                'killer_name' => $event->Killer->Name,
                'killer_guild' => $event->Killer->GuildName,
                'killer_guild_id' => $event->Killer->GuildId,
                'killer_equipment' => $this->parseEquipment($event->Killer->Equipment)->implode(","),

                'victim_character_id' => $event->Victim->Id,
                'victim_name' => $event->Victim->Name,
                'victim_guild' => $event->Victim->GuildName,
                'victim_guild_id' => $event->Victim->GuildId,
                'victim_equipment' => $this->parseEquipment($event->Victim->Equipment)->implode(","),

                'kill_fame' => $event->TotalVictimKillFame,
                'timestamp' => $event->TimeStamp,
            ]);
    }

    public function parsePreviousCTABattles(Request $request) {
        $battleIds = DeathInfo::groupBy('battle_id')->pluck('battle_id')->toArray();
        foreach($battleIds as $battleId) {
            $offset = 0;
            $events = [];
            do {
                $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/events/battle/". trim($battleId) ."?offset=" . $offset ."&limit=51";
                $battle = Http::get($url);
                $events = (array)json_decode($battle->body());
                foreach ($events as $event) {
                    $this->handleEvent($event, trim($battleId));
                }

                $offset += 51;
            } while (count($events) > 1);
        }
    }

}
