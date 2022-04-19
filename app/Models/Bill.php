<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'title',
        'total',
        'is_paid',
        'payment_date',
        'due_date',
        'notes',
        'contact_id',
        'created_by',
        'business_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'bills', 'length' => 13, 'prefix' => 'BIL-' . date('ym')]);
        });
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

}
