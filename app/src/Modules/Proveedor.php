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
    public function search(){
        
        $query= $this->database->query("SELECT Proveedor.numero AS numeroProveedor, 
        Proveedor.nombre AS nombreProveedor, 
        SUM(Orden.monto) AS subtotal, 
        COUNT(Orden.codigoPep) AS conteoPep 
        FROM Orden 
        INNER JOIN Proveedor 
        ON Orden.numeroProveedor = Proveedor.numero
        GROUP BY Proveedor.numero")->fetchAll(2);

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

?>