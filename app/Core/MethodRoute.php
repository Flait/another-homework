<?php

namespace App\Core;

use Nette\Application\Routers\Route;


class MethodRoute extends Route
{
    private array $methods;

    public function __construct(string $mask, $metadata, string|array $methods)
    {
        parent::__construct($mask, $metadata);
        $this->methods = array_map('strtoupper', (array)$methods);
    }

    public function match(\Nette\Http\IRequest $httpRequest): ?array
    {
        if (!in_array($httpRequest->getMethod(), $this->methods, true)) {
            return null;
        }
        return parent::match($httpRequest);
    }
}
