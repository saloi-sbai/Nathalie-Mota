<?php
//require_once get_template_directory() . '/ajax-functions.php';

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles()
{

    // Enqueue jQuery from CDN
    wp_enqueue_script('jquery-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.css?tte=xa', time());
    //wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/assets/css/all.min.css');
    wp_enqueue_script('mon-script', get_theme_file_uri() . '/assets/scripts/script.js');
    //wp_enqueue_script('fontawesome-script', get_theme_file_uri() . '/assets/scripts/all.min.js');
    wp_enqueue_script('filtres-js', get_template_directory_uri() . '/assets/scripts/filtres.js', array('jquery'), null, true);
    wp_enqueue_script('burger-menu', get_template_directory_uri() . '/assets/scripts/burger-menu.js', array('jquery'), null, true);

    // Affichage des images miniature (script JQuery)
    wp_enqueue_script('miniature', get_stylesheet_directory_uri() . '/assets/scripts/miniatures.js', array('jquery'), '1.0.0', true);
    // script lightbox
    wp_enqueue_script('lightbox', get_stylesheet_directory_uri() . '/assets/scripts/lightbox.js', array('jquery'), '1.0.0', true);


    // Bibliotheque Select2 pour les selects de tri
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array());

    //Enqueue select.js
    wp_enqueue_script('select-script', get_template_directory_uri() . '/assets/scripts/custom-select.js', array('jquery'), '1.0.0', true);


    // Localise le script pour y ajouter des variables spécifiques à WordPress
    //wp_localize_script('load-more', 'ajax_url', admin_url('admin-ajax.php'));
    //wp_localize_script('filter-js', 'ajaxurl', admin_url('admin-ajax.php'));
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

// Ajout du script load-more.js et filtre.js avec wp_localize_script pour passer des paramètres AJAX
function enqueue_load_more_photos_script()
{
    wp_enqueue_script('load-more', get_stylesheet_directory_uri() . '/assets/scripts/load-more.js', array('jquery'), null, true);

    // Utilisez wp_localize_script pour passer des paramètres à votre script
    wp_localize_script('load-more', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    wp_localize_script('filtre', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_photos_script');


// Fonction pour charger plus de photos via AJAX
function load_more_photos()
{
    // Récupère le numéro de page à partir des données POST
    $page = $_POST['page'];

    // Arguments de la requête pour récupérer les photos
    $args = array(
        'post_type'      => 'photo',     // Type de publication : photo
        'posts_per_page' => 8,          // Nombre de photos par page 
        'orderby'        => 'date',      // Tri par date
        'order'          => 'DESC',       // Ordre décroissant (les plus récentes en premier)
        'offset' => $_POST['offset'] // Offset pour la pagination (le nombre de photos déja charger)
    );

    // Exécute la requête WP_Query avec les arguments
    $photo_block = new WP_Query($args);

    // Vérifie s'il y a des photos dans la requête
    if ($photo_block->have_posts()) :
        // Boucle à travers les photos
        while ($photo_block->have_posts()) :
            $photo_block->the_post();
            // Inclut la partie du modèle pour afficher un bloc de photo
            get_template_part('template-parts/block-photo', get_post_format());
        endwhile;

        // Réinitialise les données post
        wp_reset_postdata();
    else :
        // Aucune photo trouvée
        echo 'Aucune photo trouvée.';

    endif;

    // Termine l'exécution de la fonction
    die();
}

// Ajoute l'action AJAX pour les utilisateurs connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos');
// Ajoute l'action AJAX pour les utilisateurs non connectés
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Fonction pour filtrer les photos via AJAX
function filter_photos()
{
    // La fonction vérifie si l'action POST filter_photos est définie.
    if (isset($_POST['action']) && $_POST['action'] == 'filter_photos') {
        // Récupérez les filtres et nettoyez-les pour eviter les injections
        $filter = array_map('sanitize_text_field', $_POST['filter']);

        // Ajoutez des messages de débogage pour voir les valeurs reçues
        error_log('Filter values: ' . print_r($filter, true));

        // Construisez votre requête WP_Query avec les filtres
        $args = array(
            'post_type'      => 'photo',
            'posts_per_page' => -1,
            'orderby'        => 'rand',
            'order'          => 'ASC',
            'tax_query'      => array(
                'relation' => 'AND',
            ),
        );

        // Ajout des filtres à la requête: Filtrage par catégorie :
        if (!empty($filter['category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $filter['category'],
            );
        }

        // Filtrage par année :
        if (!empty($filter['years'])) {
            $args['order'] = ($filter['years'] == 'date_desc') ? 'DESC' : 'ASC';
        }

        // Filtrage par format :
        if (!empty($filter['format'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'format',
                'field'    => 'slug',
                'terms'    => $filter['format'],
            );
        }

        // Effectuez la requête WP_Query
        $query = new WP_Query($args);

        // Vérifiez si la requête a réussi
        if ($query->have_posts()) {
            // Boucle à travers les résultats de la requête
            while ($query->have_posts()) :
                $query->the_post();
                // Récupérez et affichez les informations de chaque photo
                $photoId      = get_post_thumbnail_id();
                $reference    = get_field('reference');
                $refUppercase = strtoupper($reference);

                // Ajoutez des messages de débogage pour les champs ACF
                error_log('Photo ID: ' . $photoId);
                error_log('Reference: ' . $reference);

                // Si des photos correspondent aux critères de filtrage, elles sont affichées en incluant le modèle template-parts/block-photo.
                get_template_part('template-parts/block-photo');
            endwhile;

            // Réinitialisez les données de requête après la boucle de requête
            wp_reset_query();
        } else {
            // Aucune photo ne correspond aux critères de filtrage
            echo '<p class="critereFiltrage">Aucune photo ne correspond aux critères de filtrage</p>';
        }
    }

    die(); //  arrête l'exécution du script
}

// Hook pour les utilisateurs connectés
add_action('wp_ajax_filter_photos', 'filter_photos');
// Hook pour les utilisateurs non connectés
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
