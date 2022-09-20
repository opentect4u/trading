<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Helper;
use App\Models\TdMember;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $type=$request->type;
        $datas=[];
        // if($type=='ALL'){
        //     // return $type;
        //     $datas=TdMember::where('delete_flag','N')->where('member_type','M')->get();
        // }else
        if ($type!='') {
            $datas=TdMember::where('delete_flag','N')
                ->where('member_type','M')
                ->where('open_close_flag',$type)
                ->whereDate('mem_date','>=',date('Y-m-d',strtotime($from_date)))
                ->whereDate('mem_date','<=',date('Y-m-d',strtotime($to_date)))
                ->get();
        }
        return view('report.member',['datas'=>$datas,'type'=>$type,'from_date'=>$from_date,'to_date'=>$to_date]);
    }
}
