<?php

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_content.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_excerpt.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_address.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_categories.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_listingtype.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_tags.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_string.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_textarea.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_number.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_select.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_checkbox.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_radio.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_website.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_email.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_datetime.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_price.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_hours.php';

include_once ALSP_PATH . 'includes/alsp-fields/fields/alsp_field_fileupload.php';



class alsp_content_fields {

	public $content_fields_array = array();

	public $content_fields_groups_array = array();

	public $fields_types_names;

	private $map_content_fields = array();

	

	public function __construct() {

		$this->fields_types_names = array(

				'excerpt' => __('Excerpt', 'ALSP'),

				'content' => __('Content', 'ALSP'),

				'categories' => __('Listing categories', 'ALSP'),

				'listingtypes' => __('Listing Types', 'ALSP'),

				'tags' => __('Listing tags', 'ALSP'),

				'address' => __('Listing addresses', 'ALSP'),

				'string' => __('Text string', 'ALSP'),

				'textarea' => __('Textarea', 'ALSP'),

				'number' => __('Digital value', 'ALSP'),

				'select' => __('Select list', 'ALSP'),

				'radio' => __('Radio buttons', 'ALSP'),

				'checkbox' => __('Checkboxes', 'ALSP'),

				'website' => __('Website URL', 'ALSP'),

				'email' => __('Email', 'ALSP'),

				'datetime' => __('Date-Time', 'ALSP'),

				'price' => __('Price', 'ALSP'),

				'hours' => __('Opening hours', 'ALSP'),

				'fileupload' => __('File upload', 'ALSP'),

		);



		$this->getContentFieldsFromDB();

	}

	

	public function saveOrder() {

		global $wpdb;



		if (isset($_POST['content_fields_order']) && $_POST['content_fields_order'] && ($order_ids = explode(',', trim($_POST['content_fields_order'])))) {

			$i = 1;

			foreach ($order_ids AS $id) {

				$wpdb->update($wpdb->alsp_content_fields, array('order_num' => $i), array('id' => $id));

				$i++;

			}

			$this->getContentFieldsFromDB();



			return true;

		}

	}



	public function saveGroupsRelations() {

		global $wpdb;



		foreach ($this->content_fields_array AS $content_field) {

			if (isset($_POST['group_id_'.$content_field->id]))

				$wpdb->update($wpdb->alsp_content_fields, array('group_id' => $_POST['group_id_'.$content_field->id]), array('id' => $content_field->id));

		}

		$this->getContentFieldsFromDB();



		return true;

	}

	

	public function getContentFieldsFromDB() {

		global $wpdb;



		$this->content_fields_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_content_fields} ORDER BY order_num, is_core_field", ARRAY_A);

		foreach ($array AS $row) {

			$field_class_name = 'alsp_content_field_' . $row['type'];

			if (class_exists($field_class_name)) {

				$content_field = new $field_class_name;

				$content_field->buildContentFieldFromArray($row);

				$content_field->convertCategories();

				$content_field->convertListingTypes();

				$content_field->convertOptions();

				$this->content_fields_array[$row['id']] = $content_field;

			}

		}



