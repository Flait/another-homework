<?php

declare(strict_types=1);

namespace App\Enum;

enum ProductFilter: string
{
    case MIN_PRICE = 'min_price';
    case MAX_PRICE = 'max_price';
}
