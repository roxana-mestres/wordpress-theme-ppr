<footer class="footer">
    <div class="footer-contenido">
        <div class="footer-imagen">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-image.svg" alt="Imagen footer">
        </div>
        <div class="footer-texto">
            <h3 class="footer-titulo">Palabras para recordar</h3>
            <p class="footer-descripcion">
                Página web diseñada por
                <a href="https://www.roxana-mestres.com" target="_blank" rel="noopener noreferrer">Roxana Mestres</a>
            </p>
        </div>
        <div class="footer-contacto">
            <p>Contactar :</p>
            <div class="contacto-iconos">
                <a href="https://www.instagram.com/roxanebravorivera?igsh=MzRlODBiNWFlZA==" class="contacto-icono" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/instagram-icon.svg" alt="Instagram">
                </a>
                <a href="https://www.facebook.com/roxane.bravorivera" class="contacto-icono" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook-icon.svg" alt="Facebook">
                </a>
                <a href="#" class="contacto-icono" onclick="copiarCorreo()">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/email-icon.svg" alt="Enviar email a Roxane Bravo Rivera">
                </a>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>