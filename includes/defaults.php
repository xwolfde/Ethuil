<?php
/* 
 * Default Constants and values 
 */


$OPTIONS_NAME = 'ethuil_theme_options';
    // Name des Options-Array

$defaultoptions = array(
    'optiontable-version'		=> 1,
	// zaehlt jedesmal hoch, wenn neue Optionen eingefuegt werden 
	// oder Default Optionen geaendert werden. Vorhandene Defaultoptions 
	// in der Options-Table werden nur dann geändert, wenn der Wert erhöht 
	// wurde oder die Theme Options von Hand aufgerufen und gespeichert wurden.
    'js-version'			=> '1.0',
	// Theme-Versionslinie, wird überschrieben durch Style.css Version
    'src-scriptjs'                      => get_template_directory_uri() . '/js/scripts.min.js',
    'default_logo_src'			=> get_template_directory_uri().'/img/logo-240x65.svg',
    'default_logo_height'			=> 65,
    'default_logo_width'			=> 240,

    
    'content-width'			=> 616,
    'content-width-fullpage'		=> 940,
    
    'advanced_activate_post_comments'   => true,
    'advanced_post_active_subtitle' => true,    
    'advanced_comments_notes_before'    => '',
    'advanced_comments_disclaimer'  => '',
     'google-site-verification'	    => '',
    
    
); 

$content_width =$defaultoptions['content-width'];

/*--------------------------------------------------------------------*/
/* Initialisiere Options und Theme Mods 
/*--------------------------------------------------------------------*/
function ethuil_initoptions() {
    global $defaultoptions;
    global $setoptions;
    global $OPTIONS_NAME;
    
    
    $themeopt = get_theme_mods();
    $theme = get_option( 'stylesheet' );
    $theme_data = wp_get_theme();
    $newoptions['version'] =  $theme_data->Version;
    $update_thememods = false;
  
    $theme_opt_version = get_theme_mod('optiontable-version');
    
    if ((!isset($theme_opt_version)) || ($theme_opt_version < $defaultoptions['optiontable-version'])) {
	// Optiontable ist neuer. Prüefe noch die Optionen, die nicht
	// in der Settable stehen und fülle diese ebenfalls in theme_mods:
	
	    $ignoreoptions = array();
	    $update_thememods = false;
	    foreach($setoptions[$OPTIONS_NAME] as $tab => $f) {       
		foreach($setoptions[$OPTIONS_NAME][$tab]['fields'] as $i => $value) {  
		    $ignoreoptions[$i] = $value;
		}
	    }
	    $defaultlist = '';
	    foreach($defaultoptions as $i => $value) {       
		if (!isset($ignoreoptions[$i])) {
		    if (isset($themeopt[$i]) && ($themeopt[$i] !=  $defaultoptions[$i])) {
			$themeopt[$i] = $defaultoptions[$i];	
			$update_thememods = true;
		    } elseif (!isset($themeopt[$i])) {
			$themeopt[$i] = $defaultoptions[$i];	
			$update_thememods = true;
		    }
		}
	    }
	    if ($update_thememods==true) {
		update_option( "theme_mods_$theme", $themeopt );
	    } else {
		// only version number
		set_theme_mod( 'optiontable-version', $defaultoptions['optiontable-version'] ); 
	    }
    }
    
    
    
    return $newoptions;
}
 
/*--------------------------------------------------------------------*/
/* Durch User änderbare Konfigurationen
/*--------------------------------------------------------------------*/
$setoptions = array(
    'ethuil_theme_options'   => array(

       'allgemeines'   => array(
           'tabtitle'   => __('Anzeigeoptionen', 'ethuil'),
	   'user_level'	=> 1,
           'fields' => array(        
                'postoptions'  => array(
                  'type'    => 'section',
                  'title'   => __( 'Beiträge', 'ethuil' ),                      
              ),
                'advanced_activate_post_comments'		  => array(
                  'type'    => 'toggle',
                  'title'   => __( 'Kommentarfunktion', 'ethuil' ),
                  'label'   => __( 'Schaltet die Kommentarfunktion für Beiträge ein. Die Kommentare erscheinen unterhalb des Artikels. Bitte beachten Sie, daß diese Darstellung von Kommentarfunktionen ebenfalls von den Diskussions-Einstellungen abhängig sind.', 'ethuil' ),                
                  'default' => $defaultoptions['advanced_activate_post_comments'],
		  'parent'  => 'postoptions'
		), 
	        'advanced_comments_notes_before'	  => array(
                  'type'    => 'text',
                  'title'   => __( 'Hinweistext Eingabeformular', 'ethuil' ),
                  'label'   => __( 'Informationen über den Eingabefeldern für neue Kommentare.', 'ethuil' ),                
                  'default' => $defaultoptions['advanced_comments_notes_before'],
		  'parent'  => 'postoptions'
		), 
	        'advanced_comments_disclaimer'	  => array(
                  'type'    => 'text',
                  'title'   => __( 'Kommentar-Disclaimer', 'ethuil' ),
                  'label'   => __( 'Hinweistext zur Abgrenzung zum Inhalt der Kommentare.', 'ethuil' ),                
                  'default' => $defaultoptions['advanced_comments_disclaimer'],
		  'parent'  => 'postoptions'
		), 
          )
       ),
      
       'advanced'   => array(
           'tabtitle'   => __('Erweitert', 'ethuil'),
	   'user_level'	=> 1,
	   'capability'    => 'customize',
           'fields' => array(
                'bedienung'  => array(
                  'type'    => 'section',
                  'title'   => __( 'Backend', 'ethuil' ),                      
                ),
                'advanced_post_active_subtitle'	=> array(
                  'type'    => 'toggle',
                  'title'   => __( 'Untertitel (Beiträge)', 'ethuil' ),
                  'label'   => __( 'Erlaube die Eingabe von Untertitel bei Beiträgen.', 'ethuil' ),                
                  'default' => $defaultoptions['advanced_post_active_subtitle'],
		  'parent'  => 'bedienung'
                ),   
                 'google-site-verification' => array(
                  'type'    => 'text',
                  'title'   => __( 'Google Site Verification', 'ethuil' ),
                  'label'   => __( 'Zur Verifikation der Website als Property in den <a target="_blank" href="https://www.google.com/webmasters/tools/home">Google Webmaster Tools</a> wird die Methode über den HTML-Tag ausgewählt. Google erstellt dann auf der Einrichtungsseite eine HTML-Anweisung. Von dieser Anweisung kopiert man den Bestandteil, der im Attribut "content" angegeben ist. <br>Beispiel: <br>Google gibt den HTML-Code: &nbsp; &nbsp;<code>&lt;meta name="google-site-verification" content="BBssyCpddd8" /&gt;</code><br>  Dann geben Sie dies ein: <code>BBssyCpddd8</code> .', 'ethuil' ),               
                  'default' => $defaultoptions['google-site-verification'],
		     'parent'  => 'bedienung'
              ), 
	    ),    
	),    

    )
);
	       
