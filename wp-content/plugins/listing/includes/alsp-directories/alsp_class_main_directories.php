<?php
class alsp_directories_manager {
	public function __construct() {
		//alsp_directories_manager_init($this);
		add_action('admin_menu', array($this, 'menu'));
	}

	public function menu() {
			$this->menu_page_hook = add_submenu_page('pacz-admin-listing-panel',
				__('Ads Directories', 'ALSP'),
				__('Ads Directories', 'ALSP'),
				'administrator',
				'alsp_directories',
				array($this, 'alsp_manage_directories_page')
			);
	}

	public function alsp_manage_directories_page() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditDirectory();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['directory_id'])) {
			$this->addOrEditDirectory($_GET['directory_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['directory_id'])) {
			$this->deleteDirectory($_GET['directory_id']);
		} else {
			$this->showDirectoriesTable();
		}
	}
	
	public function showDirectoriesTable() {
		global $alsp_instance;
		
		$directories = $alsp_instance->directories;

		$directories_table = new alsp_manage_directories_table();
		$directories_table->prepareItems($directories);

		alsp_renderTemplate('alsp-directories/alsp_table.tpl.php', array('directories_table' => $directories_table));
	}
	
	public function addOrEditDirectory($directory_id = null) {
		global $alsp_instance;

		$directories = $alsp_instance->directories;
		
		if (!$directory = $directories->getDirectoryById($directory_id))
			$directory = new alsp_directory();

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_directories_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('name', __('Directory name', 'ALSP'), 'required');
			$validation->set_rules('single', __('Single form', 'ALSP'), 'required');
			$validation->set_rules('plural', __('Plural form', 'ALSP'), 'required');
			$validation->set_rules('listing_slug', __('Listing slug', 'ALSP'), 'alpha_dash');
			$validation->set_rules('category_slug', __('Category slug', 'ALSP'), 'alpha_dash');
			$validation->set_rules('listingtype_slug', __('Listing Type slug', 'ALSP'), 'alpha_dash');
			$validation->set_rules('location_slug', __('Location slug', 'ALSP'), 'alpha_dash');
			$validation->set_rules('tag_slug', __('Tag slug', 'ALSP'), 'alpha_dash');
			$validation->set_rules('categories', __('Assigned categories', 'ALSP'));
			$validation->set_rules('listingtypes', __('Assigned Listing Types', 'ALSP'));
			$validation->set_rules('locations', __('Assigned locations', 'ALSP'));
			$validation->set_rules('levels', __('Levels', 'ALSP'));
			apply_filters('alsp_directory_validation', $validation);
		
			if ($validation->run() && $this->checkSlugs($validation->result_array())) {
				if ($directory->id) {
					if ($directories->saveDirectoryFromArray($directory_id, $validation->result_array())) {
						alsp_addMessage(__('Directory was updated successfully!', 'ALSP'));
					}
				} else {
					if ($directories->createDirectoryFromArray($validation->result_array())) {
						alsp_addMessage(__('Directory was created successfully!', 'ALSP'));
					}
				}
				//$this->showDirectoriesTable();
				wp_redirect(admin_url('admin.php?page=alsp_directories'));
				die();
			} else {
				$directory->buildDirectoryFromArray($validation->result_array());
				alsp_addMessage($validation->error_array(), 'error');
		
				alsp_renderTemplate('alsp-directories/alsp_add_edit.tpl.php', array('directory' => $directory, 'directory_id' => $directory_id));
			}
		} else {
			alsp_renderTemplate('alsp-directories/alsp_add_edit.tpl.php', array('directory' => $directory, 'directory_id' => $directory_id));
		}
	}
	
	public function deleteDirectory($directory_id) {
		global $alsp_instance;

		$directories = $alsp_instance->directories;
		if ($directory = $directories->getDirectoryById($directory_id)) {
			if (alsp_getValue($_POST, 'submit') && ($new_directory_id = alsp_getValue($_POST, 'new_directory')) && is_numeric($new_directory_id)) {
				if ($directories->deleteDirectory($directory_id, $new_directory_id))
					alsp_addMessage(__('Directory was deleted successfully!', 'ALSP'));

				//$this->showDirectoriesTable();
				wp_redirect(admin_url('admin.php?page=alsp_directories'), 301);
				die();
			} else {
				$question = sprintf(__('Are you sure you want delete "%s" directory?', 'ALSP'), $directory->name);
				$question .= '<br /><br />' . __('Existing listings will be moved to directory:', 'ALSP');
				foreach ($alsp_instance->directories->directories_array AS $directory) {
					if ($directory->id != $directory_id)
						$question .= '<br />' . '<label><input type="radio" name="new_directory" value="' . $directory->id . '" ' . checked($directory->id, $alsp_instance->directories->getDefaultDirectory()->id, false) . ' />' . $directory->name . '</label>';
				}
				
				alsp_renderTemplate('views/alsp_d_q.tpl.php', array('heading' => __('Delete directory', 'ALSP'), 'question' => $question, 'item_name' => $directory->name));
			}
		} else 
			$this->showLevelsTable();
	}
	
	public function checkSlugs($validation_results) {
		global $alsp_instance;
		
		$slugs_to_check = array(
				$validation_results['listing_slug'],
				$validation_results['category_slug'],
				$validation_results['listingtype_slug'],
				$validation_results['location_slug'],
				$validation_results['tag_slug'],
		);
		foreach ($alsp_instance->index_pages_all AS $page) {
			if (in_array($page['slug'], $slugs_to_check)) {
				alsp_addMessage(__('One or several slugs equal to the slug of directory page! This may cause problems.', 'ALSP'), 'error');
				return false;
			}
		}
		return true;
	}
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class alsp_manage_directories_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('directory', 'ALSP'),
				'plural' => __('directories', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns($directories = array()) {
		$columns = array(
				'id' => __('ID', 'ALSP'),
				'directory_name' => __('Name', 'ALSP'),
				'shortcode' => __('Shortcode', 'ALSP'),
				'page' => __('Page', 'ALSP'),
				'listing_slug' => __('Listing slug', 'ALSP'),
				'category_slug' => __('Category slug', 'ALSP'),
				'listingtype_slug' => __('Listing Type slug', 'ALSP'),
				'location_slug' => __('Location slug', 'ALSP'),
				'tag_slug' => __('Tag slug', 'ALSP'),
		);
		$columns = apply_filters('alsp_directory_table_header', $columns, $directories);

		return $columns;
	}
	
	public function getItems($directories) {
		$items_array = array();
		$first_directory = $directories->getDefaultDirectory();
		foreach ($directories->directories_array as $id=>$directory) {
			if ($id == $first_directory->id) {
				$shortcode = '[alsp-main]';
			} else {
				$shortcode = '[alsp-main id="' . $directory->id . '"]';
			}
			
			if ($directory->url) {
				$directory_url = sprintf('<a href="%s" target="_blank">%s</a>', $directory->url, $directory->url);
			} else {
				$directory_url = '<strong>' . __('Required page is missing!', 'ALSP') . '</strong>';
			}
			
			$items_array[$id] = array(
					'id' => $directory->id,
					'directory_name' => $directory->name,
					'shortcode' => $shortcode,
					'page' => $directory_url,
					'listing_slug' => $directory->listing_slug,
					'category_slug' => $directory->category_slug,
					'listingtype_slug' => $directory->listingtype_slug,
					'location_slug' => $directory->location_slug,
					'tag_slug' => $directory->tag_slug,
			);

			$items_array[$id] = apply_filters('alsp_directory_table_row', $items_array[$id], $directory);
		}
		return $items_array;
	}

	public function prepareItems($directories) {
		$this->_column_headers = array($this->get_columns($directories), array(), array());
		
		$this->items = $this->getItems($directories);
	}
	
	public function column_directory_name($item) {
		global $alsp_instance;

		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit', $item['id']),
				'delete' => sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete', $item['id']),
		);
		
		if ($item['id'] == $alsp_instance->directories->getDefaultDirectory()->id) {
			unset($actions['delete']);
		}
		
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&directory_id=%d">' . $item['directory_name'] . '</a>', $_GET['page'], 'edit', $item['id']), $this->row_actions($actions));
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}
	
	function no_items() {
		__('No directories found.', 'ALSP');
	}
}

?>