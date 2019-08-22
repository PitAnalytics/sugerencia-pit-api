<?php

//
namespace App\Controllers;

use Psr\Container\ContainerInterface as Container;

abstract class Controller{

    //container main dependency
    protected $container;
    //app config and order by json
    protected $config;
    //mysql databases
    protected $databases=[];
    //node js socket.io by elephant.io
    protected $sockets=[];
    //GCP dependencies and tools
    protected $google;
    //authentification user and sessions
    protected $auth;
    //DAO with  connection to database dependency (from $databases)
    protected $modules=[];
    //more complex structures
    protected $subsystems=[];

    //construction using dependency inyection
    public abstract function __construct(Container $container);

}

?>