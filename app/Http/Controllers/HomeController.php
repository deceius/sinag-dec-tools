<?php

namespace App\Http\Controllers;

use App\Models\BattleInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request) {



        return view("welcome");
    }

    public function getGuildData(Request $request) {
        if ($request->ajax()) {
            $weeklyKF =  Http::get("https://gameinfo-sgp.albiononline.com/api/gameinfo/guilds/" . config('app.ingame_guild_id') . "/top?limit=5&range=week");
            $top5PvP = DB::table(DB::raw('(select 0 as kf, sum(kill_fame) as df, sum(1) as deaths, 0 as kills, victim_name as name  from battle_infos bi where bi.victim_guild_id  = "f6SvcYhFSmOYi0Cvl49lAQ" group by name
                        union all
                        select sum(kill_fame) as kf, 0 as df, 0 as deaths, sum(1) as kills, killer_name as name  from battle_infos bi where bi.killer_guild_id  = "f6SvcYhFSmOYi0Cvl49lAQ" group by name) as t'))
                            ->selectRaw('sum(kf) as kf, sum(df) as df, sum(deaths) as d, sum(kills) as k, format(sum(kf) / sum(df), 2) as f_ratio,  format(sum(kills) / sum(deaths), 2) as c_ratio, name')
                            ->groupBy('name')
                            ->orderByDesc('kf')
                            ->orderByDesc('f_ratio')
                            ->limit(5)
                            ->get();


            // dd($top5PvP);
            return [ 'kills' => json_decode($weeklyKF->body()), 'goat' => json_decode($top5PvP)];
        }
    }
}
