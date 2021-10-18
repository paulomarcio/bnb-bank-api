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
                'period' => $month->expense_date,
                'expenses' => TransactionDao::getExpensesByMonthYearAndUser($user, $month->expense_date)
            ]);
        }

        return $expenses;
    }
}
