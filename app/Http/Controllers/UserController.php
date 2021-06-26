<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{



    public function __construct()
    {

    }

    public function userFeedbacks($id)
    {

    }


    public function profile(Request $request, $id)
    {

    }

    public function logout()
    {
        Auth::logout();
        return redirect('home');
    }
}
