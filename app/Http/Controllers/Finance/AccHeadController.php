<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\{TdPurchase,MdSupplier,TdPayment,TdBalance,TdMember,MdAccHead};
use Illuminate\Support\Facades\Crypt;

class AccHeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Type $var = null)
    {
        $datas=MdAccHead::get();
        return view('finance.acc_head',['datas'=>$datas]);
    }

    public function Show()
    {
        return view('finance.acc_head_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        MdAccHead::create(array(
            'acc_head' =>$request->acc_head,
            'category'=>$request->category,
            'cash_bank_flag'=>$request->cash_bank_flag,
            'created_by'=>auth()->user()->id,
        ));
        return redirect()->route('accheadManage')->with('success','success');
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        $data=MdAccHead::find($id);
        return view('finance.acc_head_add_edit',['data'=>$data]);
    }

    public function Update(Request $request)
    {
        // return $request;
        $id=Crypt::decryptString($request->id);
        $data=MdAccHead::find($id);
        $data->category=$request->category;
        $data->acc_head=$request->acc_head;
        $data->cash_bank_flag=$request->cash_bank_flag;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');

        // auth()->user()->society_id
        // auth()->user()->id

    }
}
