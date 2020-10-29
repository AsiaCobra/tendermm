<?php

class alsp_buttons_view {
	public $args = array();
	public $hide_button_text = false;
	public $directories = array();
	public $buttons = false;
	public $listing = false;
	
	public function __construct($args = array()) {
		global $alsp_instance;
		
		$this->args = array_merge(array(
				'directories' => null,
				'hide_button_text' => false,
				'buttons' => 'submit,claim,favourites,edit,print,bookmark,pdf', // also 'logout' possible
		), $args);
		
		if ($this->args['buttons']) {
			if (is_array($this->args['buttons'])) {
				$this->buttons = $this->args['buttons'];
			} else {
				$this->buttons = array_filter(explode(',', $this->args['buttons']), 'trim');
			}
		}
		
		if (!$this->args['directories']) {
			if ($alsp_instance->current_directory) {
				$this->directories[] = $alsp_instance->current_directory;
			} else {
				$this->directories[] = $alsp_instance->directories->getDefaultdirectory();
			}
		} elseif ($this->args['directories'] == 'all') {
			foreach ($alsp_instance->directories->directories_array AS $directory) {
				$this->directories[] = $directory;
			}
		} elseif ($directories_ids = array_filter(explode(',', $this->args['directories']), 'trim')) {
			if (count($directories_ids) >= 1) {
				foreach ($directories_ids AS $id) {
					$this->directories[] = $alsp_instance->directories->getDirectoryById($id);
				}
			}
		}
		
		$this->listing = alsp_isListing();

		$this->hide_button_text = apply_filters('alsp_buttons_view_hide_text', $this->args['hide_button_text'], $this);
	}
	
	public function getDirectories() {
		return $this->directories;
	}

	public function isButton($button) {
		return (in_array($button, $this->buttons));
	}

	public function isFavouritesButton() {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		return ($this->isButton('favourites') && $ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites');
	}

	public function isEditButton() {
		return ($this->isListing() && $this->isButton('edit') && alsp_show_edit_button($this->getListingId()));
	}

	public function isPrintButton() {
		return ($this->isListing() && $this->isButton('print') && get_option('alsp_print_button'));
	}

	public function isPdfButton() {
		return ($this->isListing() && $this->isButton('pdf') && get_option('alsp_pdf_button'));
	}

	public function isBookmarkButton() {
		global $ALSP_ADIMN_SETTINGS;
		return ($this->isListing() && $this->isButton('bookmark') && $ALSP_ADIMN_SETTINGS['alsp_favourites_list']);
	}

	public function isListing() {
		return (bool)($this->listing);
	}

	public function getListingId() {
		if ($this->listing) {
			return $this->listing->post->ID;
		}
	}
	
	public function tooltipMeta($text, $return = false) {
		if ($this->hide_button_text) {
			$out = 'data-toggle="alsp-tooltip" data-placement="top" data-original-title="' . esc_attr($text) . '"';;
			if ($return) {
				return $out;
			} else {
				echo $out;
			}
		}
	}
	
	public function display($return = false) {
		return alsp_renderTemplate('views/alsp_buttons.tpl.php', array('buttons_view' => $this), $return);
	}
}
?>