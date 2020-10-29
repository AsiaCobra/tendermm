<?php if ($content_field->value['url']):
	global $post;
	$toogle_id =  $content_field->id.'-'.$post->ID;
	if(!alsp_isListing()){
		$tooltip_attr = 'data-id="'.$toogle_id.'"';
		$tootltip_triger_class = 'alsp-tooltip';
		$tooltip_content_class = '';
	}else{
		$tooltip_attr = '';
		$tootltip_triger_class = '';
		$tooltip_content_class = '';
	}
?>
<div id="alsp-<?php echo $toogle_id; ?>" class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?> <?php echo $tootltip_triger_class; ?>" <?php echo $tooltip_attr; ?>>
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
		
			<span id="<?php echo $toogle_id; ?>" class="alsp-field-content <?php echo $tooltip_content_class; ?>">
				<a itemprop="url"
					href="<?php echo esc_url($content_field->value['url']); ?>"
					<?php if ($content_field->is_blank) echo 'target="_blank"'; ?>
					<?php if ($content_field->is_nofollow) echo 'rel="nofollow"'; ?>
				><?php if ($content_field->value['text'] && $content_field->use_link_text) echo $content_field->value['text']; else echo $content_field->value['url']; ?></a>
			</span>
		
	</div>
<?php endif; ?>