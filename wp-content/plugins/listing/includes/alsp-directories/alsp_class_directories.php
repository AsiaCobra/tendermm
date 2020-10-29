<?php 

class alsp_directories {
	public $directories_array = array();

	public function __construct() {
		$this->getDirectoriesFromDB();

		add_action('init', array($this, 'setAdvanceDirectoriesURLs'));
		add_action('alsp_load_pages_directories', array($this, 'setDirectoriesURLs'));
	}

	public function getDirectoriesFromDB() {
		global $wpdb;
		$this->directories_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_directories}", ARRAY_A);
		foreach ($array AS $row) {
			$directory = new alsp_directory;
			$directory->buildDirectoryFromArray($row);
			$this->directories_array[$row['id']] = $directory;
		}
		
		if (!$this->directories_array) {
			$directory = new alsp_directory;
			$directory->buildDirectoryFromArray(array(
					'name' => __('Listings', 'ALSP'),
					'single' => __('listing', 'ALSP'),
					'plural' => __('listings', 'ALSP')
			));
			$this->directories_array[1] = $directory;
		}
	}
	
	public function setAdvanceDirectoriesURLs() {
		foreach ($this->directories_array AS &$directory) {
			$directory->setAdvanceURL();
		}
	}

	public function setDirectoriesURLs() {
		foreach ($this->directories_array AS &$directory) {
			$directory->setDirectoryURL();
		}
	}
	
	public function isMultiDirectory() {
		return (count($this->directories_array) > 1) ? true : false;
	}

	public function getDirectoryById($directory_id) {
		if (isset($this->directories_array[$directory_id]))
			return $this->directories_array[$directory_id];
	}
	
	public function getDefaultDirectory() {
		$array_keys = array_keys($this->directories_array);
		$first_id = array_shift($array_keys);
		return $this->getDirectoryById($first_id);
	}

	public function createDirectoryFromArray($array) {
		global $wpdb, $alsp_instance;
		
		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'single' => alsp_getValue($array, 'single'),
				'plural' => alsp_getValue($array, 'plural'),
				'listing_slug' => alsp_getValue($array, 'listing_slug'),
				'category_slug' => alsp_getValue($array, 'category_slug'),
				'listingtype_slug' => alsp_getValue($array, 'listingtype_slug'),
				'location_slug' => alsp_getValue($array, 'location_slug'),
				'tag_slug' => alsp_getValue($array, 'tag_slug'),
				'categories' => serialize(alsp_getValue($array, 'categories', array())),
				'listingtypes' => serialize(alsp_getValue($array, 'listingtypes', array())),
				'locations' => serialize(alsp_getValue($array, 'locations', array())),
				'levels' => serialize(alsp_getValue($array, 'levels', array())),
		);
		$insert_update_args = apply_filters('alsp_directory_create_edit_args', $insert_update_args, $array);

		if ($wpdb->insert($wpdb->alsp_directories, $insert_update_args)) {
			$new_directory_id = $wpdb->insert_id;
			
			do_action('alsp_update_directory', $new_directory_id, $array);
			
			$this->getDirectoriesFromDB();
			return true;
		}
	}
	
	public function saveDirectoryFromArray($directory_id, $array) {
		global $wpdb;

		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'single' => alsp_getValue($array, 'single'),
				'plural' => alsp_getValue($array, 'plural'),
				'listing_slug' => alsp_getValue($array, 'listing_slug'),
				'category_slug' => alsp_getValue($array, 'category_slug'),
				'listingtype_slug' => alsp_getValue($array, 'listingtype_slug'),
				'location_slug' => alsp_getValue($array, 'location_slug'),
				'tag_slug' => alsp_getValue($array, 'tag_slug'),
				'listingtypes' => serialize(alsp_getValue($array, 'listingtypes', array())),
				'locations' => serialize(alsp_getValue($array, 'locations', array())),
				'levels' => serialize(alsp_getValue($array, 'levels', array())),
		);
		$insert_update_args = apply_filters('alsp_directory_create_edit_args', $insert_update_args, $array);
	
		if ($wpdb->update($wpdb->alsp_directories, $insert_update_args, array('id' => $directory_id), null, array('%d')) !== false) {
			do_action('alsp_update_directory', $directory_id, $array);
			
			$this->getDirectoriesFromDB();
			return true;
		}
	}
	
	public function deleteDirectory($directory_id, $new_directory_id) {
		global $alsp_instance, $wpdb;

		// We can not delete default directory
		if ($directory_id != $this->getDefaultDirectory()->id) {
			$wpdb->delete($wpdb->alsp_directories, array('id' => $directory_id));
			
			if (!$alsp_instance->directories->getDirectoryById($new_directory_id)) {
				$new_directory_id = $alsp_instance->directories->getDefaultDirectory()->id;
			}
			$wpdb->update($wpdb->postmeta, array('meta_value' => $new_directory_id), array('meta_key' => '_directory_id', 'meta_value' => $directory_id));
	
			$this->getDirectoriesFromDB();
			return true;
		}
	}
	
	public function getDirectoryOfPage($page_id = 0) {
		$current_directory = null;

		$pattern = get_shortcode_regex(array('alsp-main'));
		if ($page_id && ($page = get_post($page_id))) {
			if (preg_match_all('/'.$pattern.'/s', $page->post_content, $matches) && array_key_exists(2, $matches)) {
				foreach ($matches[2] AS $key=>$shortcode) {
					if ($shortcode == 'alsp-main') {
						if (($attrs = shortcode_parse_atts($matches[3][$key]))) {
							if (isset($attrs['id']) && is_numeric($attrs['id']) && ($directory = $this->getDirectoryById($attrs['id']))) {
								$current_directory = $directory;
								break;
							} elseif (!isset($attrs['id'])) {
								$current_directory = $this->getDefaultDirectory();
								break;
							}
						} else {
							$current_directory = $this->getDefaultDirectory();
							break;
						}
					}
				}
			}
		} else {
			$current_directory = $this->getDefaultDirectory();
		}
		
		return $current_directory;
	}
}

