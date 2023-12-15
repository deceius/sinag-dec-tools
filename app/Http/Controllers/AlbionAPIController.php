<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AlbionAPIController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function searchIGN(Request $request)
    {
        $ign = $request->input('ign');
        $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/search?q=" . $ign;

        if ($request->ajax()) {
            $response = Http::get($url);
            $object = (array)json_decode($response->body())->players;

            return ['ao_characters' => $object];
        }
    }


}
