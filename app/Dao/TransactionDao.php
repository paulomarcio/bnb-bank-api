<?php

namespace App\Dao;

use App\Enum\TransactionStatusEnum;
use App\Enum\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionDao
{
    public static function create($data = [])
    {
        return Transaction::create($data);
    }

    public static function getPendingIncomes()
    {
        return Transaction::where('status', TransactionStatusEnum::PENDING)
            ->with('account')
            ->with('account.user')
            ->get();
    }

    public static function sumIncomesFromUser(User $user, $date = null)
    {
        $transactions = Transaction::where('account_id', $user->account->id)
            ->where('type', TransactionTypeEnum::INCOME)
            ->where('status', TransactionStatusEnum::ACCEPTED);

        if(!empty($date)){
            $transactions->whereRaw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m')", $date);
        }

        return $transactions->sum('amount');
    }

    public static function sumExpensesFromUser(User $user, $date = null)
    {
        $transactions = Transaction::where('account_id', $user->account->id)
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->where('status', TransactionStatusEnum::ACCEPTED);

        if(!empty($date)){
            $transactions->whereRaw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m')", $date);
        }

        return $transactions->sum('amount');
    }

    public static function getTransactionById($id)
    {
        return Transaction::find($id);
    }

    public static function getMonthsWithExpensesByUser(User $user)
    {
        return Transaction::select([
            DB::raw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m') AS transaction_date")
        ])
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->where('account_id', $user->account->id)
            ->orderBy('transaction_date', 'desc')
            ->groupBy(['transaction_date'])->get();
    }

    public static function getExpensesByMonthYearAndUser(User $user, $date)
    {
        return Transaction::where('account_id', $user->account->id)
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->whereRaw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m')", $date)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getMonthsWithIncomesByUser(User $user)
    {
        return Transaction::select([
            DB::raw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m') AS transaction_date")
        ])
            ->where('type', TransactionTypeEnum::INCOME)
            ->where('status', TransactionStatusEnum::ACCEPTED)
            ->where('account_id', $user->account->id)
            ->orderBy('transaction_date', 'desc')
            ->groupBy(['transaction_date'])->get();
    }

    public static function getIncomesByMonthYearAndUser(User $user, $date)
    {
        return Transaction::where('account_id', $user->account->id)
            ->where('type', TransactionTypeEnum::INCOME)
            ->where('status', TransactionStatusEnum::ACCEPTED)
            ->whereRaw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m')", $date)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getMonthsWithTransactionsByUser(User $user)
    {
        return Transaction::select([
            DB::raw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m') AS transaction_date")
        ])
            ->where('status', TransactionStatusEnum::ACCEPTED)
            ->where('account_id', $user->account->id)
            ->orderBy('transaction_date', 'desc')
            ->groupBy(['transaction_date'])->get();
    }

    public static function getTransactionsByMonthYearAndUser(User $user, $date)
    {
        return Transaction::where('account_id', $user->account->id)
            ->where('status', TransactionStatusEnum::ACCEPTED)
            ->whereRaw("DATE_FORMAT(CAST(created_at AS TIMESTAMP), '%Y-%m')", $date)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
