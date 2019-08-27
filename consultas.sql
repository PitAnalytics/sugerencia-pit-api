--first level
SELECT 
* 
FROM

(SELECT year2.numeroProveedor AS numeroProveedor, 
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
LEFT JOIN 
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
ON year1.numeroProveedor = year2.numeroProveedor

UNION

SELECT year2.numeroProveedor AS numeroProveedor, year2.nombreProveedor AS nombreProveedor, year1.subtotal AS subtotal2018, year2.subtotal AS subtotal2019 

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
WHERE 1
ORDER BY numeroProveedor

--------------------------------------------------------------------
--------------------------------------------------------------------

SELECT * 
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
AND Orden.numeroProveedor = '100986' 
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
AND Orden.numeroProveedor = '100986' 
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
AND Orden.numeroProveedor = '100986' 
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
AND Orden.numeroProveedor = '100986' 
GROUP BY Pep.codigo) as year2
ON year1.codigoPep=year2.codigoPep) AS years

WHERE 1
ORDER BY codigoPep
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
SELECT 
year1.numeroPedido AS numeroPedido,
year1.conceptoPedido AS conceptoPedido,
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero) as year1
LEFT JOIN 
(SELECT 
Pedido.numero AS numeroPedido, 
Pedido.concepto AS conceptoPedido, 
SUM(Orden.monto) AS subtotal 
FROM Orden 
INNER JOIN Pedido 
ON Orden.numeroPedido = Pedido.numero 
WHERE 
SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero) as year2 
ON year1.numeroPedido= year2.numeroPedido

UNION

SELECT 
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero
ON year1.numeroPedido= year2.numeroPedido) as year2 
WHERE 1

SELECT * FROM 
(SELECT 
year1.numeroPedido AS numeroPedido,
year1.conceptoPedido AS conceptoPedido,
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero) as year1
LEFT JOIN 
(SELECT 
Pedido.numero AS numeroPedido, 
Pedido.concepto AS conceptoPedido, 
SUM(Orden.monto) AS subtotal 
FROM Orden 
INNER JOIN Pedido 
ON Orden.numeroPedido = Pedido.numero 
WHERE 
SUBSTR(CAST(Orden.fecha AS CHAR(10)),1,4) = '2019' 
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero) as year2 
ON year1.numeroPedido= year2.numeroPedido

UNION

SELECT 
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
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
AND Orden.codigoPep='GI-APL-CNL-B11-202-001' 
GROUP BY 
Pedido.numero) as year2 
ON year1.numeroPedido= year2.numeroPedido) AS years
WHERE conceptoPedido LIKE '%kjh%'
ORDER BY