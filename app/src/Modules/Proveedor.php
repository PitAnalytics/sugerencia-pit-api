<?php
//
namespace App\Modules;
//
use App\Primitives\DatabaseConnection as Connection;
use App\Interfaces\TableInterface as TableInterface;
//
class Proveedor extends Connection implements TableInterface{
    
    public function index(){
        return $this->database->select('Proveedor',['numero','nombre']);
    }

    public function get($id){
       return $this->database->get('Proveedor',['numero','nombre']);
    }
    public function search($text=null){

        $query;

        if($text!==null){
            $query= $this->database->query(
                "SELECT *
        
                    FROM 
        
                (SELECT year2.numeroProveedor AS numeroProveedor, year2.nombreProveedor AS nombreProveedor, year1.subtotal AS subtotal2018, year2.subtotal AS subtotal2019 
        
                FROM 
                (SELECT Proveedor.numero AS numeroProveedor, 
                Proveedor.nombre AS nombreProveedor,
                SUM(Orden.monto) AS subtotal
                FROM Orden
                INNER JOIN Proveedor
                ON Orden.numeroProveedor = Proveedor.numero
                WHERE
                SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018'
                GROUP BY 
                Proveedor.numero) as year1 
                
                RIGHT JOIN 
                
                (SELECT Proveedor.numero AS numeroProveedor, 
                Proveedor.nombre AS nombreProveedor, 
                SUM(Orden.monto) AS subtotal 
                FROM Orden 
                INNER JOIN Proveedor 
                ON Orden.numeroProveedor = Proveedor.numero 
                WHERE 
                SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
                GROUP BY 
                Proveedor.numero) as year2 
                
                ON year1.numeroProveedor = year2.numeroProveedor) AS years 
                
                WHERE nombreProveedor LIKE '%$text%'"

            )->fetchAll(2);
        }
        else{
            $query= $this->database->query(

                "SELECT year2.numeroProveedor AS numeroProveedor, 
                year2.nombreProveedor AS nombreProveedor, 
                year1.subtotal AS subtotal2018, 
                year2.subtotal AS subtotal2019 
        
                FROM 
                (SELECT Proveedor.numero AS numeroProveedor, 
                Proveedor.nombre AS nombreProveedor, 
                SUM(Orden.monto) AS subtotal 
                FROM Orden 
                INNER JOIN Proveedor 
                ON Orden.numeroProveedor = Proveedor.numero 
                WHERE 
                SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2018' 
                GROUP BY 
                Proveedor.numero) as year1 
                
                RIGHT JOIN 
                
                (SELECT Proveedor.numero AS numeroProveedor, 
                Proveedor.nombre AS nombreProveedor, 
                SUM(Orden.monto) AS subtotal 
                FROM Orden 
                INNER JOIN Proveedor 
                ON Orden.numeroProveedor = Proveedor.numero 
                WHERE 
                SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
                GROUP BY 
                Proveedor.numero) as year2 
                
                ON year1.numeroProveedor = year2.numeroProveedor"
                
            )->fetchAll(2);
        }

        $result=[];

        foreach ($query as $row) {

            $line=[];
            $line['numeroProveedor']=$row['numeroProveedor'];
            $line['nombreProveedor']=$row['nombreProveedor'];
            $line['subtotal2018']=floatval($row['subtotal2018']);
            $line['subtotal2019']=floatval($row['subtotal2019']);
            unset($row);
            $result[]=$line;
        }

        return $result;

    }

}

?>