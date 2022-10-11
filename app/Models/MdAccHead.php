<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdAccHead extends Model
{
    use HasFactory;
    protected $table="md_acc_head";
    // protected $primaryKey = 'sl_no';
    protected $fillable = [
        'acc_head',
        'category',
        'cash_bank_flag',
        'created_by',
        'updated_by',
    ];
}
