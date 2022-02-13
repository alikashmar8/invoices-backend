<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function profile(User $user)
    {
        if(Auth::user()->id != $user->id){
            return redirect('/')->with( 'messageDgr' , 'Access Denied.');
        }

        if( request()->is('api/*')){
            //an api call
            return response()->json(['user' => $user]);
        }else{
            //a web call
            return view('app.profile' , compact('user'));
        }
    }
}
