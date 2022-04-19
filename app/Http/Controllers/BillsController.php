<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillsController extends Controller
{
    public function create()
    {
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'You must create a business first');
        }
        return view('app.bills.create', compact('businesses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'total' => 'required|numeric|min:0,max:9999999999',
            'payment_date' => 'required',
            'notes' => 'max:255',
            'business_id' => 'required|exists:businesses,id',
        ] );

        if ($validator->fails()) {
            if (request()->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 400);
            } else {
                return redirect()->back()->withInput()
                    ->withErrors($validator);
            }
        }
        $bill = new Bill();
        $bill->title = $request->title;
        $bill->total = $request->total;
        if (isset($request->is_paid)) {
            $bill->is_paid = 1;
            if (isset($request->payment_date)) {
                $bill->payment_date = $request->payment_date;
            } else {
                $bill->payment_date = Carbon::now();
            }
        } else {
            $bill->is_paid = 0;
        }
        $bill->due_date = $request->due_date;
        $bill->notes = $request->notes;
        $bill->created_by = Auth::user()->id;
        $bill->business_id = $request->business_id;
        $bill->contact_id = $request->contact_id;
        $bill->save();


        // $contacts = new Contact();
        // $contacts->name	= $request->name;
        // $contacts->email = $request->email;
        // $contacts->phone_number	= $request->phone;
        // $contacts->abn	= $request->abn;
        // $contacts->address = $request->address;
        // $contacts->bill_id = $bill->id;
        // $contacts->save();

        return redirect('businesses/' . $request->business_id);
    }
}
