<?php
require_once __DIR__ . '/config.php';



function registrarUsuario($pdo, $nombre, $apellido, $fechaNacimiento, $correo, $password)
{
    $sql = "INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, correo, password)
            VALUES (:nombre, :apellido, :fecha_nacimiento, :correo, :password)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':fecha_nacimiento' => $fechaNacimiento,
        ':correo' => $correo,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
}

function correoExiste($pdo, $correo)
{
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $correo]);

    return $stmt->fetch() !== false;
}

function validarLogin($pdo, $correo, $password)
{
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $correo]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        return $usuario;
    }

    return false;
}


function insertarMiembro($pdo, $nombre, $apellido, $telefono, $plan, $fechaInscripcion)
{
    $sql = "INSERT INTO miembros (nombre, apellido, telefono, plan, fecha_inscripcion)
            VALUES (:nombre, :apellido, :telefono, :plan, :fecha_inscripcion)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':telefono' => $telefono,
        ':plan' => $plan,
        ':fecha_inscripcion' => $fechaInscripcion,
    ]);
}

function obtenerMiembros($pdo)
{
    $stmt = $pdo->query("SELECT * FROM miembros ORDER BY id DESC");

    return $stmt->fetchAll();
}



function obtenerCategorias($pdo)
{
    $stmt = $pdo->query("SELECT * FROM categorias_suplementos ORDER BY nombre ASC");
    return $stmt->fetchAll();
}

function obtenerSuplemento($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM suplementos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function obtenerSuplementos($pdo, $categoria_id = 0, $busqueda = '')
{
    $where = "WHERE s.activo = 1";
    $params = [];

    if ($categoria_id > 0) {
        $where .= " AND s.categoria_id = :cat";
        $params[':cat'] = $categoria_id;
    }
    if ($busqueda !== '') {
        $where .= " AND (s.nombre LIKE :bus OR s.descripcion LIKE :bus2)";
        $params[':bus'] = "%$busqueda%";
        $params[':bus2'] = "%$busqueda%";
    }

    $stmt = $pdo->prepare("
        SELECT s.*, c.nombre AS categoria_nombre
        FROM suplementos s
        LEFT JOIN categorias_suplementos c ON s.categoria_id = c.id
        $where
        ORDER BY s.nombre ASC
    ");
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function obtenerTodosSuplemenos($pdo)
{
    $stmt = $pdo->query("
        SELECT s.*, c.nombre AS categoria_nombre
        FROM suplementos s
        LEFT JOIN categorias_suplementos c ON s.categoria_id = c.id
        ORDER BY s.creado_en DESC
    ");
    return $stmt->fetchAll();
}

function guardarSuplemento($pdo, $datos, $id = 0)
{
    if ($id > 0) {
        $stmt = $pdo->prepare("
            UPDATE suplementos SET
                nombre       = :nombre,
                descripcion  = :descripcion,
                precio       = :precio,
                stock        = :stock,
                categoria_id = :categoria_id,
                imagen       = :imagen,
                activo       = :activo
            WHERE id = :id
        ");
        $datos[':id'] = $id;
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO suplementos (nombre, descripcion, precio, stock, categoria_id, imagen, activo)
            VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen, :activo)
        ");
    }
    return $stmt->execute($datos);
}

function eliminarSuplemento($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM suplementos WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

function subirImagenSuplemento($archivo, $carpeta)
{
    $permitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($archivo['type'], $permitidos))
        return false;
    if ($archivo['size'] > 5 * 1024 * 1024)
        return false;

    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombre = uniqid('sup_', true) . '.' . strtolower($ext);
    $destino = $carpeta . $nombre;

    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
        return $nombre;
    }
    return false;
}
