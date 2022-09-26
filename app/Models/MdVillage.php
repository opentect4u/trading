<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdVillage extends Model
{
    use HasFactory;
    protected $table="md_village";
    protected $primaryKey = 'sl_no';
    protected $fillable = [
        'district_id',
        'block_id',
        'block_name',
        'created_by',
        'updated_by',
    ];
}
