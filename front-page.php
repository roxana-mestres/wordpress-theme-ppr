<?php get_header(); ?>
<main>
    <section class="seccion-heroe">
        <div class="contenido-seccion-heroe">
            <h1 class="titulo-heroe">Palabras</h1>
            <h2 class="subtitulo-heroe">para recordar</h2>
            <p class="autor-heroe">Roxane Bravo Rivera</p>
        </div>
    </section>

    <!-- CATEGORÍAS -->
    <div class="categorias-letras">
        <!-- ENLACES CATEGORÍAS -->
        <div class="div-categorias">
            <?php
            $categorias_permitidas = ['Amor', 'Espiritualidad', 'Nostalgia', 'Paso del tiempo', 'Pérdida y duelo'];
            foreach ($categorias_permitidas as $categoria) {
                $categoria_obj = get_category_by_slug(sanitize_title($categoria));
                if ($categoria_obj) {
                    echo "<a href='" . esc_url(add_query_arg('categoria', $categoria_obj->slug, home_url())) . "'>" . esc_html($categoria) . "</a>";
                }
            }
            ?>
        </div>

        <!-- ENLACES LETRAS -->
        <div class="div-letras">
            <?php
            foreach (range('A', 'Z') as $letra) {
                echo "<a href='" . home_url("?letra=$letra") . "'>$letra</a>";
                if ($letra !== 'Z') {
                    echo " | ";
                }
            }
            ?>
        </div>
    </div>

<!-- ENTRADAS -->
    <!-- BUSCADOR -->
    <div class="buscador">
        <form method="get" action="<?php echo home_url("/") ?>" class="form-buscador">
            <div class="input-contenedor">
                <input type="text" name="s" class="input-buscador">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon.svg" alt="Buscar" class="icono-buscador">
            </div>
        </form>
    </div>
    <div class="ultimas-entradas">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        if (isset($_GET['letra']) && !empty($_GET['letra'])) {
            // FILTRO LETRAS
            $letra = sanitize_text_field($_GET['letra']);
            error_log("Letra recibida: " . $letra);

            add_filter('posts_where', 'filtrar_por_letra', 10, 2);
            $query = new WP_Query([
                'posts_per_page'   => 3,
                'paged'            => $paged,
                'filtrar_por_letra' => true,
            ]);
            remove_filter('posts_where', 'filtrar_por_letra', 10, 2);

            error_log("Número de entradas encontradas para la letra '{$letra}': " . $query->found_posts);
        } elseif (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
            // FILTRO CATEGORÍAS
            $categoria_slug = sanitize_text_field($_GET['categoria']);
            error_log("Categoría recibida: " . $categoria_slug);

            $query = new WP_Query([
                'posts_per_page' => 3,
                'paged'          => $paged,
                'category_name'  => $categoria_slug,
            ]);

            foreach ($query->posts as $post) {
                error_log("Entrada encontrada - ID: {$post->ID}, Título: {$post->post_title}");
            }
            error_log("Número de entradas encontradas para categoría '{$categoria_slug}': " . $query->found_posts);
        } else {
            // 3 ENTRADAS POR DEFECTO
            $query = new WP_Query([
                'posts_per_page' => 3,
                'paged'          => $paged,
            ]);
            error_log("Mostrando las últimas 3 entradas por defecto.");
        }

        // RESULTADOS
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/entry');
            }
            wp_reset_postdata();
        } else {
            echo '<p class="no-entradas">No se han encontrado entradas.</p>';
        }
        ?>
    </div>
    <div class="botones-final">
        <button
            class="boton-cargar"
            data-page="1"
            data-max-pages="<?php echo $query->max_num_pages; ?>">
            Cargar más entradas
        </button>
        <button class="boton-volver" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">Volver arriba</button>
    </div>
</main>
<?php get_footer(); ?>