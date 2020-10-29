<?php 

class alsp_content_field_address extends alsp_content_field {
	protected $can_be_required = true;
	protected $can_be_ordered = false;
	protected $is_categories = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		foreach ($listing->locations AS $location)
			if ($location->getWholeAddress())
				return true;

		return false;
	}

	public function renderOutput($listing) {
		if ($listing->level->locations_number) {
			if (!($template = alsp_isTemplate('alsp_fields/fields/alsp_address_output_'.$this->id.'.tpl.php'))) {
				$template = 'alsp_fields/fields/alsp_address_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
			alsp_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
		}
	}
	
	public function renderOutputForMap($location, $listing) {
		if ($listing->level->locations_number)
			return $location->getWholeAddress();
	}
}
?>