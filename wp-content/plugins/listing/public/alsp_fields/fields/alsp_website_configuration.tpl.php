<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure website field', 'ALSP'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="alsp-configuration-page-wrap">

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Open link in new window', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_blank"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->is_blank) echo 'checked'; ?>/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Add nofollow attribute', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_nofollow"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->is_nofollow) echo 'checked'; ?>/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Enable link text field', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="use_link_text"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->use_link_text) echo 'checked'; ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Use default link text when empty', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="use_default_link_text"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->use_default_link_text) echo 'checked'; ?> />
						<p class="description"><?php _e('In other case the URL will be displayed as link text'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Default link text', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="default_link_text"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->default_link_text); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>
</div>
</div>
</div>
</div>
</div>