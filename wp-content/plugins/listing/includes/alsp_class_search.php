<?php

class alsp_search_form {
	public $uid;
	public $controller;
	public $args = array();
	public $search_fields_array = array();
	public $search_fields_array_advanced = array();
	public $search_fields_array_all = array();
	public $is_advanced_search_panel = false;
	public $search_form_id;
	public $advanced_open = false;
	public $directories = array(); // native search form needs only one directory, search form on the map can use multiple
	
	public function __construct($uid = null, $controller = 'listings_controller', $args = array()) {
		global $alsp_instance;
		
		//$this->uid = $uid;
		$alsp_instance->search_fields->load_search_fields();
		//$this->controller = $controller;
		
		
		$this->args = array_merge(array(
				'custom_home' => 0,
				'directory' => 0,
				'columns' => 1,
				'gap_in_fields' => 10,
				'show_categories_search' => 1,
				'show_listingtype_search' => 1,
				'categories_search_level' => 1,
				'listingtype_search_level' => 1,
				'category' => 0,
				'listingtype' => 0,
				'exact_categories' => array(),
				'exact_listingtypes' => array(),
				'show_default_filed_label' =>'',
				'show_keywords_search' => 1,
				'keywords_ajax_search' => 1,
				'keywords_search_examples' => '',
				'what_search' => '',
				'show_radius_search' => 1,
				'radius' => 0,
				'show_locations_search' => 1,
				'locations_search_level' => 1,
				'show_address_search' => 1,
				'address' => '',
				'location' => 0,
				'exact_locations' => array(),
				'search_fields' => '',
				'search_fields_advanced' => '',
				'search_bg_color' => '',
				'search_bg_opacity' => 100,
				'search_text_color' => '',
				'hide_search_button' => 1,
				'on_row_search_button' => 0,
				'sticky_scroll' => 0,
				'sticky_scroll_toppadding' => 0,
				'scroll_to' => '',
				'search_custom_style' => 0,
				'main_searchbar_bg_color' => '',
				'main_search_border_color' => '',
				'search_box_padding_top' => '20',
				'search_box_padding_bottom' => '90',
				'search_box_padding_left' => '60',
				'search_box_padding_right' => '40',
				'input_field_height' => '70',
				'input_field_bg' => '444',
				'input_field_border_color' => 'red',
				'input_field_placeholder_color' => '888',
				'input_field_text_color' => '#aaa',
				'input_field_label_color' => '#ddd',
				'input_field_border_width' => '3',
				'input_field_border_radius' => '6',
				'search_button_border_radius' => '',
				'search_button_bg' => '',
				'search_button_bg_hover' => '',
				'search_button_border_color' => '',
				'search_button_border_color_hover' => '',
				'search_button_border_width' => '',
				'search_button_text_color' => '',
				'search_button_text_color_hover' => '',
				'search_button_icon' => '',
				'search_form_type' => 1,
				
		), $args);
		
		if ($this->args['custom_home']) {
			if ($alsp_instance->current_directory->categories) {
				$this->args['exact_categories'] = $alsp_instance->current_directory->categories;
			}
			if ($alsp_instance->current_directory->locations) {
				$this->args['exact_locations'] = $alsp_instance->current_directory->locations;
			}
			$this->directories = array($alsp_instance->current_directory->id);
		} elseif ($this->args['directory'] && ($directory = $alsp_instance->directories->getDirectoryById($this->args['directory']))) {
			if ($directory->categories) {
				$this->args['exact_categories'] = $directory->categories;
			}
			if ($directory->listingtypes) {
				$this->args['exact_listingtypes'] = $directory->listingtypes;
			}
			if ($directory->locations) {
				$this->args['exact_locations'] = $directory->locations;
			}
			$this->directories = array($this->args['directory']);
		}
		if (isset($this->args['exact_categories']) && !is_array($this->args['exact_categories'])) {
			if ($categories = array_filter(explode(',', $this->args['exact_categories']), 'trim')) {
				$this->args['exact_categories'] = $categories;
			}
		}
		if (isset($this->args['exact_listingtypes']) && !is_array($this->args['exact_listingtypes'])) {
			if ($listingtypes = array_filter(explode(',', $this->args['exact_listingtypes']), 'trim')) {
				$this->args['exact_listingtypes'] = $listingtypes;
			}
		}
		if (isset($this->args['exact_locations']) && !is_array($this->args['exact_locations'])) {
			if ($locations = array_filter(explode(',', $this->args['exact_locations']), 'trim')) {
				$this->args['exact_locations'] = $locations;
			}
		}

		if ((isset($this->args['search_fields']) && $this->args['search_fields'] && $this->args['search_fields'] != -1) || (isset($this->args['search_fields_advanced']) && $this->args['search_fields_advanced'] && $this->args['search_fields_advanced'] != -1)) {
			$search_fields_ids = explode(',', $this->args['search_fields']);
			$search_fields_ids_advanced = explode(',', $this->args['search_fields_advanced']);
			$search_fields_ids_all = array_filter(array_merge($search_fields_ids, $search_fields_ids_advanced));
			
			foreach ($search_fields_ids_all AS $id) {
				if ($search_field = $alsp_instance->search_fields->getSearchFieldById($id)) {
					if (in_array($id, $search_fields_ids))
						$this->search_fields_array[$id] = $search_field;
					elseif (in_array($id, $search_fields_ids_advanced))
						$this->search_fields_array_advanced[$id] = $search_field;
				}
			}
		} else {
			foreach ($alsp_instance->search_fields->search_fields_array AS $id=>$search_field)
				if ($search_field->content_field->advanced_search_form && (!isset($this->args['search_fields_advanced']) || $this->args['search_fields_advanced'] != -1)) {
					$this->search_fields_array_advanced[$id] = $search_field;
				} elseif (!isset($this->args['search_fields']) || $this->args['search_fields'] != -1) {
					$this->search_fields_array[$id] = $search_field;
				}
		}

		$search_fields_array_all = $this->search_fields_array + $this->search_fields_array_advanced;
		
		// safely copy all fields into $this->search_fields_array_all, this array needs to manage hidden fields_in_categories[] = []
		foreach ($search_fields_array_all AS $key=>$search_field) {
			$this->search_fields_array_all[$key] = clone $search_field;
			$this->search_fields_array_all[$key]->resetValue();
		}
		
		if ($this->search_fields_array_advanced)
			$this->is_advanced_search_panel = true;

		if ((isset($_REQUEST['use_advanced']) && ($_REQUEST['use_advanced'] == 1)) || !empty($this->args['advanced_open']))
			$this->advanced_open = true;
	}
	
