<?php
class alsp_admin {

	public function __construct() {
		global $alsp_instance;

		add_action('admin_menu', array($this, 'menu'));

		$alsp_instance->directories_manager = new alsp_directories_manager;

		$alsp_instance->levels_manager = new alsp_levels_manager;

		$alsp_instance->listings_manager = new alsp_listings_manager;

		$alsp_instance->locations_manager = new alsp_locations_manager;

		$alsp_instance->locations_levels_manager = new alsp_locations_levels_manager;

		$alsp_instance->categories_manager = new alsp_categories_manager;
		
		$alsp_instance->listingtype_manager = new alsp_listingtype_manager;

		$alsp_instance->content_fields_manager = new alsp_content_fields_manager;

		$alsp_instance->media_manager = new alsp_media_manager;

		$alsp_instance->csv_manager = new alsp_csv_manager;
		
		//$alsp_instance->maps_importer = new alsp_maps_importer;

		add_action('admin_menu', array($this, 'addChooseLevelPage'));
		add_action('load-post-new.php', array($this, 'handleLevel'));

		// hide some meta-blocks when create/edit posts
		add_action('admin_init', array($this, 'hideMetaBlocks'));
		
		add_filter('post_row_actions', array($this, 'removeQuickEdit'), 10, 2);
		add_filter('quick_edit_show_taxonomy', array($this, 'removeQuickEditTax'), 10, 2);

		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'), 0);

		add_action('admin_notices', 'alsp_renderMessages');

	//	add_action('wp_ajax_alsp_generate_color_palette', array($this, 'generate_color_palette'));
	//	add_action('wp_ajax_nopriv_alsp_generate_color_palette', array($this, 'generate_color_palette'));
		add_action('wp_ajax_alsp_get_jqueryui_theme', array($this, 'get_jqueryui_theme'));
		add_action('wp_ajax_nopriv_alsp_get_jqueryui_theme', array($this, 'get_jqueryui_theme'));
		add_action('vp_alsp_option_before_ajax_save', array($this, 'remove_colorpicker_cookie'));
		//add_action('wp_footer', array($this, 'render_colorpicker'));
	}

	public function addChooseLevelPage() {
		add_submenu_page('options.php',
			__('Choose level of new listing', 'ALSP'),
			__('Choose level of new listing', 'ALSP'),
			'publish_posts',
			'alsp_choose_level',
			array($this, 'chooseLevelsPage')
		);
	}

	// Special page to choose the level for new listing
	public function chooseLevelsPage() {
		global $alsp_instance;

		$alsp_instance->levels_manager->displayChooseLevelTable();
	}
	
