<?php

namespace App\Config;

class Config{

    //config structure(assoc array)
    private $config;

    public function __construct($path){

        //we open the config json file
        $jsonConfig=file_get_contents($path);

        //we convert the file to the main config structure(assoc array)
        $this->config=json_decode($jsonConfig,true);

    }

    //prints all config (disable for production for obvious security reasons)
    public function index(){

        return $this->config;

    }

    //config for database settings
    public function database($database){

        return $this->config['database'][$database];

    }

    //app general config
    public function app(){

        return $this->config['app'];

    }

    //GCP config
    public function google($service){

        return $this->config['google'][$service];

    }
    
}

?>