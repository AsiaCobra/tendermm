<?php

global $alsp_search_widget_params;
$alsp_search_widget_params = array(
		array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
				//'description' => __('When set to Yes - the widget will follow some parameters from Directory Settings and not those listed here.', 'ALSP'),
		),
		array(
				'type' => 'directory',
				'param_name' => 'directory',
				'heading' => __("Search by directory", "ALSP"),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'uid',
				'heading' => __("uID", "ALSP"),
				'description' => __("Enter unique string to connect search form with another elements on the page.", "ALSP"),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('2', '1'),
				'std' => '2',
				'heading' => __('Number of columns to arrange search fields', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'advanced_open',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Advanced search panel always open', 'ALSP'),
		),
		array(
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
				'type' => 'colorpicker',
				'param_name' => 'search_bg_color',
				'heading' => __("Background color", "ALSP"),
				'value' => get_option('alsp_search_bg_color'),
		),
		array(
				'type' => 'colorpicker',
				'param_name' => 'search_text_color',
				'heading' => __("Text color", "ALSP"),
				'value' => get_option('alsp_search_text_color'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'search_bg_opacity',
				'heading' => __("Opacity of search form background, in %", "ALSP"),
				'value' => 100,
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'search_overlay',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show background overlay', 'ALSP'),
				'std' => get_option('alsp_search_overlay')
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
);

class alsp_search_widget extends alsp_widget {

	public function __construct() {
		global $alsp_instance, $alsp_search_widget_params;

		parent::__construct(
				'alsp_search_widget',
				__('Directory - Search', 'ALSP'),
				__( 'Search Form', 'ALSP')
		);

		foreach ($alsp_instance->search_fields->filter_fields_array AS $filter_field) {
			if (method_exists($filter_field, 'getVCParams') && ($field_params = $filter_field->getVCParams())) {
				$alsp_search_widget_params = array_merge($alsp_search_widget_params, $field_params);
			}
		}

		$this->convertParams($alsp_search_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $alsp_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($alsp_instance->public_controls)) {
			// when search_visibility enabled - show only when main search form wasn't displayed
			if (!empty($instance['search_visibility']) && !empty($alsp_instance->public_controls)) {
				foreach ($alsp_instance->public_controls AS $shortcode_controllers) {
					foreach ($shortcode_controllers AS $controller) {
						if (is_object($controller) && $controller->search_form) {
							return false;
						}
					}
				}
			}
				
			$title = apply_filters('widget_title', $instance['title']);
				
			// it is auto selection - take current directory
			if ($instance['directory'] == 0) {
				// probably we are on single listing page - it could be found only after frontend controllers were loaded, so we have to repeat setting
				$alsp_instance->setCurrentDirectory();
		
				$instance['directory'] = $alsp_instance->current_directory->id;
			}

			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="alsp-content alsp-widget alsp-search-widget">';
			$controller = new alsp_search_controller();
			$controller->init($instance);
			echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>