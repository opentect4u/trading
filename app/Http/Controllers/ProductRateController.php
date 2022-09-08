<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\Models\{MdProductRate,MdProductMaster};

class ProductRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $datas=DB::table('md_product_rate')
            ->leftJoin('md_product_master','md_product_master.id','=','md_product_rate.product_master_id')
            ->select('md_product_rate.*','md_product_master.pdt_name as pdt_name')
            ->where('md_product_rate.society_id',auth()->user()->society_id)
            ->get();
        // $datas=MdProductRate::where('society_id',auth()->user()->society_id)->get();
        return view('master.product_rate_manage',['datas'=>$datas]);
    }

    public function Show()
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        return view('master.product_rate_add_edit',['products'=>$products]);
    }

    public function Create(Request $request)
    {
        // return $request;
        MdProductRate::create(array(
            'society_id'=>auth()->user()->society_id,
            'effective_date'=> date('Y-m-d',strtotime($request->effective_date)),
            'product_master_id'=>$request->product_master_id,
            'rate'=>$request->rate,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('productrateManage')->with('addSuccess','addSuccess');
    }

    public function Edit($id)
    {
        $products=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        $id=Crypt::decryptString($id);
        // return $id;
        $data=MdProductRate::find($id);
        return view('master.product_rate_add_edit',['products'=>$products,'data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdProductRate::find($id);
        $data->effective_date=date('Y-m-d',strtotime($request->effective_date));
        $data->product_master_id=$request->product_master_id;
        $data->rate=$request->rate;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
