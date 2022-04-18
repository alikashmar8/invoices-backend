<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;
use App\Exports\InvoicesOutExport;
use PDF;

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

    public function create()
    {
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'You must create a business first');
        }
        return view('app.businesses.invoices.create-in-invoice', compact('businesses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'total' => 'required|numeric|min:0,max:9999999999',
            'extra_amount' => 'numeric|min:0,max:9999999999|nullable',
            'discount' => 'numeric|min:0,max:9999999999|nullable',
            'reference_number' => 'max:255',
            'payment_date' => 'required',
            'notes' => 'max:255',
            'business_id' => 'required|exists:businesses,id',
            'attachments.*' => 'mimes:pdf,doc,docx,png,jpg,jpeg,xlsx,xls,csv|max:10000',
        ], [
            'attachments.*.mimes' => 'Unsupported attachment file type',
        ]);

        if ($validator->fails()) {
            if (request()->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 400);
            } else {
                return redirect()->back()->withInput()
                    ->withErrors($validator);
            }
        }
        $invoice = new Invoice();
        $invoice->title = $request->title;
        $invoice->total = $request->total;
        if (isset($request->is_paid)) {
            $invoice->is_paid = 1;
            if (isset($request->payment_date)) {
                $invoice->payment_date = $request->payment_date;
            } else {
                $invoice->payment_date = Carbon::now();
            }
        } else {
            $invoice->is_paid = 0;
        }
        $invoice->due_date = $request->due_date;
        $invoice->reference_number = $request->reference_number;
        $invoice->notes = $request->notes;
        $invoice->discount = $request->discount;
        $invoice->discount_type = $request->discount_type;
        $invoice->extra_amount = $request->extra_amount;
        $invoice->created_by = Auth::user()->id;
        $invoice->business_id = $request->business_id;
        $invoice->save();
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $attach) {
                $attachment = new InvoiceAttachment();
                $attachment->url = $this->addImages($attach);
                $attachment->name = $attach->getClientOriginalName();
                $attachment->invoice_id = $invoice->id;
                $attachment->save();
            }
        }
        return redirect('businesses/' . $request->business_id);
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
        $invoice->attachments();
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'No business created.');
        }
        return view('app.businesses.invoices.edit-invoice', compact('invoice', 'businesses'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'total' => 'required|numeric|min:0,max:9999999999',
            'extra_amount' => 'numeric|min:0,max:9999999999|nullable',
            'discount' => 'numeric|min:0,max:9999999999|nullable',
            'reference_number' => 'max:255',
            'payment_date' => 'required',
            'notes' => 'max:255',
            'business_id' => 'required|exists:businesses,id',
            'attachments.*' => 'mimes:pdf,doc,docx,png,jpg,jpeg,xlsx,xls,csv|max:10000',
        ], [
            'attachments.*.mimes' => 'Unsupported attachment file type',
        ]);

        if ($validator->fails()) {
            if (request()->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 400);
            } else {
                return redirect()->back()->withInput()
                    ->withErrors($validator);
            }
        }
        $invoice->title = $request->title;
        $invoice->total = $request->total;
        if (isset($request->is_paid)) {
            $invoice->is_paid = 1;
            if (isset($request->payment_date)) {
                $invoice->payment_date = $request->payment_date;
            } else {
                $invoice->payment_date = Carbon\Carbon::now();
            }
        } else {
            $invoice->is_paid = 0;
        }
        $invoice->due_date = $request->due_date;
        $invoice->reference_number = $request->reference_number;
        $invoice->notes = $request->notes;
        $invoice->discount = $request->discount;
        $invoice->discount_type = $request->discount_type;
        $invoice->extra_amount = $request->extra_amount;
        $invoice->business_id = $request->business_id;
        $invoice->save();
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $attach) {
                $attachment = new InvoiceAttachment();
                $attachment->url = $this->addImages($attach);
                $attachment->name = $attach->getClientOriginalName();
                $attachment->invoice_id = $invoice->id;
                $attachment->save();
            }
        }

        if ($request->attachmentsToDelete != null) {
            $request->attachmentsToDelete = explode(",", $request->attachmentsToDelete);
            foreach ($request->attachmentsToDelete as $att) {
                $attachment = InvoiceAttachment::where('invoice_id', $invoice->id)->where('url', $att)->first();
                File::delete($attachment->url);
                $attachment->delete();
            }
        }
        return redirect('businesses/' . $request->business_id);
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
        $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = 'uploads/invoices/'; //public_path('uploads/biz');
        $image->move($destinationPath, $imageName);
        $path = $destinationPath . $imageName;
        return $path;
    }

    public function exportIn($id)
    {
        return Excel::download(new InvoicesExport($id), 'Invoices.xlsx');
    }


    public function exportOut($id)
    {
        return Excel::download(new InvoicesOutExport($id), 'Invoices.xlsx');
    }

    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('app.businesses.invoices.pdfView', $data);

        return $pdf->download('itsolutionstuff.pdf');
    }
}
