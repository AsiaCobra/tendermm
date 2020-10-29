<?php global $ALSP_ADIMN_SETTINGS; ?>
<div id="misc-publishing-actions">
	<?php if ($alsp_instance->directories->isMultiDirectory()): ?>
	<script>
		(function($) {
			"use strict";
	
			$(function() {
				$("#directory_id").on("change", function() {
					$("#publish").trigger('click');
				});
			});
		})(jQuery);
	</script>
	<div class="misc-pub-section">
		<label for="post_level"><?php _e('Directory', 'ALSP'); ?>:</label>
		<select id="directory_id" name="directory_id">
			<?php foreach ($alsp_instance->directories->directories_array AS $directory): ?>
			<option value="<?php echo $directory->id; ?>" <?php selected($directory->id, $listing->directory->id, true); ?>><?php echo $directory->name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif; ?>

	<div class="misc-pub-section">
		<label for="post_level"><?php _e('Listing level', 'ALSP'); ?>:</label>
		<span id="post-level-display">
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
					echo '<a href="' . admin_url('options.php?page=alsp_upgrade&listing_id=' . $listing->post->ID) . '">';
			else
				echo '<b>'; ?>
			<?php echo apply_filters('alsp_create_option', $listing->level->name, $listing); ?>
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
				echo '</a>';
			else
				echo '</b>'; ?>
		</span>
	</div>

	<?php if ($listing->listing_created): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php _e('Listing status', 'ALSP'); ?>:</label>
		<span id="post-level-display">
			<?php if ($listing->status == 'active'): ?>
			<span class="label label-success"><?php _e('active', 'ALSP'); ?></span>
			<?php elseif ($listing->status == 'expired'): ?>
			<span class="label label-danger"><?php _e('expired', 'ALSP'); ?></span><br />
			<a href="<?php echo admin_url('options.php?page=alsp_renew&listing_id=' . $listing->post->ID); ?>"><span class="alsp-fa alsp-fa-refresh alsp-fa-lg"></span> <?php echo apply_filters('alsp_renew_option', __('renew listing', 'ALSP'), $listing); ?></a>
			<?php elseif ($listing->status == 'unpaid'): ?>
			<span class="label label-warning"><?php _e('unpaid ', 'ALSP'); ?></span>
			<?php elseif ($listing->status == 'stopped'): ?>
			<span class="label label-danger"><?php _e('stopped', 'ALSP'); ?></span>
			<?php endif;?>
			<?php do_action('alsp_listing_status_option', $listing); ?>
		</span>
		<?php if (get_post_meta($listing->post->ID, '_preexpiration_notification_sent', true)): ?><br /><?php _e('Pre-expiration notification was sent', 'ALSP'); ?><?php endif; ?>
	</div>
	
	<?php
	$post_type_object = get_post_type_object(ALSP_POST_TYPE);
	$can_publish = current_user_can($post_type_object->cap->publish_posts);
	?>
	<?php if ($can_publish && $listing->status != 'active'): ?>
	<div class="misc-pub-section">
		<input name="alsp_save_as_active" value="Save as Active" class="button" type="submit">
	</div>
	<?php endif; ?>

	<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_stats']): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php echo sprintf(__('Total clicks: %d', 'ALSP'), (get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) ? get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) : 0)); ?></label>
	</div>
	<?php endif; ?>

	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php _e('Sorting date', 'ALSP'); ?>:
			<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->order_date)); ?></b>
			<?php if ($listing->level->raiseup_enabled && $listing->status == 'active'): ?>
			<br />
			<a href="<?php echo admin_url('options.php?page=alsp_raise_up&listing_id=' . $listing->post->ID); ?>"><span class="alsp-fa alsp-fa-level-up alsp-fa-lg"></span> <?php echo apply_filters('alsp_raiseup_option', __('raise up listing', 'ALSP'), $listing); ?></a>
			<?php endif; ?>
		</span>
	</div>

	<?php if ($listing->level->eternal_active_period || $listing->expiration_date): ?>
	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php _e('Expire on', 'ALSP'); ?>:
			<?php if ($listing->level->eternal_active_period): ?>
			<b><?php _e('Eternal active period', 'ALSP'); ?></b>
			<?php else: ?>
			<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date)); ?></b>
			<?php endif; ?>
		</span>
	</div>
	<?php endif; ?>
	
	<?php do_action('alsp_listing_info_metabox_html', $listing); ?>

	<?php endif; ?>
</div>