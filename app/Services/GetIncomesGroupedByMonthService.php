<?php

namespace App\Services;

use App\Dao\TransactionDao;
use Illuminate\Support\Facades\Auth;

class GetIncomesGroupedByMonthService
{
    public static function execute()
    {
        $user = Auth::user();
        $months = TransactionDao::getMonthsWithIncomesByUser($user);
        $incomes = [];

        foreach($months as $month){
            array_push($incomes, [
                'period' => $month->transaction_date,
                'incomes' => TransactionDao::getIncomesByMonthYearAndUser($user, $month->transaction_date)
            ]);
        }

        return $incomes;
    }
}