		$this->content_fields_groups_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_content_fields_groups}", ARRAY_A);

		foreach ($array AS $row) {

			$content_fields_group = new alsp_content_fields_group($row);

			$this->content_fields_groups_array[$row['id']] = $content_fields_group;

		}

		

		return true;

	}

	

	public function getContentFieldById($field_id) {

		if (isset($this->content_fields_array[$field_id]))

			return $this->content_fields_array[$field_id];

	}



	public function getContentFieldsGroupById($group_id) {

		if (isset($this->content_fields_groups_array[$group_id]))

			return $this->content_fields_groups_array[$group_id];

	}



	public function getContentFieldBySlug($slug) {

		foreach ($this->content_fields_array AS $content_field) {

			if ($content_field->slug == $slug)

				return $content_field;

		}

	}

	

	public function createContentFieldFromArray($array) {

		if (alsp_getValue($array, 'type')) {

			$field_class_name = 'alsp_content_field_' . alsp_getValue($array, 'type');

			if (class_exists($field_class_name)) {

				$content_field = new $field_class_name;

				if ($content_field->create($array))

					return $this->getContentFieldsFromDB();

			}

		}

		return false;

	}

	

	public function saveContentFieldFromArray($field_id, $array) {

		if ($content_field = $this->getContentFieldById($field_id))

			if ($content_field->save($array))

				return $this->getContentFieldsFromDB();



		return false;

	}

	

	public function deleteContentField($field_id) {

		if ($content_field = $this->getContentFieldById($field_id))

			if ($content_field->delete())

				return $this->getContentFieldsFromDB();

		

		return false;

	}



	public function deleteContentFieldsGroup($group_id) {

		if ($content_fields_group = $this->getContentFieldsGroupById($group_id))

			if ($content_fields_group->delete())

				return $this->getContentFieldsFromDB();

		

		return false;

	}



	public function createContentFieldsGroupFromArray($array) {

		$content_fields_group = new alsp_content_fields_group;

		if ($content_fields_group->create($array))

			return $this->getContentFieldsFromDB();

		

		return false;

	}

	

	public function saveContentFieldsGroupFromArray($group_id, $array) {

		if ($content_fields_group = $this->getContentFieldsGroupById($group_id))

			if ($content_fields_group->save($array))

				return $this->getContentFieldsFromDB();



		return false;

	}



	public function getOrderingContentFields() {

		$fields = array();

		foreach ($this->content_fields_array AS $content_field) {

			if ($content_field->canBeOrdered() && $content_field->is_ordered)

				$fields[] = $content_field;

		}

		return $fields;

	}



	public function isNotCoreContentFields() {

		foreach ($this->content_fields_array AS $content_field) {

			if (!$content_field->is_core_field)

				return true;

		}

	}

	

	public function getFieldsByCategoriesIdsAndLevelId($categories_ids, $level_id = null) {

		if ($level_id) {

			global $alsp_instance;

			$level = $alsp_instance->levels->getLevelById($level_id);

		} else 
			$level = null;



		$result_fields = array();

		foreach ($this->content_fields_array AS &$content_field) {

			if (

				(!$content_field->isCategories() || $content_field->categories === array() || !is_array($content_field->categories) || array_intersect($content_field->categories, $categories_ids)) &&

				($content_field->is_core_field || !$level || !$level->content_fields || in_array($content_field->id, $level->content_fields))

			)
				$result_fields[$content_field->id] = $content_field;

		}

		return $result_fields;

	}



	public function saveValues($post_id, $categories_ids, $level_id = null, &$errors, $data) {

		$content_fields = $this->getFieldsByCategoriesIdsAndLevelId($categories_ids, $level_id);
		 
		foreach ($content_fields AS $key=>$content_field) {

			$local_errors = array();

			if ( ($validation_results = $content_field->validateValues($local_errors, $data) ) !== false && !$local_errors) {

				$content_field->saveValue($post_id, $validation_results);
			 
			} else {

				$errors = array_merge($errors, $local_errors);

			}

		}


	}



	public function loadValues($post_id, $categories_ids, $level_id = null) {

		$content_fields = $this->getFieldsByCategoriesIdsAndLevelId($categories_ids, $level_id);

		$result_content_fields = array();

		foreach ($content_fields AS $content_field) {

			$rcontent_field = clone $content_field;

			$rcontent_field->loadValue($post_id);

			$result_content_fields[$content_field->id] = $rcontent_field;

		}

		return $result_content_fields;

	}

	

	public function getOrderParams($defaults = array()) {

		$order_by = alsp_getValue($_GET, 'order_by', alsp_getValue($defaults, 'order_by'));



		if ($order_by)

			foreach ($this->content_fields_array AS $content_field) {

				if ($content_field->canBeOrdered() && $content_field->is_ordered && $content_field->slug == $order_by) {

					return $content_field->orderParams();

					break;

				}

			}

		return array();

	}

	

	public function getMapContentFields() {

		if (!$this->map_content_fields) {

			foreach ($this->content_fields_array AS $content_field) {

				if ($content_field->on_map) {

					$this->map_content_fields[$content_field->slug] = clone $content_field;

				}

			}

			

			// address field always will be the first

			if (isset($this->map_content_fields['address'])) {

				$address_field = $this->map_content_fields['address'];

				unset($this->map_content_fields['address']);

				$this->map_content_fields = array('address' => $address_field) + $this->map_content_fields;

			}

			

			$this->map_content_fields = apply_filters('alsp_map_info_window_fields', $this->map_content_fields);

		}

		

		return $this->map_content_fields;

	}



	/**

	 * loops through all content fields and builds special array where items are of content field type

	 * or of content fields group type

	 * 

	 * content fields groups items include related content fields

	 * 

	 * @param array $content_fields_array

	 * @return multitype:multitype: array

	 */

	public function sortContentFieldsByGroups($content_fields_array = null) {

		if (!$content_fields_array)

			$content_fields_array = $this->content_fields_array;



		$result = array();

		foreach ($content_fields_array AS $content_field)

			if ($content_field->group_id && isset($this->content_fields_groups_array[$content_field->group_id])) {

				$content_fields_group = $this->content_fields_groups_array[$content_field->group_id];

				$group_in_array = false;

				foreach ($result AS $item)

					if (is_a($item, 'alsp_content_fields_group') && $item->id == $content_field->group_id)

						$group_in_array = true;

				if (!$group_in_array) {

					$content_fields_group->setContentFields($content_fields_array);

					$result[] = $content_fields_group;

				}

			} else 

				$result[] = $content_field;

		return $result;

	}

}



