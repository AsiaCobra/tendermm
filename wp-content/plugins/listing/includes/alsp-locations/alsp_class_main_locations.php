<?php 

class alsp_locations_manager {
	
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'removeLocationsMetabox'));
		add_action('add_meta_boxes', array($this, 'addLocationsMetabox'), 300);
		
		add_action('wp_ajax_alsp_tax_dropdowns_hook', 'alsp_tax_dropdowns_updateterms');
		add_action('wp_ajax_nopriv_alsp_tax_dropdowns_hook', 'alsp_tax_dropdowns_updateterms');

		add_action('wp_ajax_alsp_add_location_in_metabox', array($this, 'add_location_in_metabox'));
		add_action('wp_ajax_nopriv_alsp_add_location_in_metabox', array($this, 'add_location_in_metabox'));

		add_action('wp_ajax_alsp_select_map_icon', array($this, 'select_map_icon'));
		add_action('wp_ajax_nopriv_alsp_select_map_icon', array($this, 'select_map_icon'));

		if (alsp_isListingEditPageInAdmin()) {
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'));
		}
		if (alsp_isLocationsEditPageInAdmin()) {
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_location_edit_scripts'));
		}

		add_filter('manage_' . ALSP_LOCATIONS_TAX . '_custom_column', array($this, 'taxonomy_rows'), 15, 3);
		add_filter('manage_edit-' . ALSP_LOCATIONS_TAX . '_columns',  array($this, 'taxonomy_columns'));
		add_action(ALSP_LOCATIONS_TAX . '_edit_form_fields', array($this, 'edit_tag_form'));
		add_action(ALSP_LOCATIONS_TAX . '_edit_form_fields', array($this, 'select_image_form'));
		add_action('edit_term', array($this, 'save_image'), 10, 3);

		add_action('wp_ajax_alsp_select_location_icon_dialog', array($this, 'select_location_icon_dialog'));
		add_action('wp_ajax_alsp_select_location_icon', array($this, 'select_location_icon'));
	}
	
	// remove native locations taxonomy metabox from sidebar
	public function removeLocationsMetabox() {
		remove_meta_box(ALSP_LOCATIONS_TAX . 'div', ALSP_POST_TYPE, 'side');
	}
	
	public function addLocationsMetabox($post_type) {
		if ($post_type == ALSP_POST_TYPE && ($level = alsp_getCurrentListingInAdmin()->level) && $level->locations_number > 0) {
			add_meta_box('alsp_locations',
					__('Listing locations', 'ALSP'),
					array($this, 'listingLocationsMetabox'),
					ALSP_POST_TYPE,
					'normal',
					'high');
		}
	}

	public function listingLocationsMetabox($post) {
		global $alsp_instance;
			
		$listing = alsp_getCurrentListingInAdmin();
		$locations_levels = $alsp_instance->locations_levels;
		alsp_renderTemplate('alsp-locations/alsp_metabox.tpl.php', array('listing' => $listing, 'locations_levels' => $locations_levels));
	}
	
	public function add_location_in_metabox() {
		global $alsp_instance;
			
		if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
			$listing = new alsp_listing();
			$listing->loadListingFromPost($_POST['post_id']);
	
			$locations_levels = $alsp_instance->locations_levels;
			alsp_renderTemplate('alsp-locations/alsp_metabox_child.tpl.php', array('listing' => $listing, 'location' => new alsp_location, 'locations_levels' => $locations_levels, 'delete_location_link' => true));
		}
		die();
	}
	
	public function select_map_icon() {
		$custom_map_icons = array();
	
		$custom_map_icons_themes = scandir(ALSP_MAP_ICONS_PATH . 'icons/');
		foreach ($custom_map_icons_themes AS $dir) {
			if (is_dir(ALSP_MAP_ICONS_PATH . 'icons/' . $dir) && $dir != '.' && $dir != '..') {
				$custom_map_icons_theme_files = scandir(ALSP_MAP_ICONS_PATH . 'icons/' . $dir);
				foreach ($custom_map_icons_theme_files AS $file)
					if (is_file(ALSP_MAP_ICONS_PATH . 'icons/' . $dir . '/' . $file) && $file != '.' && $file != '..')
						$custom_map_icons[$dir][] = $file;
			} elseif (is_file(ALSP_MAP_ICONS_PATH . 'icons/' . $dir) && $dir != '.' && $dir != '..')
				$custom_map_images['..'][] = $dir;
		}
	
		alsp_renderTemplate('alsp-locations/alsp_icons.tpl.php', array('custom_map_icons' => $custom_map_icons));
		die();
	}

	public function validateLocations($level, &$errors) {
		global $alsp_instance;

		$validation = new alsp_form_validation();
		$validation->set_rules('alsp_location[]', __('Ad Location', 'ALSP'), 'is_natural');
		$validation->set_rules('selected_tax[]', __('Selected Location', 'ALSP'), 'is_natural');
		$validation->set_rules('address_line_1[]', __('Address line 1', 'ALSP'));
		$validation->set_rules('address_line_2[]', __('Address line 2', 'ALSP'));
		$validation->set_rules('zip_or_postal_index[]', __('Zip code', 'ALSP'));
		$validation->set_rules('additional_info[]', __('Additional info', 'ALSP'));
		$validation->set_rules('manual_coords[]', __('Use manual coordinates', 'ALSP'), 'is_checked');
		$validation->set_rules('map_coords_1[]', __('Latitude', 'ALSP'), 'numeric');
		$validation->set_rules('map_coords_2[]', __('Longitude', 'ALSP'), 'numeric');
		$validation->set_rules('map_icon_file[]', __('Map icon file', 'ALSP'));
		$validation->set_rules('map_zoom', __('Map zoom', 'ALSP'), 'is_natural');
	
		if (!$validation->run()) {
			$errors[] = $validation->error_array();
			//return false;
		} else {
			$passed = true;
			if ($alsp_instance->content_fields->getContentFieldBySlug('address')->is_required) {
				$address_passed = true;
				if ($validation_results = $validation->result_array()) {
					foreach ($validation_results['alsp_location[]'] AS $key=>$value) {
						if (!$validation_results['selected_tax[]'][$key] && !$validation_results['address_line_1[]'][$key] && !$validation_results['zip_or_postal_index[]'][$key])
							$address_passed = false;
					}
				}
				if (!$address_passed) {
					$errors[] = __('Location, address or zip is required!', 'ALSP');
					$passed = false;
				}
			}
				
			if ($level->map && get_option('alsp_map_markers_required')) {
				$map_passed = false;
				if ($validation_results = $validation->result_array()) {
					foreach ($validation_results['alsp_location[]'] AS $key=>$value) {
						if ($validation_results['map_coords_1[]'][$key] || $validation_results['map_coords_2[]'][$key])
							$map_passed = true;
					}
				}
				if (!$map_passed) {
					$errors[] = __('Listing must contain at least one map marker!', 'ALSP');
					$passed = false;
				}
			}

			//if ($passed)
				return $validation->result_array();
			//else 
				//return false;
		}
	}
	
	public function saveLocations($level, $post_id, $validation_results) {
		global $wpdb;
	
		$this->deleteLocations($post_id);
	
		if (isset($validation_results['alsp_location[]'])) {
			// remove unauthorized locations
			$validation_results['alsp_location[]'] = array_slice($validation_results['alsp_location[]'], 0, $level->locations_number, true);
	
			foreach ($validation_results['alsp_location[]'] AS $key=>$value) {
				if (
					$validation_results['selected_tax[]'][$key] ||
					$validation_results['address_line_1[]'][$key] ||
					$validation_results['address_line_2[]'][$key] ||
					$validation_results['zip_or_postal_index[]'][$key] ||
					($level->map && ($validation_results['map_coords_1[]'][$key] || $validation_results['map_coords_2[]'][$key]))
				) {
					$insert_values = array(
							'post_id' => $post_id,
							'location_id' => esc_sql($validation_results['selected_tax[]'][$key]),
							'address_line_1' => esc_sql($validation_results['address_line_1[]'][$key]),
							'address_line_2' => esc_sql($validation_results['address_line_2[]'][$key]),
							'zip_or_postal_index' => esc_sql($validation_results['zip_or_postal_index[]'][$key]),
							'additional_info' => (isset($validation_results['additional_info[]'][$key]) ? esc_sql($validation_results['additional_info[]'][$key]) : ''),
					);
					if ($level->map) {
						if (is_array($validation_results['manual_coords[]'])) {
							if (in_array($key, array_keys($validation_results['manual_coords[]'])) && $validation_results['manual_coords[]'][$key])
								$insert_values['manual_coords'] = 1;
							else
								$insert_values['manual_coords'] = 0;
						} else
							$insert_values['manual_coords'] = 0;
						$insert_values['map_coords_1'] = $validation_results['map_coords_1[]'][$key];
						$insert_values['map_coords_2'] = $validation_results['map_coords_2[]'][$key];
						if ($level->map_markers)
							$insert_values['map_icon_file'] = esc_sql($validation_results['map_icon_file[]'][$key]);
					}
					$keys = array_keys($insert_values);

					// duplicate locations data in postmeta in order to export it as ordinary wordpress fields
					foreach ($keys AS $key) {
						if ($key != 'post_id') {
							add_post_meta($post_id, '_'.$key, $insert_values[$key]);
						}
					}
					
					array_walk($keys, 'alsp_wrapKeys');
					array_walk($insert_values, 'alsp_wrapValues');
					$wpdb->query("INSERT INTO {$wpdb->alsp_locations_relationships} (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $insert_values) . ")");
				}
			}

			if ($validation_results['selected_tax[]']) {
				array_walk($validation_results['selected_tax[]'], 'alsp_wrapIntVal');
				wp_set_object_terms($post_id, $validation_results['selected_tax[]'], ALSP_LOCATIONS_TAX);
			}
	
			add_post_meta($post_id, '_map_zoom', $validation_results['map_zoom']);
		}
	}

	public function deleteLocations($post_id) {
		global $wpdb;

		$wpdb->delete($wpdb->alsp_locations_relationships, array('post_id' => $post_id));
		wp_delete_object_term_relationships($post_id, ALSP_LOCATIONS_TAX);
		delete_post_meta($post_id, '_location_id');
		delete_post_meta($post_id, '_address_line_1');
		delete_post_meta($post_id, '_address_line_2');
		delete_post_meta($post_id, '_zip_or_postal_index');
		delete_post_meta($post_id, '_additional_info');
		delete_post_meta($post_id, '_manual_coords');
		delete_post_meta($post_id, '_map_coords_1');
		delete_post_meta($post_id, '_map_coords_2');
		delete_post_meta($post_id, '_map_icon_file');
		delete_post_meta($post_id, '_map_zoom');
	}
	
	public function taxonomy_columns($original_columns) {
		$new_columns = $original_columns;
		array_splice($new_columns, 1);
		$new_columns['alsp_location_id'] = __('Location ID', 'ALSP');
		//$new_columns['alsp_location_image'] = __('Image', 'ALSP');
		$new_columns['alsp_location_icon'] = __('Icon', 'ALSP');
		if (isset($original_columns['description']))
			unset($original_columns['description']);
		return array_merge($new_columns, $original_columns);
	}
	
	public function taxonomy_rows($row, $column_name, $term_id) {
		if ($column_name == 'alsp_location_id') {
			return $row . $term_id;
		}
		if ($column_name == 'alsp_location_image') {
			$url = $this->get_featured_image_url($term_id);
			return $row . '<a href="' . get_edit_term_link($term_id, ALSP_LOCATIONS_TAX, ALSP_POST_TYPE) . '">' . ($url ? '<img src="' . $url . '" width="100" /><br />' : '') . __("Select image", "ALSP") . '</a>';
		}
		if ($column_name == 'alsp_location_icon') {
			return $row . $this->choose_icon_link($term_id);
		}
		return $row;
	}
	
	public function edit_tag_form($term) {
		alsp_renderTemplate('alsp-locations/alsp_icon_form.tpl.php', array('term' => $term));
	}
	
	public function choose_icon_link($term_id) {
		$icon_file = $this->getLocationIconFile($term_id);
		alsp_renderTemplate('alsp-locations/alsp_icon_link.tpl.php', array('term_id' => $term_id, 'icon_file' => $icon_file));
	}
	
	public function getLocationIconFile($term_id) {
		return alsp_getLocationIconFile($term_id);
	}
	
	public function select_location_icon_dialog() {
		$locations_icons = array();
	
		$locations_icons_files = scandir(ALSP_LOCATION_ICONS_PATH);
		foreach ((array) $locations_icons_files AS $file)
			if (is_file(ALSP_LOCATION_ICONS_PATH . $file) && $file != '.' && $file != '..')
				$locations_icons[] = $file;
	
		alsp_renderTemplate('alsp-locations/alsp_icons_dialog.tpl.php', array('locations_icons' => $locations_icons));
		die();
	}
	
	public function select_location_icon() {
		if (isset($_POST['location_id']) && is_numeric($_POST['location_id'])) {
			$location_id = intval($_POST['location_id']);
			$icons = (array) get_option('alsp_locations_icons');
			if (isset($_POST['icon_file']) && $_POST['icon_file']) {
				$icon_file = $_POST['icon_file'];
				if (is_file(ALSP_LOCATION_ICONS_PATH . $icon_file)) {
					$icons[$location_id] = $icon_file;
					update_option('alsp_locations_icons', $icons);
					echo $location_id;
				}
			} else {
				if (isset($icons[$location_id]))
					unset($icons[$location_id]);
				update_option('alsp_locations_icons', $icons);
			}
		}
		die();
	}
	
	// Location Featured Image
	public function get_featured_image_id($term_id) {
		if (($images = get_option('alsp_locations_images')) && is_array($images) && isset($images[$term_id])) {
			return $images[$term_id];
		}
	}
	public function get_featured_image_url($term_id, $size = 'full') {
		if ($image_id = $this->get_featured_image_id($term_id)) {
			$src = wp_get_attachment_image_src($image_id, $size);
			return is_array($src) ? $src[0] : null;
		}
	}
	public function select_image_form($term) {
		$attachment_id = $this->get_featured_image_id($term->term_id);
		$image_url = $this->get_featured_image_url($term->term_id);
	
		alsp_renderTemplate('alsp-locations/alsp_image_form.tpl.php', array('term' => $term, 'attachment_id' => $attachment_id, 'image_url' => $image_url));
	}
	public function save_image($term_id, $tt_id, $taxonomy) {
		if ($taxonomy == ALSP_LOCATIONS_TAX) {
			// Ignore quick edit
			if (isset($_POST['action']) && $_POST['action'] == 'inline-save-tax') {
				return;
			}
		
			$attachment_id = isset($_POST['location_image_attachment_id']) ? (int)$_POST['location_image_attachment_id'] : null;
		
			$locations_images = (array) get_option('alsp_locations_images');
			if (!empty($attachment_id)) {
				$locations_images[$term_id] = $attachment_id;
			} else {
				if (isset($locations_images[$term_id])) {
					unset($locations_images[$term_id]);
				}
			}
			update_option('alsp_locations_images', $locations_images);
		}
	}
	
	public function admin_enqueue_scripts_styles() {
		wp_localize_script(
				'alsp_applications',
				'alsp_maps_callback',
				array(
						'callback' => 'alsp_load_maps_api_backend'
				)
		);
	}
	
	public function admin_enqueue_location_edit_scripts() {
		wp_enqueue_script('alsp_locations_edit_scripts');
		wp_localize_script(
				'alsp_locations_edit_scripts',
				'locations_icons',
				array(
						'locations_icons_url' => ALSP_LOCATIONS_ICONS_URL,
						'ajax_dialog_title' => __('Select location icon', 'ALSP')
				)
		);
		wp_enqueue_media();
	}
}

?>