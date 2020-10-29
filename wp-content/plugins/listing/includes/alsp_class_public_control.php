<?php 
// check keyword [needs workaround]
class alsp_public_control {
	public $args = array();
	public $query;
	public $page_title;
	public $template;
	public $listings = array();
	public $search_form;
	public $map;
	public $paginator;
	public $breadcrumbs = array();
	public $base_url;
	public $messages = array();
	public $hash = null;
	public $levels_ids;
	public $do_initial_load = true;
	public $request_by = 'public_control';
	public $scroll = 0;
	public $scroller_nav_style;
	
	public function __construct($args = array()) {
		apply_filters('alsp_public_control_construct', $this);
	}
	
	public function init($attrs = array()) {
		global $ALSP_ADIMN_SETTINGS;
		$this->args['logo_animation_effect'] = 6;
		$this->args['listing_post_style'] = $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];

		if (!$this->hash)
			if (isset($attrs['uid']) && $attrs['uid'])
				$this->hash = md5($attrs['uid']);
			else
				$this->hash = md5(get_class($this).serialize($attrs));
	}
	public function processQuery($load_map = true, $map_args = array()) {
		global $ALSP_ADIMN_SETTINGS;
		// this is special construction,
		// this needs when we order by any postmeta field, this adds listings to the list with "empty" fields
		if (($this->getQueryVars('orderby') == 'meta_value_num' || $this->getQueryVars('orderby') == 'meta_value') && ($this->getQueryVars('meta_key') != '_order_date')) {
			$args = $this->getQueryVars();

			// there is strange thing - WP adds `taxonomy` and `term_id` args to the root of query vars array
			// this may cause problems
			unset($args['taxonomy']);
			unset($args['term_id']);
			if (empty($args['s'])) {
				unset($args['s']);
			}
			
			$original_posts_per_page = $args['posts_per_page'];

			$ordered_posts_ids = get_posts(array_merge($args, array('fields' => 'ids', 'nopaging' => true)));
			//var_dump($ordered_posts_ids);
			$ordered_max_num_pages = ceil(count($ordered_posts_ids)/$original_posts_per_page) - (int) $ordered_posts_ids;

			$args['paged'] = $args['paged'] - $ordered_max_num_pages;
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = '_order_date';
			$args['order'] = 'DESC';
			$args['posts_per_page'] = $original_posts_per_page - $this->query->post_count;
			$all_posts_ids = get_posts(array_merge($args, array('fields' => 'ids', 'nopaging' => true)));
			$all_posts_count = count($all_posts_ids);
			//var_dump($all_posts_count);

			if ($this->query->found_posts) {
				$args['post__not_in'] = array_map('intval', $ordered_posts_ids);
				if (!empty($args['post__in']) && is_array($args['post__in'])) {
					$args['post__in'] = array_diff($args['post__in'], $args['post__not_in']);
					if (!$args['post__in']) {
						$args['posts_per_page'] = 0;
					}
				}
			}

			$unordered_query = new WP_Query($args);
			//var_dump($args);

			//var_dump($unordered_query->request);
			//var_dump($this->query->request);

			if ($args['posts_per_page']) {
				$this->query->posts = array_merge($this->query->posts, $unordered_query->posts);
			}

			$this->query->post_count = count($this->query->posts);
			$this->query->found_posts = $all_posts_count;
			$this->query->max_num_pages = ceil($all_posts_count/$original_posts_per_page);
		}

		if ($load_map) {
			if (!isset($map_args['map_markers_is_limit']))
				$map_args['map_markers_is_limit'] = $ALSP_ADIMN_SETTINGS['alsp_map_markers_is_limit'];
			$this->map = new alsp_maps($map_args, $this->request_by);
			$this->map->setUniqueId($this->hash);
			
			if (!$map_args['map_markers_is_limit'] && !$this->map->is_ajax_markers_management()) {
				$this->collectAllLocations();
			}
		}
		
		while ($this->query->have_posts()) {
			$this->query->the_post();

			$listing = new alsp_listing;
			$listing->loadListingFromPost(get_post());
			//$listing->logo_animation_effect = (isset($this->args['logo_animation_effect'])) ? $this->args['logo_animation_effect'] : get_option('alsp_logo_animation_effect');
			$listing->listing_post_style = (isset($this->args['listing_post_style'])) ? $this->args['listing_post_style']: $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];
			$listing->listing_image_width = (isset($this->args['listing_image_width'])) ? $this->args['listing_image_width']: $ALSP_ADIMN_SETTINGS['alsp_logo_width'];
			$listing->listing_image_height = (isset($this->args['listing_image_height'])) ? $this->args['listing_image_height']: $ALSP_ADIMN_SETTINGS['alsp_logo_height'];
			$listing->fchash = $this->hash;
			$listing->listings_view_type = (isset($this->args['listings_view_type'])) ? $this->args['listings_view_type']: $ALSP_ADIMN_SETTINGS['alsp_views_switcher_default'];
			$listing->listing_featured_tag_style = $ALSP_ADIMN_SETTINGS['listing_featured_tag_style'];
			
			if ($load_map && $map_args['map_markers_is_limit'] && !$this->map->is_ajax_markers_management())
				$this->map->collectLocations($listing);
			
			$this->listings[get_the_ID()] = $listing;
		}
		
		global $alsp_address_locations, $alsp_tax_terms_locations;
		// empty this global arrays - there may be some google maps on one page with different arguments
		$alsp_address_locations = array();
		$alsp_tax_terms_locations = array();

		// this is reset is really required after the loop ends 
		wp_reset_postdata();
		
		remove_filter('posts_join', 'join_levels');
		remove_filter('posts_orderby', 'orderby_levels', 1);
		remove_filter('get_meta_sql', 'add_null_values');
	}
	
	public function collectAllLocations() {
		$args = $this->getQueryVars();
			
		unset($args['orderby']);
		unset($args['order']);
		$args['nopaging'] = 1;
		$unlimited_query = new WP_Query($args);
		while ($unlimited_query->have_posts()) {
			$unlimited_query->the_post();
			
			$listing = new alsp_listing;
			$listing->loadListingFromPost(get_post());
			
			$this->map->collectLocations($listing);
		}
	}
		
	public function getQueryVars($var = null) {
		if (is_null($var)) {
			return $this->query->query_vars;
		} else {
			if (isset($this->query->query_vars[$var])) {
				return $this->query->query_vars[$var];
			}
		}
		return false;
	}
	
	//public function getQuery() {
		//return $this->query;
	//}
	
	public function getPageTitle() {
		return $this->page_title;
	}

	public function getBreadCrumbs($separator = ' » ') {
		return implode($separator, $this->breadcrumbs);
	}

	public function getBaseUrl() {
		return $this->base_url;
	}
	
	public function where_levels_ids($where = '') {
		if ($this->levels_ids)
			$where .= " AND (alsp_levels.id IN (" . implode(',', $this->levels_ids) . "))";
		return $where;
	}
	// needs workaround
	public function getListingsDirectory() {
		global $alsp_instance;
		
		if (isset($this->args['directories']) && !empty($this->args['directories'])) {
			if (is_object($this->args['directories'])) {
				return $this->args['directories'];
			} elseif (is_string($this->args['directories'])) {
				if ($directories_ids = array_filter(explode(',', $this->args['directories']), 'trim')) {
					if (count($directories_ids) == 1 && ($directory = $alsp_instance->directories->getDirectoryById($directories_ids[0]))) {
						return $directory;
					}
				}
			}
		}
		
		return $alsp_instance->current_directory;
	}
	
	public function getListingClasses() {
		$classes = array();
		
		if ($this->listings[get_the_ID()]->level->featured) {
			$classes[] = 'alsp-featured';
		}
		if ($this->listings[get_the_ID()]->level->sticky) {
			$classes[] = 'alsp-sticky';
		}
		if (!empty($this->args['summary_on_logo_hover'])) {
			$classes[] = 'alsp-summary-on-logo-hover';
		}
		if (!empty($this->args['hide_content'])) {
			$classes[] = 'alsp-hidden-content';
		}
		return $classes;
	}
	
	public function display() {
		$output =  alsp_renderTemplate($this->template, array('public_control' => $this), true);
		wp_reset_postdata();
	
		return $output;
	}
}

