<?php
/**
 * Plugin Name: Ads Listing System Plugin
 * Plugin URI:  https://help.designinvento.net/
 * Description: Provides an ability to build any kind of directory site: classifieds, events directory, cars, bikes, boats and other vehicles dealers site, pets, real estate portal on your WordPress powered site. In other words - whatever you want.
 * Version: 	2.1.11
 * Author:      Designinvento
 * Author URI: 	https://designinvento.net
 * License:  	GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ALSP
 * Domain Path: /languages
 */

define('ALSP_VERSION', '2.0.3');

define('ALSP_PATH', plugin_dir_path(__FILE__));
define('ALSP_URL', plugins_url('/', __FILE__));

define('ALSP_TEMPLATES_PATH', ALSP_PATH . 'public/');

define('ALSP_RESOURCES_PATH', ALSP_PATH . 'assets/');
define('ALSP_RESOURCES_URL', ALSP_URL . 'assets/');
define('ALSP_POST_TYPE', 'alsp_listing');
define('ALSP_CATEGORIES_TAX', 'alsp-category');
define('ALSP_LOCATIONS_TAX', 'alsp-location');
define('ALSP_TYPE_TAX', 'alsp-type');

define('ALSP_TAGS_TAX', 'alsp-tag');


$ALSP_ADIMN_SETTINGS = get_option('alsp_admin_settings');
global $ALSP_ADIMN_SETTINGS;

include_once ALSP_PATH . 'includes/install.php';
include_once ALSP_PATH . 'includes/update.php';
include_once ALSP_PATH . 'alsp-panel/alsp-panel-admin.php';
include_once ALSP_PATH . 'alsp-panel/index.php';
include_once ALSP_PATH . 'includes/alsp_admin.php';
include_once ALSP_PATH . 'includes/alsp_form_validation.php';
include_once ALSP_PATH . 'includes/post.php';
include_once ALSP_PATH . 'includes/alsp-adverts/alsp_class_main_adverts.php';
include_once ALSP_PATH . 'includes/alsp-adverts/alsp_class_adverts.php';
include_once ALSP_PATH . 'includes/alsp-adverts/alsp_class_adverts_packages.php';
include_once ALSP_PATH . 'includes/alsp_class_category.php';
include_once ALSP_PATH . 'includes/alsp_class_type.php';
include_once ALSP_PATH . 'includes/alsp_class_media.php';
include_once ALSP_PATH . 'includes/alsp-fields/alsp_class_main_fields.php';
include_once ALSP_PATH . 'includes/alsp-fields/alsp_class_fields.php';
include_once ALSP_PATH . 'includes/alsp-locations/alsp_class_main_locations.php';
include_once ALSP_PATH . 'includes/alsp-locations/alsp_class_main_locations_levels.php';
include_once ALSP_PATH . 'includes/alsp-locations/alsp_class_locations_levels.php';
include_once ALSP_PATH . 'includes/alsp-locations/alsp_class_location.php';
include_once ALSP_PATH . 'includes/alsp-packages/alsp_class_main_packages.php';
include_once ALSP_PATH . 'includes/alsp-packages/alsp_class_packages.php';
include_once ALSP_PATH . 'includes/alsp-directories/alsp_class_main_directories.php';
include_once ALSP_PATH . 'includes/alsp-directories/alsp_class_directories.php';
include_once ALSP_PATH . 'includes/alsp_class_public_control.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_main_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_adverts_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_map_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_categories_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_listingtype_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_locations_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_search_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_slider_shortcode.php';
include_once ALSP_PATH . 'includes/alsp-shortcodes/alsp_buttons_shortcode.php';
include_once ALSP_PATH . 'includes/alsp_class_ajax.php';
include_once ALSP_PATH . 'includes/settings_manager.php';
include_once ALSP_PATH . 'includes/alsp-maps/alsp_maps.php';
include_once ALSP_PATH . 'includes/alsp-maps/alsp_gm_styles.php';
include_once ALSP_PATH . 'includes/alsp_filters.php';
include_once ALSP_PATH . 'includes/alsp_class_buttons.php';
include_once ALSP_PATH . 'includes/alsp_class_csv.php';
include_once ALSP_PATH . 'includes/alsp_class_geoname.php';
include_once ALSP_PATH . 'includes/alsp_class_search.php';
include_once ALSP_PATH . 'includes/alsp-search-fields/alsp_class_fields.php';
include_once ALSP_PATH . 'includes/alsp-terms/alsp_class_terms.php';
include_once ALSP_PATH . 'includes/alsp_functions.php';
include_once ALSP_PATH . 'includes/alsp_functions_public.php';
include_once ALSP_PATH . 'includes/alsp_vc_config.php';
include_once ALSP_PATH . 'includes/alsp_svg.php';
add_action('after_setup_theme', 'widget_include');
function widget_include(){
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_widget.php';
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_categories.php';
	//include_once ALSP_PATH . 'includes/alsp-widgets/alsp_listingtype.php';
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_locations.php';
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_adverts.php';
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_search.php';
	include_once ALSP_PATH . 'includes/alsp-widgets/alsp_general_widgets.php';
}
// Categories icons constant
if ($custom_dir = alsp_isCustomResourceDir('images/categories_icons/')) {
	define('ALSP_CATEGORIES_ICONS_PATH', $custom_dir);
	define('ALSP_CATEGORIES_ICONS_URL', alsp_getCustomResourceDirURL('images/categories_icons/'));
} else {
	define('ALSP_CATEGORIES_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/categories_icons/');
	define('ALSP_CATEGORIES_ICONS_URL', ALSP_RESOURCES_URL . 'images/categories_icons/');
}

// Listing Types icons constant
if ($custom_dir = alsp_isCustomResourceDir('images/listingtype_icons/')) {
	define('ALSP_LISTINGTYPE_ICONS_PATH', $custom_dir);
	define('ALSP_LISTINGTYPE_ICONS_URL', alsp_getCustomResourceDirURL('images/listingtype_icons/'));
} else {
	define('ALSP_LISTINGTYPE_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/listingtype_icons/');
	define('ALSP_LISTINGTYPE_ICONS_URL', ALSP_RESOURCES_URL . 'images/listingtype_icons/');
}

// Locations icons constant
if ($custom_dir = alsp_isCustomResourceDir('images/locations_icons/')) {
	define('ALSP_LOCATION_ICONS_PATH', $custom_dir);
	define('ALSP_LOCATIONS_ICONS_URL', alsp_getCustomResourceDirURL('images/locations_icons/'));
} else {
	define('ALSP_LOCATION_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/locations_icons/');
	define('ALSP_LOCATIONS_ICONS_URL', ALSP_RESOURCES_URL . 'images/locations_icons/');
}

// Map Markers Icons Path
if ($custom_dir = alsp_isCustomResourceDir('images/map_icons/')) {
	define('ALSP_MAP_ICONS_PATH', $custom_dir);
	define('ALSP_MAP_ICONS_URL', alsp_getCustomResourceDirURL('images/map_icons/'));
} else {
	define('ALSP_MAP_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/map_icons/');
	define('ALSP_MAP_ICONS_URL', ALSP_RESOURCES_URL . 'images/map_icons/');
}

global $alsp_instance;
global $alsp_messages;
define('ALSP_MAIN_SHORTCODE', 'alsp-main');
define('ALSP_LISTING_SHORTCODE', 'alsp-listing');

/*
 * There are 2 types of shortcodes in the system:
 1. those process as simple wordpress shortcodes
 2. require initialization on 'wp' hook
 
 [alsp] shortcode must be initialized on 'wp' hook and then renders as simple shortcode
 */
global $alsp_shortcodes, $alsp_shortcodes_init;
$alsp_shortcodes = array(
		ALSP_MAIN_SHORTCODE => 'alsp_directory_controller',
		ALSP_LISTING_SHORTCODE => 'alsp_directory_controller', // listings page
		'alsp-listing' => 'alsp_directory_controller',
		'alsp-listings' => 'alsp_listings_controller',
		'alsp-map' => 'alsp_map_controller',
		'alsp-categories' => 'alsp_categories_controller',
		'alsp-listingtypes' => 'alsp_listingtype_controller',
		'alsp-locations' => 'alsp_locations_controller',
		'alsp-search' => 'alsp_search_controller',
		'alsp-slider' => 'alsp_slider_controller',
		'alsp-buttons' => 'alsp_buttons_controller',
);
$alsp_shortcodes_init = array(
		ALSP_MAIN_SHORTCODE => 'alsp_directory_controller',
		ALSP_LISTING_SHORTCODE => 'alsp_directory_controller', // listings page
		'alsp-listing' => 'alsp_directory_controller', // one single listing by ID, compatibility with previous versions
		'alsp-listings' => 'alsp_listings_controller', // remove in free version
);

