<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function render($request) {
        $message = [
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ];
        return response()->json($message, 200);
    }
}
