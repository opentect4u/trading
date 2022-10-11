<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdSale extends Model
{
    use HasFactory;
    protected $table="td_sale";
    protected $fillable = [
        'society_id',
        'sale_date',
        'sale_type',
        'supplier_id',
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
