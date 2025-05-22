<?php
// historialEstado.php
// Recibe: id_articulo, estado_anterior, estado_nuevo, usuario, fecha_hora
// Guarda el cambio de estado en la tabla historial_estados
header('Content-Type: application/json');
include 'conexion.php'; // Debe contener la conexión $conn

$data = json_decode(file_get_contents('php://input'), true);
$id_articulo = $data['id_articulo'] ?? null;
$estado_anterior = $data['estado_anterior'] ?? null;
$estado_nuevo = $data['estado_nuevo'] ?? null;
$usuario = $data['usuario'] ?? 'sistema';
// Forzar zona horaria correcta (Honduras, por ejemplo)
if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set('America/Tegucigalpa');
}
$fecha_hora = date('Y-m-d H:i:s');

if ($id_articulo && $estado_anterior && $estado_nuevo) {
    $stmt = $conn->prepare("INSERT INTO historial_estados (id_articulo, estado_anterior, estado_nuevo, usuario, fecha_hora) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('issss', $id_articulo, $estado_anterior, $estado_nuevo, $usuario, $fecha_hora);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
$conn->close();
