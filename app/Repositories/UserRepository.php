<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function newUser($email, $name, $password)
    {
        return $this->model->create([
            'email'    => $email,
            'name'     => $name,
            'password' => $password
        ]);
    }

    public function searchuserFromEmail($emailAddress)
    {
        return $this->model->where('email', $emailAddress)->get();
    }
}
