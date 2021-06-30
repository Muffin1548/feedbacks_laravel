<?php


namespace App\Services;


use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getUserProfile(array $data, int $id): array
    {
        $data['user'] = $this->userRepository->getUserById($id);

        $data['id'] = $data['user']->id;
        $data['feedbacks'] = $data['user']->feedbacks;
        return $data;
    }
}
