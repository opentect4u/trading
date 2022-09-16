<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TdMember;
use Illuminate\Support\Facades\Crypt;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        // return "hii";
        $member_type=$request->member_type;
        if ($member_type!='') {
            $datas=TdMember::where('society_id',auth()->user()->society_id)
                ->where('delete_flag','N')
                ->where('open_close_flag',$member_type)
                // ->orderBy('customer_id','desc')
                ->get();
        }else{
            $datas=TdMember::where('society_id',auth()->user()->society_id)
                ->where('delete_flag','N')
                ->where('open_close_flag','A')
                // ->orderBy('customer_id','desc')
                ->get();

            $member_type='A';
        }
        // return $datas;
        return view('member',['datas'=>$datas ,'member_type'=>$member_type]);
    }

    public function Show(Type $var = null)
    {
        return view('member_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        // return auth()->user()->society_id;
        $count=TdMember::where('society_id',auth()->user()->society_id)->count();
        if ($count>0) {
            // return $count;
            $customer_id =($count + 1);
            // return $customer_id;
        }else{
            $customer_id =1;
        }
        if ($request->member_type=='M') {
            $open_close_flag='A';
        }else {
            $open_close_flag='N';
        }
        TdMember::create(array(
            'society_id' =>auth()->user()->society_id,
            'customer_id'=>$customer_id,
            'mem_date'=>date('Y-m-d'),
            'mem_name'=>$request->mem_name,
            'mem_address'=>$request->mem_address,
            'contact_no'=>$request->contact_no,
            'mem_email'=>$request->mem_email,
            'member_type'=>$request->member_type,
            'deposit_amount'=>$request->deposit_amount,

            'aadhar_no'=>$request->aadhar_no,
            'pan_no'=>$request->pan_no,
            'voter_id'=>$request->pan_no,
            'bank_name'=>$request->bank_name,
            'acc_no'=>$request->acc_no,
            'ifsc'=>$request->ifsc,

            'remark'=>$request->remark,
            'open_close_flag'=>$open_close_flag,
            'delete_flag'=>'N',
            'created_by'=>auth()->user()->id,
            // 'updated_by',
        ));
        return redirect()->route('memberManage');
    }

    public function View($society_id,$customer_id)
    {
        $society_id=Crypt::decryptString($society_id);
        $customer_id=Crypt::decryptString($customer_id);
        // return $customer_id;
        // $data=TdMember::find($society_id);
        $data=TdMember::where('society_id',$society_id)->where('customer_id',$customer_id)->get();
        // return $data[0];
        return view('member_view',['data'=>$data[0]]);
    }

    public function Edit($society_id,$customer_id)
    {
        $society_id=Crypt::decryptString($society_id);
        $customer_id=Crypt::decryptString($customer_id);
        // return $customer_id;
        // $data=TdMember::find($society_id);
        $data=TdMember::where('society_id',$society_id)->where('customer_id',$customer_id)->get();
        // return $data[0];
        return view('member_add_edit',['data'=>$data[0]]);
    }

    public function ShowClose($society_id,$customer_id)
    {
        $society_id=Crypt::decryptString($society_id);
        $customer_id=Crypt::decryptString($customer_id);
        // return $customer_id;
        // $data=TdMember::find($society_id);
        $data=TdMember::where('society_id',$society_id)->where('customer_id',$customer_id)->get();
        return view('member_close',['data'=>$data[0]]);
    }

    public function Update(Request $request)
    {
        // return $request;
        // $id=Crypt::decryptString($request->id);
        // return $id;
        $data=TdMember::where('society_id', auth()->user()->society_id)
        ->where('customer_id', $request->customer_id)
        ->update([
            'aadhar_no' => $request->aadhar_no,
            'pan_no' => $request->pan_no,
            'voter_id' => $request->voter_id,
            'bank_name' => $request->bank_name,
            'acc_no' => $request->acc_no,
            'ifsc' => $request->ifsc,
            'updated_by'=>auth()->user()->id,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]); 
        return redirect()->back()->with('update','update');
    }

    public function Close(Request $request)
    {
        // return $request;
        $society_id=Crypt::decryptString($request->society_id);
        $data=TdMember::where('society_id', $society_id)
        ->where('customer_id', $request->customer_id)
        ->update([
            'open_close_flag' => 'C',
            'date_of_closing'=>date('Y-m-d'),
            'closing_amount' => $request->closing_amount,
            'deduction_charge' => $request->deduction_charge,
            'close_remarks' => $request->close_remarks,
            'updated_by'=>auth()->user()->id,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]); 
        return redirect()->route('memberManage')->with('close_member','close_member');
    }

    public function Delete(Request $request)
    {
        $society_id=Crypt::decryptString($request->society_id);
        $customer_id=Crypt::decryptString($request->customer_id);
        $data=TdMember::where('society_id', $society_id)
        ->where('customer_id', $customer_id)
        ->update([
            'delete_flag' => 'Y',
            'deleted_date'=>date('Y-m-d H:i:s'),
            'deleted_by'=>auth()->user()->id,
            // 'updated_at'=>date('Y-m-d H:i:s'),
        ]); 

        $jsondata=[];
        $jsondata['society_id']=$society_id;
        $jsondata['customer_id']=$customer_id;
        $jsondata['success']='Success';
        echo json_encode($jsondata);
    }
}
