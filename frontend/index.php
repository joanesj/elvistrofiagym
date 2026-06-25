<?php
$tituloPagina = 'Inicio';
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>SUPERA TUS LÍMITES.<br>CADA DÍA.</h1>
        <p>En ElvisTrofia combinamos entrenamiento funcional, fuerza y comunidad para ayudarte a alcanzar tu mejor versión, dentro y fuera del gimnasio.</p>
        <div class="hero-buttons">
            <a href="registro.php" class="btn btn-primary">Únete Ahora</a>
            <a href="miembro_form.php" class="btn btn-outline">Inscribir Miembro</a>
        </div>
    </div>
</section>

<section class="info-section">
    <h2>¿QUÉ ES ELVISTROFIA?</h2>
    <p>ElvisTrofia es un gimnasio enfocado en entrenamiento funcional de alta intensidad. Nuestros programas están diseñados para todos los niveles, desde principiantes hasta atletas avanzados, combinando fuerza, resistencia y movilidad en rutinas que nunca se repiten.</p>
</section>

<section class="cards-section">
    <div class="card">
        <h3>ENTRENAMIENTO FUNCIONAL</h3>
        <p>Rutinas variadas e intensas que mejoran tu fuerza, resistencia y movilidad.</p>
    </div>
    <div class="card">
        <h3>COMUNIDAD</h3>
        <p>Entrena junto a un equipo que te empuja a dar lo mejor de ti en cada sesión.</p>
    </div>
    <div class="card">
        <h3>COACHES CERTIFICADOS</h3>
        <p>Entrenadores capacitados que acompañan tu progreso de forma segura y personalizada.</p>
    </div>
</section>

<section class="cta-section">
    <h2>¿LISTO PARA EMPEZAR?</h2>
    <p>Crea tu cuenta o inscríbete como miembro hoy mismo.</p>
    <a href="registro.php" class="btn btn-primary">Crear una cuenta</a>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
