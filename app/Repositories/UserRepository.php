<?php


namespace App\Repositories;


use App\Models\Feedbacks;
use App\Models\User;

class UserRepository
{
    public function getUserFeedbacks(int $id)
    {
        return Feedbacks::where('author_id', $this->getUserById($id));
    }

    public function getUserById(int $id)
    {
        return User::find($id);
    }
}
