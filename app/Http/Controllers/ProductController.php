<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\{MdProductMaster,MdProductCategory};
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $datas=DB::table('md_product_master')
            ->leftJoin('md_product_category','md_product_category.id','=','md_product_master.product_category_id')
            ->select('md_product_master.*','md_product_category.cat_name as cat_name')
            ->where('md_product_master.society_id',auth()->user()->society_id)
            ->get();
        // $datas=MdProductMaster::where('society_id',auth()->user()->society_id)->get();
        return view('master.product_manage',['datas'=>$datas]);
    }

    public function Show()
    {
        $categories=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        return view('master.product_add_edit',['categories'=>$categories]);
    }

    public function Create(Request $request)
    {
        // return $request;
        MdProductMaster::create(array(
            'society_id'=>auth()->user()->society_id,
            'product_category_id'=>$request->product_category_id,
            'pdt_name'=>$request->pdt_name,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('productManage')->with('addSuccess','addSuccess');
    }

    public function Edit($id)
    {
        $categories=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        $id=Crypt::decryptString($id);
        // return $id;
        $data=MdProductMaster::find($id);
        return view('master.product_add_edit',['categories'=>$categories,'data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdProductMaster::find($id);
        $data->product_category_id=$request->product_category_id;
        $data->pdt_name=$request->pdt_name;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
