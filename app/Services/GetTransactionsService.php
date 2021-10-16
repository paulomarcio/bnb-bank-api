<?php

namespace App\Services;

use App\Dao\TransactionDao;

class GetTransactionsService
{
    public static function execute()
    {
        return TransactionDao::getPendingIncomes();
    }
}
