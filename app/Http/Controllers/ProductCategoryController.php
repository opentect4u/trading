<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\MdProductCategory;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $datas=MdProductCategory::where('society_id',auth()->user()->society_id)->get();
        return view('master.category_manage',['datas'=>$datas]);
    }

    public function Show()
    {
        return view('master.category_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        MdProductCategory::create(array(
            'society_id'=>auth()->user()->society_id,
            'cat_name'=>$request->cat_name,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('categoryManage')->with('addSuccess','addSuccess');
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        // return $id;
        $data=MdProductCategory::find($id);
        return view('master.category_add_edit',['data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdProductCategory::find($id);
        $data->cat_name=$request->cat_name;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
