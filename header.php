<?php
/**
 * Header 
 * @since Ethuil 1.0
 */
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="pageheader" aria-label="<?php _e("Seitenkopf","ethuil"); ?>">
        
		<div class="row">
		    <div class="branding" id="logo" role="banner" itemscope itemtype="http://schema.org/Organization">
                        <p class="sitetitle">
                        <?php if ( ! is_front_page() ) {
                            echo '<a itemprop="url" rel="home" href="'.home_url( '/' ).'">';
                        }
                        $header_image = get_header_image();
                        if ( ! empty( $header_image ) ) {
                            $customheader =  get_custom_header();
                            $attachment_id = 0;
                            if (isset($customheader->attachment_id)) {
                                $attachment_id = $customheader->attachment_id;
                                $srcset=  esc_attr(wp_get_attachment_image_srcset( $attachment_id, 'full'));
                            } else {
                                $srcset ='';
                            }
                            echo '<img src="'.$header_image.'" width="'.get_custom_header()->width.'" height="'.get_custom_header()->height.'" alt="'.esc_attr(get_bloginfo( 'title' )).'"';
                            if ($srcset) {
                                echo ' srcset="'.$srcset.'"';
                            }
                            echo ">";

                        } else {
                            echo "<span>".get_bloginfo( 'title' )."</span>";
                        }
                        if ( ! is_front_page() ) {
                            echo "</a>";
                        } ?>
                        </p>
		    </div>
		    <nav class="header-menu" aria-labelledby="hauptnav-anchor">
                <h2 id="hauptnav-anchor" class="screen-reader-text"><?php _e("Hauptnavigation","fau"); ?></h2>
               
			<?php
			    if(has_nav_menu( 'main-menu' ) && class_exists('Walker_Main_Menu', false)) {

				 wp_nav_menu( array( 
                                     'theme_location' => 'main-menu', 
                                     'container' => false,
                                     'items_wrap' => '<div id="nav"><ul class="nav">%3$s</ul></div>', 
                                     'depth' => 2, 
                                     'walker' => new Walker_Main_Menu) );
                            }
			?>
		    </nav>
		</div>
	 
    </header>