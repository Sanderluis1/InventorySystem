</div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="copyright float-right">
            Antonquia
            &copy;
                <div id="year"></div>
                <script>
                document.getElementById("year").innerHTML = `${new Date().getFullYear()}`;
                </script>
            <a href="#" target="_blank"></a>
        </div>
    </div>
</footer>
</div>
</div>
<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/material-dashboard.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap-notify.js"></script>
<script src="../assets/js/arrive.min.js"></script>
<script src="../assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="../assets/js/jquery-ui/jquery-ui.min.js"></script>
<script src="../assets/js/chart.min.js"></script>
<script src="../assets/js/funciones.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentUrl = window.location.href;

    // Encontrar el enlace activo y desplazar la barra de desplazamiento
    const activeLink = Array.from(navLinks).find(link => link.href === currentUrl);
    if (activeLink) {
        activeLink.classList.add('active');
        activeLink.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'start' }); // Desplazamiento sin animación
    }

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace

            // Remover la clase 'active' de todos los enlaces
            navLinks.forEach(navLink => navLink.classList.remove('active'));

            // Agregar la clase 'active' al enlace clickeado
            link.classList.add('active');

            // Desplazar la barra hasta que el enlace activo esté visible sin animación
            link.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'start' });

            // Obtener la URL del enlace clickeado
            const url = link.getAttribute('href');

            // Actualizar la URL en la barra de direcciones sin recargar la página
            window.history.pushState({}, '', url);

            // Redirigir a la página correspondiente
            window.location.href = url;
        });
    });

    // Manejar los eventos de cambio de URL
    window.addEventListener('popstate', () => {
        const currentUrl = window.location.href;
        const activeLink = Array.from(navLinks).find(link => link.href === currentUrl);
        if (activeLink) {
            activeLink.classList.add('active');
            activeLink.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'start' }); // Desplazamiento sin animación
        }
    });
});


</script>
</body>

</html>