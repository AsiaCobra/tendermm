<?php 

class alsp_content_field_price extends alsp_content_field {
	public $currency_symbol = '$';
	public $decimal_separator = ',';
	public $thousands_separator = ' ';
	public $symbol_position = 1;
	public $hide_decimals = 0;

	protected $is_configuration_page = true;
	protected $is_search_configuration_page = true;
	protected $can_be_searched = true;
	
	public function isNotEmpty($listing) {
		if ($this->value) {
			return true;
		} else {
			return false;
		}
	}

	public function configure() {
		global $wpdb, $alsp_instance;

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('currency_symbol', __('Currency symbol', 'ALSP'), 'required');
			$validation->set_rules('decimal_separator', __('Decimal separator', 'ALSP'), 'required|max_length[1]');
			$validation->set_rules('thousands_separator', __('Thousands separator', 'ALSP'), 'max_length[1]');
			$validation->set_rules('symbol_position', __('Currency symbol position', 'ALSP'), 'integer');
			$validation->set_rules('hide_decimals', __('Hide decimals', 'ALSP'), 'required');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(
						array(
								'currency_symbol' => $result['currency_symbol'],
								'decimal_separator' => $result['decimal_separator'],
								'thousands_separator' => $result['thousands_separator'],
								'symbol_position' => $result['symbol_position'],
								'hide_decimals' => $result['hide_decimals'],
						)
					)), array('id' => $this->id), null, array('%d'))) {
						alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
				}
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->currency_symbol = $validation->result_array('currency_symbol');
				$this->decimal_separator = $validation->result_array('decimal_separator');
				$this->thousands_separator = $validation->result_array('thousands_separator');
				$this->symbol_position = $validation->result_array('symbol_position');
				$this->hide_decimals = $validation->result_array('hide_decimals');
				alsp_addMessage($validation->error_array(), 'error');

				alsp_renderTemplate('alsp_fields/fields/alsp_price_configuration.tpl.php', array('content_field' => $this));
			}
		} else
			alsp_renderTemplate('alsp_fields/fields/alsp_price_configuration.tpl.php', array('content_field' => $this));
	}
	
	public function buildOptions() {
		if (isset($this->options['currency_symbol'])) {
			$this->currency_symbol = $this->options['currency_symbol'];
		}
		if (isset($this->options['decimal_separator'])) {
			$this->decimal_separator = $this->options['decimal_separator'];
		}
		if (isset($this->options['thousands_separator'])) {
			$this->thousands_separator = $this->options['thousands_separator'];
		}
		if (isset($this->options['symbol_position'])) {
			$this->symbol_position = $this->options['symbol_position'];
		}
		if (isset($this->options['hide_decimals'])) {
			$this->hide_decimals = $this->options['hide_decimals'];
		}
	}
	
	public function renderInput() {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_price_input_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_price_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_renderTemplate($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;
	
		$validation = new alsp_form_validation();
		$rules = 'numeric';
		if ($this->canBeRequired() && $this->is_required)
			$rules .= '|required';
		$validation->set_rules($field_index, $this->name, $rules);
		if (!$validation->run()) {
			$errors[] = $validation->error_array();
		}

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
		if (is_numeric($this->value)) {
			if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_price_output_'.$this->id.'.tpl.php'))) {
				$template = 'alsp_fields/fields/alsp_price_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
				
			alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
		}
	}
	
	public function orderParams() {
		global $ALSP_ADIMN_SETTINGS;
		$order_params = array('orderby' => 'meta_value_num', 'meta_key' => '_content_field_' . $this->id);
		if ($ALSP_ADIMN_SETTINGS['alsp_orderby_exclude_null']){
			$order_params['meta_query'] = array(
				array(
					'key' => '_content_field_' . $this->id,
					'value'   => array(''),
					'compare' => 'NOT IN'
				)
			);
		}
		return $order_params;
	}
	
	public function validateCsvValues($value, &$errors) {
		if (!is_numeric($value)) {
			$errors[] = sprintf(__('The %s field must contain only numbers.', 'ALSP'), $this->name);
		}

		return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		if (is_numeric($this->value)) {
			return $this->formatPrice();
		}
	}
	
	public function formatPrice($value = null) {
		if (is_null($value)) {
			$value = $this->value;
		}
		if ($this->hide_decimals) {
			$decimals = 0;
		} else {
			$decimals = 2;
		}
		$formatted_price = number_format($value, $decimals, $this->decimal_separator, $this->thousands_separator);

		$out = $formatted_price;
		$symbol_pre = '<span>';
		$symbol_post = '</span>';
		switch ($this->symbol_position) {
			case 1:
				$out = $symbol_pre . $this->currency_symbol . $symbol_post . $out;
				break;
			case 2:
				$out = $symbol_pre . $this->currency_symbol . $symbol_post. ' ' . $out;
				break;
			case 3:
				$out = $out . $symbol_pre . $this->currency_symbol . $symbol_post;
				break;
			case 4:
				$out = $out . ' ' . $symbol_pre.$this->currency_symbol . $symbol_post;
				break;
		}
		return $out;
	}
}
?>