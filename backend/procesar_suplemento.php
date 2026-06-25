<?php

session_start();
require_once __DIR__ . '/funciones.php';


if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../frontend/index.php');
    exit;
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';


if ($accion === 'eliminar' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sup = obtenerSuplemento($pdo, $id);
    if ($sup && $sup['imagen']) {
        $ruta = __DIR__ . '/../frontend/uploads/suplementos/' . $sup['imagen'];
        if (file_exists($ruta))
            unlink($ruta);
    }
    eliminarSuplemento($pdo, $id);
    $_SESSION['msg_suplemento'] = 'Suplemento eliminado correctamente.';
    $_SESSION['msg_tipo'] = 'exito';
    header('Location: ../frontend/admin_suplementos.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($accion, ['crear', 'editar'])) {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categoria_id = intval($_POST['categoria_id'] ?? 0) ?: null;
    $activo = isset($_POST['activo']) ? 1 : 0;
    $imagen_actual = $_POST['imagen_actual'] ?? '';
    $imagen_nombre = $imagen_actual;


    if (empty($nombre) || $precio < 0 || $stock < 0) {
        $_SESSION['msg_suplemento'] = 'Por favor completa todos los campos obligatorios.';
        $_SESSION['msg_tipo'] = 'error';
        $redir = $id > 0 ? "admin_suplementos.php?editar=$id" : 'admin_suplementos.php';
        header("Location: ../frontend/$redir");
        exit;
    }


    if (!empty($_FILES['imagen']['name'])) {
        $carpeta = __DIR__ . '/../frontend/uploads/suplementos/';
        $nuevo = subirImagenSuplemento($_FILES['imagen'], $carpeta);
        if ($nuevo) {

            if ($imagen_actual && file_exists($carpeta . $imagen_actual)) {
                unlink($carpeta . $imagen_actual);
            }
            $imagen_nombre = $nuevo;
        } else {
            $_SESSION['msg_suplemento'] = 'Imagen no válida (máx 5MB, formatos: jpg, png, webp, gif).';
            $_SESSION['msg_tipo'] = 'error';
            $redir = $id > 0 ? "admin_suplementos.php?editar=$id" : 'admin_suplementos.php';
            header("Location: ../frontend/$redir");
            exit;
        }
    }

    $datos = [
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':stock' => $stock,
        ':categoria_id' => $categoria_id,
        ':imagen' => $imagen_nombre,
        ':activo' => $activo,
    ];

    guardarSuplemento($pdo, $datos, $id);

    $_SESSION['msg_suplemento'] = $id > 0 ? 'Suplemento actualizado correctamente.' : 'Suplemento agregado correctamente.';
    $_SESSION['msg_tipo'] = 'exito';
    header('Location: ../frontend/admin_suplementos.php');
    exit;
}


header('Location: ../frontend/admin_suplementos.php');
exit;
