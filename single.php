<?php get_header(); ?>

<main class="single-entrada">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="entrada">
                <!-- TÍTULO ENTRADA -->
                <h2 class="titulo-entrada"><?php the_title(); ?></h2>

                <!-- IMAGEN DESTACADA -->
                <div class="entrada-contenido">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="imagen-destacada">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    <!-- CONTENIDO -->
                    <div class="contenido js-columnas-dinamicas" data-template="<?php echo esc_url(get_template_directory_uri()); ?>">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- SEGUIR LEYENDO - COMENTAR - COMPARTIR -->
                <div class="interaccion-entrada">
                    <a href="<?php echo home_url(''); ?>" class="volver-inicio">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/flecha-atras.svg" alt="Volver a inicio">
                        Volver a inicio
                    </a>
                    <a href="<?php the_permalink(); ?>#comentarios-entrada" class="comentar">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/comment-icon.svg" alt="Comentar">
                        Comentar
                    </a>
                    <div class="compartir">
                        <a class="abrir-menu-compartir">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share-icon.svg" alt="Compartir">
                            Compartir
                        </a>
                        <div class="menu-compartir">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener">Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener">Twitter</a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener">WhatsApp</a>
                            <a onclick="copiarEnlace(this)" href="javascript:void(0);" data-permalink="<?php echo get_permalink(); ?>">Copiar enlace</a>
                        </div>
                    </div>
                </div>
                <div class="comentarios-entrada" id="comentarios-entrada">
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    else :
                        echo '<p>Los comentarios están cerrados para esta entrada.</p>';
                    endif;
                    ?>
                </div>
            </article>
    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>