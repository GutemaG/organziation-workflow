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

    protected static function successResponse(array $data=[], int $status=200): JsonResponse
    {
        $response = array();
        $response['status'] = $status;
        $response = $data ? array_merge($response, $data) : $response;
        return response()->json([$response]);
    }
}
