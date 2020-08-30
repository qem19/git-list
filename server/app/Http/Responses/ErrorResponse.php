<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ErrorResponse
{
    public static function make(string $message = ''): Response
    {
        return response([
            'message' => $message,
            'status' => 'error',
        ]);
    }
}
