<?php
//CSS
function palabras_para_recordar_enqueue_styles()
{
    // CSS STYLES.CSS
    wp_enqueue_style('style', get_stylesheet_uri());

    // CSS GENERAL
    wp_enqueue_style('global-style', get_template_directory_uri() . '/assets/css/global.css');

    // CSS HEADER
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/header.css', array(), '1.0', 'all');

    // CSS ESPECÍFICO PARA HOME - FRONT-PAGE
    if (is_front_page()) {
        wp_enqueue_style('home', get_template_directory_uri() . '/assets/css/home.css');
    }

    // CSS ESPECÍFICO PARA PÁGINA SOBRE MÍ
    if (is_page('sobre-mi')) {
        wp_enqueue_style('sobre-mi', get_template_directory_uri() . '/assets/css/sobre_mi.css', array(), '1.0', 'all');
    }

    // CSS ESPECÍFICO PARA PÁGINA DE CONTACTO
    if (is_page('contactar')) {
        wp_enqueue_style('contactar', get_template_directory_uri() . '/assets/css/contactar.css', array(), '1.0', 'all');
    }

    // CSS ESPECÍFICO PARA PÁGINA 404
    if (is_404()) {
        wp_enqueue_style('404', get_template_directory_uri() . '/assets/css/404.css', array(), '1.0', 'all');
    }

    // CSS ESPECÍFICO PARA SINGLE
    if (is_single()) {
        wp_enqueue_style('single', get_template_directory_uri() . '/assets/css/single.css', array(), '1.0', 'all');
    }

    // CSS ESPECÍFICO PARA COMMENTS
    if (is_singular('post') && (comments_open() || get_comments_number())) {
        wp_enqueue_style('comments', get_template_directory_uri() . '/assets/css/comments.css', array(), '1.0', 'all');
    }

    // CSS ESPECÍFICO PARA SEARCH
    if (is_search()) {
        wp_enqueue_style('search-style', get_template_directory_uri() . '/assets/css/search.css');
    }
}
add_action('wp_enqueue_scripts', 'palabras_para_recordar_enqueue_styles');

// PERSONALIZAR COMENTARIOS PÁGINA SINGLE
function personalizar_comentarios($comment, $args, $depth)
{
?>
    <li <?php comment_class('comentario'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comentario-avatar">
            <?php echo get_avatar($comment, 50); ?>
        </div>
        <div class="comentario-cuerpo">
            <div class="autor-comentario">
                <?php echo get_comment_author_link(); ?>
            </div>
            <div class="meta-comentario">
                <?php echo get_comment_date(); ?> a las <?php echo get_comment_time(); ?>
            </div>
            <div class="contenido-comentario">
                <?php comment_text(); ?>
            </div>
            <div class="respuesta-comentario">
                <?php
                comment_reply_link(array_merge($args, array(
                    'reply_text' => 'Responder',
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                )));
                edit_comment_link('Editar');
                ?>
            </div>
        </div>
    </li>
<?php
}

// REGISTRAR MENÚS
function palabras_para_recordar_register_menus()
{
    register_nav_menus(array(
        'primary' => __('Menú Principal', 'palabras_para_recordar'),
    ));
}
add_action('init', 'palabras_para_recordar_register_menus');

// IMÁGENES DESTACADAS
function palabras_para_recordar_theme_setup()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'palabras_para_recordar_theme_setup');

/* AÑADIR JS */
function agregar_recursos_tema()
{
    wp_enqueue_script(
        'inicio-js',
        get_template_directory_uri() . '/assets/js/inicio.js',
        array(),
        '1.0',
        true
    );

    $inline_script = "const ajax_object = { ajax_url: '" . admin_url('admin-ajax.php') . "' };";
    wp_add_inline_script('inicio-js', $inline_script, 'before');
}
add_action('wp_enqueue_scripts', 'agregar_recursos_tema');

/* AÑADIR JS CONTACTO */
function cargar_scripts_contacto()
{
    wp_enqueue_script(
        'contacto-ajax',
        get_template_directory_uri() . '/assets/js/contacto.js',
        ['jquery'],
        null,
        true
    );

    $inline_script = "const ajaxurl = '" . admin_url('admin-ajax.php') . "';";
    wp_add_inline_script('contacto-ajax', $inline_script, 'before');
}
add_action('wp_enqueue_scripts', 'cargar_scripts_contacto');

// FILTRO POR LETRA
function filtrar_por_letra($where, $query)
{
    if ($query->get('filtrar_por_letra') && isset($_GET['letra']) && !empty($_GET['letra'])) {
        global $wpdb;

        $letra = sanitize_text_field($_GET['letra']);
        $letra = mb_substr($letra, 0, 1, 'UTF-8');

        $where .= $wpdb->prepare(
            " AND (
                LOWER(LEFT({$wpdb->posts}.post_title, 1)) = %s OR
                (LOWER(LEFT({$wpdb->posts}.post_title, 1)) IN ('¿', '¡') AND LOWER(LEFT(SUBSTRING({$wpdb->posts}.post_title FROM 2), 1)) = %s)
            )",
            strtolower($letra),
            strtolower($letra)
        );

        error_log("Filtro por letra aplicado: " . $letra);
    }
    return $where;
}

