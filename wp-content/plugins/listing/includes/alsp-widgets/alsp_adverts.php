<?php

global $alsp_listings_widget_params;
$alsp_listings_widget_params = array(
		array(
				'type' => 'checkbox',
				'param_name' => 'is_footer',
				'heading' => __("Check if its Footer Widget area", "ALSP"),
				'value' => 0,
				'description' => __("Otherwise Listing style will be disturded", "ALSP"),
		),
		array(
				'type' => 'directories',
				'param_name' => 'directories',
				'heading' => __("Listings of these directories", "ALSP"),
		),
		apply_filters("alsp_listing_widget_settings_filter", "alsp_listing_widget_settings"),
		array(
				'type' => 'textfield',
				'param_name' => 'listings_grid_columns',
				'value' => 3,
				'heading' => __('Listing Grid Columns', 'ALSP'),
				'description' => __('works only when widget is in footer.', 'ALSP'),
				'dependency' => array('element' => 'is_footer', 'value' => '1'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'number_of_listings',
				'value' => 6,
				'heading' => __('Number of listings', 'ALSP'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'width',
				'value' => 370,
				'heading' => __('Listing Thumbnail Width', 'ALSP'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'height',
				'value' => 250,
				'heading' => __('Listing Thumbnail Height', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'only_sticky_featured',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
				'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
		),
		array(
				'type' => 'ordering',
				'param_name' => 'order_by',
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
				'param_name' => 'hide_content',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Hide content fields data', 'ALSP'),
				'std' => '1',
		),
		array(
				'type' => 'textfield',
				'param_name' => 'address',
				'heading' => __('Address', 'ALSP'),
				'description' => __('Display listings near this address, recommended to set default radius', 'ALSP'),
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
				'type' => 'level',
				'param_name' => 'levels',
				'heading' => __('Listings levels', 'ALSP'),
				'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
		),
		/* array(
				'type' => 'textfield',
				'param_name' => 'post__in',
				'heading' => __('Exact listings', 'ALSP'),
				'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
		), */
		array(
				'type' => 'dropdown',
				'param_name' => 'is_slider_view',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Turn On/Off Slider', 'ALSP'),
				'dependency' => array('element' => 'is_footer', 'value' => '0'),
		),
		array(
				'type' => 'checkbox',
				'param_name' => 'autoplay',
				'heading' => __("Autoplay ", "ALSP"),
				'value' => 1,
				'description' => __("Turn autoplay on or off", "ALSP"),
				'dependency' => array('element' => 'is_slider_view', 'value' => '1'),
		),
		array(
				'type' => 'checkbox',
				'param_name' => 'loop',
				'heading' => __("Slider Loop ", "ALSP"),
				'value' => 1,
				'description' => __("Turn loop on or off", "ALSP"),
				'dependency' => array('element' => 'is_slider_view', 'value' => '1'),
		),
		array(
				'type' => 'checkbox',
				'param_name' => 'owl_nav',
				'heading' => __("Slider Navigation ", "ALSP"),
				'value' => 1,
				'description' => __("Turn Navigation on or off", "ALSP"),
				'dependency' => array('element' => 'is_slider_view', 'value' => '1'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'delay',
				'heading' => __("Slider Animation Delay ", "ALSP"),
				'value' => 1000,
				'dependency' => array('element' => 'is_slider_view', 'value' => '1'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'autoplay_speed',
				'heading' => __("Slider autoplay speed ", "ALSP"),
				'value' => 1000,
				'dependency' => array('element' => 'is_slider_view', 'value' => '1'),
		),
		array(
				'type' => 'checkbox',
				'param_name' => 'visibility',
				'heading' => __("Show only on directory pages", "ALSP"),
				'value' => 1,
				'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
		),
);

class alsp_listings_widget extends alsp_widget {

	public function __construct() {
		global $alsp_instance, $alsp_listings_widget_params;

		parent::__construct(
				'alsp_listings_widget', // name for backward compatibility
				__('ALSP - Listings', 'ALSP')
		);

		//foreach ($alsp_instance->search_fields->filter_fields_array AS $filter_field) {
			//if (method_exists($filter_field, 'getVCParams') && ($field_params = $filter_field->getVCParams())) {
				//$alsp_listings_widget_params = array_merge($alsp_listings_widget_params, $field_params);
			//}
		//}

		$this->convertParams($alsp_listings_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS; 
		require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
		
			$instance['hide_paginator'] = 1;
			$instance['perpage'] = $instance['number_of_listings'];
			$instance['sticky_featured'] = $instance['only_sticky_featured'];
			$instance['hide_count'] = 1;
			$instance['hide_order'] = 1;
			$instance['show_views_switcher'] = 0;
			$instance['listings_view_type'] = 'grid';
			$instance['include_get_params'] = 0;
			$instance['listing_image_width'] = 	(isset($instance['width']) && !empty($instance['width']))? $instance['width']:'';
			$instance['listing_image_height'] = (isset($instance['height']) && !empty($instance['height']))? $instance['height']:'';
			$instance['desktop_items'] = 1;
			$instance['tab_landscape_items'] = 1;
			$instance['tab_items'] = 1;
			$instance['gutter'] = 0 ; //cz custom
			$instance['masonry_layout'] = 0;
			$instance['2col_responsive'] = 0;
			$in_footer = (isset($instance['is_footer']))? $instance['is_footer']: 0;
			if($in_footer){
				$instance['listing_post_style'] = 'footer_widget' ;
				$instance['listings_view_grid_columns'] = $instance['listings_grid_columns'] ;
				$instance['grid_padding'] = 3; //cz custom
				$instance['scroll'] = 0;
			}else{
				$instance['listing_post_style'] = (isset($instance['listing_post_style']) && !empty($instance['listing_post_style']))? $instance['listing_post_style']: 16;	
				$instance['listings_view_grid_columns'] = 1;
				$instance['scroll'] = (isset($instance['is_slider_view']) && !empty($instance['is_slider_view']))? $instance['is_slider_view']: 0;
				$instance['grid_padding'] = 0; //cz custom
			}
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($alsp_instance->public_controls)) {
			
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class=" alsp-widget alsp_recent_listings_widget">';
					$controller = new alsp_listings_controller();
					$controller->init($instance);
					echo $controller->display();
			echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>