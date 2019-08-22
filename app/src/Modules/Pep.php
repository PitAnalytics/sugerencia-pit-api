<?php
//
namespace App\Modules;
//
use App\Primitives\DatabaseConnection as Connection;
use App\Interfaces\TableInterface as TableInterface;
//
class Pep extends Connection implements TableInterface{
    
  public function index(){
    return $this->database->select('Pep',['codigo','descripcion']);
  }

  public function get($id){
    return $this->database->get('Pep',['codigo','descripcion']);
  }
  public function search($id){

    $query= $this->database->query("")->fetchAll(2);

    $result=[];

    foreach ($query as $row) {

        $line=[];
        $line['numeroProveedor']=$row['numeroProveedor'];
        $line['nombreProveedor']=$row['nombreProveedor'];
        $line['subtotal']=floatval($row['subtotal']);
        $line['conteoPep']=intval($row['conteoPep']);
        unset($row);
        $result[]=$line;
    }
    return $result;  
  }
}
