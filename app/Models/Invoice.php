<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class Invoice extends Model
{
    use HasFactory;

    public $incrementing = false;

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

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'invoices', 'length' => 13, 'prefix' => 'INV-' . date('ym')]);
        });
    }

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

    public function attachments()
    {
        return $this->hasMany('App\Models\InvoiceAttachment');
    }
}
