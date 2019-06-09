<?php
/**
 * Navigation Menu template functions
 * @since Ethuil 1.0
 */


/*-----------------------------------------------------------------------------------*/
/* Register Menus in Theme
/*-----------------------------------------------------------------------------------*/
function ethuil_register_menus() {
    register_nav_menu( 'main-menu', __( 'Hauptnavigation', 'ethuil' ) );
	// Hauptnavigation
}
/*-----------------------------------------------------------------------------------*/
/* Walker for main menu  
/*-----------------------------------------------------------------------------------*/
class Walker_Main_Menu extends Walker_Nav_Menu {
	private $currentID;
	private $level = 1;
	private $count = array();
	private $element;

	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    $this->level++;
	    $this->count[$this->level] = 0;
	    $output .= '<ul>';
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= '</ul>';
            $this->level--;
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    $level = $this->level;
	    $iscurrent =0;
	    $class_names = $value = '';

	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    $classes = ethuil_cleanup_menuclasses($classes);
	    // Generate Classes. Dont use WordPress default, cause i dont want to
	    // get all those unused data filled up my html


	    if (in_array("menu-item-has-children",$item->classes)) {
		$classes[] = 'has-sub';
	    }
	    if (in_array("current-menu-item",$item->classes)) {
		$classes[] = 'current-menu-item';
	    }
	    if (in_array("current-menu-parent",$item->classes)) {
		$classes[] = 'current-menu-parent';
	    }
	    if (in_array("current-page-item",$item->classes)) {
		$iscurrent = 1;
		$classes[] = 'current-page-item';
	    }

	    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
	    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


	    $output .= '<li' . $value . $class_names .'>';

	    $atts = array();
	    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
	    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
	    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
	    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
	    if ($iscurrent==1) {
		$atts['aria-current'] = "page";
	    }
	    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

	    if($this->level == 1) $this->currentID = $item->object_id;

	    $attributes = '';
	    foreach ( $atts as $attr => $value ) {
		    if ( ! empty( $value ) ) {
			    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
			    $attributes .= ' ' . $attr . '="' . $value . '"';
		    }
	    }


	    $item_output = $args->before;
	    $item_output .= '<a'. $attributes .'>';
	    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	    $item_output .= '</a>';
	    $item_output .= $args->after;

	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el(&$output, $item, $depth=0, $args=array()) {
	    $output .= "</li>";
	}
}


/*-----------------------------------------------------------------------------------*/
/* Cleanup Menu Classes from unwanted garbage :) 
/*-----------------------------------------------------------------------------------*/
function ethuil_cleanup_menuclasses($currentarray = array()) {
    $menugarbage = array(
	"menu-item-type-post_type",
	"menu-item-object-page",
	"menu-item-has-children",
        "menu-item"
    );
    return array_diff($currentarray,$menugarbage);
}