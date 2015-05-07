<?php
/*
Plugin Name: Site Administrator
Plugin URI: http://www.greenmellenmedia.com/plugins/gm-site-admin/
Description: Adds Site Admin User Role
Version: 1.0.2
Author: GreenMellen Media
Author URI: http://www.greenmellenmedia.com/
License: GPLv2 or later

Copyright 2015 Green Mellen Media

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * @since: 1.0.2
 * @desc: Will run at activation of the plugin
 */
function gm_site_admin_activate() {
	remove_role ( 'site-admin' );
	add_role( 'site-admin', 'Site Administrator', array(
		//Site Admin Can Read Posts & Pages
		'read'                   => true,
		'read_private_pages'     => true,
		'read_private_posts'     => true,
		//Site Admin Can Publish, Edit & Delete Posts & Pages
		'publish_pages'          => true,
		'publish_posts'          => true,
		'edit_others_pages'      => true,
		'edit_others_posts'      => true,
		'edit_pages'             => true,
		'edit_posts'             => true,
		'edit_private_pages'     => true,
		'edit_private_posts'     => true,
		'edit_published_pages'   => true,
		'edit_published_posts'   => true,
		'delete_others_pages'    => true,
		'delete_others_posts'    => true,
		'delete_pages'           => true,
		'delete_posts'           => true,
		'delete_private_pages'   => true,
		'delete_private_posts'   => true,
		'delete_published_pages' => true,
		'delete_published_posts' => true,
		//Site Admin Can Manage Categories, Links and Moderate Comments
		'manage_categories'      => true,
		'manage_links'           => true,
		'moderate_comments'      => true,
		//Site Admin Can Post HTML markup or even JavaScript code in pages, posts, comments and widgets
		'unfiltered_html'        => true,
		//Site Admin Can Upload Files
		'upload_files'           => true,
		//Site Admin Can Create, Edit & Delete Users
		'list_users'             => true,
		'edit_users'             => true,
		'add_users'              => true,
		'create_users'           => true,
		'delete_users'           => true,
		'remove_users'           => true,
		'promote_users'          => true,
		//Site Admin Cannot Switch Themes, But They Can Edit Theme Options
		'edit_theme_options'     => true,
		'switch_themes'          => false,
		//Site Admin Cannot Activate, Update or Delete Plugins
		'update_plugins'         => false,
		'delete_plugins'         => false,
		'activate_plugins'       => false,
		//Site Admin Cannot Export or Import
		'export'                 => false,
		'import'                 => false,
	) );
}
register_activation_hook( __FILE__, 'gm_site_admin_activate' );


//Removes Additional Menus
function gm_site_admin_menu() {

	$user = new WP_User( get_current_user_id() );
	if ( ! empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ) {
			$role = $role;
		}
	}

	if ( $role == "site-admin" ) {
		remove_menu_page( 'link-manager.php' );
		remove_menu_page( 'tools.php' );
		remove_submenu_page( 'themes.php', 'themes.php' );
	}
}

add_action( 'admin_menu', 'gm_site_admin_menu' );

//Removes Customizer / Header / Custom Background
function gm_remove_customize() {
	$customize_url_arr   = array();
	$customize_url_arr[] = 'customize.php'; // 3.x
	$customize_url       = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
	$customize_url_arr[] = $customize_url; // 4.0 & 4.1
	if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize' ) ) {
		$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
		$customize_url_arr[] = 'custom-header'; // 4.0
	}
	if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize' ) ) {
		$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
		$customize_url_arr[] = 'custom-background'; // 4.0
	}
	foreach ( $customize_url_arr as $customize_url ) {
		remove_submenu_page( 'themes.php', $customize_url );
	}
}

add_action( 'admin_menu', 'gm_remove_customize', 999 );



function gm_site_admin_deactivate() {
	remove_role( 'site-admin' );
}

register_deactivation_hook( __FILE__, 'gm_site_admin_deactivate' );

?>
