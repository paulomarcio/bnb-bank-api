<?php

namespace App\Dao;

use App\Models\User;

class UserDao
{
    public static function create($data = [])
    {
        return User::create($data);
    }

    public static function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function getUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }
}
