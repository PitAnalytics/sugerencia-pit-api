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
  public function search($id,$text=null){

    $query;

    if($text!==null){

      $query=$this->database->query(  
      "SELECT * 
      FROM
      (SELECT 
      year1.codigoPep as codigoPep,
      year1.descripcionPep as descripcionPep,
      year1.subtotal as subtotal2018,
      year2.subtotal as subtotal2019
      FROM 
      (SELECT Pep.codigo AS codigoPep, 
      Pep.descripcion AS descripcionPep,
      SUM(Orden.monto) AS subtotal
      FROM Orden
      INNER JOIN Pep
      ON Orden.codigoPep = Pep.codigo
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
      AND Orden.numeroProveedor = '$id' 
      GROUP BY 
      Pep.codigo) as year1
      LEFT JOIN
      (SELECT Pep.codigo AS codigoPep, 
      Pep.descripcion AS descripcionPep,
      SUM(Orden.monto) AS subtotal
      FROM Orden
      INNER JOIN Pep
      ON Orden.codigoPep = Pep.codigo
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
      AND Orden.numeroProveedor = '$id' 
      GROUP BY 
      Pep.codigo) as year2
      ON year1.codigoPep=year2.codigoPep
      
      UNION
      
      SELECT 
      year2.codigoPep as codigoPep,
      year2.descripcionPep as descripcionPep,
      year1.subtotal as subtotal2018,
      year2.subtotal as subtotal2019
      FROM 
      (SELECT Pep.codigo AS codigoPep, 
      Pep.descripcion AS descripcionPep,
      SUM(Orden.monto) AS subtotal
      FROM Orden
      INNER JOIN Pep
      ON Orden.codigoPep = Pep.codigo
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
      AND Orden.numeroProveedor = '$id' 
      GROUP BY Pep.codigo) as year1
      RIGHT JOIN
      (SELECT Pep.codigo AS codigoPep, 
      Pep.descripcion AS descripcionPep,
      SUM(Orden.monto) AS subtotal
      FROM Orden
      INNER JOIN Pep
      ON Orden.codigoPep = Pep.codigo
      WHERE 
      SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
      AND Orden.numeroProveedor = '$id' 
      GROUP BY Pep.codigo) as year2 
      ON year1.codigoPep=year2.codigoPep) AS years 
      WHERE descripcionPep LIKE '%$text%' 
      ORDER BY codigoPep" 
      )->fetchAll(2);

    }
    else{
      $query= $this->database->query(
        "SELECT * 
        FROM
        (SELECT 
        year1.codigoPep as codigoPep,
        year1.descripcionPep as descripcionPep,
        year1.subtotal as subtotal2018,
        year2.subtotal as subtotal2019
        FROM 
        (SELECT Pep.codigo AS codigoPep, 
        Pep.descripcion AS descripcionPep,
        SUM(Orden.monto) AS subtotal
        FROM Orden
        INNER JOIN Pep
        ON Orden.codigoPep = Pep.codigo
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
        AND Orden.numeroProveedor = '$id' 
        GROUP BY 
        Pep.codigo) as year1
        LEFT JOIN
        (SELECT Pep.codigo AS codigoPep, 
        Pep.descripcion AS descripcionPep,
        SUM(Orden.monto) AS subtotal
        FROM Orden
        INNER JOIN Pep
        ON Orden.codigoPep = Pep.codigo
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
        AND Orden.numeroProveedor = '$id' 
        GROUP BY 
        Pep.codigo) as year2
        ON year1.codigoPep=year2.codigoPep
        
        UNION
        
        SELECT 
        year2.codigoPep as codigoPep,
        year2.descripcionPep as descripcionPep,
        year1.subtotal as subtotal2018,
        year2.subtotal as subtotal2019
        FROM 
        (SELECT Pep.codigo AS codigoPep, 
        Pep.descripcion AS descripcionPep,
        SUM(Orden.monto) AS subtotal
        FROM Orden
        INNER JOIN Pep
        ON Orden.codigoPep = Pep.codigo
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
        AND Orden.numeroProveedor = '$id' 
        GROUP BY Pep.codigo) as year1
        RIGHT JOIN
        (SELECT Pep.codigo AS codigoPep, 
        Pep.descripcion AS descripcionPep,
        SUM(Orden.monto) AS subtotal
        FROM Orden
        INNER JOIN Pep
        ON Orden.codigoPep = Pep.codigo
        WHERE 
        SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
        AND Orden.numeroProveedor = '$id' 
        GROUP BY Pep.codigo) as year2
        ON year1.codigoPep=year2.codigoPep) AS years
        WHERE 1
        ORDER BY codigoPep"
      )->fetchAll(2);
    }
    $result=[];

    foreach ($query as $row) {

      $line=[];
      $line['codigoPep']=$row['codigoPep'];
      $line['descripcionPep']=$row['descripcionPep'];
      $line['subtotal2018']=floatval($row['subtotal2018']);
      $line['subtotal2019']=intval($row['subtotal2019']);
      unset($row);
      $result[]=$line;

    }

    return $result;  
  }
}
