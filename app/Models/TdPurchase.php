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
        'customer_id',
        'product_category_id',
        'product_master_id',
        'rate',
        'quantity',
        'discount',
        'amount',
        'remark',
        'created_by',
        'updated_by',
    ];
}
