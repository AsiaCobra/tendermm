<div class="meta-item">
	<img class="listingtype_icon_image_tag alsp-field-icon" src="<?php if ($icon_file) echo esc_url(ALSP_LISTINGTYPE_ICONS_URL . $icon_file); ?>" <?php if (!$icon_file): ?>style="display: none;" <?php endif; ?> />
	<input type="hidden" name="icon_image" class="listingtype_icon_image" value="<?php if ($icon_file) echo esc_attr($icon_file); ?>">
	<input type="hidden" name="listingtype_id" class="listingtype_id" value="<?php echo esc_attr($term_id); ?>">
	<a class="listingtype_select_icon_image" href="javascript: void(0);"><?php _e('Select icon', 'ALSP'); ?></a>
</div>