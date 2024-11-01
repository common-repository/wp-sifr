<?php
/*
Plugin Name: WP sIFR
Plugin URI: http://labs.jcow.com/plugins/wp-sifr/
Description: Add sIFR to your WP Blog. sIFR version 3r436 (nightly).
Version: 0.6.8.1
Author: Jake Snyder
Author URI: http://Jupitercow.com/
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
*/

/*
Copyright 2009 Jupitercow (http://Jupitercow.com/)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

include (dirname(__FILE__) .'/detect.php');
include (dirname(__FILE__) .'/options.php');
include (dirname(__FILE__) .'/fonts.php');
include (dirname(__FILE__) .'/header.php');

/* Activation */
register_activation_hook(__FILE__, 'wp_sifr_set_options');

/* Deactivation */
register_deactivation_hook(__FILE__, 'wp_sifr_unset_options');

/* Activation/Deactivation Functions
-------------------------------------------------------------------------------------- */
add_action('admin_head', 'wp_sifr_set_options');
function wp_sifr_set_options(){
	$folder_fonts = wp_sifr_fonts_folder();
	
	$options = array();
	foreach( $folder_fonts as $folder_font ){
		$options[$folder_font] = wp_sifr_default_settings($folder_font);
	}
	add_option('wp-sifr', $options, 'Options for WP sIFR');
}
function wp_sifr_unset_options(){
	#delete_option('wp-sifr');
}
?>