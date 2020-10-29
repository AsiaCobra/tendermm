<?php 
// check keyword [needs workaround]
class alsp_ajax_controller {

	public function __construct() {
		add_action('wp_ajax_alsp_get_map_markers', array($this, 'get_map_markers'));
		add_action('wp_ajax_nopriv_alsp_get_map_markers', array($this, 'get_map_markers'));

		add_action('wp_ajax_alsp_get_map_marker_info', array($this, 'get_map_marker_info'));
		add_action('wp_ajax_nopriv_alsp_get_map_marker_info', array($this, 'get_map_marker_info'));

		add_action('wp_ajax_alsp_get_sharing_buttons', array($this, 'get_sharing_buttons'));
		add_action('wp_ajax_nopriv_alsp_get_sharing_buttons', array($this, 'get_sharing_buttons'));

		add_action('wp_ajax_alsp_controller_request', array($this, 'controller_request'));
		add_action('wp_ajax_nopriv_alsp_controller_request', array($this, 'controller_request'));

		add_action('wp_ajax_alsp_search_by_poly', array($this, 'search_by_poly'));
		add_action('wp_ajax_nopriv_alsp_search_by_poly', array($this, 'search_by_poly'));
		
		add_action('wp_ajax_alsp_select_field_icon', array($this, 'select_field_icon'));
		add_action('wp_ajax_nopriv_alsp_select_field_icon', array($this, 'select_field_icon'));
		
		add_action('wp_ajax_alsp_contact_form', array($this, 'contact_form'));
		add_action('wp_ajax_nopriv_alsp_contact_form', array($this, 'contact_form'));

		add_action('wp_ajax_alsp_keywords_search', array($this, 'keywords_search'));
		add_action('wp_ajax_nopriv_alsp_keywords_search', array($this, 'keywords_search'));
	}

