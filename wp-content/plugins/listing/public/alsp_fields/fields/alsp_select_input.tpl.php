<?php if (count($content_field->selection_items)): ?>
<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->type; ?> alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="select-field-wrap">
		<?php 
		
			$mutiple  = '';
			$default_select  = 'selected';
			$name 			 = "alsp-field-input-$content_field->id";

			if($content_field->id == 92  ){

				$mutiple  = 'multiple=true';
				$name     = "alsp-field-input-{$content_field->id}[]";
			}
			// print_r( $content_field->value )
		?>
		<select <?php if( $mutiple ) echo "data-placeholder='- Select {$content_field->name} -'";  ?> 
			<?php echo $mutiple; ?> name="<?php echo $name; ?>" class="alsp-field-input-select form-control pacz-select2">
			<?php if( !$mutiple ): ?>
				<option  value=""><?php printf(__('- Select %s -', 'ALSP'), $content_field->name); ?></option>
			<?php endif; ?>
			
			<?php foreach ($content_field->selection_items AS $key=>$item): ?>
				<?php if ( is_array( $content_field->value ) ): ?>
				<option <?php if (in_array($key, $content_field->value)) echo 'selected'; ?> value="<?php echo esc_attr($key); ?>" ><?php echo $item; ?></option>
				<?php else: ?>
				<option  value="<?php echo esc_attr($key); ?>" <?php selected($content_field->value, $key, true); ?>><?php echo $item; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>
<style>
.select2-container--default .select2-selection--multiple .select2-selection__rendered{
	padding: 0px 5px!important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{
	margin-top: 1px;
    padding: 10px 5px;
    border: 0px solid #fff;
    /* background: #f1f1f1; */
    color: #000;
}
.select2-container .select2-search--inline .select2-search__field{
    padding: 0;
    width: 100%!important;
    border: 0px solid #973895!important;
    margin: 0 0;
    height: 35px;
    margin-top: 1px!important;
}
.select2-container--default .select2-search--inline .select2-search__field:focus{
	background:#e4e4e461;
}
</style>
<?php endif; ?>