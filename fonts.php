<?php
function wp_sifr_update_fonts(){
	$folder_fonts = wp_sifr_fonts_folder();
	$db_fonts = get_option('wp-sifr');
	
	wp_sifr_db_update( $folder_fonts, $db_fonts );
}

function wp_sifr_get_fonts_dir(){
	$plugin_dir = ABSPATH.'wp-content'.'/plugins'.'/wp-sifr/fonts/';
	$template_dir = ABSPATH.'wp-content'. str_replace(get_bloginfo('wpurl').'/wp-content', '', get_bloginfo('template_directory').'/fonts/');
	
	$files = array();
	if( is_dir($template_dir) ){
		if( $dh = opendir($template_dir) ){
			while( false !== ($filename = readdir($dh)) ){
				array_push($files, $filename);
			}
        	closedir($dh);
		}
	}
	$custom_dir = ( 2 < count($files) ) ? $template_dir : $plugin_dir;
	
	return $custom_dir;
}
function wp_sifr_fonts_folder(){
	$dir = wp_sifr_get_fonts_dir();
	$dh = opendir($dir);
	
	$filetype = "swf";
	$output = array();
	while( $file = readdir($dh) ){
		$the_type = strrchr($file, ".");
		$is_swf = stripos($the_type, $filetype);
		
		if( $file != "." and $file != ".." and $is_swf ){
			$font_name = str_replace('.'.$filetype, '', $file);
			#$font_name = str_replace('_', ' ', $file);
			array_push($output, $font_name);
		}
	}
	closedir($dh);
	
	return $output;
}
function wp_sifr_db_update( $folder_fonts, $db_fonts ){
	$new_db_fonts = array();
	foreach( $db_fonts as $db_font ){
		if( in_array($db_font['name'], $folder_fonts) ){
			$new_db_fonts[$db_font['name']] = array_merge( wp_sifr_default_settings($db_font['name']), $db_font );
		}
	}
	foreach( $folder_fonts as $font ){
		if( !array_key_exists($font, $db_fonts) ) $new_db_fonts[$font] = wp_sifr_default_settings($font);
	}
	$new_db_fonts = wp_sifr_order($new_db_fonts);
	wp_sifr_update_option( 'wp-sifr', $new_db_fonts );
}
function wp_sifr_order_cmp( $a, $b ){
	return ( strcmp( $a['order'], $b['order'] ) );
}
function wp_sifr_order( $array ){
	uasort($array, 'wp_sifr_order_cmp');
	return $array;
}
function wp_sifr_update_option( $option, $value ){
	$options = get_option($option);
	if( $options && count($options) > 0 ){
		update_option($option, $value);
	}else{
		delete_option($option);
		add_option($option, $value);
	}
}
function wp_sifr_default_settings( $font_name = '' ){
	$output = array(
		name=>$font_name,
		slug=>str_replace(array(' ','_','-'), array('','',''), $font_name),
		order=>0,
		activate=>0,
		selector=>'h2',
		styles=>".sIFR-root { font-size:24px; font-weight:normal; color:#666666; }\na { text-decoration:none; color:#ad1010; }\na:hover { color:#1d5cd1; }",
		adv=>"wmode: 'transparent'"
	);
	return $output;
}

?>