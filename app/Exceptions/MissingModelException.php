<?php

namespace App\Exceptions;

use Exception;

class MissingModelException extends Exception
{
    public function render($request) {
        $message = [
            'status' => 404,
            'error' => [
                'error' => ['Not found.'],
            ],
        ];
        return response()->json($message, 200);
    }
}
