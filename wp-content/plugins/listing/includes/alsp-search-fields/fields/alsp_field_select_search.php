<?php 

class alsp_content_field_select_search extends alsp_content_field_search {
	public $search_input_mode = 'checkboxes';
	public $checkboxes_operator = 'OR';
	public $items_count = 1;
	
	public function searchConfigure() {
		global $wpdb, $alsp_instance;
	
		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('search_input_mode', __('Search input mode', 'ALSP'), 'required');
			$validation->set_rules('checkboxes_operator', __('Operator for the search', 'ALSP'), 'required');
			$validation->set_rules('items_count', __('Items counter', 'ALSP'), 'is_checked');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('search_options' => serialize(array('search_input_mode' => $result['search_input_mode'], 'checkboxes_operator' => $result['checkboxes_operator'], 'items_count' => $result['items_count']))), array('id' => $this->content_field->id), null, array('%d')))
					alsp_addMessage(__('Search field configuration was updated successfully!', 'ALSP'));
	
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->search_input_mode = $validation->result_array('search_input_mode');
				$this->checkboxes_operator = $validation->result_array('checkboxes_operator');
				$this->items_count = $validation->result_array('items_count');
				alsp_addMessage($validation->error_array(), 'error');
	
				alsp_renderTemplate('alsp-search-fields/fields/select_checkbox_radio_configuration.tpl.php', array('search_field' => $this));
			}
		} else
			alsp_renderTemplate('alsp-search-fields/fields/select_checkbox_radio_configuration.tpl.php', array('search_field' => $this));
	}
	
	public function buildSearchOptions() {
		if (isset($this->content_field->search_options['search_input_mode'])) {
			$this->search_input_mode = $this->content_field->search_options['search_input_mode'];
		}
		if (isset($this->content_field->search_options['checkboxes_operator'])) {
			$this->checkboxes_operator = $this->content_field->search_options['checkboxes_operator'];
		}
		if (isset($this->content_field->search_options['items_count'])) {
			$this->items_count = $this->content_field->search_options['items_count'];
		}
	}

	public function renderSearch($search_form_id, $columns = 2, $defaults = array(), $gap_in_fields = 10) {
		if ($this->search_input_mode =='radiobutton' && count($this->content_field->selection_items)) {
			$this->content_field->selection_items = array('' => __('All', 'ALSP')) + $this->content_field->selection_items;
		}

		if (is_null($this->value)) {
			if (isset($defaults['field_' . $this->content_field->slug])) {
				$this->value = $defaults['field_' . $this->content_field->slug];
				if (!is_array($this->value)) {
					$this->value = array_filter(explode(',', $this->value), 'strlen');
				}
			}
		}
		
		if (!$this->value) {
			$this->value = array('');
		}
		
		$items_count_array = array();
		if ($this->items_count) {
			global $wpdb, $alsp_instance, $sitepress;
			
			$sql = "
					SELECT COUNT(DISTINCT(pm.post_id)) AS count, pm.meta_value FROM {$wpdb->posts} AS po
					LEFT JOIN {$wpdb->postmeta} AS pm ON po.ID = pm.post_id"

					. ($alsp_instance->directories->isMultiDirectory() ? " LEFT JOIN {$wpdb->postmeta} AS pm1 ON po.ID = pm1.post_id " : " ")
					
					. ((function_exists('wpml_object_id_filter') && $sitepress) ? " LEFT JOIN {$wpdb->prefix}icl_translations ON po.ID = {$wpdb->prefix}icl_translations.element_id " : " ")
					
					. "WHERE 
						pm.meta_key = '_content_field_" . $this->content_field->id . "'
					AND
						po.post_status = 'publish'"
								
					. ($alsp_instance->directories->isMultiDirectory() ? " AND
						pm1.meta_key = '_directory_id'
					AND
						pm1.meta_value = " . $alsp_instance->current_directory->id . " " : " ")
						
					. ((function_exists('wpml_object_id_filter') && $sitepress) ? " AND
						{$wpdb->prefix}icl_translations.language_code = '".ICL_LANGUAGE_CODE."' " : " ")
						
					. "GROUP BY pm.meta_value
			";
			
			$items_count_results = $wpdb->get_results($sql, ARRAY_A);
			
			foreach ($items_count_results AS $items_count) {
				$items_count_array[$items_count['meta_value']] = $items_count['count'];
			}
		}

		alsp_renderTemplate('alsp-search-fields/fields/select_checkbox_radio_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'gap_in_fields' => $gap_in_fields, 'items_count_array' => $items_count_array, 'search_form_id' => $search_form_id));
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		$field_index = 'field_' . $this->content_field->slug;
	
		if ($include_GET_params)
			$this->value = ((alsp_getValue($_REQUEST, $field_index, false) !== false) ? alsp_getValue($_REQUEST, $field_index) : alsp_getValue($defaults, $field_index));
		else
			$this->value = alsp_getValue($defaults, $field_index, false);

		if ($this->value) {
			if (!is_array($this->value)) {
				$this->value = array_filter(explode(',', $this->value), 'strlen');
			}

			$args['meta_query']['relation'] = 'AND';
			if ($this->checkboxes_operator == 'OR') {
				$args['meta_query'][] = array(
						'key' => '_content_field_' . $this->content_field->id,
						'value' => $this->value,
						'compare' => 'IN'
				);
			} elseif ($this->checkboxes_operator == 'AND') {
				foreach ($this->value AS $val) {
					$args['meta_query'][] = array(
							'key' => '_content_field_' . $this->content_field->id,
							'value' => $val
					);
				}
			}
		}
	}
	
	public function getVCParams() {
		return array(
				array(
						'type' => 'checkbox',
						'param_name' => 'field_' . $this->content_field->slug,
						'heading' => $this->content_field->name,
						'value' => array_flip($this->content_field->selection_items),
				),
		);
	}
	
	public function resetValue() {
		$this->value = array();
	}
}
?>