<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure string/textarea search field', 'ALSP'); ?>
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
					<label><?php _e('Search input mode', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<label>
						<input
							name="search_input_mode"
							type="radio"
							value="keywords"
							<?php checked($search_field->search_input_mode, 'keywords'); ?> />
						<?php _e('Search by keywords field', 'ALSP'); ?>
					</label>
					<br />
					<label>
						<input
							name="search_input_mode"
							type="radio"
							value="input"
							<?php checked($search_field->search_input_mode, 'input'); ?> />
							<?php _e('Render own search field', 'ALSP'); ?>
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