	public function handleLevel() {
		global $alsp_instance;

		if (isset($_GET['post_type']) && $_GET['post_type'] == ALSP_POST_TYPE) {
			if (!isset($_GET['level_id'])) {
				// adapted for WPML
				global $sitepress;
				if (function_exists('wpml_object_id_filter') && $sitepress && isset($_GET['trid']) && isset($_GET['lang']) && isset($_GET['source_lang'])) {
					global $sitepress;
					$listing_id = $sitepress->get_original_element_id_by_trid($_GET['trid']);
					
					$listing = new alsp_listing();
					$listing->loadListingFromPost($listing_id);
					wp_redirect(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $listing->level->id, 'trid' => $_GET['trid'], 'lang' => $_GET['lang'], 'source_lang' => $_GET['source_lang']), admin_url('post-new.php')));
				} else {
					if (count($alsp_instance->levels->levels_array) != 1) {
						wp_redirect(add_query_arg('page', 'alsp_choose_level', admin_url('options.php')));
					} else {
						$single_level = array_shift($alsp_instance->levels->levels_array);
						wp_redirect(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $single_level->id), admin_url('post-new.php')));
					}
				}
				die();
			}
		}
	}

	public function menu() {
			
	}
	public function alsp_dashboard(){
		if(class_exists('Pacz_Admin')){
			do_action('pacz_dashboad_panel');
		}
		
	}
	
	public function hideMetaBlocks() {
		 global $post, $pagenow;

		if (($pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == ALSP_POST_TYPE) || ($pagenow == 'post.php' && $post && $post->post_type == ALSP_POST_TYPE)) {
			$user_id = get_current_user_id();
			update_user_meta($user_id, 'metaboxhidden_' . ALSP_POST_TYPE, array('authordiv', 'trackbacksdiv', 'commentstatusdiv', 'postcustom'));
		}
	}

	public function removeQuickEdit($actions, $post) {
		if ($post->post_type == ALSP_POST_TYPE) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['view']);
		}
		return $actions;
	}

	public function removeQuickEditTax($show_in_quick_edit, $taxonomy_name) {
		if ($taxonomy_name == ALSP_CATEGORIES_TAX || $taxonomy_name == ALSP_TYPE_TAX || $taxonomy_name == ALSP_LOCATIONS_TAX)
			$show_in_quick_edit = false;
		
		return $show_in_quick_edit;
	}
	
	public function admin_enqueue_scripts_styles() {
		add_action('admin_head', array($this, 'enqueue_global_vars'));

		//wp_register_style('alsp_bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
		if (defined('PACZ_THEME_SETTINGS')) {
			wp_register_style('alsp_select2', PACZ_THEME_STYLES . '/select2.css');
			wp_register_style('bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
			wp_register_style('alsp_fonticon_icons', PACZ_THEME_STYLES . '/fonticon-custom.min.css');
		}
		wp_register_style('alsp_admin', ALSP_RESOURCES_URL . 'css/admin.css');
		wp_register_style('alsp_admin_notice', ALSP_RESOURCES_URL . 'css/admin_notice.css');
		wp_register_script('alsp_applications', ALSP_RESOURCES_URL . 'js/alsp_applications.js', array('jquery'), false, true);
		wp_enqueue_script('jquery-ui-datepicker');
		// this jQuery UI version 1.10.3 is for WP v3.7.1
		wp_register_style('alsp-jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css');
		if (defined('PACZ_THEME_SETTINGS')) {
			wp_register_script('bootstrap_js', PACZ_THEME_JS . '/bootstrap.min.js', array('jquery'));
			wp_register_script('alsp_select2_js', PACZ_THEME_JS . '/select2.min.js', array('jquery'));
		}
		
		 global $pagenow;
		 if ($pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
			wp_register_script('alsp_categories_edit_scripts', ALSP_RESOURCES_URL . 'js/min/alsp_categories_icons.min.js', array('jquery'));
			wp_register_script('alsp_listingtype_edit_scripts', ALSP_RESOURCES_URL . 'js/alsp_listingtype_icons.js', array('jquery'));
		 }
		wp_register_script('alsp_categories', ALSP_RESOURCES_URL . 'js/alsp_categories.js', array('jquery'));
		wp_register_script('alsp_listingtypes', ALSP_RESOURCES_URL . 'js/alsp_listingtypes.js', array('jquery'));
		
		wp_register_script('alsp_locations_edit_scripts', ALSP_RESOURCES_URL . 'js/min/alsp_locations_icons.min.js', array('jquery'));
		
		wp_register_style('alsp_media_styles', ALSP_RESOURCES_URL . 'lightbox/css/lightbox.css');
		wp_register_script('alsp_media_scripts_lightbox', ALSP_RESOURCES_URL . 'lightbox/js/lightbox.min.js', array('jquery'));
		wp_register_script('alsp_select2_triger', ALSP_RESOURCES_URL . 'js/select2-triger.js', array('jquery'));
		if (defined('PACZ_THEME_SETTINGS')) {
			wp_enqueue_style('alsp_select2');
			wp_enqueue_style('alsp_fonticon_icons');
			wp_add_inline_style('alsp_fonticon_icons', pacz_enqueue_font_icons());
			wp_enqueue_script('bootstrap_js');
		}
		wp_enqueue_style('alsp_admin');
		wp_enqueue_style('alsp_admin_notice');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('alsp-jquery-ui-style');
		
		global $pagenow;

   if ($pagenow != 'admin.php') {
        wp_enqueue_script('alsp_applications');
      }
		
	 global $post;
	if(!isset($_GET['post_type'])){
		$_GET['post_type'] = '';
	} 
    if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' || $pagenow == 'edit-tags.php') {
        if ( $_GET['post_type'] == 'alsp_listing' ) {     
            wp_register_style('alsp_fsubmit_admin', ALSP_URL . 'extension/alsp-frontend-submission/assets/css/submitlisting.css');
			wp_enqueue_style('bootstrap');
			wp_enqueue_style('alsp_fsubmit_admin');
			
			if (is_file(ALSP_URL . 'extension/alsp-frontend-submission/assets/css/submitlisting-custom.css')){
				wp_register_style('alsp_fsubmit-custom_admin', ALSP_URL . 'extension/alsp-frontend-submission/assets/css/submitlisting-custom.css');
				wp_enqueue_style('alsp_fsubmit-custom_admin');
			}
			wp_enqueue_script('alsp_select2_js');
			wp_enqueue_script('alsp_select2_triger');
			if (function_exists('is_rtl') && is_rtl()){
				wp_register_style('alsp_fsubmit_rtl_admin', ALSP_URL . 'extension/alsp-frontend-submission/assets/css/submitlisting-rtl.css');
				wp_enqueue_style('alsp_fsubmit_rtl_admin');
			}
			
       }
    }
	if(alsp_isCategoriesEditPageInAdmin()){
		wp_enqueue_style('alsp_bootstrap');
	}
	if(alsp_isListingTypeEditPageInAdmin()){
		wp_enqueue_style('alsp_bootstrap');
	}
		wp_localize_script(
			'alsp_applications',
			'alsp_maps_callback',
			array(
					'callback' => 'alsp_load_maps_api_backend'
			)
		);

		//wp_enqueue_script('alsp_google_maps_edit');
		
		
		if (alsp_isDirectoryPageInAdmin() && alsp_is_maps_used()) {
			if (alsp_getMapEngine() != 'mapbox') {
				wp_register_script('alsp_google_maps', ALSP_RESOURCES_URL . 'js/alsp_google_maps.js', array('jquery'), ALSP_VERSION, true);
				wp_enqueue_script('alsp_google_maps');
			}
		}
	}
	
	public function enqueue_global_vars() {
		// adapted for WPML
		global $sitepress, $ALSP_ADIMN_SETTINGS;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else
			$ajaxurl = admin_url('admin-ajax.php');

		echo '
<script>
';
		echo 'var alsp_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'is_maps_used' => alsp_is_maps_used(),
						'is_rtl' => is_rtl(),
				)
		) . ';
