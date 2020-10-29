<?php 

class alsp_levels_manager {
	public function __construct() {
		add_action('admin_menu', array($this, 'menu'));
	}

	public function menu() {
			add_submenu_page('pacz-admin-listing-panel',
				__('Listings levels', 'ALSP'),
				__('Listings levels', 'ALSP'),
				'administrator',
				'alsp_levels',
				array($this, 'alsp_manage_levels_page')
			);

			add_submenu_page('pacz-admin-listing-panel',
				__('Listings upgrade', 'ALSP'),
				__('Listings upgrade', 'ALSP'),
				'administrator',
				'alsp_manage_upgrades',
				array($this, 'alsp_manage_upgrades_page')
			);
	}
	public function alsp_manage_levels_page() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditLevel();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['level_id'])) {
			$this->addOrEditLevel($_GET['level_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['level_id'])) {
			$this->deleteLevel($_GET['level_id']);
		} else {
			$this->showLevelsTable();
		}
	}
	
	public function showLevelsTable() {
		global $alsp_instance;
		
		$levels = $alsp_instance->levels;

		wp_enqueue_script('jquery-ui-sortable');

		if (isset($_POST['levels_order']) && $_POST['levels_order']) {
			if ($levels->saveOrder($_POST['levels_order']))
				alsp_addMessage(__('Levels order was updated!', 'ALSP'), 'updated');
		}
		
		$levels_table = new alsp_manage_levels_table();
		$levels_table->prepareItems($levels);

		alsp_renderTemplate('alsp-packages/alsp_packages_table.tpl.php', array('levels_table' => $levels_table));
	}
	
	public function addOrEditLevel($level_id = null) {
		global $alsp_instance;

		$levels = $alsp_instance->levels;
		
		if (!$level = $levels->getLevelById($level_id))
			$level = new alsp_level();

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_levels_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('name', __('Level name', 'ALSP'), 'required');
			$validation->set_rules('active_interval', __('active interval', 'ALSP'), 'is_natural');
			$validation->set_rules('active_period', __('active period', 'ALSP'));
			$validation->set_rules('eternal_active_period', __('eternal active period', 'ALSP'), 'is_checked');
			$validation->set_rules('listings_in_package', __('listings in package', 'ALSP'), 'is_natural');
			$validation->set_rules('change_level_id', __('change level ID', 'ALSP'), 'is_natural');
			$validation->set_rules('description', __('Level description', 'ALSP'));
			$validation->set_rules('raiseup_enabled', __('Ability to raise up listings', 'ALSP'), 'is_checked');
			$validation->set_rules('sticky', __('Sticky listings', 'ALSP'), 'is_checked');
			$validation->set_rules('listings_own_page', __('Listings own pages', 'ALSP'), 'is_checked');
			$validation->set_rules('nofollow', __('Nofollow attribute', 'ALSP'), 'is_checked');
			$validation->set_rules('featured', __('Featured listings', 'ALSP'), 'is_checked');
			$validation->set_rules('categories_number', __('Categories number available', 'ALSP'), 'is_natural');
			$validation->set_rules('listingtype_number', __('Listing Types number available', 'ALSP'), 'is_natural');
			$validation->set_rules('unlimited_categories', __('Unlimited categories number', 'ALSP'), 'is_checked');
			$validation->set_rules('unlimited_listingtype', __('Unlimited listing type number', 'ALSP'), 'is_checked');
			$validation->set_rules('map', __('Enable map', 'ALSP'), 'is_checked');
			$validation->set_rules('logo_enabled', __('Enable listing logo', 'ALSP'), 'is_checked');
			$validation->set_rules('featured_level', __('Make This Level Featured/Popular', 'ALSP'), 'is_checked');
			$validation->set_rules('allow_resurva_booking', __('Allow Resurva Booking Option For this Level', 'ALSP'), 'is_checked');
			$validation->set_rules('images_number', __('Images number available', 'ALSP'), 'is_natural');
			$validation->set_rules('videos_number', __('Videos number available', 'ALSP'), 'is_natural');
			$validation->set_rules('categories', __('Assigned categories', 'ALSP'));
			$validation->set_rules('listingtypes', __('Assigned listing types', 'ALSP'));
			$validation->set_rules('locations', __('Assigned Locations', 'ALSP'));
			$validation->set_rules('content_fields', __('Assigned content fields', 'ALSP'));
			$validation->set_rules('locations_number', __('Locations number', 'ALSP'), 'is_natural');
			$validation->set_rules('map_markers', __('Custom markers on map', 'ALSP'), 'is_checked');
			apply_filters('alsp_level_validation', $validation);
		
			if ($validation->run()) {
				if ($level->id) {
					if ($levels->saveLevelFromArray($level_id, $validation->result_array())) {
						alsp_addMessage(__('Level was updated successfully!', 'ALSP'));
					}
				} else {
					if ($levels->createLevelFromArray($validation->result_array())) {
						alsp_addMessage(__('Level was created successfully!', 'ALSP'));
					}
				}
				$this->showLevelsTable();
				//wp_redirect(admin_url('admin.php?page=alsp_levels'));
				//die();
			} else {
				$level->buildLevelFromArray($validation->result_array());
				alsp_addMessage($validation->error_array(), 'error');
		
				$content_fields = $alsp_instance->content_fields->content_fields_array;
				alsp_renderTemplate('alsp-packages/alsp_add_edit.tpl.php', array('level' => $level, 'level_id' => $level_id, 'content_fields' => $content_fields));
			}
		} else {
			$content_fields = $alsp_instance->content_fields->content_fields_array;
			alsp_renderTemplate('alsp-packages/alsp_add_edit.tpl.php', array('level' => $level, 'level_id' => $level_id, 'content_fields' => $content_fields));
		}
	}
	
	public function deleteLevel($level_id) {
		global $alsp_instance;

		$levels = $alsp_instance->levels;
		if ($level = $levels->getLevelById($level_id)) {
			if (alsp_getValue($_POST, 'submit')) {
				if ($levels->deleteLevel($level_id))
					alsp_addMessage(__('Level was deleted successfully!', 'ALSP'));

				$this->showLevelsTable();
				//wp_redirect(admin_url('admin.php?page=alsp_levels'));
				//die();
			} else
				alsp_renderTemplate('views/alsp_d_q.tpl.php', array('heading' => __('Delete level', 'ALSP'), 'question' => sprintf(__('Are you sure you want delete "%s" Package with all listings inside?', 'ALSP'), $level->name), 'item_name' => $level->name));
		} else 
			$this->showLevelsTable();
	}
	
	public function alsp_manage_upgrades_page() {
		global $alsp_instance;

		$levels = $alsp_instance->levels;
		
		if (alsp_getValue($_POST, 'submit')) {
			$results = array();
			foreach ($levels->levels_array AS &$level1) {
				foreach ($levels->levels_array AS $level2) {
					if (alsp_getValue($_POST, 'level_disabled_' . $level1->id . '_' . $level2->id) || $level1->id == $level2->id)
						$results[$level1->id][$level2->id]['disabled'] = true;
					else
						$results[$level1->id][$level2->id]['disabled'] = false;

					if (alsp_getValue($_POST, 'level_raiseup_' . $level1->id . '_' . $level2->id) || $level1->id == $level2->id)
						$results[$level1->id][$level2->id]['raiseup'] = true;
					else
						$results[$level1->id][$level2->id]['raiseup'] = false;
				}
				$level1->saveUpgradeMeta($results[$level1->id]);
			}
			alsp_addMessage(__('Listings upgrade settings were updated successfully!', 'ALSP'));
		}
		
		alsp_renderTemplate('alsp-packages/alsp_upgrade_packages_table.tpl.php', array('levels' => $levels));
	}
	
	public function displayChooseLevelTable() {
		global $alsp_instance;

		$levels = $alsp_instance->levels;

		$levels_table = new alsp_choose_levels_table();
		$levels_table->prepareItems($levels);
		
		$levels_count = count($alsp_instance->levels->levels_array);

		alsp_renderTemplate('alsp-packages/alsp_select_package_table.tpl.php', array('levels_table' => $levels_table, 'levels_count' => $levels_count));
	}
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class alsp_manage_levels_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('Package', 'ALSP'),
				'plural' => __('Packages', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns($levels = array()) {
		$columns = array(
				'id' => __('ID', 'ALSP'),
				'level_name' => __('Name', 'ALSP'),
				'active_period' => __('Active period', 'ALSP'),
				'sticky' => __('Sticky', 'ALSP'),
				'featured' => __('Featured', 'ALSP'),
				'categories_number' => __('Categories number', 'ALSP'),
				'map' => __('Map', 'ALSP'),
				'locations_number' => __('Locations number', 'ALSP'),
		);
		$columns = apply_filters('alsp_level_table_header', $columns, $levels);

		return $columns;
	}
	
	public function getItems($levels) {
		$items_array = array();
		foreach ($levels->levels_array as $id=>$level) {
			$items_array[$id] = array(
					'id' => $level->id,
					'level_name' => $level->name,
					'active_period' => $level->getActivePeriodString(),
					'sticky' => $level->sticky,
					'featured' => $level->featured,
					'categories_number' => $level->categories_number,
					'unlimited_categories' => $level->unlimited_categories,
					'map' => $level->map,
					'locations_number' => $level->locations_number,
			);
			if ($level->unlimited_categories)
				$items_array[$id]['categories_number'] = __('Unlimited', 'ALSP');

			$items_array[$id] = apply_filters('alsp_level_table_row', $items_array[$id], $level);
		}
		return $items_array;
	}

	public function prepareItems($levels) {
		$this->_column_headers = array($this->get_columns($levels), array(), array());
		
		$this->items = $this->getItems($levels);
	}
	
	public function column_level_name($item) {
		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit', $item['id']),
				'delete' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete', $item['id']),
				);
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&level_id=%d">' . $item['level_name'] . '</a><input type="hidden" class="level_weight_id" value="%d" />', $_GET['page'], 'edit', $item['id'], $item['id']), $this->row_actions($actions));
	}
	
	public function column_sticky($item) {
		if ($item['sticky'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_featured($item) {
		if ($item['featured'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_map($item) {
		if ($item['map'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}
	
	public function column_categories_number($item) {
		if ($item['unlimited_categories'])
			return __('Unlimited', 'ALSP');
		else
			return $item['categories_number'];
	}
	
	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}
	
	function no_items() {
		__('No levels found.', 'ALSP');
	}
}

class alsp_choose_levels_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('Package', 'ALSP'),
				'plural' => __('Packages', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns($levels = array()) {
		$columns = array(
				'id' => __('ID', 'ALSP'),
				'level_name' => __('Name', 'ALSP'),
				'active_period' => __('Active period', 'ALSP'),
				'sticky' => __('Sticky', 'ALSP'),
				'featured' => __('Featured', 'ALSP'),
				'categories_number' => __('Categories number', 'ALSP'),
				'locations_number' => __('Locations number', 'ALSP'),
				'map' => __('Map', 'ALSP'),
				'create' => ''
		);
		$columns = apply_filters('alsp_level_table_header', $columns, $levels);
		
		return $columns;
	}

	public function getItems($levels) {
		$items_array = array();
		foreach ($levels->levels_array as $id=>$level) {
			$items_array[$id] = array(
					'id' => $level->id,
					'level_name' => $level->name,
					'active_period' => $level->getActivePeriodString(),
					'sticky' => $level->sticky,
					'featured' => $level->featured,
					'categories_number' => $level->categories_number,
					'unlimited_categories' => $level->unlimited_categories,
					'locations_number' => $level->locations_number,
					'map' => $level->map,
			);
			if ($level->unlimited_categories)
				$items_array[$id]['categories_number'] = __('Unlimited', 'ALSP');

			$items_array[$id] = apply_filters('alsp_level_table_row', $items_array[$id], $level);
		}
		return $items_array;
	}

	public function prepareItems($levels) {
		$this->_column_headers = array($this->get_columns($levels), array(), array());

		$this->items = $this->getItems($levels);
	}

	public function column_create($item) {
		global $alsp_instance;
		
		$out = array();
		foreach ($alsp_instance->directories->directories_array AS $directory) {
			if ($directory->levels) {
				if (in_array($item['id'], $directory->levels)) {
					$out[] = sprintf('<a href="%s">Create %s in this level</a>', esc_url(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $item['id'], 'directory_id' => $directory->id), admin_url('post-new.php'))), $directory->single);
				}
			} else {
				$out[] = sprintf('<a href="%s">Create %s in this level</a>', esc_url(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $item['id'], 'directory_id' => $directory->id), admin_url('post-new.php'))), $directory->single);
			}
		}
		return implode('<br />', $out);
	}

	public function column_sticky($item) {
		if ($item['sticky'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_featured($item) {
		if ($item['featured'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_map($item) {
		if ($item['map'])
			return '<span class="field_check pacz-icon-check"></span>';
		else
			return '<span class="field_remove pacz-icon-close"></span>';
	}

	public function column_categories_number($item) {
		if ($item['unlimited_categories'])
			return __('Unlimited', 'ALSP');
		else
			return $item['categories_number'];
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}
	
	function no_items() {
		esc_attr__("No Package found. Can't create new Advert.", 'ALSP');
	}
}

?>