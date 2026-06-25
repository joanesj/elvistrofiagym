<?php
session_start();
require_once __DIR__ . '/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /miembro_form.php');
    exit;
}

$nombre           = trim($_POST['nombre'] ?? '');
$apellido         = trim($_POST['apellido'] ?? '');
$telefono         = trim($_POST['telefono'] ?? '');
$plan             = $_POST['plan'] ?? '';
$fechaInscripcion = $_POST['fecha_inscripcion'] ?? date('Y-m-d');

if ($nombre === '' || $apellido === '' || $plan === '') {
    $_SESSION['error_miembro'] = 'Nombre, apellido y plan son obligatorios.';
    header('Location: /miembro_form.php');
    exit;
}

insertarMiembro($pdo, $nombre, $apellido, $telefono, $plan, $fechaInscripcion);

$_SESSION['mensaje_miembro'] = 'Miembro inscrito correctamente.';
header('Location: /listado.php');
exit;
