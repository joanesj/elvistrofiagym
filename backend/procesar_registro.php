<?php
session_start();
require_once __DIR__ . '/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/registro.php');
    exit;
}

$nombre    = trim($_POST['nombre'] ?? '');
$apellido  = trim($_POST['apellido'] ?? '');
$mes       = $_POST['mes'] ?? '';
$dia       = $_POST['dia'] ?? '';
$anio      = $_POST['anio'] ?? '';
$correo    = trim($_POST['correo'] ?? '');
$password  = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar_password'] ?? '';

$errores = [];

if ($nombre === '' || $apellido === '' || $correo === '' || $password === '') {
    $errores[] = 'Todos los campos son obligatorios.';
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El correo electrónico no es válido.';
}

if ($password !== $confirmar) {
    $errores[] = 'Las contraseñas no coinciden.';
}

if (strlen($password) < 6) {
    $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
}

if (empty($errores) && correoExiste($pdo, $correo)) {
    $errores[] = 'Ya existe una cuenta registrada con ese correo.';
}

if (!empty($errores)) {
    $_SESSION['errores_registro'] = $errores;
    header('Location: ../frontend/registro.php');
    exit;
}

$fechaNacimiento = sprintf('%04d-%02d-%02d', (int) $anio, (int) $mes, (int) $dia);

registrarUsuario($pdo, $nombre, $apellido, $fechaNacimiento, $correo, $password);

$_SESSION['mensaje_login'] = 'Cuenta creada con éxito. Ahora puedes iniciar sesión.';
header('Location: ../frontend/login.php');
exit;
