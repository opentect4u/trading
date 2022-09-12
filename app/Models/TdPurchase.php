<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPurchase extends Model
{
    use HasFactory;
    protected $table="td_purchase";
    protected $fillable = [
        'society_id',
        'purchase_date',
        'purchase_type',
        'supplier_id',
        'product_master_id',
        'rate',
        'quantity',
        'amount',
        'created_by',
        'updated_by',
    ];
}