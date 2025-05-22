<?php
// Limpia cualquier buffer de salida previo
while (ob_get_level()) { ob_end_clean(); }
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soporte_herco";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['articulo'], $data['sucursal'], $data['entregado_por'], $data['recibido_por'], $data['n_serie'], $data['accesorio'], $data['condicion'], $data['fecha_hora'], $data['estado'], $data['fallo'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    exit;
}

$articulo = $data['articulo'];
$sucursal = $data['sucursal'];
$entregado_por = $data['entregado_por'];
$recibido_por = isset($data['recibido_por']) ? $data['recibido_por'] : null;
$tecnico_reparo = null;
$n_serie = $data['n_serie'];
$accesorio = $data['accesorio'];
$condicion = $data['condicion'];
$fecha_hora = $data['fecha_hora'];
$estado = $data['estado'];
$fallo = $data['fallo'];

// Convertir fecha_hora a formato DATETIME de MySQL
$fecha_hora = str_replace('T', ' ', $fecha_hora);

$stmt = $conn->prepare("INSERT INTO articulos (articulo, sucursal, entregado_por, recibido_por, tecnico_reparo, n_serie, accesorio, condicion, fecha_hora, estado, fallo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Error en la preparación de la consulta.", "mysql_error" => $conn->error]);
    $conn->close();
    exit;
}
$stmt->bind_param('sssssssssss', $articulo, $sucursal, $entregado_por, $recibido_por, $tecnico_reparo, $n_serie, $accesorio, $condicion, $fecha_hora, $estado, $fallo);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Artículo registrado correctamente!"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo registrar el artículo.", "mysql_error" => $stmt->error]);
}

$stmt->close();
$conn->close();
exit;
