<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Business;
use App\Models\Invitation;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
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
        $validator = Validator::make($request->all(), [
            'business_id' => ['required', 'exists:businesses,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'role' => ['required', new EnumValue(UserRole::class)],
        ]);

        if ($validator->fails()) {
            //TODO: add error message for api
            Log::error($validator->errors());
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $business = Business::where('id', $request->business_id)->first();
        $business->users;

        $invitation = Invitation::create([
            'business_id' => $request->business_id,
            'user_id' => $user->id,
            'role' => $request->role,
            'message' => 'Hello, I would like you to join my team.',
        ]);

        //TODO: send notification for the invited user

        return custom_response($request->is('api/*'), ['invitation' => $invitation], compact('invitation', 'business'), 'app.businesses.members.list-members', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        //
    }
}
