<?php
/**
 * Additional features to allow styling of the templates
 */

 /*-----------------------------------------------------------------------------------*/
 /* Extends the default WordPress body classes
 /*-----------------------------------------------------------------------------------*/
 function ethuil_body_class( $classes ) {
    global $defaultoptions;


    $header_image = get_header_image();
    if (empty( $header_image ) ) {	
	$classes[] = 'nologo';
    }
    
    $sitetitle = get_bloginfo( 'title' );
    if (strlen($sitetitle) > 50) {
	$classes[] = 'longtitle';
    }

    return $classes;
 }
 add_filter( 'body_class', 'ethuil_body_class' );
/*-----------------------------------------------------------------------------------*/
/* Add Class for protected pages
/*-----------------------------------------------------------------------------------*/
 function ethuil_protected_attribute ($classes, $item) {
	if($item->post_password != '')	{
		$classes[] = 'protected-page';
	}
	return $classes;
}
add_filter('page_css_class', 'ethuil_protected_attribute', 10, 3);

/*-----------------------------------------------------------------------------------*/
/* Define errorpages 401 and 403
/*-----------------------------------------------------------------------------------*/
function ethuil_prefix_custom_site_icon_size( $sizes ) {
   $sizes[] = 64;
   $sizes[] = 120;
   return $sizes;
}
add_filter( 'site_icon_image_sizes', 'ethuil_prefix_custom_site_icon_size' );
 
function ethuil_prefix_custom_site_icon_tag( $meta_tags ) {
   $meta_tags[] = sprintf( '<link rel="icon" href="%s" sizes="64x64" />', esc_url( get_site_icon_url( null, 64 ) ) );
   $meta_tags[] = sprintf( '<link rel="icon" href="%s" sizes="120x120" />', esc_url( get_site_icon_url( null, 120 ) ) );
 
   return $meta_tags;
}
add_filter( 'site_icon_meta_tags', 'ethuil_prefix_custom_site_icon_tag' );