class alsp_directory {
	public $id;
	public $url;
	public $name;
	public $single;
	public $plural;
	public $listing_slug;
	public $category_slug;
	public $listingtype_slug;
	public $location_slug;
	public $tag_slug;
	public $categories = array();
	public $listingtypes = array();
	public $locations = array();
	public $levels = array();
	
	public function __construct() {
		$this->listing_slug = get_option('alsp_listing_slug');
		$this->category_slug = get_option('alsp_category_slug');
		$this->listingtype_slug = get_option('alsp_listingtype_slug');
		$this->location_slug = get_option('alsp_location_slug');
		$this->tag_slug = get_option('alsp_tag_slug');
	}

	public function buildDirectoryFromArray($array) {
		$this->id = alsp_getValue($array, 'id');
		$this->name = alsp_getValue($array, 'name');
		$this->single = alsp_getValue($array, 'single');
		$this->plural = alsp_getValue($array, 'plural');
		$this->listing_slug = alsp_getValue($array, 'listing_slug');
		$this->category_slug = alsp_getValue($array, 'category_slug');
		$this->listingtype_slug = alsp_getValue($array, 'listingtype_slug');
		$this->location_slug = alsp_getValue($array, 'location_slug');
		$this->tag_slug = alsp_getValue($array, 'tag_slug');
		$this->categories = alsp_getValue($array, 'categories');
		$this->listingtypes = alsp_getValue($array, 'listingtypes');
		$this->locations = alsp_getValue($array, 'locations');
		$this->levels = alsp_getValue($array, 'levels');
		
		$this->convertCategories();
		$this->convertListingTypes();
		$this->convertLocations();
		$this->convertLevels();
		
		apply_filters('alsp_directories_loading', $this, $array);
	}
	
	public function convertCategories() {
		if ($this->categories) {
			$unserialized_categories = maybe_unserialize($this->categories);
			if (count($unserialized_categories) > 1 || $unserialized_categories != array(''))
				$this->categories = $unserialized_categories;
			else
				$this->categories = array();
		} else
			$this->categories = array();
		return $this->categories;
	}
	
