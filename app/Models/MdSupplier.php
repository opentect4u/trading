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
        'created_by',
        'updated_by',
    ];
}
