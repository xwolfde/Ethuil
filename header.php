<?php
/**
 * Header 
 * @since Ethuil 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php get_template_part( 'template-parts/meta', 'sprungmarken' ); ?>
    <header aria-label="<?php _e("Seitenkopf","ethuil"); ?>">
        <?php get_template_part( 'template-parts/header', 'logo' ); ?>
	
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
    </header>