class alsp_content_fields_group {

	public $id;

	public $name;

	public $on_tab;

	public $group_style;

	public $hide_anonymous;

	public $content_fields_array = array();



	public function __construct($row = null) {

		if ($row) {

			$this->id = $row['id'];

			$this->name = $row['name'];

			$this->on_tab = $row['on_tab'];

			$this->group_style = (isset($row['group_style']))? $row['group_style'] :'';

			$this->hide_anonymous = $row['hide_anonymous'];

		}

	}

	

	public function validation() {

		$validation = new alsp_form_validation();

		$validation->set_rules('name', __('Content field name', 'ALSP'), 'required');

		$validation->set_rules('on_tab', __('On tab', 'ALSP'), 'is_checked');

		$validation->set_rules('group_style', __('Group Output Style', 'ALSP'), 'required');

		$validation->set_rules('hide_anonymous', __('Hide from anonymous', 'ALSP'), 'is_checked');

		return $validation;

	}

	

	public function create($array) {

		global $wpdb;

	

		$insert_update_args = array(

				'name' => alsp_getValue($array, 'name'),

				'on_tab' => alsp_getValue($array, 'on_tab'),

				'group_style' => $array['group_style'],

				'hide_anonymous' => alsp_getValue($array, 'hide_anonymous'),

		);

		

		$insert_update_args = apply_filters('alsp_content_field_group_create_edit_args', $insert_update_args, $this, $array);



		if ($wpdb->insert($wpdb->alsp_content_fields_groups, $insert_update_args)) {

			$new_content_field_group_id = $wpdb->insert_id;

				

			do_action('alsp_update_content_field_group', $new_content_field_group_id, $this, $insert_update_args);

			

			return true;

		}

	}

	

	public function save($array) {

		global $wpdb, $alsp_instance;



		$insert_update_args = array(

				'name' => alsp_getValue($array, 'name'),

				'on_tab' => alsp_getValue($array, 'on_tab'),

				'group_style' => $array['group_style'],

				'hide_anonymous' => alsp_getValue($array, 'hide_anonymous'),

		);

		

		$insert_update_args = apply_filters('alsp_content_field_group_create_edit_args', $insert_update_args, $this, $array);



		if ($wpdb->update($wpdb->alsp_content_fields_groups, $insert_update_args, array('id' => $this->id), null, array('%d')) !== false) {

			do_action('alsp_update_content_field_group', $this->id, $this, $insert_update_args);

				

			return true;

		}

	}

	

	public function delete() {

		global $wpdb;



		$wpdb->delete($wpdb->alsp_content_fields_groups, array('id' => $this->id));

		$wpdb->update($wpdb->alsp_content_fields, array('group_id' => 0), array('group_id' => $this->id));

		return true;

	}

	

	public function setContentFields($content_fields_array) {

		foreach ($content_fields_array AS $content_field) {

			if ($this->id == $content_field->group_id)

				$this->content_fields_array[$content_field->id] = $content_field;

		}

	}

	

	public function renderOutput($listing, $is_single = true) {

		if ($this->content_fields_array) {

			alsp_renderTemplate('alsp_fields/alsp_fields_group_output.tpl.php', array('content_fields_group' => $this, 'listing' => $listing, 'is_single' => $is_single));

		}

	}

}



