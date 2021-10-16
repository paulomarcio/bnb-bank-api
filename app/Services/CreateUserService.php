<?php

namespace App\Services;

use App\Dao\UserDao;
use App\Enum\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateUserService
{
    public static function execute(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            throw new BadRequestException($validator->errors());
        }

        $username = trim($data['username']);
        $email = trim(strtolower($data['email']));

        $user = UserDao::getUserByEmail($email);

        if(!empty($user)){
            throw new BadRequestException('Email has already been taken.');
        }

        $user = UserDao::getUserByUsername($username);

        if(!empty($user)){
            throw new BadRequestException('Username has already been taken.');
        }

        return UserDao::create([
            'role_id' => RoleEnum::CUSTOMER,
            'username' => $username,
            'email' => $email,
            'password' => $data['password']
        ]);
    }
}
