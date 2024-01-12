<?php

namespace App\Http\Controllers;

use App\Models\DeathInfo;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegearReportController extends Controller
{
    //

    public function index(Request $request) {
        return view('reports.regear.index');
    }

    public function fetch(Request $request) {
        if ($request->ajax()){
            $deathlogs = DeathInfo::where('status', 2)->get();
            $result = [];
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
            return ['gears' => $result];
        }


    }
}
