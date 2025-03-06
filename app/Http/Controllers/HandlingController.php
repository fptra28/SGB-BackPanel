<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandlingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** 
     *  Error 404
     */
    public function Error404()
    {
        return view('errors.404');
    }

    /** 
     *  Error 403
     */
    public function Error403()
    {
        return view('errors.403');
    }
}
