<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\{TdPurchase,TdSale,MdProductMaster};

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
        $datas=[];
        if ($from_date!='' && $to_date!='') {
            $datas=DB::table('td_receive')
                ->leftJoin('md_supplier','md_supplier.id','=','td_receive.supplier_id')
                ->select('td_receive.*','md_supplier.sup_name as sup_name')
                ->where('td_receive.society_id',auth()->user()->society_id)
                ->whereDate('td_receive.received_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('td_receive.received_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }
        return view('report.receive',['datas'=>$datas,'from_date'=>$from_date,'to_date'=>$to_date]);
    }
}
