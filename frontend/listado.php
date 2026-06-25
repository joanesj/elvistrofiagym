<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$tituloPagina = 'Listado de Miembros';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../backend/funciones.php';

$miembros = obtenerMiembros($pdo);
?>

<section class="listado-section">
    <div class="listado-encabezado">
        <h1>LISTADO DE MIEMBROS</h1>
        <button type="button" onclick="window.print()" class="btn btn-primary no-print">IMPRIMIR LISTADO</button>
    </div>

    <?php if (!empty($_SESSION['mensaje_miembro'])): ?>
        <p class="alerta alerta-exito no-print">
            <?php echo htmlspecialchars($_SESSION['mensaje_miembro']);
            unset($_SESSION['mensaje_miembro']); ?>
        </p>
    <?php endif; ?>

    <?php if (empty($miembros)): ?>
        <p>Aún no hay miembros inscritos. <a href="miembro_form.php">Inscribe el primero</a>.</p>
    <?php else: ?>
        <table class="tabla-listado">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Plan</th>
                    <th>Fecha inscripción</th>
                    <th>Estado</th>
                    <th class="no-print">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($miembros as $m): ?>
                    <tr>
                        <td>
                            <?php echo $m['id']; ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['nombre']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['apellido']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['telefono']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['plan']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['fecha_inscripcion']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($m['estado']); ?>
                        </td>
                        <td class="no-print">
                            <a href="miembro_form.php?id=<?php echo $m['id']; ?>" class="btn-accion editar">Editar</a>
                            <a href="../backend/eliminar_miembro.php?id=<?php echo $m['id']; ?>" class="btn-accion eliminar"
                                onclick="return confirm('¿Seguro que deseas eliminar a este miembro?')">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>