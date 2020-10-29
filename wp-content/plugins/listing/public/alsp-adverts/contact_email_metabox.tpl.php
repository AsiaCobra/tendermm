<p><?php _e("When field is empty contact messages from contact form will be sent directly to author email.", 'ALSP'); ?></p>

<div class="alsp-content">
	<input class="alsp-field-input-string form-control" type="text" name="contact_email" value="<?php echo esc_attr($listing->contact_email); ?>" />
</div>
	
<?php do_action('alsp_contact_email_metabox_html', $listing); ?>