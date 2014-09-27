<?php

/**
 * Plugin Name:       ReviewerWP
 * Plugin URI:		  http://reviwerwp.com/
 * Description:       Simple review plugin for WordPress.
 * Version:           1.0.0
 * Author:            Taras Dahkevych
 * Author URI:        http://tdwp.us/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reviewerwp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) )  die;


if ( ! class_exists( 'Reviwer_WP' ) ) :

/**
 * This is the main Reviwer_WP Class
 *
 * @since 1.0.0
 */
final class Reviwer_WP {

	/**
	 * Instance of this class
	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * The version number
	 *
	 * @since 1.0.0
	 */
	private $version = '1.0.0';

	/**
	 * Admin review metaboxes
	 *
	 * @since 1.0.0
	 */
	private $metaboxes;

	/**
	 * Review box
	 *
	 * @since 1.0.0
	 */
	private $review_box;

	 /**
	 * Option names
	 *
	 * @since 1.0.0
	 */
	public $option_names;

	/**
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file
	 *
	 * @since    1.0.0
	 */
	protected $plugin_slug = 'reviewerwp';

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

	}

	/**
	 * This is the main Reviwer_WP Instance
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Reviwer_WP ) ) {
			self::$instance = new Reviwer_WP;
			self::$instance->setup_plugin_constants();
			self::$instance->includes();
			self::$instance->load_plugin_textdomain();

			if( is_admin() ) {
				self::$instance->metaboxes = new Reviewer_WP_Metaboxes;
			}

			self::$instance->option_names = new Reviewer_WP_Option_Names;
			self::$instance->review_box = new Reviewer_WP_Review_Box;
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function setup_plugin_constants() {
		// Plugin version
		if ( ! defined( 'REVIWERWP_VERSION' ) ) {
			define( 'REVIWERWP_VERSION', $this->version );
		}

		// Plugin Folder Path
		if ( ! defined( 'REVIWERWP_PLUGIN_DIR' ) ) {
			define( 'REVIWERWP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'REVIWERWP_PLUGIN_URL' ) ) {
			define( 'REVIWERWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}
	}

	/**
	 * Include required plugin files
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function includes() {

		require_once REVIWERWP_PLUGIN_DIR . 'includes/class-option-names.php';

		//Load admin files
		if( is_admin() ) {
			require_once REVIWERWP_PLUGIN_DIR . 'includes/admin/metaboxes/class-metaboxes.php';
		}

		require_once REVIWERWP_PLUGIN_DIR . 'includes/class-review-box.php';

	}

	/**
	 * Load the plugin text domain for translation
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Return plugin slug name
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

}

endif;

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function reviwer_wp() {
	return Reviwer_WP::instance();
}
reviwer_wp();
