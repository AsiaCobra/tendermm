<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure select/checkbox/radio search field', 'ALSP'); ?>
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
					<select name="search_input_mode">
						<option value="checkboxes" <?php selected($search_field->search_input_mode, 'checkboxes'); ?>><?php _e('checkboxes', 'ALSP'); ?></option>
						<option value="selectbox" <?php selected($search_field->search_input_mode, 'selectbox'); ?>><?php _e('selectbox', 'ALSP'); ?></option>
						<option value="radiobutton" <?php selected($search_field->search_input_mode, 'radiobutton'); ?>><?php _e('radio buttons', 'ALSP'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Operator for the search', 'ALSP'); ?></label>
					<p class="description"><?php _e('Works only in checkboxes mode', 'ALSP'); ?></p>
				</th>
				<td>
					<label>
						<input
							name="checkboxes_operator"
							type="radio"
							value="OR"
							<?php checked($search_field->checkboxes_operator, 'OR'); ?> />
						<?php _e('OR - any item present is enough', 'ALSP')?>
					</label>
					<br />
					<label>
						<input
							name="checkboxes_operator"
							type="radio"
							value="AND"
							<?php checked($search_field->checkboxes_operator, 'AND'); ?> />
						<?php _e('AND - require all items', 'ALSP')?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Items counter', 'ALSP'); ?></label>
					<p class="description"><?php _e('On the search form shows the number of listings per item (in brackets)', 'ALSP'); ?></p>
				</th>
				<td>
					<label>
						<input
							name="items_count"
							type="checkbox"
							value="1"
							<?php checked($search_field->items_count, 1); ?> />
						<?php _e('enable', 'ALSP')?>
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