<tr class="form-field hide-if-no-js font-color-meta">
	<th scope="row" valign="top"><label for="description"><?php print _e('Font Color', 'ALSP') ?></label></th>
	<td>
		<?php echo $alsp_instance->listingtype_manager->choose_font_icon_color($term->term_id); ?>
		<p class="description"><?php _e('Associate a color to this listing type', 'ALSP'); ?></p>
	</td>
</tr>