<?php

class Reviewer_WP_Metaboxes {

	/**
	 * Metabox nonce field name
	 *
	 * @since    1.0.0
	 */
	private $review_noncename;

	/**
	 * Get things started
	 *
	 * @since 1.0.0
	*/
	public function __construct() {
		$this->plugin_slug = reviwer_wp()->get_plugin_slug();
		$this->review_noncename = '_' . $this->plugin_slug . '_noncename';

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'load-post.php', array( $this, 'setup_meta_boxes' ) );
		add_action( 'load-post-new.php', array( $this, 'setup_meta_boxes' ) );
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $pagenow;
		if( $pagenow === 'post.php' ) {
			wp_enqueue_style( $this->plugin_slug, REVIWERWP_PLUGIN_URL . 'assets/css/admin-metaboxes.css', array(), REVIWERWP_VERSION, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $pagenow;
		if( $pagenow === 'post.php' ) {
			wp_enqueue_script( $this->plugin_slug, REVIWERWP_PLUGIN_URL . 'assets/js/admin-metaboxes.js', array( 'jquery' ), REVIWERWP_VERSION, false );
		}
	}

	/**
	 * Add metaboxes to the post type.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box(
			$this->plugin_slug . '-post-metabox',
			esc_html__( 'Review Settings', $this->plugin_slug ),
			array( $this, 'review_settings_view' ),
			'post',
			'normal',
			'core'
   	 	);
	}

	/**
	 * Setup metaboxes
	 *
	 * @since    1.0.0
	 */
	public function setup_meta_boxes() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'save_post_meta' ), 10, 2 );

	}

	public function review_settings_view() {
		require_once REVIWERWP_PLUGIN_DIR . 'includes/admin/metaboxes/metaboxes-view.php';
	}

	/**
	 * Save Custom Metabox Data
	 */
	public function save_post_meta( $post_id, $post ) {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return  $post->ID;
		}

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
			return;
		}

		if( !isset( $_POST[$this->review_noncename] ) || !wp_verify_nonce( $_POST[$this->review_noncename], $this->review_noncename ) ) {
			return;
		}

		$is_visible = isset( $_POST[ reviwer_wp()->option_names->get_review_box_visibility() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box_visibility() ] : '';
		$reviews = isset( $_POST[ reviwer_wp()->option_names->get_review_box() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box() ] : '';
		$review_summary = isset( $_POST[ reviwer_wp()->option_names->get_review_box_summary() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box_summary() ] : '';
		$review_title = isset( $_POST[ reviwer_wp()->option_names->get_review_box_title() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box_title() ] : '';
		$top_position = isset( $_POST[ reviwer_wp()->option_names->get_review_box_top() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box_top() ] : '';
		$bottom_position = isset( $_POST[ reviwer_wp()->option_names->get_review_box_bottom() ] ) ? $_POST[ reviwer_wp()->option_names->get_review_box_bottom() ] : '';

		if( $is_visible ) {

			update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_visibility(), $is_visible);

			if( $reviews ) {
				//remove dummy row
				unset( $reviews['dummyindex'] );

				//update array index
				$reviews = array_values( $reviews );

				update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box(), $reviews );

			} else {
				delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box() );
			}

			if( $review_summary ) {
				update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_summary(), $review_summary );
			} else {
				delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_summary() );
			}

			if( $review_title ) {
				update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_title(), $review_title );
			} else {
				delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_title() );
			}

			if( $top_position ) {
				update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_top(), $top_position );
			} else {
				delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_top() );
			}

			if( $bottom_position ) {
				update_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_bottom(), $bottom_position );
			} else {
				delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_bottom() );
			}

		} else {
			delete_post_meta( $post_id, reviwer_wp()->option_names->get_review_box_visibility() );
		}

	}
}