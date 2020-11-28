<?php

namespace App\Http\Controllers;


use App\Admin;
use App\Http\Requests\PostAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminHomeController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }

}
