<?php
class alsp_content_field_price_search extends alsp_content_field_number_search {

	public function renderSearch($search_form_id, $columns = 2, $defaults = array(), $gap_in_fields = 10) {
		if ($this->mode == 'exact_number') {
			if (is_null($this->value)) {
				if (isset($defaults['field_' . $this->content_field->slug])) {
					$this->value = $defaults['field_' . $this->content_field->slug];
				}
			}
		} elseif ($this->mode == 'min_max' || $this->mode == 'min_max_slider' || $this->mode == 'range_slider') {
			if (is_null($this->min_max_value)) {
				if (isset($defaults['field_' . $this->content_field->slug . '_min'])) {
					$this->min_max_value['min'] = $defaults['field_' . $this->content_field->slug . '_min'];
				}
				if (isset($defaults['field_' . $this->content_field->slug . '_max'])) {
					$this->min_max_value['max'] = $defaults['field_' . $this->content_field->slug . '_max'];
				}
			}
		}

		if ($this->mode == 'exact_number')
			alsp_renderTemplate('alsp-search-fields/fields/price_input_exactnumber.tpl.php', array('search_field' => $this, 'columns' => $columns, 'gap_in_fields' => $gap_in_fields, 'search_form_id' => $search_form_id));
		elseif ($this->mode == 'min_max')
			alsp_renderTemplate('alsp-search-fields/fields/price_input_minmax.tpl.php', array('search_field' => $this, 'columns' => $columns, 'gap_in_fields' => $gap_in_fields, 'search_form_id' => $search_form_id));
		elseif ($this->mode == 'min_max_slider' || $this->mode == 'range_slider')
			alsp_renderTemplate('alsp-search-fields/fields/price_input_slider.tpl.php', array('search_field' => $this, 'columns' => $columns, 'gap_in_fields' => $gap_in_fields, 'search_form_id' => $search_form_id));
	}
	
	public function printVisibleSearchParams($public_control) {
		if ($this->mode == 'exact_number') {
			$field_index = 'field_' . $this->content_field->slug;
			if (isset($_REQUEST[$field_index]) && $_REQUEST[$field_index] && is_numeric($_REQUEST[$field_index])) {
				$value = $_REQUEST[$field_index];
				$url = remove_query_arg($field_index, $public_control->base_url);
				echo alsp_visibleSearchParam($this->content_field->name . ' ' . $this->content_field->formatPrice($value), $url);
			}
		} elseif ($this->mode == 'min_max' || $this->mode == 'min_max_slider' || $this->mode == 'range_slider') {
			$field_index = 'field_' . $this->content_field->slug . '_min';
			if (isset($_REQUEST[$field_index]) && $_REQUEST[$field_index] && is_numeric($_REQUEST[$field_index])) {
				$url = remove_query_arg($field_index, $public_control->base_url);
				$value = $_REQUEST[$field_index];
				echo alsp_visibleSearchParam(sprintf(__("%s from %s", "ALSP"), $this->content_field->name, $this->content_field->formatPrice($value)), $url);
			}
	
			$field_index = 'field_' . $this->content_field->slug . '_max';
			if (isset($_REQUEST[$field_index]) && $_REQUEST[$field_index] && is_numeric($_REQUEST[$field_index])) {
				$url = remove_query_arg($field_index, $public_control->base_url);
				$value = $_REQUEST[$field_index];
				echo alsp_visibleSearchParam(sprintf(__("%s to %s", "ALSP"), $this->content_field->name, $this->content_field->formatPrice($value)), $url);
			}
		}
	}
}