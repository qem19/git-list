<?php

declare(strict_types=1);

namespace App\Modules\Commits\DTO;

class CommitDto
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $this->validated($params);
    }

    public function sha(): string
    {
        return $this->params['sha'];
    }

    public function toArray(): array
    {
        return $this->params;
    }

    private function validated(array $params): array
    {
        return validator($params, [
            'sha' => 'string|required',
            'author' => 'string|required',
            'description' => 'string|required',
            'committed_at' => 'date|required',
        ])
            ->validated();
    }
}
