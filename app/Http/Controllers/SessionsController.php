<?php

namespace App\Http\Controllers;

use App\Services\CreateSessionService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SessionsController extends Controller
{
    public function create(Request $request)
    {
        try{
            $user = CreateSessionService::execute($request);
            $user->account = $user->account;

            return response()->json($user, 201);
        }catch(BadRequestException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }catch(NotFoundHttpException $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        }catch(UnauthorizedHttpException $exception){
            return response()->json(['message' => $exception->getMessage()], 401);
        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