class alsp_plugin {
	public $admin;
	public $listings_manager;
	public $locations_manager;
	public $locations_levels_manager;
	public $categories_manager;
	public $listingtype_manager;
	public $content_fields_manager;
	public $media_manager;
	public $settings_manager;
	public $directories_manager; // remove in free version
	public $demo_data_manager;
	public $levels_manager;
	public $csv_manager;
	public $updater; // remove in free version

	public $current_directory = null;
	public $directories;
	public $current_listing; // this is object of listing under edition right now
	public $levels;
	public $locations_levels;
	public $content_fields;
	public $search_fields;
	public $ajax_controller;
	public $index_page_id;
	public $index_page_slug;
	public $index_page_url;
	public $index_pages_all = array();
	public $listing_pages_all = array();
	public $original_index_page_id;
	public $listing_page_id;
	public $listing_page_slug;
	public $listing_page_url;
	public $public_controls = array();
	public $_public_controls = array(); // this duplicate property needed because we unset each controller when we render shortcodes, but WP doesn't really know which shortcode already was processed
	public $action;
	
	public $radius_values_array = array();
	
	public $order_by_date = false; // special flag, used to display or hide sticky pin
	
	
	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activation'));
		register_deactivation_hook(__FILE__, array($this, 'deactivation'));
		
	}
	
	public function activation() {
		global $wp_version;

		if (version_compare($wp_version, '3.6', '<')) {
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
			wp_die("Sorry, but you can't run this plugin on current WordPress version, it requires WordPress v3.6 or higher.");
		}
		flush_rewrite_rules();
		
		wp_schedule_event(current_time('timestamp'), 'hourly', 'scheduled_events');
	}

	public function deactivation() {
		flush_rewrite_rules();

		wp_clear_scheduled_hook('scheduled_events');
	}
	
	public function init() {
		global $alsp_instance, $alsp_shortcodes, $alsp_google_maps_styles, $wpdb;

		if (isset($_REQUEST['alsp_action'])) {
			$this->action = $_REQUEST['alsp_action'];
		}

		add_action('plugins_loaded', array($this, 'load_textdomains'));

		if (!isset($wpdb->alsp_content_fields))
			$wpdb->alsp_content_fields = $wpdb->prefix . 'alsp_content_fields';
		if (!isset($wpdb->alsp_content_fields_groups))
			$wpdb->alsp_content_fields_groups = $wpdb->prefix . 'alsp_content_fields_groups';
		if (!isset($wpdb->alsp_directories))
			$wpdb->alsp_directories = $wpdb->prefix . 'alsp_directories';
		if (!isset($wpdb->alsp_levels))
			$wpdb->alsp_levels = $wpdb->prefix . 'alsp_levels';
		if (!isset($wpdb->alsp_levels_relationships))
			$wpdb->alsp_levels_relationships = $wpdb->prefix . 'alsp_levels_relationships';
		if (!isset($wpdb->alsp_locations_levels))
			$wpdb->alsp_locations_levels = $wpdb->prefix . 'alsp_locations_levels';
		if (!isset($wpdb->alsp_locations_relationships))
			$wpdb->alsp_locations_relationships = $wpdb->prefix . 'alsp_locations_relationships';

		add_action('sheduled_events', array($this, 'suspend_expired_listings'));
		
		foreach ($alsp_shortcodes AS $shortcode=>$function) {
			add_shortcode($shortcode, array($this, 'renderShortcode'));
		}
		
		add_action('init', array($this, 'register_post_type'), 0);
		add_action('init', array($this, 'getAllDirectoryPages'), 1);
		add_action('wp', array($this, 'loadPagesDirectories'), 1);
		add_action('admin_init', array($this, 'loadPagesDirectories'), 1);
		add_action('init', array($this, 'checkMainShortcode'), 0);
		//add_filter('body_class', array($this, 'addBodyClasses'));
		
		add_action('wp', array($this, 'loadFrontendControllers'), 1);

		// needs workaround, sheduled_events not working
		add_action('wp', array($this, 'suspend_expired_listings_call'), 1);
		
		if (!get_option('alsp_installed_directory') || get_option('alsp_installed_directory_version') != ALSP_VERSION) {
			// load classes ONLY after directory was fully installed, otherwise it can not get directories, levels, content fields, e.t.c. from the database
			if (get_option('alsp_installed_directory')) {
				$this->loadClasses();
			}

			add_action('init', 'alsp_install_directory', 0);
		} else {
			$this->loadClasses();
		}
		
		add_filter('template_include', array($this, 'printlisting_template'), 100000);

		add_action('wp', array($this, 'wp_loaded'));
		add_filter('query_vars', array($this, 'add_query_vars'));
		add_filter('rewrite_rules_array', array($this, 'rewrite_rules'));
		
		add_filter('redirect_canonical', array($this, 'prevent_wrong_redirect'), 10, 2);
		add_filter('post_type_link', array($this, 'listing_permalink'), 10, 3);
		add_filter('term_link', array($this, 'category_permalink'), 10, 3);
		add_filter('term_link', array($this, 'listingtype_permalink'), 10, 3);
		add_filter('term_link', array($this, 'location_permalink'), 10, 3);
		add_filter('term_link', array($this, 'tag_permalink'), 10, 3);
		
		// adapted for Polylang
		add_action('init', array($this, 'pll_setup'));

		add_filter('comments_open', array($this, 'filter_comment_status'), 100, 2);
		
		add_filter('wp_unique_post_slug_is_bad_flat_slug', array($this, 'reserve_slugs'), 10, 2);
		
		add_filter('no_texturize_shortcodes', array($this, 'alsp_no_texturize'));
		
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
		//add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles_custom'), 9999);
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
		
		add_filter('wpseo_sitemap_post_type_archive_link', array($this, 'exclude_post_type_archive_link'), 10, 2);
		
		//add_filter('alsp_dequeue_maps_googleapis', array($this, 'divi_not_dequeue_maps_api'));
		
		//add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
		//add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
		
		$alsp_google_maps_styles = apply_filters('alsp_google_maps_styles', $alsp_google_maps_styles);
		
		add_action('redux/loaded', array($this, 'custom_listing_config'));

	}
	public function custom_listing_config() {
	require_once ALSP_PATH . 'includes/alsp-options.php';
	}
	public function load_textdomains() {
		load_plugin_textdomain('ALSP', '', dirname(plugin_basename( __FILE__ )) . '/languages');
	}
	
	public function loadClasses() {
		global $ALSP_ADIMN_SETTINGS;
		$this->directories = new alsp_directories;
		$this->levels = new alsp_levels;
		$this->locations_levels = new alsp_locations_levels;
		$this->content_fields = new alsp_content_fields;
		$this->search_fields = new alsp_search_fields;
		$this->ajax_controller = new alsp_ajax_controller;
		$this->admin = new alsp_admin();
		$this->listings_packages = new alsp_listings_packages;
		//$this->updater = new alsp_updater(__FILE__, get_option('alsp_access_token'), get_option('alsp_purchase_code'));
	}

	public function alsp_no_texturize($shortcodes) {
		global $alsp_shortcodes;
		
		foreach ($alsp_shortcodes AS $shortcode=>$function)
			$shortcodes[] = $shortcode;
		
		return $shortcodes;
	}

	public function renderShortcode() {
		// Some "genial" themes and plugins can load our shortcodes at the admin part, breaking some important functionality
		if (!is_admin()) {
			global $alsp_shortcodes;
	
			// remove content filters in order not to break the layout of page
			$filters_to_remove = array(
					'wpautop',
					'wptexturize',
					'shortcode_unautop',
					'convert_chars',
					'prepend_attachment',
					'convert_smilies',
			);
			foreach ($filters_to_remove AS $filter) {
				while (($priority = has_filter('the_content', $filter)) !== false) {
					remove_filter('the_content', $filter, $priority);
				}
			}
	
			$attrs = func_get_args();
			$shortcode = $attrs[2];
	
			$filters_where_not_to_display = array(
					'wp_head',
					'init',
					'wp',
					'edit_attachment',
			);
			
			//var_dump(current_filter());
			if (isset($this->_public_controls[$shortcode]) && !in_array(current_filter(), $filters_where_not_to_display)) {
				$shortcode_controllers = $this->_public_controls[$shortcode];
				foreach ($shortcode_controllers AS $key=>&$controller) {
					unset($this->_public_controls[$shortcode][$key]); // there are possible more than 1 same shortcodes on a page, so we have to unset which already was displayed
					if (method_exists($controller, 'display'))
						return $controller->display();
				}
			}
	
			if (isset($alsp_shortcodes[$shortcode])) {
				$shortcode_class = $alsp_shortcodes[$shortcode];
				if ($attrs[0] === '')
					$attrs[0] = array();
				$shortcode_instance = new $shortcode_class();
				$this->public_controls[$shortcode][] = $shortcode_instance;
				$shortcode_instance->init($attrs[0], $shortcode);
	
				if (method_exists($shortcode_instance, 'display'))
					return $shortcode_instance->display();
			}
		}
	}

	public function loadFrontendControllers() {
		global $post, $wp_query;

		if ($wp_query->posts) {
			$pattern = get_shortcode_regex();
			foreach ($wp_query->posts AS $archive_post) {
				if (isset($archive_post->post_content))
					$this->loadNestedFrontendController($pattern, $archive_post->post_content);
			}
		} elseif ($post && isset($post->post_content)) {
			$pattern = get_shortcode_regex();
			$this->loadNestedFrontendController($pattern, $post->post_content);
		}
	}

	// this may be recursive function to catch nested shortcodes
	public function loadNestedFrontendController($pattern, $content) {
		global $alsp_shortcodes_init, $alsp_shortcodes;

		if (preg_match_all('/'.$pattern.'/s', $content, $matches) && array_key_exists(2, $matches)) {
			foreach ($matches[2] AS $key=>$shortcode) {
				if ($shortcode != 'shortcodes') {
					if (isset($alsp_shortcodes_init[$shortcode]) && class_exists($alsp_shortcodes_init[$shortcode])) {
						$shortcode_class = $alsp_shortcodes_init[$shortcode];
						if (!($attrs = shortcode_parse_atts($matches[3][$key])))
							$attrs = array();
						$shortcode_instance = new $shortcode_class();
						$this->public_controls[$shortcode][] = $shortcode_instance;
						$this->_public_controls[$shortcode][] = $shortcode_instance;
						$shortcode_instance->init($attrs, $shortcode);
					} elseif (isset($alsp_shortcodes[$shortcode]) && class_exists($alsp_shortcodes[$shortcode])) {
						$shortcode_class = $alsp_shortcodes[$shortcode];
						$this->public_controls[$shortcode][] = $shortcode_class;
					}
					if ($shortcode_content = $matches[5][$key])
						$this->loadNestedFrontendController($pattern, $shortcode_content);
				}
			}
		}
	}
	
	public function getAllDirectoryPages() {
		$this->index_pages_all = alsp_getAllDirectoryPages();
		$this->listing_pages_all = alsp_getAllListingPages();
	}
	
	public function loadPagesDirectories() {
		$this->getIndexPage();
		$this->setCurrentDirectory();
		
		//$this->suspend_expired_listings();

		do_action('alsp_load_pages_directories');
	}
	
	public function checkMainShortcode() {
		global $ALSP_ADIMN_SETTINGS;
		if ($this->index_page_id === 0 && is_admin()) {
			alsp_addMessage(sprintf(__("<b>Ads Listing System Plugin</b>: sorry, but there isn't any page with [alsp-main] shortcode. This is mandatory page. Create <a href=\"%s\">this special page</a> for you?", 'ALSP'), admin_url('admin.php?page=alsp_settings&action=directory_page_installation')));
		}
		
		if (alsp_is_maps_used() && !$ALSP_ADIMN_SETTINGS['alsp_google_api_key'] && is_admin()) {
			alsp_addMessage(sprintf(__("<b>Ads Listing System Plugin</b>: since 22 June 2016 Google requires mandatory Maps API key for maps created on NEW websites/domains.", 'ALSP'), admin_url('admin.php?page=alsp_settings#_advanced')));
		}
	}

	public function getIndexPage() {
		if ($array = alsp_getIndexPage()) {
			$this->index_page_id = $array['id'];
			$this->index_page_slug = $array['slug'];
			$this->index_page_url = $array['url'];
		}
		
		if ($array = alsp_getListingPage()) {
			$this->listing_page_id = $array['id'];
			$this->listing_page_slug = $array['slug'];
			$this->listing_page_url = $array['url'];
		}
	}
	
	public function suspend_expired_listings_call() {
		$this->suspend_expired_listings();
	}
	
	public function setCurrentDirectory($current_directory = null) {
		global $pagenow;

		if (isset($_GET['directory']) && is_numeric($_GET['directory']) && ($directory = $this->directories->getDirectoryById($_GET['directory']))) {
			$current_directory = $directory;
		}
		if (is_admin() && $pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == ALSP_POST_TYPE && isset($_GET['directory_id']) && is_numeric($_GET['directory_id']) && ($directory = $this->directories->getDirectoryById($_GET['directory_id']))) {
			$current_directory = $directory;
		}

		if (!$current_directory && $this->public_controls && ($listing = alsp_isListing())) {
			$current_directory = $listing->directory;
		}

		if (!$current_directory && get_query_var('directory-alsp')) {
			$current_directory = $this->directories->getDirectoryById(get_query_var('directory-alsp'));
		}

		if (!$current_directory) {
			// If current page is not alsp index page, then pass, and make current directory = default directory
			if (($this->index_page_id == get_queried_object_id()) || (wp_doing_ajax() && $this->isAJAXIndexPage()) ) {
				$current_directory = $this->directories->getDirectoryOfPage($this->index_page_id);
			}
		}
		if (!$current_directory) {
			$current_directory = $this->directories->getDefaultDirectory();
		}
		return ($this->current_directory = $current_directory);
	}
	
	public function isAJAXIndexPage() {
		global $wp_rewrite;

		if ($wp_rewrite->using_permalinks()) {
			if (isset($_REQUEST['base_url'])) {
				$base_url = $_REQUEST['base_url'];
				if (strtok($base_url, '?') == $this->index_page_url) {
					return true;
				}
			}
		} else {
			if (
				isset($_REQUEST['base_url']) && 
				($base_url = wp_parse_args($_REQUEST['base_url'])) &&
				isset($base_url['homepage']) &&
				$base_url['homepage'] == $this->index_page_id
			) {
				return true;
			}
		}
		return false;
	}
	
	public function addBodyClasses($classes) {
		$classes[] = 'alsp-body';
		
		if (!empty($this->public_controls)) {
			$classes[] = 'alsp-directory-' . $this->current_directory->id;
		}
		
		return $classes;
	}
	
	public function add_query_vars($vars) {
		$vars[] = 'directory-alsp';
		$vars[] = 'listing-alsp';
		$vars[] = 'category-alsp';
		$vars[] = 'listingtype-alsp';
		$vars[] = 'location-alsp';
		$vars[] = 'tag-alsp';
		$vars[] = 'tax-slugs-alsp';
		$vars[] = 'homepage';

		if (!is_admin()) {
			// order query var may damage sorting of listings at the frontend - it shows WP posts instead of directory listings
			$key = array_search('order', $vars);
			unset($vars[$key]);
		}

		return $vars;
	}
	
	public function rewrite_rules($rules) {
		return $this->alsp_addRules() + $rules;
	}
	
	public function alsp_addRules() {
		$rules = array();
		foreach ($this->index_pages_all AS $page) {
			$this->index_page_id = $page['id'];
			$this->index_page_slug = $page['slug'];
			$this->index_page_url = get_permalink($page['id']);
				
			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress && ($languages = $sitepress->get_active_languages()) && count($languages) > 1) {
				$this->original_index_page_id = $this->index_page_id;
				//$this->original_listing_page_id = $this->listing_page_id;
				foreach ($languages AS $lang_code=>$lang) {
					if ($this->index_page_id = apply_filters('wpml_object_id', $this->original_index_page_id, 'page', false, $lang_code)) {
						$post = get_post($this->index_page_id);
						$this->index_page_slug = $post->post_name;
						//$this->listing_page_id = apply_filters('wpml_object_id', $original_listing_page_id, 'page', true, $lang_code);
	
						$rules = $rules + $this->buildRules($lang_code);
					}
				}
				//$this->getIndexPage();
				//return $rules;
			} else {
				$rules = $rules + $this->buildRules();
			}
		}
		$this->getIndexPage();
		return $rules;
	}
	
	public function buildRules($lang_code = '') {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		// adapted for WPML
		//
		// If it was set to use different languages in directories ((http://wp/ - English, http://wp/it/ - Italian)),
		// WPML removes this directory from home page url and we can not match "language-based" rewrite rule by exact request - 
		// home_url() simply gives path without directory and $wp->parse_request() does not see any difference between language URLs,
		// so we have to build rules "on the fly" for each switching of language.
		// The last chance we might have when alsp-main page could not be home page.
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if (
			$sitepress->get_setting('language_negotiation_type') == 1 &&
			$lang_code != ICL_LANGUAGE_CODE &&
			get_option('show_on_front') != 'posts' &&
			get_option('page_on_front') == $this->original_index_page_id
			) {
				return array();
			}
		}
		
		global $wp_rewrite;

		$lang_param = '';

		// adapted for WPML
		global $sitepress;
		if ($lang_code && function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_setting('language_negotiation_type') == 3 && $lang_code != $sitepress->get_default_language()) {
				//$lang_param = '\?lang=ru';
				$lang_param = '';
				// Need research!  latest version of WPML do not need lang param to be matched with rule, it is not included into request. Example:
				// Request:        listing/united-states-ru/california-ru/los-angeles-ru/super-shopping-in-la
				// Matched Rule:   (directory-classifieds-it)?/?listing/(.+?)/([^\/.]+)/?$
			}
		}

		$page_url = $this->index_page_slug;

		foreach (get_post_ancestors($this->index_page_id) AS $parent_id) {
			$parent = get_page($parent_id);
			$page_url = $parent->post_name . '/' . $page_url;
		}
		
		$rules['(' . $page_url . ')/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&paged=$matches[2]';
		$rules['(' . $page_url . ')/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id;
		
		$category_page_id = $this->index_page_id;
		$listingtype_page_id = $this->index_page_id;
		$location_page_id = $this->index_page_id;
		$tag_page_id = $this->index_page_id;

		if (!($directory = $alsp_instance->directories->getDirectoryOfPage($this->index_page_id))) {
			$directory = $alsp_instance->directories->getDefaultDirectory();
		}

		if (isset($this->listing_pages_all[$directory->id])) {
			$listing_page_id = $this->listing_pages_all[$directory->id];
		} elseif (isset($this->listing_pages_all[$this->directories->getDefaultDirectory()->id])) {
			$listing_page_id = $this->listing_pages_all[$this->directories->getDefaultDirectory()->id];
		} else {
			$listing_page_id = $this->index_page_id;
		}
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$listing_page_id = apply_filters('wpml_object_id', $listing_page_id, 'page', true, $lang_code);
		}
		
		$listing_slug = $directory->listing_slug;
		$category_slug = $directory->category_slug;
		$listingtype_slug = $directory->listingtype_slug;
		$location_slug = $directory->location_slug;
		$tag_slug = $directory->tag_slug;

		$rules['(' . $page_url . ')?/?' . $category_slug . '/(.+?)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $category_page_id . '&category-alsp=$matches[2]&paged=$matches[3]';
		$rules['(' . $page_url . ')?/?' . $category_slug . '/(.+?)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $category_page_id . '&category-alsp=$matches[2]&directory-alsp=' . $directory->id;
		
		$rules['(' . $page_url . ')?/?' . $listingtype_slug . '/(.+?)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $listingtype_page_id . '&listingtype-alsp=$matches[2]&paged=$matches[3]';
		$rules['(' . $page_url . ')?/?' . $listingtype_slug . '/(.+?)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $listingtype_page_id . '&listingtype-alsp=$matches[2]&directory-alsp=' . $directory->id;
		
		$rules['(' . $page_url . ')?/?' . $location_slug . '/(.+?)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $location_page_id . '&location-alsp=$matches[2]&paged=$matches[3]';
		$rules['(' . $page_url . ')?/?' . $location_slug . '/(.+?)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $location_page_id . '&location-alsp=$matches[2]&directory-alsp=' . $directory->id;
	
		$rules['(' . $page_url . ')?/?' . $tag_slug . '/([^\/.]+)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $tag_page_id . '&tag-alsp=$matches[2]&paged=$matches[3]';
		$rules['(' . $page_url . ')?/?' . $tag_slug . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $tag_page_id . '&tag-alsp=$matches[2]&directory-alsp=' . $directory->id;

		// here directory ID we will take from post meta
		$rules['(' . $page_url . ')?/?' . $listing_slug . '/(.+?)/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&tax-slugs-alsp=$matches[2]&listing-alsp=$matches[3]';
		$rules['(' . $page_url . ')?/?' . $listing_slug . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[2]';
		
		$rules[$page_url . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[1]';
		if (
			strpos(get_option('permalink_structure'), '/%post_id%/%postname%') === FALSE &&
			strpos(get_option('permalink_structure'), '/%year%/%postname%') === FALSE
		) {
			// /%post_id%/%postname%/ will not work when /%post_id%/%postname%/ or /%year%/%postname%/ was enabled for native WP posts
			// also avoid mismatches with archive pages with /%year%/%monthnum%/ permalinks structure
			$rules['(' . $page_url . ')?/?(?!(?:199[0-9]|20[012][0-9])/(?:0[1-9]|1[012]))([0-9]+)/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[3]';
		}
		
		return $rules;
	}
	
	public function wp_loaded() {
		if ($rules = get_option('rewrite_rules'))
			foreach ($this->alsp_addRules() as $key=>$value) {
				if (!isset($rules[$key]) || $rules[$key] != $value) {
					global $wp_rewrite;
					$wp_rewrite->flush_rules();
					return;
				}
			}
	}
	
	public function prevent_wrong_redirect($redirect_url, $requested_url) {
		
		if ($this->public_controls) {
			// add/remove www. into/from $requested_url when needed
			$user_home = @parse_url(home_url());
			if (!empty($user_home['host'])) {
				if (strpos($user_home['host'], 'www.') === 0) {
					$requested_home = @parse_url($requested_url);
					if (!empty($requested_home['host'])) {
						if (strpos($requested_home['host'], 'www.') !== 0) {
							$requested_url = str_replace($requested_home['host'], 'www.'.$requested_home['host'], $requested_url);
						}
					}
				} else {
					$requested_home = @parse_url($requested_url);
					if (!empty($requested_home['host'])) {
						if (strpos($requested_home['host'], 'www.') === 0) {
							$pos = strpos($requested_url, 'www.');
							$requested_url = substr_replace($requested_url, '', $pos, 4);
						}
					}
				}
			}
			return $requested_url;
		}
	
		return $redirect_url;
	}

	public function listing_permalink($permalink, $post, $leavename) {
		if ($post->post_type == ALSP_POST_TYPE) {
			global $wp_rewrite, $ALSP_ADIMN_SETTINGS;
			if ($wp_rewrite->using_permalinks()) {
				if ($leavename)
					$postname = '%postname%';
				else
					$postname = $post->post_name;

				/* if ($this->current_directory) {
					$listing_slug = $this->current_directory->listing_slug;
				} else {
					$listing_slug = get_option('alsp_listing_slug');
				} */
				$listing_directory = alsp_getListingDirectory($post->ID);
				$listing_slug = $listing_directory->listing_slug;
				
				if (!$listing_directory->url)
					return false;

				switch ($ALSP_ADIMN_SETTINGS['alsp_permalinks_structure']) {
					case 'post_id':
						return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
						break;
					case 'postname':
						if (get_option('page_on_front') == $this->index_page_id)
							return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
						else
							return alsp_directoryUrl($postname, $listing_directory);
						break;
					case 'listing_slug':
						if ($listing_slug)
							return alsp_directoryUrl($listing_slug . '/' . $postname, $listing_directory);
						else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
							else
								return alsp_directoryUrl($postname, $listing_directory);
						break;
					case 'category_slug':
						if ($listing_slug && ($terms = get_the_terms($post->ID, ALSP_CATEGORIES_TAX))) {
							$term = array_shift($terms);
							if ($cur_term = alsp_get_term_by_path(get_query_var('category-alsp'))) {
								foreach ($terms AS $lterm) {
									$term_path_ids = alsp_get_term_parents_ids($lterm->term_id, ALSP_CATEGORIES_TAX);
									if ($cur_term->term_id == $lterm->term_id) { $term = $lterm; break; }  // exact term much more better
									if (in_array($cur_term->term_id, $term_path_ids)) { $term = $lterm; break; }
								}
							}
							$uri = '';
							if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_CATEGORIES_TAX))
								$uri = implode('/', $parents);
							return alsp_directoryUrl($listing_slug . '/' . $uri . '/' . $postname, $listing_directory);
						} else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
							else
								return alsp_directoryUrl($postname, $listing_directory);
						break;
					case 'listingtype_slug':
						if ($listing_slug && ($terms = get_the_terms($post->ID, ALSP_TYPE_TAX))) {
							$term = array_shift($terms);
							if ($cur_term = alsp_get_term_by_path(get_query_var('listingtype-alsp'))) {
								foreach ($terms AS $lterm) {
									$term_path_ids = alsp_get_term_parents_ids($lterm->term_id, ALSP_TYPE_TAX);
									if ($cur_term->term_id == $lterm->term_id) { $term = $lterm; break; }  // exact term much more better
									if (in_array($cur_term->term_id, $term_path_ids)) { $term = $lterm; break; }
								}
							}
							$uri = '';
							if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_TYPE_TAX))
								$uri = implode('/', $parents);
							return alsp_directoryUrl($listing_slug . '/' . $uri . '/' . $postname, $listing_directory);
						} else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
							else
								return alsp_directoryUrl($postname, $listing_directory);
						break;
					case 'location_slug':
						if ($listing_slug && ($terms = get_the_terms($post->ID, ALSP_LOCATIONS_TAX)) && ($term = array_shift($terms))) {
							if ($cur_term = alsp_get_term_by_path(get_query_var('location-alsp'))) {
								foreach ($terms AS $lterm) {
									$term_path_ids = alsp_get_term_parents_ids($lterm->term_id, ALSP_LOCATIONS_TAX);
									if ($cur_term->term_id == $lterm->term_id) { $term = $lterm; break; }  // exact term much more better
									if (in_array($cur_term->term_id, $term_path_ids)) { $term = $lterm; break; }
								}
							}
							$uri = '';
							if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_LOCATIONS_TAX))
								$uri = implode('/', $parents);
							return alsp_directoryUrl($listing_slug . '/' . $uri . '/' . $postname, $listing_directory);
						} else {
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
							else
								return alsp_directoryUrl($postname, $listing_directory);
						}
						break;
					case 'tag_slug':
						if ($listing_slug && ($terms = get_the_terms($post->ID, ALSP_TAGS_TAX)) && ($term = array_shift($terms))) {
							return alsp_directoryUrl($listing_slug . '/' . $term->slug . '/' . $postname, $listing_directory);
						} else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
							else
								return alsp_directoryUrl($postname, $listing_directory);
						break;
					default:
						if (get_option('page_on_front') == $this->index_page_id)
							return alsp_directoryUrl($post->ID . '/' . $postname, $listing_directory);
						else
							return alsp_directoryUrl($postname, $listing_directory);
				}
			} else {
				if ($this->listing_page_url) {
					$listing_page_url = $this->listing_page_url;
				} else {
					$listing_page_url = $this->index_page_url;
				}
					
				return alsp_templatePageUri(array('listing-alsp' => $post->post_name), $listing_page_url);
			}
		}
		return $permalink;
	}

	public function category_permalink($permalink, $category, $tax) {
		if ($tax == ALSP_CATEGORIES_TAX) {
			global $wp_rewrite;
			if ($wp_rewrite->using_permalinks()) {
				/* if ($this->current_directory) {
					$category_slug = $this->current_directory->category_slug;
				} else {
					$category_slug = get_option('alsp_category_slug');
				} */
				global $alsp_directory_flag;
				if ($alsp_directory_flag) {
					$directory = $this->directories->getDirectoryById($alsp_directory_flag);
				} else {
					$directory = alsp_getListingDirectory(get_the_ID());
				}
				$category_slug = $directory->category_slug;

				$uri = '';
				if ($parents = alsp_get_term_parents_slugs($category->term_id, ALSP_CATEGORIES_TAX))
					$uri = implode('/', $parents);
				return alsp_directoryUrl($category_slug . '/' . $uri, $directory);
			} else
				return alsp_templatePageUri(array('category-alsp' => $category->slug), $this->index_page_url);
		}
		return $permalink;
	}
	
	public function listingtype_permalink($permalink, $listingtype, $tax) {
		if ($tax == ALSP_TYPE_TAX) {
			global $wp_rewrite;
			if ($wp_rewrite->using_permalinks()) {
				
				global $alsp_directory_flag;
				if ($alsp_directory_flag) {
					$directory = $this->directories->getDirectoryById($alsp_directory_flag);
				} else {
					$directory = alsp_getListingDirectory(get_the_ID());
				}
				$listingtype_slug = $directory->listingtype_slug;

				$uri = '';
				if ($parents = alsp_get_term_parents_slugs($listingtype->term_id, ALSP_TYPE_TAX))
					$uri = implode('/', $parents);
				return alsp_directoryUrl($listingtype_slug . '/' . $uri, $directory);
			} else
				return alsp_templatePageUri(array('listingtype-alsp' => $listingtype->slug), $this->index_page_url);
		}
		return $permalink;
	}
	
	public function location_permalink($permalink, $location, $tax) {
		if ($tax == ALSP_LOCATIONS_TAX) {
			global $wp_rewrite;
			if ($wp_rewrite->using_permalinks()) {
				/* if ($this->current_directory) {
					$location_slug = $this->current_directory->location_slug;
				} else {
					$location_slug = get_option('alsp_location_slug');
				} */
				global $alsp_directory_flag;
				if ($alsp_directory_flag) {
					$directory = $this->directories->getDirectoryById($alsp_directory_flag);
				} else {
					$directory = alsp_getListingDirectory(get_the_ID());
				}
				$location_slug = $directory->location_slug;

				$uri = '';
				if ($parents = alsp_get_term_parents_slugs($location->term_id, ALSP_LOCATIONS_TAX))
					$uri = implode('/', $parents);
				return alsp_directoryUrl($location_slug . '/' . $uri, $directory);
			} else
				return alsp_templatePageUri(array('location-alsp' => $location->slug), $this->index_page_url);
		}
		return $permalink;
	}

	public function tag_permalink($permalink, $tag, $tax) {
		if ($tax == ALSP_TAGS_TAX) {
			global $wp_rewrite;
			if ($wp_rewrite->using_permalinks()) {
				/* if ($this->current_directory) {
					$tag_slug = $this->current_directory->tag_slug;
				} else {
					$tag_slug = get_option('alsp_tag_slug');
				} */
				$directory = alsp_getListingDirectory(get_the_ID());
				$tag_slug = $directory->tag_slug;

				return alsp_directoryUrl($tag_slug . '/' . $tag->slug, $directory);
			} else {
				return alsp_templatePageUri(array('tag-alsp' => $tag->slug), $this->index_page_url);
			}
		}
		return $permalink;
	}
	
	public function reserve_slugs($is_bad_flat_slug, $slug) {
		$slugs_to_check = array();
		foreach ($this->directories->directories_array AS $directory) {
			$slugs_to_check[] = $directory->listing_slug;
			$slugs_to_check[] = $directory->category_slug;
			$slugs_to_check[] = $directory->listingtype_slug;
			$slugs_to_check[] = $directory->location_slug;
			$slugs_to_check[] = $directory->tag_slug;
		}

		if (in_array($slug, $slugs_to_check))
			return true;
		return $is_bad_flat_slug;
	}

	public function register_post_type() {
		global $ALSP_ADIMN_SETTINGS;
		$args = array(
			'labels' => array(
				'name' => __('Listings', 'ALSP'),
				'singular_name' => __('Listing', 'ALSP'),
				'add_new' => __('Create new listing', 'ALSP'),
				'add_new_item' => __('Create new listing', 'ALSP'),
				'edit_item' => __('Edit listing', 'ALSP'),
				'new_item' => __('New listing', 'ALSP'),
				'view_item' => __('View listing', 'ALSP'),
				'search_items' => __('Search listings', 'ALSP'),
				'not_found' =>  __('No listings found', 'ALSP'),
				'not_found_in_trash' => __('No listings found in trash', 'ALSP')
			),
			'has_archive' => true,
			'description' => __('Listings', 'ALSP'),
			'public' => true,
			'exclude_from_search' => false, // this must be false otherwise it breaks pagination for custom taxonomies
			'supports' => array('title', 'author', 'comments'),
			'menu_icon' => ALSP_RESOURCES_URL . 'images/menuicon.png',
		);
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_description'])
			$args['supports'][] = 'editor';
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_summary'])
			$args['supports'][] = 'excerpt';
		register_post_type(ALSP_POST_TYPE, $args);
		
		register_taxonomy(ALSP_CATEGORIES_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => true,
				'has_archive' => true,
				'labels' => array(
					'name' =>  __('Listing categories', 'ALSP'),
					'menu_name' =>  __('Listing categories', 'ALSP'),
					'singular_name' => __('Category', 'ALSP'),
					'add_new_item' => __('Create category', 'ALSP'),
					'new_item_name' => __('New category', 'ALSP'),
					'edit_item' => __('Edit category', 'ALSP'),
					'view_item' => __('View category', 'ALSP'),
					'update_item' => __('Update category', 'ALSP'),
					'search_items' => __('Search categories', 'ALSP'),
				),
			)
		);
		register_taxonomy(ALSP_LOCATIONS_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => true,
				'has_archive' => true,
				'labels' => array(
					'name' =>  __('Listing locations', 'ALSP'),
					'menu_name' =>  __('Listing locations', 'ALSP'),
					'singular_name' => __('Location', 'ALSP'),
					'add_new_item' => __('Create location', 'ALSP'),
					'new_item_name' => __('New location', 'ALSP'),
					'edit_item' => __('Edit location', 'ALSP'),
					'view_item' => __('View location', 'ALSP'),
					'update_item' => __('Update location', 'ALSP'),
					'search_items' => __('Search locations', 'ALSP'),
					
				),
			)
		);
		register_taxonomy(ALSP_TYPE_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => true,
				'has_archive' => true,
				'labels' => array(
					'name' =>  __('Listing type', 'ALSP'),
					'menu_name' =>  __('Listing types', 'ALSP'),
					'singular_name' => __('Type', 'ALSP'),
					'add_new_item' => __('Create type', 'ALSP'),
					'new_item_name' => __('New type', 'ALSP'),
					'edit_item' => __('Edit type', 'ALSP'),
					'view_item' => __('View type', 'ALSP'),
					'update_item' => __('Update type', 'ALSP'),
					'search_items' => __('Search type', 'ALSP'),
					
				),
			)
		);
		register_taxonomy(ALSP_TAGS_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => false,
				'labels' => array(
					'name' =>  __('Listing tags', 'ALSP'),
					'menu_name' =>  __('Listing tags', 'ALSP'),
					'singular_name' => __('Tag', 'ALSP'),
					'add_new_item' => __('Create tag', 'ALSP'),
					'new_item_name' => __('New tag', 'ALSP'),
					'edit_item' => __('Edit tag', 'ALSP'),
					'view_item' => __('View tag', 'ALSP'),
					'update_item' => __('Update tag', 'ALSP'),
					'search_items' => __('Search tags', 'ALSP'),
				),
			)
		);
	}

	public function suspend_expired_listings() {
		global $wpdb, $ALSP_ADIMN_SETTINGS;

		$posts_ids = $wpdb->get_col($wpdb->prepare("
				SELECT
					wp_pm1.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm1
				LEFT JOIN
					{$wpdb->postmeta} AS wp_pm2 ON wp_pm1.post_id=wp_pm2.post_id
				LEFT JOIN
					{$wpdb->posts} AS wp_posts ON wp_pm1.post_id=wp_posts.ID
				LEFT JOIN
					{$wpdb->alsp_levels_relationships} AS wp_lr ON wp_lr.post_id=wp_pm1.post_id
				LEFT JOIN
					{$wpdb->alsp_levels} AS wp_l ON wp_l.id=wp_lr.level_id
				WHERE
					wp_pm1.meta_key = '_expiration_date' AND
					wp_pm1.meta_value < %d AND
					wp_pm2.meta_key = '_listing_status' AND
					(wp_pm2.meta_value = 'active' OR wp_pm2.meta_value = 'stopped') AND
					(wp_l.eternal_active_period = '0')
			", current_time('timestamp')));
		$listings_ids_to_suspend = $posts_ids;
		foreach ($posts_ids AS $post_id) {
			if (!get_post_meta($post_id, '_expiration_notification_sent', true) && $listing = alsp_getListing($post_id)) {
				if ($ALSP_ADIMN_SETTINGS['alsp_expiration_notification']) {
					$listing_owner = get_userdata($listing->post->post_author);
			
					$subject = __('Expiration notification', 'ALSP');
			
					$body = str_replace('[listing]', $listing->title(),
							str_replace('[link]', (($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && isset($this->dashboard_page_url) && $this->dashboard_page_url) ? alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $post_id)) : admin_url('options.php?page=alsp_renew&listing_id=' . $post_id)),
							$ALSP_ADIMN_SETTINGS['alsp_expiration_notification']));
					alsp_mail($listing_owner->user_email, $subject, $body);
					
					$to = $listing_owner->user_phone;
					if(alsp_isDiTwilioActive() && !empty($to)){
						alsp_send_sms($to, $body);
					}
					add_post_meta($post_id, '_expiration_notification_sent', true);
				}
			}

			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				$trid = $sitepress->get_element_trid($post_id, 'post_' . ALSP_POST_TYPE);
				$translations = $sitepress->get_element_translations($trid, 'post_' . ALSP_POST_TYPE, false, true);
				foreach ($translations AS $lang=>$translation) {
					$listings_ids_to_suspend[] = $translation->element_id;
				}
			} else {
				$listings_ids_to_suspend[] = $post_id;
			}
		}
		$listings_ids_to_suspend = array_unique($listings_ids_to_suspend);
		foreach ($listings_ids_to_suspend AS $listing_id) {
			update_post_meta($listing_id, '_listing_status', 'expired');
			wp_update_post(array('ID' => $listing_id, 'post_status' => 'draft')); // This needed in order terms counts were always actual
			
			$listing = alsp_getListing($listing_id);
			if ($listing->level->change_level_id && ($new_level = $this->levels->getLevelById($listing->level->change_level_id))) {
				if ($wpdb->query("UPDATE {$wpdb->alsp_levels_relationships} SET level_id=" . $new_level->id . "  WHERE post_id=" . $listing->post->ID)) {
					$listing->setLevelByPostId($listing->post->ID);
				}
			}
			
			//$continue = true;
			//$continue_invoke_hooks = true;
			//apply_filters('alsp_listing_renew', $continue, $listing, array(&$continue_invoke_hooks));
		}

		$posts_ids = $wpdb->get_col($wpdb->prepare("
				SELECT
					wp_pm1.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm1
				LEFT JOIN
					{$wpdb->postmeta} AS wp_pm2 ON wp_pm1.post_id=wp_pm2.post_id
				LEFT JOIN
					{$wpdb->posts} AS wp_posts ON wp_pm1.post_id=wp_posts.ID
				LEFT JOIN
					{$wpdb->alsp_levels_relationships} AS wp_lr ON wp_lr.post_id=wp_pm1.post_id
				LEFT JOIN
					{$wpdb->alsp_levels} AS wp_l ON wp_l.id=wp_lr.level_id
				WHERE
					wp_pm1.meta_key = '_expiration_date' AND
					wp_pm1.meta_value < %d AND
					wp_pm2.meta_key = '_listing_status' AND
					(wp_pm2.meta_value = 'active' OR wp_pm2.meta_value = 'stopped') AND
					(wp_l.eternal_active_period = '0')
			", current_time('timestamp')+($ALSP_ADIMN_SETTINGS['alsp_send_expiration_notification_days']*86400)));

		$listings_ids = $posts_ids;

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			foreach ($posts_ids AS $post_id) {
				$trid = $sitepress->get_element_trid($post_id, 'post_' . ALSP_POST_TYPE);
				$listings_ids[] = $trid;
			}
		} else {
			$listings_ids = $posts_ids;
		}

		$listings_ids = array_unique($listings_ids);
		foreach ($listings_ids AS $listing_id) {
			if (!get_post_meta($listing_id, '_preexpiration_notification_sent', true) && ($listing = alsp_getListing($listing_id))) {
				if ($ALSP_ADIMN_SETTINGS['alsp_preexpiration_notification']) {
					$listing_owner = get_userdata($listing->post->post_author);

					$subject = __('Expiration notification', 'ALSP');
					
					$body = str_replace('[listing]', $listing->title(),
							str_replace('[days]', $ALSP_ADIMN_SETTINGS['alsp_send_expiration_notification_days'],
							str_replace('[link]', (($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && isset($this->dashboard_page_url) && $this->dashboard_page_url) ? alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $listing_id)) : admin_url('options.php?page=alsp_renew&listing_id=' . $listing_id)),
							$ALSP_ADIMN_SETTINGS['alsp_preexpiration_notification'])));
					alsp_mail($listing_owner->user_email, $subject, $body);
					
					$to = $listing_owner->user_phone;
					if(alsp_isDiTwilioActive() && !empty($to)){
						alsp_send_sms($to, $body);
					}
					add_post_meta($listing_id, '_preexpiration_notification_sent', true);
				}

				//$continue_invoke_hooks = true;
				//if ($listing = $this->listings_manager->loadListing($listing_id)) {
					//apply_filters('alsp_listing_renew', false, $listing, array(&$continue_invoke_hooks));
				//}
			}
		}
	}

	/**
	 * Special template for listings printing functionality
	 */
	public function printlisting_template($template) {
		if ((is_page($this->index_page_id) || is_page($this->listing_page_id)) && ($this->action == 'printlisting' || $this->action == 'pdflisting')) {
			if (!($template = alsp_isTemplate('views/alsp_advert_print.tpl.php')) && !($template = alsp_isTemplate('views/listing_print-custom.tpl.php'))) {
				$template = alsp_isTemplate('views/alsp_advert_print.tpl.php');
			}
		}
		return $template;
	}
	
	function filter_comment_status($open, $post_id) {
		global $ALSP_ADIMN_SETTINGS;
		$post = get_post($post_id);
		if ($post->post_type == ALSP_POST_TYPE) {
			if ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'enabled')
				return true;
			elseif ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'disabled')
				return false;
		}

		return $open;
	}

	/**
	 * Get property by shortcode name
	 * 
	 * @param string $shortcode
	 * @param string $property if property missed - return controller object
	 * @return mixed
	 */
	public function getShortcodeProperty($shortcode, $property = false) {
		if (!isset($this->public_controls[$shortcode]) || !isset($this->public_controls[$shortcode][0]))
			return false;

		if ($property && !isset($this->public_controls[$shortcode][0]->$property))
			return false;

		if ($property)
			return $this->public_controls[$shortcode][0]->$property;
		else 
			return $this->public_controls[$shortcode][0];
	}
	
	public function getShortcodeByHash($hash) {
		if (!isset($this->public_controls) || !is_array($this->public_controls) || empty($this->public_controls))
			return false;

		foreach ($this->public_controls AS $shortcodes)
			foreach ($shortcodes AS $controller)
				if (is_object($controller) && $controller->hash == $hash)
					return $controller;
	}
	
	public function getListingsShortcodeByuID($uid) {
		foreach ($this->public_controls AS $shortcodes)
			foreach ($shortcodes AS $controller)
				if (is_object($controller) && get_class($controller) == 'alsp_listings_controller' && $controller->args['uid'] == $uid)
					return $controller;
	}

	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $alsp_enqueued, $ALSP_ADIMN_SETTINGS, $pacz_settings;
		if($pacz_settings['minify-css']){
			$css_min = '';
		}else{
			$css_min = '';
		}
		
		if ((($this->public_controls || $load_scripts_styles || is_page() || is_single() || is_404() || is_search() || is_author() || is_home()) && !$alsp_enqueued)) {
			add_action('wp_head', array($this, 'enqueue_global_vars'));
			
			wp_enqueue_script('jquery');
			wp_register_style('alsp_locations', ALSP_RESOURCES_URL . 'css/locations' . $css_min . '.css');
			wp_register_style('alsp_category', ALSP_RESOURCES_URL . 'css/alsp-categories' . $css_min . '.css');
			wp_register_style('alsp_listings', ALSP_RESOURCES_URL . 'css/alsp-listings' . $css_min . '.css');
			wp_register_style('alsp-search', ALSP_RESOURCES_URL . 'css/alsp-search' . $css_min . '.css');
			wp_register_style('single-listing', ALSP_RESOURCES_URL . 'css/single-listing' . $css_min . '.css');
			wp_register_style('alsp_frontend', ALSP_RESOURCES_URL . 'css/frontend' . $css_min . '.css');
			wp_register_style('alsp_font_awesome', ALSP_RESOURCES_URL . 'css/font-awesome.css');
			
	
			if ($frontend_custom = alsp_isResource('css/frontend-custom.css')) {
				wp_register_style('alsp_frontend-custom', $frontend_custom, array(), ALSP_VERSION);
			}
			
			wp_register_script('alsp_applications', ALSP_RESOURCES_URL . 'js/alsp_applications.js', array('jquery'), false, true);
			wp_register_script('alsp_categories', ALSP_RESOURCES_URL . 'js/alsp_categories.js', array('jquery'), false, true);
			wp_register_script('alsp_listingtypes', ALSP_RESOURCES_URL . 'js/alsp_listingtypes.js', array('jquery'), false, true);

			wp_register_style('alsp_media_styles', ALSP_RESOURCES_URL . 'lightbox/css/lightbox.min.css');
			wp_register_script('alsp_media_scripts_lightbox', ALSP_RESOURCES_URL . 'lightbox/js/lightbox.min.js', array('jquery'), false, true);
			wp_register_style('alsp-jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.min.css');
			
			if (function_exists('is_rtl') && is_rtl()){
				wp_register_style('alsp_frontend_rtl', ALSP_RESOURCES_URL . 'css/frontend-rtl' . $css_min . '.css');
			}
			if(!$pacz_settings['minify-css']){
				wp_enqueue_style('alsp_locations');
				wp_enqueue_style('alsp_category');
				wp_enqueue_style('alsp_listings');
				wp_enqueue_style('alsp-search');
				wp_enqueue_style('single-listing');
				wp_enqueue_style('alsp_frontend');
				wp_enqueue_style('alsp_frontend_rtl');
			}
			wp_enqueue_style('alsp_frontend-custom');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-selectmenu');
			wp_enqueue_script('jquery-ui-autocomplete');
			wp_enqueue_style('alsp-jquery-ui-style');
			wp_enqueue_script('alsp_applications');
			
			wp_register_style('alsp_listings_slider', ALSP_RESOURCES_URL . 'css/bxslider/jquery.bxslider.css');
			wp_enqueue_style('alsp_listings_slider');
			
			if (alsp_is_maps_used()) {
				if (alsp_getMapEngine() != 'mapbox') {
					add_action('wp_print_scripts', array($this, 'dequeue_maps_googleapis'), 1000);
					wp_register_script('alsp_google_maps', ALSP_RESOURCES_URL . 'js/alsp_google_maps.js', array('jquery'), ALSP_VERSION, true);
					wp_enqueue_script('alsp_google_maps');
				}
			}
			
			// Single Listing page
			if ($this->getShortcodeProperty('alsp-main', 'is_single') || $this->getShortcodeProperty('alsp-listing', 'is_single')) {
					wp_enqueue_style('alsp_media_styles');
					wp_enqueue_script('alsp_media_scripts_lightbox');
			}
			
			wp_localize_script(
				'alsp_applications',
				'alsp_maps_callback',
				array(
						'callback' => 'alsp_load_maps_api'
				)
			);
			
			if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
				wp_register_script('alsp_recaptcha', '//google.com/recaptcha/api.js');
				wp_enqueue_script('alsp_recaptcha');
			}
			

			$alsp_enqueued = true;
		}
		
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (!is_author() && !is_404() && !is_search() && !is_archive() && alsp_isWooActiveAll()){
			if(is_account_page()){
				wp_register_style('alsp_user_panel', ALSP_FSUBMIT_RESOURCES_URL . 'css/user_panel.css');
				wp_register_script('alsp_js_userpanel', ALSP_RESOURCES_URL . 'js/min/alsp_userpanel.min.js', array('jquery'), false, true);
				wp_enqueue_style('alsp_user_panel');
				wp_enqueue_script('alsp_js_userpanel');
			}
		}
	}
	public function dequeue_maps_googleapis() {
		global $ALSP_ADIMN_SETTINGS;
		$dequeue = false;
		if ((alsp_is_maps_used() && $ALSP_ADIMN_SETTINGS['alsp_google_api_key'] && !(defined('ALSP_NOTINCLUDE_MAPS_API') && ALSP_NOTINCLUDE_MAPS_API)) && !(defined('ALSP_NOT_DEQUEUE_MAPS_API') && ALSP_NOT_DEQUEUE_MAPS_API)) {
			$dequeue = true;
		}
		
		$dequeue = apply_filters('alsp_dequeue_maps_googleapis', $dequeue);
		
		if ($dequeue) {
			// dequeue only at the frontend or at admin directory pages
			if (!is_admin() || (is_admin() && alsp_isDirectoryPageInAdmin())) {
				global $wp_scripts;
				foreach ($wp_scripts->registered AS $key=>$script) {
					if (strpos($script->src, 'maps.googleapis.com') !== false || strpos($script->src, 'maps.google.com/maps/api') !== false) {
						unset($wp_scripts->registered[$key]);
					}
				}
			}
		}
	}
	public function enqueue_global_vars() {
		global $ALSP_ADIMN_SETTINGS;
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else
			$ajaxurl = admin_url('admin-ajax.php');

		echo '
<script>
';
		echo 'var alsp_controller_args_array = {};
';
		echo 'var alsp_map_markers_attrs_array = [];
';
		echo 'var alsp_map_markers_attrs = (function(map_id, markers_array, enable_radius_circle, enable_clusters, show_summary_button, show_readmore_button, draw_panel, map_style, enable_full_screen, enable_wheel_zoom, enable_dragging_touchscreens, center_map_onclick, show_directions, map_attrs) {
		this.map_id = map_id;
		this.markers_array = markers_array;
		this.enable_radius_circle = enable_radius_circle;
		this.enable_clusters = enable_clusters;
		this.show_summary_button = show_summary_button;
		this.show_readmore_button = show_readmore_button;
		this.draw_panel = draw_panel;
		this.map_style = map_style;
		this.enable_full_screen = enable_full_screen;
		this.enable_wheel_zoom = enable_wheel_zoom;
		this.enable_dragging_touchscreens = enable_dragging_touchscreens;
		this.center_map_onclick = center_map_onclick;
		this.show_directions = show_directions;
		this.map_attrs = map_attrs;
		});
