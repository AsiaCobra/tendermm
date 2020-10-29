<?php 

class alsp_locations_controller extends alsp_public_control {

	public function init($args = array()) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'directory' => 0,
				'location_style' => 0,
				'parent' => 0,
				'depth' => 1,
				'columns' => 1,
				'count' => 0,
				'hide_empty' => 0,
				'sublocations' => 0,
				'locations' => array(),
				'icons' => 1,
				'location_bg' => '#333',
				'location_bg_image' => '',
				'gradientbg1' => '',
				'gradientbg2' => '',
				'opacity1' => '',
				'opacity2' => '',
				'gradient_angle' => '',
				'location_width' => 30,
				'location_height' => 480,
				'location_padding' => 15,
		), $args);
		$this->args = $shortcode_atts;

		
		if (isset($this->args['locations']) && !is_array($this->args['locations'])) {
			if ($locations = array_filter(explode(',', $this->args['locations']), 'trim')) {
				$this->args['locations'] = $locations;
			}
		}

		apply_filters('alsp_locations_controller_construct', $this);

	}

		
	public function display() {
		global $alsp_instance;
		
		$this->args['max_subterms'] = $this->args['sublocations'];
		$this->args['exact_terms'] = $this->args['locations'];
		
		ob_start();

		$locations_view = new alsp_locations_view($this->args);
		$locations_view->display();

		$output = ob_get_clean();

		return $output;
	}
}

?>