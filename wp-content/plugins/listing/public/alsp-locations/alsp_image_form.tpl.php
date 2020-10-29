<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top"><?php print _e('Featured Image', 'ALSP') ?></th>
	<td>
		<input type="hidden" name="location_image_attachment_id" id="alsp-location-image-attachment-id" value="<?php echo $attachment_id; ?>">

		<div>
			<img src="<?php echo $image_url; ?>" id="alsp-location-image" width="300" <?php if (!$image_url): ?>style="display: none;"<?php endif; ?> />
		</div>

		<div class="options">
			<button id="alsp-upload-location-featured" class="button" data-title="<?php esc_attr_e("Location Featured Image", "ALSP")?>" data-button="<?php esc_attr_e("Insert", "ALSP"); ?>"><?php _e("Select image", "ALSP"); ?></button>
			<button id="alsp-remove-location-featured" class="button"><?php _e("Remove image", "ALSP"); ?></button>
		</div>
	</td>
</tr>