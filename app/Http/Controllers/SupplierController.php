<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdSupplier;
use Illuminate\Support\Facades\Crypt;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $datas=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        return view('master.supplier_manage',['datas'=>$datas]);
    }

    public function Show()
    {
        return view('master.supplier_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        MdSupplier::create(array(
            'society_id'=>auth()->user()->society_id,
            'sup_name'=>$request->sup_name,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('supplierManage')->with('addSuccess','addSuccess');
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        // return $id;
        $data=MdSupplier::find($id);
        return view('master.supplier_add_edit',['data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdSupplier::find($id);
        $data->sup_name=$request->sup_name;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
