<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App(['settings' => [
    'displayErrorDetails' => true,
    'responseChunkSize' => 8096]
    ]
);
//
$container=$app->getContainer();
//
$container['config']=function($container){

    return new App\Config\Config('../app/src/Config/Config.json');

};
//
$container['database']=function($container){

    return function($config){

        return App\Tools\DatabasePool::instanciate($config);

    };

};
//
$container['proveedor']=function($container){

    return function($database){

        return new App\Modules\Proveedor($database);

    };

};
//
$container['pep']=function($container){

    return function($database){

        return new App\Modules\Pep($database);

    };

};
//
$container['pedido']=function($container){

    return function($database){

        return new App\Modules\Pedido($database);

    };

};

?>