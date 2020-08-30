<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCommitsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'commit_ids' => 'array|required',
            'commit_ids.*' => 'integer',
        ];
    }
}
