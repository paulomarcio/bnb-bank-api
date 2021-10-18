<?php

namespace App\Services;

use App\Dao\TransactionDao;
use Illuminate\Support\Facades\Auth;

class GetTransactionsGroupedByMonthService
{
    public static function execute()
    {
        $user = Auth::user();
        $months = TransactionDao::getMonthsWithTransactionsByUser($user);
        $transactions = [];

        foreach($months as $month){
            array_push($transactions, [
                'period' => $month->operation_date,
                'incomes' => ['amount' => TransactionDao::sumIncomesFromUser($user, $month->operation_date)],
                'expenses' => ['amount' => TransactionDao::sumExpensesFromUser($user, $month->operation_date)],
                'transactions' => TransactionDao::getTransactionsByMonthYearAndUser($user, $month->operation_date)
            ]);
        }

        return $transactions;
    }
}
