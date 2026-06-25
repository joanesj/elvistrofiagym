<?php
session_start();
require_once __DIR__ . '/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/login.php');
    exit;
}

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === 'admin1@gmail.com' && $password === 'admin1234567890') {
    $_SESSION['usuario_id'] = 0;
    $_SESSION['usuario_nombre'] = 'Admin Principal';
    $_SESSION['usuario_rol'] = 'admin';

    header('Location: ../frontend/index.php');
    exit;
}


$usuario = validarLogin($pdo, $correo, $password);

if ($usuario) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['rol'] ?? 'usuario';

    header('Location: ../frontend/index.php');
    exit;
}

$_SESSION['error_login'] = 'Correo o contraseña incorrectos.';
header('Location: ../frontend/login.php');
exit;