class alsp_content_field {

	public $id;

	public $is_core_field = 0;

	public $order_num;

	public $name;

	public $slug;

	public $description;

	public $fieldwidth;

	public $fieldwidth_archive;

	public $type;

	public $icon_image;

	public $is_required = 0;

	public $is_ordered;

	public $is_hide_name;

	public $is_field_in_line;

	public $is_hide_name_on_grid;

	public $is_hide_name_on_list;

	public $is_hide_name_on_search;

	public $on_exerpt_page = 1;

	public $on_exerpt_page_list = 1;

	public $on_listing_page = 1;

	public $on_map;

	public $categories = array();

	public $listingtypes = array();

	public $options;

	public $search_options;

	public $group_id;

	public $value;

	

	protected $can_be_required = true;

	protected $can_be_ordered = true;

	protected $is_categories = true;

	protected $is_listingtypes = true;

	protected $is_slug = true;

	

	protected $is_configuration_page = false;



	protected $can_be_searched = false;

	protected $is_search_configuration_page = false;

	public $on_search_form = false;

	public $on_search_form_archive = false;

	public $on_search_form_widget = false;

	public $advanced_search_form = false;





	public function validation() {

		global $alsp_instance;



		// core fields can't change type

		if (!$this->is_core_field) {

			if (isset($_POST['type']) && $_POST['type']) {

				// load dummy content field by its new type from $_POST

				$field_class_name = 'alsp_content_field_' . $_POST['type'];

				if (class_exists($field_class_name)) {

					$process_content_field = new $field_class_name;

				} else {

					alsp_addMessage('This type of content field does not exist!', 'error');

					$process_content_field = $this;

				}

			} else {

				$process_content_field = $this;

			}

		} else

			$process_content_field = $this;

		

		$validation = new alsp_form_validation();

		$validation->set_rules('name', __('Content field name', 'ALSP'), 'required');

		if ($process_content_field->isSlug())

			$validation->set_rules('slug', __('Content field slug', 'ALSP'), 'required|alpha_dash');

		$validation->set_rules('description', __('Content field description', 'ALSP'));

		$validation->set_rules('fieldwidth', __('Content field fieldwidth on custom search form', 'ALSP'));

		$validation->set_rules('fieldwidth_archive', __('Content field fieldwidth on Archive search form', 'ALSP'));

		$validation->set_rules('icon_image', __('Icon image', 'ALSP'));

		if ($process_content_field->canBeRequired())

			$validation->set_rules('is_required', __('Content field required', 'ALSP'), 'is_checked');

		if ($process_content_field->canBeOrdered())

			$validation->set_rules('is_ordered', __('Order by field', 'ALSP'), 'is_checked');

		$validation->set_rules('is_hide_name', __('Hide name on single listing', 'ALSP'), 'is_checked');

		$validation->set_rules('is_hide_name_on_grid', __('Hide name grid style', 'ALSP'), 'required');

		$validation->set_rules('is_hide_name_on_list', __('Hide name on list style', 'ALSP'), 'required');

		$validation->set_rules('is_hide_name_on_search', __('Hide name in search forms', 'ALSP'), 'is_checked');

		$validation->set_rules('is_field_in_line', __('Display field in line', 'ALSP'), 'is_checked');

		$validation->set_rules('on_exerpt_page', __('On grid view', 'ALSP'), 'is_checked');

		$validation->set_rules('on_exerpt_page_list', __('On list view', 'ALSP'), 'is_checked');

		$validation->set_rules('on_listing_page', __('On listing page', 'ALSP'), 'is_checked');

		$validation->set_rules('on_map', __('In map marker InfoWindow', 'ALSP'), 'is_checked');

		// core fields can't change type

		if (!$this->is_core_field)

			$validation->set_rules('type', __('Content field type', 'ALSP'), 'required');

		if ($process_content_field->isCategories())

			$validation->set_rules('categories', __('Assigned categories', 'ALSP'));

		if ($process_content_field->canBeSearched()) {

			$validation->set_rules('on_search_form', __('On search form', 'ALSP'), 'is_checked');

			$validation->set_rules('advanced_search_form', __('On advanced search panel', 'ALSP'), 'is_checked');

		}



		$validation = apply_filters('alsp_content_field_validation', $validation, $process_content_field);



		if ($process_content_field->isSlug()) {

			global $wpdb;



			if ($wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->alsp_content_fields} WHERE slug=%s AND id!=%d", $_POST['slug'], $this->id), ARRAY_A)

				|| $_POST['slug'] == 'post_title'

				|| $_POST['slug'] == 'post_name'

				|| $_POST['slug'] == 'post_date'

				|| $_POST['slug'] == 'title'

				|| $_POST['slug'] == 'categories_list'

				|| $_POST['slug'] == 'address'

				|| $_POST['slug'] == 'address_line_1'

				|| $_POST['slug'] == 'address_line_2'

				|| $_POST['slug'] == 'map_coords_1'

				|| $_POST['slug'] == 'map_coords_2'

				|| $_POST['slug'] == 'map_icon_file'

				|| $_POST['slug'] == 'content'

				|| $_POST['slug'] == 'excerpt'

				|| $_POST['slug'] == 'listing_tags'

				|| $_POST['slug'] == 'distance'

				|| $_POST['slug'] == 'user'

				|| $_POST['slug'] == 'zip_or_postal_index'

			)

				$validation->setError('slug', esc_attr__("Can't use this slug", 'ALSP'));

		}



