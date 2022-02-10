<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\UserBusiness;
use Illuminate\Http\Request;
use App\Models\User;
use \Illuminate\Support\Facades\Auth;
use Image;
class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $business = new Business();
        $business->name = $request->name;
        $business->is_active = 1;
        if (isset($request->logo)) {
            $image = $request->file('logo');
            $business->logo = $this->addBizImages($image); 
        }elseif ($request->logo == ''|| $request->logo == null){
            $business->logo =  'img/bizLogo.png';
        }else{
            $business->logo = 'img/bizLogo.png';
        } 
        $business->save();

        $relation = new UserBusiness();
        $relation->role	= 'SUPERADMIN';
        $relation->user_id =Auth::user()->id;
        $relation->business_id = $business->id;
        $relation->save();

        return redirect('myBusinesses')->with( 'messageSuc' , 'Business profile created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        $myBus = UserBusiness::where('user_id' , Auth::user()->id)->get();
        $businesses = collect();
        if($myBus != null){ 
            foreach($myBus as $b){ 
                //$businesses = Business::all();//where('userId' , Auth::user()->id);
                $businesses->push(Business::findOrFail($b->business_id));
            }
        } 
        
        return view('app.businessList' , compact('businesses' ,'myBus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
    public function showBusiness($id)
    {
        $business = Business::findOrFail($id);
        $auth = UserBusiness::where('business_id' ,$id)->where('user_id', Auth::user()->id)->get();
        if(count($auth) > 0 ){
            return view('app.businessDetails' , compact('business'));
        }else{
            return redirect('/')->with( 'messageDgr' , 'Access Denied.');
        }

    }

    public function addBizImages($image){ 
        $destinationPath = 'uploads/biz'; //public_path('uploads/biz');

        $img = Image::make($image->getRealPath());
        $img->resize(700, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . time() . $image->getClientOriginalName());
        $path = $destinationPath . '/' . time() . $image->getClientOriginalName();

        /*$imageName =pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME). time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = 'uploads/biz/'; //public_path('uploads/biz');
        $image->move($destinationPath, $imageName);
        $path = $destinationPath . $imageName;*/
        return $path;
    }


}
