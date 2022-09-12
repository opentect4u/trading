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
        $type=$request->type;
        $datas=[];
        if($type=='ALL'){
            // return $type;
            $datas=TdMember::where('delete_flag','N')->where('member_type','M')->get();
        }elseif ($type!='') {
            $datas=TdMember::where('delete_flag','N')->where('member_type','M')->where('open_close_flag',$type)->get();
        }
        return view('report.member',['datas'=>$datas,'type'=>$type]);
    }
}
