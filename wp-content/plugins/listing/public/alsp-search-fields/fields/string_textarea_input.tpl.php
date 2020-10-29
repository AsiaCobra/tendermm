<?php 
	global $ALSP_ADIMN_SETTINGS, $alsp_instance;
	if ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] != 2){
		$field_width = $search_field->content_field->fieldwidth_archive;
	}elseif($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$field_width = '100';
	}else{
		$field_width = $search_field->content_field->fieldwidth;
	}
 ?>
<?php $gap_in_fields = $ALSP_ADIMN_SETTINGS['gap_in_fields']; ?>
<div class="row alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $search_form_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $search_form_id; ?> pull-left" style=" width:<?php echo $field_width; ?>%; padding:<?php echo $gap_in_fields; ?>px;">
	<?php if(!$search_field->content_field->is_hide_name_on_search){ ?>
		<div class="col-md-12">
			<label><?php echo $search_field->content_field->name; ?></label>
		</div>
	<?php } ?>
	<div class="col-md-12 form-group">
		<input type="text" class="form-control" name="field_<?php echo $search_field->content_field->slug; ?>" value="<?php echo esc_attr($search_field->value); ?>" />
	</div>
</div>