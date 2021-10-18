<?php

namespace App\Http\Controllers;

use App\Services\CreateAccountService;
use App\Services\CreateUserService;
use App\Services\GetUserBalanceService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UsersController extends Controller
{
    public function create(Request $request)
    {
        try{
            $user = CreateUserService::execute($request);
            CreateAccountService::execute($user);

            return response()->json($user, 201);
        }catch(BadRequestException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function balance()
    {
        try{
            $balance = GetUserBalanceService::execute();

            return response()->json($balance, 201);
        }catch(BadRequestException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
