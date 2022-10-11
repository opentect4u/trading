<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\{TdPurchase,MdSupplier,TdPayment,TdBalance,TdMember,MdAccHead,TdVoucher};
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Helper;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Type $var = null)
    {
        // $datas=TdVoucher::where('society_id',auth()->user()->society_id)->get();
        $datas=DB::table('td_voucher')
            ->leftJoin('md_acc_head','md_acc_head.id','=','td_voucher.acc_head_id')
            ->select('td_voucher.*','md_acc_head.acc_head as acc_head')
            ->where('society_id',auth()->user()->society_id)
            ->get();
        return view('finance.voucher',['datas'=>$datas]);
    }

    public function Show()
    {
        $acc_heads=MdAccHead::get();
        return view('finance.voucher_add_edit',['acc_heads'=>$acc_heads]);
    }

    public function Create(Request $request)
    {
        // return $request;
        $finalcial_date=Helper::getFinancialStartDate();
        // return $finalcial_date;
        $is_voucher=TdVoucher::whereDate('voucher_date','>=',date('Y-m-d',strtotime($finalcial_date)))
            ->whereDate('voucher_date','<=',date('Y-m-d'))
            ->get();
        // return $is_voucher;
        if (count($is_voucher)>0) {
            $voucher_id=date('Y').(count($is_voucher)+1);
        }else{
            $voucher_id=date('Y')."1";
        }
        // return $voucher_id;
        TdVoucher::create(array(
            'society_id'=>auth()->user()->society_id,
            'voucher_date'=> date('Y-m-d',strtotime($request->voucher_date)),
            'voucher_id'=>$voucher_id,
            'voucher_mode'=>$request->voucher_mode,
            'acc_head_id'=>$request->acc_head_id,
            'dr_cr_flag'=>$request->dr_cr_flag,
            'amount'=>$request->amount,
            'ins_no'=>$request->ins_no,
            'ins_date'=>$request->ins_date,
            'remarks'=>$request->remarks,
            // 'approval_status',
            // 'approval_date',
            // 'approval_by',
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('voucherManage')->with('success','success');
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        $data=TdVoucher::find($id);
        $acc_heads=MdAccHead::get();
        return view('finance.voucher_add_edit',['data'=>$data,'acc_heads'=>$acc_heads]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=TdVoucher::find($id);
        $data->category=$request->category;
        $data->voucher=$request->voucher;
        $data->cash_bank_flag=$request->cash_bank_flag;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');

        // auth()->user()->society_id
        // auth()->user()->id

    }

}
