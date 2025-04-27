<?php

declare(strict_types=1);

namespace App\Dto;

final class ProductQueryDto
{
    public PaginationDto $pagination;
    public ?float        $minPrice = null;
    public ?float        $maxPrice = null;

    private function __construct()
    {
    }

    public static function fromParams(
        ?string $page,
        ?string $perPage,
        ?string $minPrice,
        ?string $maxPrice,
    ): self {
        $dto = new self();
        // reuse the PaginationDto
        $dto->pagination = PaginationDto::fromParams($page, $perPage);

        if (is_numeric($minPrice)) {
            $dto->minPrice = (float) $minPrice;
        }
        if (is_numeric($maxPrice)) {
            $dto->maxPrice = (float) $maxPrice;
        }

        return $dto;
    }
}
