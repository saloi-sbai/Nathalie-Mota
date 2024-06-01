<?php get_header(); ?>
<div class="hero_banner">
    <h1 class="hero_banner_title">PHOTOGRAPHE EVENT</h1>
    <?php
    // parametre de la requete
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand', // post aléatoire
    );

    $banner_query = new WP_Query($args);

    if ($banner_query->have_posts()) :
        while ($banner_query->have_posts()) : $banner_query->the_post();
            $banner_img_url = get_the_post_thumbnail_url();
        endwhile;
    endif;
    ?>
    <img class="banner__img" src=<?php echo $banner_img_url ?> alt="">
</div>
<!---------------------- filtres et galerie ------------------------------->
<section class="galery_section">
    <div class="filters_container">
        <div class="taxonomy_container">
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
                    <button class="dropdown_toggle"><i class="fas fa-chevron-down"></i>FORM</button>
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

        </div>
        <div class="date_container">
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

        </div>

    </div>


</section>


<?php get_footer(); ?>