/**
 * join levels_relationships and levels tables into the query
 * 
 * */
function join_levels($join = '') {
	global $wpdb;

	$join .= " LEFT JOIN {$wpdb->alsp_levels_relationships} AS alsp_lr ON alsp_lr.post_id = {$wpdb->posts}.ID ";
	$join .= " LEFT JOIN {$wpdb->alsp_levels} AS alsp_levels ON alsp_levels.id = alsp_lr.level_id ";

	return $join;
}

/**
 * sticky and featured listings in the first order
 * 
 */
function orderby_levels($orderby = '') {
	$orderby = " alsp_levels.sticky DESC, alsp_levels.featured DESC, " . $orderby;
	return $orderby;
}

/**
 * sticky and featured listings in the first order
 * 
 */
function where_sticky_featured($where = '') {
	$where .= " AND (alsp_levels.sticky=1 OR alsp_levels.featured=1)";
	return $where;
}

/**
 * Listings with empty values must be sorted as well
 * 
 */
function add_null_values($clauses) {
	$clauses['where'] = preg_replace("/wp_postmeta\.meta_key = '_content_field_([0-9]+)'/", "(wp_postmeta.meta_key = '_content_field_$1' OR wp_postmeta.meta_value IS NULL)", $clauses['where']);
	return $clauses;
}


