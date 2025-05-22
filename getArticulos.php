<?php
session_start();
header('Content-Type: application/json');
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_herco";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, articulo, sucursal, entregado_por, recibido_por, tecnico_reparo, n_serie, accesorio, condicion, fecha_hora, estado, fecha_entregado, fecha_descartado, nota, fallo, activo FROM articulos ORDER BY fecha_hora ASC, id ASC";
$result = $conn->query($sql);

$articulos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }
}

echo json_encode($articulos);

$conn->close();
?>
