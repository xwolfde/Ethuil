<?php
/**
 * The main template file.
 * @since Ethuil 1.0
 */

get_header(); 
?>
<main id="droppoint">
<?php
    if (have_posts()) {
        while ( have_posts() ) { 
            the_post();  
            $format = get_post_format() ? : 'post';
            get_template_part( 'template-parts/index', $format );
        } 
    } else {
        get_template_part( 'template-parts/index', 'not-found' );
    }
    ?>
</main>	
<?php 
get_footer(); 

