<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPayment extends Model
{
    use HasFactory;
    protected $table="td_payment";
    protected $fillable = [
        'society_id',
        'payment_date',
        'payment_type',
        'supplier_id',
        'amount',
        'bank',
        'cheque_no',
        'cheque_date',
        'created_by',
        'updated_by',
    ];
}
