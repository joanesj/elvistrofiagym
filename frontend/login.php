<?php
$tituloPagina = 'Acceso';
require_once __DIR__ . '/includes/header.php';
?>

<section class="form-section">
    <div class="form-card">
        <h1>ACCESO</h1>

        <?php if (!empty($_SESSION['mensaje_login'])): ?>
            <p class="alerta alerta-exito">
                <?php echo htmlspecialchars($_SESSION['mensaje_login']); unset($_SESSION['mensaje_login']); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error_login'])): ?>
            <p class="alerta alerta-error">
                <?php echo htmlspecialchars($_SESSION['error_login']); unset($_SESSION['error_login']); ?>
            </p>
        <?php endif; ?>

        <form action="../backend/procesar_login.php" method="POST">
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <label class="checkbox-label">
                <input type="checkbox" name="recordar" checked> Mantenme conectado.
            </label>

            <button type="submit" class="btn btn-primary btn-full">ACCESO</button>
        </form>

        <p class="form-footer">¿Eres nuevo en ElvisTrofia? <a href="registro.php">Crear una cuenta</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
