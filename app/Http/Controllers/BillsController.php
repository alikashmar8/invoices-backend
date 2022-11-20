<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\bills_items;
use App\Models\Contact;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Business;
use App\Models\BillAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail; 
use App\Mail\ShareBill; 

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
        if($request->get('bill_items')){
            foreach ($request->get('bill_items') as $billItem) {

                $bill_item = new bills_items(); 
                $bill_item->description = $billItem['description'];
                $bill_item->quantity = $billItem['quantity'];
                $bill_item->gst = $billItem['gst'];
                $bill_item->item_price = $billItem['item_price'];
                $bill_item->bill_id = $bill->id;
                $bill_item->save();
                // More fields
                
                    //$shipment->shipment_details()->save($shipment_detail);
                //$bill_item1 = new bills_items($bill_item);
            }
        }
        \QrCode::size(50) 
                ->generate(asset('storage/pdf/'.$bill->id.'.pdf'), public_path('storage/QR/'.$bill->id.'.svg'));


        $this->generatePDF($bill);
        if (isset($request->send_bill)) {
            $request->email = null;
            $this->ShareBill($bill, $request);
        }
        return redirect('businesses/' . $request->business_id)->with('msg', 'bill')->with('gocha', 'bill');
    }

    public function edit(Bill $bill){
         
        $contacts = Contact::where('user_id',Auth::user()->id)->get();
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'No business created.');
        }
        $bill_items = bills_items::where('bill_id' , $bill->id)->get();
        $maxId = bills_items::where('bill_id' , $bill->id)->max('id');
        return view('app.businesses.bills.edit-bill', compact('bill','bill_items','contacts','maxId'));
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

        $items_collection = collect();
        if($request->get('bill_items')){
            print_r ($request->get('bill_items'));
            foreach ($request->get('bill_items') as $billItem) {
                 
                if(bills_items::where('id', $billItem['id'])->exists()){ 
                    $bill_item = bills_items::findOrFail($billItem['id']);
                    $bill_item->description = $billItem['description'];
                    $bill_item->quantity = $billItem['quantity'];
                    $bill_item->gst = $billItem['gst'];
                    $bill_item->item_price = $billItem['item_price']; 
                    $bill_item->save();
                }else{
                    
                    $bill_item = new bills_items(); 
                    $bill_item->description = $billItem['description'];
                    $bill_item->quantity = $billItem['quantity'];
                    $bill_item->gst = $billItem['gst'];
                    $bill_item->item_price = $billItem['item_price'];
                    $bill_item->bill_id = $bill->id;
                    $bill_item->save();
                }
                $items_collection->push($bill_item);
            }
        }

        $old_items = bills_items::where('bill_id' , $bill->id)->get();
        foreach($old_items as $old_item){
            if(!$items_collection->contains('id',$old_item->id)){
                 $old_item->delete() ;
            }
        }

        $this->generatePDF($bill);
        return redirect('businesses/' . $request->business_id)->with('msg', 'bill')->with('gocha', 'bill');;
    }

    public function generatePDF(Bill $bill)
    { 
        //$bill = Bill::where('business_id' , 1 )->first();
        $bill_items = bills_items::where('bill_id' , $bill->id)->get();
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
            'QR' => 'storage/QR/'.$bill->id.'.svg',
            'bill_items' => $bill_items,
            'created_at' => Carbon::parse($bill->created_at)->format('l jS \\of F Y')
        ];

        
        $pdf = Pdf::loadView('app.businesses.bills.pdfs.bill-pdf-view', $data);
        Storage::put('public/pdf/'. $bill->id . '.pdf', $pdf->output());
        return 0;//$pdf->download($bill->id . '.pdf'); 
    }
    public function ShareBill(Bill $bill, Request $request)
    { 
        
        $data = array(
            'billId' => $bill->id,
            'billURL' => asset('storage/pdf/'.$bill->id.'.pdf'),
            'billQR' => asset('storage/QR/'.$bill->id.'.svg'),
            'business' => Business::findOrFail($bill->business_id)->name,
            'sender' => Auth::user()->name,
        );
        if($request->email == null){
            $email = Contact::findOrFail($bill->contact_id)->email;
            if(count(BillAccess::where('email', $email)->where('bill_id',$bill->id )->get()) ==0 ){
                $billAccess = new BillAccess();
                $billAccess->email = $email;
                $billAccess->bill_id = $bill->id;
                $billAccess->save();
            }
            Mail::to($email)->send(new ShareBill($data));
        }else{
            if(count(BillAccess::where('email', $request->email)->where('bill_id',$bill->id )->get()) ==0 ){
                $billAccess = new BillAccess();
                $billAccess->email = $request->email;
                $billAccess->bill_id = $bill->id;
                $billAccess->save();
            }
            Mail::to($request->email)->send(new ShareBill($data));
            //return response()->json(['success' => true , 'emailAdded' =>$request->email]);//->with('messageSuc', 'Invoice sent successfully'); 
            return back()->with('msg', 'bill');//->with('emailAdded' ,$request->email );
        }
        
    }
    public function changeAccessForm(Bill $bill, Request $request)
    {
        $bill->restricted = $request->restricted;
        $bill->save();
        return response()->json(['success' => true]); 

    }
    public function removeAccess($id) 
    {
        $access = BillAccess::where('id',$id)->first();
        if($access != null){
            $access->delete();
        }
        return response()->json(['success' => true]);
    }
    public function accessBill(Bill $bill)
    {
        if($bill->restricted == 0){
            return redirect('/storage/pdf/'. $bill->id . '.pdf');
        }
        $exists = Business::where('id' , $bill->business_id)->first()->users->contains(Auth::user());
        if(!$exists && count(BillAccess::where('email', Auth::user()->email)->where('bill_id',$bill->id )->get()) ==0 ){
            return redirect('/')->with('messageDgr', 'Access denied, you are not permitted to access this bill.');
        }
        return redirect('/storage/pdf/'. $bill->id . '.pdf');
    }
}
