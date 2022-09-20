<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $datas=User::where('society_id',auth()->user()->society_id)->get();
        // $datas=[];
        return view('user_manage',['datas'=>$datas]);
    }

    public function Show()
    {
        return view('user_add_edit');
    }

    public function Create(Request $request)
    {
        // return $request;
        
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'confirmed'],
        // ]);
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
                'user_type'=>$request->user_type,
                'password'=>Hash::make($request->password),
                'society_id'=>auth()->user()->id,
            ));
            return redirect()->route('usersManage')->with('success','success');
        }
        
    }

    public function Edit($id)
    {
        $id=Crypt::decryptString($id);
        // return $id;
        $data=User::find($id);
        return view('user_add_edit',['data'=>$data]);
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
