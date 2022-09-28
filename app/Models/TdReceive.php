<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdReceive extends Model
{
    use HasFactory;
    protected $table="td_receive";
    protected $fillable = [
        'society_id',
        'received_date',
        'received_type',
        'customer_id',
        'amount',
        'bank',
        'cheque_no',
        'cheque_date',
        'remark',
        'created_by',
        'updated_by',
    ];

}
