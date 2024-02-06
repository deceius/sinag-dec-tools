<?php

namespace App\Http\Controllers;

use App\Models\BuildInfo;
use App\Models\DeathInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class RegearController extends Controller
{

    public function index(Request $request) {

        $tiers = [
            'Mentor'    => config('app.roles.mentor'),
            'Core'      => config('app.roles.core'),
            'Senior'    => config('app.roles.senior'),
            'Sinag'     => config('app.roles.sinag'),
            'Trial'     => config('app.roles.trial')
        ];
        return view('regear.index', ['tiers' => $tiers]);
    }

    public function requestRegear(Request $request, DeathInfo $regearInfo) {

        $member = User::where('ao_character_id', $regearInfo->character_id)->first();
        $regearInfo->status = 2;
        $regearInfo->save();
        $prompt =  $member->ao_character_name . " regear request for Battle ID # `" . $regearInfo->battle_id . "` - sent.";
        Log::info($prompt);
        return redirect()->back();

    }

    public function processRegear(Request $request, DeathInfo $regearInfo) {

        $member = User::where('ao_character_id', $regearInfo->character_id)->first();

        if (Auth::user()->is_regear_officer && $regearInfo->status == 2) {
            $regearInfo->regeared_by = Auth::user()->id;
            $regearInfo->remarks = $request->input('remarks');
            $prompt = "<@" . $member->id . ">'s regear request for Battle ID # `" . $regearInfo->battle_id . "` ";
            if ($request->input("reject")){
                $regearInfo->status = -1;
                $prompt = $prompt . "has been rejected. Reason: " . $regearInfo->remarks;
            } else {
                $regearInfo->status = 1;
                $regearInfo->remarks = $request->input('remarks');
                $prompt =  $prompt . "has been fulfilled by <@" . Auth()->user()->id . ">. Please check out chest: " . $regearInfo->remarks;
            }

            if (App::environment('production')) {
                DiscordAlert::message($prompt);
            }
            Log::info($prompt);

            $regearInfo->save();
            return response('success');
        }


        return redirect()->back();

    }

    public function fetchAllRegears(Request $request) {
            $deaths = [];
            $deaths = DeathInfo::from("death_infos as di")->select( DB::raw( 'di.*' ) )->orderBy('status', 'desc')->orderBy('timestamp', 'desc');

            $deaths->addSelect(DB::raw('COALESCE(bi.role_id, -1) as role_id'));
            $deaths->leftJoin('build_infos AS bi', function ($join) {
                $join->on(DB::raw('bi.equipment'), "LIKE", DB::raw("CONCAT('%', SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(di.equipment, ',', 1), '@', 1), 4), '%')"));
            });


            if ($request->input('status')) {
                $deaths->where('status', $request->input('status'));
            }
            if ($request->input('role_id') != null) {
                $deaths->where('role_id', $request->input('role_id'));
            }

            if ($request->input('battle_id') != null) {
                $deaths->where('battle_id', 'like', '%' . $request->input('battle_id') . '%');
            }
            $deaths->join('users', 'ao_character_id', '=', 'character_id');

            if ($request->input('tier') != null) {
                $deaths->where('users.roles', 'like', '%' . $request->input('tier') . '%');
            }


            if ($request->input('name') != null) {
                $deaths->where('name', 'like', '%' . $request->input('name') . '%');
            }

            $deaths->groupBy('di.timestamp', 'di.battle_id', 'di.character_id');

            $deaths = $deaths->paginate(10);
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
        return [ 'deaths' => $deaths ];
    }
}
