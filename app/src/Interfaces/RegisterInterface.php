<?php

//interface namespace by psr-4 and composer
namespace App\Interfaces;

//interface for 1 row object
interface RegisterInterface{

  //id is any identity field (string or integer)
  public function get($id);

}

?>