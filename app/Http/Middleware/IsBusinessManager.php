<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\UserBusiness;
use Closure;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class IsBusinessManager
{

    public function error_response(Request $request)
    {
        if ($request->is('api/*')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            return redirect('home')->with('messageDgr', 'Access Denied.');
        }
    }

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
            return $this->error_response($request);

        $business = $request->business;

        if (!$business)
            return $this->error_response($request);

        $user = Auth::user();
        $exists = $business->users->contains($user);

        if (!$exists)
            return $this->error_response($request);

        $pivot = UserBusiness::where('business_id', $business->id)->where('user_id', $user->id)->first();

        if ($pivot->role != UserRole::MANAGER && $pivot->role != UserRole::CO_MANAGER)
            return $this->error_response($request);

        return $next($request);
    }
}