		return $validation;

	}

	

	public function create($array) {

		global $wpdb;



		$insert_update_args = array(

				'name' => alsp_getValue($array, 'name'),

				'description' => alsp_getValue($array, 'description'),

				'fieldwidth' => alsp_getValue($array, 'fieldwidth'),

				'fieldwidth_archive' => alsp_getValue($array, 'fieldwidth_archive'),

				'type' => alsp_getValue($array, 'type'),

				'icon_image' => alsp_getValue($array, 'icon_image'),

				'is_configuration_page' => $this->is_configuration_page,

				'is_search_configuration_page' => $this->is_search_configuration_page,

				'is_hide_name' => alsp_getValue($array, 'is_hide_name'),

				'is_hide_name_on_grid' => alsp_getValue($array, 'is_hide_name_on_grid'),

				'is_hide_name_on_list' => alsp_getValue($array, 'is_hide_name_on_list'),

				'is_hide_name_on_search' => alsp_getValue($array, 'is_hide_name_on_search'),

				'is_field_in_line' => alsp_getValue($array, 'is_field_in_line'),

				'on_exerpt_page' => alsp_getValue($array, 'on_exerpt_page'),

				'on_exerpt_page_list' => alsp_getValue($array, 'on_exerpt_page_list'),

				'on_listing_page' => alsp_getValue($array, 'on_listing_page'),

				'on_map' => alsp_getValue($array, 'on_map'),

		);

		if ($this->isSlug())

			$insert_update_args['slug'] = alsp_getValue($array, 'slug');

		if ($this->canBeRequired())

			$insert_update_args['is_required'] = alsp_getValue($array, 'is_required');

		if ($this->canBeOrdered())

			$insert_update_args['is_ordered'] = alsp_getValue($array, 'is_ordered');

		if ($this->isCategories())

			$insert_update_args['categories'] = serialize(alsp_getValue($array, 'categories', array()));

		if ($this->canBeSearched()) {

			$insert_update_args['on_search_form'] = alsp_getValue($array, 'on_search_form');

			$insert_update_args['advanced_search_form'] = alsp_getValue($array, 'advanced_search_form');

		} else {

			$insert_update_args['on_search_form'] = 0;

			$insert_update_args['advanced_search_form'] = 0;

			$insert_update_args['search_options'] = '';

		}



		$insert_update_args = apply_filters('alsp_content_field_create_edit_args', $insert_update_args, $this, $array);

		

		if ($wpdb->insert($wpdb->alsp_content_fields, $insert_update_args)) {

			$new_content_field_id = $wpdb->insert_id;

				

			do_action('alsp_update_content_field', $new_content_field_id, $this, $array);

			

			return true;

		}

	}

	

	public function save($array) {

		global $wpdb, $alsp_instance;

		

		// core fields can't change type

		if (!$this->is_core_field) {

			if (isset($_POST['type']) && $_POST['type']) {

				// load dummy content field by its new type from $_POST

				$field_class_name = 'alsp_content_field_' . $_POST['type'];

				if (class_exists($field_class_name)) {

					$process_content_field = new $field_class_name;

				} else {

					alsp_addMessage('This type of content field does not exist!', 'error');

					$process_content_field = $this;

				}

			} else {

				$process_content_field = $this;

			}

		} else

			$process_content_field = $this;

		

		$insert_update_args = array(

				'name' => alsp_getValue($array, 'name'),

				'description' => alsp_getValue($array, 'description'),

				'fieldwidth' => alsp_getValue($array, 'fieldwidth'),

				'fieldwidth_archive' => alsp_getValue($array, 'fieldwidth_archive'),

				'icon_image' => alsp_getValue($array, 'icon_image'),

				'is_hide_name' => alsp_getValue($array, 'is_hide_name'),

				'is_hide_name_on_grid' => alsp_getValue($array, 'is_hide_name_on_grid'),

				'is_hide_name_on_list' => alsp_getValue($array, 'is_hide_name_on_list'),

				'is_hide_name_on_search' => alsp_getValue($array, 'is_hide_name_on_search'),

				'is_field_in_line' => alsp_getValue($array, 'is_field_in_line'),

				'on_exerpt_page' => alsp_getValue($array, 'on_exerpt_page'),

				'on_exerpt_page_list' => alsp_getValue($array, 'on_exerpt_page_list'),

				'on_listing_page' => alsp_getValue($array, 'on_listing_page'),

				'on_map' => alsp_getValue($array, 'on_map'),

		);

		// core fields can't change type

		if (!$this->is_core_field)

			$insert_update_args['type'] = alsp_getValue($array, 'type');

		if ($process_content_field->isSlug())

			$insert_update_args['slug'] = alsp_getValue($array, 'slug');



		if ($process_content_field->canBeRequired())

			$insert_update_args['is_required'] = alsp_getValue($array, 'is_required');

		else

			$insert_update_args['is_required'] = 0;



		if ($process_content_field->canBeOrdered())

			$insert_update_args['is_ordered'] = alsp_getValue($array, 'is_ordered');

		else

			$insert_update_args['is_ordered'] = 0;



		if ($process_content_field->isCategories())

			$insert_update_args['categories'] = serialize(alsp_getValue($array, 'categories', array()));

		else

			$insert_update_args['categories'] = '';

		

		if ($process_content_field->isConfigurationPage())

			$insert_update_args['is_configuration_page'] = 1;

		else

			$insert_update_args['is_configuration_page'] = 0;



		if ($process_content_field->isSearchConfigurationPage())

			$insert_update_args['is_search_configuration_page'] = 1;

		else

			$insert_update_args['is_search_configuration_page'] = 0;



		if ($this->canBeSearched()) {

			$insert_update_args['on_search_form'] = alsp_getValue($array, 'on_search_form');

			$insert_update_args['advanced_search_form'] = alsp_getValue($array, 'advanced_search_form');

		} else {

			$insert_update_args['on_search_form'] = 0;

			$insert_update_args['advanced_search_form'] = 0;

			$insert_update_args['search_options'] = '';

		}



		$insert_update_args = apply_filters('alsp_content_field_create_edit_args', $insert_update_args, $process_content_field, $array);



		if ($wpdb->update($wpdb->alsp_content_fields, $insert_update_args, array('id' => $this->id), null, array('%d')) !== false) {

			do_action('alsp_update_content_field', $this->id, $process_content_field, $array);

			return true;

		}

	}

	

	public function delete() {

		global $wpdb;



		$wpdb->delete($wpdb->postmeta, array('meta_key' => '_content_field_' . $this->id));



		$wpdb->delete($wpdb->alsp_content_fields, array('id' => $this->id));

		return true;

	}



	public function buildContentFieldFromArray($array) {

		$this->id = alsp_getValue($array, 'id');

		$this->is_core_field = alsp_getValue($array, 'is_core_field');

		$this->order_num = alsp_getValue($array, 'order_num');

		$this->name = alsp_getValue($array, 'name');

		$this->slug = alsp_getValue($array, 'slug');

		$this->description = alsp_getValue($array, 'description');

		$this->fieldwidth = alsp_getValue($array, 'fieldwidth');

		$this->fieldwidth_archive = alsp_getValue($array, 'fieldwidth_archive');

		$this->type = alsp_getValue($array, 'type');

		$this->icon_image = alsp_getValue($array, 'icon_image');

		$this->is_required = alsp_getValue($array, 'is_required');

		$this->is_configuration_page = alsp_getValue($array, 'is_configuration_page');

		$this->is_search_configuration_page = alsp_getValue($array, 'is_search_configuration_page');

		$this->on_search_form = alsp_getValue($array, 'on_search_form');

		$this->advanced_search_form = alsp_getValue($array, 'advanced_search_form');

		$this->is_ordered = alsp_getValue($array, 'is_ordered');

		$this->is_hide_name = alsp_getValue($array, 'is_hide_name');

		$this->is_hide_name_on_grid = alsp_getValue($array, 'is_hide_name_on_grid');

		$this->is_hide_name_on_list = alsp_getValue($array, 'is_hide_name_on_list');

		$this->is_hide_name_on_search = alsp_getValue($array, 'is_hide_name_on_search');

		$this->is_field_in_line = alsp_getValue($array, 'is_field_in_line');

		$this->on_exerpt_page = alsp_getValue($array, 'on_exerpt_page');

		$this->on_exerpt_page_list = alsp_getValue($array, 'on_exerpt_page_list');

		$this->on_listing_page = alsp_getValue($array, 'on_listing_page');

		$this->on_map = alsp_getValue($array, 'on_map');

		$this->categories = alsp_getValue($array, 'categories');

		$this->options = alsp_getValue($array, 'options');

		$this->search_options = alsp_getValue($array, 'search_options');

		$this->group_id = alsp_getValue($array, 'group_id');

	}

	

	public function convertCategories() {

		if ($this->categories) {

			$unserialized_categories = maybe_unserialize($this->categories);

			if (count($unserialized_categories) > 1 || $unserialized_categories != array(''))

				$this->categories = $unserialized_categories;

			else

				$this->categories = array();

		} else 

			$this->categories = array();

		return $this->categories;

	}

	public function convertListingTypes() {

		if ($this->listingtypes) {

			$unserialized_listingtypes = maybe_unserialize($this->listingtypes);

			if (count($unserialized_listingtypes) > 1 || $unserialized_listingtypes != array(''))

				$this->listingtypes = $unserialized_listingtypes;

			else

				$this->listingtypes = array();

		} else 

			$this->listingtypes = array();

		return $this->listingtypes;

	}

	public function convertOptions() {

		if ($this->options) {

			$unserialized_options = maybe_unserialize($this->options);

			if (count($unserialized_options) > 1 || $unserialized_options != array('')) {

				$this->options = $unserialized_options;

				if (method_exists($this, 'buildOptions'))

					$this->buildOptions();

				return $this->options;

			}

		}

		return array();

	}

	

	public function canBeRequired() {

		return $this->can_be_required;

	}



	public function canBeOrdered() {

		return $this->can_be_ordered;

	}



	public function isSlug() {

		return $this->is_slug;

	}



	public function isCategories() {

		return $this->is_categories;

	}



	public function isConfigurationPage() {

		return $this->is_configuration_page;

	}



	public function isSearchConfigurationPage() {

		return $this->is_search_configuration_page;

	}



	public function canBeSearched() {

		return $this->can_be_searched;

	}

	

	public function validateValues(&$errors, $data) {

		return true;

	}



	public function validateCsvValues($value, &$errors) {

		return true;

	}

	

	public function exportCSV() {

		if ($this->value) {

			return $this->value;

			//return addslashes($this->value);

		}

	}



	public function saveValue($post_id, $validation_results) {

		return true;

	}



	public function loadValue($post_id) {

		return true;

	}

	

	public function renderOutput($listing) {

		return true;

	}



	public function renderOutputForMap($location, $string) {

		return true;

	}



	public function isEmpty($listing) {

		if ($this->value)

			return false;

		else 

			return true;

	}

}



