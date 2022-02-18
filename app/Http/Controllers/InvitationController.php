<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\InvitationStatus;
use App\Models\Business;
use \Illuminate\Support\Facades\Auth;
use App\Models\Notification;
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

        $notify = new Notification();
        $notify->title = 'Joining a new team';
        $notify->user_id = $user->id;
        $notify->message = '';
        $notify->save();
        $notify->message = 'You were invited to join ' . $business->name . ' team as ' . $request['role'] . '.
        <form method="post" action="/invitations/' . $invitation->id . '/accept">
            <input type="hidden" name="notification_id" value="' . $notify->id . '" />
            <BR>
            <button type="submit" class="btn btn-link text-success">Accept</a>
        </form>
         <form method="post" action="/invitations/' . $invitation->id . '/reject">
            <input type="hidden" name="notification_id" value="' . $notify->id . '" />
         <BR>
            <button type="submit" class="btn btn-link text-danger">Reject</a>
         </form>';
        $notify->save();

        if (request()->is('api/*')) {
            //an api call
            return response()->json(['invitation' => $invitation]);
        } else {
            //a web call
            return redirect('/businesses/' . $business->id . '/employees');
        }
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
    public function accept(Request $request, Invitation $invitation)
    {

        $validator = Validator::make($request->all(), [
            'notification_id' => ['required', 'exists:notifications,id']
        ]);

        if ($validator->fails()) {
            //TODO: add error message for api
            Log::error($validator->errors());
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $invitation->status = InvitationStatus::ACCEPTED;
        $invitation->save();

        $notification = Notification::findOrFail($request->notification_id);

        $notification->message = 'You were invited to join ' . $invitation->business->name . ' team as ' . $invitation['role'] . '.<BR> <a  class="btn btn-link text-success">Accepted</a> ';
        $notification->is_read = 0;
        $notification->save();

        Auth::user()->businesses()->attach([$invitation->business->id => ['role' => $invitation['role']]]);

        //notify the user that he joined the new team
        $notify = new Notification();
        $notify->title = 'Welcome to ' . $invitation->business->name . ' team';
        $notify->message = 'Now you are a ' . $invitation['role'] . ' in <a href="/businesses/' . $invitation->business->id . '" style="font-weight:bold" class="p-0 btn-link text-primary">' . $invitation->business->name . '</a> team.';
        $notify->user_id = Auth::user()->id;
        $notify->save();

        if (request()->is('api/*')) {
            //an api call
            return response()->json(['accepted' => true]);
        } else {
            //a web call
            return redirect('/businesses/' . $invitation->business->id);
        }
    }

    public function reject(Request $request, Invitation $invitation)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => ['required', 'exists:notifications,id']
        ]);

        if ($validator->fails()) {
            Log::error($validator->errors());
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $invitation->status = InvitationStatus::REJECTED;
        $invitation->save();

        $notification = Notification::findOrFail($request->notification_id);
        $notification->message = 'You were invited to join ' . $invitation->business->name . ' team as ' . $invitation['role'] . '.<BR> <a  class="btn btn-link text-danger">Rejected</a> ';
        $notification->is_read = 0;
        $notification->save();

        if (request()->is('api/*')) {
            //an api call
            return response()->json(['rejected' => true]);
        } else {
            //a web call
            return back()->with('messageDgr', 'Invitation rejected.');
        }
    }
}