';
		global $alsp_google_maps_styles;
		/* if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 1){
			$in_favourites_icon = 'pacz-icon-heart';
			$not_in_favourites_icon = 'pacz-icon-heart-o';
		}if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 14){
			$in_favourites_icon = 'checked pacz-icon-heart';
			$not_in_favourites_icon = 'unchecked pacz-icon-heart';
		}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 15){
			$in_favourites_icon = 'pacz-icon-bookmark';
			$not_in_favourites_icon = 'pacz-icon-bookmark-o';
		}else{
			$in_favourites_icon = 'checked pacz-icon-bookmark';
			$not_in_favourites_icon = 'unchecked pacz-icon-bookmark-o';
		} */
		$in_favourites_icon = 'pacz-icon-heart';
		$in_favourites_icon2 = 'checked pacz-icon-heart';
		$in_favourites_icon3 = 'checked pacz-icon-bookmark';
		$not_in_favourites_icon = 'pacz-icon-heart-o';
		$not_in_favourites_icon2 = 'unchecked pacz-icon-heart';
		$not_in_favourites_icon3 = 'unchecked pacz-icon-bookmark-o';
		echo 'var alsp_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'in_favourites_icon' => $in_favourites_icon,
						'in_favourites_icon2' => $in_favourites_icon2,
						'in_favourites_icon3' => $in_favourites_icon3,
						'not_in_favourites_icon' => $not_in_favourites_icon,
						'not_in_favourites_icon2' => $not_in_favourites_icon2,
						'not_in_favourites_icon3' => $not_in_favourites_icon3,
						'in_favourites_msg' => __('Remove Bookmark', 'ALSP'),
						'not_in_favourites_msg' => __('Add Bookmark', 'ALSP'),
						'ajax_load' => (int)$ALSP_ADIMN_SETTINGS['alsp_ajax_load'],
						'ajax_initial_load' => (int)$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load'],
						'is_rtl' => is_rtl(),
						'send_button_text' => __('Send message', 'ALSP'),
						'send_button_sending' => __('Sending...', 'ALSP'),
						'recaptcha_public_key' => (($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) ? $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] : ''),
						'lang' => (($sitepress && $ALSP_ADIMN_SETTINGS['alsp_map_language_from_wpml']) ? ICL_LANGUAGE_CODE : ''),
						'is_maps_used' => alsp_is_maps_used(),
						'alsp_show_radius_tooltip' => $ALSP_ADIMN_SETTINGS['alsp_show_radius_tooltip'],
						'alsp_miles_kilometers_in_search' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search'],
				)
		) . ';
