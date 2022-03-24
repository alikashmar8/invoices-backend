<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'total',
        'extra_amount',
        'discount',
        'reference_number',
        'is_paid',
        'due_date',
        'payment_date',
        'notes',
        'created_by',
        'business_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function items()
    {
        return $this->hasMany('App\Models\InvoiceItem');
    }

}
