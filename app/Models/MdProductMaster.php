<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdProductMaster extends Model
{
    use HasFactory;
    protected $table="md_product_master";
    protected $fillable = [
        'society_id',
        'product_category_id',
        'pdt_name',
        'created_by',
        'updated_by',
    ];
}