';
			
		$map_content_fields = $this->content_fields->getMapContentFields();
		$map_content_fields_icons = array('fa-info-circle');
		foreach ($map_content_fields AS $content_field)
			if (is_a($content_field, 'alsp_content_field') && $content_field->icon_image)
				$map_content_fields_icons[] = $content_field->icon_image;
			else
				$map_content_fields_icons[] = '';
		echo 'var alsp_maps_objects = ' . json_encode(
				array(
						'notinclude_maps_api' => ((defined('ALSP_NOTINCLUDE_MAPS_API') && ALSP_NOTINCLUDE_MAPS_API) ? 1 : 0),
						'google_api_key' => $ALSP_ADIMN_SETTINGS['alsp_google_api_key'],
						'mapbox_api_key' => (isset($ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key']) && !empty($ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key']))? $ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key'] : '',
						'map_markers_type' => $ALSP_ADIMN_SETTINGS['alsp_map_markers_type'],
						'default_marker_color' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_color'],
						'default_marker_icon' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_icon'],
						'global_map_icons_path' => ALSP_MAP_ICONS_URL,
						'marker_image_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_width'],
						'marker_image_height' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_height'],
						'marker_image_anchor_x' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_x'],
						'marker_image_anchor_y' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_y'],
						'infowindow_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_width'],
						'infowindow_offset' => -(int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_offset'],
						'infowindow_logo_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_width'],
						'infowindow_logo_height' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_height'],
						'alsp_map_info_window_button_readmore' => __('Read more »', 'ALSP'),
						'alsp_map_info_window_button_summary' => __('« Summary', 'ALSP'),
						//'map_style_name' => $ALSP_ADIMN_SETTINGS['alsp_map_style'],
						'draw_area_button' => __('', 'ALSP'),
						'edit_area_button' => __('', 'ALSP'),
						'apply_area_button' => __('', 'ALSP'),
						'reload_map_button' => __('', 'ALSP'),
						'enable_my_location_button' => (int)$ALSP_ADIMN_SETTINGS['alsp_address_geocode'],
						'my_location_button' => __('', 'ALSP'),
						'my_location_button_error' => __('GeoLocation service does not work on your device!', 'ALSP'),
						'alsp_map_content_fields_icons' => $map_content_fields_icons,
						//'map_markers_array' => alsp_get_fa_icons_names(),
						'map_style' => alsp_getSelectedMapStyle(),
						'address_autocomplete' => $ALSP_ADIMN_SETTINGS['alsp_address_autocomplete'],
						'address_autocomplete_code' => (isset($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code']))? $ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code']: '',
				)
		) . ';
