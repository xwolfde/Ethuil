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
        <span class="cat-links"><span class="linetitle"><?php _e( 'Abgelegt unter', 'ethuil' ); ?>:</span> <?php the_category( ', ' ); ?></span>
       <?php the_tags( '<span class="tag-links"><span class="linetitle">' . __( 'Schlagworte', 'ethuil' ) . ':</span> ', ', ', '</span>' ); ?>


        <?php if ( comments_open() ) : ?>
                <span class="comments-link"><?php comments_popup_link( __( '<span class="leave-reply">Eine Antwort hinterlassen</span>', 'ethuil' ), __( '<b>1</b> Antwort', 'ethuil' ), __( '<b>%</b> Antworten', 'ethuil' ) ); ?></span>
        <?php endif; ?>

        <?php edit_post_link( __( 'Bearbeiten', 'ethuil' ), '<span class="sep"> &middot; </span> <span class="edit-link">', '</span>' ); ?>
    </footer> 
</article>
