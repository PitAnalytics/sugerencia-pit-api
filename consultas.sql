SELECT year1.numeroProveedor AS numeroProveedor, year1.nombreProveedor AS nombreProveedor, year1.subtotal AS subtotal2018, year2.subtotal AS subtotal2019

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

FULL OUTER JOIN 

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

ON year1.numeroProveedor= year2.numeroProveedor

--
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
GROUP BY 
Pep.codigo) as year1
        
RIGHT JOIN

(SELECT Pep.codigo AS codigoPep, 
Pep.descripcion AS descripcionPep,
SUM(Orden.monto) AS subtotal
FROM Orden
INNER JOIN Pep
ON Orden.codigoPep = Pep.codigo
WHERE
SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019'
GROUP BY 
Pep.codigo) as year2
        
ON year1.codigoPep=year2.codigoPep