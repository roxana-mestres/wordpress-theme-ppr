<article class="entrada" data-id="<?php echo get_the_ID(); ?>">
    <h2 class="titulo-entrada"><?php the_title(); ?></h2>
    <div class="entrada-contenido">
        <?php if (has_post_thumbnail()) : ?>
            <div class="imagen-destacada">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
        <div class="contenido">
            <?php the_content(); ?>
        </div>
    </div>
    <!-- SEGUIR LEYENDO - COMENTAR - COMPARTIR -->
    <div class="interaccion-entrada">
        <a href="<?php the_permalink(); ?>" class="seguir-leyendo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/keep-reading-icon.svg" alt="Seguir leyendo">
            Seguir leyendo
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
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener">Twitter - X</a>
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener">WhatsApp</a>
                <a onclick="copiarEnlace(this)" href="javascript:void(0);" data-permalink="<?php echo get_permalink(); ?>">Copiar enlace</a>
            </div>
        </div>
    </div>
</article>