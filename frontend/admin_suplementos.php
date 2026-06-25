<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();


if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$tituloPagina = 'Admin — Suplementos';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../backend/funciones.php';

$mensaje = $_SESSION['msg_suplemento'] ?? '';
$msg_tipo = $_SESSION['msg_tipo'] ?? '';
unset($_SESSION['msg_suplemento'], $_SESSION['msg_tipo']);


$editar = null;
if (isset($_GET['editar'])) {
    $editar = obtenerSuplemento($pdo, intval($_GET['editar']));
}

$todos = obtenerTodosSuplemenos($pdo);
$categorias = obtenerCategorias($pdo);
?>

<section class="listado-section">


    <div class="listado-encabezado">
        <h1><?php echo $editar ? 'EDITAR SUPLEMENTO' : 'GESTIÓN DE SUPLEMENTOS'; ?></h1>
        <a href="suplementos.php" class="btn btn-primary no-print" target="_blank">VER TIENDA</a>
    </div>


    <?php if ($mensaje): ?>
        <p class="alerta alerta-<?php echo htmlspecialchars($msg_tipo); ?> no-print">
            <?php echo htmlspecialchars($mensaje); ?>
        </p>
    <?php endif; ?>

    <div class="form-section no-print" style="justify-content:flex-start; padding-top:0;">
        <div class="form-card" style="max-width:620px;">
            <h2 style="font-size:1.2rem; margin-bottom:18px;">
                <?php echo $editar ? '✏️ Editar producto' : '➕ Agregar nuevo suplemento'; ?>
            </h2>

            <form method="POST" action="/backend/procesar_suplemento.php" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="<?php echo $editar ? 'editar' : 'crear'; ?>">
                <input type="hidden" name="id" value="<?php echo $editar['id'] ?? 0; ?>">
                <input type="hidden" name="imagen_actual"
                    value="<?php echo htmlspecialchars($editar['imagen'] ?? ''); ?>">

                <label>Nombre del producto *</label>
                <input type="text" name="nombre" required maxlength="150"
                    value="<?php echo htmlspecialchars($editar['nombre'] ?? ''); ?>"
                    placeholder="Ej: Whey Protein Gold Standard">

                <label>Descripción</label>
                <textarea name="descripcion" rows="3"
                    style="width:100%;padding:12px 14px;border:1px solid var(--borde);border-radius:8px;font-size:1rem;font-family:var(--fuente-texto);resize:vertical;"
                    placeholder="Descripción breve del producto..."><?php echo htmlspecialchars($editar['descripcion'] ?? ''); ?></textarea>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div>
                        <label>Precio ($) *</label>
                        <input type="number" name="precio" required min="0" step="0.01"
                            value="<?php echo $editar['precio'] ?? ''; ?>" placeholder="0.00">
                    </div>
                    <div>
                        <label>Stock *</label>
                        <input type="number" name="stock" required min="0" value="<?php echo $editar['stock'] ?? 0; ?>">
                    </div>
                </div>

                <label>Categoría</label>
                <select name="categoria_id">
                    <option value="">— Sin categoría —</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($editar['categoria_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Imagen (máx 5MB · jpg, png, webp)</label>
                <?php if (!empty($editar['imagen']) && file_exists(__DIR__ . '/uploads/suplementos/' . $editar['imagen'])): ?>
                    <div style="margin-bottom:10px;">
                        <img src="uploads/suplementos/<?php echo htmlspecialchars($editar['imagen']); ?>"
                            style="height:90px;border-radius:8px;border:2px solid var(--borde);object-fit:cover;" alt="">
                        <small style="display:block;color:var(--texto-suave);margin-top:4px;">Imagen actual — sube una nueva
                            para reemplazarla</small>
                    </div>
                <?php endif; ?>
                <input type="file" name="imagen" accept="image/*" id="inputImagen" style="padding:8px 0;">
                <div id="previewNueva"></div>

                <label class="checkbox-label" style="margin-top:16px;">
                    <input type="checkbox" name="activo" value="1" <?php echo (!$editar || $editar['activo']) ? 'checked' : ''; ?>>
                    Producto activo (visible en tienda)
                </label>

                <div style="display:flex;gap:12px;margin-top:10px;">
                    <button type="submit" class="btn btn-primary btn-full">
                        <?php echo $editar ? ' GUARDAR CAMBIOS' : ' AGREGAR SUPLEMENTO'; ?>
                    </button>
                    <?php if ($editar): ?>
                        <a href="admin_suplementos.php" class="btn btn-outline-dark">Cancelar</a>
                    <?php endif; ?>
                </div>

            </form>
        </div>
    </div>

    <h2 style="font-size:1.2rem; margin:30px 0 14px;">PRODUCTOS REGISTRADOS</h2>

    <?php if (empty($todos)): ?>
        <p style="color:var(--texto-suave);">Aún no hay suplementos registrados.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table class="tabla-listado">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="no-print">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos as $s): ?>
                        <tr style="<?php echo !$s['activo'] ? 'opacity:.55;' : ''; ?>">
                            <td>
                                <?php
                                $ri = __DIR__ . '/uploads/suplementos/' . $s['imagen'];
                                if ($s['imagen'] && file_exists($ri)):
                                    ?>
                                    <img src="uploads/suplementos/<?php echo htmlspecialchars($s['imagen']); ?>"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid var(--borde);"
                                        alt="">
                                <?php else: ?>
                                    <span style="font-size:1.8rem;">💊</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($s['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($s['categoria_nombre'] ?? '—'); ?></td>
                            <td>$<?php echo number_format($s['precio'], 2); ?></td>
                            <td>
                                <span style="
                            padding:3px 10px;border-radius:20px;font-size:.8rem;font-weight:700;
                            background:<?php echo $s['stock'] > 0 ? '#e6f4ea' : '#fde8e8'; ?>;
                            color:<?php echo $s['stock'] > 0 ? '#1e6b34' : '#9b1c1c'; ?>;">
                                    <?php echo $s['stock']; ?>
                                </span>
                            </td>
                            <td>
                                <span style="
                            padding:3px 10px;border-radius:20px;font-size:.78rem;font-weight:700;
                            background:<?php echo $s['activo'] ? '#e6f4ea' : '#f2f2f2'; ?>;
                            color:<?php echo $s['activo'] ? '#1e6b34' : '#5a5a5a'; ?>;">
                                    <?php echo $s['activo'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td class="no-print">
                                <a href="admin_suplementos.php?editar=<?php echo $s['id']; ?>"
                                    class="btn-accion editar">Editar</a>
                                <a href="../backend/procesar_suplemento.php?accion=eliminar&id=<?php echo $s['id']; ?>"
                                    class="btn-accion eliminar"
                                    onclick="return confirm('¿Eliminar este suplemento? Esta acción no se puede deshacer.')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</section>

<script>
    // Vista previa de imagen
    const inp = document.getElementById('inputImagen');
    const prev = document.getElementById('previewNueva');
    if (inp && prev) {
        inp.addEventListener('change', function () {
            prev.innerHTML = '';
            const f = this.files[0];
            if (!f || !f.type.startsWith('image/')) return;
            const r = new FileReader();
            r.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'height:80px;margin-top:8px;border-radius:8px;border:2px dashed var(--azul);object-fit:cover;';
                prev.appendChild(img);
            };
            r.readAsDataURL(f);
        });
    }
    // Auto-ocultar alerta
    const al = document.querySelector('.alerta');
    if (al) setTimeout(() => { al.style.transition = 'opacity .5s'; al.style.opacity = '0'; setTimeout(() => al.remove(), 500); }, 4000);
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>