<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\{TdPurchase,MdSupplier,TdPayment,TdBalance,TdMember,MdAccHead,TdVoucher};
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Helper;

class BankVoucherController extends Controller
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
            ->where('td_voucher.society_id',auth()->user()->society_id)
            ->where('td_voucher.voucher_mode','B')
            ->groupBy('td_voucher.voucher_id')
            ->get();
        return view('finance.bank_voucher',['datas'=>$datas]);
    }

    public function Show()
    {
        $acc_heads=MdAccHead::get();
        return view('finance.bank_voucher_add_edit',['acc_heads'=>$acc_heads]);
    }

    public function Create(Request $request)
    {
        // return $request;
        $finalcial_date=Helper::getFinancialStartDate();
        // return $finalcial_date;
        $is_voucher=TdVoucher::whereDate('voucher_date','>=',date('Y-m-d',strtotime($finalcial_date)))
            ->whereDate('voucher_date','<=',date('Y-m-d'))
            ->groupby('voucher_id')
            ->orderBy('voucher_id','DESC')
            ->get();
        // return $is_voucher;
        if (count($is_voucher)>0) {
            $voucher_id=$is_voucher[0]['voucher_id'];
            // return $voucher_id;
            $only_year=date('Y',strtotime($finalcial_date));
            // return $only_year;
            $latest_no=str_replace($only_year,"",$voucher_id);
            $voucher_id=date('Y',strtotime($finalcial_date)).($latest_no+1);
        }else{
            $voucher_id=date('Y')."1";
        }

        $voucher_mode='B';
        $dr_cr_flag ='D';
        // $acc_head_id=$request->acc_head_id;
        $acc_head_id=1;

        $totamount=0;
        for ($i=0; $i < count($request->amount); $i++) { 
            $totamount=$totamount+$request->amount[$i];
        }
        // return $request;
        // return $totamount;
        TdVoucher::create(array(
            'society_id'=>auth()->user()->society_id,
            'voucher_date'=> date('Y-m-d',strtotime($request->voucher_date)),
            'voucher_id'=>$voucher_id,
            'voucher_mode'=>$voucher_mode,
            'acc_head_id'=>$acc_head_id,
            'dr_cr_flag'=>$dr_cr_flag,
            'amount'=>$totamount,
            // 'ins_no'=>$request->ins_no,
            // 'ins_date'=>$request->ins_date,
            'remarks'=>$request->remarks,
            // 'approval_status',
            // 'approval_date',
            // 'approval_by',
            'created_by'=>auth()->user()->id,
        ));
        $voucher_mode1='B';
        $dr_cr_flag1 ='C';
        for ($j=0; $j <count($request->cash_acc_head_id) ; $j++) { 
            TdVoucher::create(array(
                'society_id'=>auth()->user()->society_id,
                'voucher_date'=> date('Y-m-d',strtotime($request->voucher_date)),
                'voucher_id'=>$voucher_id,
                'voucher_mode'=>$voucher_mode1,
                'acc_head_id'=>$request->cash_acc_head_id[$j],
                'dr_cr_flag'=>$dr_cr_flag1,
                'amount'=>$request->amount[$j],
                // 'remarks'=>$request->remarks,
                'created_by'=>auth()->user()->id,
            ));
        }
        return redirect()->route('bankvoucherManage')->with('success','success');
    }

    public function Edit($voucher_id,$society_id)
    {
        $voucher_id=Crypt::decryptString($voucher_id);
        $society_id=Crypt::decryptString($society_id);
        // return $society_id;
        $data=TdVoucher::where('voucher_id',$voucher_id)->where('society_id',$society_id)->get();
        // return $data[0]['dr_cr_flag'];
        // if ($data[0]['dr_cr_flag']=='D') {
        //     $data1=TdVoucher::where('voucher_id',$voucher_id)->where('society_id',$society_id)->where('society_id',$society_id)->get();
        // }else{

        // }
        $acc_heads=MdAccHead::get();
        return view('finance.bank_voucher_add_edit',['data'=>$data,'acc_heads'=>$acc_heads]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $voucher_id=Crypt::decryptString($request->voucher_id);
        // return $voucher_id;

        $totamount=0;
        for ($i=0; $i < count($request->amount); $i++) { 
            $totamount=$totamount+$request->amount[$i];
        }
        // return $totamount;
        TdVoucher::where('society_id',auth()->user()->society_id)
            ->where('voucher_id',$voucher_id)
            ->where('acc_head_id',$request->acc_head_id)
            ->where('dr_cr_flag',$request->dr_cr_flag_1)
            ->update([
                'amount'=>$totamount,
                'updated_by'=>auth()->user()->id,
            ]);

        for ($i=0; $i < count($request->edit_dr_cr_flag); $i++) { 
            TdVoucher::where('society_id',auth()->user()->society_id)
                ->where('voucher_id',$voucher_id)
                ->where('acc_head_id',$request->acc_code[$i])
                ->where('dr_cr_flag',$request->edit_dr_cr_flag[$i])
                ->update([
                    'amount'=>$request->amount[$i],
                    'updated_by'=>auth()->user()->id,
                ]);
        }
        return redirect()->back()->with('update','update');

        // auth()->user()->society_id
        // auth()->user()->id

    }
}