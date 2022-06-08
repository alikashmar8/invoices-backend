<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\User;
class InvoicesOutExport implements FromCollection,   WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function headings(): array
    {
        return [

            'Title', 'Total', 'Extra_amount', 'Discount', 'Discount_type', 'Reference_number',
            'Paid' ,  'Due_date' , 'Payment_date' , 'Notes' , 'Created_by' ,   'Created_at'
        ];
    }
    public function collection()
    {
        $invoices = Bill::select('title', 'total', 'extra_amount', 'discount', 'discount_type', 'reference_number',
        'is_paid' ,  'due_date' , 'payment_date' , 'notes' , 'created_by'  , 'created_at')
        ->where('business_id' , $this->id)->get();
        foreach($invoices as $inv){
            if($inv->is_paid == 1) {$inv->is_paid = 'Yes';} else {$inv->is_paid = 'No';}
            if($inv->discount_type == 1) {$inv->discount_type = 'Percentage';} else {$inv->discount_type = 'Amount';}
            $inv->created_by = User::findOrFail($inv->created_by)->name;
        }
        return $invoices;// Invoice::where('business_id' , $id);
    }
}