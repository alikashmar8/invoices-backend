<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use \Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function profile($id)
    {
        if(Auth::user()->id != $id){
            return redirect('/')->with( 'messageDgr' , 'Access Denied.');
        }
        $user = User::findOrFail($id);
        return view('app.profile' , compact('user'));
    }

}
