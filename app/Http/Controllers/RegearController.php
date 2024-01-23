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

        $tiers = [
            'Mentor'    => env('MEMBER_ROLE_MENTOR'),
            'Core'      => env('MEMBER_ROLE_CORE'),
            'Senior'    => env('MEMBER_ROLE_SENIOR'),
            'Sinag'     => env('MEMBER_ROLE_SINAG'),
            'Trial'     => env('MEMBER_ROLE_TRIAL')
        ];
        return view('regear.index', ['tiers' => $tiers]);
    }

    public function processRegear(Request $request, DeathInfo $regearInfo) {
        if (Auth::user()->is_regear_officer && $regearInfo->status == 2) {
            $regearInfo->regeared_by = Auth::user()->id;
            $regearInfo->remarks = $request->input('remarks');
            $member = User::where('ao_character_id', $regearInfo->character_id)->first();
            $prompt = "<@" . $member->id . ">'s regear request for Battle ID # `" . $regearInfo->battle_id . "` ";
            if ($request->input("reject")){
                $regearInfo->status = -1;
                DiscordAlert::message($prompt . "has been rejected. Reason: " . $regearInfo->remarks);
            } else {
                $regearInfo->status = 1;
                $regearInfo->remarks = $request->input('remarks');
                DiscordAlert::message( $prompt . "has been fulfilled by <@" . Auth()->user()->id . ">. Please check out chest: " . $regearInfo->remarks);
            }

            $regearInfo->save();
        }
        else {
            $regearInfo->status = 2;
            $regearInfo->save();
            return redirect()->back();
        }

    }

    public function fetchAllRegears(Request $request) {
            $deaths = [];
            $deaths = DeathInfo::from("death_infos as di")->select( DB::raw( 'di.*' ) )->orderBy('status', 'desc')->orderBy('timestamp', 'desc');

            $deaths->addSelect(DB::raw('COALESCE(bi.role_id, -1) as role_id'));
            $deaths->leftJoin('build_infos AS bi', function ($join) {
                $join->on(DB::raw('bi.equipment'), "LIKE", DB::raw("CONCAT('%', SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(di.equipment, ',', 1), '@', 1), 4), '%')"));
            });


            $unfiltered = DeathInfo::select(DB::raw("CONCAT(battle_id, ' > ', DATE_FORMAT(timestamp, '%Y-%m-%d')) as battle_time"))->groupBy("battle_time")->orderBy('timestamp', 'desc')->limit('20')->get();
            if ($request->input('status')) {
                $deaths->where('status', $request->input('status'));
            }
            if ($request->input('role_id') != null) {
                $deaths->where('role_id', $request->input('role_id'));
            }

            if ($request->input('battle_id') != null) {
                $deaths->where('battle_id', $request->input('battle_id'));
            }
            $deaths->join('users', 'ao_character_id', '=', 'character_id');

            if ($request->input('tier') != null) {
                $deaths->where('users.roles', 'like', '%' . $request->input('tier') . '%');
            }


            if ($request->input('name') != null) {
                $deaths->where('name', 'like', '%' . $request->input('name') . '%');
            }


            $deaths->groupBy('di.timestamp', 'di.battle_id', 'di.character_id');

            // dd($deaths->toSql());
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
                $death->member_info = $death->memberInfo;

            }
        return [ 'deaths' => $deaths, 'unfiltered' => $unfiltered ];
    }

    public function store(Request $request)
    {

        DiscordAlert::message("A regear has been filed by <@" . Auth()->user()->id . '>. check it out here: ' . url('/regear?id=') . '12');
        // return ['data' => $request->all()];
    }


}
