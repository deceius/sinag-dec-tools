<?php

namespace App\Http\Controllers;

use App\Models\ItemInfo;
use App\Models\Items;
use App\Models\MarketPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class MarketController extends Controller
{
    //

    public function index(Request $request) {
            $itemSearch = $request->input('itemSearch');
            $city = $request->input('locationSearch');
            $tier = $request->input('tierSearch');
            $enchantment = $request->input('enchantmentSearch');
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
            $enchantments = ["All Enchantments", 1, 2, 3, 4];
            $tier = ($tier == "All Tiers") ? "" : $tier;
            $enchantment = ($enchantment == "All Enchantments") ? "" : $enchantment;
            $value = $this->searchItem($itemSearch, ($tier == null) ? "" : $tier, ($enchantment == null) ? "" :$enchantment);
        if ($request->ajax()) {
            $url = 'https://east.albion-online-data.com/api/v2/stats/prices/'.$value.'?locations='.$city;
            $response = Http::get($url);
            $object = (array)json_decode($response->body());
            $collection = MarketPrice::hydrate($object);

            return ['market_data' => $collection];
        }

        return view('market.index', [
            'data' => $collection,
            'searchKeyword' => ($itemSearch) ? $itemSearch : '',
            'enchantment' => ($enchantment) ? $enchantment : '',
            'city' => ($city) ? $city : '',
            'tier' => ($tier) ? $tier : '',
            'enchantment' => ($enchantment) ? $enchantment : '',
            'cities' => $cities,
            'enchantments' => $enchantments,
            'tiers' => $tiers]);
    }


    public function bmIndex(Request $request) {

        Log::channel('bm')->info(Auth::user()->username . " have accessed the black market.");
        $tiers = [1, 2, 3, 4, 5, 6, 7, 8];
        $enchantments = [0, 1, 2, 3, 4];
        if ($request->ajax()) {

            $tier = $request->input('tier') ? $request->input('tier') : '';
            $enchant = $request->input('enchant') ? $request->input('enchant') : '';


            $itemDump = ItemInfo::where('item_id', 'like', 'T'. $tier .'%');
            $itemDump->where('item_id', $enchant > 0 ? 'like' : 'not like', '%@' . ($enchant > 0 ? $enchant : '' ). '%');
            $itemDump->where('item_id', 'not like', '%_BEAN');
            $itemDump->where('item_id', 'not like', '%_WHEAT');
            $itemDump->where('item_id', 'not like', '%_CABBAGE');
            $itemDump->where('item_id', 'not like', '%_TURNIP');
            $itemDump->where('item_id', 'not like', '%_CORN');
            $itemDump->where('item_id', 'not like', '%_PUMPKIN');
            $itemDump->where('item_id', 'not like', '%_COMFREY');
            $itemDump->where('item_id', 'not like', '%_BURDOCK');
            $itemDump->where('item_id', 'not like', '%_MEAT');
            $itemDump->where('item_id', 'not like', '%_BUTTER');
            $itemDump->where('item_id', 'not like', '%_ALCOHOL');
            $itemDump->where('item_id', 'not like', '%_RELIC');
            $itemDump->where('item_id', 'not like', '%_RUNE');
            $itemDump->where('item_id', 'not like', '%_SOUL');
            $itemDump->where('item_id', 'not like', '%_EGG');
            $itemDump->where('item_id', 'not like', '%_MILK');
            $itemDump->where('item_id', 'not like', '%_ESSENCE');
            $itemDump->where('item_id', 'not like', 'TREASURE_%');
            $itemDump->where('item_id', 'not like', '%_FARM_%');
            $itemDump->where('item_id', 'not like', '%_FISH_%');
            $itemDump->where('item_id', 'not like', '%_SKILLBOOK_%');
            $itemDump->where('item_id', 'not like', '%_POTION%');
            $itemDump->where('item_id', 'not like', '%_MEAL_%');
            $itemDump->where('item_id', 'not like', '%_WOOD%');
            $itemDump->where('item_id', 'not like', '%_ROCK%');
            $itemDump->where('item_id', 'not like', '%_ORE%');
            $itemDump->where('item_id', 'not like', '%_HIDE%');
            $itemDump->where('item_id', 'not like', '%_FIBER%');
            $itemDump->where('item_id', 'not like', '%_PLANKS%');
            $itemDump->where('item_id', 'not like', '%_METALBAR%');
            $itemDump->where('item_id', 'not like', '%_STONEBLOCK%');
            $itemDump->where('item_id', 'not like', '%_ALCHEMY_%');
            $itemDump->where('item_id', 'not like', '%_TRASH%');
            $itemDump->where('item_id', 'not like', '%_CLOTH');
            $itemDump->where('item_id', 'not like', '%_LEATHER');
            $itemDump->where('item_id', 'not like', '%_SHARD_%');
            $itemDump->where('item_id', 'not like', '%_ARTEFACT_%');
            $itemDump->where('item_id', 'not like', '%_FURNITURE%');
            $itemDump->where('item_id', 'not like', '%_JOURNAL_%');
            $itemDump->where('item_id', 'not like', '%_LABOURER_%');
            $itemDump->where('item_id', 'not like', '%_DUNGEON_%');
            $itemDump->where('item_id', 'not like', '%_LOOT%');
            $itemDump->where('item_id', 'not like', '%_BP');
            $itemDump->where('item_id', 'not like', '%_LEVEL%');
            $itemDump->where('item_id', 'not like', '%_TOKEN_%');
            $itemDump->where('item_id', 'not like', '%_MOUNT_%');
            $itemDump->where('item_id', 'not like', '%_TRACKING');
            $value = implode(",", collect($itemDump->get())->pluck('item_id')->all());
            $url = 'https://east.albion-online-data.com/api/v2/stats/prices/'.$value.'?locations=Black Market';
            $response = Http::get($url);
            $object = (array)json_decode($response->body());
            $collection = MarketPrice::hydrate($object);
            return ['market_data' => $collection];
        }
        return view('black-market.index', [
            'enchantments' => $enchantments,
            'tiers' => $tiers]);
}


    function searchItem($searchWord, $tier = "", $enchant = "")
    {
        $itemDump = ItemInfo::where('item_name', 'like', '%'.$searchWord.'%');
        if (!empty($tier)){
            $itemDump->where('item_id', 'like', 'T'.$tier.'%');
        }
        if (!empty($enchant)){
            $itemDump->where('item_id', 'like', '%@'.$enchant);
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
