<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{MdSociety,User};
use Illuminate\Support\Facades\Crypt;
use DB;
use Illuminate\Support\Facades\Hash;

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

    public function Show()
    {
        $societies=MdSociety::get();
        return view('admin.user_add_edit',['societies'=>$societies]);
    }

    public function Create (Request $request)
    {
        // return $request;

        if ($request->password!=$request->password_confirmation) {
            return redirect()->back()->with('password_error','password_error');
        }
        $is_has=User::where('email',$request->email)->get();
        if (count($is_has)>0) {
            return redirect()->back()->with('email_error','email_error');
        } else {
            User::create(array(
                'name'=>$request->name,
                'email'=>$request->email,
                'user_type'=>'S',
                'password'=>Hash::make($request->password),
                'society_id'=>$request->society_id,
            ));
            return redirect()->route('admin.userManage')->with('success','success');
        }
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        // return $id;
        $data=User::find($id);
        $societies=MdSociety::get();
        return view('admin.user_add_edit',['data'=>$data,'societies'=>$societies]);
    }

    public function Update(Request $request)
    {
        // return $request;
        if ($request->password!=$request->password_confirmation) {
            return redirect()->back()->with('password_error','password_error');
        }
        $id=Crypt::decryptString($request->id);
        $data=User::find($id);
        $data->name=$request->name;
        $data->password=Hash::make($request->password);
        $data->save();
        return redirect()->back()->with('update','update');
    }
}
