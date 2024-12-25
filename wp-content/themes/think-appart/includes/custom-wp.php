<?php


/*************************************************************************/
/*                           CUSTOM MENU                                 */
/*************************************************************************/
add_action( 'admin_menu', 'custom_menu',100);
function custom_menu(){
	// remove_menu_page( 'index.php' );                  //Dashboard
	remove_menu_page( 'edit.php' );                   //Posts
	// remove_menu_page( 'upload.php' );                 //Media
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	remove_menu_page( 'themes.php' );                 //Appearance
	remove_menu_page( 'plugins.php' );                //Plugins
	remove_menu_page( 'users.php' );                  //Users
	remove_menu_page( 'tools.php' );                  //Tools
	remove_menu_page( 'options-general.php' );        //Settings
	remove_menu_page( 'edit.php?post_type=acf-field-group' );     //Custom Fields

	add_menu_page("Home", "Home",'edit_posts','post.php?post=7&action=edit','', 'dashicons-admin-home', '4');
	add_submenu_page('edit.php?post_type=works', 'Works page', 'Works page','edit_posts','post.php?post=11&action=edit','');
	add_menu_page("About", "About",'edit_posts','post.php?post=9&action=edit','', 'dashicons-id', '6');
	
	add_submenu_page('config-think-appart', 'Customizar tema', 'Customizar tema','edit_posts','customize.php?return=index.php','');


}


add_filter('parent_file', 'jg_parent_file');

function jg_parent_file($parent_file){
	global $submenu_file;

	if (isset($_GET['post']) && $_GET['post'] == 7){ $submenu_file = 'post.php?post=7&action=edit'; $parent_file = 'post.php?post=7&action=edit';}
	elseif (isset($_GET['post']) && $_GET['post'] == 9){ $submenu_file = 'post.php?post=9&action=edit'; $parent_file = 'post.php?post=9&action=edit';}
	elseif (isset($_GET['post']) && $_GET['post'] == 11){ $submenu_file = 'post.php?post=11&action=edit'; $parent_file = 'edit.php?post_type=works';}

	return $parent_file;
}


/*************************************************************************/
/*                         REMOVE INCLUDES WP                            */
/*************************************************************************/
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}

function disable_wp_emojicons() {

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
add_action( 'init', 'disable_wp_emojicons' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'wp_head', 'rel_canonical');
remove_action( 'wp_head', 'wp_resource_hints', 2 ); //dns-prefetch

add_filter( 'rest_endpoints', function( $endpoints ){
	return [];
});

