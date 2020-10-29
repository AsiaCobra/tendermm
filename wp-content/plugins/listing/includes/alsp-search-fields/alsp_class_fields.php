<?php

include_once ALSP_PATH . 'includes/alsp-search-fields/alsp_field_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_string_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_select_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_checkbox_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_radio_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_number_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_price_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_datetime_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/fields/alsp_field_textarea_search.php';

class alsp_search_fields {
	public $search_fields_array = array(); // fields on search form
	public $filter_fields_array = array(); // all content fields available to filter listings

	public function __construct() {
		$this->load_search_fields();
		
		add_filter('alsp_search_args', array($this,  'retrieve_search_args'), 100, 4);
		add_filter('alsp_base_url_args', array($this, 'base_url_args'));
		
		// handle search configuration page
		add_action('admin_menu', array($this, 'menu'), 11);
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'), 100);
	}
	
	public function menu() {
		global $alsp_instance;
	
		add_action($alsp_instance->content_fields_manager->menu_page_hook, array($this, 'search_configuration_page'));
	}
	
	public function search_configuration_page() {
		if (isset($_GET['action']) && $_GET['action'] == 'configure_search' && isset($_GET['field_id'])) {
			$field_id = $_GET['field_id'];
			if (isset($this->search_fields_array[$field_id])) {
				$search_field = $this->search_fields_array[$field_id];
				if (method_exists($search_field, 'searchConfigure'))
					$search_field->searchConfigure();
			}
		}
	}
	
	public function getSearchFieldById($id) {
		if (isset($this->filter_fields_array[$id])) {
			return $this->filter_fields_array[$id];
		}
	}
	
	public function load_search_fields() {
		global $alsp_instance;
		
		//$this->search_fields_array = array();
		//$this->filter_fields_array = array();
	
		// load only for our page
		if (!$this->search_fields_array) {
			$content_fields = $alsp_instance->content_fields->content_fields_array;
	
			foreach ($content_fields AS $content_field) {
				$field_search_class = get_class($content_field) . '_search';
				if (class_exists($field_search_class)) {
					$search_field = new $field_search_class;
					$search_field->assignContentField($content_field);
					$search_field->convertSearchOptions();
					if ($content_field->canBeSearched() && (is_admin() || $content_field->on_search_form)) {
							$this->search_fields_array[$content_field->id] = $search_field;
							$this->filter_fields_array[$content_field->id] = $search_field;
					} else {
						$this->filter_fields_array[$content_field->id] = $search_field;
					}
				}
			}
		}
	}
	
	public function render_content_fields($search_form_id, $columns = 2, $gap_in_fields = 10, $search_form) {
		alsp_renderTemplate('alsp-search-fields/alsp_fields_search_form.tpl.php',
			array(
				'search_fields' => $search_form->search_fields_array,
				'search_fields_advanced' => $search_form->search_fields_array_advanced,
				'search_fields_all' => $search_form->search_fields_array_all,
				'columns' => $columns,
				'gap_in_fields' => $gap_in_fields,
				'is_advanced_search_panel' => $search_form->is_advanced_search_panel,
				'advanced_open' => $search_form->advanced_open,
				'search_form_id' => $search_form_id,
				'defaults' => $search_form->args
			)
		);
	}
	
	public function retrieve_search_args($args, $defaults = array(), $include_GET_params = true, $shortcode_hash = null) {
		global $ALSP_ADIMN_SETTINGS, $alsp_instance;

		$include_tax_children = alsp_getValue($defaults, 'include_categories_children');

		if ($include_GET_params) {
			$categories = (alsp_getValue($_REQUEST, 'categories') ? alsp_getValue($_REQUEST, 'categories') : alsp_getValue($defaults, 'categories'));
		} else {
			$categories = alsp_getValue($defaults, 'categories');
		}
		if (!$categories) {
			$categories = alsp_getValue($defaults, 'exact_categories');
		}
		
		// Search keyword in categories terms
		if (!empty($args["s"])) {
			$t_args = array(
					'taxonomy'      => array(ALSP_CATEGORIES_TAX), // taxonomy name
					'orderby'       => 'id',
					'order'         => 'ASC',
					'hide_empty'    => true,
					'fields'        => 'tt_ids',
					'name__like'    => $args["s"]
			);
			$categories .= ',' . implode(',', get_terms($t_args));
			$args["_meta_or_title"] = $args["s"]; // needed for posts_clauses filter in frotnend_controller.php
		}

		if ($categories) {
			if ($categories = array_filter(explode(',', $categories), 'trim')) {
				$field = 'term_id';
				foreach ($categories AS $category) {
					if (!is_numeric($category)) {
						$field = 'slug';
					}
				}

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_CATEGORIES_TAX,
						'terms' => $categories,
						'field' => $field,
						'include_children' => $include_tax_children
				);
			}
		}
		