	public function outputHiddenFields() {
		global $alsp_instance, $wp_rewrite;

		$hidden_fields = array();

		if (!$wp_rewrite->using_permalinks() && $alsp_instance->index_page_id && (get_option('show_on_front') != 'page' || get_option('page_on_front') != $alsp_instance->index_page_id))
			$hidden_fields['page_id'] = $alsp_instance->index_page_id;
		if ($alsp_instance->index_page_id)
			$hidden_fields['alsp_action'] = "search";
		else
			$hidden_fields['s'] = "search";
		if ($this->uid)
			$hidden_fields['hash'] = $this->uid;
		if ($this->controller)
			$hidden_fields['controller'] = $this->controller;
		
		$hidden_fields['include_categories_children'] = 1;

		if ($this->directories) {
			$hidden_fields['directories'] = implode(',', $this->directories);
		}

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress)
			if ($sitepress->get_option('language_negotiation_type') == 3)
				$hidden_fields['lang'] =  $sitepress->get_current_language();

		if (!$this->args['show_categories_search'] && !empty($this->args['category'])) {
			$hidden_fields['categories'] = $this->args['category'];
		}
		if (!$this->args['show_listingtype_search'] && !empty($this->args['listingtype'])) {
			$hidden_fields['listingtypes'] = $this->args['listingtype'];
		}
		if (!$this->args['show_keywords_search'] && !empty($this->args['what_search'])) {
			$hidden_fields['what_search'] = $this->args['what_search'];
		}
		if (!$this->args['show_locations_search'] && !empty($this->args['location'])) {
			$hidden_fields['location_id'] = $this->args['location'];
		}
		if (!$this->args['show_address_search'] && !empty($this->args['address'])) {
			$hidden_fields['address'] = $this->args['address'];
		}
		if (!$this->args['show_radius_search'] && !empty($this->args['radius'])) {
			$hidden_fields['radius'] = $this->args['radius'];
		}
		if (!empty($this->args['exact_categories'])) {
			$hidden_fields['exact_categories'] = implode(",", $this->args['exact_categories']);
		}
		if (!empty($this->args['exact_locations'])) {
			$hidden_fields['exact_locations'] = implode(",", $this->args['exact_locations']);
		}

