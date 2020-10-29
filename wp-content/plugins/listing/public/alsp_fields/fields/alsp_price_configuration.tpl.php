<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Configure price field', 'ALSP'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="alsp-configuration-page-wrap">
<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#add_selection_item").click(function() {
				$("#selection_items_wrapper").append('<div class="selection_item"><input name="range_options[]" type="text" size="40" value="" /><span class="alsp-delete-selection-item pacz-icon-remove" title="<?php esc_attr_e('Remove min-max option', 'ALSP')?>"></span></div>');
			});
			$(document).on("click", ".alsp-delete-selection-item", function() {
				$(this).parent().remove();
			});
		});
	})(jQuery);
</script>
<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Currency symbol', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="currency_symbol"
						type="text"
						size="1"
						value="<?php echo esc_attr($content_field->currency_symbol); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Currency symbol position', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="symbol_position">
						<option value="1" <?php if($content_field->symbol_position == '1') echo 'selected'; ?>>$1.00</option>
						<option value="2" <?php if($content_field->symbol_position == '2') echo 'selected'; ?>>$ 1.00</option>
						<option value="3" <?php if($content_field->symbol_position == '3') echo 'selected'; ?>>1.00$</option>
						<option value="4" <?php if($content_field->symbol_position == '4') echo 'selected'; ?>>1.00 $</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Decimal separator', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="decimal_separator">
						<option value="." <?php if($content_field->decimal_separator == '.') echo 'selected'; ?>><?php _e('dot', 'ALSP')?></option>
						<option value="," <?php if($content_field->decimal_separator == ',') echo 'selected'; ?>><?php _e('comma', 'ALSP')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Hide decimals', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="hide_decimals">
						<option value="0" <?php if($content_field->hide_decimals == '0') echo 'selected'; ?>><?php _e('no', 'ALSP')?></option>
						<option value="1" <?php if($content_field->hide_decimals == '1') echo 'selected'; ?>><?php _e('yes', 'ALSP')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Thousands separator', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="thousands_separator">
						<option value="" <?php if($content_field->thousands_separator == '') echo 'selected'; ?>><?php _e('no separator', 'ALSP')?></option>
						<option value="." <?php if($content_field->thousands_separator == '.') echo 'selected'; ?>><?php _e('dot', 'ALSP')?></option>
						<option value="," <?php if($content_field->thousands_separator == ',') echo 'selected'; ?>><?php _e('comma', 'ALSP')?></option>
						<option value=" " <?php if($content_field->thousands_separator == ' ') echo 'selected'; ?>><?php _e('space', 'ALSP')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Price Range options:', 'ALSP'); ?>
				</th>
				<td>
					<div id="selection_items_wrapper">
						<?php if (count($content_field->range_options)): ?>
						<?php foreach ($content_field->range_options AS $item): ?>
						<div class="selection_item clearfix">
							<input
								name="range_options[]"
								type="text"
								size="40"
								value="<?php echo $item; ?>" />
							<span class="alsp-delete-selection-item pacz-icon-remove" title="<?php esc_attr_e('Remove min-max option', 'ALSP')?>"></span>
						</div>
						<?php endforeach; ?>
						<?php else: ?>
						<div class="selection_item clearfix">
							<input
								name="range_options[]"
								type="text"
								size="40"
								value="" />
							<span class="alsp-delete-selection-item pacz-icon-remove" title="<?php esc_attr_e('Remove min-max option', 'ALSP')?>"></span>
						</div>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		</tbody>
		<input type="button" id="add_selection_item" class="button button-primary" value="<?php esc_attr_e('Add Range option', 'ALSP'); ?>" />
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