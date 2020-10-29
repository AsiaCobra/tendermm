<?php 

class alsp_categories_controller extends alsp_public_control {

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
				'categories' => array(),
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

		/*if ($this->args['custom_home']) {
			if ($alsp_instance->getShortcodeProperty('alsp-main', 'is_category')) {
				$category = $alsp_instance->getShortcodeProperty('alsp-main', 'category');
				$this->args['parent'] = $category->term_id;
			}

			$this->args['depth'] = alsp_getValue($args, 'depth', $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level']);
			$this->args['columns'] = alsp_getValue($args, 'columns', $ALSP_ADIMN_SETTINGS['alsp_categories_columns']);
			$this->args['count'] = alsp_getValue($args, 'count', $ALSP_ADIMN_SETTINGS['alsp_show_category_count']);
			$this->args['subcats'] = alsp_getValue($args, 'subcats', $ALSP_ADIMN_SETTINGS['alsp_subcategories_items']);
			$this->args['cat_style'] = alsp_getValue($args, 'cat_style', $ALSP_ADIMN_SETTINGS['alsp_categories_style']);
			$this->args['cat_icon_type'] = alsp_getValue($args, 'cat_icon_type');
			$this->args['scroll'] = alsp_getValue($args, 'scroll');
			$this->args['desktop_items'] = alsp_getValue($args, 'desktop_items');
			$this->args['tab_landscape_items'] = alsp_getValue($args, 'tab_landscape_items');
			$this->args['tab_items'] = alsp_getValue($args, 'tab_items');
			$this->args['autoplay'] = alsp_getValue($args, 'autoplay');
			$this->args['loop'] = alsp_getValue($args, 'loop');
			$this->args['owl_nav'] = alsp_getValue($args, 'owl_nav');
			$this->args['delay'] = alsp_getValue($args, 'delay');
			$this->args['autoplay_speed'] = alsp_getValue($args, 'autoplay_speed');
			$this->args['gutter'] = alsp_getValue($args, 'gutter');
			$this->args['cat_font_size'] = alsp_getValue($args, 'cat_font_size');
			$this->args['cat_font_weight'] = alsp_getValue($args, 'cat_font_weight');
			$this->args['cat_font_line_height'] = alsp_getValue($args, 'cat_font_line_height');
			$this->args['cat_font_transform'] = alsp_getValue($args, 'cat_font_transform');
			$this->args['child_cat_font_size'] = alsp_getValue($args, 'child_cat_font_size');
			$this->args['child_cat_font_weight'] = alsp_getValue($args, 'child_cat_font_weight');
			$this->args['child_cat_font_line_height'] = alsp_getValue($args, 'child_cat_font_line_height');
			$this->args['child_cat_font_transform'] = alsp_getValue($args, 'child_cat_font_transform');
			$this->args['parent_cat_title_color'] = alsp_getValue($args, 'parent_cat_title_color');
			$this->args['parent_cat_title_color_hover'] = alsp_getValue($args, 'parent_cat_title_color_hover');
			$this->args['parent_cat_title_bg'] = alsp_getValue($args, 'parent_cat_title_bg');
			$this->args['parent_cat_title_bg_hover'] = alsp_getValue($args, 'parent_cat_title_bg_hover');
			$this->args['subcategory_title_color'] = alsp_getValue($args, 'subcategory_title_color');
			$this->args['subcategory_title_color_hover'] = alsp_getValue($args, 'subcategory_title_color_hover');
			$this->args['cat_bg'] = alsp_getValue($args, 'cat_bg');
			$this->args['cat_bg_hover'] = alsp_getValue($args, 'cat_bg_hover');
			$this->args['cat_border_color'] = alsp_getValue($args, 'cat_border_color');
			$this->args['cat_border_color_hover'] = alsp_getValue($args, 'cat_border_color_hover');
		}*/
			
		/*$this->args['id'] = alsp_generateRandomVal();	
		if (isset($this->args['levels']) && !is_array($this->args['levels']))
			if ($levels = array_filter(explode(',', $this->args['levels']), 'trim'))
				$this->args['levels'] = $levels;

		if (isset($this->args['categories']) && !is_array($this->args['categories']))
			if ($categories = array_filter(explode(',', $this->args['categories']), 'trim'))
				$this->args['categories'] = $categories;

		apply_filters('alsp_public_control_construct', $this);*/
		
		if (isset($this->args['categories']) && !is_array($this->args['categories'])) {
			if ($categories = array_filter(explode(',', $this->args['categories']), 'trim')) {
				$this->args['categories'] = $categories;
			}
		}

		apply_filters('alsp_categories_controller_construct', $this);
		
	}

	public function display() {
		global $alsp_instance;
		$this->args['max_subterms'] = $this->args['subcats'];
		$this->args['exact_terms'] = $this->args['categories'];
		
		ob_start();
		
		$categories_view = new alsp_categories_view($this->args);
		$categories_view->display();

		$output = ob_get_clean();

		return $output;

	}
}

?>