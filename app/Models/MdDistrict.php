<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdDistrict extends Model
{
    use HasFactory;
    protected $table="md_district";
    protected $primaryKey = 'sl_no';
    protected $fillable = [
        'dist_name',
        'created_by',
        'updated_by',
    ];
}
