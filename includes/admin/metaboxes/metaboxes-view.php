<?php
/**
 * Represents the view of review metabox for the administration dashboard.
 *
 * @package   ReviewerWP
 * @author    Taras Dashkevych
 * @license   GPL-2.0+
 */

 global $post;

 $is_visible = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box_visibility(), true );
 $is_top = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box_top(), true );
 $is_bottom = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box_bottom(), true );
 $post_reviews = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box(), true );
 $review_summary = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box_summary(), true );
 $review_title = get_post_meta( $post->ID, reviwer_wp()->option_names->get_review_box_title(), true );

 wp_nonce_field( $this->review_noncename, $this->review_noncename );
?>

<p>
	<label for="<?php echo $this->plugin_slug; ?>-post-visibility">
		<input type="checkbox" id="<?php echo $this->plugin_slug; ?>-post-visibility" name="<?php echo reviwer_wp()->option_names->get_review_box_visibility(); ?>" value="1" <?php checked( $is_visible, 1 ); ?>><?php _e( 'Turn On the Review feature', $this->plugin_slug ) ?>
	</label>
</p>

<div class="simple-review-table">

	<div class="simple-review-section">
		<p class="label"><?php _e( 'Review Box Position', $this->plugin_slug ) ?></p>
		<p class="meta-options">
			<label for="<?php echo $this->plugin_slug; ?>-post-top" class="selectit">
				<input type="checkbox" id="<?php echo $this->plugin_slug; ?>-post-top" name="<?php echo reviwer_wp()->option_names->get_review_box_top(); ?>" value="1" <?php checked( $is_top, 1 ); ?>><?php _e( 'Top of the post', $this->plugin_slug ) ?>
			</label>
			<br>
			<label for="<?php echo $this->plugin_slug; ?>-post-bottom" class="selectit">
				<input type="checkbox" id="<?php echo $this->plugin_slug; ?>-post-bottom" name="<?php echo reviwer_wp()->option_names->get_review_box_bottom(); ?>" value="1" <?php checked( $is_bottom, 1 ); ?>><?php _e( 'Bottom of the post', $this->plugin_slug ) ?>
			</label>
		</p><!-- .meta-options -->
	</div><!-- .simple-review -->

	<div class="simple-review-section">
		<p class="label"><?php _e( 'Review Box Title', $this->plugin_slug ) ?></p>
		<p><input type="text" class="widefat" name="<?php echo reviwer_wp()->option_names->get_review_box_title(); ?>" value="<?php echo esc_attr( $review_title ); ?>"></p>
	</div><!-- .simple-review -->

	<div class="simple-review-section">
		<p class="label"><?php _e( 'Review Summary', $this->plugin_slug ) ?></p>
		<p><textarea class="widefat" name="<?php echo reviwer_wp()->option_names->get_review_box_summary(); ?>" rows="6"><?php echo esc_html( $review_summary ); ?></textarea></p>
	</div><!-- .simple-review -->

	<p class="label"><?php _e( 'Review', $this->plugin_slug ) ?></p>
	<table class="widefat">
		<thead>
			<tr>
				<th class="order"></th>
				<th class="score-label" width="60%"><?php _e( 'Label', $this->plugin_slug ) ?></th>
				<th class="score-number" width="40%"><?php _e( 'Score', $this->plugin_slug ) ?></th>
				<th class="controls"></th>
			</tr>
		</thead>

		<tbody class="ui-sortable">
		<?php if( !empty( $post_reviews ) ): ?>
			<?php foreach( $post_reviews as $key => $value ): ?>
			<tr class="review-row">
				<td class="order"><?php echo $key + 1; ?></td>
				<td width="60%">
					<input type="text" class="widefat text" name="<?php echo reviwer_wp()->option_names->get_review_box(); ?>[<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value[label] ); ?>">
				</td>
				<td width="40%">
					<select class="select widefat" name="<?php echo reviwer_wp()->option_names->get_review_box(); ?>[<?php echo esc_attr( $key ); ?>][score]">
						<option value="1" <?php selected( $value[score], 1 ); ?>>1</option>
						<option value="2" <?php selected( $value[score], 2 ); ?>>2</option>
						<option value="3" <?php selected( $value[score], 3 ); ?>>3</option>
						<option value="4" <?php selected( $value[score], 4 ); ?>>4</option>
						<option value="5" <?php selected( $value[score], 5 ); ?>>5</option>
						<option value="6" <?php selected( $value[score], 6 ); ?>>6</option>
						<option value="7" <?php selected( $value[score], 7 ); ?>>7</option>
						<option value="8" <?php selected( $value[score], 8 ); ?>>8</option>
						<option value="9" <?php selected( $value[score], 9 ); ?>>9</option>
						<option value="10" <?php selected( $value[score], 10 ); ?>>10</option>
					</select>
				</td>
				<td class="controls">
					<a href="#" class="reviwerwp-remove-row" title="<?php esc_attr_e( 'Remove', $this->plugin_slug ) ?>"></a>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>

			<tr class="review-clone">
				<td class="order">1</td>
				<td width="60%">
					<input type="text" class="widefat text" name="<?php echo reviwer_wp()->option_names->get_review_box(); ?>[dummyindex][label]">
				</td>
				<td width="40%">
					<select class="select widefat" name="<?php echo reviwer_wp()->option_names->get_review_box(); ?>[dummyindex][score]">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select>
				</td>
				<td class="controls">
					<a href="#" class="reviwerwp-remove-row" title="<?php esc_attr_e( 'Remove', $this->plugin_slug ) ?>"></a>
				</td>
			</tr>
		</tbody>
	</table><!-- .widefat -->

	<div class="simple-review-row-button">
		<a href="#" class="reviwerwp-add-row button button-primary button-medium"><?php _e( 'Add Rating Row', $this->plugin_slug ) ?></a>
	</div><!-- .simple-review-row-button -->

</div><!-- .simple-review-table -->