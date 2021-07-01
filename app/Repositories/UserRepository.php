<?php


namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function getUserById(int $id)
    {
        return User::find($id);
    }
}
