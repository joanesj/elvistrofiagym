<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

require_once 'sql/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: /listado.php?msg=UsuarioEliminado");
    } else {
        echo "Error al intentar eliminar.";
    }
}
?>