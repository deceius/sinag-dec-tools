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
        return view('reports.regear.index');
    }

    public function fetchRoleRegearStats() {
        $result = [];
        $result = DeathInfo::select('battle_id',
                DB::raw('SUM(regear_cost) as cost'),
                DB::raw('SUM(death_fame) as death_fame'),
                DB::raw("SUM(LENGTH(REPLACE(equipment, '!no_equip,', '')) - LENGTH(REPLACE(REPLACE(equipment, ',', ''), '!no_equip', '')) + 1) as unit"),
                DB::raw('COUNT(1) as death_count'))
        ->groupBy('battle_id')
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
        ->paginate(5);
        return ['result' => $result];
    }

    public function fetchPendingRegears(Request $request) {
        $result = [];
        $deathlogs = DeathInfo::where('status', 2)->get();
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
