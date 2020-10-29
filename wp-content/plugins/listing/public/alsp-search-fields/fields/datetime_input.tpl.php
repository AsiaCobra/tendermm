<?php global $ALSP_ADIMN_SETTINGS, $alsp_instance; ?>
<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker({
				changeMonth: false,
				changeYear: false,
				<?php if (function_exists('is_rtl') && is_rtl()): ?>isRTL: true,<?php endif; ?>
				showButtonPanel: true,
				dateFormat: '<?php echo $dateformat; ?>',
				firstDay: <?php echo intval(get_option('start_of_week')); ?>,
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
					$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker('option', 'minDate', sDate);
	
					$("input[name=field_<?php echo $search_field->content_field->slug; ?>_min]").val(tmstmp_str).trigger("change");
				}
			});
			<?php
			if ($lang_code = ALSP_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
	
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker({
				changeMonth: false,
				changeYear: false,
				showButtonPanel: true,
				dateFormat: '<?php echo $dateformat; ?>',
				firstDay: <?php echo intval(get_option('start_of_week')); ?>,
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
					$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker('option', 'maxDate', sDate);
	
					$("input[name=field_<?php echo $search_field->content_field->slug; ?>_max]").val(tmstmp_str).trigger("change");
				}
			});
			<?php
			if ($lang_code = ALSP_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
	
			<?php if ($search_field->min_max_value['max']): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $search_field->min_max_value['max']); ?>'));
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker('option', 'maxDate', $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker('getDate'));
			<?php endif; ?>
			$("#reset-date-max-<?php echo $search_form_id; ?>").click(function() {
				$.datepicker._clearDate('#ALSP-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>');
			})
	
			<?php if ($search_field->min_max_value['min']): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $search_field->min_max_value['min']); ?>'));
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>").datepicker('option', 'minDate', $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>").datepicker('getDate'));
			<?php endif; ?>
			$("#reset-date-min-<?php echo $search_form_id; ?>").click(function() {
				$.datepicker._clearDate('#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>');
			})
		});
	})(jQuery);
</script>
<?php
	if ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] != 2){
		$field_width = $search_field->content_field->fieldwidth_archive;
	}elseif($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$field_width = '100';
	}else{
		$field_width = $search_field->content_field->fieldwidth;
	}
 ?>

<div class="cz-datetime form-group search-element-col alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $search_form_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $search_form_id; ?> clearfix pull-left" style=" width:<?php echo $field_width; ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
	<div class="row clearfix">
		<?php if(!$search_field->content_field->is_hide_name_on_search){ ?>
			<div class="col-md-12">
				<label><?php echo $search_field->content_field->name; ?></label>
			</div>
		<?php } ?>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-horizontal clearfix">
				<div class="datetime-input-field has-feedback">
					<input type="text" class="form-control" id="alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $search_form_id; ?>" placeholder="<?php esc_attr_e('Start date', 'ALSP'); ?>" />
					<span class="glyphicon glyphicon-calendar alsp-form-control-feedback"></span>
					<input type="hidden" name="field_<?php echo $search_field->content_field->slug; ?>_min" value="<?php echo esc_attr($search_field->min_max_value['min']); ?>"/>
				</div>
				<div class="datetime-reset-btn">
					<input type="button" class="btn btn-primary form-control" id="reset_date-min-<?php echo $search_form_id; ?>" value="<?php esc_attr_e('Reset', 'ALSP')?>" />
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-horizontal">
				<div class="datetime-input-field has-feedback">
					<input type="text" class="form-control" id="alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $search_form_id; ?>" placeholder="<?php esc_attr_e('End date', 'ALSP'); ?>" />
					<span class="glyphicon glyphicon-calendar alsp-form-control-feedback"></span>
					<input type="hidden" name="field_<?php echo $search_field->content_field->slug; ?>_max" value="<?php echo esc_attr($search_field->min_max_value['max']); ?>"/>
				</div>
				<div class="datetime-reset-btn">
					<input type="button" class="btn btn-primary form-control" id="reset-date-max-<?php echo $search_form_id; ?>" value="<?php esc_attr_e('Reset', 'ALSP')?>" />
				</div>
			</div>
		</div>
	</div>
</div>