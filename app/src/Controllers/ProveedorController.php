<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface as Container;

class ProveedorController extends Controller{
    
    //mandamos llamar dependencias del container
    public function __construct(Container $container){

        //container yn sus dependencias
        $this->container=$container;
        $this->config=$this->container['config'];
        $this->databases['sistemas']=$this->container['database'](['sistemas'=>$this->config->database('sistemas')]);
        $this->modules['proveedor']=$this->container['proveedor']($this->databases['sistemas']);

    }

    //hola mundo
    public function wellcome($request,$response,$args){

        echo('wellcome');

    }

    //tabla de prueba
    public function index($request,$response,$args){

        $index = $this->modules['proveedor']->index();
        
        $response1 = $response->withJson($index,201);
        $response2 = $response1
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

        return $response2;
        
    }

    //tabla de prueba
    public function search($request,$response,$args){

        $index = $this->modules['proveedor']->search();

        $response1 = $response->withJson($index,201);
        $response2 = $response1
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

        return $response2;
        
    }

}

?>