<?php if ($content_field->value): 
	if(!alsp_isListing()){
		$tootltip_triger_class = 'alsp_field_tooltip';
		$tooltip_content_class = 'tooltip-content';
	}else{
		$tootltip_triger_class = '';
		$tooltip_content_class = '';
	}

?>
<div class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
	<span class="alsp-field-caption">
			<?php
				if(!alsp_isListing()){
					if(alsp_listing_view_type() == 'show_grid_style'){
						if($content_field->is_hide_name_on_grid == 'show_only_label'){
							echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
						}elseif($content_field->is_hide_name_on_grid == 'show_icon_label'){
							if ($content_field->icon_image){
								echo '<span class="alsp-field-icon '.$content_field->icon_image.'"></span>';
							}
							echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
						}elseif($content_field->is_hide_name_on_grid == 'show_only_icon'){
							if ($content_field->icon_image){
								echo '<span class="alsp-field-icon '.$content_field->icon_image.'"></span>';
							}
						}
					}elseif(alsp_listing_view_type() == 'show_list_style'){
						if($content_field->is_hide_name_on_list == 'show_only_label'){
							echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
						}elseif($content_field->is_hide_name_on_list == 'show_icon_label'){
							if ($content_field->icon_image){
								echo '<span class="alsp-field-icon '.$content_field->icon_image.'"></span>';
							}
							echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
						}elseif($content_field->is_hide_name_on_list == 'show_only_icon'){
							if ($content_field->icon_image){
								echo '<span class="alsp-field-icon '.$content_field->icon_image.'"></span>';
							}
						}
					}
				}else{
					if ($content_field->icon_image){
						echo '<span class="alsp-field-icon '.$content_field->icon_image.'"></span>';
					}
					if(!$content_field->is_hide_name){
						echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
					}
				}
			?>
		</span>
	<ul class="alsp-field-content clearfix">
	<?php if ($content_field->how_display_items == 'all'): ?>
	
	<?php foreach ($content_field->selection_items AS $key=>$item): ?>
		<?php 
			if(in_array($key, $content_field->value)){
				$icon = '<span class="pacz-icon-check-circle"></span>';
			}else{
				$icon = '<span class="pacz-icon-times-circle"></span>';
			}
		?>
		<li><?php echo $icon; ?><?php echo $item; ?></li>
	<?php endforeach; ?>
	<?php elseif ($content_field->how_display_items == 'checked'): ?>
	<?php foreach ($content_field->value AS $key): ?>
	<?php 
	if(isset($content_field->icon_selection_items[$key]) && $content_field->check_icon_type == 'custom_icon'){
		$icon = '<span class="'.$content_field->icon_selection_items[$key].'"></span>';
	}elseif(isset($content_field->icon_selection_items[$key]) && $content_field->check_icon_type == 'default'){
		$icon = '<span class="pacz-icon-check-circle"></span>';
	}else{
		$icon = '<span class="pacz-icon-check-circle"></span>';
	}
	?>
		<?php if (isset($content_field->selection_items[$key])): ?><li><?php echo $icon; ?><?php echo $content_field->selection_items[$key]; ?></li><?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
	</ul>
</div>
<?php endif; ?>