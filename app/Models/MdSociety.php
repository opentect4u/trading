<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSociety extends Model
{
    use HasFactory;
    protected $table="md_society";
    protected $fillable = [
        'soc_name',
        'soc_address',
        'created_by',
        'updated_by',
    ];
}
