<?php

namespace App\Services;

use App\Dao\AccountDao;
use App\Models\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateAccountService
{
    public static function execute(User $user)
    {

        if(empty($user)){
            throw new BadRequestException();
        }

        AccountDao::create([
            'user_id' => $user->id,
            'number' => str_pad($user->id, 8, '0', STR_PAD_LEFT),
        ]);
    }
}
