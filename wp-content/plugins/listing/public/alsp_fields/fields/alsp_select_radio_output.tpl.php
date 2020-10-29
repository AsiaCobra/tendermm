<?php if (
		$content_field->value 
		// && isset($content_field->selection_items[$content_field->value])
		):
	global $post; 
	$toogle_id =  $content_field->id.'-'.$post->ID; 
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
	
		<?php 
		// output($content_field->value);
		if( $content_field->id == 92  ){
			// if( ! is_single() )
			// 	echo "<br>";
			foreach( $content_field->value as $value ){

				echo '<span class="alsp-field-content content-multi">';
				echo ' | ';
				echo $content_field-> selection_items[$value];
				// echo $content_field->selection_items[$content_field->value];
				echo ' | ';
				echo '</span>';
			}
		}else{
			echo '<span class="alsp-field-content">';
			echo $content_field->selection_items[$content_field->value]; 
			echo '</span>';
		}
			?>
	
</div><?php endif; ?>