<?php

class Reviewer_WP_Review_Box {

	/**
	 * Get things started
	 *
	 * @since 1.0.0
	*/
	public function __construct() {
		//Plugin slug name
		$this->plugin_slug = reviwer_wp()->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		//add_action( 'wp_footer', array( $this, 'review_box' ) );
		add_filter( 'the_content', array( $this, 'add_review_box' ), 99 );
	}

	/**
	 * Register the stylesheets for the front end.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug, REVIWERWP_PLUGIN_URL . 'assets/css/public-reviewerwp.css', array(), REVIWERWP_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the front end.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		//wp_enqueue_script( $this->plugin_slug, REVIWERWP_PLUGIN_URL . 'assets/js/admin-metaboxes.js', array( 'jquery' ), REVIWERWP_VERSION, false );
	}

	/**
	 * Check if current post has any reviews
	 *
	 * @since    1.0.0
	 */
	public function has_reviews() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box_visibility(), true );
	}

	/**
	 * Return review box settings for the current post
	 *
	 * @since    1.0.0
	 */
	public function get_review_box_settings() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box(), true );
	}

	/**
	 * Return review box title
	 *
	 * @since    1.0.0
	 */
	public function get_review_box_title() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box_title(), true );
	}

	/**
	 * Return review box summary
	 *
	 * @since    1.0.0
	 */
	public function get_review_box_summary() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box_summary(), true );
	}

	/**
	 * Is review box before the post content
	 *
	 * @since    1.0.0
	 */
	public function is_top_review_box() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box_top(), true );
	}

	/**
	 * Is review box after the post content
	 *
	 * @since    1.0.0
	 */
	public function is_bottom_review_box() {
		return get_post_meta( get_the_ID(), reviwer_wp()->option_names->get_review_box_bottom(), true );
	}

	/**
	 * Return total review score number
	 *
	 * @since    1.0.0
	 */
	public function get_total_score() {
		$total_score = 0;

		if( $this->has_reviews() ) {
			$settings = $this->get_review_box_settings();

			if( !empty( $settings ) ) {
				$score = array();

				foreach( $settings as $key => $row ){
					$score[$key] = $row['score'];
				}

				$items = count( $score );
				$sum = array_sum( $score );
				$total_score = number_format( ( $sum / $items ), 1, '.', '' );
			}
		}

		return $total_score;
	}

	/**
	 * Add review box to the post content
	 *
	 * @since    1.0.0
	 */
	public function add_review_box( $content ) {
		$review_box = $this->get_review_box();

		if( is_singular() ) {
			if( $this->is_top_review_box() ) {
				$content = $review_box . $content;
			}

			if( $this->is_bottom_review_box() ) {
				$content .= $review_box;
			}
		}

		return $content;
	}

	/**
	 * Display review box on a single post page
	 *
	 * @since    1.0.0
	 */
	function get_review_box() {
		$review_box = '';
		$settings = $this->get_review_box_settings();

		if( !empty( $settings ) ) {
			$review_box .= '<div class="reviewerwp-box">';
			$review_box .= '<div class="reviewerwp-box-inner">';

			if( $this->get_review_box_title() ):
			$review_box .= '<h4 class="reviewerwp-review-title">';
			$review_box .= $this->get_review_box_title();
			$review_box .= '</h4><!-- .reviewerwp-review-summary -->';
			endif;

			$review_box .= '<div class="reviewerwp-review-criterias">';
			foreach( $settings as $row ) {
				$review_box .= '<h5 class="criteria">';
				$review_box .= '<span class="review-label">'.$row['label'].'</span>';
				$review_box .= '<span class="review-score-number">'.$row['score'].'</span>';
				$review_box .= '</h5>';

				$review_box .= '<div class="review-score">';
				$review_box .= '<div class="review-score-bar" style="width:'.$row['score'].'0%;"></div>';
				$review_box .= '</div><!-- .review-score -->';
			}
			$review_box .= '</div><!-- .reviewerwp-review-criterias -->';

			if( $this->get_review_box_summary() ):
			$review_box .= '<div class="reviewerwp-review-summary">';
			$review_box .= $this->get_review_box_summary();
			$review_box .= '</div><!-- .reviewerwp-review-summary -->';
			endif;

			$review_box .= '<div class="reviewerwp-total-score">';
			$review_box .= $this->get_total_score();
			$review_box .= '</div><!-- .reviewerwp-total-score -->';

			$review_box .= '</div><!-- .reviewerwp-box-inner -->';
			$review_box .= '</div><!-- .reviewerwp-box -->';
		}

		return $review_box;
	}


}