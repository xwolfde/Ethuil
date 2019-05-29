<?php
/**
 * The main template file.
 * @since Ethuil 1.0
 */

get_header(); 
?>
<main>
<?php
    while ( have_posts() ) { 
        the_post();  
        the_content(); 
        
        echo wp_link_pages(); 
    } 
    ?>
</main>	
<?php 
get_footer(); 

