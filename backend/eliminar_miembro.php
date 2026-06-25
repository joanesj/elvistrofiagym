<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso denegado.");
}


require_once __DIR__ . '/funciones.php';

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt = $pdo->prepare("DELETE FROM miembros WHERE id = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['mensaje_miembro'] = "Miembro eliminado correctamente.";
    } else {
        $_SESSION['mensaje_miembro'] = "Error al intentar eliminar el miembro.";
    }
}

header('Location: /listado.php');
exit;