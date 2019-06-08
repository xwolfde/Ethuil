<?php

/* 
 *  Theme Name: content
 */

?>

<article class="card">
    <header class="card-header">
	<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    </header>
    <div class="card-body">
			
        <?php
        the_content(
                the_title( '', '', FALSE ) . ' ' . __( 'Weiterlesen &raquo;', 'ethuil' )
        );
        wp_link_pages(
                array(
                        'before' => '<nav class="page-link">' . __( '<span>Seiten:</span>', 'ethuil' ),
                        'after' => '</nav>',
                )
        );

        ?>
    </div> 
    <footer class="card-footer">
        <?php edit_post_link( __( 'Bearbeiten', 'ethuil' ), '<span class="edit-link">', '</span>' ); ?>
    </footer> 
</article>
