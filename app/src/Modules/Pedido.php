<?php
//
namespace App\Modules;
//
use App\Primitives\DatabaseConnection as Connection;
use App\Interfaces\TableInterface as TableInterface;
//
class Pedido extends Connection implements TableInterface{
    
  public function index(){
    return $this->database->select('Pedido',['numero','concepto']);
  }

  public function get($id){
    return $this->database->get('Pedido',['numero','concepto','numeroProveedor','codigoPep']);
  }

  public function search($id,$text=null){

    $query;


    if($text!==null){

      $query= $this->database->query(
      "SELECT *

      FROM
      (SELECT 
	    year2.numeroPedido AS numeroPedido,
      year2.conceptoPedido AS conceptoPedido,
      year1.subtotal AS subtotal2018,
      year2.subtotal AS subtotal2019
      
      FROM 
      
      (SELECT 
      Pedido.numero AS numeroPedido,  
      Pedido.concepto AS conceptoPedido, 
      SUM(Orden.monto) AS subtotal 
      FROM Orden 
      INNER JOIN Pedido 
      ON Orden.numeroPedido = Pedido.numero 
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
      AND Orden.codigoPep='$id' 
      GROUP BY 
      Pedido.numero) as year1
      
      RIGHT JOIN 
      
      (SELECT 
      Pedido.numero AS numeroPedido, 
      Pedido.concepto AS conceptoPedido, 
      SUM(Orden.monto) AS subtotal 
      FROM Orden 
      INNER JOIN Pedido 
      ON Orden.numeroPedido = Pedido.numero 
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
      AND Orden.codigoPep='$id' 
      GROUP BY 
      Pedido.numero) as year2 
      
      ON year1.numeroPedido= year2.numeroPedido) as years
      
      WHERE conceptoPedido LIKE '%$text%'"

      )->fetchAll(2);

    }
    else{

      $query= $this->database->query(
        "SELECT year2.numeroPedido AS numeroPedido,
        year2.conceptoPedido AS conceptoPedido,
        year1.subtotal AS subtotal2018,
        year2.subtotal AS subtotal2019
        
        FROM 
        
        (SELECT 
        Pedido.numero AS numeroPedido,  
        Pedido.concepto AS conceptoPedido, 
        SUM(Orden.monto) AS subtotal 
        FROM Orden 
        INNER JOIN Pedido 
        ON Orden.numeroPedido = Pedido.numero 
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
        AND Orden.codigoPep='$id' 
        GROUP BY 
        Pedido.numero) as year1
        
        RIGHT JOIN 
        
        (SELECT 
        Pedido.numero AS numeroPedido, 
        Pedido.concepto AS conceptoPedido, 
        SUM(Orden.monto) AS subtotal 
        FROM Orden 
        INNER JOIN Pedido 
        ON Orden.numeroPedido = Pedido.numero 
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
        AND Orden.codigoPep='$id' 
        GROUP BY 
        Pedido.numero) as year2 
        
        ON year1.numeroPedido= year2.numeroPedido"
      )->fetchAll(2);

    }

    $result=[];

    foreach ($query as $row) {

      $line=[];
      $line['numeroPedido']=$row['numeroPedido'];
      $line['conceptoPedido']=$row['conceptoPedido'];
      $line['subtotal2018']=floatval($row['subtotal2018']);
      $line['subtotal2019']=intval($row['subtotal2019']);
      unset($row);
      $result[]=$line;

    }

    return $result;  
  }
  

}
