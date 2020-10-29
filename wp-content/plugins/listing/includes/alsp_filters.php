<?php
// options filters

add_filter("alsp_map_type_option" , "alsp_map_type");
add_filter("alsp_mapbox_api_option" , "alsp_mapbox_api");
add_filter("alsp_mapbox_styles_option" , "alsp_mapbox_styles");

add_filter("alsp_listing_styles_option" , "alsp_listing_styles");
add_filter("alsp_listing_listview_styles_option" , "alsp_listing_listview_styles");
add_filter("alsp_listing_sorting_style_option" , "alsp_listing_sorting_styles");
add_filter("alsp_listing_single_style_option" , "alsp_listing_single_styles");
add_filter("alsp_pricing_plan_style_option" , "alsp_pricing_plan_styles");

// option filter callback functions

function alsp_map_type(){
	$value = array(
		'type' => 'select',
		'id' => 'alsp_map_type',
		'title' => __('Map Type', 'ALSP'),
		'options' => array(
		'google' => __('Google Map', 'ALSP'),
		),
		'default' => 'google',
	);
	return $value;
}

function alsp_mapbox_api(){
	$value = '';
	return $value;
}

function alsp_mapbox_styles(){
	$value = '';
	return $value;
}

function alsp_listing_styles(){
	$value = array(
				'type' => 'select',
				'id' => 'alsp_listing_post_style',
				'title' => __('Listing Style', 'ALSP'),
				'options' => array(
												
					'1' => __('style 1 Elca', 'ALSP'),

					'2' => __('style 2 Emo ', 'ALSP'),
												
					'3' => __('style 3 Lemo', 'ALSP'),
												
					'4' => __('style 4 Max', 'ALSP'),
												
					'5' => __('style 5 default', 'ALSP'),
												
					'6' => __('style 6 Exo', 'ALSP'),
												
					'7' => __('style 7 Exotic', 'ALSP'),
												
					'8' => __('style 8 Snow', 'ALSP'),
												
					'9' => __('style 9 Zee', 'ALSP'),
												
					'10' => __('style 10 Ultra', 'ALSP'),
												
					'11' => __('style 11 Mintox', 'ALSP'),
												
					'12' => __('style 12 Solic', 'ALSP'),
												
					'13' => __('style 13 Zoco', 'ALSP'),
					
					'14' => __('style 14 Fantro', 'ALSP'),
					
					'15' => __('style 15 Directory', 'ALSP'),
					
					'16' => __('style 16 ', 'ALSP'),
					
					'17' => __('style 17 ', 'ALSP'),

				),
				'default' => '10',
			);
	return $value;
}
function alsp_listing_listview_styles(){
	$value = array(
				'type' => 'select',
				'id' => 'alsp_listing_listview_post_style',
				'title' => __('Listing List View Style', 'ALSP'),
				'options' => array(
					'listview_default' => __('List View Style (Default)', 'ALSP'),
					'listview_ultra' => __('List View Style (Ultra)', 'ALSP'),
					'listview_mod' => __('List View Style (modern)', 'ALSP'),
				),
				'default' => 'listview_ultra',
			);
	return $value;
}

function alsp_listing_sorting_styles(){
	$value = array(
				'type' => 'select',
				'id' => 'view_switther_panel_style',
				'title' => __('View Switcher and Sorting Panel Style', 'ALSP'),
				'options' => array(
					'1' => __('style 1 Default', 'ALSP'),
					'2' => __('style 2 Fantro ', 'ALSP'),
					'3' => __('style 3 Zoco ', 'ALSP'),
				),
				'default' => '1',
			);
	return $value;
}
function alsp_listing_single_styles(){
	$value = array(
				'type' => 'select',
				'id' => 'alsp_single_listing_style',
				'title' => __('Single Listing Page Style', 'ALSP'),
				'options' => array(
					'1' => __('style 1 Default', 'ALSP'),
					'2' => __('style 2 Ultra ', 'ALSP'),
					'4' => __('style 3 ', 'ALSP'),
				),
				'default' => '2',
			);
	return $value;
}
function alsp_pricing_plan_styles(){
	$value = array(
				'type' => 'select',
				'id' => 'alsp_pricing_plan_style',
				'title' => __('Pricing Plan Style', 'ALSP'),
				'options' => array(
					'pplan-style-1' => __('style 1', 'ALSP'),
					'pplan-style-2' => __('style 2', 'ALSP'),
					'pplan-style-3' => __('style 3', 'ALSP'),
					'pplan-style-4' => __('style 4 Zoco', 'ALSP'),
				),
				'default' => 'pplan-style-3',
			);
	return $value;
}
// vc args

