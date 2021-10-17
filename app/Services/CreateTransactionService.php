<?php

namespace App\Services;

use App\Dao\TransactionDao;
use App\Enum\TransactionStatusEnum;
use App\Enum\TransactionTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateTransactionService
{
    public static function execute(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'amount' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            throw new BadRequestException($validator->errors());
        }

        $user = Auth::user();
        if($user->is_admin){
            throw new NotFoundHttpException();
        }

        $account = $user->account;
        $amount = $data['amount'];
        $status = $data['type'] === TransactionTypeEnum::INCOME ? TransactionStatusEnum::PENDING : TransactionStatusEnum::ACCEPTED;
        $isAllowed = true;

        if($data['type'] === TransactionTypeEnum::EXPENSE){
            $incomes = TransactionDao::sumIncomesFromUser($user);
            $expenses = TransactionDao::sumExpensesFromUser($user);
            $balance = $incomes - $expenses;
            $isAllowed = $balance >= $amount;
        }

        if(!$isAllowed){
            throw new BadRequestException('You do not have enough funds to complete this operation');
        }

        TransactionDao::create([
            'account_id' => $account->id,
            'amount' => $amount,
            'description' => $data['description'],
            'check_image' => (!empty($data['check_image'])) ? $data['check_image'] : null,
            'transaction_date' => (!empty($data['transaction_date'])) ? $data['transaction_date'] : date('Y-m-d'),
            'type' => $data['type'],
            'status' => $status
        ]);
    }
}
