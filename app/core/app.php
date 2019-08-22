<?php
/************************/
/*****PSR-7-INTERFACE****/
/************************/
//
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
//
/************************/
/*****SLIM-INSTANCE******/
/************************/
//
$app = new \Slim\App([

    'settings' => [
        'displayErrorDetails' => true,
        'responseChunkSize' => 8096
    ]

]);
//
/*********************/
/******CONTAINER******/
/*********************/
require_once '../app/core/container.php';
//
/******************/
/****ROUTER********/
/******************/
//
$app->get('/', \App\Controllers\ProveedorController::class.':wellcome');
$app->get('/proveedor', \App\Controllers\ProveedorController::class.':index');
$app->get('/pep', \App\Controllers\PepController::class.':index');
$app->get('/pedido', \App\Controllers\PedidoController::class.':index');
//
$app->get('/proveedor/search', \App\Controllers\ProveedorController::class.':search');
$app->get('/pep/search', \App\Controllers\ProveedorController::class.':search');
//

//
/******************/
/****EJECUTAMOS****/
/******************/
$app->run();

?>