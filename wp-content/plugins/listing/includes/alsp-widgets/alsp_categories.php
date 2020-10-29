<?php

global $alsp_categories_widget_params;
$alsp_categories_widget_params = array(
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
				'param_name' => 'style',
				'value' => array(__('Style 1', 'ALSP') => '1', __('Style 2', 'ALSP') => '2'),
				'heading' => __('Style', 'ALSP'),
		),
		array(
				'type' => 'textfield',
				'param_name' => 'parent',
				'heading' => __('Parent category', 'ALSP'),
				'description' => __('ID of parent category (default 0 – this will build categories tree starting from the parent as root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Categories nesting level', 'ALSP'),
				'description' => __('The max depth of categories tree. When set to 1 – only root categories will be listed.', 'ALSP'),
			),
		array(
				'type' => 'textfield',
				'param_name' => 'subcats',
				'heading' => __('Show subcategories items number', 'ALSP'),
				'description' => __('This is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all subcategories ->" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
		),
		/*array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4'),
				'std' => '2',
				'heading' => __('Categories columns number', 'ALSP'),
				'description' => __('Categories list is divided by columns.', 'ALSP'),
		),*/
		array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show category listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current category.', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'hide_empty',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Hide empty categories?', 'ALSP'),
		),
		/*array(
				'type' => 'dropdown',
				'param_name' => 'grid',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Enable grid view', 'ALSP'),
		),*/
		/*array(
				'type' => 'dropdown',
				'param_name' => 'grid_view',
				'value' => array(
						__('Standard', 'ALSP') => '0',
						__('Left Side Grid', 'ALSP') => '1',
						__('Right Side Grid', 'ALSP') => '2',
						__('Center Grid', 'ALSP') => '3',
				),
				'heading' => __('Grid view', 'ALSP'),
		),*/
		array(
				'type' => 'dropdown',
				'param_name' => 'icons',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show categories icons', 'ALSP'),
		),
		array(
				'type' => 'dropdown',
				'param_name' => 'cat_icon_type',
				'value' => array(__('Font Icons', 'ALSP') => '1', __('Image icons', 'ALSP') => '2', __('Svg icons', 'ALSP') => '3'),
				'heading' => __('Show categories icons', 'ALSP'),
		),
		array(
				'type' => 'categoriesfield',
				'param_name' => 'categories',
				'heading' => __('Categories', 'ALSP'),
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

class alsp_categories_widget extends alsp_widget {

	public function __construct() {
		global $alsp_instance, $alsp_categories_widget_params;

		parent::__construct(
				'alsp_categories_widget',
				__('ALSP - Categories', 'ALSP')
		);

		$this->convertParams($alsp_categories_widget_params);
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
					//echo $args['before_title'] . $title . $args['after_title'];
					if ($instance['style'] == 1){
						echo '<div class="alsp_category_widget_inner">'.$args['before_title'] . $title . $args['after_title'].'</div>';
					}else{
						echo '<div class="alsp_category_widget_inner style2">'.$args['before_title'] . $title . $args['after_title'].'</div>';
					}
				}
				echo '<div class="alsp-widget alsp-categories-widget">';
					if ($instance['style'] == 1){
						echo '<div class="alsp_category_widget_inner">';
					}else{
						echo '<div class="alsp_category_widget_inner style2">';
					}
						$controller = new alsp_categories_controller();
						$controller->init($instance);
						echo $controller->display();
					echo '</div>';
				echo '</div>';
			echo $args['after_widget'];
				
		}
	}
}
?>