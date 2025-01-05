<?php get_header(); ?>
<main>
    <section class="seccion-busqueda">
        <!-- BUSCADOR -->
        <div class="buscador buscador-search">
            <form method="get" action="<?php echo home_url("/") ?>" class="form-buscador">
                <div class="input-contenedor">
                    <input type="text" name="s" class="input-buscador">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon.svg" alt="Buscar" class="icono-buscador">
                </div>
            </form>
        </div>
        <div class="contenedor-busqueda">
            <h1 class="titulo-busqueda">Resultados de la búsqueda:</h1>
            <?php if (have_posts()) : ?>
                <ul class="lista-resultados">
                    <?php while (have_posts()) : the_post(); ?>
                        <li class="resultado-item">
                            <h2 class="resultado-titulo">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="resultado-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 150, '... <a href="' . get_permalink() . '">Leer más</a>'); ?>
                            </p>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="paginacion">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '« Anterior',
                        'next_text' => 'Siguiente »',
                    ));
                    ?>
                </div>
            <?php else : ?>
                <p class="sin-resultados">No se encontraron entradas que coincidan con tu búsqueda.<br /> Por favor, inténtalo de nuevo.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>