<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,MdProductMaster,MdSupplier,TdMember};

class ReceiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $supplier_id=$request->supplier_id;
        $datas=[];
        if ($from_date!='' && $to_date!='' && $supplier_id!='') {
            $datas=DB::table('td_receive')
                ->leftJoin('td_member','td_member.customer_id','=','td_receive.customer_id')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_receive.supplier_id')
                ->select('td_receive.*','td_member.mem_name as sup_name')
                ->where('td_receive.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->where('td_receive.customer_id',$supplier_id)
                ->whereDate('td_receive.received_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_receive.received_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }else if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_receive')
                ->leftJoin('td_member','td_member.customer_id','=','td_receive.customer_id')
                // ->leftJoin('md_supplier','md_supplier.id','=','td_receive.supplier_id')
                ->select('td_receive.*','td_member.mem_name as sup_name')
                ->where('td_receive.society_id',auth()->user()->society_id)
                ->where('td_member.society_id',auth()->user()->society_id)
                ->whereDate('td_receive.received_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_receive.received_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }
        // $suppliers=MdSupplier::where('society_id',auth()->user()->society_id)->get();
        $suppliers=TdMember::where('delete_flag','N')
            // ->where('member_type','M')
            ->where('society_id',auth()->user()->society_id)
            ->get();
        return view('report.receive',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date,
        'supplier_id'=>$supplier_id,'suppliers'=>$suppliers
        ]);
    }
}
