<?php 

class alsp_buttons_controller extends alsp_public_control {
	public $buttons_view;

	public function init($args = array()) {
		parent::init($args);
		
		global $alsp_instance;

		$shortcode_atts = array_merge(array(
				'directories' => null,
				'hide_button_text' => false,
				'buttons' => 'submit,claim,favourites,edit,print,bookmark,pdf', // also 'logout' possible
		), $args);

		$this->args = $shortcode_atts;
		
		$this->buttons_view = new alsp_buttons_view($this->args);

		apply_filters('alsp_buttons_controller_construct', $this);
	}

	public function display() {
		$output =  $this->buttons_view->display(true);
		wp_reset_postdata();

		return $output;
	}
}

?>