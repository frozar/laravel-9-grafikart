<?php

namespace App\Http\Controllers;

// use \Request;
// use \Input;

class WelcomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("ip");
    }

    public function index()
    {
        // dd(request()->ip());
        // dd(request()->query());
        // dd(session());
        // dd(Request::ip());
        return view("welcome");
    }
}
