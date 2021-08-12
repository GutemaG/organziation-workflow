<?php


namespace App\Http\Controllers\Actions;


use Illuminate\Http\JsonResponse;

trait MyJsonResponse
{
    protected static function unauthorizedResponse(): JsonResponse
    {
        return response()->json([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    protected static function successResponse(array $data, int $status=200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            $data,
        ]);
    }
}
