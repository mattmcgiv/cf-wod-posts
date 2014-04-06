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
	

	add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
	
	function add_my_post_types_to_query( $query ) {
		if ( is_home() && $query->is_main_query() )
				$query->set( 'post_type', array( 'post', 'cf_wod' ) );
		return $query;
	}*/
	
		/** Add WOD plugin menu to admin area*/
		add_action( 'admin_menu', 'cf_wod_menu' );

		/** Add options page  */
		function cf_wod_menu() {
			add_options_page( 'WOD Options', 'CF WOD Posts', 'manage_options', 'cf_wod', 'wod_options' );
		}

		/** Step 3. */
		function wod_options() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ));
			}		
		
			echo '<h2>CF WOD Posts Settings</h2>';	
			echo '<form action="">';
			echo '<input type="checkbox" name="cf-wod-main-query" value="main-query">Add WODs to main WordPress query<br>'; 
			echo '<p>Use this option if you want to have WODs show up along other posts (like blog posts) on the page that shows your posts.</p>';
			echo '<p>The page that shows your posts can usually be set by changing your "Posts page" in Settings->Reading, but is also influenced by your theme.</p>';
			echo '</form>';
			
			echo '<p class="submit">';
			echo '<input type="submit" name="Submit" class="button-primary" value="Save" />';
			echo '</p>';
		
		}
?>