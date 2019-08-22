<?php

namespace App\Primitives;

class DatabaseConnection{

    protected $database;

    public function __construct($database){

        $this->database=$database;

    }
    
}

?>