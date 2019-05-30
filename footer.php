<?php

/**
 * Footer 
 * @since Ethuil 1.0
 */
?>
    <footer id="pagefooter">
    <?php  
     if ( is_active_sidebar( 'sitebar-footer' ) ) { 
         dynamic_sidebar( 'sitebar-footer' ); 
    }
    ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>