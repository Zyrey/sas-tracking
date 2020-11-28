<?php

namespace App\Http\Controllers;



use App\Superadmin;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('superadmin.home');
    }


    public function show(Superadmin $superadmin)
    {
        return view('superadmin.show', compact('superadmin'));
    }


}
