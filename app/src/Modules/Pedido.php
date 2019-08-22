<?php
//
namespace App\Modules;
//
use App\Primitives\DatabaseConnection as Connection;
use App\Interfaces\TableInterface as TableInterface;
//
class Pedido extends Connection implements TableInterface{
    
  public function index(){
    return $this->database->select('Pedido',['numero','concepto','numeroProveedor','codigoPep']);
  }

  public function get($id){
    return $this->database->get('Pedido',['numero','concepto','numeroProveedor','codigoPep']);
  }

}
