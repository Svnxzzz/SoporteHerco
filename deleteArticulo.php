<?php
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'soporte_herco';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID no recibido.']);
    exit;
}
$id = intval($data['id']);

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión.']);
    exit;
}

// Eliminar historial antes de eliminar el artículo
$stmtHistorial = $conn->prepare("DELETE FROM historial_estados WHERE id_articulo=?");
$stmtHistorial->bind_param('i', $id);
$stmtHistorial->execute();
$stmtHistorial->close();

$stmt = $conn->prepare("DELETE FROM articulos WHERE id=?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar.']);
}
$stmt->close();
$conn->close();
