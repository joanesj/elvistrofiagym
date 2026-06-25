document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.getElementById('menuToggle');
    var menuClose = document.getElementById('menuClose');
    var overlayMenu = document.getElementById('overlayMenu');

    function abrirMenu() {
        overlayMenu.classList.add('activo');
        document.body.classList.add('menu-abierto');
        menuToggle.setAttribute('aria-expanded', 'true');
    }

    function cerrarMenu() {
        overlayMenu.classList.remove('activo');
        document.body.classList.remove('menu-abierto');
        menuToggle.setAttribute('aria-expanded', 'false');
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', abrirMenu);
    }

    if (menuClose) {
        menuClose.addEventListener('click', cerrarMenu);
    }

    // Cierra el menú al hacer clic en cualquier enlace dentro de él
    document.querySelectorAll('.overlay-menu a').forEach(function (enlace) {
        enlace.addEventListener('click', cerrarMenu);
    });

    // Cierra el menú con la tecla Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlayMenu.classList.contains('activo')) {
            cerrarMenu();
        }
    });

    // Validación: las contraseñas deben coincidir en el formulario de registro
    var formRegistro = document.getElementById('formRegistro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function (e) {
            var pass = document.getElementById('password').value;
            var confirmar = document.getElementById('confirmar_password').value;
            if (pass !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden.');
            }
        });
    }
});
