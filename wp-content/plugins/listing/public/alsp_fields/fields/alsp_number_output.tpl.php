<?php 
	if(!alsp_isListing()){
		$toogle_attr = '';
		$collapse_class = '';
	}else{
		$toogle_attr = '';
		$collapse_class = '';
	}

?>
<div class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
	<span class="alsp-field-caption">
		<?php
			if(!alsp_isListing()){
				if(alsp_listing_view_type() == 'show_grid_style'){
					if($content_field->is_hide_name_on_grid == 'show_only_label'){
						echo '<span class="alsp-field-name" '.$toogle_attr.'>'.$content_field->name.':</span>';
					}elseif($content_field->is_hide_name_on_grid == 'show_icon_label'){
						if ($content_field->icon_image){
							echo '<span class="alsp-field-icon '.$content_field->icon_image.'" '.$toogle_attr.'></span>';
						}
						echo '<span class="alsp-field-name" '.$toogle_attr.'>'.$content_field->name.':</span>';
					}elseif($content_field->is_hide_name_on_grid == 'show_only_icon'){
						if ($content_field->icon_image){
							echo '<span class="alsp-field-icon '.$content_field->icon_image.'" '.$toogle_attr.'></span>';
						}
					}
				}elseif(alsp_listing_view_type() == 'show_list_style'){
					if($content_field->is_hide_name_on_list == 'show_only_label'){
						echo '<span class="alsp-field-name" '.$toogle_attr.'>'.$content_field->name.':</span>';
					}elseif($content_field->is_hide_name_on_list == 'show_icon_label'){
						if ($content_field->icon_image){
							echo '<span class="alsp-field-icon '.$content_field->icon_image.'" '.$toogle_attr.'></span>';
						}
						echo '<span class="alsp-field-name" '.$toogle_attr.'>'.$content_field->name.':</span>';
					}elseif($content_field->is_hide_name_on_list == 'show_only_icon'){
						if ($content_field->icon_image){
							echo '<span class="alsp-field-icon '.$content_field->icon_image.'" '.$toogle_attr.'></span>';
						}
					}
				}
			}else{
				if ($content_field->icon_image){
					echo '<span class="alsp-field-icon fa fa-lg '.$content_field->icon_image.'"></span>';
				}
				if(!$content_field->is_hide_name){
					echo '<span class="alsp-field-name">'.$content_field->name.':</span>';
				}
			}
		?>
	</span>
	<span class="alsp-field-content">
		<?php echo $formatted_number; ?>
	</span>
</div>