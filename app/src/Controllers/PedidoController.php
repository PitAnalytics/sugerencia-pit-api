<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface as Container;

class PedidoController extends Controller{
    
  //mandamos llamar dependencias del container
  public function __construct(Container $container){

    //container yn sus dependencias
    $this->container=$container;
    $this->config=$this->container['config'];
    $this->databases['sistemas']=$this->container['database'](['sistemas'=>$this->config->database('sistemas')]);
    $this->modules['pedido']=$this->container['pedido']($this->databases['sistemas']);

  }

  //tabla de prueba
  public function index($request,$response,$args){

      $index = $this->modules['pedido']->index();
      //imprimimos como json la tabla de prueba
      $response1 = $response->withJson($index,201);
      $response2 = $response1
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
      return $response2;
      
  }

    //tabla de prueba
  public function search($request,$response,$args){

    $index = $this->modules['pedido']->search($args['id'],$args['idbis'],$args['text']);
    //imprimimos como json la tabla de prueba
    $response1 = $response->withJson($index,201);
    $response2 = $response1
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    return $response2;
      
  }

}

?>