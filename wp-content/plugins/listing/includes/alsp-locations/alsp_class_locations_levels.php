<?php 

class alsp_locations_levels {
	public $levels_array = array();

	public function __construct() {
		$this->getLevelsFromDB();
	}

	public function getLevelsFromDB() {
		global $wpdb;
		$this->levels_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_locations_levels}", ARRAY_A);
		foreach ($array AS $row) {
			$level = new alsp_locations_level;
			$level->buildLevelFromArray($row);
			$this->levels_array[$row['id']] = $level;
		}
	}
	
	public function getNamesArray() {
		$names = array();
		foreach ($this->levels_array AS $level)
			$names[] = $level->name;
		
		return $names;
	}

	public function getSelectionsArray() {
		$selections = array();
		foreach ($this->levels_array AS $level)
			$selections[] = $level->name;
		
		return $selections;
	}
	
	public function getLevelById($level_id) {
		if (isset($this->levels_array[$level_id]))
			return $this->levels_array[$level_id];
	}
	
	public function createLevelFromArray($array) {
		global $wpdb;
		
		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'in_address_line' => alsp_getValue($array, 'in_address_line'),
		);
		
		$insert_update_args = apply_filters('alsp_locations_level_create_edit_args', $insert_update_args, $array);
	
		if ($wpdb->insert($wpdb->alsp_locations_levels, $insert_update_args)) {
			$new_level_id = $wpdb->insert_id;

			do_action('alsp_update_locations_level', $new_level_id, $insert_update_args);
			
			$this->getLevelsFromDB();
			
			return true;
		}
	}
	
	public function saveLevelFromArray($level_id, $array) {
		global $wpdb;
		
		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'in_address_line' => alsp_getValue($array, 'in_address_line'),
		);
		
		$insert_update_args = apply_filters('alsp_locations_level_create_edit_args', $insert_update_args, $array);
	
		if ($wpdb->update($wpdb->alsp_locations_levels, $insert_update_args,	array('id' => $level_id), null, array('%d')) !== false) {
			do_action('alsp_update_locations_level', $level_id, $insert_update_args);
			
			$this->getLevelsFromDB();
				
			return true;
		}
	}
	
	public function deleteLevel($level_id) {
		global $wpdb;
	
		if ($wpdb->delete($wpdb->alsp_locations_levels, array('id' => $level_id))) {
			$this->getLevelsFromDB();

			return true;
		}
	}
}

class alsp_locations_level {
	public $id;
	public $name;
	public $in_address_line = 1;

	public function buildLevelFromArray($array) {
		$this->id = alsp_getValue($array, 'id');
		$this->name = alsp_getValue($array, 'name');
		$this->in_address_line =alsp_getValue($array, 'in_address_line');
	}
}


if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class alsp_manage_locations_levels_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('locations level', 'ALSP'),
				'plural' => __('locations levels', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns() {
		$columns = array(
				'locations_level_name' => __('Name', 'ALSP'),
				'in_address_line' => __('In address line', 'ALSP'),
		);

		return $columns;
	}

	public function getItems($locations_levels) {
		$items_array = array();
		foreach ($locations_levels->levels_array as $id=>$level) {
			$items_array[$id] = array(
					'id' => $level->id,
					'locations_level_name' => $level->name,
					'in_address_line' => $level->in_address_line,
			);
		}
		return $items_array;
	}

	public function prepareItems($locations_levels) {
		$this->_column_headers = array($this->get_columns(), array(), array());

		$this->items = $this->getItems($locations_levels);
	}

	public function column_locations_level_name($item) {
		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit', $item['id']),
				'delete' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete', $item['id']),
		);
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&level_id=%d">' . $item['locations_level_name'] . '</a>', $_GET['page'], 'edit', $item['id']), $this->row_actions($actions));
	}

	public function column_in_address_line($item) {
		if ($item['in_address_line'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}

	function no_items() {
		__('No locations levels found', 'ALSP');
	}
}

add_action('init', 'alsp_locations_levels_names_into_strings');
function alsp_locations_levels_names_into_strings() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		foreach ($alsp_instance->locations_levels->levels_array AS &$locations_level) {
			$locations_level->name = apply_filters('wpml_translate_single_string', $locations_level->name, 'Ads Listing System', 'The name of locations level #' . $locations_level->id);
		}
	}
}

add_filter('alsp_locations_level_create_edit_args', 'alsp_filter_locations_level_fields', 10, 2);
function alsp_filter_locations_level_fields($insert_update_args, $array) {
	global $sitepress, $wpdb;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['level_id'])) {
				$level_id = $_GET['level_id'];
				if ($name_string_id = icl_st_is_registered_string('Ads Listing System', 'The name of locations level #' . $level_id))
					icl_add_string_translation($name_string_id, ICL_LANGUAGE_CODE, $insert_update_args['name'], ICL_TM_COMPLETE);
				unset($insert_update_args['name']);
			}
		}
	}
	return $insert_update_args;
}

add_action('alsp_update_locations_level', 'alsp_update_locations_level', 10, 2);
function alsp_update_locations_level($level_id, $array) {
	global $sitepress;
	
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {
			do_action('wpml_register_single_string', 'Ads Listing System', 'The name of locations level #' . $level_id, alsp_getValue($array, 'name'));
		}
	}
}

?>