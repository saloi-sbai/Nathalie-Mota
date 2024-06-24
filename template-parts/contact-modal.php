<div id="overlay" class="hidden">
    <div id="contact-modal" class="modal">
        <div class="modal-content">
            <!-- Bouton de fermeture de la modal -->
            <span class="close-modal">&times;</span>

            <!-- Image d'en-tête de la modal -->
            <img src="<?php echo get_template_directory_uri() . '/assets/images/Contact_ header.svg' ?>" alt="Contact header">
        </div>
        <div class="modal-form">
            <!-- Formulaire de contact -->
            <?php echo do_shortcode('[contact-form-7 id="31b7c66" title="Formulaire de contact"]'); ?>
        </div>
    </div>
</div>