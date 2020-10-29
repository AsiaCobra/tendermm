<form method="POST" action="<?php the_permalink($listing->post->ID); ?>#report-tab" id="alsp_report_form">
	<input type="hidden" name="listing_id" id="report_listing_id" value="<?php echo $listing->post->ID; ?>" />
	<input type="hidden" name="report_nonce" id="report_nonce" value="<?php print wp_create_nonce('alsp_report_nonce'); ?>" />
	<h3><?php _e('Send message to moderator', 'ALSP'); ?></h3>
	<h5 id="report_warning" style="display: none; color: red;"></h5>
	<div class="alsp-report-form">
		<?php if (is_user_logged_in()): ?>
		<p>
			<?php printf(__('You are currently logged in as %s. Your message will be sent using your logged in name and email.', 'ALSP'), wp_get_current_user()->user_login); ?>
			<input type="hidden" name="report_name" id="report_name" />
			<input type="hidden" name="report_email" id="report_email" />
		</p>
		<?php else: ?>
		<p>
			<label for="report_name"><?php _e('Contact Name', 'ALSP'); ?><span class="red-asterisk">*</span></label>
			<input type="text" name="report_name" id="report_name" class="form-control" value="<?php echo esc_attr(alsp_getValue($_POST, 'report_name')); ?>" size="35" />
		</p>
		<p>
			<label for="report_email"><?php _e("Contact Email", "ALSP"); ?><span class="red-asterisk">*</span></label>
			<input type="text" name="report_email" id="report_email" class="form-control" value="<?php echo esc_attr(alsp_getValue($_POST, 'report_email')); ?>" size="35" />
		</p>
		<?php endif; ?>
		<p>
			<label for="report_message"><?php _e("Your message", "ALSP"); ?><span class="red-asterisk">*</span></label>
			<textarea name="report_message" id="report_message" class="form-control" rows="15"><?php echo esc_textarea(alsp_getValue($_POST, 'report_message')); ?></textarea>
		</p>
		
		<?php echo alsp_recaptcha(); ?>
		
		<input type="submit" name="submit" class="alsp-send-message-button btn btn-primary" value="<?php esc_attr_e('Send message', 'ALSP'); ?>" />
	</div>
</form>