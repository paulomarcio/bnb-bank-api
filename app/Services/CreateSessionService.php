<?php

namespace App\Services;

use App\Dao\UserDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreateSessionService
{
    public static function execute(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            throw new BadRequestException($validator->errors());
        }

        $email = trim(strtolower($data['email']));
        $user = UserDao::getUserByEmail($email);

        if(empty($user)){
            throw new NotFoundHttpException('User not found');
        }

        if(Hash::check($data['password'], $user->password) === false){
            throw new UnauthorizedHttpException('Email or password does not match');
        }

        return $user;
    }
}
