<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Models\{TdPurchase,MdSupplier,MdProductMaster,MdProductRate,MdProductCategory,TdMember};

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        // return $request;
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $all_datas=[];
        if ($from_date!='' && $to_date!='') {
            // $datas=DB::table('td_purchase')
            //     ->join('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
            //     ->join('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
            //     ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
            //     ->where('td_purchase.society_id',auth()->user()->society_id)
            //     ->whereDate('td_purchase.purchase_date','>=',date('Y-m-d',strtotime($from_date)))
            //     ->whereDate('td_purchase.purchase_date','<=',date('Y-m-d',strtotime($to_date)))
            //     ->get();
            $datas=DB::table('td_purchase')
                ->join('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
                // ->leftJoin('td_member','td_member.customer_id','=','td_purchase.customer_id')
                ->join('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
                ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_purchase.society_id',auth()->user()->society_id)
                // ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_purchase.purchase_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_purchase.purchase_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
            foreach ($datas as $key => $value) {
                array_push($all_datas,$value);
            }
            $datas1=DB::table('td_purchase')
                ->leftJoin('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_purchase.customer_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
                ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name','td_member.mem_name as mem_name')
                ->where('td_purchase.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                // ->whereDate('td_purchase.purchase_date',date('Y-m-d'))
                ->whereDate('td_purchase.purchase_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_purchase.purchase_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();

            foreach ($datas1 as $key => $value1) {
                array_push($all_datas,$value1);
            }
        }else {
            $datas=DB::table('td_purchase')
                ->join('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
                // ->leftJoin('td_member','td_member.customer_id','=','td_purchase.customer_id')
                ->join('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
                ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name')
                ->where('td_purchase.society_id',auth()->user()->society_id)
                // ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_purchase.purchase_date',date('Y-m-d'))
                ->get();
            foreach ($datas as $key => $value) {
                array_push($all_datas,$value);
            }
            $datas1=DB::table('td_purchase')
                ->leftJoin('md_supplier','md_supplier.id','=','td_purchase.supplier_id')
                ->leftJoin('td_member','td_member.customer_id','=','td_purchase.customer_id')
                ->leftJoin('md_product_master','md_product_master.id','=','td_purchase.product_master_id')
                ->select('td_purchase.*','md_supplier.sup_name as sup_name','md_product_master.pdt_name as pdt_name','td_member.mem_name as mem_name')
                ->where('td_purchase.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_purchase.purchase_date',date('Y-m-d'))
                ->get();

            foreach ($datas1 as $key => $value1) {
                array_push($all_datas,$value1);
            }
        }
        // return $datas;
        // $datas=TdPurchase::where('society_id',auth()->user()->society_id)->get();
        return view('purchase_manage',['datas'=>$all_datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }

    public function Show()
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $ProductCategory=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $members=TdMember::where('society_id',auth()->user()->society_id)
                ->where('delete_flag','N')
                ->get();

        return view('purchase_add_edit',['products'=>$products,'suppliers'=>$suppliers,
            'ProductCategory'=>$ProductCategory,'members'=>$members
        ]);
    }

    public function Create(Request $request)
    {
        // return $request;
        TdPurchase::create(array(
            'society_id'=>auth()->user()->society_id,
            'purchase_date'=> date('Y-m-d',strtotime($request->purchase_date)),
            // 'purchase_type'=>$request->purchase_type,
            'supplier_id'=>$request->supplier_id,
            'customer_id'=>$request->customer_id,
            'product_category_id'=>$request->product_category_id,
            'product_master_id'=>$request->product_master_id,
            'rate'=>$request->rate,
            'quantity'=>$request->quantity,
            'discount'=>$request->discount,
            'amount'=>$request->amount,
            'remark'=>$request->remark,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('purchaseManage')->with('addSuccess','addSuccess');
    }

    public function Edit($id)
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $ProductCategory=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $members=TdMember::where('society_id',auth()->user()->society_id)
        ->where('delete_flag','N')
        ->get();
        $id=Crypt::decryptString($id);
        // return $id;
        $data=TdPurchase::find($id);
        return view('purchase_add_edit',['products'=>$products,'suppliers'=>$suppliers,
            'data'=>$data,'ProductCategory'=>$ProductCategory,'members'=>$members
        ]);
    }

    // public function Update(Request $request)
    // {
    //     // return $request;
    //     $id=Crypt::decryptString($request->id);
    //     $data=TdPurchase::find($id);
    //     $data->purchase_date=date('Y-m-d',strtotime($request->purchase_date));
    //     $data->purchase_type=$request->purchase_type;
    //     $data->supplier_id=$request->supplier_id;
    //     $data->product_category_id=$request->product_category_id;
    //     $data->product_master_id=$request->product_master_id;
    //     $data->rate=$request->rate;
    //     $data->quantity=$request->quantity;
    //     $data->amount=$request->amount;
    //     $data->updated_by=auth()->user()->id;
    //     $data->save();
    //     return redirect()->back()->with('update','update');
    // }

    public function RateAjax(Request $request)
    {
        $product_master_id=$request->product_master_id;
        // $product_master_id=1;
        $rate=MdProductRate::where('society_id',auth()->user()->society_id)
            ->where('product_master_id',$product_master_id)
            ->orderBy('effective_date','desc')
            ->first();
        // return $rate;
        $json_data=[];
        $json_data['rate']=isset($rate->rate)?$rate->rate:0;
        $json_data['product_master_id']=isset($rate->product_master_id)?$rate->product_master_id:'';
        echo json_encode($json_data);
    }

    public function DeleteAjax(Request $request)
    {
        $id=$request->customer_id;
        $table_name=$request->table_name;
        // $product_master_id=1;
        // $rate=MdProductRate::where('society_id',auth()->user()->society_id)
        //     ->where('product_master_id',$product_master_id)
        //     ->orderBy('effective_date','desc')
        //     ->first();

        $data=DB::table($table_name)->where('id',$id)->delete();
        // return $rate;
        $json_data=[];
        $json_data['id']=$id;
        $json_data['table_name']=$table_name;
        echo json_encode($json_data);
    }
}