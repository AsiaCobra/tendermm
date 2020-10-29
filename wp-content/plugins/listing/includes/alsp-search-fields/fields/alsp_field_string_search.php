<?php 

class alsp_content_field_string_search extends alsp_content_field_search {
	public $search_input_mode = 'keywords';
	
	public function searchConfigure() {
		global $wpdb, $alsp_instance;
	
		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('search_input_mode', __('Search input mode', 'ALSP'), 'required');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('search_options' => serialize(array('search_input_mode' => $result['search_input_mode']))), array('id' => $this->content_field->id), null, array('%d')))
					alsp_addMessage(__('Search field configuration was updated successfully!', 'ALSP'));
	
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->search_input_mode = $validation->result_array('search_input_mode');
				alsp_addMessage($validation->error_array(), 'error');
	
				alsp_renderTemplate('alsp-search-fields/fields/string_textarea_configuration.tpl.php', array('search_field' => $this));
			}
		} else
			alsp_renderTemplate('alsp-search-fields/fields/string_textarea_configuration.tpl.php', array('search_field' => $this));
	}
	
	public function buildSearchOptions() {
		if (isset($this->content_field->search_options['search_input_mode']))
			$this->search_input_mode = $this->content_field->search_options['search_input_mode'];
	}

	public function renderSearch($search_form_id, $columns = 2, $defaults = array(), $gap_in_fields = 10) {
		if ($this->search_input_mode == 'input') {
			if (is_null($this->value) && isset($defaults['field_' . $this->content_field->slug])) {
				$this->value = $defaults['field_' . $this->content_field->slug];
			}
			
			alsp_renderTemplate('alsp-search-fields/fields/string_textarea_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'search_form_id' => $search_form_id));
		}
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		if ($this->search_input_mode == 'input') {
			$field_index = 'field_' . $this->content_field->slug;
	
			if ($include_GET_params)
				$this->value = ((alsp_getValue($_REQUEST, $field_index, false) !== false) ? alsp_getValue($_REQUEST, $field_index) : alsp_getValue($defaults, $field_index));
			else
				$this->value = alsp_getValue($defaults, $field_index, false);
	
			if ($this->value !== false && $this->value !== "") {
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][] = array(
						'key' => '_content_field_' . $this->content_field->id,
						'value' => stripslashes($this->value),
						'compare' => 'LIKE'
				);
			}
		} elseif ($this->search_input_mode == 'keywords' && $this->content_field->on_search_form) {
			if (!empty($args['s'])) {
				$this->value = $args['s'];
	
				//var_dump($include_GET_params);
				//if (!has_filter('posts_clauses', array($this, 'postsClauses'))) {
					//var_dump(11);
					add_filter('posts_clauses', array($this, 'postsClauses'), 11, 2);
				//}
			}
		}
	}
	
	public function postsClauses($clauses, $q) {
		global $wpdb;

		$postmeta_table = 'alsp_postmeta_' . $this->content_field->id;
		
		if ($this->value && strpos($clauses['join'], $postmeta_table) === false) { 
			$clauses['join'] .=' LEFT JOIN '.$wpdb->postmeta. ' AS ' . $postmeta_table . ' ON '. $wpdb->posts . '.ID = ' . $postmeta_table . '.post_id ';
			
			$postmeta_where = ' AND ' . $postmeta_table . '.meta_key = "_content_field_' . $this->content_field->id . '" ';
			
			$clauses['where'] = preg_replace(
					"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
					"(".$wpdb->posts.".post_title LIKE $1) OR (".$postmeta_table.".meta_value LIKE $1 ".$postmeta_where.")", $clauses['where']);
			
			// Add GROUP BY posts.ID (for some occasions it becomes missing in the result query)
			$clauses['groupby'] = "{$wpdb->posts}.ID";
		}
		
		return $clauses;
	}
	
	public function getVCParams() {
		return array(
				array(
						'type' => 'textfield',
						'param_name' => 'field_' . $this->content_field->slug,
						'heading' => $this->content_field->name,
				),
		);
	}
}
?>