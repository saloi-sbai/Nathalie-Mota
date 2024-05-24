<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description') ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>


</head>

<body <?php body_class() ?>>
    <?php wp_body_open() ?>


    <div id="container">
        <header class="nav-bar">
            <div class="logo"><?php
                                the_custom_logo();
                                ?></div>

            <nav class="menu">
                <div class="main-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary_menu',
                    ))
                    ?>

                </div>

            </nav>

        </header>
        <main>