	public function convertListingTypes() {
		if ($this->listingtypes) {
			$unserialized_listingtypes = maybe_unserialize($this->listingtypes);
			if (count($unserialized_listingtypes) > 1 || $unserialized_listingtypes != array(''))
				$this->listingtypes = $unserialized_listingtypes;
			else
				$this->listingtypes = array();
		} else
			$this->listingtypes = array();
		return $this->listingtypes;
	}

	public function convertLocations() {
		if ($this->locations) {
			$unserialized_locations = maybe_unserialize($this->locations);
			if (count($unserialized_locations) > 1 || $unserialized_locations != array(''))
				$this->locations = $unserialized_locations;
			else
				$this->locations = array();
		} else
			$this->locations = array();
		return $this->locations;
	}

	public function convertLevels() {
		if ($this->levels) {
			$unserialized_levels = maybe_unserialize($this->levels);
			if (count($unserialized_levels) > 1 || $unserialized_levels != array(''))
				$this->levels = $unserialized_levels;
			else
				$this->levels = array();
		} else
			$this->levels = array();
		return $this->levels;
	}
	
	/**
	 * this is required to have an URL in advance in 'init' hook
	 * 
	 * @return string
	 */
	public function setAdvanceURL() {
		global $alsp_instance;
		
		$pattern = get_shortcode_regex(array('alsp-main'));

		foreach ($alsp_instance->index_pages_all AS $index_page) {
			$page_obj = get_post($index_page['id']);
			if (preg_match_all('/'.$pattern.'/s', $page_obj->post_content, $matches) && array_key_exists(2, $matches)) {
				foreach ($matches[2] AS $key=>$shortcode) {
					if ($shortcode == 'alsp-main') {
						if ($attrs = shortcode_parse_atts($matches[3][$key])) {
							if (isset($attrs['id']) && is_numeric($attrs['id']) && $this->id == $attrs['id']) {
								$this->url = get_permalink($page_obj);
							} elseif (!isset($attrs['id']) && $this->id == $alsp_instance->directories->getDefaultDirectory()->id) {
								$this->url = get_permalink($page_obj);
							}
						} elseif ($this->id == $alsp_instance->directories->getDefaultDirectory()->id) {
							$this->url = get_permalink($page_obj);
						}
					}
				}
			}
		}

		return $this->url;
	}

	/**
	 * this will give complete URL of directory after current Directory was loaded,
	 * will run in 'wp' hook
	 * 
	 * @return string
	 */
	public function setDirectoryURL() {
		global $alsp_instance;
		
		// it is possible to have some pages with same [alsp-main] shortcodes,
		// URL of the current page has priority, so we will try to catch current page to build correct links
		$possible_url = '';
		$current_page_url = '';
	
		$pattern = get_shortcode_regex(array('alsp-main'));
	
		foreach ($alsp_instance->index_pages_all AS $index_page) {
			$page_obj = get_post($index_page['id']);
			if (preg_match_all('/'.$pattern.'/s', $page_obj->post_content, $matches) && array_key_exists(2, $matches)) {
				foreach ($matches[2] AS $key=>$shortcode) {
					if ($shortcode == 'alsp-main') {
						if (
							$alsp_instance->current_directory &&
							$this->id == $alsp_instance->current_directory->id &&
							$page_obj->ID == $alsp_instance->index_page_id &&
							($directory_of_page = $alsp_instance->directories->getDirectoryOfPage($page_obj->ID)) && 
							$this->id == $directory_of_page->id
						) {
							$current_page_url = get_permalink($page_obj);
							break;
							break;
						}
						if ($attrs = shortcode_parse_atts($matches[3][$key])) {
							if (isset($attrs['id']) && is_numeric($attrs['id']) && $this->id == $attrs['id']) {
								$possible_url = get_permalink($page_obj);
							} elseif (!isset($attrs['id']) && $this->id == $alsp_instance->directories->getDefaultDirectory()->id) {
								$possible_url = get_permalink($page_obj);
							}
						} elseif ($this->id == $alsp_instance->directories->getDefaultDirectory()->id) {
							$possible_url = get_permalink($page_obj);
						}
					}
				}
			}
		}

		if ($current_page_url) {
			$this->url = $current_page_url;
		} elseif ($possible_url) {
			$this->url = $possible_url;
		}

		return $this->url;
	}
}

