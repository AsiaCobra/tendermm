<?php 

class alsp_listings_controller extends alsp_public_control {
	public $request_by = 'listings_controller';

	public function init($args = array()) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);
	
		if (get_query_var('page'))
			$paged = get_query_var('page');
		elseif (get_query_var('paged'))
			$paged = get_query_var('paged');
		else
			$paged = 1;
		
		$shortcode_atts = array_merge(array(
				'directories' => '',
				'perpage' => 10,
				'onepage' => 0,
				'listing_post_style' => 1,
				'sticky_featured' => 0,
				'order_by' => 'post_date',
				'order' => 'ASC',
/* 				'order_by' => (isset($_GET['order_by']) && $_GET['order_by'] ? $_GET['order_by'] : 'post_date'),
				'order' => (isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : 'ASC'), */
				'hide_order' => 0,
				'hide_count' => 0,
				'hide_paginator' => 0,
				'show_views_switcher' => 1,
				'listings_view_type' => 'list',
				'listings_view_grid_columns' =>  1,
				'grid_padding' => 15, //cz custom
				'masonry_layout' => 0, //cz custom
				'2col_responsive' => 0, //cz custom
				//'listing_thumb_width' => (int)get_option('alsp_listing_thumb_width'),
				'wrap_logo_list_view' => 0,
				'logo_animation_effect' => 6,
				'hide_content' => 0,
				'summary_on_logo_hover' => 0,
				'carousel' => 0,
				'carousel_show_slides' => 4,
				'carousel_slide_width' => 250,
				'carousel_slide_height' => 300,
				'carousel_full_width' => 0,
				'author' => 0,
				'paged' => $paged,
				'ajax_initial_load' => 0,
				'include_categories_children' => 0,
				'include_get_params' => 1,
				'categories' => '',
				'locations' => '',
				'related_directory' => 0,
				'related_categories' => 0,
				'related_locations' => 0,
				'related_tags' => 0,
				'scrolling_paginator' => 0,
				//'grid_view_logo_ratio' => get_option('alsp_grid_view_logo_ratio'), // 100 (1:1), 75 (4:3), 56.25 (16:9), 50 (2:1)
				'scroll' => 0, //cz custom
				'desktop_items' => '3' , //cz custom
				'tab_landscape_items' => '3' , //cz custom
				'tab_items' => '2' , //cz custom
				'autoplay' => 'false' , //cz custom
				'loop' => 'false' , //cz custom
				'owl_nav' => 'false' , //cz custom
				'delay' => '1000' , //cz custom
				'autoplay_speed' => '1000' , //cz custom
				'gutter' => '30' , //cz custom
				'listing_image_width' => 370,
				'listing_image_height' => 270,
				'listing_featured_tag_style' => '',
				'listing_order_by_txt' => '',
				'scroller_nav_style' => 2,
				'custom_category_link' => '',
				'custom_category_link_text' => '',
				'template' => 'views/alsp_adverts_wrapper.tpl.php',
				'uid' => null,
		), $args);
		$shortcode_atts = apply_filters('alsp_related_shortcode_args', $shortcode_atts, $args);
		
		$this->args = $shortcode_atts;
		if ($shortcode_atts['include_get_params']) {
			$get_params = $_GET;
			array_walk_recursive($get_params, 'sanitize_text_field');
			$this->args = array_merge($this->args, $get_params);
		}

		$base_url_args = apply_filters('alsp_base_url_args', array());
		if (isset($args['base_url']))
			$this->base_url = add_query_arg($base_url_args, $args['base_url']);
		else
			$this->base_url = add_query_arg($base_url_args, get_permalink());

		$this->template = $this->args['template'];
		
		//if ($this->args['carousel']) {
			//$this->template = 'views/listings_carousel.tpl.php';
		//}

		$args = array(
				'post_type' => ALSP_POST_TYPE,
				'post_status' => 'publish',
				//'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
				'posts_per_page' => $shortcode_atts['perpage'],
				'paged' => $paged,
		);
		
		if ($shortcode_atts['author'])
			$args['author'] = $shortcode_atts['author'];
		
		// render just one page - all found listings on one page
		if ($shortcode_atts['onepage'])
			$args['posts_per_page'] = -1;

		$args = array_merge($args, apply_filters('alsp_order_args', array(), $shortcode_atts, true));
		$args = apply_filters('alsp_search_args', $args, $this->args, $this->args['include_get_params'], $this->hash);

		if (!empty($this->args['post__in'])) {
			if (is_string($this->args['post__in'])) {
				$args = array_merge($args, array('post__in' => explode(',', $this->args['post__in'])));
			} elseif (is_array($this->args['post__in'])) {
				$args['post__in'] = $this->args['post__in'];
			}
		}
		if (!empty($this->args['post__not_in'])) {
			$args = array_merge($args, array('post__not_in' => explode(',', $this->args['post__not_in'])));
		}

		if (!$shortcode_atts['ajax_initial_load']) {
			if (!empty($this->args['directories'])) {
				if ($directories_ids = array_filter(explode(',', $this->args['directories']), 'trim')) {
					$args = alsp_set_directory_args($args, $directories_ids);
				}
			}

			if (isset($this->args['levels']) && !is_array($this->args['levels'])) {
				if ($levels = array_filter(explode(',', $this->args['levels']), 'trim')) {
					$this->levels_ids = $levels;
					add_filter('posts_where', array($this, 'where_levels_ids'));
				}
			}
	
			if (isset($this->args['levels']) || $this->args['sticky_featured']) {
				add_filter('posts_join', 'join_levels');
				if ($this->args['sticky_featured'])
					add_filter('posts_where', 'where_sticky_featured');
			}
			$this->query = new WP_Query($args);
			
			// adapted for Relevanssi
			if (alsp_is_relevanssi_search($shortcode_atts)) {
				$this->query->query_vars['s'] = alsp_getValue($shortcode_atts, 'what_search');
				$this->query->query_vars['posts_per_page'] = $shortcode_atts['perpage'];
				relevanssi_do_query($this->query);
			}
				
			//var_dump($this->query->request);
			$this->processQuery(false);

			if ($this->args['sticky_featured']) {
				remove_filter('posts_join', 'join_levels');
				remove_filter('posts_where', 'where_sticky_featured');
			}
	
			if ($this->levels_ids)
				remove_filter('posts_where', array($this, 'where_levels_ids'));
		} else {
			$this->do_initial_load = false;
		}
		
		apply_filters('alsp_listings_controller_construct', $this);
	}
}

?>