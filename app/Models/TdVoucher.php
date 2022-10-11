<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdVoucher extends Model
{
    use HasFactory;
    protected $table="td_voucher";
    protected $fillable = [
        'society_id',
        'voucher_date',
        'voucher_id',
        'voucher_mode',
        'acc_head_id',
        'dr_cr_flag',
        'amount',
        'ins_no',
        'ins_date',
        'remarks',
        'approval_status',
        'approval_date',
        'approval_by',
        'created_by',
        'updated_by',
    ];
    
}
