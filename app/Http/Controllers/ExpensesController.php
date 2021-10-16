<?php

namespace App\Http\Controllers;

use App\Services\GetExpensesGroupedByMonthService;
use Exception;

class ExpensesController extends Controller
{
    public function index()
    {
        try{
            $months = GetExpensesGroupedByMonthService::execute();
            return response()->json($months, 200);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
