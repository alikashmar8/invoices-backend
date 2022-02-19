<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Support\Facades\Auth;

class IsBusinessMember
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                return redirect('home')->with('messageDgr', 'Access Denied.');
            }
        }

        $business = $request->business;
        if (!$business) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                return redirect('home')->with('messageDgr', 'Access Denied.');
            }
        }
        $user = Auth::user();
        $exists = $business->users->contains($user);
        if ($exists) {
            return $next($request);
        } else {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                return redirect('home')->with('messageDgr', 'Access Denied.');
            }
        }
    }
}
