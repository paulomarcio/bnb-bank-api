<?php

namespace App\Services;

use App\Dao\TransactionDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateTransactionService
{
    public static function execute(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'status' => 'required',
        ]);

        if($validator->fails()){
            throw new BadRequestException($validator->errors());
        }

        $transaction = TransactionDao::getTransactionById($id);

        if(empty($transaction)){
            throw new NotFoundHttpException();
        }

        $transaction->update($data);
    }
}
