<?php


namespace App\Http\Controllers\Actions;


use Illuminate\Http\JsonResponse;

trait MyJsonResponse
{
    /**
     * Returns unauthorized Json response.
     *
     * @return JsonResponse
     */
    protected static function unauthorizedResponse(): JsonResponse
    {
        return response()->json([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    /**
     * Return success Json response by combining the status and the return data.
     *
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected static function successResponse(array $data=[], int $status=200): JsonResponse
    {
        $response = array();
        $response['status'] = $status;

        $response = $data ? array_merge($response, $data) : $response;
        return response()->json($response);
    }
}
