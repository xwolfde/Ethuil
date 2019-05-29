<?php 
global $options;

if ( post_password_required() ) { ?>
    <p class="attention">
        <?php _e("Dieser Eintrag ist mit einem Passwort geschützt. Bitte geben Sie das Passwort ein, um ihn freizuschalten.", 'ethuil'); ?>
    </p>
    <?php
    return;
}

if ( have_comments() ) { ?>
   
    <h2><?php _e("Kommentare", 'ethuil'); ?></h2>
    
    <?php if (isset($options['advanced_comments_disclaimer'])) {
	echo '<p class="attention">'.$options['advanced_comments_disclaimer'] .'</p>'."\n";
     } ?>

     <p>   
    <?php printf( _n( 'Ein Kommentar zu <em>"%2$s"</em>', '%1$s Kommentare zu <em>"%2$s"</em>', get_comments_number(), 'ethuil' ), number_format_i18n( get_comments_number() ), '' . get_the_title() . '' ); ?>:
    </p>
    <?php 
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  
           previous_comments_link( '&larr; '. __( 'Ältere Kommentare', 'ethuil' ) ); 
           next_comments_link( __( 'Neuere Kommentare;', 'ethuil' ).' &rarr' ); 
    endif; ?>
    <ul>
            <?php wp_list_comments( array(  'style' => 'ul', 'callback' => 'ethuil_comment' ) ); ?>
    </ul>

    <?php 
     if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { 
             previous_comments_link( '&larr; '.__( 'Ältere Kommentare', 'ethuil' ) ); 
             next_comments_link( __( 'Neuere Kommentare', 'ethuil' ). ' &rarr;' ); 
    } 
    if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' )  ) { ?>
	<p><?php _e("Eine Kommentierung ist nicht mehr möglich.", 'ethuil'); ?></p>
     <?php 
     } 
} 
     
if (!empty($options['advanced_comments_notes_before'])) {
    $notes = '<p class="comment-notes">'.$options['advanced_comments_notes_before'].'</p>';
	    
     comment_form( array( 'comment_notes_before' => $notes) ); 
} else {
    comment_form();
}
   

?> 