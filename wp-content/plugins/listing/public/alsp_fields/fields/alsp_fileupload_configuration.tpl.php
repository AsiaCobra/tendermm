<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure FileUpload field', 'ALSP'); ?>
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
					<label><?php _e('Enable file title field', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="use_text"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->use_text) echo 'checked'; ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Use default file title text when empty', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="use_default_text"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->use_default_text) echo 'checked'; ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Default file title text', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="default_text"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->default_text); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Allowed file types', 'ALSP'); ?></label>
				</th>
				<td>
					<?php foreach ($content_field->get_mime_types() AS $type=>$label): ?>
					<label>
						<input
							name="allowed_mime_types[]"
							type="checkbox"
							class="regular-text"
							value="<?php echo $type; ?>"
							<?php if (in_array($type, $content_field->allowed_mime_types)) echo 'checked'; ?> /> <?php echo $label['label']; ?> (<?php echo $type; ?>) <br />
					</label>
					<?php endforeach; ?>
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