add_filter("alsp_listing_vc_settings_filter" , "alsp_listing_vc_settings");
add_filter("alsp_listing_featured_tags_vc_settings_filter" , "alsp_listing_featured_tags_vc_settings");
function alsp_listing_vc_settings(){
		
			$value = array(
					'type' => 'dropdown',
					'param_name' => 'listing_post_style',
					'value' => array(						
					__('style 1 Elca', 'ALSP') => '1',
					__('style 2 Emo ', 'ALSP') => '2',						
					__('style 3 Lemo', 'ALSP') => '3',						
					__('style 4 Max', 'ALSP') => '4',						
					__('style 5 default', 'ALSP') => '5',						
					__('style 6 Exo', 'ALSP') => '6',					
					__('style 7 Exotic', 'ALSP') => '7',					
					__('style 8 Snow', 'ALSP') => '8',						
					__('style 9 Zee', 'ALSP') => '9',						
					__('style 10 Ultra', 'ALSP') => '10',						
					__('style 11 Mintox', 'ALSP') => '11',						
					__('style 12 Solic', 'ALSP') => '12',					
					__('style 13 Zoco', 'ALSP') => '13',
					__('style 14 Fantro', 'ALSP') => '14',
					__('style 15 Directory', 'ALSP') => '15',
					__('style 16 ', 'ALSP') => '16',
					__('style 17 ', 'ALSP') => '17',

				),
					'heading' => __('Listing Style.', 'ALSP'),
			);
	
	return $value;
}
function alsp_listing_featured_tags_vc_settings(){
			$value = array(
					'type' => 'dropdown',
					'param_name' => 'listing_featured_tag_style',
					'value' => array(						
					__('style 1 Elca', 'ALSP') => '1',
					__('style 2 Emo ', 'ALSP') => '2',						
					__('style 3 Lemo', 'ALSP') => '3',						
					__('style 4 Max', 'ALSP') => '4',						
					__('style 5 default', 'ALSP') => '5',						
					__('style 6 Exo', 'ALSP') => '6',					
					__('style 7 Exotic', 'ALSP') => '7',					
					__('style 8 Snow', 'ALSP') => '8',						
					__('style 9 Zee', 'ALSP') => '9',						
					__('style 10 Ultra', 'ALSP') => '10',						
					__('style 11 Mintox', 'ALSP') => '11',						
					__('style 12 Solic', 'ALSP') => '12',					
					__('style 13 Zoco', 'ALSP') => '13',
					__('style 14 Fantro', 'ALSP') => '14',
					__('style 15', 'ALSP') => '15',
					__('style 16', 'ALSP') => '16',
					__('style 17', 'ALSP') => '17',

				),
					'heading' => __('Listing Feature Tag Style.', 'ALSP'),
			);
	
	return $value;
}


// widget

add_filter("alsp_listing_widget_settings_filter", "alsp_listing_widget_settings");
add_filter("alsp_listing_featured_tags_widget_settings_filter", "alsp_listing_featured_tags_widget_settings");
function alsp_listing_widget_settings(){
		
	$value = array(
				'type' => 'dropdown',
				'param_name' => 'listing_post_style',
				'value' => array(						
					__('style 1 Elca', 'ALSP') => '1',
					__('style 2 Emo ', 'ALSP') => '2',						
					__('style 3 Lemo', 'ALSP') => '3',						
					__('style 4 Max', 'ALSP') => '4',						
					__('style 5 default', 'ALSP') => '5',						
					__('style 6 Exo', 'ALSP') => '6',					
					__('style 7 Exotic', 'ALSP') => '7',					
					__('style 8 Snow', 'ALSP') => '8',						
					__('style 9 Zee', 'ALSP') => '9',						
					__('style 10 Ultra', 'ALSP') => '10',						
					__('style 11 Mintox', 'ALSP') => '11',						
					__('style 12 Solic', 'ALSP') => '12',					
					__('style 13 Zoco', 'ALSP') => '13',
					__('style 14 Fantro', 'ALSP') => '14',
					__('style 15 Directory', 'ALSP') => '15',
					__('style 16 ', 'ALSP') => '16',
					__('style 17 ', 'ALSP') => '17',

				),
				'heading' => __('Listing Style', 'ALSP'),
				'dependency' => array('element' => 'is_footer', 'value' => 0),
		);
	
	return $value;
}
function alsp_listing_featured_tags_widget_settings(){
	$value = array(
		'type' => 'dropdown',
		'param_name' => 'listing_featured_tag_style',
		'value' => array(						
			__('style 1 Elca', 'ALSP') => '1',
			__('style 2 Emo ', 'ALSP') => '2',						
			__('style 3 Lemo', 'ALSP') => '3',						
			__('style 4 Max', 'ALSP') => '4',						
			__('style 5 default', 'ALSP') => '5',						
			__('style 6 Exo', 'ALSP') => '6',					
			__('style 7 Exotic', 'ALSP') => '7',					
			__('style 8 Snow', 'ALSP') => '8',						
			__('style 9 Zee', 'ALSP') => '9',						
			__('style 10 Ultra', 'ALSP') => '10',						
			__('style 11 Mintox', 'ALSP') => '11',						
			__('style 12 Solic', 'ALSP') => '12',					
			__('style 13 Zoco', 'ALSP') => '13',
			__('style 14 Fantro', 'ALSP') => '14',

		),
		'heading' => __('Listing Feature Tag Style.', 'ALSP'),
	);
	
	return $value;
}