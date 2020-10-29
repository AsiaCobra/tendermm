<?php

add_action('vc_before_init', 'alsp_vc_init');

function alsp_vc_init() {
	global $alsp_instance, $alsp_fsubmit_instance, $alsp_google_maps_styles;
	
	$map_styles = array('default' => '');
	foreach ($alsp_google_maps_styles AS $name=>$style)
		$map_styles[$name] = $name;

	$levels = array(__('All', 'ALSP') => 0);
	foreach ($alsp_instance->levels->levels_array AS $level) {
		$levels[$level->name] = $level->id;
	}
	$ordering = alsp_orderingItems();
	
	if (!isset($alsp_instance->content_fields)) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		return ;
	}

	if (!function_exists('alsp_ordering_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('ordering', 'alsp_ordering_param');
		function alsp_ordering_param($settings, $value) {
			$ordering = alsp_orderingItems();

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			foreach ($ordering AS $ordering_item) {
				$out .= '<option value="' . $ordering_item['value'] . '" ' . selected($value, $ordering_item['value'], false) . '>' . $ordering_item['label'] . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}

	if (!function_exists('alsp_mapstyle_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('mapstyle', 'alsp_mapstyle_param');
		function alsp_mapstyle_param($settings, $value) {
			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="0" ' . ((!$value) ? 'selected' : 0) . '>' . __('Default', 'ALSP') . '</option>';
			$map_styles = array('default' => '');
			foreach (alsp_getAllMapStyles() AS $name=>$style) {
				$out .= '<option value="' . $name . '" ' . selected($value, $name, false) . '>' . $name . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}

	if (!function_exists('alsp_directories_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('directories', 'alsp_directories_param');
		function alsp_directories_param($settings, $value) {
			global $alsp_instance;

			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
			
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";

			$out .= '<select id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" multiple="multiple">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : 0) . '>' . __('- Auto -', 'ALSP') . '</option>';
			foreach ($alsp_instance->directories->directories_array AS $directory) {
				$out .= '<option value="' . $directory->id . '" ' . selected($value, $directory->id, false) . '>' . $directory->name . '</option>';
			}
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
			return $out;
		}
	}
	
	if (!function_exists('alsp_directory_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('directory', 'alsp_directory_param');
		function alsp_directory_param($settings, $value) {
			global $alsp_instance;

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : 0) . '>' . __('- Auto -', 'ALSP') . '</option>';
			foreach ($alsp_instance->directories->directories_array AS $directory) {
				$out .= '<option value="' . $directory->id . '" ' . selected($value, $directory->id, false) . '>' . $directory->name . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}
	
	if (!function_exists('alsp_levels_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('levels', 'alsp_levels_param');
		function alsp_levels_param($settings, $value) {
			global $alsp_instance;
	
			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
		
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";
	
			$out .= '<select id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" multiple="multiple">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Auto -', 'ALSP') . '</option>';
			foreach ($alsp_instance->levels->levels_array AS $level) {
				$out .= '<option value="' . $level->id . '" ' . selected($value, $level->id, false) . '>' . $level->name . '</option>';
			}
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
			return $out;
		}
	}

	if (!function_exists('alsp_level_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('level', 'alsp_level_param');
		function alsp_level_param($settings, $value) {
			global $alsp_instance;

			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : 0) . '>' . __('- Auto -', 'ALSP') . '</option>';
			foreach ($alsp_instance->levels->levels_array AS $level) {
				$out .= '<option value="' . $level->id . '" ' . selected($value, $level->id, false) . '>' . $level->name . '</option>';
			}
			$out .= '</select>';
	
			return $out;
		}
	}

	if (!function_exists('alsp_categories_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('categoriesfield', 'alsp_categories_param');
		function alsp_categories_param($settings, $value) {
			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
		
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";
		
			$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_CATEGORIES_TAX, 0, explode(',', $value));
			$out .= ob_get_clean();
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
		
			return $out;
		}
	}

	if (!function_exists('alsp_category_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('categoryfield', 'alsp_category_param');
		function alsp_category_param($settings, $value) {
			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- No category selected -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_CATEGORIES_TAX, 0, array($value));
			$out .= ob_get_clean();
			$out .= '</select>';
		
			return $out;
		}
	}
	
	if (!function_exists('alsp_listingtypes_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('listingtypesfield', 'alsp_listingtypes_param');
		function alsp_listingtypes_param($settings, $value) {
			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
		
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";
		
			$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_TYPE_TAX, 0, explode(',', $value));
			$out .= ob_get_clean();
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
		
			return $out;
		}
	}
	
	if (!function_exists('alsp_listingtype_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('listingtypefield', 'alsp_listingtype_param');
		function alsp_listingtype_param($settings, $value) {
			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- No category selected -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_TYPE_TAX, 0, array($value));
			$out .= ob_get_clean();
			$out .= '</select>';
		
			return $out;
		}
	}

	if (!function_exists('alsp_locations_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('locationsfield', 'alsp_locations_param');
		function alsp_locations_param($settings, $value) {
			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
		
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";
		
			$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_LOCATIONS_TAX, 0, explode(',', $value));
			$out .= ob_get_clean();
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
		
			return $out;
		}
	}

	if (!function_exists('alsp_location_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('locationfield', 'alsp_location_param');
		function alsp_location_param($settings, $value) {
			$out = '<select id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- No location selected -', 'ALSP') . '</option>';
			ob_start();
			alsp_renderOptionsTerms(ALSP_LOCATIONS_TAX, 0, array($value));
			$out .= ob_get_clean();
			$out .= '</select>';
		
			return $out;
		}
	}

	if (!function_exists('alsp_content_fields_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		vc_add_shortcode_param('contentfields', 'alsp_content_fields_param');
		function alsp_content_fields_param($settings, $value) {
			global $alsp_instance;
			$out = "<script>
				function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
		
				jQuery(function() {
					jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
					updateTagChecked();
				});
			</script>";

			$content_fields_ids = explode(',', $value);
			$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
			$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- All content fields -', 'ALSP') . '</option>';
			$out .= '<option value="-1" ' . (($value == -1) ? 'selected' : '') . '>' . __('- No content fields -', 'ALSP') . '</option>';
			foreach ($alsp_instance->search_fields->search_fields_array AS $search_field)
				$out .= '<option value="' . $search_field->content_field->id . '" ' . (in_array($search_field->content_field->id, $content_fields_ids) ? 'selected' : '') . '>' . $search_field->content_field->name . '</option>';
			$out .= '</select>';
			$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
		
			return $out;
		}
	}
	
	vc_map( array(
		'name'                    => __('ALSP Listing', 'ALSP'),
		'description'             => __('Main shortcode', 'ALSP'),
		'base'                    => 'alsp-main',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Is it on custom home page?', 'ALSP'),
			),
			array(
					'type' => 'directory',
					'param_name' => 'id',
					'heading' => __('Select Directory', 'ALSP'),
			),
			array(
					'type' => 'textarea_raw_html',
					'param_name' => 'archive_top_banner',
					'heading' => __('Add Custom Banner or adsense ads below header ', 'ALSP'),
			),
			array(
					'type' => 'textarea_raw_html',
					'param_name' => 'archive_below_search_banner',
					'heading' => __('Add Custom Banner or adsense ads below Search ', 'ALSP'),
			),
			array(
					'type' => 'textarea_raw_html',
					'param_name' => 'archive_below_category_banner',
					'heading' => __('Add Custom Banner or adsense ads below Categories ', 'ALSP'),
			),
			array(
					'type' => 'textarea_raw_html',
					'param_name' => 'archive_below_locations_banner',
					'heading' => __('Add Custom Banner or adsense ads below Locations', 'ALSP'),
			),
			array(
					'type' => 'textarea_raw_html',
					'param_name' => 'archive_below_listings_banner',
					'heading' => __('Add Custom Banner or adsense ads below Listings ', 'ALSP'),
			),
			array(
						'type' => 'contentfields',
						'param_name' => 'search_fields',
						'heading' => __('Select certain content fields', 'ALSP'),
				),
				array(
						'type' => 'contentfields',
						'param_name' => 'search_fields_advanced',
						'heading' => __('Select certain content fields in advanced section', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'hide_search_button',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Hide search button', 'ALSP'),
				),
		),
	));
	
	if ($alsp_fsubmit_instance) {
		vc_map( array(
			'name'                    => __('Listings submit', 'ALSP'),
			'description'             => __('Listings submission pages', 'ALSP'),
			'base'                    => 'alsp-submit',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
				array(
						'type' => 'levels',
						'param_name' => 'levels',
						'heading' => __('Listings levels', 'ALSP'),
						'description' => __('Choose exact levels to display', 'ALSP'),
						'value' => '',
				),
				array(
						'type' => 'directory',
						'param_name' => 'directory',
						'heading' => __("Specific directory", "ALSP"),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns',
						'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
						'std' => '3',
						'heading' => __('Columns', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns_same_height',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show negative parameters?', 'ALSP'),
						'description' => __('Show parameters those have negation. For example, such row in the table will be shown: Featured Listings - No. In other case this row will be hidden.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_period',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show level active period on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_sticky',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level sticky on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_featured',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level featured on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level categories number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level locations number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_maps',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level supports maps on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_images',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level images number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_videos',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level videos number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'checkbox',
						'param_name' => 'visibility',
						'heading' => __("Show only on directory pages", "ALSP"),
						'value' => 1,
						'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
				),
			),
		));
		vc_map( array(
			'name'                    => __('Pricing table', 'ALSP'),
			'description'             => __('Listings levels table. Works in the same way as 1st step on Listings submit, displays only pricing table. Note, that page with Listings submit element required.', 'ALSP'),
			'base'                    => 'alsp-levels-table',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
				array(
						'type' => 'levels',
						'param_name' => 'levels',
						'heading' => __('Listings levels', 'ALSP'),
						'description' => __('Choose exact levels to display', 'ALSP'),
						'value' => '',
				),
				array(
						'type' => 'directory',
						'param_name' => 'directory',
						'heading' => __("Specific directory", "ALSP"),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns',
						'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4'),
						'std' => '3',
						'heading' => __('Columns', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns_same_height',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show negative parameters?', 'ALSP'),
						'description' => __('Show parameters those have negation. For example, such row in the table will be shown: Featured Listings - No. In other case this row will be hidden.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_period',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show level active period on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_sticky',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level sticky on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_featured',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level featured on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level categories number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level locations number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_maps',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level supports maps on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_images',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level images number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_videos',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level videos number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'checkbox',
						'param_name' => 'visibility',
						'heading' => __("Show only on directory pages", "ALSP"),
						'value' => 1,
						'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
				),
			),
		));
		vc_map( array(
			'name'                    => __('Users Dashboard', 'ALSP'),
			'description'             => __('Listing frontend dashboard', 'ALSP'),
			'base'                    => 'alsp-dashboard',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
		));
	}
	
	$vc_listings_args = array(
		'name'                    => __('Listings', 'ALSP'),
		'description'             => __('Listings filtered by params', 'ALSP'),
		'base'                    => 'alsp-listings',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			array(
					'type' => 'directories',
					'param_name' => 'directories',
					'heading' => __("Listings of these directories", "ALSP"),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => __('Enter unique string to connect this shortcode with another shortcode.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show all possible listings on one page?', 'ALSP'),
			),
			apply_filters("alsp_listing_vc_settings_filter" , "alsp_listing_vc_settings"),
			apply_filters("alsp_listing_featured_tags_vc_settings_filter" , "alsp_listing_featured_tags_vc_settings"),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_initial_load',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Load listings only after the page was completely loaded.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => '2col_responsive',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show 2 column listing on Mobile devices.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'masonry_layout',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Turn on Masonry Layout.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => __('Number of listing per page', 'ALSP'),
					'description' => __('Number of listings to display per page. Set -1 to display all listings without paginator.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide paginator', 'ALSP'),
					'description' => __('When paginator is hidden - it will display only exact number of listings.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scrolling_paginator',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Load next set of listing on scroll', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
					'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order_by',
					'value' => $ordering,
					'heading' => __('Order by', 'ALSP'),
					'description' => __('Order listings by any of these parameter.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'value' => array(__('Ascending', 'ALSP') => 'ASC', __('Descending', 'ALSP') => 'DESC'),
					'description' => __('Direction of sorting.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide ordering links?', 'ALSP'),
					'description' => __('Whether to hide ordering navigation links.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing_order_by_txt',
					'heading' => __('Order By Text', 'ALSP'),
					'description' => __('Option will work if Ordering links are On', 'ALSP'),
					'dependency' => array('element' => 'hide_order', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_count',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide number of listings?', 'ALSP'),
					'description' => __('Whether to hide number of found listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_views_switcher',
					'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
					'heading' => __('Show listings views switcher?', 'ALSP'),
					'description' => __('Whether to show listings views switcher.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_type',
					'value' => array(__('List', 'ALSP') => 'list', __('Grid', 'ALSP') => 'grid'),
					'heading' => __('Listings view by default', 'ALSP'),
					'description' => __('Do not forget that selected view will be stored in cookies.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_grid_columns',
					'value' => array('1', '2', '3', '4', '5', '6'),
					'heading' => __('Number of columns for listings Grid View', 'ALSP'),
					//'std' => 2,
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing_thumb_width',
					'heading' => __('Listing thumbnail logo width in List View', 'ALSP'),
					'description' => __('in pixels', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'wrap_logo_list_view',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Wrap logo image by text content in List View', 'ALSP'),
			),
			
			
			array(
					'type' => 'textfield',
					'param_name' => 'grid_padding',
					'value' => '15',
					'heading' => __('Grid padding ', 'ALSP'),
					'description' => __('padding between columns', 'ALSP'),
			),
			array(
					'type' => 'range',
					'param_name' => 'listing_image_width',
					'value' => 370,
					'min' => 0,
					'max' => 770,
					'heading' => __('Grid image width', 'ALSP'),
					'step' => 1,
					'unit' => 'px',
					//'std' => 2,
			),
			array(
					'type' => 'range',
					'param_name' => 'listing_image_height',
					'value' => 270,
					'min' => 0,
					'max' => 770,
					'heading' => __('Grid image Height', 'ALSP'),
					'step' => 1,
					'unit' => 'px',
					//'std' => 2,
			),
			array(
					'type' => 'textfield',
					'param_name' => 'address',
					'heading' => __('Address', 'ALSP'),
					'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'radius',
					'heading' => __('Radius', 'ALSP'),
					'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => __('Author', 'ALSP'),
					'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related categories.', 'ALSP'),
					'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					//'value' => 0,
					'heading' => __('Select certain categories', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related locations.', 'ALSP'),
					'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					//'value' => 0,
					'heading' => __('Select certain locations', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related tags.', 'ALSP'),
					'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'include_categories_children',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Include children of selected categories and locations', 'ALSP'),
					'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'levels',
					'value' => $levels,
					'heading' => __('Listings levels', 'ALSP'),
					'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => __('Exact listings', 'ALSP'),
					'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scroll',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Scroll', 'ALSP'),
					'description' => __('listing carousel', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scroller_nav_style',
					'value' => array(__('Style 1', 'ALSP') => '1', __('Style 2', 'ALSP') => '2'),
					'heading' => __('Scroller Navigation style.', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'custom_category_link',
					'value' => '',
					'heading' => __('Custom Category Link', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'custom_category_link_text',
					'value' => '',
					'heading' => __('Custom Category Link Text', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'visibility',
					'heading' => __("Show only on directory pages", "ALSP"),
					'value' => 1,
					'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
			),
		),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_listings_args['params'] = array_merge($vc_listings_args['params'], $field_params);
	}
	vc_map($vc_listings_args);
	
	vc_map(array(
			'name'                    => __('Single Listing', 'ALSP'),
			'description'             => __('The page with single listing', 'ALSP'),
			'base'                    => 'alsp-listing',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
					array(
							'type' => 'textfield',
							'param_name' => 'listing_id',
							'heading' => __('ID of listing', 'ALSP'),
							'description' => __('Enter exact ID of listing or leave empty to build custom page for any single listing.', 'ALSP'),
					),
			),
		)
	);
	
	$vc_maps_args = array(
			'name'                    => __('Listing Map', 'ALSP'),
			'description'             => __('Listing map and markers', 'ALSP'),
			'base'                    => 'alsp-map',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
				array(
						'type' => 'dropdown',
						'param_name' => 'custom_home',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Is it on custom home page?', 'ALSP'),
				),
				array(
						'type' => 'directories',
						'param_name' => 'directories',
						'heading' => __("Listings of these directories", "ALSP"),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'map_markers_is_limit',
						'value' => array(__('Display all map markers', 'ALSP') => '0', __('The only map markers of visible listings will be displayed (when listings shortcode is connected with map by unique string)', 'ALSP') => '1'),
						'heading' => __('How many map markers to display on the map', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'uid',
						'value' => '',
						'heading' => __('uID. Enter unique string to connect this shortcode with another shortcode.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'draw_panel',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Enable Draw Panel', 'ALSP'),
						'description' => __('Very important: MySQL version must be 5.6.1 and higher or MySQL server variable "thread stack" must be 256K and higher. Ask your host about it if "Draw Area" does not work.', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'num',
						'value' => -1,
						'heading' => __('Number of markers', 'ALSP'),
						'description' => __('Number of markers to display on map (-1 gives all markers).', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'width',
						'heading' => __('Width', 'ALSP'),
						'description' => __('Set map width in pixels. With empty field the map will take all possible width.', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'height',
						'value' => 400,
						'heading' => __('Height', 'ALSP'),
						'description' => __('Set map height in pixels, also possible to set 100% value.', 'ALSP'),
				),
				array(
						'type' => 'mapstyle',
						'param_name' => 'map_style',
						'heading' => __('Maps style', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'sticky_scroll',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Make map to be sticky on scroll', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'sticky_scroll_toppadding',
						'value' => 0,
						'heading' => __('Sticky scroll top padding', 'ALSP'),
						'description' => __('Top padding in pixels.', 'ALSP'),
						'dependency' => array('element' => 'sticky_scroll', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_summary_button',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show summary button?', 'ALSP'),
						'description' => __('Show summary button in InfoWindow?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_readmore_button',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show read more button?', 'ALSP'),
						'description' => __('Show read more button in InfoWindow?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'geolocation',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('GeoLocation', 'ALSP'),
						'description' => __('Geolocate user and center map.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'ajax_loading',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('AJAX loading', 'ALSP'),
						'description' => __('When map contains lots of markers - this may slow down map markers loading. Select AJAX to speed up loading. Requires Starting Address or Starting Point coordinates Latitude and Longitude.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'ajax_markers_loading',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Maps info window AJAX loading', 'ALSP'),
						'description' => __('This may additionally speed up loading.', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'start_address',
						'heading' => __('Starting Address', 'ALSP'),
						'description' => __('When map markers load by AJAX - it should have starting point and starting zoom. Enter start address or select latitude and longitude (recommended). Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'start_latitude',
						'heading' => __('Starting Point Latitude', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'start_longitude',
						'heading' => __('Starting Point Longitude', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'start_zoom',
						'heading' => __('Default zoom', 'ALSP'),
						'value' => array(__("Auto", "ALSP") => '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'),
						'std' => '0',
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'sticky_featured',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show markers only of sticky or/and featured listings?', 'ALSP'),
						'description' => __('Whether to show markers only of sticky or/and featured listings.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				/* array(
						'type' => 'dropdown',
						'param_name' => 'search_on_map',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show search form and listings panel on the map', 'ALSP'),
				), */
				/* array(
						'type' => 'dropdown',
						'param_name' => 'search_on_map_open',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Search form open by default', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_keywords_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show keywords search?', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'keywords_ajax_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Enable listings autosuggestions by keywords', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'what_search',
						'heading' => __('Default keywords', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show categories search?', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'categories_search_level',
						'value' => array('1', '2', '3'),
						'std' => '2',
						'heading' => __('Categories search depth level in search', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'categoryfield',
						'param_name' => 'category',
						'heading' => __('Select certain category in search', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'categoriesfield',
						'param_name' => 'exact_categories',
						'heading' => __('List of categories in search', 'ALSP'),
						'description' => __('Comma separated string of categories slugs or IDs. Possible to display exact categories.', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show locations search?', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'locations_search_level',
						'value' => array('1', '2', '3'),
						'std' => '2',
						'heading' => __('Locations search depth level', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'locationfield',
						'param_name' => 'location',
						'heading' => __('Select certain location', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'locationsfield',
						'param_name' => 'exact_locations',
						'heading' => __('List of locations in search', 'ALSP'),
						'description' => __('Comma separated string of locations slugs or IDs. Possible to display exact locations.', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_address_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show address search?', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'address',
						'heading' => __('Default address, recommended to set default radius.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_radius_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show locations radius search?', 'ALSP'),
						'dependency' => array('element' => 'search_on_map', 'value' => '1'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'radius',
						'heading' => __('Default radius search. Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
				), */
				array(
						'type' => 'dropdown',
						'param_name' => 'radius_circle',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show radius circle?', 'ALSP'),
						'description' => __('Display radius circle on map when radius filter provided.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'clusters',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Group map markers in clusters?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'enable_full_screen',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Enable full screen button', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'enable_wheel_zoom',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Enable zoom by mouse wheel', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'enable_dragging_touchscreens',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Enable map dragging on touch screen devices', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'center_map_onclick',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Center map on marker click', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'author',
						'heading' => __('Author', 'ALSP'),
						'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'related_categories',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Use related categories.', 'ALSP'),
						'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'categoriesfield',
						'param_name' => 'categories',
						'heading' => __('Select listings categories to display on map', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'related_locations',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Use related locations.', 'ALSP'),
						'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'locationsfield',
						'param_name' => 'locations',
						'heading' => __('Select listings locations to display on map', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'related_tags',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Use related tags.', 'ALSP'),
						'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'include_categories_children',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Include children of selected categories and locations', 'ALSP'),
						'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'level',
						'param_name' => 'levels',
						'heading' => __('Listings levels', 'ALSP'),
						'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'post__in',
						'heading' => __('Exact listings', 'ALSP'),
						'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'checkbox',
						'param_name' => 'visibility',
						'heading' => __("Show only on Listing pages", "ALSP"),
						'value' => 1,
						'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
				),
			),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_maps_args['params'] = array_merge($vc_maps_args['params'], $field_params);
	}
	vc_map($vc_maps_args);

	vc_map( array(
		'name'                    => __('Categories List', 'ALSP'),
		'description'             => __('Listing categories list', 'ALSP'),
		'base'                    => 'alsp-categories',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			/*array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
			),*/
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => __("Categories links will redirect to selected directory", "ALSP"),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'cat_style',
				'value' => array(__('Style 1 ( Elca and Max )', 'ALSP') => '1', __('Style 2 Echo', 'ALSP') => '2',  __('Style 3 Zee', 'ALSP') => '3', __('Style 4 Wox', 'ALSP') => '4', __('Style 5 Ultra', 'ALSP') => '5', __('Style 6 Mintox', 'ALSP') => '6', __('Style 7 Zoco', 'ALSP') => '7',  __('Style 8 Fantro (List)', 'ALSP') => '8',  __('Style 9 ', 'ALSP') => '9', __('Style 10 ', 'ALSP') => '10', __('Style 11 ', 'ALSP') => '11'),
				'heading' => __('category styles', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'parent',
				//'value' => 0,
				'heading' => __('Parent category', 'ALSP'),
				'description' => __('ID of parent category (default 0 – this will build whole categories tree starting from the root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Categories nesting level', 'ALSP'),
				'description' => __('The max depth of categories tree. When set to 1 – only root categories will be listed.', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '3',
					'6',
					'7',
					'10'
                ),
				)
			),
			array(
				'type' => 'textfield',
				'param_name' => 'subcats',
				//'value' => 0,
				'heading' => __('Show subcategories items number', 'ALSP'),
				'description' => __('This is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4', '5', '6', 'inline'),
				'heading' => __('Categories columns number', 'ALSP'),
				'description' => __('Categories list is divided by columns.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'cat_icon_type',
				'value' => array(__('Font Icons', 'ALSP') => '1', __('Image Icons', 'ALSP') => '2', __('SVG Icons', 'ALSP') => '3'),
				'heading' => __('Select Categories icon type', 'ALSP'),
				'description' => '',
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show category listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current category in brackets.', 'ALSP'),
			),
			array(
				"type" => "range",
				"heading" => esc_html__("Parent category font size", "alsp"),
				"param_name" => "cat_font_size",
				"value" => '',
				"min" => "0",
				"max" => "36",
				"step" => "1",
				"unit" => 'px',
				//"description" => esc_html__("", "alsp")
			),
			array(
				"type" => "range",
				"heading" => esc_html__("Child category font size", "ALSP"),
				"param_name" => "child_cat_font_size",
				"value" => '',
				"min" => "0",
				"max" => "24",
				"step" => "1",
				"unit" => 'px',
				//"description" => esc_html__("", "ALSP")
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'cat_font_weight',
					'value' => array(__('300', 'ALSP') => '300', __('400', 'ALSP') => '400', __('700', 'ALSP') => '700',  __('900', 'ALSP') => '900'),
					'heading' => __('Parent category font weight', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'child_cat_font_weight',
					'value' => array(__('300', 'ALSP') => '300', __('400', 'ALSP') => '400', __('700', 'ALSP') => '700',  __('900', 'ALSP') => '900'),
					'heading' => __('Child category font weight', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'cat_font_line_height',
					'value' => '',
					'heading' => __('Parent category line-height ', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'child_cat_font_line_height',
					'value' => '',
					'heading' => __('Child category line-height ', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'cat_font_transform',
					'value' => array(__('Lowercase', 'ALSP') => 'lowercase', __('Capitalize', 'ALSP') => 'capitalize', __('Uppercase', 'ALSP') => 'uppercase'),
					'heading' => __('Parent category text transform', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'child_cat_font_transform',
					'value' => array(__('Lowercase', 'ALSP') => 'lowercase', __('Capitalize', 'ALSP') => 'capitalize', __('Uppercase', 'ALSP') => 'uppercase'),
					'heading' => __('Child category text transform', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category background color", "ALSP"),
				"param_name" => "cat_bg",
				"value" => "",
				"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category background color on hover", "alsp"),
				"param_name" => "cat_bg_hover",
				"value" => "",
				"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category parent title color", "alsp"),
				"param_name" => "parent_cat_title_color",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Child title color", "alsp"),
				"param_name" => "subcategory_title_color",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category parent title color on hover", "alsp"),
				"param_name" => "parent_cat_title_color_hover",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Child title color on hover", "alsp"),
				"param_name" => "subcategory_title_color_hover",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Border color", "alsp"),
				"param_name" => "cat_border_color",
				"value" => "",
				"description" => esc_html__("will effect style 6", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Border color on hover", "alsp"),
				"param_name" => "cat_border_color_hover",
				"value" => "",
				"description" => esc_html__("will effect style 6", "alsp")
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'scroll',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('scroll', 'ALSP'),
				'description' => __('', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '1',
					'2',
					'3',
					'4',
					'5'
                ),
				)
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'levels',
				'value' => $levels,
				'heading' => __('Listings levels', 'ALSP'),
				'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
				'type' => 'categoriesfield',
				'param_name' => 'categories',
				//'value' => 0,
				'heading' => __('Categories', 'ALSP'),
				'description' => __('Comma separated string of categories slugs or IDs. Possible to display exact categories.', 'ALSP'),
			),
		),
	));
	
	vc_map( array(
		'name'                    => __('Listing Types List', 'ALSP'),
		'description'             => __('Listing Types list', 'ALSP'),
		'base'                    => 'alsp-listingtypes',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			/*array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
			),*/
			array(
					'type' => 'directory',
					'param_name' => 'directory',
					'heading' => __("Listing types links will redirect to selected directory", "ALSP"),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'cat_style',
				'value' => array(__('Style 1 ( Elca and Max )', 'ALSP') => '1', __('Style 2 Echo', 'ALSP') => '2',  __('Style 3 Zee', 'ALSP') => '3', __('Style 4 Wox', 'ALSP') => '4', __('Style 5 Ultra', 'ALSP') => '5', __('Style 6 Mintox', 'ALSP') => '6', __('Style 7 Zoco', 'ALSP') => '7',  __('Style 8 Fantro (List)', 'ALSP') => '8',  __('Style 9 ', 'ALSP') => '9', __('Style 10 ', 'ALSP') => '10'),
				'heading' => __('category styles', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'parent',
				//'value' => 0,
				'heading' => __('Parent category', 'ALSP'),
				'description' => __('ID of parent category (default 0 – this will build whole categories tree starting from the root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Categories nesting level', 'ALSP'),
				'description' => __('The max depth of categories tree. When set to 1 – only root categories will be listed.', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '3',
					'6',
					'7',
					'10'
                ),
				)
			),
			array(
				'type' => 'textfield',
				'param_name' => 'subcats',
				//'value' => 0,
				'heading' => __('Show subcategories items number', 'ALSP'),
				'description' => __('This is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4', '5', '6', 'inline'),
				'heading' => __('Categories columns number', 'ALSP'),
				'description' => __('Categories list is divided by columns.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'cat_icon_type',
				'value' => array(__('Font Icons', 'ALSP') => '1', __('Image Icons', 'ALSP') => '2', __('SVG Icons', 'ALSP') => '3'),
				'heading' => __('Select Categories icon type', 'ALSP'),
				'description' => '',
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show category listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current category in brackets.', 'ALSP'),
			),
			array(
				"type" => "range",
				"heading" => esc_html__("Parent category font size", "alsp"),
				"param_name" => "cat_font_size",
				"value" => '',
				"min" => "0",
				"max" => "36",
				"step" => "1",
				"unit" => 'px',
				//"description" => esc_html__("", "alsp")
			),
			array(
				"type" => "range",
				"heading" => esc_html__("Child category font size", "ALSP"),
				"param_name" => "child_cat_font_size",
				"value" => '',
				"min" => "0",
				"max" => "24",
				"step" => "1",
				"unit" => 'px',
				//"description" => esc_html__("", "ALSP")
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'cat_font_weight',
					'value' => array(__('300', 'ALSP') => '300', __('400', 'ALSP') => '400', __('700', 'ALSP') => '700',  __('900', 'ALSP') => '900'),
					'heading' => __('Parent category font weight', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'child_cat_font_weight',
					'value' => array(__('300', 'ALSP') => '300', __('400', 'ALSP') => '400', __('700', 'ALSP') => '700',  __('900', 'ALSP') => '900'),
					'heading' => __('Child category font weight', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'cat_font_line_height',
					'value' => '',
					'heading' => __('Parent category line-height ', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'child_cat_font_line_height',
					'value' => '',
					'heading' => __('Child category line-height ', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'cat_font_transform',
					'value' => array(__('Lowercase', 'ALSP') => 'lowercase', __('Capitalize', 'ALSP') => 'capitalize', __('Uppercase', 'ALSP') => 'uppercase'),
					'heading' => __('Parent category text transform', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'child_cat_font_transform',
					'value' => array(__('Lowercase', 'ALSP') => 'lowercase', __('Capitalize', 'ALSP') => 'capitalize', __('Uppercase', 'ALSP') => 'uppercase'),
					'heading' => __('Child category text transform', 'ALSP'),
					'description' => '',
					//'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category background color", "ALSP"),
				"param_name" => "cat_bg",
				"value" => "",
				"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category background color on hover", "alsp"),
				"param_name" => "cat_bg_hover",
				"value" => "",
				"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category parent title color", "alsp"),
				"param_name" => "parent_cat_title_color",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Child title color", "alsp"),
				"param_name" => "subcategory_title_color",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category parent title color on hover", "alsp"),
				"param_name" => "parent_cat_title_color_hover",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Child title color on hover", "alsp"),
				"param_name" => "subcategory_title_color_hover",
				"value" => "",
				//"description" => esc_html__("depended on category styles, this color will effect category icon box for style 1 and style 2, and will effect category wrapper for all other styles", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Border color", "alsp"),
				"param_name" => "cat_border_color",
				"value" => "",
				"description" => esc_html__("will effect style 6", "alsp")
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Category Border color on hover", "alsp"),
				"param_name" => "cat_border_color_hover",
				"value" => "",
				"description" => esc_html__("will effect style 6", "alsp")
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'scroll',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('scroll', 'ALSP'),
				'description' => __('', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '1',
					'2',
					'3',
					'4',
					'5'
                ),
				)
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'levels',
				'value' => $levels,
				'heading' => __('Listings levels', 'ALSP'),
				'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
				'type' => 'listingtypesfield',
				'param_name' => 'listingtypes',
				//'value' => 0,
				'heading' => __('Listing Types', 'ALSP'),
				'description' => __('Comma separated string of Types slugs or IDs. Possible to display exact Types.', 'ALSP'),
			),
		),
	));

	vc_map( array(
		'name'                    => __('Locations List', 'ALSP'),
		'class'                    => 'location-element',
		'description'             => __('Listing locations list', 'ALSP'),
		'base'                    => 'alsp-locations',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			
			/*array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
			),*/
			array(
				'type' => 'dropdown',
				'param_name' => 'location_style',
				'value' => array(__('Default', 'ALSP') => '0', __('Style1', 'ALSP') => '1', __('Style2', 'ALSP') => '2',  __('Style3', 'ALSP') => '3', __('Style4', 'ALSP') => '4',  __('Style5', 'ALSP') => '5',  __('Style6', 'ALSP') => '6',  __('Style 7', 'ALSP') => '7', __('Style 8 solic', 'ALSP') => '8', __('Style 9 Mintox', 'ALSP') => '9', __('Style 10 Directory', 'ALSP') => '10'),
				'heading' => __('Location styles', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'parent',
				//'value' => 0,
				'heading' => __('Parent location', 'ALSP'),
				'description' => __('ID of parent location (default 0 – this will build whole locations tree starting from the root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
            "type" => "colorpicker",
            "heading" => esc_html__("background Color", "alsp"),
            "param_name" => "location_bg",
            "value" => "",
            "description" => esc_html__("", "alsp")
			),
		array(
            "type" => "upload",
            "heading" => esc_html__("Background Image", "alsp"),
            "param_name" => "location_bg_image",
            "value" => "",
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Gradient Color 1", "alsp"),
            "param_name" => "gradientbg1",
            "value" => "",
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Gradient Color 2", "alsp"),
            "param_name" => "gradientbg2",
            "value" => "",
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Opacity Color 1", "alsp"),
            "param_name" => "opacity1",
            "value" => "0",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Opacity Color 2", "alsp"),
            "param_name" => "opacity2",
            "value" => "0",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Gradient Angle", "alsp"),
            "param_name" => "gradient_angle",
            "value" => "0",
            "min" => "0",
            "max" => "360",
            "step" => "1",
            "unit" => 'deg',
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Column width", "alsp"),
            "param_name" => "location_width",
            "value" => "30",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Column Height ", "alsp"),
            "param_name" => "location_height",
            "value" => "480",
            "min" => "0",
            "max" => "800",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "alsp")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Top", "alsp"),
            "param_name" => "location_padding",
            "value" => "15",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "alsp")
        ),
			array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Locations nesting level', 'ALSP'),
				'description' => __('The max depth of locations tree. When set to 1 – only root locations will be listed.', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'sublocations',
				//'value' => 0,
				'heading' => __('Show sub-locations items number', 'ALSP'),
				'description' => __('This is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all sublocations ->" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4'),
				'heading' => __('Locations columns number', 'ALSP'),
				'description' => __('Locations list is divided by columns.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Show location listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current location in brackets.', 'ALSP'),
			),
			array(
				'type' => 'locationsfield',
				'param_name' => 'locations',
				//'value' => 0,
				'heading' => __('Locations', 'ALSP'),
				'description' => __('Comma separated string of locations slugs or IDs. Possible to display exact locations.', 'ALSP'),
			),
		),
	));

	vc_map( array(
		'name'                    => __('Search form', 'ALSP'),
		'description'             => __('Listing listings search form', 'ALSP'),
		'base'                    => 'alsp-search',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => false,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
				array(
						'type' => 'dropdown',
						'param_name' => 'custom_home',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Is it on custom home page?', 'ALSP'),
						//'description' => __('When set to Yes - the widget will follow some parameters from Directory Settings and not those listed here.', 'ALSP'),
				),
				/* array(
						'type' => 'dropdown',
						'param_name' => 'columns',
						'value' => array('2', '1'),
						'std' => '2',
						'heading' => __('Number of columns to arrange search fields', 'ALSP'),
				), */
				array(
						'type' => 'directory',
						'param_name' => 'directory',
						'heading' => __("Search by directory", "ALSP"),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'uid',
						'value' => '',
						'heading' => __('Enter unique string to connect this shortcode with another shortcode.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'advanced_open',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Advanced search panel always open', 'ALSP'),
				),array(
						'type' => 'dropdown',
						'param_name' => 'sticky_scroll',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Make search form to be sticky on scroll', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'sticky_scroll_toppadding',
						'value' => 0,
						'heading' => __('Sticky scroll top padding', 'ALSP'),
						'description' => __('Sticky scroll top padding in pixels.', 'ALSP'),
						'dependency' => array('element' => 'sticky_scroll', 'value' => '1'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_keywords_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show keywords search?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'keywords_ajax_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Enable listings autosuggestions by keywords', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'keywords_search_examples',
						'heading' => __('Keywords examples', 'ALSP'),
						'description' => __('Comma-separated list of suggestions to try to search.', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'what_search',
						'heading' => __('Default keywords', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show categories search?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'categories_search_level',
						'value' => array('1', '2', '3'),
						'std' => '2',
						'heading' => __('Categories search depth level', 'ALSP'),
				),
				array(
						'type' => 'categoryfield',
						'param_name' => 'category',
						'heading' => __('Select certain category', 'ALSP'),
				),
				array(
						'type' => 'categoriesfield',
						'param_name' => 'exact_categories',
						'heading' => __('List of categories', 'ALSP'),
						'description' => __('Comma separated string of categories slugs or IDs. Possible to display exact categories.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_listingtype_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show Listing Type search?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'listingtype_search_level',
						'value' => array('1', '2', '3'),
						'std' => '2',
						'heading' => __('Listing Type search depth level', 'ALSP'),
				),
				array(
						'type' => 'listingtypefield',
						'param_name' => 'listingtype',
						'heading' => __('Select certain Listing Types', 'ALSP'),
				),
				array(
						'type' => 'listingtypesfield',
						'param_name' => 'exact_listingtypes',
						'heading' => __('List of Listing Type', 'ALSP'),
						'description' => __('Comma separated string of Listing Type slugs or IDs. Possible to display exact Listing Type.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show locations search?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'locations_search_level',
						'value' => array('1', '2', '3'),
						'std' => '2',
						'heading' => __('Locations search depth level', 'ALSP'),
				),
				array(
						'type' => 'locationfield',
						'param_name' => 'location',
						'heading' => __('Select certain location', 'ALSP'),
				),
				array(
						'type' => 'locationsfield',
						'param_name' => 'exact_locations',
						'heading' => __('List of locations', 'ALSP'),
						'description' => __('Comma separated string of locations slugs or IDs. Possible to display exact locations.', 'ALSP'),
						'dependency' => array('element' => 'custom_home', 'value' => '0'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_address_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show address search?', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'address',
						'heading' => __('Default address', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_radius_search',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show locations radius search?', 'ALSP'),
				),
				array(
						'type' => 'textfield',
						'param_name' => 'radius',
						'heading' => __('Default radius search', 'ALSP'),
				),
				array(
						'type' => 'contentfields',
						'param_name' => 'search_fields',
						'heading' => __('Select certain content fields', 'ALSP'),
				),
				array(
						'type' => 'contentfields',
						'param_name' => 'search_fields_advanced',
						'heading' => __('Select certain content fields in advanced section', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'hide_search_button',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Hide search button', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'on_row_search_button',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Search button on one line with fields', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'scroll_to',
						'value' => array(__('No scroll', 'ALSP') => '', __('Listings', 'ALSP') => 'listings', __('Map', 'ALSP') => 'map'),
						'heading' => __('Scroll to listings, map or do not scroll after search button was pressed', 'ALSP'),
				),
				array(
						'type' => 'checkbox',
						'param_name' => 'search_visibility',
						'heading' => __("Show only when there is no any other search form on page", "ALSP"),
				),
				array(
						'type' => 'checkbox',
						'param_name' => 'visibility',
						'heading' => __("Show only on directory pages", "ALSP"),
						'value' => 1,
						'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
				),
				array(
						'type' => 'range',
						'param_name' => 'keyword_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Keyword Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'listingtype_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Listing Types Field In Search Form', 'ALSP'),
				),
				/* array(
						'type' => 'range',
						'param_name' => 'category_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Category Field In Search Form', 'ALSP'),
				), */
				array(
						'type' => 'range',
						'param_name' => 'location_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Location Field In Search Form', 'ALSP'),
				),
				/* array(
						'type' => 'range',
						'param_name' => 'address_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Address Field In Search Form', 'ALSP'),
				), */
				array(
						'type' => 'range',
						'param_name' => 'radius_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Radius Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'button_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Search Button Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_button_margin_top',
						'value' => 0,
						'min' => 0,
						'max' => 50,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Set Margin top for Search Button Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'gap_in_fields',
						'value' => 10,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set gap between Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_default_filed_label',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show Field Label for default fields', 'ALSP'),
						'save_always' => true,
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'search_custom_style',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Custom Styling', 'ALSP'),
						'save_always' => true,
				),
				array(
						'type' => 'range',
						'param_name' => 'search_box_padding_top',
						'value' => '',
						'min' => 0,
						'max' => 200,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Search Box Padding Top', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_box_padding_bottom',
						'value' => '',
						'min' => 0,
						'max' => 200,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Search Box Padding Bottom', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_box_padding_left',
						'value' => '',
						'min' => 0,
						'max' => 200,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Search Box Padding Left', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_box_padding_right',
						'value' => '',
						'min' => 0,
						'max' => 200,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Search Box Padding Right', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Main Search Box background Color", "ALSP"),
					"param_name" => "main_searchbar_bg_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Main Search Box Border Color", "ALSP"),
					"param_name" => "main_search_border_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'input_field_border_width',
						'value' => '',
						'min' => 0,
						'max' => 10,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Input Field Border Width', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'input_field_border_radius',
						'value' => '',
						'min' => 0,
						'max' => 10,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Input Field Border Radius', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Input Field Border Color", "ALSP"),
					"param_name" => "input_field_border_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Input Field Label Color", "ALSP"),
					"param_name" => "input_field_label_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Input Field Placeholder Color", "ALSP"),
					"param_name" => "input_field_placeholder_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Input Field Text Color", "ALSP"),
					"param_name" => "input_field_text_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_button_border_width',
						'value' => '',
						'min' => 0,
						'max' => 10,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Submit Button Border Width', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_button_border_radius',
						'value' => '',
						'min' => 0,
						'max' => 10,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Submit Button Border Radius', 'ALSP'),
						'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Text Color", "ALSP"),
					"param_name" => "search_button_text_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Text Hover Color", "ALSP"),
					"param_name" => "search_button_text_color_hover",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Background Color", "ALSP"),
					"param_name" => "search_button_bg",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Background Hover Color", "ALSP"),
					"param_name" => "search_button_bg_hover",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Border Color", "ALSP"),
					"param_name" => "search_button_border_color",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Submit Button Border Hover Color", "ALSP"),
					"param_name" => "search_button_border_color_hover",
					"value" => "",
					"description" => '',
					'dependency' => array('element' => 'search_custom_style', 'value' => '1'),
				),
				array(
					'type' => 'textfield',
					'param_name' => 'search_button_icon',
					'value' => '',
					'heading' => esc_html__("Submit Button Icon Class", "ALSP"),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'search_form_type',
						'value' => array(__('Custom', 'ALSP') => '1'),
						'heading' => __('Form Type', 'ALSP'),
						'save_always' => true,
				),
			),
	));
	$vc_slider_args = array(
			'name'                    => __('Listings slider', 'ALSP'),
			'description'             => __('Listing listings in slider view', 'ALSP'),
			'base'                    => 'alsp-slider',
			'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
					array(
							'type' => 'textfield',
							'param_name' => 'slides',
							'value' => 3,
							'heading' => __('Maximum number of slides', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'max_width',
							'heading' => __('Maximum width of slider in pixels', 'ALSP'),
							'description' => __('Leave empty to make it auto width.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'height',
							'value' => 230,
							'heading' => __('Height of slider in pixels', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'slide_width',
							'value' => 330,
							'heading' => __('Maximum width of one slide in pixels', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'max_slides',
							'value' => array('2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
							'heading' => __('Maximum number of slides to be shown in carousel', 'ALSP'),
							'description' => __('Slides will be sized up if carousel becomes larger than the original size.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'auto_slides',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Enable automatic rotating slideshow', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'auto_slides_delay',
							'value' => 3000,
							'heading' => __('The delay in rotation (in ms)', 'ALSP'),
							'dependency' => array('element' => 'auto_slides', 'value' => '1'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'sticky_featured',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
							'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order_by_rand',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Order listings randomly?', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order_by',
							'value' => $ordering,
							'heading' => __('Order by', 'ALSP'),
							'description' => __('Order listings by any of these parameter.', 'ALSP'),
							'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order',
							'value' => array(__('Ascending', 'ALSP') => 'ASC', __('Descending', 'ALSP') => 'DESC'),
							'description' => __('Direction of sorting.', 'ALSP'),
							'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'address',
							'heading' => __('Address', 'ALSP'),
							'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'radius',
							'heading' => __('Radius', 'ALSP'),
							'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'author',
							'heading' => __('Author', 'ALSP'),
							'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_categories',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related categories.', 'ALSP'),
							'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
					),
					array(
							'type' => 'categoriesfield',
							'param_name' => 'categories',
							//'value' => 0,
							'heading' => __('Select certain categories', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_locations',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related locations.', 'ALSP'),
							'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
					),
					array(
							'type' => 'locationsfield',
							'param_name' => 'locations',
							//'value' => 0,
							'heading' => __('Select certain locations', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_tags',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related tags.', 'ALSP'),
							'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'include_categories_children',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Include children of selected categories and locations', 'ALSP'),
							'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
					),
					array(
							'type' => 'checkbox',
							'param_name' => 'levels',
							'value' => $levels,
							'heading' => __('Listings levels', 'ALSP'),
							'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'post__in',
							'heading' => __('Exact listings', 'ALSP'),
							'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
					),
			),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_slider_args['params'] = array_merge($vc_slider_args['params'], $field_params);
	}
	vc_map($vc_slider_args);
	
	vc_map( array(
		'name'                    => __('Front buttons', 'ALSP'),
		'description'             => __('Submit listing, my bookmarks, edit listing, print listing, ....', 'ALSP'),
		'base'                    => 'alsp-buttons',
		'icon'                    => ALSP_RESOURCES_URL . 'images/alsp.png',
		'show_settings_on_create' => false,
		'category'                => __('Listing Content', 'ALSP'),
	));

}

add_action('vc_load_default_templates_action', 'alsp_custom_templates_vc');
function alsp_custom_templates_vc() {
	$data               = array();
	$data['name']       = __('Listing custom homepage 1', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="2/3"][alsp-search columns="2"][alsp custom_home="1"][/vc_column][vc_column width="1/3"][alsp-categories parent="0" depth="1" columns="1" subcats="1" count="1" categories="0" custom_home="1" levels="0"][alsp-map custom_home="1" sticky_scroll="1" sticky_scroll_toppadding="25" height="100%"][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates($data);

	$data               = array();
	$data['name']       = __('Listing custom homepage 2', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="1/1"][alsp-search columns="2"][/vc_column][/vc_row][vc_row][vc_column width="1/2"][alsp-slider slides="10" height="350" slide_width="130" max_slides="4" sticky_featured="0" order_by="post_date" order="ASC" field_methods_of_payment="0" order_by_rand="0" auto_slides="1" auto_slides_delay="3000"][/vc_column][vc_column width="1/2"][alsp-map custom_home="1" height="500"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][alsp-buttons][alsp custom_home="1"][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates($data);
	
	$data               = array();
	$data['name']       = __('Listing custom homepage 3', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="1/2"][alsp-map custom_home="1" sticky_scroll="1" sticky_scroll_toppadding="20" height="100%"][/vc_column][vc_column width="1/2"][alsp custom_home="1"][/vc_column][/vc_row][vc_row el_class="scroller_bottom"][/vc_row]
CONTENT;

	vc_add_default_templates($data);
}

?>