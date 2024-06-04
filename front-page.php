<?php get_header(); ?>
<!-- recuperer l'image aléatoire du banner -->
<div class="hero_banner">
    <h1 class="hero_banner_title">PHOTOGRAPHE EVENT</h1>
    <?php
    // parametre de la requete
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand', // post aléatoire
    );
    // on execute la wp_query
    $banner_query = new WP_Query($args);
    // on lance la boucle
    if ($banner_query->have_posts()) :
        while ($banner_query->have_posts()) : $banner_query->the_post();
            $banner_img_url = get_the_post_thumbnail_url();
        endwhile;
    endif;
    ?>
    <img class="banner__img" src=<?php echo $banner_img_url ?> alt="">
</div>

<!---------------------- filtres et galerie ------------------------------->
<section class="filters_section">
    <div class="filters category">
        <label class="filter_label" for="category_filter">CATEGORIES</label>
        <div class="dropdown" id="category_dropdown">
            <button class="dropdown_toggle"><i class="fas fa-chevron-down"></i>CATEGORIES</button>
            <ul class="dropdown_list">
                <li data-value="" data-label='Toutes'>TOUTES</li>
                <?php
                $categories = get_terms(array(
                    'taxonomy'   => 'categorie',
                    'hide_empty' => false,
                ));

                foreach ($categories as $category) {
                    $label = get_field('label', $category);
                    $label = $label ? $label : $category->name;
                    echo '<li data-value="' . esc_attr($category->slug) . '" data-label="' . esc_attr($label) . '">' . esc_html($label) . '</li>';
                }
                ?>
            </ul>
        </div>

    </div>
    <div class="filters format">
        <label class="filter_label" for="format_filter">FORMAT</label>
        <div class="dropdown" id="format_dropdown">
            <button class="dropdown_toggle"><i class="fas fa-chevron-down"></i>FORMAT</button>
            <ul class="dropdown_list">
                <li data-value="" data-label='Toutes'>TOUS</li>
                <?php
                $formats = get_terms(array(
                    'taxonomy'   => 'format',
                    'hide_empty' => false,
                ));

                foreach ($formats as $format) {
                    $label = get_field('label', $format);
                    $label = $label ? $label : $format->name;
                    echo '<li data-value="' . esc_attr($format->slug) . '" data-label="' . esc_attr($label) . '">' . esc_html($label) . '</li>';
                }
                ?>
            </ul>
        </div>

    </div>
    <div class="filters date">
        <label class="filter_label" for="date_filter">DATES</label>
        <div class="dropdown" id="date_dropdown">
            <button class="dropdown_toggle"><i class="fas fa-chevron-down"></i>DATES</button>
            <ul class="dropdown_list">
                <li data-value="recent" data-label='plus récentes'>Plus récentes</li>
                <li data-value="old" data-label='plus enciennes'>Plus enciennes</li>

            </ul>
        </div>

    </div>
</section>

<?php
// parametre de la requete
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 8,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>

    <section class="photos_section">
        <div class="photos_container">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="photo_item">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'desktop-home')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="photo_image">
                    </a>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <!-- bouton pour charger plus d'images -->
        <div class="load_more">
            <button id="load_more_button">Charger plus</button>
        </div>

    </section>

<?php else :
    echo 'Aucune photo trouvée.';
endif;
get_footer();
wp_footer(); ?>