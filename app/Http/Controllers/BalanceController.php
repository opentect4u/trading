<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Models\{TdPurchase,MdSupplier,MdProductMaster,MdProductRate,TdPayment,TdBalance,TdMember,TdReceive};

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $alldata=[];
        if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_payment')
                ->leftJoin('md_supplier','md_supplier.id','=','td_payment.supplier_id')
                // ->leftJoin('md_product_master','md_product_master.id','=','td_payment.product_master_id')
                ->select('td_payment.*','md_supplier.sup_name as sup_name')
                ->where('td_payment.society_id',auth()->user()->society_id)
                ->whereDate('td_payment.payment_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_payment.payment_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else {
            $datas=DB::table('td_payment')
                ->join('md_supplier','md_supplier.id','=','td_payment.supplier_id')
                // ->leftJoin('md_product_master','md_product_master.id','=','td_payment.product_master_id')
                ->select('td_payment.*','md_supplier.sup_name as sup_name')
                ->where('td_payment.society_id',auth()->user()->society_id)
                ->whereDate('td_payment.payment_date',date('Y-m-d'))
                ->get();

            foreach ($datas as $key => $value) {
                $value->trans_type='Payment';
                array_push($alldata,$value);
            }
            $datas1=DB::table('td_payment')
                ->leftJoin('md_supplier','md_supplier.id','=','td_payment.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_payment.customer_id')
                ->select('td_payment.*','md_supplier.sup_name as sup_name','td_member.mem_name as mem_name')
                ->where('td_payment.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_payment.payment_date',date('Y-m-d'))
                ->get();
                
            foreach ($datas1 as $key => $value1) {
                $value1->trans_type='Payment';
                array_push($alldata,$value1);
            }

            $datas2=DB::table('td_receive')
                ->leftJoin('td_member','td_member.customer_id','=','td_receive.customer_id')
                ->select('td_receive.*','td_member.mem_name as mem_name')
                ->where('td_receive.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_receive.received_date',date('Y-m-d'))
                ->get();

            foreach ($datas2 as $key => $value2) {
                $value2->trans_type='Receive';
                $value2->payment_date=$value2->received_date;
                $value2->payment_type=$value2->received_type;
                array_push($alldata,$value2);
            }
        }
        // return $datas2;
        // $datas=TdPurchase::where('society_id',auth()->user()->society_id)->get();
        return view('balance_manage',['datas'=>$alldata,'from_date'=>$from_date,'to_date'=>$to_date]);
    }

    public function Show()
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $members=TdMember::where('society_id',auth()->user()->society_id)
                ->where('delete_flag','N')
                ->get();
        return view('balance_add_edit',['products'=>$products,'suppliers'=>$suppliers,'members'=>$members]);
    }

    public function Create(Request $request)
    {
        // return $request;
        $member_type=$request->member_type;
        if ($member_type=='S') {
            TdPayment::create(array(
                'society_id'=>auth()->user()->society_id,
                'payment_date'=> date('Y-m-d',strtotime($request->payment_date)),
                'payment_type'=>$request->payment_type,
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->amount,
                'bank'=>$request->bank,
                'cheque_no'=>$request->cheque_no,
                'cheque_no'=>$request->cheque_no,
                'remark'=>$request->remark,
                'created_by'=>auth()->user()->id,
            ));

            return redirect()->route('balanceManage')->with('paymentSuccess','paymentSuccess');
        }elseif ($member_type=='M') {
            // return $request;
            $trans_type=$request->trans_type;
            if ($trans_type=='R') {
                TdReceive::create(array(
                    'society_id'=>auth()->user()->society_id,
                    'received_date'=> date('Y-m-d',strtotime($request->payment_date)),
                    'received_type'=>$request->payment_type,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->amount,
                    'bank'=>$request->bank,
                    'cheque_no'=>$request->cheque_no,
                    'cheque_no'=>$request->cheque_no,
                    'remark'=>$request->remark,
                    'created_by'=>auth()->user()->id,
                ));
                return redirect()->route('balanceManage')->with('receivedSuccess','receivedSuccess');
            } else if ($trans_type=='P') {
                // return $request;
                TdPayment::create(array(
                    'society_id'=>auth()->user()->society_id,
                    'payment_date'=> date('Y-m-d',strtotime($request->payment_date)),
                    'payment_type'=>$request->payment_type,
                    // 'supplier_id'=>$request->supplier_id,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->amount,
                    'bank'=>$request->bank,
                    'cheque_no'=>$request->cheque_no,
                    'cheque_no'=>$request->cheque_no,
                    'remark'=>$request->remark,
                    'created_by'=>auth()->user()->id,
                ));
    
                return redirect()->route('balanceManage')->with('paymentSuccess','paymentSuccess');
            } else {
                return redirect()->back()->with('error','error');
            }
        }
        // TdBalance::create(array(
        //     'society_id'=>auth()->user()->society_id,
        //     'bal_date'=> date('Y-m-d',strtotime($request->payment_date)),
        //     'trans_type'=>$request->trans_type,
        //     'payment_type'=>$request->payment_type,
        //     'supplier_id'=>$request->supplier_id,
        //     'customer_id'=>$request->customer_id,
        //     'amount'=> '-'.$request->amount,
        //     'bank'=>$request->bank,
        //     'cheque_no'=>$request->cheque_no,
        //     'cheque_no'=>$request->cheque_no,
        //     'remarks'=>$request->remarks,
        //     'created_by'=>auth()->user()->id,
        // ));
        // return redirect()->route('balanceManage')->with('addSuccess','addSuccess');
    }
}