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

<?php wp_footer() ?>

</body>