<?php
$tituloPagina = 'Crear una cuenta';
require_once __DIR__ . '/includes/header.php';
?>

<section class="form-section">
    <div class="form-card">
        <h1>CREAR UNA CUENTA</h1>

        <?php if (!empty($_SESSION['errores_registro'])): ?>
            <div class="alerta alerta-error">
                <ul>
                <?php foreach ($_SESSION['errores_registro'] as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; unset($_SESSION['errores_registro']); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/backend/procesar_registro.php" method="POST" id="formRegistro">
            <label for="nombre">Nombre de pila</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>

            <label>Fecha de nacimiento</label>
            <div class="fecha-grupo">
                <select name="mes" required>
                    <option value="">Mes</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="dia" required>
                    <option value="">Día</option>
                    <?php for ($d = 1; $d <= 31; $d++): ?>
                        <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="anio" required>
                    <option value="">Año</option>
                    <?php for ($a = (int) date('Y'); $a >= 1940; $a--): ?>
                        <option value="<?php echo $a; ?>"><?php echo $a; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required minlength="6">

            <label for="confirmar_password">Confirmar Contraseña</label>
            <input type="password" id="confirmar_password" name="confirmar_password" required minlength="6">

            <button type="submit" class="btn btn-primary btn-full">CREAR UNA CUENTA</button>
        </form>

        <p class="form-footer">¿Ya tienes una cuenta? <a href="login.php">Acceso</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
