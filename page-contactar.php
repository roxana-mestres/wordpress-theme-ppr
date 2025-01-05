<?php include 'header.php'; ?>

<main class="pagina-contacto">
    <!-- BORDES HORIZONTALES -->
    <div class="borde-arriba">
    </div>
    <div class="borde-abajo">
    </div>

    <!-- BORDES VERTICALES -->
    <div class="borde-izquierda">
    </div>
    <div class="borde-derecha">
    </div>
    <!-- FONDO -->
    <div class="fondo-contacto">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fondo-contacto.svg" alt="Fondo contacto decorativo">
    </div>
    <!-- FORMULARIO -->
    <section class="formulario-contacto">
        <div class="titulo">
            <h1>¡Escríbeme!</h1>
        </div>
        <form id="formulario-contacto">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

            <div class="contenedor-boton">
                <button type="submit">Enviar</button>
            </div>
        </form>
        <!-- ESTAMPILLAS -->
        <div class="estampillas">
            <img class="estampilla-cuadrada" src="<?php echo get_template_directory_uri(); ?>/assets/images/estampilla-icono.svg" alt="Estampilla decorativa">
            <img class="estampilla-redonda" src="<?php echo get_template_directory_uri(); ?>/assets/images/estampilla-dos-icono.svg" alt="Estampilla decorativa adicional">
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>