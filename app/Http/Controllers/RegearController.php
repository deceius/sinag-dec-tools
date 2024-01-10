<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BuildInfo;
use App\Models\RegearInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class RegearController extends Controller
{

    public function index(Request $request) {

        return view('regear.index');
    }

    public function store(Request $request)
    {

        DiscordAlert::message("A regear has been filed by <@" . Auth()->user()->id . '>. check it out here: ' . url('/regear?id=') . '12');
        // return ['data' => $request->all()];
    }


}
