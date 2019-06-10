<?php

/* 
 * Logo in Header
 */

?>
<div class="branding" role="banner" itemscope itemtype="http://schema.org/Organization">
    <?php 
    if ( ! is_front_page() ) {
        echo '<a itemprop="url" rel="home" href="'.home_url( '/' ).'">';
    }
    $header_image = get_header_image();
    if ( ! empty( $header_image ) ) {
        $customheader =  get_custom_header();
        $attachment_id = 0;
        if (isset($customheader->attachment_id)) {
            $attachment_id = $customheader->attachment_id;
            $srcset=  wp_get_attachment_image_srcset( $attachment_id, 'full');
        } else {
            $srcset ='';
        }
        echo '<img role="presentation" itemprop="logo" '
                . 'src="'.$header_image.'" '
                . 'width="'.get_custom_header()->width.'" height="'.get_custom_header()->height.'" ';
        if ($srcset) {
            echo ' srcset="'.$srcset.'"';
        }
        echo ">";
        echo '<span class="screen-reader-text" itemprop="name">'.get_bloginfo( 'title' ).'</span>';
    } else {
        echo '<span itemprop="name">'.get_bloginfo( 'title' ).'</span>';
    }
    if ( ! is_front_page() ) {
        echo "</a>";
    } 

    $desc = get_bloginfo( 'description' );
    $showdesc = get_theme_mod( 'display_site_description');
        // if false, remove link to comment feed from head
    
     
    if ((! ethuil_empty($desc)) && ($showdesc)) {
        echo '<p class="description" itemprop="description">'.$desc.'</p>';
    }
    ?>
</div>