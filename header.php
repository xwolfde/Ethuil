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
        
        <?php get_template_part( 'template-parts/header', 'logo' ); 
       
        if(has_nav_menu( 'main-menu' )) { ?>
	<nav class="main-menu" aria-label="<?php _e("Hauptnavigation","fau"); ?>">
            <button class="navbar-toggler" type="button" 
                     data-toggle="collapse" 
                     data-target="#navbarSupportedContent"
                     aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php
                wp_nav_menu( array( 
                     'theme_location' => 'main-menu', 
                     'container' => false,
                     'items_wrap' => '<div class="collapse navbar-collapse" id="navbarSupportedContent"><ul>%3$s</ul></div>', 
                     'depth' => 2, 
                     'walker' => new Walker_Main_Menu) );
                ?>
	</nav>
        <?php } ?>
    </header>