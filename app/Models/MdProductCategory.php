<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdProductCategory extends Model
{
    use HasFactory;
    protected $table="md_product_category";
    protected $fillable = [
        'society_id',
        'cat_name',
        'created_by',
        'updated_by',
    ];
}
