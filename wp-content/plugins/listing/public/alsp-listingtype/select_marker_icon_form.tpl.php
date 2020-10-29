<tr class="form-field hide-if-no-js listingtype-marker-meta">
	<th scope="row" valign="top"><label for="description"><?php print _e('Marker Icon', 'ALSP') ?></label></th>
	<td>
		<?php echo $alsp_instance->listingtype_manager->choose_marker_icon_link($term->term_id); ?>
		<p class="description"><?php _e('Associate an icon to this listing type', 'ALSP'); ?></p>
	</td>
</tr>