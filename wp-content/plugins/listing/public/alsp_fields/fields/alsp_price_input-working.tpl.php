<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class=" alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?> <?php echo $content_field->currency_symbol; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="">
		<input type="text" name="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-price form-control" value="<?php echo esc_attr($content_field->value['price_start']); ?>" size="4" />
		<input type="text" name="alsp-field-input-<?php echo $content_field->id; ?>-end" class="alsp-field-input-price form-control" value="<?php echo esc_attr($content_field->value['price_end']); ?>" size="4" />
		
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
	<?php if (count($content_field->range_options)): ?>
	<div class="">
		<select name="alsp-field-input-<?php echo $content_field->id; ?>-range" class="alsp-field-input-select form-control pacz-select2">
			<option value=""><?php printf(__('- Select %s -', 'ALSP'), $content_field->name); ?></option>
			<?php foreach ($content_field->range_options AS $key=>$item): ?>
			<option value="<?php echo esc_attr($key); ?>" <?php selected($content_field->value['price_range'], $key, true); ?>><?php echo $item; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
<?php endif; ?>
</div>