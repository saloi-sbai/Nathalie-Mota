<?php

add_action('wp_enqueue_jquery_scripts', 'my_register_script_method');

function my_register_jquery_script_method()
{
    //wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
}


add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles()
{
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.css?tte=xtt', time());
    wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/assets/css/all.min.css');
    wp_enqueue_script('mon-script', get_theme_file_uri() . '/assets/scripts/script.js');
    wp_enqueue_script('filters', get_theme_file_uri() . '/assets/scripts/filters.js');
    wp_enqueue_script('fontawesome-script', get_theme_file_uri() . '/assets/scripts/all.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/scripts/load-more.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/scripts/filters.js', array('jquery'), '1.0.0', true);
    // Localise le script pour y ajouter des variables spécifiques à WordPress
    wp_localize_script('load-more', 'my_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
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



function filter_photos()
{
    $category = $_POST['category'];
    $format = $_POST['format'];
    $date = $_POST['date'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $_POST['page'] ?? 1,
    );

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if ($date) {
        $args['orderby'] = 'date';
        $args['order'] = ($date === 'recent') ? 'DESC' : 'ASC';
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
?>
            <div class="photo_item">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <img src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'desktop-home')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="photo_image">
                </a>
            </div>
<?php
        }
        wp_reset_postdata();
    } else {
        echo 'Aucune photo trouvée.';
    }

    die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function enqueue_custom_scripts()
{
    wp_enqueue_script('filter-js', get_template_directory_uri() . '/js/filter.js', array('jquery'), null, true);

    // Localize script to pass the ajaxurl to our JS file
    wp_localize_script('filter-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function enqueue_select2()
{
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, true);
    wp_enqueue_script('filter-js', get_template_directory_uri() . '/assets/scripts/filters.js', array('jquery', 'select2-js'), null, true);

    // Localize script to pass the ajaxurl to our JS file
    wp_localize_script('filter-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_select2');
