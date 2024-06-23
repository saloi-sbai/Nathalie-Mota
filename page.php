<?php get_header() ?>

<?php
while (have_posts()) : the_post();
    the_title("<h1>", "</h1>");
    echo "<div class= 'main-content'>";
    the_content();
    echo "</div>";
endwhile;


?>


<?php get_footer() ?>