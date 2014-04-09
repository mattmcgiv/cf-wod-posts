<?php

/**
 * Plugin Name: CF Wod Posts
 * Description: Provides the ability to create a WOD post in WordPress.
 * Version: 1.0
 * Author: Matt McGivney
 * Author URI: http://antym.com
 * License: GPL2
 */
 
 /*  Copyright 2014 Matt McGivney  (email : matt@antym.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	add_action( 'init', 'create_post_type' );
	
	function create_post_type() {
		register_post_type( 'cf_wod',
			array(
				'labels' => array(
					'name' => __( 'WODs' ),
					'singular_name' => __( 'WOD' ),
					'add_new' => 'Add New',
					'add_new_item' => 'Add New WOD',
					'edit' => 'Edit',
					'edit_item' => 'Edit WOD',
					'new_item' => 'New WOD',
					'view' => 'View',
					'view_item' => 'View WOD',
					'search_items' => 'Search WODs',
					'not_found' => 'No WODs found',
					'not_found_in_trash' => 'No WODs found in trash'
				),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'WODs'),
			'menu_icon' => 'dashicons-star-filled',
			'supports' => array('title', 'editor', 'author', 'comments')
			)
		);
	} 

	/*
	* Adds custom post type to main query so the WODs mix in with other
	* posts (like blog posts).
	*/
	
	add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
	
	function add_my_post_types_to_query( $query ) {
		
			echo("<script>console.log('Reading wod_display setting.');</script>");
		
		if (get_option('wods_in_main')) {
			
			echo("<script>console.log('wod_display... returned true,inside if statement');</script>");
			
			if ( is_home() && $query->is_main_query() ) {
					$query->set( 'post_type', array( 'post', 'cf_wod' ) );
			}
			return $query;
		}		
	}

	/**
	* Initializes settings by registering the section, fields etc.
	*
	*/

	add_action('admin_init', 'initialize_wod_options');		
	function initialize_wod_options() {
		
		//Add the setting section to the reading page
		add_settings_section( 'wod_settings_id', 'WOD Settings', 'wod_settings_callback', 'reading' );
		
		// Add the field for toggling whether or not WODs show up in the main query.
		add_settings_field( 
	    	'wods_in_main',
			'WODs in main query?',
			'toggle_wods_main_query_callback',
			'reading',
			'wod_settings_id',
			array('Activate this setting to have the WODs display in the main query alongside other posts (like blog posts).')
		);	
		
		// Finally, we register the fields with WordPress
		register_setting(
			'reading',
			'wods_in_main'
		);
	}
	
	//implementing the callback identified in the add_settings_setion(...) call above
	function wod_settings_callback() {
		echo '<p>Select how you would like to display WODs.</p>';
	}
	
	//implementing the callback identified in the add_settings_section(...) call above
	function toggle_wods_main_query_callback($args) {
	
	// Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
    $html = '<input type="checkbox" id="wods_in_main" name="wods_in_main" value="1" ' . checked(1, get_option('wods_in_main'), false) . '/>';
     
    // Here, we will take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="wods_in_main"> '  . $args[0] . '</label>';
     
    echo $html;	}
?>