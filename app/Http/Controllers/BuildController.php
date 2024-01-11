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
            $roleId = $request->input('role_id');
            $builds = $roleId != null ? BuildInfo::where('role_id', $roleId)->get() : BuildInfo::orderBy('role_id')->get();
            return ['builds' => $builds];
        }

        return view('builds.index');
    }

    public function create(Request $request) {


        return view('builds.create', ['buildInfo' => null]);
    }


    public function edit(Request $request, BuildInfo $buildInfo): View {
        return view('builds.edit', ['buildInfo' => $buildInfo]);
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request)
    {

        $build = new BuildInfo();
        $build->fill($request->all());
        if($build->id > 0) {
           BuildInfo::whereId($build->id)->update($request->all());
        }
        else {
            $build->save();
        }

        return ['data' => $request->all()];
    }

        /**
     * Display the user's profile form.
     */
    public function update(Request $request, BuildInfo $build)
    {
        $build->save();
        return ['data' => $request->all()];
    }


}
