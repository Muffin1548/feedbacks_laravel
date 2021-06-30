<?php

namespace App\Http\Controllers;

use App\Models\Feedbacks;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;


    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function userFeedbacks($id)
    {

    }


    public function profile($id)
    {
        $data['user'] = User::find($id);

        $data['feedbacks'] = $data['user']->feedbacks;
        return view('admin.profile')->with('user', $data);
    }

}