add_filter('alsp_order_args', 'alsp_order_listings', 10, 3);
function alsp_order_listings($order_args = array(), $defaults = array(), $include_GET_params = true) {
	global $alsp_instance, $ALSP_ADIMN_SETTINGS;
	
	// adapted for Relevanssi
	if (alsp_is_relevanssi_search($defaults)) {
		return $order_args;
	}

	if ($include_GET_params && isset($_GET['order_by']) && $_GET['order_by']) {
		$order_by = $_GET['order_by'];
		$order = alsp_getValue($_GET, 'order', 'ASC');
	} else {
		if (isset($defaults['order_by']) && $defaults['order_by']) {
			$order_by = $defaults['order_by'];
			$order = alsp_getValue($defaults, 'order', 'ASC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$order_args['orderby'] = $order_by;
	$order_args['order'] = $order;

	if ($order_by == 'rand' || $order_by == 'random') {
		// do not order by rand in search results
		//if ($_REQUEST['alsp_action'] != 'search') {
			if ($ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
				add_filter('posts_join', 'join_levels');
				add_filter('posts_orderby', 'orderby_levels', 1);
			}
			$order_args['orderby'] = 'rand';
		/* } else {
			$order_by = 'post_date';
		} */
	}

	if ($order_by == 'title') {
		//$order_args['orderby'] = 'title';
		$order_args['orderby'] = array('title' => $order_args['order'], 'meta_value_num' => 'ASC');
		$order_args['meta_key'] = '_order_date';
		if ($ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
			add_filter('posts_join', 'join_levels');
			add_filter('posts_orderby', 'orderby_levels', 1);
		}
	} elseif ($order_by == 'post_date' || $ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
		// Do not affect levels weights when already ordering by posts IDs
		if (!isset($order_args['orderby']) || $order_args['orderby'] != 'post__in') {
			add_filter('posts_join', 'join_levels');
			add_filter('posts_orderby', 'orderby_levels', 1);
			add_filter('get_meta_sql', 'add_null_values');
		}

		if ($order_by == 'post_date') {
			$alsp_instance->order_by_date = true;
			// First of all order by _order_date parameter
			$order_args['orderby'] = 'meta_value_num';
			$order_args['meta_key'] = '_order_date';
		} else
			$order_args = array_merge($order_args, $alsp_instance->content_fields->getOrderParams($defaults));
	} else {
		$order_args = array_merge($order_args, $alsp_instance->content_fields->getOrderParams($defaults));
	}

	return $order_args;
}

class alsp_query_search extends WP_Query {
	function __parse_search($q) {
		$x = $this->parse_search($q);
		return $x;
	}
}

add_filter('posts_clauses', 'posts_clauses', 10, 2);
function posts_clauses($clauses, $q) {
	if ($title = $q->get('_meta_or_title')) {
		$tax_query_vars = array();
		if (!empty($q->query_vars['tax_query'])) {
			$tax_query_vars = $q->query_vars['tax_query'];
		}
		if (isset($tax_query_vars[0]['taxonomy']) && in_array($tax_query_vars[0]['taxonomy'], array(ALSP_CATEGORIES_TAX, ALSP_TAGS_TAX))) {
			$tq = new WP_Tax_Query($tax_query_vars);

			$qu['s'] = $title;
			$alsp_query_search = new alsp_query_search;
	
			global $wpdb;
			$tc = $tq->get_sql($wpdb->posts, 'ID');

			if ($tc['where'] && ($search_sql = $alsp_query_search->__parse_search($qu))) {
				$clauses['where'] = str_ireplace( 
					$search_sql, 
					' ', 
					$clauses['where'] 
				);
				$clauses['where'] = str_ireplace( 
					$tc['where'], 
					' ', 
					$clauses['where'] 
				);
				$clauses['where'] .= sprintf( 
					" AND ( ( 1=1 %s ) OR ( 1=1 %s ) ) ", 
					$tc['where'],
					$search_sql
				);
			}
		}
    }
    return $clauses;
}
function alsp_what_search($args, $defaults = array(), $include_GET_params = true) {
	if ($include_GET_params) {
		$args['s'] = alsp_getValue($_GET, 'what_search', alsp_getValue($defaults, 'what_search'));
	} else {
		$args['s'] =  alsp_getValue($defaults, 'what_search');
	}
	
	$args['s'] = stripslashes($args['s']);
	
	$args['s'] = apply_filters('alsp_search_param_what_search', $args['s']);

	// 's' parameter must be removed when it is empty, otherwise it may case WP_query->is_search = true
	if (empty($args['s'])) {
		unset($args['s']);
	}

	return $args;
}
add_filter('alsp_search_args', 'alsp_what_search', 10, 3);

function alsp_address($args, $defaults = array(), $include_GET_params = true) {
	global $wpdb, $alsp_address_locations;

	if ($include_GET_params) {
		$address = alsp_getValue($_GET, 'address', alsp_getValue($defaults, 'address'));
		$search_location = alsp_getValue($_GET, 'location_id', alsp_getValue($defaults, 'location_id'));
	} else {
		$search_location = alsp_getValue($defaults, 'location_id');
		$address = alsp_getValue($defaults, 'address');
	}
	
	$search_location = apply_filters('alsp_search_param_location_id', $search_location);
	$address = apply_filters('alsp_search_param_address', $address);
	
	$where_sql_array = array();
	if ($search_location && is_numeric($search_location)) {
		$term_ids = get_terms(ALSP_LOCATIONS_TAX, array('child_of' => $search_location, 'fields' => 'ids', 'hide_empty' => false));
		$term_ids[] = $search_location;
		$where_sql_array[] = "(location_id IN (" . implode(', ', $term_ids) . "))";
	}
	
	if ($address) {
		$where_sql_array[] = $wpdb->prepare("(address_line_1 LIKE '%%%s%%' OR address_line_2 LIKE '%%%s%%' OR zip_or_postal_index LIKE '%%%s%%')", $address, $address, $address);
		
		// Search keyword in locations terms
		$t_args = array(
				'taxonomy'      => array(ALSP_LOCATIONS_TAX),
				'orderby'       => 'id',
				'order'         => 'ASC',
				'hide_empty'    => true,
				'fields'        => 'tt_ids',
				'name__like'    => $address
		);
		$address_locations = get_terms($t_args);

		foreach ($address_locations AS $address_location) {
			$term_ids = get_terms(ALSP_LOCATIONS_TAX, array('child_of' => $address_location, 'fields' => 'ids', 'hide_empty' => false));
			$term_ids[] = $address_location;
			$where_sql_array[] = "(location_id IN (" . implode(', ', $term_ids) . "))";
		}
	}

	if ($where_sql_array) {
		$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->alsp_locations_relationships} WHERE " . implode(' OR ', $where_sql_array), ARRAY_A);
		$post_ids = array();
		foreach ($results AS $row) {
			$post_ids[] = $row['post_id'];
			$alsp_address_locations[] = $row['id'];
		}
		if ($post_ids) {
			$args['post__in'] = $post_ids;
		} else {
			// Do not show any listings
			$args['post__in'] = array(0);
		}	
	}
	return $args;
}
add_filter('alsp_search_args', 'alsp_address', 10, 3);

function alsp_keywordInCategorySearch($keyword) {
	if (alsp_getValue($_REQUEST, 'alsp_action') == 'search' && ($categories = array_filter(explode(',', alsp_getValue($_REQUEST, 'categories')), 'trim')) && count($categories) == 1) {
		if (!is_wp_error($category = get_term(array_pop($categories), ALSP_CATEGORIES_TAX))) {
			$keyword = trim(str_ireplace(htmlspecialchars_decode($category->name), '', $keyword));
		}
	}
	return $keyword;
}
add_filter('alsp_search_param_what_search', 'alsp_keywordInCategorySearch');

function alsp_addressInLocationSearch($address) {
	if (alsp_getValue($_REQUEST, 'alsp_action') == 'search' && ($location_id = array_filter(explode(',', alsp_getValue($_REQUEST, 'location_id')), 'trim')) && count($location_id) == 1) {
		if (!is_wp_error($location = get_term(array_pop($location_id), ALSP_LOCATIONS_TAX))) {
			$address = trim(str_ireplace(htmlspecialchars_decode($location->name), '', $address));
		}
	}
	return $address;
}
add_filter('alsp_search_param_address', 'alsp_addressInLocationSearch');

function alsp_base_url_args($args) {
	global $ALSP_ADIMN_SETTINGS;
	if (isset($_REQUEST['alsp_action']) && $_REQUEST['alsp_action'] == 'search') {
			$args['alsp_action'] = 'search';
		if (isset($_REQUEST['what_search']) && $_REQUEST['what_search'])
			$args['what_search'] = urlencode($_REQUEST['what_search']);
		if (isset($_REQUEST['address']) && $_REQUEST['address'])
			$args['address'] = urlencode($_REQUEST['address']);
		if (isset($_REQUEST['location_id']) && $_REQUEST['location_id'] && is_numeric($_REQUEST['location_id']))
			$args['location_id'] = $_REQUEST['location_id'];
	}
	
	// Required in ajax controller for get_pagenum_link() filter
	if ($ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
		if (isset($_REQUEST['order_by']) && $_REQUEST['order_by'])
			$args['order_by'] = $_REQUEST['order_by'];
		if (isset($_REQUEST['order']) && $_REQUEST['order'])
			$args['order'] = $_REQUEST['order'];
	}

	return $args;
}
add_filter('alsp_base_url_args', 'alsp_base_url_args');

function alsp_related_shortcode_args($shortcode_atts) {
	global $alsp_instance;
	
	if ((isset($shortcode_atts['directories']) && $shortcode_atts['directories'] == 'related') || (isset($shortcode_atts['related_directory']) && $shortcode_atts['related_directory'])) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
			if ($directory_controller->is_home || $directory_controller->is_search || $directory_controller->is_category || $directory_controller->is_location || $directory_controller->is_tag) {
				$shortcode_atts['directories'] = $alsp_instance->current_directory->id;
			} elseif ($directory_controller->is_single) {
				$shortcode_atts['directories'] = $directory_controller->listing->directory->id;
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if ((isset($shortcode_atts['categories']) && $shortcode_atts['categories'] == 'related') || (isset($shortcode_atts['related_categories']) && $shortcode_atts['related_categories'])) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
			if ($directory_controller->is_category) {
				$shortcode_atts['categories'] = $directory_controller->category->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_CATEGORIES_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['categories'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if ((isset($shortcode_atts['locations']) && $shortcode_atts['locations'] == 'related') || (isset($shortcode_atts['related_locations']) && $shortcode_atts['related_locations'])) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
			if ($directory_controller->is_location) {
				$shortcode_atts['locations'] = $directory_controller->location->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_LOCATIONS_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['locations'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if (isset($shortcode_atts['related_tags']) && $shortcode_atts['related_tags']) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
			if ($directory_controller->is_tag) {
				$shortcode_atts['tags'] = $directory_controller->tag->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_TAGS_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['tags'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if (isset($shortcode_atts['author']) && $shortcode_atts['author'] === 'related') {
		if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
			if ($directory_controller->is_single) {
				$shortcode_atts['author'] = $directory_controller->listing->post->post_author;
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		} elseif ($user_id = get_the_author_meta('ID')) {
			$shortcode_atts['author'] = $user_id;
		}
	}

	return $shortcode_atts;
}
add_filter('alsp_related_shortcode_args', 'alsp_related_shortcode_args');
// needs workaround
function alsp_set_directory_args($args, $directories_ids = array()) {
	global $alsp_instance;
	
	if ($alsp_instance->directories->isMultiDirectory()) {
		if (!isset($args['meta_query']))
			$args['meta_query'] = array();
	
		$args['meta_query'] = array_merge($args['meta_query'], array(
				array(
						'key' => '_directory_id',
						'value' => $directories_ids,
						'compare' => 'IN',
				)
		));
	}

	return $args;
}
if (!function_exists('alsp_get_similar_listings')) {
      function alsp_get_similar_listings($post_id, $count = 4, $cat = true)
      {
		  global $alsp_instance;
		  $listing = $alsp_instance->getShortcodeProperty('alsp-listing');
            $query = new WP_Query();
            $args = '';
            $post_id = $listing->listing->post->ID;
            $item_cats  = get_the_terms($post_id, ALSP_CATEGORIES_TAX);
            $item_array = array();
            if ($item_cats):
                  foreach ($item_cats as $item_cat) {
                        $item_array[] = $item_cat->term_id;
                  }
            else :
               $item_array[] = array('');
            endif;
			
            $args = wp_parse_args($args, array(
                  'showposts' => $count,
                  'post__not_in' => array(
                        $post_id
                  ),
                  'ignore_sticky_posts' => 0,
                  'post_type' => ALSP_POST_TYPE,
                  'tax_query' => array(
                        array(
                              'taxonomy' => ALSP_CATEGORIES_TAX,
                              'field' => 'id',
                              'terms' => $item_array
                        )
                  )
            ));
             $query = new WP_Query($args);
            return $query;
      }
}

add_action('alsp_related_listings', 'alsp_similar_listings');
if ( !function_exists( 'alsp_similar_listings' ) ) {
	function alsp_similar_listings( $layout ) {
			global $post, $pacz_settings, $alsp_instance;
			$output = '';
			$width = 250;
			$height = 190;

			if ( $layout == 'full' ) {
				$showposts = 3;
				$column_css = 'four-column';
			} else {
				$showposts = 3;
				$column_css = 'col-md-4 col-md-4 col-md-4';
			}
			$listing = $alsp_instance->getShortcodeProperty('alsp-listing');
			$related = alsp_get_similar_listings( $listing->listing->post->ID, $showposts, true );
			if ( $related->have_posts() ) {
				$output .= '<section class="alsp-similar-listings">';
					$output .=  '<h5 class="single-listing-fancy-title">'.esc_html__( 'Related Tenders', 'ALSP' ).'</h5>';
					
					$output .= '<div class="row related_listing_wrapper clearfix">';
						while ( $related->have_posts() ) {
							$related->the_post();
							$output .= '<div class="'.$column_css.'">';
								$output .= '<div class="item-holder">';
									$output .= '<a class="alsp-similiar-thumbnail" href="' . get_permalink() . '" title="' . get_the_title() . '">';
										if ( has_post_thumbnail() ) {
											$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
											$image_src = bfi_thumb( $image_src_array[ 0 ], array('width' => $width, 'height' => $height, 'crop'=>true));
											$output .= '<img width="'.$width.'" height="'.$height.'" src="' .pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . get_the_title() . '" />';
										}
									$output .= '</a>';
									$output .= '<a href="'.get_permalink().'" class="alsp-similiar-title" style="height:100px;">'.get_the_title().'</a>';
								$output .= '</div>';
							$output .= '</div>';
						}
					$output .= '</div>';
				$output .= '</section>';
			}
		wp_reset_postdata();
		echo $output;
	}
	/*-----------------*/
}
?>