<footer id="footer" role="contentinfo">
    <?php
    wp_nav_menu(array(
        'footer menu' => 'footer_menu',
        'container' => 'false',
        'menu_class' => 'footer-nav',
    ));
    ?>

    <!-- affichage de la modal -->
    <?php get_template_part('template-parts/contact-modal'); ?>

    <!-- affichage de la lightbox -->
    <?php get_template_part('template-parts/lightbox'); ?>

</footer>
</div>


<?php wp_footer() ?>

</body>