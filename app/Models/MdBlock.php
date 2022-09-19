<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdBlock extends Model
{
    use HasFactory;
    protected $table="md_block";
    protected $primaryKey = 'sl_no';
    protected $fillable = [
        'block_name',
        'created_by',
        'updated_by',
    ];
}
