</main>
<footer id="footer" role="contentinfo">
    <?php
    wp_nav_menu(array(
        'footer menu' => 'footer_menu',
    ));
    ?>

</footer>
</div>
<?php get_template_part('template-parts/contact-modal'); ?>

<!-- affichage de la lightbox -->
<?php get_template_part('template-parts/lightbox'); ?>

<?php wp_footer() ?>

</body>