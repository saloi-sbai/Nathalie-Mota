<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles()
{
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.css', time());
    wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/assets/css/all.min.css');
    wp_enqueue_script('mon-script', get_theme_file_uri() . '/assets/scripts/script.js');
    wp_enqueue_script('fontawesome-script', get_theme_file_uri() . '/assets/scripts/all.min.js');
    wp_enqueue_script('jquery');
}

function montheme_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
}

add_action('after_setup_theme', 'montheme_supports');


if (!function_exists('mytheme_register_nav_menu')) {

    function mytheme_register_nav_menu()
    {
        register_nav_menus(array(
            'primary_menu' => "menu principal",
            'footer_menu'  => "Footer Menu",
        ));
        add_theme_support('custom-logo');
    }
    add_action('after_setup_theme', 'mytheme_register_nav_menu', 0);
}
