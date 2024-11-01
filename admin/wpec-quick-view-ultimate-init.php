<?php
/**
 * Register Activation Hook
 */
update_option('wpec_quick_view_ultimate_plugin', 'wpec_quick_view_ultimate');
function wpec_quick_view_ultimate_install(){
	update_option('wpec_quick_view_ultimate_version', '2.0.0');

	// Set Settings Default from Admin Init
	global $wpec_qv_admin_init;
	$wpec_qv_admin_init->set_default_settings();

	delete_option('wpec_quick_view_lite_clean_on_deletion');

	// Build sass
	global $wpec_qv_less;
	$wpec_qv_less->plugin_build_sass();

	delete_transient("wpec_quick_view_ultimate_update_info");
	update_option('wpec_quick_view_ultimate_just_installed', true);
}

function wpec_quick_view_ultimate_init() {
	if ( get_option('wpec_quick_view_ultimate_just_installed') ) {
		delete_option('wpec_quick_view_ultimate_just_installed');
		wp_redirect( admin_url( 'admin.php?page=wpec-quick-view', 'relative' ) );
		exit;
	}

	wpec_quick_view_ultimate_plugin_textdomain();

	global $wpec_quick_view_template_gallery_thumbnails_settings;

	$thumb_width = $wpec_quick_view_template_gallery_thumbnails_settings['thumb_width'];
	if ( $thumb_width <= 0 ) $thumb_width = 105;
	$thumb_height = $wpec_quick_view_template_gallery_thumbnails_settings['thumb_height'];
	if ( $thumb_height <= 0 ) $thumb_height = 75;
	add_image_size( 'wpec-qv-dynamic-gallery-thumb', $thumb_width, $thumb_height, false  );
}

global $wpec_quick_view_ultimate;

// Add language
add_action('init', 'wpec_quick_view_ultimate_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( $wpec_quick_view_ultimate, 'a3_wp_admin' ) );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( $wpec_quick_view_ultimate, 'admin_sidebar_menu_css' ) );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array( $wpec_quick_view_ultimate, 'plugin_extra_links'), 10, 2 );

// Need to call Admin Init to show Admin UI
global $wpec_qv_admin_init;
$wpec_qv_admin_init->init();

// Add extra link on left of Deactivate link on Plugin manager page
add_action('plugin_action_links_' . WPEC_QV_ULTIMATE_NAME, array( $wpec_quick_view_ultimate, 'settings_plugin_links' ) );

//Ajax Load Custom Template for Popup
add_action('wp_ajax_quick_view_custom_template_load', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_custom_template_load') );
add_action('wp_ajax_nopriv_quick_view_custom_template_load', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_custom_template_load') );

// Ajax load Previous Product
add_action('wp_ajax_quick_view_load_previous_product', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_load_previous_product') );
add_action('wp_ajax_nopriv_quick_view_load_previous_product', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_load_previous_product') );

// Ajax load Next Product
add_action('wp_ajax_quick_view_load_next_product', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_load_next_product') );
add_action('wp_ajax_nopriv_quick_view_load_next_product', array( 'WPEC_Quick_View_Custom_Template', 'quick_view_load_next_product') );

// Check upgrade functions
add_action( 'init', 'a3_wpec_quick_view_upgrade_plugin' );
function a3_wpec_quick_view_upgrade_plugin () {

	if ( version_compare(get_option('wpec_quick_view_ultimate_version'), '2.0.0' ) === -1) {
		update_option('wpec_quick_view_ultimate_version', '2.0.0');

		global $wpec_qv_admin_init;
		$wpec_qv_admin_init->set_default_settings();

		// Build sass
		global $wpec_qv_less;
		$wpec_qv_less->plugin_build_sass();
	}

	update_option('wpec_quick_view_ultimate_version', '2.0.0');

}

?>