<?php
/* WP sIFR Options Page
-------------------------------------------------------------------------------------- */
function wp_sifr_add_pages(){
    add_options_page('WP sIFR', 'WP sIFR', 8, 'wpsifr', 'wp_sifr_options_page');
}
add_action('admin_menu', 'wp_sifr_add_pages');
function wp_sifr_options_page(){
	wp_sifr_update_fonts();
	
	if( $_REQUEST['submit'] ){
		update_wp_sifr_options();
	}
	echo '<div class="wrap">'."\n";
	echo '<h2>WP sIFR Options</h2>'."\n";
	
	print_wp_sifr_form();
	
	echo '</div>'."\n";
}
function update_wp_sifr_options(){
	$new_options = $options = get_option('wp-sifr');
	foreach( $options as $option ){
		$font_name = $option['name'];
		$font_slug = $option['slug'];
		$wp_sifr_activate = $_REQUEST['wp_sifr_activate_'.$font_slug];
		if( $wp_sifr_activate ){
			$new_options[$font_name]['activate'] = 1;
		}else{
			$new_options[$font_name]['activate'] = 0;
		}
		$new_options[$font_name]['selector'] = $_REQUEST['wp_sifr_selector_'.$font_slug];
		$new_options[$font_name]['styles'] = $_REQUEST['wp_sifr_styles_'.$font_slug];
		$new_options[$font_name]['adv'] = stripslashes( $_REQUEST['wp_sifr_adv_'.$font_slug] );
		$new_options[$font_name]['order'] = intval($_REQUEST['wp_sifr_order_'.$font_slug]);
		$new_options = wp_sifr_order($new_options);
	}
	
	if( $options ){
		wp_sifr_update_option('wp-sifr', $new_options);
		echo '<div id="message" class="updated fade">';
		echo '<p>Options updated</p>';
		echo '</div>';
	} else {
		echo '<div id="message" class="error fade">';
		echo '<p>Unable to update options</p>';
		echo '</div>';
	}
}
function print_wp_sifr_form(){
	$fonts = get_option('wp-sifr');
	
	$output  = '<form method="post">'."\n";
	$output .= '<p>After fonts are created in Flash, upload them to the "fonts" directory in the plugin folder and they will show up here. Then you can activate and manage the font settings.</p>'."\n";
	$output .= '<p>To create a font, you can upload your TTF file to <a href="http://www.sifrgenerator.com/" title="Link to sIFR Generator" target="_blank">sIFR Generator</a>. Or you can use <a href="http://wiki.novemberborn.net/sifr3/How+to+use#main" title="Link to sIFR Wiki" target="_blank">sIFR Wiki</a>. Be sure to remove any spaces from the file name or you will have trouble ("timesnewroman.swf" = GOOD | "times new roman.swf" = BAD).</p>'."\n";
	$output .= '<p>If you are using a more specific version of a general selector that you are already using, make sure the most specific version is ordered first. (e.g. "h1.foo" should be higher on the page than "h1".</p>'."\n";
	$output .= '<table class="form-table">'."\n";
	
	foreach( $fonts as $font ){
		$output .= print_wp_sifr_form_font($font);
	}
	
	$output .= '</table>'."\n";

	$output .= '<p class="submit"><input type="submit" name="submit" value="Save Changes" class="button-primary" />'."\n";
	$output .= '</p>'."\n";
	
	$output .= '</form>'."\n";
	
	$output .= '<p>&hearts; If you find this plugin useful:</p><ol style="list-style:decimal; padding-left:36px;">';
	$output .= '<li>Please rate it 5 Stars at the <a href="http://wordpress.org/extend/plugins/wp-sifr/" target="_blank">Wordpress Plugin Directory</a>.</li>'."\n";
	$output .= '<li><a href="post-new.php" target="_blank">Spread the word</a>.</li>'."\n";
	$output .= '<li><a href="http://labs.jcow.com/donate/" target="_blank">Send a beer</a>! There is no better motivation to continue development. :)</li>'."\n";
	$output .= '</ol>'."\n";
	
	echo $output;
}
function print_wp_sifr_form_font( $font ){
	$font_name = $font['name'];
	$font_slug = $font['slug'];
	$font_order = $font['order'];
	$font_activate = $font['activate'];
	$font_selector = $font['selector'];
	$font_styles = $font['styles'];
	$font_adv = $font['adv'];
	
	$output .= '<tr valign="middle">'."\n";
	$output .= '<th scope="row"><h3 class="'. $font_slug .'">'. $font_name .'</h3></th><td>';
		$output .= '<label for="wp_sifr_activate_'. $font_slug .'">Activate this font:</label>';
			$output .= '<input type="checkbox" name="wp_sifr_activate_'. $font_slug .'" value="1"';
				$output .= ($font_activate == 1) ? ' checked="checked"' : '';
				$output .= ' />'."\n";
		$output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="jQuery(this).parent().parent().next().toggle();">Settings</a>';
		$output .= '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="jQuery(this).parent().parent().next().next().toggle();">Advanced Settings</a>';
		$output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="wp_sifr_order_'. $font_slug .'">Order: </label>';
			$output .= '<input style="width:35px" type="text" name="wp_sifr_order_'. $font_slug .'" value="'. $font_order .'" /> (-9 thru 9)'."\n";
	$output .= '</td></tr>'."\n";
	
	$output .= '<tr style="display:none;"><td colspan="2"><table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">';
	
		$output .= '<tr valign="top">'."\n";
		$output .= '<th scope="row"><label for="wp_sifr_selector_'. $font_slug .'">Item to Replace (Selector):</label></th>'."\n";
		$output .= "<td><input style='width:35%' type='text' name='wp_sifr_selector_". $font_slug ."' value='". $font_selector ."' /> Reference like CSS (e.g. 'div#sidebar h2')</td>"."\n";
		$output .= '</tr>'."\n";
		
		$output .= '<tr valign="top">'."\n";
		$output .= '<th scope="row"><label for="wp_sifr_styles_'. $font_slug .'">CSS / Styles (.sIFR-root):</label></th>'."\n";
		$output .= '<td><textarea rows="4" style="width:100%" type="text" name="wp_sifr_styles_'. $font_slug .'">'. $font_styles .'</textarea></td>'."\n";
		$output .= '</tr>'."\n";
	
	$output .= '</table></td></tr>';
	$output .= '<tr style="display:none;"><td colspan="2"><table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">';
	
		$output .= '<tr valign="top">'."\n";
		$output .= '<th scope="row"><label for="wp_sifr_adv_'. $font_slug .'">Advanced Settings:</label></th>'."\n";
		$output .= '<td><textarea rows="5" style="width:100%" type="text" name="wp_sifr_adv_'. $font_slug .'">'. $font_adv .'</textarea></td>'."\n";
		$output .= '</tr>'."\n";
	
	$output .= '</table></td></tr>';
	
	return $output;
}
?>