// CARGAR MÁS ENTRADAS  - AJAX
function cargar_mas_entradas()
{
    if (isset($_POST['page']) && !empty($_POST['page'])) {
        $page = intval($_POST['page']);

        error_log("Página solicitada: $page");

        $args = [
            'posts_per_page' => 3,
            'paged'          => $page,
            'post_status'    => 'publish',
            'post_type'      => 'post',
        ];

        error_log("Argumentos de WP_Query: " . print_r($args, true));

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                error_log("Entrada encontrada - ID: " . get_the_ID() . ", Título: " . get_the_title());
                get_template_part('template-parts/entry');
            }
            wp_reset_postdata();
        } else {
            error_log("No se encontraron entradas para la página {$page}.");
            echo '<p class="no-entradas">No se han encontrado más entradas.</p>';
        }
    } else {
        error_log("Error: No se recibió el número de página.");
        echo '<p class="no-entradas">Error: No se recibió el número de página.</p>';
    }

    wp_die();
}
add_action('wp_ajax_cargar_mas_entradas', 'cargar_mas_entradas');
add_action('wp_ajax_nopriv_cargar_mas_entradas', 'cargar_mas_entradas');

/* FORMULARIO CONTACTO */

function procesar_formulario_contacto_ajax()
{
    if (!isset($_POST['nombre']) || !isset($_POST['correo']) || !isset($_POST['asunto']) || !isset($_POST['mensaje'])) {
        wp_send_json_error(['message' => 'Faltan campos obligatorios']);
        wp_die();
    }

    $nombre = sanitize_text_field($_POST['nombre']);
    $correo = sanitize_email($_POST['correo']);
    $asunto = sanitize_text_field($_POST['asunto']);
    $mensaje = sanitize_textarea_field($_POST['mensaje']);

    error_log("Datos recibidos: Nombre: $nombre, Correo: $correo, Asunto: $asunto, Mensaje: $mensaje");

    $para = 'roxane.bravo.riv@gmail.com';
    $cabeceras = ['Content-Type: text/html; charset=UTF-8'];
    $contenido = "
        <h2>Nuevo mensaje de contacto</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Correo:</strong> $correo</p>
        <p><strong>Asunto:</strong> $asunto</p>
        <p><strong>Mensaje:</strong><br>$mensaje</p>
    ";

    if (wp_mail($para, $asunto, $contenido, $cabeceras)) {
        wp_send_json_success(['message' => 'Correo enviado correctamente']);
    } else {
        wp_send_json_error(['message' => 'Error al enviar el correo']);
    }

    wp_die();
}
add_action('wp_ajax_procesar_formulario_contacto', 'procesar_formulario_contacto_ajax');
add_action('wp_ajax_nopriv_procesar_formulario_contacto', 'procesar_formulario_contacto_ajax');

// LIMPIAR CLASES GUTENBERG
function limpiar_clases_gutenberg($content) {
    $content = preg_replace('/\s?has-[a-zA-Z0-9-]+/', '', $content);
    return '<div class="contenido">' . $content . '</div>';
}
add_filter('the_content', 'limpiar_clases_gutenberg');

// FORMATEAR EL TÍTULO DE LAS ENTRADAS
function transformar_titulo($title) {
    
    $title = mb_strtolower($title);

    $title = preg_replace_callback('/^(\s*[\¿\¡]?\s*)(\w)/u', function ($matches) {
        return $matches[1] . mb_strtoupper($matches[2]);
    }, $title);

    return $title;
}
add_filter('the_title', 'transformar_titulo');

// FUNCIÓN PARA ELIMINAR EMBEDS COMO VIDEOS DE YOUTUBE
function eliminar_embeds($content) {
    $content = preg_replace('/<iframe.*?\\/iframe>/is', '', $content);

    $content = preg_replace('/<embed.*?\\/embed>/is', '', $content);

    return $content;
}
add_filter('the_content', 'eliminar_embeds');

// FUNCIÓN PARA LIMPIAR FORMATO DE CONTENIDO (NEGRITAS, CURSIVAS, ENLACES)

function limpiar_formato_contenido($content) {
    $content = preg_replace('/<\\/?(strong|b|i|em|u)>/', '', $content);
    
    $content = preg_replace('/<a\\b[^>]*>(.*?)<\\/a>/', '$1', $content);

    $content = '<div style="text-align: left; color: #31086a;">' . $content . '</div>';

    return $content;
}
add_filter('the_content', 'limpiar_formato_contenido');

// SOBREESCRIBIR COLOR TEXTO P
function limpiar_clases_y_estilos($content) {
    $content = preg_replace('/<p class="wp-elements-[^"]+"/', '<p', $content);

    $content = preg_replace('/style="([^"]+)"/', 'style="/* $1 */"', $content);

    return $content;
}
add_filter('the_content', 'limpiar_clases_y_estilos');

?>