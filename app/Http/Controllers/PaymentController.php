<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Models\{TdPurchase,MdSupplier,MdProductMaster,MdProductRate,TdPayment};

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
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
                ->leftJoin('md_supplier','md_supplier.id','=','td_payment.supplier_id')
                // ->leftJoin('md_product_master','md_product_master.id','=','td_payment.product_master_id')
                ->select('td_payment.*','md_supplier.sup_name as sup_name')
                ->where('td_payment.society_id',auth()->user()->society_id)
                ->whereDate('td_payment.payment_date',date('Y-m-d'))
                ->get();
        }
        // return $datas;
        // $datas=TdPurchase::where('society_id',auth()->user()->society_id)->get();
        return view('payment_manage',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }

    public function Show()
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        return view('payment_add_edit',['products'=>$products,'suppliers'=>$suppliers]);
    }

    public function Create(Request $request)
    {
        // return $request;
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
        return redirect()->route('paymentManage')->with('addSuccess','addSuccess');
    }

}
