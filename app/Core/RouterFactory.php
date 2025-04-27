<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList();

        $router->addRoute('api/v1/products', 'Product:getAll');
        $router->addRoute('api/v1/products/<id \d+>', 'Product:getById');
        $router->addRoute('api/v1/products', 'Product:create');
        $router->addRoute('api/v1/products/<id \d+>', 'Product:update');
        $router->addRoute('api/v1/products/<id \d+>', 'Product:delete');

        return $router;

    }
}
