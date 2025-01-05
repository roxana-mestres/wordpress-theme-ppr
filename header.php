<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Oooh+Baby&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="header-principal">
        <nav class="menu-nav">
            <!-- MENÚ HAMBURGUESA -->
            <div class="menu-hamburguesa" onclick="toggleMenu()">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu_icon.svg" alt="Menú">
            </div>
            <!-- MENÚ NAV -->
            <ul>
                <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
                <li><a href="<?php echo home_url('/sobre-mi'); ?>">Sobre mí</a></li>
                <li><a href="<?php echo home_url('/contactar'); ?>">Contactar</a></li>
            </ul>
        </nav>
    </header>