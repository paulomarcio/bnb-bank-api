<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\GetTransactionsService;
use App\Services\CreateTransactionService;
use App\Services\UpdateTransactionService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TransactionsController extends Controller
{
    public function index()
    {
        try{
            $transactions = GetTransactionsService::execute();
            return response()->json($transactions, 200);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try{
            CreateTransactionService::execute($request);
            return response()->json([], 201);
        }catch(BadRequestException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }catch(NotFoundHttpException $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            UpdateTransactionService::execute($request, $id);
            return response()->json([], 200);
        }catch(BadRequestException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }catch(NotFoundHttpException $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
