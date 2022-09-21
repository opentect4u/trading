<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,MdProductMaster,MdSupplier,TdMember};

class SaleController extends Controller
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
        $product_master_id=$request->product_master_id;
        $datas=[];
        if ($from_date!='' && $to_date!='' && $supplier_id!='' && $product_master_id!='') {
            $datas=DB::table('td_sale')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','td_member.mem_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->where('td_sale.supplier_id',$supplier_id)
                ->where('td_sale.product_master_id',$product_master_id)
                ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else if ($from_date!='' && $to_date!='' && $supplier_id!='') {
            $datas=DB::table('td_sale')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','td_member.mem_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->where('td_sale.supplier_id',$supplier_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else if ($from_date!='' && $to_date!='' && $product_master_id!='') {
            $datas=DB::table('td_sale')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','td_member.mem_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->where('td_sale.product_master_id',$product_master_id)
                ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_sale')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','td_member.mem_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }

        $product_master=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        // $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $suppliers=TdMember::where('delete_flag','N')
            // ->where('member_type','M')
            ->where('society_id',auth()->user()->society_id)
            ->get();
        // return $suppliers;
        return view('report.sale',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date,
            'product_master'=>$product_master,'suppliers'=>$suppliers,
            'supplier_id'=>$supplier_id,'product_master_id'=>$product_master_id
        ]);
    }
}
