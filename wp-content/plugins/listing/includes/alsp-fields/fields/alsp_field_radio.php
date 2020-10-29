<?php 

class alsp_content_field_radio extends alsp_content_field_select {
	protected $can_be_searched = true;
	protected $is_search_configuration_page = true;

	public function renderInput() {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_radio_input_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_radio_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_renderTemplate($template, array('content_field' => $this));
	}
}
?>