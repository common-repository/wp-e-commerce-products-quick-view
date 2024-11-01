<?php
/*
Plugin Name: WP e-Commerce Quick View Ultimate
Description: This plugin adds the ultimate Quick View feature to your stores Product page, Product category and Product tags listings. Opens the full pages content - add to cart, view cart and click to cloase and keep browsing your store.
Version: 2.0.0
Author: a3rev Software
Author URI: https://a3rev.com/
Text Domain: wp-e-commerce-products-quick-view
Domain Path: /languages
License: This software is under commercial license and copyright to A3 Revolution Software Development team

	WP e-Commerce Quick View Ultimate. Plugin for the WP e-Commerce.
	Copyright© 2011 A3 Revolution Software Development team

	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('WPEC_QV_ULTIMATE_FILE_PATH', dirname(__FILE__));
define('WPEC_QV_ULTIMATE_DIR_NAME', basename(WPEC_QV_ULTIMATE_FILE_PATH));
define('WPEC_QV_ULTIMATE_FOLDER', dirname(plugin_basename(__FILE__)));
define('WPEC_QV_ULTIMATE_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WPEC_QV_ULTIMATE_DIR', WP_PLUGIN_DIR . '/' . WPEC_QV_ULTIMATE_FOLDER);
define('WPEC_QV_ULTIMATE_NAME', plugin_basename(__FILE__));
define('WPEC_QV_ULTIMATE_TEMPLATE_PATH', WPEC_QV_ULTIMATE_FILE_PATH . '/templates');
define('WPEC_QV_ULTIMATE_IMAGES_URL', WPEC_QV_ULTIMATE_URL . '/assets/images');
define('WPEC_QV_ULTIMATE_JS_URL', WPEC_QV_ULTIMATE_URL . '/assets/js');
define('WPEC_QV_ULTIMATE_CSS_URL', WPEC_QV_ULTIMATE_URL . '/assets/css');

if (!defined("WPEC_QV_ULTIMATE_DOCS_URI")) define("WPEC_QV_ULTIMATE_DOCS_URI", "http://docs.a3rev.com/user-guides/plugins-extensions/wp-e-commerce/wpec-quick-view/");

/**
 * Load Localisation files.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 * 		- WP_LANG_DIR/wp-e-commerce-products-quick-view/wp-e-commerce-products-quick-view-LOCALE.mo
 * 	 	- WP_LANG_DIR/plugins/wp-e-commerce-products-quick-view-LOCALE.mo
 * 	 	- /wp-content/plugins/wp-e-commerce-products-quick-view/languages/wp-e-commerce-products-quick-view-LOCALE.mo (which if not found falls back to)
 */
function wpec_quick_view_ultimate_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-e-commerce-products-quick-view' );

	load_textdomain( 'wp-e-commerce-products-quick-view', WP_LANG_DIR . '/wp-e-commerce-products-quick-view/wp-e-commerce-products-quick-view-' . $locale . '.mo' );
	load_plugin_textdomain( 'wp-e-commerce-products-quick-view', false, WPEC_QV_ULTIMATE_FOLDER.'/languages' );
}

include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-quick-view-page.php');
include ('admin/admin-pages/admin-custom-template-page.php');

include ('admin/admin-init.php');
include ('admin/less/sass.php');

include 'classes/class-wpec-quick-view-ultimate.php';
include 'classes/class-quick-view-template.php';

include 'admin/wpec-quick-view-ultimate-init.php';


/**
 * Call when the plugin is activated and deactivated
 */
register_activation_hook(__FILE__, 'wpec_quick_view_ultimate_install');

?>