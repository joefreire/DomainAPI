<?php

namespace App\Actions;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUser
{
    public function handle(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return $user;
    }
}
