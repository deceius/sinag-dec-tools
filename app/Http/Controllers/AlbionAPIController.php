<?php

namespace App\Http\Controllers;

use App\Models\DeathInfo;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

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
                if ($player->GuildId == env('INGAME_GUILD_ID', null)) {
                    array_push($sinagMembers, $player);
                }
            }
           return ['ao_characters' => $sinagMembers];
        }
    }

    public function searchDeathLog(Request $request) {
        $id = $request->input('id');
        $deaths = $id ? DeathInfo::where('character_id', $id)->get() : DeathInfo::all();
        $approvedGears = ['HEAD_LEATHER_SET3', '2H_AXE', 'HEAD_LEATHER_UNDEAD', '2H_DUALAXE_KEEPER', '2H_HAMMER_AVALON', 'HEAD_PLATE_SET2', 'CAPEITEM_FW_MARTLOCK', 'ARMOR_PLATE_KEEPER', 'ARMOR_LEATHER_HELL'];
        foreach ($deaths as $death) {
            $newGears = [];
            $notAllowed = 0;
            $gears = explode(',', $death->equipment);
            foreach ($gears as $gear) {
                $search = Arr::where($approvedGears, function ($value) use ($gear) {
                    return preg_match("/{$value}/i", $gear);
                });
                if (count($search) == 0) {
                    $gear = '!' . $gear;
                    $notAllowed += 1;

                }
                array_push($newGears, $gear);
            }
            $death->equipment = implode(",", $newGears);
            $death->allowed_gears = count($newGears) - $notAllowed;

        }
        return [ 'deaths' => $deaths ];
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
        if ($request->ajax()) {
            $keyword = $request->input('keyword');
            if (empty($keyword) || strlen($keyword) < 3) {
                return abort(500, 'error');
            }
            $item = ItemInfo::where('item_name', 'LIKE', '%'.$keyword.'%')->first();
            if (!$item) {
                return abort(404, 'error');
            }
            return ['item' => $item];
        }
    }

    public function fetchDeathLog(Request $request)
    {
        $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/battles?range=month&offset=0&limit=51&sort=recent&guildId=" . env('INGAME_GUILD_ID', null);
        $response = Http::get($url);
        $battles = (array)json_decode($response->body());
        $deaths = [];

        foreach ($battles as $battle) {
            $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/events/battle/". $battle->id ."?offset=0&limit=51";

            $battle = Http::get($url);

            $events = (array)json_decode($battle->body());

            foreach ($events as $event) {
                if ($event->Victim->GuildId == env('INGAME_GUILD_ID', null)) {
                    $death = DeathInfo::firstOrCreate(
                        ['id' => $event->EventId],
                        [
                            'id' => $event->EventId,
                            'character_id' => $event->Victim->Id,
                            'name' => $event->Victim->Name,
                            'guild' => $event->Victim->GuildName,
                            'equipment' => $this->parseEquipment($event->Victim->Equipment)->implode(","),
                            'killer_name' => $event->Killer->Name,
                            'killer_guild' => $event->Killer->GuildName,
                            'killer_equipment' => $this->parseEquipment($event->Killer->Equipment)->implode(","),
                            'death_fame' => $event->TotalVictimKillFame,
                            'timestamp' => $event->TimeStamp,
                        ]);

                }
            }
        }


        return ['deaths' => DeathInfo::all() ];
    }

    function parseEquipment($equipment) {
        return collect([
            $equipment->MainHand ? $equipment->MainHand->Type : "!no_weapon",
            $equipment->OffHand ? $equipment->OffHand->Type : "!no_offhand",
            $equipment->Head ? $equipment->Head->Type : "!no_offhand",
            $equipment->Armor ? $equipment->Armor->Type : "!no_armor",
            $equipment->Shoes ? $equipment->Shoes->Type : "!no_shoes",
            $equipment->Cape ? $equipment->Cape->Type : "!no_cape",
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

}
