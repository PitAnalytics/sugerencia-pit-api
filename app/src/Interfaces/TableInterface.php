<?php

//interface namespace by psr-4 and composer
namespace App\Interfaces;

//interface for full table
interface TableInterface extends RegisterInterface{

    //the table in specified order
    public function index();

}

?>