// adapted for WPML

add_action('init', 'alsp_content_fields_names_into_strings');

function alsp_content_fields_names_into_strings() {

	global $alsp_instance, $sitepress;



	if (function_exists('wpml_object_id_filter') && $sitepress) {

		foreach ($alsp_instance->content_fields->content_fields_array AS &$content_field) {

			$content_field->name = apply_filters('wpml_translate_single_string', $content_field->name, 'Ads Listing System', 'The name of content field #' . $content_field->id);

			$content_field->description = apply_filters('wpml_translate_single_string', $content_field->description, 'Ads Listing System', 'The description of content field #' . $content_field->id);

		}

		foreach ($alsp_instance->content_fields->content_fields_groups_array AS &$content_fields_group) {

			$content_fields_group->name = apply_filters('wpml_translate_single_string', $content_fields_group->name, 'Ads Listing System', 'The name of content fields group #' . $content_fields_group->id);

		}

	}

}



add_filter('alsp_content_field_create_edit_args', 'alsp_filter_content_field_fields', 10, 3);

function alsp_filter_content_field_fields($insert_update_args, $content_field, $array) {

	global $sitepress, $wpdb;



	if (function_exists('wpml_object_id_filter') && $sitepress) {

		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {

			if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['field_id'])) {

				$content_field_id = $_GET['field_id'];

				if ($name_string_id = icl_st_is_registered_string('Ads Listing System', 'The name of content field #' . $content_field_id))

					icl_add_string_translation($name_string_id, ICL_LANGUAGE_CODE, $insert_update_args['name'], ICL_TM_COMPLETE);

				if ($description_string_id = icl_st_is_registered_string('Ads Listing System', 'The description of content field #' . $content_field_id))

					icl_add_string_translation($description_string_id, ICL_LANGUAGE_CODE, $insert_update_args['description'], ICL_TM_COMPLETE);

				unset($insert_update_args['name']);

				unset($insert_update_args['description']);

				unset($insert_update_args['slug']);



				unset($insert_update_args['categories']);

			} else {

				$insert_update_args['categories'] = '';

			}

		}

	}

	return $insert_update_args;

}



