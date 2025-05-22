<?php
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'soporte_herco';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'], $data['estado'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    exit;
}
$id = intval($data['id']);
$estado = $data['estado'];

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión.']);
    exit;
}
if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set('America/Tegucigalpa');
}
// Obtener usuario de sesión si existe
session_start();
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$stmt = null;
$fecha_actual = date('Y-m-d H:i:s');
if (in_array($estado, ['entregado', 'descartado', 'terminado']) && $usuario) {
    // Registrar técnico que reparó si está vacío
    $stmtCheck = $conn->prepare("SELECT tecnico_reparo FROM articulos WHERE id=?");
    $stmtCheck->bind_param('i', $id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($tecnico_reparo);
    $stmtCheck->fetch();
    $stmtCheck->close();
    if ($tecnico_reparo === null || $tecnico_reparo === '') {
        $stmtTec = $conn->prepare("UPDATE articulos SET tecnico_reparo=? WHERE id=?");
        $stmtTec->bind_param('si', $usuario, $id);
        $stmtTec->execute();
        $stmtTec->close();
    }
}
if ($estado === 'entregado') {
    $stmt = $conn->prepare("UPDATE articulos SET estado=?, fecha_entregado=? WHERE id=?");
    $stmt->bind_param('ssi', $estado, $fecha_actual, $id);
} else if ($estado === 'descartado') {
    $stmt = $conn->prepare("UPDATE articulos SET estado=?, fecha_descartado=? WHERE id=?");
    $stmt->bind_param('ssi', $estado, $fecha_actual, $id);
} else {
    $stmt = $conn->prepare("UPDATE articulos SET estado=? WHERE id=?");
    $stmt->bind_param('si', $estado, $id);
}
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar.']);
}
$stmt->close();
$conn->close();
