<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class IsInGuild
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->ao_character_id) {
            $url = "https://gameinfo-sgp.albiononline.com/api/gameinfo/players/" . $user->ao_character_id;
            $response = Http::get($url);

            $object = json_decode($response->body());
            if ($object->GuildId != config('app.ingame_guild_id')) {
                return redirect('/')->with('error', 'You are not a member of the guild in-game.');
            }
        }

        return $next($request);

    }
}
