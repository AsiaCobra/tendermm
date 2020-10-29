<p>
	<label for="<?php echo $widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('uid'); ?>"><?php _e('uID:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('uid'); ?>" name="<?php echo $widget->get_field_name('uid'); ?>" type="text" value="<?php echo esc_attr($instance['uid']); ?>" /><?php _e('Enter unique string to connect search form with another elements on the page.', 'ALSP'); ?>
</p>
<p>
	<input id="<?php echo $widget->get_field_name('search_visibility'); ?>" name="<?php echo $widget->get_field_name('search_visibility'); ?>" type="checkbox" value="1" <?php checked($instance['search_visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('search_visibility'); ?>"><?php _e('Show only when there is no any other search form on page'); ?></label> 
</p>
<p>
	<input id="<?php echo $widget->get_field_name('visibility'); ?>" name="<?php echo $widget->get_field_name('visibility'); ?>" type="checkbox" value="1" <?php checked($instance['visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('visibility'); ?>"><?php _e('Show only on directory pages'); ?></label> 
</p>
<p>
	<input id="<?php echo $widget->get_field_name('search_custom_style'); ?>" name="<?php echo $widget->get_field_name('search_custom_style'); ?>" type="checkbox" value="1" <?php checked($instance['search_custom_style'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('search_custom_style'); ?>"><?php _e('Custom Styles'); ?></label> 
</p>

<p>
	<label for="<?php echo $widget->get_field_id('input_field_border_width'); ?>"><?php _e('Input Field Border Radius:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('input_field_border_width'); ?>" name="<?php echo $widget->get_field_name('input_field_border_width'); ?>" type="text" value="<?php echo esc_attr($instance['input_field_border_width']); ?>" /><?php _e('Input Field Border Width in PX', 'ALSP'); ?>
</p>
<p>
	<label for="<?php echo $widget->get_field_id('input_field_border_radius'); ?>"><?php _e('Input Field Border Width:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('input_field_border_radius'); ?>" name="<?php echo $widget->get_field_name('input_field_border_radius'); ?>" type="text" value="<?php echo esc_attr($instance['input_field_border_radius']); ?>" /><?php _e('Input Field Border Radius in PX', 'ALSP'); ?>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'input_field_bg' ); ?>"><?php _e('Input Field Background Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['input_field_bg']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'input_field_bg' ); ?>" name="<?php echo $widget->get_field_name( 'input_field_bg' ); ?>" type="text" value="<?php echo esc_attr($instance['input_field_bg']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'input_field_border_color' ); ?>"><?php _e('Input Field Border Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['input_field_border_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'input_field_border_color' ); ?>" name="<?php echo $widget->get_field_name( 'input_field_border_color' ); ?>" type="text" value="<?php echo esc_attr($instance['input_field_border_color']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'input_field_label_color' ); ?>"><?php _e('Input Field Label Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['input_field_label_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'input_field_label_color' ); ?>" name="<?php echo $widget->get_field_name( 'input_field_label_color' ); ?>" type="text" value="<?php echo esc_attr($instance['input_field_label_color']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'input_field_placeholder_color' ); ?>"><?php _e('Input Field Placeholder Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['input_field_placeholder_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'input_field_placeholder_color' ); ?>" name="<?php echo $widget->get_field_name( 'input_field_placeholder_color' ); ?>" type="text" value="<?php echo esc_attr($instance['input_field_placeholder_color']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'input_field_text_color' ); ?>"><?php _e('Input Field Text Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['input_field_text_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'input_field_text_color' ); ?>" name="<?php echo $widget->get_field_name( 'input_field_text_color' ); ?>" type="text" value="<?php echo esc_attr($instance['input_field_text_color']); ?>" /></div>
</p>

<p>
	<label for="<?php echo $widget->get_field_id('search_button_border_radius'); ?>"><?php _e('Submit Button Border Radius:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('search_button_border_radius'); ?>" name="<?php echo $widget->get_field_name('search_button_border_radius'); ?>" type="text" value="<?php echo esc_attr($instance['search_button_border_radius']); ?>" /><?php _e('Submit Button Border Radius in px', 'ALSP'); ?>
</p>
<p>
	<label for="<?php echo $widget->get_field_id('search_button_border_width'); ?>"><?php _e('Submit Button Border Width:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('search_button_border_width'); ?>" name="<?php echo $widget->get_field_name('search_button_border_width'); ?>" type="text" value="<?php echo esc_attr($instance['search_button_border_width']); ?>" /><?php _e('Submit Button Border Width in px', 'ALSP'); ?>
</p>

<p>
<label for="<?php echo $widget->get_field_id( 'search_button_text_color' ); ?>"><?php _e('Submit Button Text Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_text_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_text_color' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_text_color' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_text_color']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'search_button_text_color_hover' ); ?>"><?php _e('Submit Button Text Hover Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_text_color_hover']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_text_color_hover' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_text_color_hover' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_text_color_hover']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'search_button_border_color' ); ?>"><?php _e('Submit Button Border Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_border_color']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_border_color' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_border_color' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_border_color']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'search_button_border_color_hover' ); ?>"><?php _e('Submit Button Border Hover Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_border_color_hover']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_border_color_hover' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_border_color_hover' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_border_color_hover']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'search_button_bg' ); ?>"><?php _e('Submit Button Background Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_bg']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_bg' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_bg' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_bg']); ?>" /></div>
</p>
<p>
<label for="<?php echo $widget->get_field_id( 'search_button_bg_hover' ); ?>"><?php _e('Submit Button Background Hover Color:', 'ALSP'); ?></label>
	<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($instance['search_button_bg_hover']); ?>" class="color-picker" id="<?php echo $widget->get_field_id( 'search_button_bg_hover' ); ?>" name="<?php echo $widget->get_field_name( 'search_button_bg_hover' ); ?>" type="text" value="<?php echo esc_attr($instance['search_button_bg_hover']); ?>" /></div>
</p>

<script>


			jQuery(document).ready(function() {
				pacz_color_picker();
		    	//pacz_social_networks_custom_skin();
			});

		</script>