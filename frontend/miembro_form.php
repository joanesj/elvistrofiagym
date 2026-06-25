<?php
$tituloPagina = 'Inscribir Miembro';
require_once __DIR__ . '/includes/header.php';
?>

<section class="form-section">
    <div class="form-card">
        <h1>INSCRIBIR MIEMBRO</h1>
        <p class="subtitulo">Registra un nuevo miembro del gimnasio en el sistema.</p>

        <?php if (!empty($_SESSION['error_miembro'])): ?>
            <p class="alerta alerta-error">
                <?php echo htmlspecialchars($_SESSION['error_miembro']);
                unset($_SESSION['error_miembro']); ?>
            </p>
        <?php endif; ?>

        <form action="../backend/procesar_miembro.php" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" placeholder="809-000-0000">

            <label for="plan">Plan</label>
            <select id="plan" name="plan" required>
                <option value="">Selecciona un plan</option>
                <option value="Mensual">Mensual</option>
                <option value="Trimestral">Trimestral</option>
                <option value="Semestral">Semestral</option>
                <option value="Anual">Anual</option>
            </select>

            <label for="fecha_inscripcion">Fecha de inscripción</label>
            <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" value="<?php echo date('Y-m-d'); ?>"
                required>

            <button type="submit" class="btn btn-primary btn-full">INSCRIBIR MIEMBRO</button>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>