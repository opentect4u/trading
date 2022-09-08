<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ParamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
