<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SuccessResponse
{
    public static function make(string $message = '', array $additionalParams = []): Response
    {
        return response(array_merge([
            'message' => $message,
            'status' => 'ok',
        ], $additionalParams));
    }

    public static function makeFromCollection(
        Collection $items,
        string $message = '',
        array $additionalParams = []
    ): Response {
        return self::make($message, array_merge(['data' => $items], $additionalParams));
    }
}
