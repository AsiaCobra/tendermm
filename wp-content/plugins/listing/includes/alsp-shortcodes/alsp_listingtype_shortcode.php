<?php 

class alsp_listingtype_controller extends alsp_public_control {

	public function init($args = array()) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'directory' => 0,
				'parent' => 0,
				'depth' => 1,
				'columns' => 1,
				'count' => 1,
				'hide_empty' => 0,
				'subcats' => 0,
				'listingtypes' => array(),
				'grid' => 0,
				'grid_view' => 0, // 3 types of view
				'icons' => 1,
				'menu' => 0,
				'icon_type' => 'img',
				'levels' => array(),
				'cat_style' => 1,
				'cat_icon_type' => 1,
				'scroll' => 0, //cz custom
				'desktop_items' => 3, //cz custom
				'tab_landscape_items' => 3 , //cz custom
				'tab_items' => 2 , //cz custom
				'autoplay' => 'false' , //cz custom
				'loop' => 'false' , //cz custom
				'owl_nav' => 'false' , //cz custom
				'delay' => '1000' , //cz custom
				'autoplay_speed' => '1000' , //cz custom
				'gutter' => '30' , //cz custom
				'cat_font_size' => '' , //cz custom
				'cat_font_weight' => '' , //cz custom
				'cat_font_line_height' => '' , //cz custom
				'cat_font_transform' => '' , //cz custom
				'child_cat_font_size' => '' , //cz custom
				'child_cat_font_weight' => '' , //cz custom
				'child_cat_font_line_height' => '' , //cz custom
				'child_cat_font_transform' => '' , //cz custom
				'parent_cat_title_color' => '' , //cz custom
				'parent_cat_title_color_hover' => '' , //cz custom
				'parent_cat_title_bg' => '' , //cz custom
				'parent_cat_title_bg_hover' => '' , //cz custom
				'subcategory_title_color' => '' , //cz custom
				'subcategory_title_color_hover' => '' , //cz custom
				'cat_bg' => '' , //cz custom
				'cat_bg_hover' => '' , //cz custom
				'cat_border_color' => '' , //cz custom
				'cat_border_color_hover' => '' , //cz custom
				
		), $args);
		$this->args = $shortcode_atts;
		
		if (isset($this->args['listingtypes']) && !is_array($this->args['listingtypes'])) {
			if ($listingtypes = array_filter(explode(',', $this->args['listingtypes']), 'trim')) {
				$this->args['listingtypes'] = $listingtypes;
			}
		}

		apply_filters('alsp_listingtype_controller_construct', $this);
		
	}

	public function display() {
		global $alsp_instance;
		$this->args['max_subterms'] = $this->args['subcats'];
		$this->args['exact_terms'] = $this->args['listingtypes'];
		
		ob_start();
		
		$listingtypes_view = new alsp_listingtypes_view($this->args);
		$listingtypes_view->display();

		$output = ob_get_clean();

		return $output;

	}
}

?>