';

		global $alsp_google_maps_styles;
		if(alsp_isMapBoxActive()){
			$mapbox_api = (isset($ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key']) && !empty($ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key']))? $ALSP_ADIMN_SETTINGS['alsp_mapbox_api_key']: '';
		}else{
			$mapbox_api = '';
		}
		echo 'var alsp_maps_objects = ' . json_encode(
				array(
						'notinclude_maps_api' => ((defined('ALSP_NOTINCLUDE_MAPS_API') && ALSP_NOTINCLUDE_MAPS_API) ? 1 : 0),
						'google_api_key' => $ALSP_ADIMN_SETTINGS['alsp_google_api_key'],
						'mapbox_api_key' => $mapbox_api,
						'map_markers_type' => $ALSP_ADIMN_SETTINGS['alsp_map_markers_type'],
						'default_marker_color' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_color'],
						'default_marker_icon' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_icon'],
						'global_map_icons_path' => ALSP_MAP_ICONS_URL,
						'marker_image_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_width'],
						'marker_image_height' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_height'],
						'marker_image_anchor_x' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_x'],
						'marker_image_anchor_y' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_y'],
						'default_geocoding_location' => $ALSP_ADIMN_SETTINGS['alsp_default_geocoding_location'],
						'map_style' => alsp_getSelectedMapStyle(),
						'address_autocomplete_code' => (isset($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code']))? $ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code']: '',
						'enable_my_location_button' => 1,
				)
		) . ';
';
		echo '</script>
';
	}
}
