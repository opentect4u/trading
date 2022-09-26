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
        $datas=MdSupplier::where('society_id',auth()->user()->society_id)->where('deleted_flag','N')->get();
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
            'sup_address'=>$request->sup_address,
            'contact_no'=>$request->contact_no,
            'sup_email'=>$request->sup_email,
            'aadhar_no'=>$request->aadhar_no,
            'pan_no'=>$request->pan_no,
            'bank_name'=>$request->bank_name,
            'acc_no'=>$request->acc_no,
            'ifsc'=>$request->ifsc,
            'remarks'=>$request->remarks,
            'deleted_flag'=>'N',
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
        $data->sup_address=$request->sup_address;
        $data->contact_no=$request->contact_no;
        $data->sup_email=$request->sup_email;
        $data->aadhar_no=$request->aadhar_no;
        $data->pan_no=$request->pan_no;
        $data->bank_name=$request->bank_name;
        $data->acc_no=$request->acc_no;
        $data->ifsc=$request->ifsc;
        $data->remarks=$request->remarks;
        $data->updated_by=auth()->user()->id;
        $data->save();
        return redirect()->back()->with('update','update');
    }

    public function Delete(Request $request)
    {
        // $society_id=Crypt::decryptString($request->society_id);
        // $customer_id=Crypt::decryptString($request->customer_id);
        // $data=TdMember::where('society_id', $society_id)
        // ->where('customer_id', $customer_id)
        // ->update([
        //     'delete_flag' => 'Y',
        //     'deleted_date'=>date('Y-m-d H:i:s'),
        //     'deleted_by'=>auth()->user()->id,
        //     // 'updated_at'=>date('Y-m-d H:i:s'),
        // ]);
        $id=Crypt::decryptString($request->id);
        $data=MdSupplier::find($id); 
        $data->deleted_flag='Y';
        $data->deleted_at=date('Y-m-d H:i:s');
        $data->deleted_by=auth()->user()->id;
        $data->save();

        $jsondata=[];
        $jsondata['id']=$id;
        // $jsondata['customer_id']=$customer_id;
        $jsondata['success']='Success';
        echo json_encode($jsondata);
    }
}