';
		echo '</script>
';
	}

	public function exclude_post_type_archive_link($archive_url, $post_type) {
		if ($post_type == ALSP_POST_TYPE) {
			return false;
		}
		
		return $archive_url;
	}
	
	// adapted for Polylang
	public function pll_setup() {
		if (defined("POLYLANG_VERSION")) {
			add_filter('post_type_link', array($this, 'pll_stop_add_lang_to_url_post'), 0, 2);
			add_filter('post_type_link', array($this, 'pll_start_add_lang_to_url_post'), 100, 2);
			add_filter('term_link', array($this, 'pll_stop_add_lang_to_url_term'), 0, 3);
			add_filter('term_link', array($this, 'pll_start_add_lang_to_url_term'), 100, 3);
			add_filter('rewrite_rules_array', array($this, 'pll_rewrite_rules'));
		}
	}
	public function pll_stop_add_lang_to_url_post($permalink, $post) {
		$this->pll_force_lang = false;
		if ($post->post_type == ALSP_POST_TYPE) {
			global $polylang;
			if (isset($polylang->links->links_model->model->options['force_lang']) && $polylang->links->links_model->model->options['force_lang']) {
				$this->pll_force_lang = true;
				$polylang->links->links_model->model->options['force_lang'] = 0;
			}
		}
		return $permalink;
	}
	public function pll_start_add_lang_to_url_post($permalink, $post) {
		if ($this->pll_force_lang && $post->post_type == ALSP_POST_TYPE) {
			global $polylang;
			$polylang->links->links_model->model->options['force_lang'] = 1;
		}
		return $permalink;
	}
	public function pll_stop_add_lang_to_url_term($permalink, $term, $tax) {
		$this->pll_force_lang = false;
		if ($tax == ALSP_CATEGORIES_TAX || $tax == ALSP_TYPE_TAX || $tax == ALSP_LOCATIONS_TAX || $tax == ALSP_TAGS_TAX) {
			global $polylang;
			if (isset($polylang->links->links_model->model->options['force_lang']) && $polylang->links->links_model->model->options['force_lang']) {
				$this->pll_force_lang = true;
				$polylang->links->links_model->model->options['force_lang'] = 0;
			}
		}
		return $permalink;
	}
	public function pll_start_add_lang_to_url_term($permalink, $term, $tax) {
		if ($this->pll_force_lang && ($tax == ALSP_CATEGORIES_TAX || $tax == ALSP_TYPE_TAX || $tax == ALSP_LOCATIONS_TAX || $tax == ALSP_TAGS_TAX)) {
			global $polylang;
			$polylang->links->links_model->model->options['force_lang'] = 1;
		}
		return $permalink;
	}
	public function pll_rewrite_rules($rules) {
		global $polylang, $wp_current_filter;
		$wp_current_filter[] = 'alsp_listing';
		return $polylang->links->links_model->rewrite_rules($this->buildRules()) + $rules;
	}
}

