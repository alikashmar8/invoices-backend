<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\DefaultBusiness;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
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
    public function createDefault()
    {
        $defaultBusiness = DefaultBusiness::where('user_id' , Auth::user()->id)->get();
        if(count($defaultBusiness)) $business = $defaultBusiness[0];
        else $business = Auth::user()->businesses()->first();

        if (request()->is('api/*')) { 
            return response()->json(['succeed' => true, 'business' => $business]);
        } else {
            return view('app.businesses.invoices.create-invoice' , compact('business'));
        }
    }

    public function create()
    {
        return view('app.businesses.invoices.create-invoice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = new Invoice();
        $invoice->title =	$request->title;
        $invoice->total	= $request->total;
        if(isset($request->is_paid)){
            $invoice->is_paid = 1;
            if(isset($request->payment_date)){
                $invoice->payment_date = $request->payment_date;
            }else{
                $invoice->payment_date = Carbon\Carbon::now();
            }
        }
        $invoice->due_date = $request->due_date;
        $invoice->reference_number = $request->reference_number;
        $invoice->notes = $request->notes;
        $invoice->discount = $request->discount;
        $invoice->extra_amount = $request->extra_amount;
        $invoice->created_by = Auth::user()->id;
        $invoice->business_id = $request->business_id;
        $invoice->save();
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $attach) { 
                if ($attach->getClientOriginalExtension() == 'pdf' 
                || $attach->getClientOriginalExtension() == 'docx'
                || $attach->getClientOriginalExtension() == 'png'
                || $attach->getClientOriginalExtension() == 'jpg'
                || $attach->getClientOriginalExtension() == 'xlsx' ) {
                    //You have better way for attaching 
                    $attachment = new InvoiceAttachment();
                    $attachment->url = $this->addImages($attach);
                    $attachment->invoice_id = $invoice->id;
                    $attachment->save();
                }  else{
                    //You have better way for attaching 
                    $attachment = new InvoiceAttachment();
                    $attachment->url = 'img/notSupportedFile.png';
                    $attachment->invoice_id = $invoice->id;
                    $attachment->save();
                }
            }
        }
        return redirect('businesses/'.$request->business_id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    public function addImages($image)
    {  
        $imageName =pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME). time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = 'uploads/invoices/'; //public_path('uploads/biz');
        $image->move($destinationPath, $imageName);
        $path = $destinationPath . $imageName;
        return $path;
    }

}
