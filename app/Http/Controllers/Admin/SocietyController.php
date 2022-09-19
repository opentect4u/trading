<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{MdSociety};
use Illuminate\Support\Facades\Crypt;

class SocietyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function Index()
    {
        $societies=MdSociety::get();
        return view('admin.society_manage',['societies'=>$societies]);
    }

    public function Show()
    {
        return view('admin.society_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        MdSociety::create(array(
            'soc_name'=>$request->soc_name,
            'soc_address'=>$request->soc_address,
            // 'created_by'=>auth()->guard()->user()->id,
        ));
        return redirect()->route('admin.SocietyManage')->with('success','success');
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        // return $id;
        $data=MdSociety::find($id);
        return view('admin.society_add_edit',['data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdSociety::find($id);
        $data->soc_name=$request->soc_name;
        $data->soc_address=$request->soc_address;
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
