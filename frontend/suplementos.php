<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

$tituloPagina = 'Suplementos';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../backend/funciones.php';

$categoria_filtro = intval($_GET['categoria'] ?? 0);
$busqueda = trim($_GET['buscar'] ?? '');

$suplementos = obtenerSuplementos($pdo, $categoria_filtro, $busqueda);
$categorias = obtenerCategorias($pdo);
?>

<section class="hero hero-sm">
    <div class="hero-content">
        <h1>SUPLEMENTOS</h1>
        <p>Potencia tu rendimiento con los mejores productos del mercado.</p>
    </div>
</section>

<section class="listado-section">

    <form method="GET" action="" class="sup-filtros no-print">
        <input type="text" name="buscar" placeholder="Buscar suplemento..."
            value="<?php echo htmlspecialchars($busqueda); ?>" class="sup-input-buscar">
        <select name="categoria" class="sup-select">
            <option value="0">Todas las categorías</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo $categoria_filtro == $cat['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <?php if ($busqueda || $categoria_filtro): ?>
            <a href="suplementos.php" class="btn btn-outline-dark">✕ Limpiar</a>
        <?php endif; ?>
    </form>

    <?php if (empty($suplementos)): ?>
        <p style="color:var(--texto-suave); margin-top:30px;">
            No se encontraron suplementos con esos criterios.
            <a href="suplementos.php">Ver todos</a>.
        </p>
    <?php else: ?>
        <div class="sup-grid">
            <?php foreach ($suplementos as $s): ?>
                <div class="sup-card">

                    <div class="sup-card-img">
                        <?php

                        $nombre_imagen = $s['imagen'] ? trim($s['imagen']) : '';
                        $ruta_fisica = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'suplementos' . DIRECTORY_SEPARATOR . $nombre_imagen;

                        if (!empty($nombre_imagen) && file_exists($ruta_fisica)):
                            ?>
                            <img src="uploads/suplementos/<?php echo htmlspecialchars($nombre_imagen); ?>"
                                alt="<?php echo htmlspecialchars($s['nombre']); ?>">
                        <?php else: ?>
                            <div class="sup-img-placeholder">💊</div>
                        <?php endif; ?>

                        <?php if (!empty($s['categoria_nombre'])): ?>
                            <span class="sup-badge-cat">
                                <?php echo htmlspecialchars($s['categoria_nombre']); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="sup-card-body">
                        <h3 class="sup-nombre">
                            <?php echo htmlspecialchars($s['nombre']); ?>
                        </h3>
                        <p class="sup-desc">
                            <?php echo htmlspecialchars($s['descripcion']); ?>
                        </p>

                        <div class="sup-card-footer">
                            <span class="sup-precio">$
                                <?php echo number_format($s['precio'], 2); ?>
                            </span>
                            <span class="sup-stock <?php echo $s['stock'] > 0 ? 'en-stock' : 'agotado'; ?>">
                                <?php echo $s['stock'] > 0 ? "En stock ({$s['stock']})" : "Agotado"; ?>
                            </span>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>