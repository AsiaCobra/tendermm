<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure date-time field', 'ALSP'); ?>
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
					<label><?php _e('Enable time in field', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_time"
						type="checkbox"
						class="regular-text"
						value="1"
						<?php if($content_field->is_time) echo 'checked'; ?>/>
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