// Load Main Class
$alsp_instance = new alsp_plugin();
$alsp_instance->init();



// Load Extensions	
//include_once ALSP_PATH . 'extension/di-report-abuse/di-report-abuse.php';
if(!class_exists('Di_Frontend_Pm')){
	include_once ALSP_PATH . 'extension/di-frontend-pm/di-frontend-pm.php';
}

global $ALSP_ADIMN_SETTINGS;
	include_once ALSP_PATH . 'extension/alsp_pass_reset_form/alsp_pass_reset_form.php';
if($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon']){
	include_once ALSP_PATH . 'extension/alsp-frontend-submission/alsp-frontend-submission.php';
}
if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment'){
	include_once ALSP_PATH . 'extension/alsp-payments/alsp-payments.php';
}
if ($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
	include_once ALSP_PATH . 'extension/di-reviews/di-reviews.php';
}
if(alsp_isGdUserDashboardPluginActive()){
	deactivate_plugins('gd-user-dashboard/gd-user-dashboard.php');
}elseif(alsp_isGdListingStylesPluginActive()){
	deactivate_plugins('gd-listing-styles/gd-listing-styles.php');
}
if(!class_exists('Puc_v4_Factory')){
	include_once ALSP_PATH. 'alsp-update-checker/alsp-update-checker.php';
}
$UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://assets.designinvento.net/plugins/listing/update/alsp-update.json',
	plugin_dir_path( __DIR__ ).'listing/alsp.php',
	'listing'
); 