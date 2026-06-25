<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($tituloPagina) ? $tituloPagina . ' | ElvisTrofia' : 'ElvisTrofia'; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header class="site-header">
    <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <a href="index.php" class="logo">ELVIS<span>TROFIA</span></a>

    <a
        href="<?php echo isset($_SESSION['usuario_id']) ? '../backend/logout.php' : 'login.php'; ?>"
        class="login-icon"
        title="<?php echo isset($_SESSION['usuario_id'])
            ? 'Cerrar sesión (' . htmlspecialchars($_SESSION['usuario_nombre']) . ')'
            : 'Iniciar sesión'; ?>"
    >
        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
            <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.3c-3.3 0-9.7 1.6-9.7 4.9V21h19.4v-1.5c0-3.3-6.4-4.9-9.7-4.9z"/>
        </svg>
    </a>
</header>

<nav class="overlay-menu" id="overlayMenu">
    <div class="overlay-menu-header">
        <span class="logo">ELVIS<span>TROFIA</span></span>
        <button class="menu-close" id="menuClose" aria-label="Cerrar menú">&times;</button>
    </div>
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="suplementos.php">Suplementos</a></li>
        <li><a href="miembro_form.php">Inscribir Miembro</a></li>
        <li><a href="listado.php">Listado de Miembros</a></li>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <li class="separador">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></li>
            <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                <li><a href="admin_suplementos.php">⚙ Admin Suplementos</a></li>
            <?php endif; ?>
            <li><a href="/backend/logout.php">Cerrar sesión</a></li>
        <?php else: ?>
            <li><a href="login.php">Acceso</a></li>
            <li><a href="registro.php">Crear una cuenta</a></li>
        <?php endif; ?>
    </ul>
</nav>

<main>
