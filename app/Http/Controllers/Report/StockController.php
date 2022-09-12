<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,MdProductMaster};

class StockController extends Controller
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
        $start_date=Helper::getFinancialStartDate();

        if ($from_date!='' && $to_date!='') {
            $data=DB::table('md_product_master')
                ->leftJoin('md_product_category','md_product_category.id','=','md_product_master.product_category_id')
                ->select('md_product_master.*','md_product_category.cat_name as cat_name')
                ->where('md_product_category.society_id',auth()->user()->society_id)
                ->where('md_product_master.society_id',auth()->user()->society_id)
                ->get();
            // $data=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
            // return $data;
            foreach ($data as $key => $value) {
                // return $value;
                $product_master_id=$value->id;
                $total_stock=0;
                $opening_stockss=TdPurchase::where('purchase_type','O')
                    ->where('purchase_date',$start_date)
                    ->where('product_master_id',$product_master_id)
                    ->where('society_id',auth()->user()->society_id)
                    ->get();
                // return $opening_stock;
                $opening_stock=0;
                foreach ($opening_stockss as $opening) {
                    $opening_stock=$opening->quantity;
                    $total_stock=$total_stock+$opening->quantity;
                }
                $one_opening_stock=TdPurchase::where('product_master_id',$product_master_id)
                    ->where('purchase_type','!=','O')
                    ->where('society_id',auth()->user()->society_id)
                    ->whereDate('purchase_date','>=',date('Y-m-d',strtotime($from_date)))
                    ->whereDate('purchase_date','<=',date('Y-m-d',strtotime($to_date)))
                    ->get();
                // return $one_opening_stock;
                $total_purchase=0;
                foreach ($one_opening_stock as $one_opening) {
                    $total_purchase=$total_purchase+$one_opening->quantity;
                    $total_stock=$total_stock+$one_opening->quantity;
                }

                $saless=TdSale::where('product_master_id',$product_master_id)
                    ->where('society_id',auth()->user()->society_id)
                    ->whereDate('sale_date','>=',date('Y-m-d',strtotime($from_date)))
                    ->whereDate('sale_date','<=',date('Y-m-d',strtotime($to_date)))
                    ->get();
                
                $total_sale=0;
                foreach ($saless as $sale) {
                    $total_sale=$total_sale+$sale->quantity;
                }
                $value->opening_stock=$opening_stock;
                $value->total_stock=$total_stock;
                $value->total_purchase=$total_purchase;
                $value->total_sale=$total_sale;
                $value->stock_in_hand= $total_stock - $total_sale;
                array_push($datas,$value);

            }
        }

        // return $datas;
        return view('report.stock',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }
}
