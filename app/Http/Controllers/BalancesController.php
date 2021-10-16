<?php

namespace App\Http\Controllers;

use App\Services\GetTransactionsGroupedByMonthService;
use Exception;

class BalancesController extends Controller
{
    public function index()
    {
        try{
            $months = GetTransactionsGroupedByMonthService::execute();
            return response()->json($months, 200);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
