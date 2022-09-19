<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{MdSociety,User};
use Illuminate\Support\Facades\Crypt;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function Index()
    {
        // $users=User::where('user_type','S')->get();
        $users=DB::table('users')
            ->leftJoin('md_society','md_society.id','=','users.society_id')
            ->select('users.*','md_society.soc_name as soc_name')
            ->where('user_type','S')
            ->get();
        return view('admin.user_manage',['users'=>$users]);
    }
}
