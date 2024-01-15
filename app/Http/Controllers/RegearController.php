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
use Illuminate\Support\Facades\DB;
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
            $regearInfo->remarks = $request->input('remarks');
            $member = User::where('ao_character_id', $regearInfo->character_id)->first();

            if ($request->input("reject")){
                $regearInfo->status = -1;

                DiscordAlert::message("<@" . $member->id . ">'s regear [request](". url('/home') .") has been rejected. Reason: " . $regearInfo->remarks);
            } else {
                $regearInfo->status = 1;
                $regearInfo->remarks = $request->input('remarks');
                DiscordAlert::message("<@" . $member->id . ">'s regear [request](". url('/home') .") has been fulfilled by <@" . Auth()->user()->id . ">. Please check out chest: " . $regearInfo->remarks);
            }
        }
        else {
            $regearInfo->status = 2;
        }
        $regearInfo->save();

        return redirect()->back();
    }

    public function fetchAllRegears(Request $request) {
            $deaths = [];
            $deaths = DeathInfo::from("death_infos as di")->select( DB::raw( 'di.*' ) )->orderBy('status', 'desc')->orderBy('timestamp', 'desc');

            if ($request->input('status')) {
                $deaths->where('status', $request->input('status'));
            }
            $deaths->addSelect(DB::raw('COALESCE(bi.role_id, -1) as role_id'));
            $deaths->leftJoin('build_infos AS bi', function ($join) {
                $join->on(DB::raw('bi.equipment'), "LIKE", DB::raw("CONCAT('%', SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(di.equipment, ',', 1), '@', 1), 4), '%')"));
            });
            if ($request->input('role_id') != null) {
                $deaths->where('role_id', $request->input('role_id'));
            }


            $deaths = $deaths->paginate(10);
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
