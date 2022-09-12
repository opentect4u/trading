<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,MdProductMaster};

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $datas=[];
        if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_purchase')
                ->leftJoin('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
                ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_purchase.society_id',auth()->user()->society_id)
                ->whereDate('td_purchase.purchase_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_purchase.purchase_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }
        // $data=TdPurchase::where('society_id',auth()->user()->society_id)->get();
        // return $data;
        return view('report.purchase',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }
}
