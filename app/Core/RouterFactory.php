<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\MethodRoute;
use Nette\Application\Routers\RouteList;
final class RouterFactory
{
    public static function createRouter(): RouteList
    {
        $router = new RouteList;

        $router[] = new MethodRoute(
            'api/v1/products',
            'Product:getAll',
            'GET'
        );
        $router[] = new MethodRoute(
            'api/v1/products/<id \d+>',
            'Product:getById',
            'GET'
        );

        $router[] = new MethodRoute(
            'api/v1/products',
            'Product:create',
            'POST'
        );

        $router[] = new MethodRoute(
            'api/v1/products/<id \d+>',
            'Product:update',
            'PUT'
        );

        $router[] = new MethodRoute(
            'api/v1/products/<id \d+>',
            'Product:delete',
            'DELETE'
        );

        return $router;
    }
}
