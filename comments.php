<?php
if (post_password_required()) {
    return;
}
?>

<div id="comentarios" class="area-comentarios">
    <ul class="lista-comentarios">
        <?php
        wp_list_comments(array(
            'style'      => 'ul',
            'short_ping' => true,
            'avatar_size' => 50,
            'callback'   => 'personalizar_comentarios'
        ));
        ?>
    </ul>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <nav class="navegacion-comentarios" role="navigation">
            <div class="nav-previo"><?php previous_comments_link('&larr; Comentarios anteriores'); ?></div>
            <div class="nav-siguiente"><?php next_comments_link('Comentarios siguientes &rarr;'); ?></div>
        </nav>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'  => '',
        'label_submit' => 'Enviar',
        'class_form'   => 'formulario-comentario',
        'comment_field' => '<textarea id="comment" name="comment" rows="4" required placeholder="Escribe tu comentario aquí..."></textarea>',
        'fields' => array(
            'author' => '<input id="author" name="author" type="text" class="campo-autor" placeholder="Tu nombre" required>',
            'email'  => '<input id="email" name="email" type="email" class="campo-email" placeholder="Tu correo electrónico" required>',
        ),
        'logged_in_as' => '',
    ));
    ?>
</div>
