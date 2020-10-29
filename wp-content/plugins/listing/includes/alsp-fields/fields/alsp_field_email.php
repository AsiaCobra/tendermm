<?php 

class alsp_content_field_email extends alsp_content_field {
	protected $can_be_ordered = false;
	
	public function isNotEmpty($listing) {
		if ($this->value)
			return true;
		else
			return false;
	}

	public function renderInput() {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_email_input_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_email_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_renderTemplate($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;

		$validation = new alsp_form_validation();
		$rules = 'valid_email';
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
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_email_output_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_email_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function validateCsvValues($value, &$errors) {
		$validation = new alsp_form_validation();
		if (!$validation->valid_email($value))
			$errors[] = __("Email field is invalid", "ALSP");
		return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		$email = antispambot($this->value);
		if (function_exists('iconv') && function_exists('mb_detect_encoding') && function_exists('mb_detect_order')) {
			$email = iconv(mb_detect_encoding($email, mb_detect_order(), true), "UTF-8", $email);
		}

		return alsp_renderTemplate('alsp_fields/fields/alsp_email_output_map.tpl.php', array('content_field' => $this, 'listing' => $listing, 'email' => $email), true);
	}
}
?>