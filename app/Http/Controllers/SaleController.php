<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
