<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdMember extends Model
{
    use HasFactory;
    protected $table="td_member";

    public $incrementing = false;
    protected $primaryKey = ['society_id', 'customer_id'];
    
    protected $fillable = [
        'society_id',
        'customer_id',
        'mem_date',
        'mem_name',
        'mem_address',
        'contact_no',
        'mem_email  ',
        'member_type',
        'deposit_amount',
        'aadhar_no',
        'pan_no',
        'voter_id',
        'bank_name',
        'acc_no',
        'ifsc',

        'remark',
        'open_close_flag',
        'date_of_closing',
        'closing_amount',
        'deduction_charge',
        'close_remarks',
        'delete_flag',
        'deleted_date',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}