<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;
use Image;
class UsersController extends Controller
{
    public function profile(User $user)
    {
        if(Auth::user()->id != $user->id){
            return redirect('/')->with( 'messageDgr' , 'Access Denied.');
        }
        $notifications = $user->notifications()->latest()->get();

        if( request()->is('api/*')){
            //an api call
            return response()->json(['user' => $user , 'notifications' => $notifications] );
        }else{
            //a web call
            return view('app.profile' , compact('user', 'notifications'));
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
    public function memberCheckerIfExist(Request $request)
    {
        $user = User::where('email', $request->email1)->get();

        if(!$user->isEmpty()) {
            $invitations = Invitation::where('user_id' , $user[0]->id)
                                    ->where('business_id', $request->id)
                                    ->where('status' , 'PENDING')->get();

            if(!$user[0]->businesses()->where('business_id', $request->id)->get()->isEmpty()
                || !$invitations->isEmpty()  ){
                return response()->json(['success' => 'isTeamMember']);
            }
            return response()->json(['success' => 'exist']);
        }
        else return response()->json(['success' => 'notExist']);

    }
    public function registerPlan($id)
    {
        // Enter Your Stripe Secret
        \Stripe\Stripe::setApiKey('sk_test_51HywjtC3KTL075dcARHpuSgf8trC3awdHpWBgHYmfInB7nbYTSYNnHBlLRaOPFOffMODwAvpkjZB1kzjuRrFumxv00H2p0JX7t');

        $plan = Plan::findOrFail($id);
        //$amount = $request->amount ;
        //$amount *= 100;(float) 
        $amount = $plan->price * 100;
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'AUD',
            'description' => 'Payment For Invoice Gem, Developed by WebSide.com.au',
            'payment_method_types' => ['card'],
        ]);
        $intent = $payment_intent->client_secret;

        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        $payment->price	= $plan->price;
		$payment->is_paid = 0 ;
		$payment->plan_id = $id; 
        $payment->save();
        return view('plan.checkout' ,compact('plan','payment','amount','intent'));
    }
}