		if ($include_GET_params) {
			$listingtypes = (alsp_getValue($_REQUEST, 'listingtypes') ? alsp_getValue($_REQUEST, 'listingtypes') : alsp_getValue($defaults, 'listingtypes'));
		} else {
			$listingtypes = alsp_getValue($defaults, 'listingtypes');
		}
		if (!$listingtypes) {
			$listingtypes = alsp_getValue($defaults, 'exact_listingtypes');
		}
		
		// Search keyword in categories terms
		if (!empty($args["s"])) {
			$t_args = array(
					'taxonomy'      => array(ALSP_TYPE_TAX), // taxonomy name
					'orderby'       => 'id',
					'order'         => 'ASC',
					'hide_empty'    => true,
					'fields'        => 'tt_ids',
					'name__like'    => $args["s"]
			);
			$listingtypes .= ',' . implode(',', get_terms($t_args));
			$args["_meta_or_title"] = $args["s"]; // needed for posts_clauses filter in frotnend_controller.php
		}

		if ($listingtypes) {
			if ($listingtypes = array_filter(explode(',', $listingtypes), 'trim')) {
				$field = 'term_id';
				foreach ($listingtypes AS $listingtype) {
					if (!is_numeric($listingtype)) {
						$field = 'slug';
					}
				}

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_TYPE_TAX,
						'terms' => $listingtypes,
						'field' => $field,
						'include_children' => $include_tax_children
				);
			}
		}
		
		
		//$search_locations = (alsp_getValue($defaults, 'locations')) ? alsp_getValue($defaults, 'locations') : alsp_getValue($defaults, 'exact_locations');
		if ($include_GET_params) {
			$search_locations = (alsp_getValue($_REQUEST, 'locations') ? alsp_getValue($_REQUEST, 'locations') : alsp_getValue($defaults, 'locations'));
		} else {
			$search_locations = alsp_getValue($defaults, 'locations');
		}
		if (!$search_locations) {
			if ($include_GET_params) {
				$search_locations = (alsp_getValue($_REQUEST, 'exact_locations') ? alsp_getValue($_REQUEST, 'exact_locations') : alsp_getValue($defaults, 'exact_locations'));
			} else {
				$search_locations = alsp_getValue($defaults, 'exact_locations');
			}
		}

		if ($search_locations) {
			if ($locations = array_filter(explode(',', $search_locations), 'trim')) {
				$field = 'term_id';
				foreach ($locations AS $location) {
					if (!is_numeric($location)) {
						$field = 'slug';
					}
				}

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_LOCATIONS_TAX,
						'terms' => $locations,
						'field' => $field,
						'include_children' => $include_tax_children
				);
			}
		}
		
		if ($include_GET_params) {
			$tags = (alsp_getValue($_REQUEST, 'tags') ? alsp_getValue($_REQUEST, 'tags') : alsp_getValue($defaults, 'tags'));
		} else {
			$tags = alsp_getValue($defaults, 'tags');
		}
		
		if (!empty($args["s"])) {
			$t_args = array(
					'taxonomy'      => array(ALSP_TAGS_TAX), // taxonomy name
					'orderby'       => 'id',
					'order'         => 'ASC',
					'hide_empty'    => true,
					'fields'        => 'tt_ids',
					'name__like'    => $args["s"]
			);
			$tags .= ',' . implode(',', get_terms($t_args));
			$args["_meta_or_title"] = $args["s"]; // needed for posts_clauses filter in frotnend_controller.php
		}

		if ($tags) {
			if ($tags = array_filter(explode(',', $tags), 'trim')) {
				$field = 'term_id';
				foreach ($tags AS $tag) {
					if (!is_numeric($tag)) {
						$field = 'slug';
					}
				}

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_TAGS_TAX,
						'terms' => $tags,
						'field' => 'term_id'
				);
			}
		}

		if ($include_GET_params) {
			$search_location = alsp_getValue($_REQUEST, 'location_id', alsp_getValue($defaults, 'location_id'));
			$address = trim(alsp_getValue($_REQUEST, 'address', alsp_getValue($defaults, 'address', null)));
			$radius = alsp_getValue($_REQUEST, 'radius', alsp_getValue($defaults, 'radius'));
		} else {
			$search_location = alsp_getValue($defaults, 'location_id');
			$address = trim(alsp_getValue($defaults, 'address', null));
			$radius = alsp_getValue($defaults, 'radius');
		}

		$search_location = apply_filters('alsp_search_param_location_id', $search_location);
		$address = apply_filters('alsp_search_param_address', $address);
		$radius = apply_filters('alsp_search_param_radius', $radius);
		
		if (is_null($address) && (alsp_getValue($defaults, 'start_address'))) {
			$address = alsp_getValue($defaults, 'start_address');
		}

		$start_latitude = alsp_getValue($defaults, 'start_latitude');
		$start_longitude = alsp_getValue($defaults, 'start_longitude');
		
		$start_latitude = apply_filters('alsp_search_param_start_latitude', $start_latitude);
		$start_longitude = apply_filters('alsp_search_param_start_longitude', $start_longitude);

		// Do not search by radius when only location ID was selected and we do not have any real address clicking the search button,
		// but working with shortcode parameters must be enough to search by radius.
		if (alsp_getValue($_REQUEST, 'alsp_action') == 'search') {
			if (!$address) {
				$radius = 0;
			}
		}
		if ($radius && is_numeric($radius) && ($address || ($start_latitude && $start_longitude))) {
			$alsp_instance->radius_values_array[$shortcode_hash]['radius'] = $radius;

			if (($search_location && is_numeric($search_location)) || $address || ($start_latitude && $start_longitude)) {
				$coords = null;
				if ($start_latitude && $start_longitude) {
					$coords[1] = $start_latitude;
					$coords[0] = $start_longitude;
				} elseif ($address || $search_location) {
					$chain = array();
					$parent_id = $search_location;
					while ($parent_id != 0) {
						if ($term = get_term($parent_id, ALSP_LOCATIONS_TAX)) {
							$chain[] = $term->name;
							$parent_id = $term->parent;
						} else
							$parent_id = 0;
					}
					$location_string = implode(', ', $chain);
					
					if ($address)
						$location_string = $address . ' ' . $location_string;
					if ($ALSP_ADIMN_SETTINGS['alsp_default_geocoding_location'])
						$location_string = $location_string . ' ' . $ALSP_ADIMN_SETTINGS['alsp_default_geocoding_location'];
					
					$alsp_locationGeoname = new alsp_locationGeoname();
					$coords = $alsp_locationGeoname->geocodeRequest($location_string, 'coordinates');
				}

				if ($coords) {
					add_filter('alsp_ordering_options', array($this, 'order_by_distance_html'), 10, 4);

					$alsp_instance->radius_values_array[$shortcode_hash]['x_coord'] = $coords[1]; // latitude
					$alsp_instance->radius_values_array[$shortcode_hash]['y_coord'] = $coords[0]; // longitude

					// radius_params must be localized by 2 ways: inside retrieve_search_args() function and in wp_enqueue_scripts hook
					// this one for alsp-map shortcode and map widget
					//if (($public_control = $alsp_instance->getShortcodeByHash($shortcode_hash)) /* && $public_control->map */) {
						wp_localize_script(
							'alsp_applications',
							'radius_params_'.$shortcode_hash,
							array(
								'radius_value' => $radius,
								'map_coords_1' => $coords[1],
								'map_coords_2' => $coords[0],
								'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
							)
						);
					//}

					if ($ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search'] == 'miles')
						$R = 3956; // earth's mean radius in miles
					else
						$R = 6367; // earth's mean radius in km

					$dLat = '((map_coords_1-'.$coords[1].')*PI()/180)';
					$dLong = '((map_coords_2-'.$coords[0].')*PI()/180)';
					$a = '(sin('.$dLat.'/2) * sin('.$dLat.'/2) + cos('.$coords[1].'*pi()/180) * cos(map_coords_1*pi()/180) * sin('.$dLong.'/2) * sin('.$dLong.'/2))';
					$c = '2*atan2(sqrt('.$a.'), sqrt(1-'.$a.'))';
					$sql = $R.'*'.$c; 

					global $wpdb, $alsp_address_locations;
					$results = $wpdb->get_results($wpdb->prepare(
						"SELECT DISTINCT
							id, post_id, " . $sql . " AS distance FROM {$wpdb->alsp_locations_relationships}
						HAVING
							distance <= %d
						ORDER BY
							distance
						", $radius), ARRAY_A);

					$post_ids = array();
					$alsp_address_locations = array();
					foreach ($results AS $row) {
						$post_ids[] = $row['post_id'];
						$alsp_address_locations[] = $row['id'];
					}
					$post_ids = array_unique($post_ids);

					if ($post_ids) {
						$args['post__in'] = $post_ids;
					} else
						// Do not show any listings
						$args['post__in'] = array(0);

					$args = $this->order_by_distance_args($args, $defaults, $include_GET_params, $shortcode_hash);
				}
			}
		}

		foreach ($this->filter_fields_array AS $field_id=>$filter_field) {
			$filter_field->validateSearch($args, $defaults, $include_GET_params);
		}

		return $args;
	}
	
	public function order_by_distance_args($args, $defaults, $include_GET_params, $shortcode_hash) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if (isset($alsp_instance->radius_values_array[$shortcode_hash]) && $alsp_instance->radius_values_array[$shortcode_hash]['radius']) {
			if (!isset($defaults['order_by']) || !$defaults['order_by']) {
				$defaults['order_by'] = 'distance';
				$alsp_instance->order_by_date = false;
				//$defaults['order'] = 'ASC';
			}
			
			if ($include_GET_params) {
				$order_by = alsp_getValue($_REQUEST, 'order_by', alsp_getValue($defaults, 'order_by'));
				$order = alsp_getValue($_REQUEST, 'order', alsp_getValue($defaults, 'order'));
			} else {
				$order_by = alsp_getValue($defaults, 'order_by');
				$order = alsp_getValue($defaults, 'order');
			}

			// When search by radius - order by distance by default instead of ordering by date
			if ($order_by == 'distance' && $ALSP_ADIMN_SETTINGS['alsp_orderby_distance']) {
				$args['orderby'] = 'post__in';
				unset($args['meta_key']);
				if ($order == 'DESC') {
					if (!empty($args['post__in']) && is_array($args['post__in'])) {
						$args['post__in'] = array_reverse($args['post__in']);
					}
				}
	
				if (!$ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
					// Do not affect levels weights when search by radius
					remove_filter('posts_join', 'join_levels');
					remove_filter('posts_orderby', 'orderby_levels', 1);
					remove_filter('get_meta_sql', 'add_null_values');
				}
			}
		}

		return $args;
	}
	
	public function order_by_distance_html($ordering, $base_url, $defaults = array(), $shortcode_hash = null) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if (isset($alsp_instance->radius_values_array[$shortcode_hash]) && $alsp_instance->radius_values_array[$shortcode_hash]['radius']) {
			if (!isset($_REQUEST['order_by']) || !$_REQUEST['order_by'] || $_REQUEST['order_by'] == 'distance') {
				// clear links buttons class from previous set
				foreach ($ordering['array'] AS $field_slug=>$field_name) {
					$ordering['struct'][$field_slug]['class'] = '';
				}
				
				if (isset($defaults['order_by']) && $defaults['order_by'] && isset($ordering['array'][$defaults['order_by']])) {
					$url = esc_url(add_query_arg('order_by', $defaults['order_by'], $base_url));
					$ordering['links'][$defaults['order_by']] = '<a href="' . $url . '">' . $ordering['array'][$defaults['order_by']] . '</a>';
					$ordering['struct'][$defaults['order_by']]['url'] = $url;
					$ordering['struct'][$defaults['order_by']]['class'] = '';
				}
	
				$order_by = 'distance';
				$order = alsp_getValue($_REQUEST, 'order', 'ASC');
			} else {
				$order_by = alsp_getValue($defaults, 'order_by');
				$order = alsp_getValue($defaults, 'order');
			}
	
			$class = '';
			$next_order = 'ASC';
			// When search by radius - order by distance by default instead of ordering by date
			if ($order_by == 'distance' && $ALSP_ADIMN_SETTINGS['alsp_orderby_distance']) {
				if (!$order || $order == 'DESC') {
					$class = 'descending';
					$next_order = 'ASC';
					$url = esc_url(add_query_arg('order_by', 'distance', $base_url));
				} elseif ($order == 'ASC') {
					$class = 'ascending';
					$next_order = 'DESC';
					$url = esc_url(add_query_arg('order', $next_order, add_query_arg('order_by', 'distance', $base_url)));
				}
			} else
				$url = esc_url(add_query_arg('order_by', 'distance', $base_url));
	
			$ordering['links']['distance'] = '<a class="' . $class . '" href="' . $url . '">' . __('Distance', 'ALSP') . '</a>';
			$ordering['array']['distance'] = __('Distance', 'ALSP');
			$ordering['struct']['distance'] = array('class' => $class, 'url' => $url, 'field_name' => __('Distance', 'ALSP'), 'order' => $next_order);
		}

		return $ordering;
	}
	
	public function base_url_args($args) {
		if (isset($_REQUEST['alsp_action']) && $_REQUEST['alsp_action'] == 'search') {
			if (isset($_REQUEST['categories']) && $_REQUEST['categories'] && is_numeric($_REQUEST['categories']))
				$args['categories'] = $_REQUEST['categories'];
			if (isset($_REQUEST['listingtypes']) && $_REQUEST['listingtypes'] && is_numeric($_REQUEST['listingtypes']))
				$args['listingtypes'] = $_REQUEST['listingtypes'];
			if (isset($_REQUEST['radius']) && $_REQUEST['radius'] && is_numeric($_REQUEST['radius']))
				$args['radius'] = $_REQUEST['radius'];

			foreach ($this->search_fields_array AS $search_field)
				$search_field->getBaseUrlArgs($args);
		}
		
		return $args;
	}
	
	public function enqueue_scripts_styles() {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
	
		if (function_exists('is_rtl') && is_rtl()) {
			wp_deregister_script('jquery-ui-slider');
			wp_register_script('jquery-ui-slider', ALSP_RESOURCES_URL . 'js/min/jquery.ui.slider-rtl.min.js', array('jquery-ui-core') , false, true);
		}
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-touch-punch');
	
		wp_localize_script(
			'jquery-ui-slider',
			'slider_params',
			array(
				'min' => $ALSP_ADIMN_SETTINGS['alsp_radius_search_min'],
				'max' => $ALSP_ADIMN_SETTINGS['alsp_radius_search_max']
			)
		);

		// radius_params must be localized by 2 ways: inside retrieve_search_args() function and in wp_enqueue_scripts hook
		// this one for alsp shortcode
		foreach ($alsp_instance->radius_values_array AS $shortcode_hash=>$value) {
			if (($public_control = $alsp_instance->getShortcodeByHash($shortcode_hash)) && isset($value['x_coord']) && isset($value['y_coord'])) {
				wp_localize_script(
					'alsp_applications',
					'radius_params_'.$public_control->hash,
					array(
						'radius_value' => $value['radius'],
						'map_coords_1' => $value['x_coord'],
						'map_coords_2' => $value['y_coord'],
						'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
					)
				);
			}
		}
	}
}

?>