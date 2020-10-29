<?php 

class alsp_content_field_listingtypes extends alsp_content_field {
	protected $can_be_required = true;
	protected $can_be_ordered = false;
	protected $is_listingtypes = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		if (has_term('', ALSP_TYPE_TAX, $listing->post->ID))
			return true;
		else
			return false;
	}

	public function renderOutput($listing) {
		if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_listingtypes_output_'.$this->id.'.tpl.php'))) {
			$template = 'alsp_fields/fields/alsp_listingtypes_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function renderOutputForMap($location, $listing) {
		return alsp_renderTemplate('alsp_fields/fields/alsp_listingtypes_output_map.tpl.php', array('content_field' => $this, 'listing' => $listing), true);
	}
}
?>