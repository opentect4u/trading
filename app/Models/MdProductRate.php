<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdProductRate extends Model
{
    use HasFactory;
    protected $table="md_product_rate";
    protected $fillable = [
        'society_id',
        'effective_date',
        'product_master_id',
        'company_rate',
        'buy_rate',
        'rate',
        'created_by',
        'updated_by',
    ];
}
