<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BuildInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BuildController extends Controller
{

    public function index(Request $request) {

        if ($request->ajax()){
            return ['builds' => BuildInfo::all()];
        }
    }
    /**
     * Display the user's profile form.
     */
    public function store(Request $request)
    {

        $build = new BuildInfo();
        $build->fill($request->all());
        $build->save();

        return ['data' => $request->all()];
    }


}
