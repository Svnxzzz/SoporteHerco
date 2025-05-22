<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['usuario'], $data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    exit;
}
$usuario = $data['usuario'];
$password = $data['password'];
$usuarios = json_decode(file_get_contents('usuarios.json'), true);
$found = false;
foreach ($usuarios as $u) {
    if ($u['usuario'] === $usuario && $u['password'] === $password) {
        $found = true;
        break;
    }
}
if ($found) {
    session_start();
    $_SESSION['usuario'] = $usuario;
    echo json_encode(['status' => 'success', 'usuario' => $usuario]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos.']);
}
