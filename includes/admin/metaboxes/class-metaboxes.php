<?php

class Reviewer_WP_Metaboxes {

	private $visibility_option;
	private $top_box_option;
	private $bottom_box_option;
	private $reviews_option;
	private $review_summary_option;
	private $review_title_option;

	private $review_noncename;

	/**
	 * Get things started
	 *
	 * @since 1.0.0
	*/
	public function __construct() {
		$this->plugin_slug = reviwer_wp()->get_plugin_slug();

		$this->visibility_option = '_' . $this->plugin_slug . '_visibility';
		$this->reviews_option = '_' . $this->plugin_slug . '_reviews';
		$this->top_box_option = '_' . $this->plugin_slug . '_review_top';
		$this->bottom_box_option = '_' . $this->plugin_slug . '_review_bottom';
		$this->review_summary_option = '_' . $this->plugin_slug . '_review_summary';
		$this->review_title_option = '_' . $this->plugin_slug . '_review_title';

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

		if( ! wp_verify_nonce( $_POST[$this->review_noncename], $this->review_noncename ) ) {
			return;
		}

		$is_visible = isset( $_POST[ $this->visibility_option ] ) ? $_POST[ $this->visibility_option ] : '';
		$reviews = isset( $_POST[ $this->reviews_option ] ) ? $_POST[ $this->reviews_option ] : '';
		$review_summary = isset( $_POST[ $this->review_summary_option ] ) ? $_POST[ $this->review_summary_option ] : '';
		$review_title = isset( $_POST[ $this->review_title_option ] ) ? $_POST[ $this->review_title_option ] : '';
		$top_position = isset( $_POST[ $this->top_box_option ] ) ? $_POST[ $this->top_box_option ] : '';
		$bottom_position = isset( $_POST[ $this->bottom_box_option ] ) ? $_POST[ $this->bottom_box_option ] : '';

		if( $is_visible ) {

			update_post_meta( $post_id, $this->visibility_option, $is_visible);

			if( $reviews ) {
				//remove dummy row
				unset( $reviews['dummyindex'] );

				//update array index
				$reviews = array_values( $reviews );

				update_post_meta( $post_id, $this->reviews_option, $reviews );

			} else {
				delete_post_meta( $post_id, $this->reviews_option );
			}

			if( $review_summary ) {
				update_post_meta( $post_id, $this->review_summary_option, $review_summary );
			} else {
				delete_post_meta( $post_id, $this->review_summary_option );
			}

			if( $review_title ) {
				update_post_meta( $post_id, $this->review_title_option, $review_title );
			} else {
				delete_post_meta( $post_id, $this->review_title_option );
			}

			if( $top_position ) {
				update_post_meta( $post_id, $this->top_box_option, $top_position );
			} else {
				delete_post_meta( $post_id, $this->top_box_option );
			}

			if( $bottom_position ) {
				update_post_meta( $post_id, $this->bottom_box_option, $bottom_position );
			} else {
				delete_post_meta( $post_id, $this->bottom_box_option );
			}

		} else {
			delete_post_meta( $post_id, $this->visibility_option );
		}

	}

}
new Reviewer_WP_Metaboxes();