		// output search params of fields, those are not on the search form
		foreach ($this->args AS $arg_name=>$arg_value) {
			if (strpos($arg_name, 'field_') === 0) {
				$is_visible_content_field = false;
				foreach ($this->search_fields_array_all AS $search_field) {
					if ($search_field->isParamOfThisField($arg_name)) {
						$is_visible_content_field = true;
						break;
					}
				}

				if (!$is_visible_content_field)
					$hidden_fields[$arg_name] = $arg_value;
			}
		}
		
		foreach ($hidden_fields AS $name=>$value) {
			if (is_array($value)) {
				foreach ($value AS $val) {
					echo '<input type="hidden" name="' . esc_attr($name) . '[]" value="' . esc_attr($val) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '" />';
			}
		}
	}
	
	public function isDefaultSearchFields() {
		if (
			((!empty($this->args['show_categories_search']) && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)) || !empty($this->args['show_keywords_search'])) ||
			(!empty($this->args['show_listingtype_search']) && alsp_is_anyone_in_taxonomy(ALSP_TYPE_TAX)) ||
			((!empty($this->args['show_locations_search']) && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)) || !empty($this->args['show_address_search']))
		) {
			return true;
		}
	}
	public function isDefaultFieldsLabel() {
		if (!empty($this->args['show_default_filed_label']) && $this->args['show_default_filed_label'] == 1)  {
			return true;
		}
	}
	public function isCategories() {
		if (!empty($this->args['show_categories_search']) && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)) {
			return true;
		}
	}
	public function isListingType() {
		if (!empty($this->args['show_listingtype_search']) && alsp_is_anyone_in_taxonomy(ALSP_TYPE_TAX)) {
			return true;
		}
	}
	public function isKeywords() {
		if (!empty($this->args['show_keywords_search'])) {
			return true;
		}
	}

	public function isKeywordsAJAX() {
		if (!empty($this->args['keywords_ajax_search'])) {
			return true;
		}
	}

	public function isCategoriesOrKeywords() {
		if ($this->isCategories() || $this->isKeywords()) {
			return true;
		}
	}
	
	public function isLocations() {
		if (!empty($this->args['show_locations_search']) && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)) {
			return true;
		}
	}

	public function isAddress() {
		if (!empty($this->args['show_address_search'])) {
			return true;
		}
	}

	public function isLocationsOrAddress() {
		if ($this->isLocations() || $this->isAddress()) {
			return true;
		}
	}

	public function isRadius() {
		if (!empty($this->args['show_radius_search'])) {
			return true;
		}
	}

	public function getKeywordValue() {
		return stripslashes(alsp_getValue($_GET, 'what_search', alsp_getValue($this->args, 'what_search')));
	}

	public function isKeywordsExamples() {
		if (!empty($this->args['keywords_search_examples'])) {
			return true;
		}
	}
	
	public function wrapKeywordsExamples($example) {
		$example = trim($example);
		return "<a href=\"javascript:void(0);\">{$example}</a>";
	}

	public function getKeywordsExamples() {
		$examples = explode(',', $this->args['keywords_search_examples']);
		$wrapped = array_map(
				array($this, "wrapKeywordsExamples"),
				$examples
		);
		return implode(', ', $wrapped);
	}

	public function getAddressValue() {
		return stripslashes(alsp_getValue($_GET, 'address', alsp_getValue($this->args, 'address')));
	}

	public function getRadiusValue() {
		if (!($radius = alsp_getValue($_GET, 'radius', alsp_getValue($this->args, 'radius')))) {
			$radius = 0;
		} else {
			$radius = alsp_getValue($_GET, 'radius', alsp_getValue($this->args, 'radius'));
		}
		return $radius;
	}
	
	public function getCategoriesDropdownsMenuParams($placeholder_category, $placeholder_category_keywords) {
		global $ALSP_ADIMN_SETTINGS;
		$term_id = alsp_getSearchTermID('category-alsp', 'categories', alsp_getValue($this->args, 'category'));
			
		$params = array(
				'tax' => ALSP_CATEGORIES_TAX,
				'field_name' => 'categories',
				'depth' => $this->args['categories_search_level'],
				'term_id' => $term_id,
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search'],
				'uID' => null,
				'exact_terms' => $this->args['exact_categories'],
				'hide_empty' => $ALSP_ADIMN_SETTINGS['alsp_hide_empty_categories'],
				'placeholder' => $placeholder_category,
		);
		if ($this->isKeywords()) {
			$params['placeholder'] = $placeholder_category_keywords;
			$params['autocomplete_field'] = 'what_search';
			$params['autocomplete_field_value'] = $this->getKeywordValue();
			$params['autocomplete_ajax'] = $this->isKeywordsAJAX();
		}
		
		return $params;
	}
	
	public function getListingTypeDropdownsMenuParams($placeholder_listingtype, $placeholder_listingtype_keywords) {
		global $ALSP_ADIMN_SETTINGS;
		$term_id = alsp_getSearchTermID('listingtype-alsp', 'listingtypes', alsp_getValue($this->args, 'listingtype'));
			
		$params = array(
				'tax' => ALSP_TYPE_TAX,
				'field_name' => 'listingtypes',
				'depth' => $this->args['categories_search_level'],
				'term_id' => $term_id,
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_listingtype_count_in_search'],
				'uID' => null,
				'exact_terms' => $this->args['exact_categories'],
				'hide_empty' => $ALSP_ADIMN_SETTINGS['alsp_hide_empty_listngtypes'],
				'placeholder' => $placeholder_listingtype,
		);
		/* if ($this->isKeywords()) {
			$params['placeholder'] = $placeholder_category_keywords;
			$params['autocomplete_field'] = 'what_search';
			$params['autocomplete_field_value'] = $this->getKeywordValue();
			$params['autocomplete_ajax'] = $this->isKeywordsAJAX();
		} */
		
		return $params;
	}

	public function getLocationsDropdownsMenuParams($placeholder_location, $placeholder_locations_address) {
		$term_id = alsp_getSearchTermID('location-alsp', 'location_id', alsp_getValue($this->args, 'location'));

		$params = array(
				'tax' => ALSP_LOCATIONS_TAX,
				'field_name' => 'location_id',
				'depth' => $this->args['locations_search_level'],
				'term_id' => $term_id,
				'count' => get_option('alsp_show_location_count_in_search'),
				'uID' => null,
				'exact_terms' => $this->args['exact_locations'],
				'hide_empty' => get_option('alsp_hide_empty_locations'),
				'placeholder' => $placeholder_location,
		);
		if ($this->isAddress()) {
			$params['placeholder'] = $placeholder_locations_address;
			$params['autocomplete_field'] = 'address';
			$params['autocomplete_field_value'] = $this->getAddressValue();
		}

		return $params;
	}

	public function getColMd() {
		if (
			(empty($this->args['columns']) || $this->args['columns'] == 2) &&
			(($this->args['show_categories_search'] && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)) || $this->args['show_keywords_search']) &&
			(($this->args['show_locations_search'] && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)) || $this->args['show_address_search'])
		) {
			$col_md = 6;

			if ($this->args['on_row_search_button'] && !$this->args['hide_search_button']) {
				$col_md = $col_md - 1;
			}
		} else {
			$col_md = 12;
			
			if ($this->args['on_row_search_button'] && !$this->args['hide_search_button']) {
				$col_md = $col_md - 2;
			}
		}
		
		return $col_md;
	}
	
	public function getSearchFormStyles() {
		if ($this->args['search_custom_style']) {
			$id = uniqid();
			global $alsp_dynamic_styles, $pacz_settings;
			$alsp_styles = '';
			 /* styles */
			$main_search_border_color = $this->args['main_search_border_color'];
			$main_searchbar_bg_color = $this->args['main_searchbar_bg_color'];
			$search_box_padding_top = $this->args['search_box_padding_top'];
			$search_box_padding_bottom = $this->args['search_box_padding_bottom'];
			$search_box_padding_left = $this->args['search_box_padding_left'];
			$search_box_padding_right = $this->args['search_box_padding_right'];
			
			$input_field_bg = $this->args['input_field_bg'];
			$input_field_border_color = $this->args['input_field_border_color'];
			$input_field_placeholder_color = $this->args['input_field_placeholder_color'];
			$input_field_text_color = $this->args['input_field_text_color'];
			$input_field_label_color = $this->args['input_field_label_color'];
			$input_field_border_width = $this->args['input_field_border_width'];
			$input_field_border_radius = $this->args['input_field_border_radius'];
			
			$search_button_border_radius = $this->args['search_button_border_radius'];
			$search_button_bg = $this->args['search_button_bg'];
			$search_button_bg_hover = $this->args['search_button_bg_hover'];
			$search_button_border_color = $this->args['search_button_border_color'];
			$search_button_border_color_hover = $this->args['search_button_border_color_hover'];
			$search_button_border_width = $this->args['search_button_border_width'];
			$search_button_text_color = $this->args['search_button_text_color'];
			$search_button_text_color_hover = $this->args['search_button_text_color_hover'];
			$search_button_icon = $this->args['search_button_icon'];
						
			$search_form_id = "#alsp-search-form-" . $this->search_form_id;
			$alsp_styles .='
				'.$search_form_id.' .search-wrap{
					padding-top:'.$search_box_padding_top.'px;
					padding-bottom:'.$search_box_padding_bottom.'px;
					padding-left:'.$search_box_padding_left.'px;
					padding-right:'.$search_box_padding_right.'px;
				}
				'.$search_form_id.'.alsp-search-form,
				.search-form-style1 .advanced-search-button{
					background:'.$main_searchbar_bg_color.';
					border-color:'.$main_search_border_color.';
				}
				'.$search_form_id.' .search-form-style1 .advanced-search-button a{color:'.$pacz_settings['body-txt-color'].' !important;}

				'.$search_form_id.' .search-wrap .cz-submit-btn.btn.btn-primary{
					background-color:'.$search_button_bg.' !important;
					border-color:'.$search_button_border_color.'!important;
					border-width:'.$search_button_border_width.'px;
					border-radius: '.$search_button_border_radius.'px;
					color:'.$search_button_text_color.'!important;
				}
				'.$search_form_id.' .search-wrap .cz-submit-btn.btn.btn-primary:hover{
					background-color:'.$search_button_bg_hover.'!important;
					border-color:'.$search_button_border_color_hover.'!important;
					color:'.$search_button_text_color_hover.'!important;
				}
				'.$search_form_id.' .search-wrap .form-control{
					background-color:'.$input_field_bg.';
					border-color:'.$input_field_border_color.';
					border-width:'.$input_field_border_width.'px;
					border-radius: '.$input_field_border_radius.'px;
					color:'.$input_field_text_color.';
				}

				'.$search_form_id.' .search-wrap .form-control:focus{
					border-color:'.$input_field_border_color.';
					border-width:'.$input_field_border_width.'px;
					border-radius: '.$input_field_border_radius.'px;
					color:'.$input_field_text_color.';
				}
				'.$search_form_id.' .alsp-search-radius-label{
					color:'.$input_field_label_color.';
				}
				'.$search_form_id.' .search-wrap .form-control::-moz-placeholder,
				'.$search_form_id.' .search-wrap .form-control::placeholder{
					color:'.$input_field_placeholder_color.' !important;
				}
			
			';
			
			// Hidden styles node for head injection after page load through ajax
			echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
			echo '</div>';


			// Export styles to json for faster page load
			$alsp_dynamic_styles[] = array(
			  'id' => 'ajax-'.$id ,
			  'inject' => $alsp_styles
			);
		}
	}
	
	public function displaySearchButton($on_row_search_button = false) {
		if ($on_row_search_button) {
			$classes = "alsp-on-row-button";
		} else {
			$classes = "alsp-col-md-6 alsp-pull-right alsp-text-right";
		}
		echo '<div class="alsp-search-form-button ' . $classes . '">
				<button type="submit" name="submit" class="btn btn-primary ' . (($this->args['hide_search_button']) ? 'alsp-submit-button-hidden' : '') . '">' . __('Search', 'ALSP') . '</button>
			</div>';
	}
	public function displaySearchButton_header($on_row_search_button = false) {
			$classes = "alsp-on-row-button";
		
		echo '<div class="alsp-search-form-button ' . $classes . '">
				<button type="submit" name="submit" class="btn btn-primary ' . (($this->args['hide_search_button']) ? 'alsp-submit-button-hidden' : '') . '"><i class="pacz-fic4-magnifying-glass"></i></button>
			</div>';
	}
	
	public function display() {
		global $alsp_instance;

		// random ID needed because there may be more than 1 search form on one page
		$this->search_form_id = alsp_generateRandomVal();

		if ($this->directories && ($directory_id = $this->directories[0]) &&  ($directory = $alsp_instance->directories->getDirectoryById($directory_id))) {
			$search_url = $directory->url;
		} else {
			$search_url = ($alsp_instance->index_page_url) ? alsp_directoryUrl() : home_url('/');
		}
		
		$search_url = apply_filters('alsp_search_url', $search_url, $this);

		alsp_renderTemplate('views/alsp_searchForm.tpl.php',
			array(
				'search_form_id' => $this->search_form_id,
				'is_advanced_search_panel' => $this->is_advanced_search_panel,
				'advanced_open' => $this->advanced_open,
				'search_url' => $search_url,
				'args' => $this->args,
				'search_form' => $this
			)
		);
	}
	
	/* public function display($advanced_open = 0, $keyword_field_width = 25, $category_field_width = 25, $location_field_width = 25, $address_field_width = 25, $radius_field_width = 25, $button_field_width = 25, $search_button_margin_top = 0, $gap_in_fields = 10, $search_form_type = 1) {
		global $alsp_instance;

		// random ID needed because there may be more than 1 search form on one page
		//$random_id = alsp_generateRandomVal();
		$this->search_form_id = alsp_generateRandomVal();
		
		$search_url = ($alsp_instance->index_page_url) ? alsp_directoryUrl() : home_url('/');

		alsp_renderTemplate('views/alsp_searchForm.tpl.php', array('random_id' => $this->search_form_id, 'advanced_open' => $advanced_open, 'button_field_width' => $button_field_width, 'search_button_margin_top' => $search_button_margin_top, 'keyword_field_width' => $keyword_field_width, 'category_field_width' => $category_field_width, 'location_field_width' => $location_field_width, 'address_field_width' => $address_field_width, 'radius_field_width' => $radius_field_width, 'gap_in_fields' => $gap_in_fields, 'search_form_type' => $search_form_type, 'search_url' => $search_url, 'hash' => $this->uid, 'controller' => $this->controller, 'search_form' => $this));
	} */
}
?>