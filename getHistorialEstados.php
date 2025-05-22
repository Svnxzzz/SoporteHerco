<?php
// getHistorialEstados.php
header('Content-Type: application/json');
include 'conexion.php';
$data = json_decode(file_get_contents('php://input'), true);
$id_articulo = $data['id_articulo'] ?? null;
if ($id_articulo) {
    $stmt = $conn->prepare("SELECT fecha_hora, estado_anterior, estado_nuevo, usuario FROM historial_estados WHERE id_articulo = ? ORDER BY fecha_hora DESC");
    $stmt->bind_param('i', $id_articulo);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    // Forzar encabezados y codificación correcta
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
    $stmt->close();
} else {
    echo json_encode([]);
}
$conn->close();
