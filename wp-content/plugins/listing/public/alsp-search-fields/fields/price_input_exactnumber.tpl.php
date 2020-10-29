<?php 
	global $alsp_instance;
	if ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] != 2){
		$field_width = $search_field->content_field->fieldwidth_archive;
	}elseif($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$field_width = '100';
	}else{
		$field_width = $search_field->content_field->fieldwidth;
	}

?>
<div class="search-element-col alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $search_form_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $search_form_id; ?> pull-left" style=" width:<?php echo $field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
	
	<?php if(!$search_field->content_field->is_hide_name_on_search){ ?>
		<div class="col-md-12">
			<label><?php echo $search_field->content_field->name; ?> <?php echo $search_field->content_field->currency_symbol; ?></label>
		</div>
	<?php } ?>
	<div class="col-md-12">
		<input type="text" name="field_<?php echo $search_field->content_field->slug; ?>" class="form-control" value="<?php echo esc_attr($search_field->value); ?>" />
	</div>
</div>