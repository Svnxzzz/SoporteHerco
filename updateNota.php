<?php
session_start();
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'soporte_herco';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    exit;
}
$id = intval($data['id']);

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión.']);
    exit;
}

if (isset($data['nota'])) {
    $nota = $data['nota'];
    $stmt = $conn->prepare("UPDATE articulos SET nota=? WHERE id=?");
    $stmt->bind_param('si', $nota, $id);
    $ok = $stmt->execute();
    $stmt->close();
} else if (isset($data['tecnico_reparo'])) {
    $tecnico_reparo = $data['tecnico_reparo'];
    $stmt = $conn->prepare("UPDATE articulos SET tecnico_reparo=? WHERE id=? AND (tecnico_reparo IS NULL OR tecnico_reparo = '')");
    $stmt->bind_param('si', $tecnico_reparo, $id);
    $ok = $stmt->execute();
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Campo no soportado.']);
    $conn->close();
    exit;
}

if ($ok) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar.']);
}
$conn->close();
?>