	public function controller_request() {
		global $ALSP_ADIMN_SETTINGS, $alsp_instance;
		
		$alsp_instance->setCurrentDirectory();

		$post_args = $_POST;

		switch ($post_args['controller']) {
			case "directory_controller":
			case "listings_controller":
				if ($post_args['controller'] == "directory_controller")
					$shortcode_atts = array_merge(array(
							'perpage' => (isset($post_args['is_home']) && $post_args['is_home']) ? $ALSP_ADIMN_SETTINGS['alsp_listings_number_index'] : $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
							'onepage' => 0,
							'map_markers_is_limit' => $ALSP_ADIMN_SETTINGS['alsp_map_markers_is_limit'],
							'sticky_featured' => 0,
							'order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'],
							'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order'],
							'hide_order' => (int)(!($ALSP_ADIMN_SETTINGS['alsp_show_orderby_links'])),
							'hide_count' => 0,
							'hide_paginator' => 0,
							'show_views_switcher' => (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher'],
							'listings_view_type' =>'',
							'listings_view_grid_columns' => (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher_grid_columns'],
							'grid_padding' => (int)$ALSP_ADIMN_SETTINGS['alsp_grid_padding'],
							//'listing_thumb_width' => (int)get_option('alsp_listing_thumb_width'),
							//'wrap_logo_list_view' => (int)get_option('alsp_wrap_logo_list_view'),
							'logo_animation_effect' => 6,
							//'hide_content' => 0,
							'summary_on_logo_hover' => 0,
							'listing_post_style' => 3,
							'author' => 0,
							'paged' => 1,
							'include_categories_children' => 1,
							'include_get_params' => 1,
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
							'scroller_nav_style' => 2,
							'template' => 'views/alsp_adverts_wrapper.tpl.php',
					), $post_args);
				else
					$shortcode_atts = array_merge(array(
							'perpage' => 10,
							'onepage' => 0,
							'sticky_featured' => 0,
							'order_by' => 'post_date',
							'order' => 'DESC',
							'hide_order' => 0,
							'hide_count' => 0,
							'hide_paginator' => 0,
							'show_views_switcher' => 1,
							'listings_view_type' => '',
							'listings_view_grid_columns' => 2,
							'grid_padding' => 15, //cz custom
							//'listing_thumb_width' => 300,
							//'wrap_logo_list_view' => 0,
							'logo_animation_effect' => 6,
							'listing_post_style' => 3,
							'hide_content' => 0,
							'summary_on_logo_hover' => 0,
							'author' => 0,
							'paged' => 1,
							'include_categories_children' => 0,
							'include_get_params' => 1,
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
							'scroller_nav_style' => 2,
							'template' => array('views/alsp_adverts_wrapper.tpl.php'),
					), $post_args);

					$address = false;
				$radius = false;
				if (isset($post_args['address'])) {
					$address = apply_filters('alsp_search_param_address', $post_args['address']);
				}
				if (isset($post_args['radius'])) {
					$radius = apply_filters('alsp_search_param_radius', $post_args['radius']);
				}
					
				// This is required workaround
				if (isset($post_args['order_by'])) {
					$_REQUEST['order_by'] = alsp_getValue($post_args, 'order_by', $shortcode_atts['order_by']);
					$_REQUEST['order'] = alsp_getValue($post_args, 'order', $shortcode_atts['order']);
				} elseif ($address && $radius) {
					// When search by radius - order by distance by default instead of ordering by date
					$shortcode_atts['order_by'] = 'distance';
					$shortcode_atts['order'] = 'ASC';
				}

				// Strongly required for paginator
				set_query_var('page', $shortcode_atts['paged']);

				$controller = new alsp_public_control();
				$controller->init($post_args);
				$controller->hash = $post_args['hash'];
				$controller->args = $shortcode_atts;
				$controller->request_by = 'listings_controller';
				$controller->custom_home = (isset($shortcode_atts['custom_home']) && $shortcode_atts['custom_home']);

				//$default_orderby_args = array('order_by' => $shortcode_atts['order_by'], 'order' => $shortcode_atts['order']);
				$order_args = apply_filters('alsp_order_args', array(), $shortcode_atts, false);
				
				// while random sorting and we have to exclude already shown listings - do not limit records, we will take needed later
				if (isset($shortcode_atts['existing_listings']) && $order_args['orderby'] == 'rand') {
					$perpage = -1;
				} else {
					$perpage = $shortcode_atts['perpage'];
				}
				
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						//'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
						'posts_per_page' => $perpage,
						'paged' => $shortcode_atts['paged'],
				);
				if ($shortcode_atts['author'])
					$args['author'] = $shortcode_atts['author'];
				// render just one page
				if ($shortcode_atts['onepage'])
					$args['posts_per_page'] = -1;

				$args = array_merge($args, $order_args);
				$args = apply_filters('alsp_search_args', $args, $shortcode_atts, $shortcode_atts['include_get_params'], $controller->hash);
				if (!empty($shortcode_atts['post__in'])) {
					if (is_string($shortcode_atts['post__in'])) {
						$args = array_merge($args, array('post__in' => explode(',', $shortcode_atts['post__in'])));
					} elseif (is_array($shortcode_atts['post__in'])) {
						$args['post__in'] = $shortcode_atts['post__in'];
					}
				}
				if (!empty($shortcode_atts['post__not_in'])) {
					$args = array_merge($args, array('post__not_in' => explode(',', $shortcode_atts['post__not_in'])));
				}
				
				if (!empty($shortcode_atts['levels']) && !is_array($shortcode_atts['levels'])) {
					if ($levels = array_filter(explode(',', $shortcode_atts['levels']), 'trim')) {
						$controller->levels_ids = $levels;
						add_filter('posts_where', array($controller, 'where_levels_ids'));
					}
				}
				
				if (!empty($shortcode_atts['levels']) || $shortcode_atts['sticky_featured']) {
					add_filter('posts_join', 'join_levels');
					if ($shortcode_atts['sticky_featured'])
						add_filter('posts_where', 'where_sticky_featured');
				}
				// needs workaround
				if (!empty($shortcode_atts['directories']) && !empty($shortcode_atts['directories'])) {
					if ($directories_ids = array_filter(explode(',', $shortcode_atts['directories']), 'trim')) {
						$args = alsp_set_directory_args($args, $directories_ids);
					}
				} elseif (!empty($shortcode_atts['directories']) && $post_args['controller'] == 'directory_controller') {
					$args = alsp_set_directory_args($args, array($alsp_instance->current_directory->id));
				}
				
				$args = apply_filters('alsp_directory_query_args', $args);
					
				// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
				global $wp_filter;
				if (isset($wp_filter['pre_get_posts'])) {
					$pre_get_posts = $wp_filter['pre_get_posts'];
					unset($wp_filter['pre_get_posts']);
				}
				$controller->query = new WP_Query($args);
				//var_dump($controller->query->request);
				
				// adapted for Relevanssi
				if (alsp_is_relevanssi_search($shortcode_atts)) {
					$controller->query->query_vars['s'] = alsp_getValue($shortcode_atts, 'what_search');
					$controller->query->query_vars['posts_per_page'] = $perpage;
					relevanssi_do_query($controller->query);
				}
				//var_dump($controller->query->request);
				
				// while random sorting - we have to exclude already shown listings, we are taking only needed
				if (isset($shortcode_atts['existing_listings']) && $order_args['orderby'] == 'rand') {
					$all_posts_count = count($controller->query->posts);
					$existing_listings = array_filter(explode(',', $shortcode_atts['existing_listings']));
					foreach ($controller->query->posts AS $key=>$post) {
						if (in_array($post->ID, $existing_listings)) {
							unset($controller->query->posts[$key]);
						}
					}
					$controller->query->posts = array_values($controller->query->posts);
					$controller->query->posts = array_slice($controller->query->posts, 0, $shortcode_atts['perpage']);

					$controller->query->post_count = count($controller->query->posts);
					$controller->query->found_posts = $all_posts_count;
					$controller->query->max_num_pages = ceil($all_posts_count/$shortcode_atts['perpage']);
				}
				
				if (!empty($post_args['with_map']) || !empty($post_args['map_listings']))
					$load_map_markers = true;
				else
					$load_map_markers = false;

				$map_args = array();
				if (!empty($post_args['map_markers_is_limit']))
					$map_args['map_markers_is_limit'] = true;
				else
					$map_args['map_markers_is_limit'] = false;

				$controller->processQuery($load_map_markers, $map_args);
				if (isset($pre_get_posts))
					$wp_filter['pre_get_posts'] = $pre_get_posts;

				$base_url_args = apply_filters('alsp_base_url_args', array());
				if (!empty($post_args['base_url']))
					$controller->base_url = add_query_arg($base_url_args, $post_args['base_url']);
				else 
					$controller->base_url = alsp_directoryUrl($base_url_args);
				
				global $alsp_global_base_url;
				$alsp_global_base_url = $controller->base_url;
				add_filter('get_pagenum_link', array($this, 'get_pagenum_link'));
				// some stylings vars
				$listing_post_styles = $post_args['listing_post_style'];
				
				if(($controller->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$controller->hash]) && $_COOKIE['alsp_listings_view_'.$controller->hash] == 'grid')){
					$listing_style_to_show = 'show_grid_style';
				}elseif(($controller->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$controller->hash]) && $_COOKIE['alsp_listings_view_'.$controller->hash] == 'list')){
					$listing_style_to_show = 'show_list_style';
				}elseif(($controller->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$controller->hash]) && $_COOKIE['alsp_listings_view_'.$controller->hash] == 'list')){
					$listing_style_to_show = 'show_list_style';
				}elseif(($controller->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$controller->hash]) && $_COOKIE['alsp_listings_view_'.$controller->hash] == 'grid')){
					$listing_style_to_show = 'show_grid_style';
				}elseif($controller->args['listings_view_type'] == 'grid'){
					$listing_style_to_show = 'show_grid_style';
				}else{
					$listing_style_to_show = 'show_grid_style';
				}
				 if($listing_style_to_show == 'show_grid_style'){
					if(isset($listing_post_styles) && !empty($listing_post_styles)) {
						$listing_style = $listing_post_styles;
					}else{
						$listing_style = '';
					}
					//$grid_padding = $ALSP_ADIMN_SETTINGS['alsp_grid_padding'];
					$grid_padding = $controller->args['grid_padding'];
				 }else{
					 $listing_style = $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'];
					 $grid_padding = 0;
				 }
				  if($ALSP_ADIMN_SETTINGS['alsp_listing_responsive_grid']){
					$alsp_responsive_col = 'responsive-2col';
				 }else{
					$alsp_responsive_col = '';
				 }
				 if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display'] && $listing_style_to_show == 'show_grid_style'){
					$masonry = 'masonry';
					$isotope_el_class = 'isotop-enabled pacz-theme-loop ';
				}else{
					$masonry = '';
					$isotope_el_class = '';
				}
				$alsp_grid_margin_bottom = $ALSP_ADIMN_SETTINGS['alsp_grid_margin_bottom'];
				
				$listings_html = '';
				if (!isset($post_args['without_listings']) || !$post_args['without_listings']) {
					if (isset($post_args['do_append']) && $post_args['do_append']) {
						if ($controller->listings)
							while ($controller->query->have_posts()) {
								$controller->query->the_post(); 
								
								$listings_html .= '<article id="post-' . get_the_ID() . '" class="row alsp-listing '.$alsp_responsive_col.' listing-post-style-'.$listing_style.' pacz-isotop-item isotop-item masonry-'.$controller->hash.'   clearfix isotope-item ' . (($controller->listings[get_the_ID()]->level->featured) ? 'alsp-featured' : '') . ' ' . (($controller->listings[get_the_ID()]->level->sticky) ? 'alsp-sticky' : '') . '" style="padding-left:'.$grid_padding.'px; padding-right:'.$grid_padding.'px; margin-bottom:'.$alsp_grid_margin_bottom.'px;" >';
								$listings_html .= '<div class="listing-wrapper clearfix">';
								//$listings_html .= $listing_style_to_show;
								//$listings_html .= $controller->listings[get_the_ID()]->display(false, true);
								$listings_html .= $controller->listings[get_the_ID()]->display($controller, false, true);
								$listings_html .= '</div>';
								$listings_html .= '</article>';
							}
						unset($controller->args['do_append']);
					} else
						$listings_html = alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $controller), true);
				}
				wp_reset_postdata();
				
				$out = array(
						'html' => $listings_html,
						'hash' => $controller->hash,
						'map_markers' => ((!empty($post_args['with_map']) && $controller->map) ? $controller->map->locations_option_array : ''),
						'map_listings' => ((!empty($post_args['map_listings']) && $controller->map) ? $controller->map->buildListingsContent() : ''),
						'hide_show_more_listings_button' => ($shortcode_atts['paged'] >= $controller->query->max_num_pages) ? 1 : 0,
				);
				
				if (isset($alsp_instance->radius_values_array[$controller->hash]) && isset($alsp_instance->radius_values_array[$controller->hash]['x_coord']) && isset($alsp_instance->radius_values_array[$controller->hash]['y_coord'])) {
					$out['radius_params'] = array(
							'radius_value' => $alsp_instance->radius_values_array[$controller->hash]['radius'],
							'map_coords_1' => $alsp_instance->radius_values_array[$controller->hash]['x_coord'],
							'map_coords_2' => $alsp_instance->radius_values_array[$controller->hash]['y_coord'],
							'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
					);
				}
				
				echo json_encode($out);

				break;
		}
		
		die();
	}

	public function get_pagenum_link($result) {
		global $alsp_global_base_url;

		if ($alsp_global_base_url) {
			preg_match('/paged=(.?)/', $result, $matches);
			if (isset($matches[1])) {
				global $wp_rewrite;
				if ($wp_rewrite->using_permalinks()) {
					$parsed_url = parse_url($alsp_global_base_url);
					$query_args = (isset($parsed_url['query'])) ? wp_parse_args($parsed_url['query']) : array();
					$query_args = array_map('urlencode', $query_args);
					$url_without_get = ($pos_get = strpos($alsp_global_base_url, '?')) ? substr($alsp_global_base_url, 0, $pos_get) : $alsp_global_base_url;
					return esc_url(add_query_arg($query_args, trailingslashit(trailingslashit($url_without_get) . 'page/' . $matches[1])));
				} else
					return add_query_arg('page', $matches[1], $alsp_global_base_url);
			} else 
				return $alsp_global_base_url;
		}
		return $result;
	}

	public function get_map_markers() {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		// needs workaround
		$alsp_instance->setCurrentDirectory();

		$post_args = $_POST;
		$hash = $post_args['hash'];

		$map_markers = array();
		$map_listings = '';
		if (isset($post_args['neLat']) && isset($post_args['neLng']) && isset($post_args['swLat']) && isset($post_args['swLng'])) {
			// needed to unset 'ajax_loading' parameter when it is calling by AJAX, then $args will be passed to map controller
			if (isset($post_args['ajax_loading'])) {
				unset($post_args['ajax_loading']);
			}
			
			$address = false;
			$radius = false;
			if (isset($post_args['address'])) {
				$address = apply_filters('alsp_search_param_address', $post_args['address']);
			}
			if (isset($post_args['radius'])) {
				$radius = apply_filters('alsp_search_param_radius', $post_args['radius']);
			}
			
			if ($radius && $address) {
				// When search by radius - order by distance by default instead of ordering by date
				$post_args['order_by'] = 'distance';
				$post_args['order'] = 'ASC';
			}
			// needs workaround
			if (!isset($post_args['directories'])) {
				$post_args['directories'] = $alsp_instance->current_directory->id;
			}
			
			$post_args['custom_home'] = 0;

			$map_controller = new alsp_map_controller();
			$map_controller->hash = $hash;
			$map_controller->init($post_args);
			wp_reset_postdata();
			
			$map_markers = $map_controller->map->locations_option_array;
			if (!empty($post_args['map_listings'])) {
				$map_listings = $map_controller->map->buildListingsContent();
			}
		}
			
		$listings_html = '';
		if ((!isset($post_args['without_listings']) || !$post_args['without_listings'])) {
			$shortcode_atts = array_merge(array(
					'perpage' => 10,
					'onepage' => 0,
					'sticky_featured' => 0,
					'order_by' => 'post_date',
					'order' => 'DESC',
					'hide_order' => 0,
					'hide_count' => 0,
					'hide_paginator' => 0,
					'show_views_switcher' => 1,
					'listings_view_type' => 'list',
					'listings_view_grid_columns' => 2,
					//'listing_thumb_width' => 300,
					//'wrap_logo_list_view' => 0,
					//'logo_animation_effect' => 1,
					'listing_post_style' => 13,
					'author' => 0,
					'paged' => 1,
					'ajax_initial_load' => 0,
					'scroll' => 0,
					'scroller_nav_style' => 2,
					'template' => 'views/alsp_adverts_wrapper.tpl.php',
			), $post_args);

			$post_ids = array();
			if (isset($map_controller->map->locations_array) && $map_controller->map->locations_array) {
				foreach ($map_controller->map->locations_array AS $location)
					$post_ids[] = $location->post_id;
				$shortcode_atts['post__in'] = $post_ids;
			} else {
				$shortcode_atts['post__in'] = array(0);
			}
			// needs workaround
			if (!isset($post_args['directories'])) {
				$shortcode_atts['directories'] = $alsp_instance->current_directory->id;
			}

			$listings_controller = new alsp_listings_controller();
			$listings_controller->init($shortcode_atts);
			$listings_controller->hash = $hash;
			
			$base_url_args = apply_filters('alsp_base_url_args', array());
			if (isset($post_args['base_url']) && $post_args['base_url'])
				$listings_controller->base_url = add_query_arg($base_url_args, $post_args['base_url']);
			else
				$listings_controller->base_url = alsp_directoryUrl($base_url_args);

			$listings_html = alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $listings_controller), true);
			wp_reset_postdata();
		}

		$out = array(
				'html' => $listings_html,
				'hash' => $hash,
				'map_markers' => $map_markers,
				'map_listings' => $map_listings,
		);

		if (isset($alsp_instance->radius_values_array[$hash]) && isset($alsp_instance->radius_values_array[$hash]['x_coord']) && isset($alsp_instance->radius_values_array[$hash]['y_coord'])) {
			$out['radius_params'] = array(
					'radius_value' => $alsp_instance->radius_values_array[$hash]['radius'],
					'map_coords_1' => $alsp_instance->radius_values_array[$hash]['x_coord'],
					'map_coords_2' => $alsp_instance->radius_values_array[$hash]['y_coord'],
					'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
			);
		}
			
		echo json_encode($out);

		die();
	}
	
	public function search_by_poly() {
		global $alsp_instance;
		
		$post_args = $_POST;
		$hash = $post_args['hash'];
		
		$out = array(
				'hash' => $hash
		);

		$map_markers = array();
		$map_listings = '';
		if (isset($post_args['geo_poly']) && $post_args['geo_poly']) {
			$map_controller = new alsp_map_controller();
			$map_controller->hash = $hash;
			// Here we need to remove any location-based parameters, leave only content-based (like categories, content fields, ....)
			$post_args['ajax_loading'] = 0; // ajax loading always OFF
			$post_args['ajax_markers_loading'] = 0; // ajax infowindow always OFF
			$post_args['radius'] = 0; // this is not the case for radius search
			$post_args['address'] = ''; // this is not the case for address search
			$post_args['location_id'] = 0; // this is not the case for search by location ID
			$post_args['locations'] = ''; // this is not the case for search by locations
			$post_args['custom_home'] = 0;
			// needs workaround
			if (!isset($post_args['directories'])) {
				$post_args['directories'] = $alsp_instance->current_directory->id;
			}
			$map_controller->init($post_args);
			wp_reset_postdata();

			$map_markers = $map_controller->map->locations_option_array;
			if (!empty($post_args['map_listings'])) {
				$map_listings = $map_controller->map->buildListingsContent();
			}
		}
		
		$listings_html = '';
		if ((!isset($post_args['without_listings']) || !$post_args['without_listings'])) {
			$shortcode_atts = array_merge(array(
					'perpage' => 10,
					'onepage' => 0,
					'sticky_featured' => 0,
					'order_by' => 'post_date',
					'order' => 'DESC',
					'hide_order' => 0,
					'hide_count' => 0,
					'hide_paginator' => 0,
					'show_views_switcher' => 1,
					'listings_view_type' => 'list',
					'listings_view_grid_columns' => 2,
					//'listing_thumb_width' => 300,
					//'wrap_logo_list_view' => 0,
					//'logo_animation_effect' => 1,
					'author' => 0,
					'paged' => 1,
					'ajax_initial_load' => 0,
					'scroll' => 0,
					'scroller_nav_style' => 2,
					'template' => 'views/alsp_adverts_wrapper.tpl.php',
			), $post_args);

			if (isset($map_controller->map->locations_array) && $map_controller->map->locations_array) {
				$post_ids = array();
				foreach ($map_controller->map->locations_array AS $location)
					$post_ids[] = $location->post_id;
				$shortcode_atts['post__in'] = $post_ids;
			} else {
				$shortcode_atts['post__in'] = 0;
			}
			// needs workaround
			if (!isset($post_args['directories'])) {
				$shortcode_atts['directories'] = $alsp_instance->current_directory->id;
			}

			$listings_controller = new alsp_listings_controller();
			$listings_controller->init($shortcode_atts);
			$listings_controller->hash = $hash;
		
			$listings_html = alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $listings_controller), true);
			wp_reset_postdata();
		}
		
		$out['html'] = $listings_html;
		$out['map_markers'] = $map_markers;
		$out['map_listings'] = $map_listings;

		echo json_encode($out);
	
		die();
	}
	
	public function get_map_marker_info() {
		global $alsp_instance, $wpdb;

		if (isset($_POST['location_id']) && is_numeric($_POST['location_id'])) {
			$location_id = $_POST['location_id'];

			$row = $wpdb->get_row("SELECT * FROM {$wpdb->alsp_locations_relationships} WHERE id=".$location_id, ARRAY_A);

			if ($row && $row['location_id'] || $row['map_coords_1'] != '0.000000' || $row['map_coords_2'] != '0.000000' || $row['address_line_1'] || $row['zip_or_postal_index']) {
				$listing = new alsp_listing;
				if ($listing->loadListingFromPost($row['post_id'])) {
					$location = new alsp_location($row['post_id']);
					$location_settings['id'] = alsp_getValue($row, 'id');
					$location_settings['selected_location'] = alsp_getValue($row, 'location_id');
					$location_settings['address_line_1'] = alsp_getValue($row, 'address_line_1');
					$location_settings['address_line_2'] = alsp_getValue($row, 'address_line_2');
					$location_settings['zip_or_postal_index'] = alsp_getValue($row, 'zip_or_postal_index');
					$location_settings['additional_info'] = alsp_getValue($row, 'additional_info');
					if ($listing->level->map) {
						$location_settings['manual_coords'] = alsp_getValue($row, 'manual_coords');
						$location_settings['map_coords_1'] = alsp_getValue($row, 'map_coords_1');
						$location_settings['map_coords_2'] = alsp_getValue($row, 'map_coords_2');
						if ($listing->level->map_markers)
							$location_settings['map_icon_file'] = alsp_getValue($row, 'map_icon_file');
					}
					$location->createLocationFromArray($location_settings);
					global $ALSP_ADIMN_SETTINGS;
					$logo_image = '';
					if ($listing->logo_image) {
							require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
							$width= $ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_width'];
							$height= $ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_height'];
							$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
							$image_src = $image_src_array[0];
							$param = array(
								'width' => $width,
								'height' => $height,
								'crop' => true
							);
							//$src = wp_get_attachment_image_src($listing->logo_image, array(,));
							$logo_image = '<img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" />';
							//$logo_image = $src[0];
						} elseif ($ALSP_ADIMN_SETTINGS['alsp_enable_nologo'] && $ALSP_ADIMN_SETTINGS['alsp_nologo_url']) {
							$image_src = $ALSP_ADIMN_SETTINGS['alsp_nologo_url'];
							$param = array(
								'width' => $width,
								'height' => $height,
								'crop' => true
							);
							$logo_image = '<img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" />';
							//$logo_image = $ALSP_ADIMN_SETTINGS['alsp_nologo_url'];
						}
						
					$listing_link = '';
					if ($listing->level->listings_own_page)
						$listing_link = get_permalink($listing->post->ID);
						
					$content_fields_output = $listing->setMapContentFields($alsp_instance->content_fields->getMapContentFields(), $location);

					$locations_option_array = array(
							$location->id,
							$location->map_coords_1,
							$location->map_coords_2,
							$location->map_icon_file,
							$location->map_icon_color,
							$listing->map_zoom,
							$listing->title(),
							$logo_image,
							$listing_link,
							$content_fields_output,
							'post-' . $listing->post->ID,
					);
						
					echo json_encode($locations_option_array);
				}
			}
		}
		die();
	}
	
	public function select_field_icon() {
		alsp_renderTemplate('views/alsp_fontawesome.tpl.php', array('icons' => alsp_get_fa_icons_names()));
		die();
	}
	
	public function get_sharing_buttons() {
		alsp_renderTemplate('views/alsp_btn_share_ajax.tpl.php', array('post_id' => $_POST['post_id']));
		die();
	}
	
	public function contact_form() {
		global $ALSP_ADIMN_SETTINGS;
		$success = '';
		$error = '';
		if (!($type = $_REQUEST['type'])) {
			$error = __('The type of message required!', 'ALSP');
		} else {
			check_ajax_referer('alsp_' . $type . '_nonce', 'security');

			$validation = new alsp_form_validation;
			if (!is_user_logged_in()) {
				$validation->set_rules('name', __('Contact name', 'ALSP'), 'required');
				$validation->set_rules('email', __('Contact email', 'ALSP'), 'required|valid_email');
			}
			$validation->set_rules('listing_id', __('Listing ID', 'ALSP'), 'required');
			$validation->set_rules('message', __('Your message', 'ALSP'), 'required|max_length[1500]');
			if ($validation->run()) {
				$listing = new alsp_listing();
				if ($listing->loadListingFromPost($validation->result_array('listing_id'))) {
					if (!is_user_logged_in()) {
						$name = $validation->result_array('name');
						$email = $validation->result_array('email');
					} else {
						$current_user = wp_get_current_user();
						$name = $current_user->display_name;
						$email = $current_user->user_email;
					}
					$message = $validation->result_array('message');
	
					if (alsp_is_recaptcha_passed()) {
						if ($type == 'contact') {
							if ($ALSP_ADIMN_SETTINGS['alsp_custom_contact_email'] && $listing->contact_email){
								$send_to_email = $listing->contact_email;
							}else {
								$listing_owner = get_userdata($listing->post->post_author);
								$send_to_email = $listing_owner->user_email;
							}
						}elseif ($type == 'report') {
							$send_to_email = get_option('admin_email');
						}
	
						$headers[] = "From: $name <$email>";
						$headers[] = "Reply-To: $email";
						$headers[] = "Content-Type: text/html";

						$subject = sprintf(__('%s contacted you about your listing "%s"', 'ALSP'), $name, $listing->title());
	
						$body = alsp_renderTemplate('alsp-emails/' . $type . '_form.tpl.php',
						array(
							'name' => $name,
							'email' => $email,
							'message' => $message,
							'listing_title' => $listing->title(),
							'listing_url' => get_permalink($listing->post->ID)
						), true);

						do_action('alsp_send_' . $type . '_email', $listing, $send_to_email, $subject, $body, $headers);
					
						if (alsp_mail($send_to_email, $subject, $body, $headers)) {
							unset($_POST['name']);
							unset($_POST['email']);
							unset($_POST['message']);
							$success = __('You message was sent successfully!', 'ALSP');
						} else {
							$error = esc_attr__("An error occurred and your message wasn't sent!", 'ALSP');
						}
						$listing_owner = get_userdata($listing->post->post_author);
						$to = $listing_owner->user_phone;
						if(alsp_isDiTwilioActive() && !empty($to)){
							alsp_send_sms($to, $body);
						}
					} else {
						$error = esc_attr__("Anti-bot test wasn't passed!", 'ALSP');
					}
				}
			} else {
				$error = $validation->error_array();
			}
			echo json_encode(array('error' => $error, 'success' => $success));
	
			die();
		}
	}
	public function keywords_search() {
		global $ALSP_ADIMN_SETTINGS;
		$validation = new alsp_form_validation;
		$validation->set_rules('term', __('Search term', 'ALSP'));
		$validation->set_rules('directories', __('Directories IDs', 'ALSP'));
		if ($validation->run()) {
			$term = $validation->result_array('term');
			$directories = $validation->result_array('directories'); 
			
			$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);
			$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
		
			$args = array(
					'post_type' => ALSP_POST_TYPE,
					'post_status' => 'publish',
					'posts_per_page' => apply_filters('alsp_ajax_search_listings_number', 10),
					's' => $term
			);
			$args = array_merge($args, $order_args);
			// needs workaround
			if ($directories) {
				$directories = explode(',', $directories);
				$args = alsp_set_directory_args($args, $directories);
			}

			$query = new WP_Query($args);
			
			// adapted for Relevanssi
			if (alsp_is_relevanssi_search()) {
				$query->query_vars['s'] = $term;
				$query->query_vars['posts_per_page'] = apply_filters('alsp_ajax_search_listings_number', 10);
				relevanssi_do_query($query);
			}
			
			$listings_json = array();
			while ($query->have_posts()) {
				$query->the_post();
			
				$listing = new alsp_listing;
				$listing->loadListingFromPost(get_post());
				
				if (!$listing->level->listings_own_page) {
					$title = '<strong>' . $listing->title() . '</strong>';
				} else {
					$target = apply_filters('alsp_listing_title_search_target', 'target="_blank"');
					
					$title = '<strong><a href="' . get_the_permalink() . '" ' . $target . ' title="' . esc_attr__("open listing", "ALSP") . '" ' . (($listing->level->nofollow) ? 'rel="nofollow"' : '') . '>' . $listing->title() . '</a></strong>';
				}

				$listing_json_field = array();
				$listing_json_field['title'] = apply_filters('alsp_listing_title_search_html', $title, $listing);
				$listing_json_field['name'] = $listing->title();
				$listing_json_field['url'] = get_the_permalink();
				$listing_json_field['icon'] = $listing->get_logo_url(array(40, 40));
				$listing_json_field['sublabel'] = alsp_crop_content(10, 0, false, false, '...');
				$listings_json[] = $listing_json_field;
			}
			
			echo json_encode(array('listings' => $listings_json));
		}
		
		die();
	}
}
?>