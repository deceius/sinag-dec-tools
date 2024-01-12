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
            $deathlogs = DeathInfo::all();//where('status', 2)->get();
            $result = [];
            foreach ($deathlogs as $log) {
                $items = explode(",", $log->equipment);
                foreach ($items as $item) {
                    $formattedItem = explode('@', substr($item, 3))[0];
                    if (!Str::contains($item, '!')) {
                        if (!isset($result[$formattedItem])) {
                            $result[$formattedItem] = [];
                        }
                        array_push($result[$formattedItem], $item);

                    }
                }
            }
            return ['gears' => $result];
        }


    }
}
