<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure opening hours field', 'ALSP'); ?>
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
					<label><?php _e('Time convention', 'ALSP'); ?></label>
				</th>
				<td>
					<label>
						<input
							name="hours_clock"
							type="radio"
							value="12"
							<?php if ($content_field->hours_clock == 12) echo 'checked'; ?> />
						<?php _e('12-hour clock', 'ALSP')?>
					</label>
					&nbsp;&nbsp;
					<label>
						<input
							name="hours_clock"
							type="radio"
							value="24"
							<?php if ($content_field->hours_clock == 24) echo 'checked'; ?> />
						<?php _e('24-hour clock', 'ALSP')?>
					</label>
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