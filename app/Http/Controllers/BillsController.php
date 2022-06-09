<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Contact;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BillsController extends Controller
{
    public function create()
    {
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'You must create a business first');
        }
        $contacts = Contact::where('user_id',Auth::user()->id)->get();
        return view('app.businesses.bills.create-bill', compact('businesses', 'contacts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'total' => 'required|numeric|min:0,max:9999999999',
            'gst' => 'required|numeric|min:0,max:9999999999',
            'payment_date' => 'required',
            'notes' => 'max:255',
            'business_id' => 'required|exists:businesses,id',
        ]);

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
        $bill->gst = $request->gst; 
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
        //$bill->save();

        if($request->contact_id)    $bill->contact_id = $request->contact_id;
        else {
            $contacts = new Contact();
            $contacts->name	= $request->contact_name;
            $contacts->email = $request->contact_email;
            $contacts->phone_number	= $request->contact_phone;
            $contacts->abn	= $request->contact_abn;
            $contacts->address = $request->contact_address;
            $contacts->user_id = Auth::user()->id;
            $contacts->save();
            $bill->contact_id = $contacts->id;
        }
        $bill->save();
        

        return redirect('businesses/' . $request->business_id)->with('msg', 'bill');
    }

    public function edit(Bill $bill){
         
        $contacts = Contact::where('user_id',Auth::user()->id)->get();
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'No business created.');
        }
        return view('app.businesses.bills.edit-bill', compact('bill','contacts'));
    }
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'total' => 'required|numeric|min:0,max:9999999999',
            'gst' => 'required|numeric|min:0,max:9999999999',
            'payment_date' => 'required',
            'notes' => 'max:255', 
        ]);

        if ($validator->fails()) {
            if (request()->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 400);
            } else {
                return redirect()->back()->withInput()
                    ->withErrors($validator);
            }
        }
        $bill = Bill::findOrFail($request->id);
        $bill->title = $request->title;
        $bill->total = $request->total;
        $bill->gst = $request->gst; 
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
        //$bill->save();

        if($request->contact_id)    $bill->contact_id = $request->contact_id;
        else {
            $contacts = new Contact();
            $contacts->name	= $request->contact_name;
            $contacts->email = $request->contact_email;
            $contacts->phone_number	= $request->contact_phone;
            $contacts->abn	= $request->contact_abn;
            $contacts->address = $request->contact_address;
            $contacts->user_id = Auth::user()->id;
            $contacts->save();
            $bill->contact_id = $contacts->id;
        }
        $bill->save();
        

        return redirect('businesses/' . $request->business_id)->with('msg', 'bill');
    }

    public function generatePDF(Bill $bill)
    { 
        $bill = Bill::where('business_id' , 1 )->first();
        $data = [
            'mainLogo' => 'images/logo.png',
            'clientName' => $bill->contact->name,
            'clientEmail' => $bill->contact->email,
            'clientPhone' => $bill->contact->phone_number,
            'clientABN' => $bill->contact->abn,
            'clientAddress' => $bill->contact->address,
            'businessLogo' => $bill->business->logo,
            'businessName' => $bill->business->name,
            'businessABN' => $bill->business->abn,
            'businessAddress' => $bill->business->address,
            'payment_method' => $bill->business->payment_method,
            'id' => $bill->id,
            'title' => $bill->title,
            'total' => $bill->total,
            'GST' => $bill->gst,
            'amount' =>  $bill->total + $bill->gst,
            'is_paid' => $bill->is_paid,
            'due_date' => $bill->due_date,
            'payment_date' => $bill->payment_date,
            'notes' => $bill->notes,
            'created_at' => Carbon::parse($bill->created_at)->format('l jS \\of F Y')
        ];
        $pdf = Pdf::loadView('app.businesses.bills.pdfs.bill-pdf-view', $data);
        Storage::put('public/pdf/'. $bill->id . '.pdf', $pdf->output());
        return $pdf->download($bill->id . '.pdf'); 
    }
}
