<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BuildInfo;
use App\Models\DeathInfo;
use App\Models\RegearInfo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class RegearController extends Controller
{

    public function index(Request $request) {

        return view('regear.index');
    }

    public function processRegear(Request $request, DeathInfo $regearInfo) {
        // 2 - pending, 1 - regeared, 0 - not filed
        if (Auth::user()->is_regear_officer && $regearInfo->status == 2) {
            $regearInfo->regeared_by = Auth::user()->id;
            $regearInfo->status = 1;
            $member = User::where('ao_character_id', $regearInfo->character_id)->first();
            DiscordAlert::message("<@" . $member->id . ">'s regear [request](". url('/home') .") has been fulfilled by <@" . Auth()->user()->id . ">. Please check out the designated chest.");

        }
        else {
            $regearInfo->status = 2;
        }
        $regearInfo->save();

        return redirect()->back();
    }

    public function fetchAllRegears(Request $request) {
        $deaths = [];
            $deaths = DeathInfo::orderBy('status', 'desc')->orderBy('timestamp', 'desc')->get();
            $approvedGears = []; //['HEAD_LEATHER_SET3', '2H_AXE', 'HEAD_LEATHER_UNDEAD', '2H_DUALAXE_KEEPER', '2H_HAMMER_AVALON', 'HEAD_PLATE_SET2', 'CAPEITEM_FW_MARTLOCK', 'ARMOR_PLATE_KEEPER', 'ARMOR_LEATHER_HELL'];
            foreach ($deaths as $death) {
                $newGears = [];
                $notAllowed = 0;
                $gears = explode(',', $death->equipment);
                foreach ($gears as $gear) {
                    $search = BuildInfo::where('equipment', 'like', '%' . substr(explode("@", $gear)[0], 3) . '%')->get();
                    if (count($search) == 0) {
                        $gear = '!' . $gear;
                    }
                    array_push($newGears, $gear);
                }
                $death->equipment = implode(",", $newGears);
                $death->allowed_gears = count($newGears) - $notAllowed;
                $death->regearing_officer = $death->regearingOfficer;

            }
        return [ 'deaths' => $deaths ];
    }

    public function store(Request $request)
    {

        DiscordAlert::message("A regear has been filed by <@" . Auth()->user()->id . '>. check it out here: ' . url('/regear?id=') . '12');
        // return ['data' => $request->all()];
    }


}
