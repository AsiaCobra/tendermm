<?php

global $alsp_locations_widget_params;
$alsp_locations_widget_params = array(
		array(
				'type' => 'directory',
				'param_name' => 'directory',
				'heading' => __("Locations links will redirect to selected directory", "ALSP"),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'style',
				'value' => array(__('Style 1', 'ALSP') => '1', __('Style 2', 'ALSP') => '2'),
				'heading' => __('Style', 'ALSP'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'parent',
				'heading' => __('Parent location', 'ALSP'),
				'description' => __('ID of parent location (default 0 – this will build locations tree starting from the parent as root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('locations nesting level', 'ALSP'),
				'description' => __('The max depth of locations tree. When set to 1 – only root locations will be listed.', 'ALSP'),
			),
		array(
				'type' => 'textfield',
				'param_name' => 'sublocations',
				'heading' => __('Show sub-locations items number', 'ALSP'),
				'description' => __('This is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all sublocations ->" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show location listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current location.', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'hide_empty',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Hide empty locations?', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'icons',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show locations icons', 'ALSP'),
		),
		array(
				'type' => 'locationsfield',
				'param_name' => 'locations',
				'heading' => __('locations', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
		),
		array(
				'type' => 'checkbox',
				'param_name' => 'visibility',
				'heading' => __("Show only on directory pages", "ALSP"),
				'value' => 1,
				'description' => __("Otherwise it will load plugin's files on all pages.", "ALSP"),
		),
);

class alsp_locations_widget extends alsp_widget {

	public function __construct() {
		global $alsp_instance, $alsp_locations_widget_params;

		parent::__construct(
				'alsp_locations_widget',
				__('ALSP - Locations', 'ALSP')
		);

		$this->convertParams($alsp_locations_widget_params);
	}
	
	public function render_widget($instance, $args) {
		global $alsp_instance;
		
		// when visibility enabled - show only on directory pages
		if (empty($instance['visibility']) || !empty($alsp_instance->public_controls)) {
			$instance['menu'] = 0;
			$instance['columns'] = 1;
			
			$title = apply_filters('widget_title', $instance['title']);
	
			echo $args['before_widget'];
				if (!empty($title)) {
					echo $args['before_title'] . $title . $args['after_title'];
				}
				if ($instance['style'] == 1){
					echo '<div class="alsp-widget alsp-locations-widget clearfix">';
				}else{
					echo '<div class="alsp-widget alsp-locations-widget style2 clearfix">';	
				}
					$controller = new alsp_locations_controller();
					$controller->init($instance);
					echo $controller->display();
				echo '</div>';
			echo $args['after_widget'];
		}
	}
}
?>