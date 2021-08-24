<?php

namespace App\Exceptions;

use Exception;

class DatabaseException extends Exception
{
    public function render() {
        return response()->json([
           'status' => 500,
            'error' => [
                'error' => [$this->getMessage()]
            ]
        ], 200);
    }
}
