<?php
/*
Plugin Name: Site Administrator
Plugin URI: http://www.greenmellenmedia.com/plugins/gm-site-admin/
Description: Adds Site Admin User Role
Version: 1.0
Author: GreenMellen Media
Author URI: http://www.greenmellenmedia.com/
License: GPLv2 or later
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_role('site-admin', 'Site Administrator', array(
	//Site Admin Can Read Posts & Pages
	'read' => true,
	'read_private_pages' => true,
	'read_private_posts' => true,

	//Site Admin Can Publish, Edit & Delete Posts & Pages
	'publish_pages' => true,
	'publish_posts' => true,
	'edit_others_pages' => true,
	'edit_others_posts' => true,
	'edit_pages' => true,
	'edit_posts' => true,
	'edit_private_pages' => true,
	'edit_private_posts' => true,
	'edit_published_pages' => true,
	'edit_published_posts' => true,
	'delete_others_pages' => true,
	'delete_others_posts' => true,
	'delete_pages' => true,
	'delete_posts' => true,
	'delete_private_pages' => true,
	'delete_private_posts' => true,
	'delete_published_pages' => true,
	'delete_published_posts' => true,

	//Site Admin Can Manage Categories, Links and Moderate Comments
	'manage_categories' => true,
	'manage_links' => true,
	'moderate_comments' => true,

	//Site Admin Can Post HTML markup or even JavaScript code in pages, posts, comments and widgets
	'unfiltered_html' => true,
	
	//Site Admin Can Upload Files
	'upload_files' => true,

	//Site Admin Can Create, Edit & Delete Users
	'edit_users' => true,
	'create_users' => true,
	'delete_users' => true,


	//Site Admin Cannot Switch Themes, But They Can Edit Theme Options
	'edit_theme_options' => true, 
	'switch_themes' => false,

	//Site Admin Cannot Activate, Update or Delete Plugins	
	'update_plugins' => false,
	'delete_plugins' => false,
	'activate_plugins' => false, 

	//Site Admin Cannot Export or Import	
	'export' => false,
	'import' => false,


	
));


//Removes Additional Menus
function gm_site_admin_menu() {

$user = new WP_User(get_current_user_id());
if (!empty( $user->roles) && is_array($user->roles)) {
foreach ($user->roles as $role)
$role = $role;
}

if($role == "site-admin") {
remove_menu_page( 'link-manager.php' ); 
remove_menu_page( 'tools.php' ); 
remove_submenu_page( 'themes.php', 'themes.php' );
}
}

add_action('admin_menu', 'gm_site_admin_menu');

//Removes Customizer / Header / Custom Background
function gm_remove_customize() {
    $customize_url_arr = array();
    $customize_url_arr[] = 'customize.php'; // 3.x
    $customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
    $customize_url_arr[] = $customize_url; // 4.0 & 4.1
    if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize') ) {
        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
        $customize_url_arr[] = 'custom-header'; // 4.0
    }
    if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize') ) {
        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
        $customize_url_arr[] = 'custom-background'; // 4.0
    }
    foreach ( $customize_url_arr as $customize_url ) {
        remove_submenu_page( 'themes.php', $customize_url );
    }
}
add_action( 'admin_menu', 'gm_remove_customize', 999 );


?>