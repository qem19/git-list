<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncRepositoriesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vendor' => 'string|required',
            'repository' => 'string|required',
        ];
    }
}
