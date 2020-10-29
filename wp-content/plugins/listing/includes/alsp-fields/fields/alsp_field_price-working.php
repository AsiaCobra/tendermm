<?php 

class alsp_content_field_price extends alsp_content_field {
	public $currency_symbol = '$';
	public $decimal_separator = ',';
	public $thousands_separator = ' ';
	public $symbol_position = 1;
	public $hide_decimals = 0;
	public $range_options = array();
	
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
			$validation->set_rules('range_options[]', __('Range options', 'ALSP'), '');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(
						array(
								'currency_symbol' => $result['currency_symbol'],
								'decimal_separator' => $result['decimal_separator'],
								'thousands_separator' => $result['thousands_separator'],
								'symbol_position' => $result['symbol_position'],
								'hide_decimals' => $result['hide_decimals'],
								'hide_decimals' => $result['hide_decimals'],
								'range_options' => $result['range_options[]'],
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
				$this->range_options = $validation->result_array('range_options[]');
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
		if (isset($this->options['range_options'])) {
			$this->range_options = $this->options['range_options'];
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
		$field_index_end_value = 'alsp-field-input-' . $this->id . '-end';
		$field_index_range_value = 'alsp-field-input-' . $this->id . '-range';
		$validation = new alsp_form_validation();
		$rules = 'numeric';
		$rules2 = 'numeric';
		if ($this->canBeRequired() && $this->is_required)
			$rules .= '|required';
		$validation->set_rules($field_index, $this->name, $rules);
		$validation->set_rules($field_index_end_value, $this->name, $rules);
		$validation->set_rules($field_index_range_value, $this->name, $rules2);
		if (!$validation->run()) {
			$errors[] = $validation->error_array();
		}

		//return $validation->result_array($field_index);
		return array(
			'price_start' => $validation->result_array($field_index),
			'price_end' => $validation->result_array($field_index_end_value),
			'price_range' => $validation->result_array($field_index_range_value)
		);
	}
	
	public function saveValue($post_id, $validation_results) {
		//return update_post_meta($post_id, '_content_field_' . $this->id, $validation_results);
		if ($validation_results && is_array($validation_results)) {
			update_post_meta($post_id, '_content_field_' . $this->id, $validation_results['price_start']);
			update_post_meta($post_id, '_content_field_' . $this->id . '_price_end', $validation_results['price_end']);
			update_post_meta($post_id, '_content_field_' . $this->id . '_price_range', $validation_results['price_range']);
			return true;
		}
	}
	
	public function loadValue($post_id) {
		$this->value = array(
			'price_start' => 0,
			'price_end' => 0
		);
		$price_start = 0;
		$price_end = 0;
		$price_range = '';
		
		$price_start = get_post_meta($post_id, '_content_field_' . $this->id, true);
		if (get_post_meta($post_id, '_content_field_' . $this->id . '_price_end', true)) {
			$price_end = get_post_meta($post_id, '_content_field_' . $this->id . '_price_end', true);
		}
		if (get_post_meta($post_id, '_content_field_' . $this->id . '_price_range', true)) {
			$price_range = get_post_meta($post_id, '_content_field_' . $this->id . '_price_range', true);
		}
		$this->value = array(
			'price_start' => $price_start,
			'price_end' => $price_end,
			'price_range' => $price_range
		);
		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	public function renderRangeOutput($listing = null) {
		
		if ($this->value['price_start'] || $this->value['price_end'] || $this->value['price_range']) {
			if (is_numeric($this->value['price_start'])) {
				$price_start = $this->value['price_start'];
			}
			
			$price_end = $this->value['price_end'];
			$price_range = $this->value['price_range'];
			if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_price_output_range_'.$this->id.'.tpl.php'))) {
				$template = 'alsp_fields/fields/alsp_price_output_range.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			alsp_renderTemplate($template, array('content_field' => $this, 'price_start' => $price_start, 'price_end' => $price_end, 'price_range' => $price_range, 'listing' => $listing));	
			
		}
	}
	public function renderOutput($listing = null) {
		/* if (is_numeric($this->value)) {
			if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_price_output_'.$this->id.'.tpl.php'))) {
				$template = 'alsp_fields/fields/alsp_price_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
				
			alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
		} */
		if ($this->value['price_start'] || $this->value['price_end'] || $this->value['price_range']) {
			if (is_numeric($this->value['price_start'])) {
				$price_start = $this->value['price_start'];
			}
			//if (is_numeric($this->value['price_end'])) {
				$price_end = $this->value['price_end'];
			//}
			//if (isset($this->value['price_range'])) {
				$price_range = $this->value['price_range'];
		//	}
			if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_price_output_'.$this->id.'.tpl.php'))) {
				$template = 'alsp_fields/fields/alsp_price_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
				
			alsp_renderTemplate($template, array('content_field' => $this, 'price_start' => $price_start, 'price_end' => $price_end, 'price_range' => $price_range, 'listing' => $listing));
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
	
	public function formatPrice() {
		if ($this->hide_decimals) {
			$decimals = 0;
		} else {
			$decimals = 2;
		}
		$formatted_price = number_format($this->value['price_start'], $decimals, $this->decimal_separator, $this->thousands_separator);
		$out = $formatted_price;
		 switch ($this->symbol_position) {
			case 1:
				$out = $this->currency_symbol . $out;
				break;
			case 2:
				$out = $this->currency_symbol . ' ' . $out;
				break;
			case 3:
				$out = $out . $this->currency_symbol;
				break;
			case 4:
				$out = $out . ' ' . $this->currency_symbol;
				break;
		}
		
		return $out;
	}
	public function formatPriceEnd() {
		if($this->value['price_end'] == 0){
			return;
		}
			if ($this->hide_decimals) {
				$decimals = 0;
			} else {
				$decimals = 2;
			}
			//$formatted_price = number_format($this->value['price_start'], $decimals, $this->decimal_separator, $this->thousands_separator);
			
			$formatted_price = number_format($this->value['price_end'], $decimals, $this->decimal_separator, $this->thousands_separator);
			$price_split = ' - ';
			$out = $formatted_price;
			switch ($this->symbol_position) {
				case 1:
					$out = $this->currency_symbol . $out;
					break;
				case 2:
					$out = $this->currency_symbol . ' ' . $out;
					break;
				case 3:
					$out = $out . $this->currency_symbol;
					break;
				case 4:
					$out = $out . ' ' . $this->currency_symbol;
					break;
			}
			
			return $price_split . $out;
		
	}
	public function RangePrice() {
		//$range_price = $this->value['price_range'];
		$range_price = $this->range_options[$this->value['price_range']];
		$out = $range_price;
		return $out;
	}
	
}
?>