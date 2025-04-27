<?php

declare(strict_types=1);

namespace App\Dto;

final class PaginationDto
{
    public int $page;
    public int $perPage;

    private function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public static function fromParams(?string $page, ?string $perPage): self
    {
        $p = max(1, (int) ($page ?? '1'));
        $pp = min(100, max(1, (int) ($perPage ?? '20')));
        return new self($p, $pp);
    }
}
