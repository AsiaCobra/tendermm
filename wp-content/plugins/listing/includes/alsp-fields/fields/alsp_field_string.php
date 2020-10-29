<?php 

class alsp_content_field_string extends alsp_content_field {
	public $max_length = 255;
	public $regex;
	public $is_phone;
	
	protected $can_be_searched = true;
	protected $is_configuration_page = true;
	protected $is_search_configuration_page = true;
	
	public function isNotEmpty($listing) {
		if ($this->value)
			return true;
		else
			return false;
	}

	public function configure() {
		global $wpdb, $alsp_instance;

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('max_length', __('Max length', 'ALSP'), 'required|is_natural_no_zero');
			$validation->set_rules('regex', __('PHP RegEx template', 'ALSP'));
			$validation->set_rules('is_phone', __('Is phone field', 'ALSP'), 'is_checked');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(array('max_length' => $result['max_length'], 'regex' => $result['regex'], 'is_phone' => $result['is_phone']))), array('id' => $this->id), null, array('%d')))
					alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->max_length = $validation->result_array('max_length');
				$this->regex = $validation->result_array('regex');
				$this->is_phone = $validation->result_array('is_phone');
				alsp_addMessage($validation->error_array(), 'error');

				alsp_renderTemplate('alsp_fields/fields/alsp_string_configuration.tpl.php', array('content_field' => $this));
			}
		} else
			alsp_renderTemplate('alsp_fields/fields/alsp_string_configuration.tpl.php', array('content_field' => $this));
	}
	
	public function buildOptions() {
		if (isset($this->options['max_length']))
			$this->max_length = $this->options['max_length'];

		if (isset($this->options['regex']))
			$this->regex = $this->options['regex'];

		if (isset($this->options['is_phone']))
			$this->is_phone = $this->options['is_phone'];
		
	}
	
	public function renderInput() {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_string_input_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_string_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_renderTemplate($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;
		
		if (isset($_POST[$field_index]) && $_POST[$field_index] && $this->regex)
			if (@!preg_match('/^' . $this->regex . '$/', $_POST[$field_index]))
				$errors[] = sprintf(__("Field %s doesn't match template!", 'ALSP'), $this->name);

		$validation = new alsp_form_validation();
		$rules = 'max_length[' . $this->max_length . ']';
		if ($this->canBeRequired() && $this->is_required)
			$rules .= '|required';
		$validation->set_rules($field_index, $this->name, $rules);
		if (!$validation->run())
			$errors[] = $validation->error_array();

		return $validation->result_array($field_index);
	}
	
	public function saveValue($post_id, $validation_results) {
		return update_post_meta($post_id, '_content_field_' . $this->id, $validation_results);
	}
	
	public function loadValue($post_id) {
		$this->value = get_post_meta($post_id, '_content_field_' . $this->id, true);
		
		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	
	public function renderOutput($listing = null) {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_string_output_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_string_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function orderParams() {
		global $ALSP_ADIMN_SETTINGS;
		$order_params = array('orderby' => 'meta_value', 'meta_key' => '_content_field_' . $this->id);
		if ($ALSP_ADIMN_SETTINGS['alsp_orderby_exclude_null'])
			$order_params['meta_query'] = array(
				array(
					'key' => '_content_field_' . $this->id,
					'value'   => array(''),
					'compare' => 'NOT IN'
				)
			);
		return $order_params;
	}

	public function validateCsvValues($value, &$errors) {
		if (!is_string($value))
			$errors[] = sprintf(__('Field %s must be a string!', 'ALSP'), $this->name);
		elseif ($this->regex && @!preg_match('/^' . $this->regex . '$/', $value))
			$errors[] = sprintf(__("Field %s doesn't match template!", 'ALSP'), $this->name);
		elseif (strlen($value) > $this->max_length)
			$errors[] = sprintf(__('The %s field can not exceed %s characters in length.', 'ALSP'), $this->name, $this->max_length);
		else
			return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		if ($this->is_phone) {
			$phone = antispambot($this->value);
			if (function_exists('iconv') && function_exists('mb_detect_encoding') && function_exists('mb_detect_order')) {
				$phone = iconv(mb_detect_encoding($phone, mb_detect_order(), true), "UTF-8", $phone);
			}
			return $phone;
		} else {
			return $this->value;
		}
	}
}
?>