add_action('alsp_update_content_field', 'alsp_save_content_field', 10, 3);

function alsp_save_content_field($content_field_id, $content_field, $array) {

	global $sitepress;



	if (function_exists('wpml_object_id_filter') && $sitepress) {

		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE && $content_field->isCategories()) {

			update_option('alsp_wpml_content_field_categories_'.$content_field_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'categories'));

		}

		

		if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {

			do_action('wpml_register_single_string', 'Ads Listing System', 'The name of content field #' . $content_field_id, alsp_getValue($array, 'name'));

			do_action('wpml_register_single_string', 'Ads Listing System', 'The description of content field #' . $content_field_id, alsp_getValue($array, 'description'));

		}

	}

}



add_filter('alsp_content_field_group_create_edit_args', 'alsp_filter_content_field_group_fields', 10, 3);

function alsp_filter_content_field_group_fields($insert_update_args, $content_field_group, $array) {

	global $sitepress, $wpdb;



	if (function_exists('wpml_object_id_filter') && $sitepress) {

		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {

			if (isset($_GET['action']) && $_GET['action'] == 'edit_group' && isset($_GET['group_id'])) {

				$content_field_group_id = $_GET['group_id'];

				if ($name_string_id = icl_st_is_registered_string('Ads Listing System', 'The name of content fields group #' . $content_field_group_id))

					icl_add_string_translation($name_string_id, ICL_LANGUAGE_CODE, $insert_update_args['name'], ICL_TM_COMPLETE);

				unset($insert_update_args['name']);

			}

		}

	}

	return $insert_update_args;

}



add_action('alsp_update_content_field_group', 'alsp_save_content_field_group', 10, 3);

function alsp_save_content_field_group($content_field_group_id, $content_field_group, $array) {

	global $sitepress;

	

	if (function_exists('wpml_object_id_filter') && $sitepress) {

		if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {

			do_action('wpml_register_single_string', 'Ads Listing System', 'The name of content fields group #' . $content_field_group_id, alsp_getValue($array, 'name'));

		}

	}

}



add_action('init', 'alsp_load_content_fields_categories');

function alsp_load_content_fields_categories() {

	global $alsp_instance, $sitepress;



	if (function_exists('wpml_object_id_filter') && $sitepress) {

		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {

			foreach ($alsp_instance->content_fields->content_fields_array AS &$content_field) {

				if ($content_field->isCategories()) {

					$_categories = get_option('alsp_wpml_content_field_categories_'.$content_field->id.'_'.ICL_LANGUAGE_CODE);

					if ($_categories && (count($_categories) > 1 || $_categories != array('')))

						$content_field->categories = $_categories;

					else

						$content_field->categories = array();

				}

			}

		}

	}

}



?>