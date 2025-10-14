<?php
$host = "marketperu.database.windows.net";  // servidor SQL
$dbname = "supermercado";                   // base de datos
$user = "adminsql";              
$pass = "Sql1908.";                
try {
    $conn = new PDO("sqlsrv:server=$host;Database=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a SQL Server en Azure!";
} catch (PDOException $e) {
    echo "Error al conectar: " . $e->getMessage();
}
