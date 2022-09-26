<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSupplier extends Model
{
    use HasFactory;
    protected $table="md_supplier";
    protected $fillable = [
        'society_id',
        'sup_name',
        'sup_address',
        'contact_no',
        'sup_email',
        'aadhar_no',
        'pan_no',
        'bank_name',
        'acc_no',
        'ifsc',
        'remarks',
        'deleted_flag',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}
