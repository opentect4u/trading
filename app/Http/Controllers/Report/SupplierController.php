<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,TdReceive,TdPayment,MdProductMaster,MdSupplier,TdMember};

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $supplier_id=$request->supplier_id;
        $datas=[];
        // $datas=collect();

        $td_sale=DB::table('td_sale')
            ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
            ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
            ->select('td_sale.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
            ->where('td_sale.society_id',auth()->user()->society_id)
            ->where('td_sale.supplier_id',$supplier_id)
            ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
            ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
            ->get();
        
        foreach ($td_sale as $key => $sale) {
            $sale->sort_date=$sale->sale_date;
            array_push($datas,$sale);
        }
        $td_receive=DB::table('td_receive')
            ->leftJoin('md_supplier','md_supplier.id','=','td_receive.supplier_id')
            ->select('td_receive.*','md_supplier.sup_name as sup_name')
            ->where('td_receive.society_id',auth()->user()->society_id)
            ->where('td_receive.supplier_id',$supplier_id)
            ->whereDate('td_receive.received_date','>=',date('Y-m-d',strtotime($from_date)))
            ->whereDate('td_receive.received_date','<=',date('Y-m-d',strtotime($to_date)))
            ->get();
        
        foreach ($td_receive as $key => $receive) {
            $receive->sort_date=$receive->received_date;
            array_push($datas,$receive);
        }
        $td_purchase=DB::table('td_purchase')
            ->leftJoin('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
            ->leftJoin('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
            ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
            ->where('td_purchase.society_id',auth()->user()->society_id)
            ->where('td_purchase.supplier_id',$supplier_id)
            ->whereDate('td_purchase.purchase_date','>=',date('Y-m-d',strtotime($from_date)))
            ->whereDate('td_purchase.purchase_date','<=',date('Y-m-d',strtotime($to_date)))
            ->get();

        foreach ($td_purchase as $key => $purchase) {
            $purchase->sort_date=$purchase->purchase_date;
            array_push($datas,$purchase);
        }
        $td_payment=DB::table('td_payment')
            ->leftJoin('md_supplier','md_supplier.id','=','td_payment.supplier_id')
            ->select('td_payment.*','md_supplier.sup_name as sup_name')
            ->where('td_payment.society_id',auth()->user()->society_id)
            ->where('td_payment.supplier_id',$supplier_id)
            ->whereDate('td_payment.payment_date','>=',date('Y-m-d',strtotime($from_date)))
            ->whereDate('td_payment.payment_date','<=',date('Y-m-d',strtotime($to_date)))
            ->get();
        
        foreach ($td_payment as $key => $payment) {
            $payment->sort_date=$payment->payment_date;
            array_push($datas,$payment);
        }
        // return $td_sale;
        // $datas = collect($datas)->sortBy('date')->toArray();
        // usort($datas, function($a, $b){
        //     return $a['date'] <=> $b['date'];
        //     // return $a['date'] - $b['date'];

        // });
        // $datas = collect($datas)->sortBy('sort_date')->toArray();
        // $datas = collect($datas)->sortByDesc('sort_date')->toArray();
        // array_multisort($datas, SORT_ASC, $datas);
        // arsort($datas)
        // return $datas;
        // $datas=[];
        $supplier_details=MdSupplier::where('society_id',auth()->user()->society_id)
            ->where('id',$supplier_id)
            ->get();
        // return $supplier_details;
        // $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $suppliers=TdMember::where('delete_flag','N')->where('society_id',auth()->user()->society_id)->get();

        return view('report.supplier_pur_sale',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date,
            'supplier_id'=>$supplier_id,'suppliers'=>$suppliers,
            'supplier_details'=>$supplier_details
        ]);
    }

}
