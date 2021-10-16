<?php

namespace App\Services;

use App\Dao\TransactionDao;
use Illuminate\Support\Facades\Auth;

class GetExpensesGroupedByMonthService
{
    public static function execute()
    {
        $user = Auth::user();
        $months = TransactionDao::getMonthsWithExpensesByUser($user);
        $expenses = [];

        foreach($months as $month){
            array_push($expenses, [
                'period' => $month->transaction_date,
                'expenses' => TransactionDao::getExpensesByMonthYearAndUser($user, $month->transaction_date)
            ]);
        }

        return $expenses;
    }
}
