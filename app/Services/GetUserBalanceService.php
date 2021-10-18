<?php

namespace App\Services;

use App\Dao\TransactionDao;
use Illuminate\Support\Facades\Auth;

class GetUserBalanceService
{
    public static function execute()
    {
        $user = Auth::user();
        $incomes = TransactionDao::sumIncomesFromUser($user);
        $expenses = TransactionDao::sumExpensesFromUser($user);

        return ['balance' => ($incomes - $expenses)];
    }
}
