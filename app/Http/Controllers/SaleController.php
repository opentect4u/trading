<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdSale,MdSupplier,MdProductMaster,MdProductRate,TdMember,MdProductCategory};

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
        if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_sale')
                ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->whereDate('td_sale.sale_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_sale.sale_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else {
            $datas=DB::table('td_sale')
                ->leftJoin('md_supplier','md_supplier.id','=','td_sale.supplier_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_sale.product_master_id')
                ->select('td_sale.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_sale.society_id',auth()->user()->society_id)
                ->whereDate('td_sale.sale_date',date('Y-m-d'))
                ->get();
        }
        // return $datas;
        // $datas=TdPurchase::where('society_id',auth()->user()->society_id)->get();
        return view('sale_manage',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }

    public function Show()
    {
        // $start_date= Helper::getFinancialStartDate();
        // // return Helper::getFinancialEndDate();
        // $product_master_id=1;
        // return Helper::stockProduct($product_master_id,$start_date);

        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $ProductCategory=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        // $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $suppliers=TdMember::where('delete_flag','N')->where('society_id',auth()->user()->society_id)->get();
        return view('sale_add_edit',['products'=>$products,'suppliers'=>$suppliers,'ProductCategory'=>$ProductCategory]);
    }

    public function Create(Request $request)
    {
        // return $request;
        $start_date= Helper::getFinancialStartDate();
        $product_master_id=$request->product_master_id;
        $stock=Helper::stockProduct($product_master_id,$start_date);
        if ($request->quantity==0 || $stock < $request->quantity) {
            return redirect()->back()->with('error','error');
        }
        // return $request;
        TdSale::create(array(
            'society_id'=>auth()->user()->society_id,
            'sale_date'=> date('Y-m-d',strtotime($request->sale_date)),
            'sale_type'=>$request->sale_type,
            'supplier_id'=>$request->supplier_id,
            'product_master_id'=>$request->product_master_id,
            'rate'=>$request->rate,
            'quantity'=>$request->quantity,
            'amount'=>$request->amount,
            'remark'=>$request->remark,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('saleManage')->with('addSuccess','addSuccess');
    }

    public function SaleStockProductAjax(Request $request)
    {

        $start_date= Helper::getFinancialStartDate();
        // return Helper::getFinancialEndDate();
        $product_master_id=$request->product_master_id;
        $stock=Helper::stockProduct($product_master_id,$start_date);

        $json_data=[];
        $json_data['stock']=$stock;
        $json_data['product_master_id']=$product_master_id;
        echo json_encode($json_data);
    }

    public function ProductNameAjax(Request $request)
    {
        $product_category_id=$request->product_category_id;
        $products=MdProductMaster::where('product_category_id',$product_category_id)->where('society_id',auth()->user()->society_id)->get();
        return view('product_name_ajax',['products'=>$products]);
    }
}
