<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DeathInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        return [ 'deaths' => $deaths ];
    }

    public function fetchDeathLog(Request $request)
    {
        $ign = $request->input('id');
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
