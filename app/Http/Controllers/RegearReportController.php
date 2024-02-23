<?php

namespace App\Http\Controllers;

use App\Models\DeathInfo;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegearReportController extends Controller
{
    //

    public function index(Request $request) {
        $result = DeathInfo::select('battle_id',
                DB::raw('SUM(regear_cost) as cost'),
                DB::raw('SUM(death_fame) as death_fame'),
                DB::raw("SUM(LENGTH(REPLACE(equipment, '!no_equip,', '')) - LENGTH(REPLACE(REPLACE(equipment, ',', ''), '!no_equip', '')) + 1) as unit"),
                DB::raw('COUNT(1) as death_count'))
        ->first();

        $tiers = [
            'Mentor'    => config('app.roles.mentor'),
            'Core'      => config('app.roles.core'),
            'Senior'    => config('app.roles.senior'),
            'Sinag'     => config('app.roles.sinag'),
            'Trial'     => config('app.roles.trial'),
            'All Tiers'       => null
        ];

        return view('reports.regear.index', ['unfiltered' => $result, 'tiers' => array_reverse($tiers)]);
    }

    public function fetchRoleRegearStats() {
        $result = [];
        $result = DeathInfo::select('battle_id',
                DB::raw('SUM(regear_cost) as cost'),
                DB::raw('SUM(death_fame) as death_fame'),
                DB::raw("SUM(LENGTH(REPLACE(equipment, '!no_equip,', '')) - LENGTH(REPLACE(REPLACE(equipment, ',', ''), '!no_equip', '')) + 1) as unit"),
                DB::raw('COUNT(1) as death_count'))
        ->groupBy('battle_id')
        ->orderBy('battle_id', 'desc')
        ->paginate(5);
        return $result;
    }

    public function fetchGuildLosses(Request $request) {

        $result = DeathInfo::select('battle_id',
                DB::raw('SUM(regear_cost) as cost'),
                DB::raw('SUM(death_fame) as death_fame'),
                DB::raw("SUM(LENGTH(REPLACE(equipment, '!no_equip,', '')) - LENGTH(REPLACE(REPLACE(equipment, ',', ''), '!no_equip', '')) + 1) as unit"),
                DB::raw('COUNT(1) as death_count'))
        ->groupBy('battle_id')
        ->orderBy('battle_id', 'desc')
        ->paginate(5);
        return ['result' => $result];
    }

    public function fetchDeathStats(Request $request) {

        $status = $request->input('status') ? $request->input('status') : '';
        $result = DeathInfo::select('character_id',
                'name',
                DB::raw('SUM(death_fame) as death_fame'),
                DB::raw("SUM(LENGTH(REPLACE(equipment, '!no_equip,', '')) - LENGTH(REPLACE(REPLACE(equipment, ',', ''), '!no_equip', '')) + 1) as items_lost"),
                DB::raw('COUNT(1) as death_count'),
                DB::raw('SUM(regear_cost) as cost'))
        ->groupBy('character_id')
        ->orderBy('death_count', 'desc');

        if (!empty($status)) {
            $result->where('status', $status);
        }
        $result = $result->paginate(10);

        return ['result' => $result];
    }
    public function fetchPendingRegears(Request $request) {
        $result = [];
        $deathlogs = DeathInfo::where('status', 2);

        if ($request->input('tier') != null) {
            $deathlogs->join('users', 'ao_character_id', '=', 'character_id');
            $deathlogs->where('users.roles', 'like', '%' . $request->input('tier') . '%');
        }

        $deathlogs = $deathlogs->get();
            foreach ($deathlogs as $log) {
                $items = explode(",", $log->equipment);
                foreach ($items as $item) {
                    $formattedItem = explode('@', substr($item, 3))[0];
                    if (!Str::contains($item, '!')) {
                        if (!isset($result[$formattedItem])) {
                            $itemInfo = ItemInfo::where('item_id', $item)->first();
                            $name = explode(" ", $itemInfo->item_name);
                            array_shift($name);
                            $result[$formattedItem] = [
                                'items' => [],
                                'name' => implode(" ", $name)
                            ];
                        }
                        array_push($result[$formattedItem]['items'], $item);

                    }
                }
            }

        return ['result' => $result];
    }
}
