<?php

namespace App\Exceptions;

use Exception;

class FormRequestException extends Exception
{
    public function render($request) {
        $message = json_decode($this->getMessage());
        $statusCode = $this->getCode();

        return response()->json($message, $statusCode);
    }
}
