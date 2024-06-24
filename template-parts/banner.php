<!-- recuperer l'image aléatoire du banner -->
<div class="hero_banner">
    <h1 class="hero_banner_title">PHOTOGRAPHE EVENT</h1>
    <?php
    // parametre de la requete
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1, // un seul post.
        'orderby' => 'rand', // post aléatoire
    );
    // on execute la wp_query avec les parametre difini
    // On crée une nouvelle instance de la classe WP_Query avec les paramètres définis. Ceci exécute la requête et stocke le résultat dans $banner_query.
    $banner_query = new WP_Query($args);
    // on lance la boucle
    // On vérifie s'il y a des posts dans les résultats de la requête.
    // si oui on recupere l'url de l'image et on le stocke dans $banner_img_url.
    if ($banner_query->have_posts()) :
        while ($banner_query->have_posts()) : $banner_query->the_post();
            $banner_img_url = get_the_post_thumbnail_url();
        endwhile;
    endif;
    ?>
    <img class="banner__img" src=<?php echo $banner_img_url ?> alt="">
</div>