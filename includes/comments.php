<?php
/**
* @since Ethuil 1.0
* 
*  Template for comments and pingbacks.
*/


if ( ! function_exists( 'ethuil_comment' ) ) :
function ethuil_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        
        switch ( $comment->comment_type ) :
                case '' :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
          <div id="comment-<?php comment_ID(); ?>">
            <article itemprop="comment" itemscope itemtype="http://schema.org/UserComments">
              <header>  
                <div class="comment-details">
                    
                <span class="comment-author vcard" itemprop="creator" itemscope itemtype="http://schema.org/Person">
                    <?php
		    
                    printf( __( '%s <span class="says">schrieb am</span>', 'ethuil' ), sprintf( '<cite class="fn" itemprop="name">%s</cite>', get_comment_author_link() ) ); 
                    ?>
                </span><!-- .comment-author .vcard -->
              

                <span class="comment-meta commentmetadata"><a itemprop="url" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time itemprop="commentTime" datetime="<?php comment_time('c'); ?>">
                    <?php
                          /* translators: 1: date, 2: time */
                       printf( __( '%1$s um %2$s Uhr', 'ethuil' ), get_comment_date(),  get_comment_time() ); ?></time></a> <?php echo __('folgendes','ethuil');?>:
                  
                </span><!-- .comment-meta .commentmetadata -->
                </div>
              </header>
		     <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em><?php _e( 'Kommentar wartet auf Freischaltung.', 'ethuil' ); ?></em>
                        <br />
                <?php endif; ?>
                <div class="comment-body" itemprop="commentText"><?php comment_text(); ?></div>
		 <?php edit_comment_link( __( '(Bearbeiten)', 'ethuil' ), ' ' ); ?>
            </article>
          </div><!-- #comment-##  -->

        <?php
                        break;
                case 'pingback'  :
                case 'trackback' :
        ?>
        <li class="post pingback">
                <p><?php _e( 'Pingback:', 'ethuil' ); ?> <?php comment_author_link(); edit_comment_link( __('Bearbeiten', 'ethuil'), ' ' ); ?></p>
        <?php
                        break;
        endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/*  Refuse spam-comments on media
/*-----------------------------------------------------------------------------------*/
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );
/*-----------------------------------------------------------------------------------*/
/* EOF comments.php
/*-----------------------------------------------------------------------------------*/