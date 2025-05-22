<?php
session_start();
if (isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'success', 'usuario' => $_SESSION['usuario']]);
} else {
    echo json_encode(['status' => 'error']);
}
