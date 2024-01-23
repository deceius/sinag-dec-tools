<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request) {



        return view("welcome");
    }

    public function getGuildData(Request $request) {
        if ($request->ajax()) {
            $weeklyKF =  Http::get("https://gameinfo-sgp.albiononline.com/api/gameinfo/guilds/" . config('app.ingame_guild_id') . "/top?limit=5&range=week");
            $top5PvP =  Http::get("https://gameinfo-sgp.albiononline.com/api/gameinfo/guilds/" . config('app.ingame_guild_id') . "/data");

            return [ 'kills' => json_decode($weeklyKF->body()), 'goat' => json_decode($top5PvP->body())->topPlayers ];
        }
    }
}
