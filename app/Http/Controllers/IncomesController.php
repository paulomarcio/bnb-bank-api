<?php

namespace App\Http\Controllers;

use App\Services\GetIncomesGroupedByMonthService;
use Exception;

class IncomesController extends Controller
{
    public function index()
    {
        try{
            $months = GetIncomesGroupedByMonthService::execute();
            return response()->json($months, 200);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