// adapted for WPML
add_action('init', 'alsp_directories_names_into_strings');
function alsp_directories_names_into_strings() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		foreach ($alsp_instance->directories->directories_array AS &$directory) {
			$directory->single = apply_filters('wpml_translate_single_string', $directory->single, 'Ads Listing System', 'Single item of directory #' . $directory->id);
			$directory->plural = apply_filters('wpml_translate_single_string', $directory->plural, 'Ads Listing System', 'Plural item of directory #' . $directory->id);
		}
	}
}

add_filter('alsp_level_create_edit_args', 'alsp_filter_directory_categories_locations_types', 10, 2);
function alsp_filter_directory_categories_locations_types($insert_update_args, $array) {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['directory_id'])) {
				$directory_id = $_GET['directory_id'];
				if ($single_string_id = icl_st_is_registered_string('Ads Listing System', 'Single item of directory #' . $directory_id))
					icl_add_string_translation($single_string_id, ICL_LANGUAGE_CODE, $insert_update_args['single'], ICL_TM_COMPLETE);
				if ($plural_string_id = icl_st_is_registered_string('Ads Listing System', 'Plural item of directory #' . $directory_id))
					icl_add_string_translation($plural_string_id, ICL_LANGUAGE_CODE, $insert_update_args['plural'], ICL_TM_COMPLETE);
				unset($insert_update_args['single']);
				unset($insert_update_args['plural']);
				
				unset($insert_update_args['categories']);
				unset($insert_update_args['listingtypes']);
				unset($insert_update_args['locations']);
			} else { 
				$insert_update_args['categories'] = '';
				$insert_update_args['listingtypes'] = '';
				$insert_update_args['locations'] = '';
			}
		}
	}
	return $insert_update_args;
}

add_action('alsp_update_directory', 'alsp_save_directory_categories_locations_types', 10, 2);
function alsp_save_directory_categories_locations_types($directory_id, $array) {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			update_option('alsp_wpml_directory_categories_'.$directory_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'categories'));
			update_option('alsp_wpml_directory_listingtypes_'.$directory_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'listingtypes'));
			update_option('alsp_wpml_directory_locations_'.$directory_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'locations'));
		}
		
		if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {
			do_action('wpml_register_single_string', 'Ads Listing System', 'Single item of directory #' . $directory_id, alsp_getValue($array, 'single'));
			do_action('wpml_register_single_string', 'Ads Listing System', 'Plural item of directory #' . $directory_id, alsp_getValue($array, 'plural'));
		}
	}
}
	
add_action('init', 'alsp_load_directory_categories_locations_types');
function alsp_load_directory_categories_locations_types() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			foreach ($alsp_instance->directories->directories_array AS &$directory) {
				$_categories = get_option('alsp_wpml_directory_categories_'.$directory->id.'_'.ICL_LANGUAGE_CODE);
				$_listingtypes = get_option('alsp_wpml_directory_listingtypes_'.$directory->id.'_'.ICL_LANGUAGE_CODE);
				$_locations = get_option('alsp_wpml_directory_locations_'.$directory->id.'_'.ICL_LANGUAGE_CODE);
				if ($_categories && (count($_categories) > 1 || $_categories != array(''))){
					$directory->categories = $_categories;
				}else{
					$directory->categories = array();
				}
				if ($_listingtypes && (count($_listingtypes) > 1 || $_listingtypes != array(''))){
					$directory->listingtypes = $_listingtypes;
				}else{
					$directory->listingtypes = array();
				}
				if ($_locations && (count($_locations) > 1 || $_locations != array('')))
					$directory->locations = $_locations;
				else
					$directory->locations = array();
			}
		}
	}
}

?>