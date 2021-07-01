<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function profile($id)
    {
        $data = $this->userService->getUserProfile($id);
        return view('admin.profile')->with('user', $data);
    }

}
