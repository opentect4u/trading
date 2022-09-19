<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdMember extends Model
{
    use HasFactory;
    protected $table="td_member";

    public $incrementing = false;
    protected $primaryKey = ['society_id', 'customer_id'];
    
    protected $fillable = [
        'society_id',
        'customer_id',
        'mem_date',
        'mem_name',
        
        'contact_no',
        'mem_email',
        'mem_vill',
        'mem_block',
        'mem_gender',
        'mem_cast',
        'mem_qualification',
        'aadhar_no',
        'pan_no',
        'voter_id',
        'ration_card',
        'nrega_card',
        'whether_member',
        'member_type',
        'mem_share',
        'deposit_amount',
        'classification_of_mem',
        'landholding',

        'seed_cost',
        'manure_fertilizer',
        'whether_soil_health',
        'crop_loan_amt',
        'crop_loan_source',
        'investment_loan',
        'investment_loan_source',
        'crop_insurance',
        'asset_insurance',
        'life_insurance',
        'farm_assets_held',
        'other_assets_held',

        'bank_name',
        'acc_no',
        'ifsc',
        'remark',

        'open_close_flag',
        'date_of_closing',
        'closing_amount',
        'deduction_charge',
        'close_remarks',
        'delete_flag',
        'deleted_date',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}