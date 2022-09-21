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
                // $total_opening_stock=0;
                $opening_stockss=TdPurchase::where('purchase_type','O')
                    ->where('purchase_date',$start_date)
                    ->where('product_master_id',$product_master_id)
                    ->where('society_id',auth()->user()->society_id)
                    ->get();
                // return $opening_stockss;
                $finance_year_opening_stock=0;
                foreach ($opening_stockss as $opening) {
                    $finance_year_opening_stock=$opening->quantity;
                    // $total_opening_stock=$total_opening_stock+$opening->quantity;
                }
                // return $finance_year_opening_stock;

                $all_purchase_stock=TdPurchase::where('product_master_id',$product_master_id)
                    ->where('purchase_type','!=','O')
                    ->where('society_id',auth()->user()->society_id)
                    ->whereDate('purchase_date','>=',date('Y-m-d',strtotime($start_date)))
                    // ->whereDate('purchase_date','>=',date('Y-m-d',strtotime($from_date)))
                    ->whereDate('purchase_date','<=',date('Y-m-d',strtotime($to_date)))
                    ->orderBy('purchase_date','ASC')
                    ->get();
                // return $all_purchase_stock;

                $during_period_purchase=0;
                $before_period_purchase=0;
                foreach ($all_purchase_stock as $one_opening) {
                    if ($one_opening->purchase_date >= date('Y-m-d',strtotime($from_date))) {
                        $during_period_purchase=$during_period_purchase+$one_opening->quantity;
                    }else{
                        $before_period_purchase=$before_period_purchase+$one_opening->quantity;
                    }
                }
                // return $during_period_purchase;
                // return $before_period_purchase;

                $all_saless=TdSale::where('product_master_id',$product_master_id)
                    ->where('society_id',auth()->user()->society_id)
                    ->whereDate('sale_date','>=',date('Y-m-d',strtotime($start_date)))
                    // ->whereDate('sale_date','>=',date('Y-m-d',strtotime($from_date)))
                    ->whereDate('sale_date','<=',date('Y-m-d',strtotime($to_date)))
                    ->orderBy('sale_date','ASC')
                    ->get();

                // return $all_saless;
                
                $during_period_sale=0;
                $before_period_sale=0;
                foreach ($all_saless as $sale) {
                    if ($sale->sale_date >= date('Y-m-d',strtotime($from_date))) {
                        $during_period_sale=$during_period_sale+$sale->quantity;
                    }else{
                        $before_period_sale=$before_period_sale+$sale->quantity;
                    }
                }
                // return $during_period_sale;
                // return $before_period_sale;
                
                $opening_stock= ($finance_year_opening_stock + $before_period_purchase) - $before_period_sale ;
                $total_purchase=$during_period_purchase + $finance_year_opening_stock + $before_period_purchase;
                $total_sale=$before_period_sale + $during_period_sale;
                // return $opening_stock;
                $value->finance_year_opening_stock=$finance_year_opening_stock;
                $value->opening_stock=$opening_stock;
                $value->during_period_purchase=$during_period_purchase;
                $value->during_period_sale=$during_period_sale;
                $value->stock_in_hand= $total_purchase - $total_sale;
                array_push($datas,$value);

            }
        }

        // return $datas;
        return view('report.stock',['datas'=>$datas,'from_date'=>$from_date,
            'to_date'=>$to_date,'finalcial_start_date'=>$start_date
        ]);
    }
}
