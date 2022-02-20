<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Invitation;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        if($notification->title == 'Joining a new team'){
            $pendingInvitations = Invitation::where('user_id', Auth::user()->id)
            ->where('status', 'PENDING')
            ->where('notification_id', $notification->id)
            ->first()->delete();
        }
        $notification->delete();
        return response()->json(['success' => true]); 
        return back();
    }
    public function markRead(Notification $notification)
    {
        $notification->is_read = 1;
        $notification->save();
        return response()->json(['success' => true]); 
        return back();
    }
    public function markUnread(Notification $notification)
    {
        $notification->is_read = 0;
        $notification->save();
        return response()->json(['success' => true]); 
        return back();
    }

}
