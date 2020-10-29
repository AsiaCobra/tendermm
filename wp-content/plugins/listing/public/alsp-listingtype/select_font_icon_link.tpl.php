<div class="meta-item">
	<span class="alsp-font-icon-tag <?php if ($icon_name): ?>fa <?php echo esc_attr($icon_name); ?><?php endif; ?>"></span>
	<input type="hidden" name="font_icon_image" class="font_icon_image" value="<?php echo esc_attr($icon_name); ?>" />
	<input type="hidden" name="listingtype_id" class="listingtype_id" value="<?php echo esc_attr($term_id); ?>" />
	<a class="select_font_icon_image" href="javascript: void(0);"><?php _e('Select Icon', 'ALSP'); ?></a>
</div>