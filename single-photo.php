<?php
get_header(); ?>

<div id="single" class="single_photo_section">
    <main id="main" class="single_photo_container" role="main">

        <?php
        while (have_posts()) : the_post(); ?>

            <div class="content_wrapper">
                <div class="photo_details">
                    <!----------------- div details --------------->
                    <div class="details">
                        <h1 class="title"> <?php the_title(); ?></h1>
                        <p class="property">Référence : <span id="reference-value"><?php echo get_post_meta(get_the_ID(), 'reference', true); ?></span></p>
                        <p class="property">Catégorie : <?php echo get_the_terms(get_the_ID(), 'categorie')[0]->name; ?></p>
                        <p class="property">Format : <?php echo get_the_terms(get_the_ID(), 'format')[0]->name; ?> </p>
                        <p class="property">Type : <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
                        <p class="property">Année : <?php the_time('Y'); ?></p>
                        <hr>
                    </div>

                    <!--------------- div photo seule ------------>
                    <div class="photo">
                        <?php echo the_post_thumbnail(); ?>
                    </div>
                </div>
                <!---------------- div interet ------------------->
                <div class="interet">
                    <div class="interet_contact">
                        <p class="text">Cette photo vous intéresse ?</p>
                        <button class="grey-btn popup-contact">Contact</button>
                    </div>
                    <div class="interet_navigation">
                        <?php
                        // Replace the image URLs with your actual arrow image URLs
                        $previous_arrow_image_url = get_template_directory_uri() . '/assets/images/previous.png';
                        $next_arrow_image_url = get_template_directory_uri() . '/assets/images/next.png';

                        // Custom format strings for previous and next post links with arrow images
                        $previous_link_format = '<img src="' . $previous_arrow_image_url . '" alt="Previous Post" />';
                        $next_link_format = '<img src="' . $next_arrow_image_url . '" alt="Next Post" />';
                        ?>

                        <div class="previous-wrapper">
                            <div class="thumbnail">
                                <?php
                                $previous_post = get_previous_post();
                                echo get_the_post_thumbnail($previous_post, [100, 100]);
                                ?>
                            </div>
                            <div class="arrow">
                                <?php previous_post_link('%link', $previous_link_format); ?>
                            </div>
                        </div>
                        <div class="next-wrapper">
                            <div class="thumbnail">
                                <?php
                                $next_post = get_next_post();
                                echo get_the_post_thumbnail($next_post, [100, 100]);
                                ?>
                            </div>
                            <div class="arrow">
                                <?php next_post_link('%link', $next_link_format); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!----------------- Affichage des photos apparentés -------------->

            <div class="similar-photos" id=similar-photos>
                <h2 class="subtitle">Vous aimeriez AUSSI</h2>
                <div class=photos></div>
            </div>

        <?php
        // End the loop (principale).
        endwhile;
        ?>


    </main>
</div>

<?php get_footer(); ?>