/*-----------------------------------------------------------------------------------*/
/* Get Image Attributs / Extends https://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
/*-----------------------------------------------------------------------------------*/
function ethuil_get_image_attributs($id=0) {
        $precopyright = '';
        if ($id==0) return;
        
        $meta = get_post_meta( $id );
        if (!isset($meta)) {
	    return;
        }
    
        $result = array();
	if (isset($meta['_wp_attachment_image_alt'][0])) {
	    $result['alt'] = trim(strip_tags($meta['_wp_attachment_image_alt'][0]));
	} else {
	    $result['alt'] = "";
	}   

        if (isset($meta['_wp_attachment_metadata']) && is_array($meta['_wp_attachment_metadata'])) {        
	    $data = unserialize($meta['_wp_attachment_metadata'][0]);
	    if (isset($data['image_meta']) && is_array($data['image_meta'])) {
		if (isset($data['image_meta']['copyright'])) {
		       $result['copyright'] = trim(strip_tags($data['image_meta']['copyright']));
		}
		if (isset($data['image_meta']['author'])) {
		       $result['author'] = trim(strip_tags($data['image_meta']['author']));
		} elseif (isset($data['image_meta']['credit'])) {
		       $result['credit'] = trim(strip_tags($data['image_meta']['credit']));
		}
		if (isset($data['image_meta']['title'])) {
		     $result['title'] = $data['image_meta']['title'];
		}
		if (isset($data['image_meta']['caption'])) {
		     $result['caption'] = $data['image_meta']['caption'];
		}
	    }
	    if (isset($data['width'])) {
		$result['orig_width'] = $data['width'];
	    }
	    if (isset($data['height'])) {
		$result['orig_height'] = $data['height'];
	    }
	    if (isset($data['file'])) {
		$result['orig_file'] = $data['file'];
	    }
	    
        }
	if (isset($meta['_wp_attached_file']) && is_array($meta['_wp_attached_file'])) {
	    $result['attachment_file'] = $meta['_wp_attached_file'][0];
	} 
	
        $attachment = get_post($id);
	$result['excerpt'] = $result['credits'] = $result['description']= $result['title'] = '';
        if (isset($attachment) ) {
	   
	    if (isset($attachment->post_excerpt)) {
		$result['excerpt'] = trim(strip_tags( $attachment->post_excerpt ));
	    }
	    if (isset($attachment->post_content)) {
		$result['description'] = trim(strip_tags( $attachment->post_content ));
	    }        
	    if (isset($attachment->post_title) && (empty( $result['title']))) {
		 $result['title'] = trim(strip_tags( $attachment->post_title )); 
	    }   
        }      
	$info_credits = get_theme_mod('advanced_images_info_credits');
	if ($info_credits) {
	    
	    if (!empty($result['description'])) {
		$result['credits'] = $result['description'];
	    } elseif (!empty($result['copyright'])) {
		$result['credits'] = $precopyright.' '.$result['copyright'];	
	    } elseif (!empty($result['author'])) {
		$result['credits'] = $precopyright.' '.$result['author'];
	    } elseif (!empty($result['credit'])) {
		$result['credits'] = $precopyright.' '.$result['credit'];	
   	    } else {
		if (!empty($result['caption'])) {
		    $result['credits'] = $result['caption'];
		} elseif (!empty($result['excerpt'])) {
		    $result['credits'] = $result['excerpt'];
		} 
	    } 
	} else {
	
	    if (!empty($result['copyright'])) {
		$result['credits'] = $precopyright.' '.$result['copyright'];		
	    } elseif (!empty($result['author'])) {
		$result['credits'] = $precopyright.' '.$result['author'];
	    } elseif (!empty($result['credit'])) {
		$result['credits'] = $precopyright.' '.$result['credit'];		
	    } else {
		if (!empty($result['description'])) {
		    $result['credits'] = $result['description'];
		} elseif (!empty($result['caption'])) {
		    $result['credits'] = $result['caption'];
		} elseif (!empty($result['excerpt'])) {
		    $result['credits'] = $result['excerpt'];
		} 
	    }   
	}
        return $result;               
}


/*-----------------------------------------------------------------------------------*/
/* Force srcset urls to be relative
/*-----------------------------------------------------------------------------------*/
add_filter( 'wp_calculate_image_srcset', function( $sources ) {
    if(	! is_array( $sources ) )
       	return $sources;

    foreach( $sources as &$source ) {
        if( isset( $source['url'] ) )
            $source['url'] = fau_esc_url( $source['url']);
    }
    return $sources;

}, PHP_INT_MAX );


 
 /*-----------------------------------------------------------------------------------*/
 /* Custom template tags: Functions for templates and output
 /*-----------------------------------------------------------------------------------*/
function ethuil_load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

/*-----------------------------------------------------------------------------------*/
/*  Returns language code, without subcode
/*-----------------------------------------------------------------------------------*/
function ethuil_get_language_main () {
    $charset = explode('-',get_bloginfo('language'))[0];
    return $charset;
}


/*-----------------------------------------------------------------------------------*/
/* Change WordPress default language attributes function to 
 * strip of region code parts. Not used yet /anymore
/*-----------------------------------------------------------------------------------*/
function ethuil_get_language_attributes ($doctype = 'html' ) {
    $attributes = array();
	
    if ( function_exists( 'is_rtl' ) && is_rtl() )
	    $attributes[] = 'dir="rtl"';
    
    if ( $langcode = fau_get_language_main() ) {
	    if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
		    $attributes[] = "lang=\"$langcode\"";

	    if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
		    $attributes[] = "xml:lang=\"$langcode\"";
    }	
    $output = implode(' ', $attributes);
    return $output;
}



/*-----------------------------------------------------------------------------------*/
/* This is the end :)
/*-----------------------------------------------------------------------------------*/

