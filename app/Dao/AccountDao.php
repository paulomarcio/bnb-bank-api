<?php

namespace App\Dao;

use App\Models\Account;

class AccountDao
{
    public static function create($data = [])
    {
        return Account::create($data);
    }

    public static function getAccountByNumber($number)
    {
        return Account::where('number', $number)->first();
    }
}
