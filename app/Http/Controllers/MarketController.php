<?php

namespace App\Http\Controllers;

use App\Models\ItemInfo;
use App\Models\Items;
use App\Models\MarketPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class MarketController extends Controller
{
    //

    public function index(Request $request) {
            $itemSearch = $request->input('itemSearch');
            $city = $request->input('locationSearch');
            $tier = $request->input('tierSearch');
            $collection = [];
            $cities = [
                'All Cities' => '',
                'Brecilien' => '5003',
                'Lymhurst' => 'Lymhurst',
                'Bridgewatch' => 'Bridgewatch',
                'Fort Sterling' => 'Fort Sterling',
                'Martlock' => 'Martlock',
                'Thetford' => 'Thetford',
                'Caerleon' => 'Caerleon',
            ];
            $tiers = ["All Tiers", 1, 2, 3, 4, 5, 6, 7, 8];
            $tier = ($tier == "All Tiers") ? "" : $tier;
            $value = $this->searchItem($itemSearch, ($tier == null) ? "" : $tier);

        if ($request->ajax()) {
            $response = Http::get('https://east.albion-online-data.com/api/v2/stats/prices/'.$value.'?locations='.$city);
            $object = (array)json_decode($response->body());
            $collection = MarketPrice::hydrate($object);

            return ['market_data' => $collection];
        }

        return view('market.index', ['data' => $collection, 'searchKeyword' => ($itemSearch) ? $itemSearch : '', 'city' => ($city) ? $city : '', 'tier' => ($tier) ? $tier : '', 'cities' => $cities, 'tiers' => $tiers]);
    }


    function searchItem($searchWord, $tier = "")
    {
        $itemDump = ItemInfo::where('item_name', 'like', '%'.$searchWord.'%');
        if (!empty($tier)){
            $itemDump->where('item_id', 'like', 'T'.$tier.'%');
        }
        return implode(",", collect($itemDump->get())->pluck('item_id')->all());
    }

    function getLocalizedName($array, $itemId)
    {
        $result = array_filter($array,
            function ($item) use ($itemId) {
                if ($item['LocalizedNames'] != null) {
                    return $item['UniqueName'] == $itemId;
                }
            }
        );

        return array_values($result)[0]['LocalizedNames']['EN-US'];
    }
}
