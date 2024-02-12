<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsBlackMarket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        if ($user && $this->hasBlackMarketRole($user)) {
            return $next($request);
       }

       return redirect('/')->with('error', 'No Access.');
    }

    function hasBlackMarketRole($user){
        $roles = explode(",", $user->roles);
        $blckMarketRole = config('app.roles.blck_market');

        return in_array($blckMarketRole, $roles);
    }
}
