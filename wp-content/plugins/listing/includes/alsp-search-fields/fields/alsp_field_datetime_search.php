<?php 

class alsp_content_field_datetime_search extends alsp_content_field_search {
	public $min_max_value;
	
	public function isParamOfThisField($param) {
		if ($param == 'field_' . $this->content_field->slug . '_min' || $param == 'field_' . $this->content_field->slug . '_max') {
			return true;
		}
	}

	public function renderSearch($search_form_id, $columns = 2, $defaults = array(), $gap_in_fields = 10) {
		wp_enqueue_script('jquery-ui-datepicker');

		if (is_null($this->min_max_value)) {
			if (isset($defaults['field_' . $this->content_field->slug . '_min'])) {
				$val = $defaults['field_' . $this->content_field->slug . '_min'];
				if (!is_numeric($val)) {
					$val = strtotime($val);
				}
				$this->min_max_value['min'] = $val;
			}
			if (isset($defaults['field_' . $this->content_field->slug . '_max'])) {
				$val = $defaults['field_' . $this->content_field->slug . '_max'];
				if (!is_numeric($val)) {
					$val = strtotime($val);
				}
				$this->min_max_value['max'] = $val;
			}
		}
		
		if ($i18n_file = alsp_getDatePickerLangFile(get_locale())) {
			wp_register_script('datepicker-i18n', $i18n_file, array('jquery-ui-datepicker'));
			wp_enqueue_script('datepicker-i18n');
		}

		alsp_renderTemplate('alsp-search-fields/fields/datetime_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'gap_in_fields' => $gap_in_fields, 'dateformat' => alsp_getDatePickerFormat(), 'search_form_id' => $search_form_id));
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		global $wpdb;
		
		$field_index = 'field_' . $this->content_field->slug . '_min';
		if ($include_GET_params) {
			$this->min_max_value['min'] = ((alsp_getValue($_REQUEST, $field_index, false) !== false) ? alsp_getValue($_REQUEST, $field_index) : alsp_getValue($defaults, $field_index));
		} else {
			$this->min_max_value['min'] = alsp_getValue($defaults, $field_index, false);
		}
		
		$field_index = 'field_' . $this->content_field->slug . '_max';
		if ($include_GET_params) {
			$this->min_max_value['max'] = ((alsp_getValue($_REQUEST, $field_index, false) !== false) ? alsp_getValue($_REQUEST, $field_index) : alsp_getValue($defaults, $field_index));
		} else {
			$this->min_max_value['max'] = alsp_getValue($defaults, $field_index, false);
		}

		$wheres = array();
		if ($this->min_max_value['min'] !== false && ((is_numeric($this->min_max_value['min']) && $this->min_max_value['min'] > 0) || strtotime($this->min_max_value['min']))) {
			$wheres[] = "(meta1.meta_key = '_content_field_" . $this->content_field->id . "_date_end' AND CAST(meta1.meta_value AS SIGNED) >= " . $this->min_max_value['min'] . ")";
		}
		if ($this->min_max_value['max'] !== false && ((is_numeric($this->min_max_value['max']) && $this->min_max_value['max'] > 0) || strtotime($this->min_max_value['max']))) {
			$wheres[] = "(meta2.meta_key = '_content_field_" . $this->content_field->id . "_date_start' AND CAST(meta2.meta_value AS SIGNED) <= " . $this->min_max_value['max'] . ")";
		}

		if ($wheres) {
			$query = "SELECT meta1.post_id FROM {$wpdb->postmeta} AS meta1 INNER JOIN {$wpdb->postmeta} AS meta2 ON meta1.post_id = meta2.post_id WHERE (" . implode(" AND ", $wheres) . ")";

			$posts_in = array();
			$results = $wpdb->get_results($query, ARRAY_A);
			foreach ($results AS $row) {
				$posts_in[] = $row['post_id'];
			}
			if ($posts_in) {
				$posts_in = array_unique($posts_in);
				
				$args = array_merge($args, array('post__in' => $posts_in));
			} else {
				$args['post__in'] = array(0);
			}
		}
	}
	
	public function getBaseUrlArgs(&$args) {
		$field_index = 'field_' . $this->content_field->slug . '_min';
		if (isset($_REQUEST[$field_index]) && $_REQUEST[$field_index] && is_numeric($_REQUEST[$field_index]))
			$args[$field_index] = $_REQUEST[$field_index];
	
		$field_index = 'field_' . $this->content_field->slug . '_max';
		if (isset($_REQUEST[$field_index]) && $_REQUEST[$field_index] && is_numeric($_REQUEST[$field_index]))
			$args[$field_index] = $_REQUEST[$field_index];
	}
	
	public function getVCParams() {
		return array(
				array(
					'type' => 'datefieldmin',
					'param_name' => 'field_' . $this->content_field->slug . '_min',
					'heading' => __('From ', 'ALSP') . $this->content_field->name,
					'field_id' => $this->content_field->id,
				),
				array(
					'type' => 'datefieldmax',
					'param_name' => 'field_' . $this->content_field->slug . '_max',
					'heading' => __('To ', 'ALSP') . $this->content_field->name,
					'field_id' => $this->content_field->id,
				)
			);
	}
	
	public function resetValue() {
		$this->min_max_value = array('min' => '', 'max' => '');
	}
}

add_action('vc_before_init', 'alsp_vc_init_datefield');
function alsp_vc_init_datefield() {
	vc_add_shortcode_param('datefieldmin', 'alsp_datefieldmin_param');
	vc_add_shortcode_param('datefieldmax', 'alsp_datefieldmax_param');

	if (!function_exists('alsp_datefieldmin_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		function alsp_datefieldmin_param($settings, $value) {
			if (!is_numeric($value))
				$value = strtotime($value);
			return alsp_renderTemplate('alsp-search-fields/fields/datetime_input_vc_min.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => alsp_getDatePickerFormat()), true);
		}
	}
	if (!function_exists('alsp_datefieldmax_param')) { // some "unique" themes/plugins call vc_before_init more than ones - this is such protection
		function alsp_datefieldmax_param($settings, $value) {
			if (!is_numeric($value))
				$value = strtotime($value);
			return alsp_renderTemplate('alsp-search-fields/fields/datetime_input_vc_max.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => alsp_getDatePickerFormat()), true);
		}
	}
}
?>