<?php

/**
 * Footer 
 * @since Ethuil 1.0
 */
?>
    <footer id="pagefooter" aria-label="<?php echo __("Seitenabschluss","ethuil");?>">
    <?php  
     if ( is_active_sidebar( 'sitebar-footer' ) ) { 
         dynamic_sidebar( 'sitebar-footer' ); 
    }
    ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>