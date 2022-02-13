<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Image;
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
    public function edit(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if (isset($request->profile_picture)) {
            $image = $request->file('profile_picture');
            $user->profile_picture = $this->addImages($image);
        } elseif ($request->profile_picture == '' || $request->profile_picture == null) {
            $user->profile_picture =  'img/profile.png';
        } else {
            $user->profile_picture = 'img/profile.png';
        }
        $user->save();

        return redirect('/profile/'.Auth::user()->id);
    }

    
    public function addImages($image)
    {
        $destinationPath = 'uploads/profile'; //public_path('uploads/profile');

        $img = Image::make($image->getRealPath());
        $img->resize(700, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . time() . $image->getClientOriginalName());
        $path = $destinationPath . '/' . time() . $image->getClientOriginalName();

        /*$imageName =pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME). time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = 'uploads/profile/'; //public_path('uploads/profile');
        $image->move($destinationPath, $imageName);
        $path = $destinationPath . $imageName;*/
        return $path;
    }
}
