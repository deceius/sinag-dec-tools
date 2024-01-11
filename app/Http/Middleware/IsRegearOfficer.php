<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsRegearOfficer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $this->hasOfficerRole($user)) {
            return $next($request);
       }

       return redirect('home');
    }

    function hasOfficerRole($user){
        $roles = explode(",", $user->roles);
        $regearOfficerRole = env('OFFICER_REGEAR_DISCORD_ROLE');

        return in_array($roles, $regearOfficerRole);
    }
}
