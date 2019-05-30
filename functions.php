<?php
/**
 * @package WordPress
 * @since Ethuil 1.0
 */

load_theme_textdomain( 'ethuil', get_template_directory() . '/languages' );
require_once( get_template_directory() . '/includes/template-functions.php' );
require_once( get_template_directory() . '/includes/defaults.php' );
require_once( get_template_directory() . '/includes/sanitizer.php' );

require_once( get_template_directory() . '/includes/customizer.php');
$options = ethuil_initoptions();

/*-----------------------------------------------------------------------------------*/
/* Setup
/*-----------------------------------------------------------------------------------*/
function ethuil_setup() {
    global $defaultoptions;

    if ( ! isset( $content_width ) ) $content_width = $defaultoptions['content-width'];


    add_theme_support( 'html5');
    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails' );
        // Add Thumbnails
    ethuil_register_menus();
        // Register Menus
}
add_action( 'after_setup_theme', 'ethuil_setup' );
/*-----------------------------------------------------------------------------------*/
/* Register Menus in Theme
/*-----------------------------------------------------------------------------------*/
function ethuil_register_menus() {
    register_nav_menu( 'main-menu', __( 'Haupt-Navigation', 'ethuil' ) );
	// Hauptnavigation
}
/*-----------------------------------------------------------------------------------*/
/* Set extra init values
/*-----------------------------------------------------------------------------------*/
function ethuil_custom_init() {
    /* Keine verwirrende Abfrage nach Kommentaren im Page-Editor */
    remove_post_type_support( 'page', 'comments' );

    /* Disable Emojis */
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'ethuil_custom_init' );

/*-----------------------------------------------------------------------------------*/
/* Enqueues scripts and styles for front end.
/*-----------------------------------------------------------------------------------*/
function ethuil_register_scripts() {
    global $defaultoptions;
    
    $theme_data = wp_get_theme();
    $theme_version = $theme_data->Version;

    wp_register_style('ethuil-style',  get_stylesheet_uri(), array(), $theme_version);
	// Base Style
    wp_register_script('ethuil-scripts', $defaultoptions['src-scriptjs'], array('jquery'), $theme_version, true );
	// Base Scripts   
	
}
add_action('init', 'ethuil_register_scripts');

/*-----------------------------------------------------------------------------------*/
/* Activate base scripts
/*-----------------------------------------------------------------------------------*/
function ethuil_basescripts_styles() {
    wp_enqueue_style( 'ethuil-style');	
  //  wp_enqueue_script( 'ethuil-scripts');
}
add_action( 'wp_enqueue_scripts', 'ethuil_basescripts_styles' );

/*-----------------------------------------------------------------------------------*/
/* Remove type-String from link-reference to follow W3C Validator
/*-----------------------------------------------------------------------------------*/
function ethuil_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
add_filter('style_loader_tag', 'ethuil_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'ethuil_remove_type_attr', 10, 2);

/*-----------------------------------------------------------------------------------*/
/* Change default header
/*-----------------------------------------------------------------------------------*/
function ethuil_addmetatags() {

    $output = "";
    $output .= '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo('charset').'">'."\n";
    $output .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n";    
    
    $googleverification = get_theme_mod('google-site-verification');
    if ((isset( $googleverification )) && ( !ethuil_empty($googleverification) )) {
        $output .= '<meta name="google-site-verification" content="'.$googleverification.'">'."\n";
    }

    // Adds RSS feed links to <head> for posts and comments.
    // add_theme_support( 'automatic-feed-links' );
    // Will post both: feed and comment feed; To use only main rss feed, i have to add it manually in head
    $title = sanitize_text_field(get_bloginfo( 'name' ));
    $output .= '<link rel="alternate" type="application/rss+xml" title="'.$title.' - RSS 2.0 Feed" href="'.get_bloginfo( 'rss2_url').'">'."\n";
    
    echo $output;
}
add_action('wp_head', 'ethuil_addmetatags',1);

/*-----------------------------------------------------------------------------------*/
/* Change default DNS prefetch
/*-----------------------------------------------------------------------------------*/
function ethuil_remove_default_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }

    return $hints;
}
add_filter( 'wp_resource_hints', 'ethuil_remove_default_dns_prefetch', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*  Remove something out of the head
/*-----------------------------------------------------------------------------------*/
function ethuil_remove_unwanted_head_actions() {
    remove_action( 'wp_head', 'post_comments_feed_link ', 2 ); 
        // Display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'rsd_link' ); 
        // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' ); 
        // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
        // remove prev link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); 
        // remove Display relational links for the posts adjacent to the current post.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links'         ); 
        // remove oEmbed discovery links in the website 

    remove_action('wp_head', '_admin_bar_bump_cb');
        // remove Inline CSS to display WordPress Admin Bar
        // we move this into our CSS-file - see: css/sass/backend/wordpress 	
    if (!is_user_logged_in()) {
        // remove admin settings in footer if not logged in
        remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
        add_filter( 'show_admin_bar', '__return_false' );
    }

}
add_action('wp_head', 'ethuil_remove_unwanted_head_actions', 0);
/*-----------------------------------------------------------------------------------*/
/* Remove unwanted styles
/*-----------------------------------------------------------------------------------*/
function ethuil_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'ethuil_deregister_styles', 100 );

/*-----------------------------------------------------------------------------------*/
/* Remove unwanted scripts
/*-----------------------------------------------------------------------------------*/
function ethuil_deregister_scripts(){
 wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'ethuil_deregister_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Change default title
/*-----------------------------------------------------------------------------------*/
function ethuil_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Seite %s', 'ethuil' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ethuil_wp_title', 10, 2 );


/*-----------------------------------------------------------------------------------*/
/* Header setup
/*-----------------------------------------------------------------------------------*/
function ethuil_custom_header_setup() { 
    global $defaultoptions;
	$args = array(
	    'height'			=> $defaultoptions['default_logo_height'],
	    'width'			=> $defaultoptions['default_logo_width'],
	    'admin-head-callback'	=> 'ethuil_admin_header_style',
	    'header-text'		=> false,
	    'flex-width'		=> true,
	    'flex-height'		=> true,
	);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'ethuil_custom_header_setup' );


/*-----------------------------------------------------------------------------------*/
/* Load Comment Functions
/*-----------------------------------------------------------------------------------*/
require get_template_directory() . '/includes/comments.php';


/*-----------------------------------------------------------------------------------*/
/* This is the end of the code as we know it
/*-----------------------------------------------------------------------------------*/



