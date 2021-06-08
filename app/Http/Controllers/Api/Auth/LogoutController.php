<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * LogoutController constructor.
     * check if user is logged in before logging out
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(!auth('sanctum')->check()){
                return response()->json([
                    'status' => 500,
                    'message' => 'Unauthorized',
                ]);
            }
            return $next($request);
        });
    }

    /**
     * Logout user.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'successfully logged out',
        ]);
    }
}
