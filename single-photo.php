<?php get_header(); ?>

<?php
// récupèrer les informations sur la photo principale
$photoId = get_field('photo');
$reference = get_field('reference');
$refUppercase = strtoupper($reference);

// Récupération des termes de taxonomie catégories et format de la photo principale
$categories = get_the_terms(get_the_ID(), 'categorie');
$categorie_name = $categories ? $categories[0]->name : '';
$formats = get_the_terms(get_the_ID(), 'format');
$FORMATS = $formats ? ucwords($formats[0]->name) : '';

// Récupération de l'annee de publication de la photo
// $annees_terms = get_the_terms(get_the_ID(), 'annee');
// $annee = ($annees_terms && !is_wp_error($annees_terms)) ? $annees_terms[0]->name : 'Non défini';
$annee = get_the_date('Y');

// recuperation des informations sur les posts suivants et précédents,et les URL des vignettes.
$nextPost = get_next_post();
$previousPost = get_previous_post();
$previousThumbnailURL = $previousPost ? get_the_post_thumbnail_url($previousPost->ID, 'thumbnail') : '';
$nextThumbnailURL = $nextPost ? get_the_post_thumbnail_url($nextPost->ID, 'thumbnail') : '';
?>

<!-- affiche la photo, le titre, et des informations détaillées -->
<section class="photos__catalog">
    <div class="photos__gallery">
        <div class="photo__detail">
            <div class="photo__container">
                <?php echo the_post_thumbnail(); ?>
            </div>

            <div class="photo__info">
                <h2><?php echo esc_html(get_the_title()); ?></h2>

                <div class="photo__taxo">
                    <p>RÉFÉRENCE : <span id="single-reference"><?php echo esc_html($refUppercase); ?></span></p>
                    <p>CATÉGORIE : <?php echo esc_html($categorie_name); ?></p>
                    <p>FORMAT : <?php echo esc_html($FORMATS); ?></p>
                    <p>TYPE : <?php echo esc_html(get_field('type')); ?></p>
                    <p>ANNÉE : <?php echo esc_html($annee); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- section contact et navigation entre les photos -->
    <div class="contact__container">
        <div class="contact">
            <p class="interested">Cette photo vous intéresse ?</p>
            <button class="modale-contact" id="contact__button" data-reference="<?php echo $refUppercase; ?>">Contact</button>
        </div>

        <div class="navPhotos">
            <div class="miniature" id="miniature"></div>

            <div class="navArrow">
                <?php if (!empty($previousPost)) : ?>
                    <img class="arrow arrow-left" src="<?php echo get_theme_file_uri() . '/assets/images/previous.png'; ?>" alt="Photo précédente" data-thumbnail-url="<?php echo $previousThumbnailURL; ?>" data-target-url="<?php echo esc_url(get_permalink($previousPost->ID)); ?>">
                <?php endif; ?>

                <?php if (!empty($nextPost)) : ?>
                    <img class="arrow arrow-right" src="<?php echo get_theme_file_uri() . '/assets/images/next.png'; ?>" alt="Photo suivante" data-thumbnail-url="<?php echo $nextThumbnailURL; ?>" data-target-url="<?php echo esc_url(get_permalink($nextPost->ID)); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- section affiche des photos similaires en se basant sur la catégorie de la photo actuelle -->
<!-- utilise une requête personnalisée pour récupérer et afficher deux photos aléatoires de la même catégorie -->
<section class="suggestions">
    <div class="title__suggestion">
        <h3>VOUS AIMEREZ AUSSI</h3>
    </div>

    <div class="photo__similar">
        <?php
        $categories = get_the_terms(get_the_ID(), 'categorie');
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 2,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'id',
                    'terms' => $categories ? wp_list_pluck($categories, 'term_id') : array(),
                ),
            ),
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                get_template_part('template-parts/block-photo');
            endwhile;
        else :
            echo '<p class="photoNotFound">Pas de photo similaire trouvée pour la catégorie.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>


<?php get_footer(); ?>