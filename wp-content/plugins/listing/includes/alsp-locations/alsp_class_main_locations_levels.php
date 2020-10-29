<?php 

class alsp_locations_levels_manager {
	
	public function __construct() {
		add_action('admin_menu', array($this, 'menu'));
	}

	public function menu() {
			add_submenu_page('pacz-admin-listing-panel',
					__('Locations levels', 'ALSP'),
					__('Locations levels', 'ALSP'),
					'administrator',
					'alsp_locations_levels',
					array($this, 'alsp_locations_levels')
			);
	}
	
	public function alsp_locations_levels() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditLocationsLevel();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['level_id'])) {
			$this->addOrEditLocationsLevel($_GET['level_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['level_id'])) {
			$this->deleteLocationsLevel($_GET['level_id']);
		} else {
			$this->showLocationsLevelsTable();
		}
	}
	
	public function showLocationsLevelsTable() {
		global $alsp_instance;
		
		$locations_levels = $alsp_instance->locations_levels;
	
		$locations_levels_table = new alsp_manage_locations_levels_table();
		$locations_levels_table->prepareItems($locations_levels);
	
		alsp_renderTemplate('alsp-locations/alsp_table.tpl.php', array('locations_levels_table' => $locations_levels_table));
	}
	
	public function addOrEditLocationsLevel($level_id = null) {
		global $alsp_instance;
	
		$locations_levels = $alsp_instance->locations_levels;
	
		if (!$locations_level = $locations_levels->getLevelById($level_id))
			$locations_level = new alsp_locations_level();
	
		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_locations_levels_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('name', __('Level name', 'ALSP'), 'required');
			$validation->set_rules('in_address_line', __('In address line', 'ALSP'), 'is_checked');
	
			if ($validation->run()) {
				if ($locations_level->id) {
					if ($locations_levels->saveLevelFromArray($level_id, $validation->result_array())) {
						alsp_addMessage(__('Level was updated successfully!', 'ALSP'));
					}
				} else {
					if ($locations_levels->createLevelFromArray($validation->result_array())) {
						alsp_addMessage(__('Level was created successfully!', 'ALSP'));
					}
				}
				$this->showLocationsLevelsTable();
				//wp_redirect(admin_url('admin.php?page=alsp_locations_levels'));
				//die();
			} else {
				$locations_level->buildLevelFromArray($validation->result_array());
				alsp_addMessage($validation->error_array(), 'error');
	
				alsp_renderTemplate('alsp-locations/alsp_add_edit_level.tpl.php', array('locations_level' => $locations_level, 'locations_level_id' => $level_id));
			}
		} else {
			alsp_renderTemplate('alsp-locations/alsp_add_edit_level.tpl.php', array('locations_level' => $locations_level, 'locations_level_id' => $level_id));
		}
	}
	
	public function deleteLocationsLevel($level_id) {
		global $alsp_instance;
	
		$locations_levels = $alsp_instance->locations_levels;
		if ($locations_level = $locations_levels->getLevelById($level_id)) {
			if (alsp_getValue($_POST, 'submit')) {
				if ($locations_levels->deleteLevel($level_id))
					alsp_addMessage(__('Level was deleted successfully!', 'ALSP'));
	
				$this->showLocationsLevelsTable();
				//wp_redirect(admin_url('admin.php?page=alsp_locations_levels'));
				//die();
			} else
				alsp_renderTemplate('views/alsp_d_q.tpl.php', array('heading' => __('Delete level', 'ALSP'), 'question' => sprintf(__('Are you sure you want delete "%s" level?', 'ALSP'), $locations_level->name), 'item_name' => $locations_level->name));
		} else
			$this->showLocationsLevelsTable();
	}
}

?>