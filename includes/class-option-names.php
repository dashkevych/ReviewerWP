<?php

class Reviewer_WP_Option_Names {

	/**
	 * Option name for the review box visibility
	 *
	 * @since 1.0.0
	*/
	public $review_box_visibility;

	/**
	 * Option name for the post reviews
	 *
	 * @since 1.0.0
	*/
	public $review_box;

	/**
	 * Option name for the review box title
	 *
	 * @since 1.0.0
	*/
	public $review_box_title;

	/**
	 * Option name for the review box summary
	 *
	 * @since 1.0.0
	*/
	public $review_box_summary;

	/**
	 * Option name for the review box top position
	 *
	 * @since 1.0.0
	*/
	public $review_box_top;

	/**
	 * Option name for the review box bottom position
	 *
	 * @since 1.0.0
	*/
	public $review_box_bottom;

	/**
	 * Get things started
	 *
	 * @since 1.0.0
	*/
	public function __construct() {
		// get plugin slug
		$this->plugin_slug = reviwer_wp()->get_plugin_slug();

		// option name for the review box visibility
		$this->review_box_visibility = '_' . $this->plugin_slug . '_visibility';

		// option name for the post reviews
		$this->review_box = '_' . $this->plugin_slug . '_reviews';

		// option name for the review box title
		$this->review_box_title = '_' . $this->plugin_slug . '_review_title';

		// option name for the review box summary
		$this->review_box_summary = '_' . $this->plugin_slug . '_review_summary';

		// option name for the review box top position
		$this->review_box_top = '_' . $this->plugin_slug . '_review_top';

		// option name for the review box bottom position
		$this->review_box_bottom = '_' . $this->plugin_slug . '_review_bottom';
	}

	/**
	 * Return option name for the review box visibility
	 *
	 * @since 1.0.0
	*/
	public function get_review_box_visibility() {
		return $this->review_box_visibility;
	}

	/**
	 * Return option name for the post reviews
	 *
	 * @since 1.0.0
	*/
	public function get_review_box() {
		return $this->review_box;
	}

	/**
	 * Return option name for the review box title
	 *
	 * @since 1.0.0
	*/
	public function get_review_box_title() {
		return $this->review_box_title;
	}

	/**
	 * Return option name for the review box summary
	 *
	 * @since 1.0.0
	*/
	public function get_review_box_summary() {
		return $this->review_box_summary;
	}

	/**
	 * Return option name for the review box top position
	 *
	 * @since 1.0.0
	*/
	public function get_review_box_top() {
		return $this->review_box_top;
	}

	/**
	 * Return option name for the review box bottom position
	 *
	 * @since 1.0.0
	*/
	public function get_review_box_bottom() {
		return $this->review_box_bottom;
	}

}