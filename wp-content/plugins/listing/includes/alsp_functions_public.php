<?php

function alsp_tax_dropdowns_menu_init($params) {
	global $ALSP_ADIMN_SETTINGS;
	$attrs = array_merge(array(
			'uID' => 0,
			'field_name' => '',
			'count' => true,
			'tax' => 'category',
			'hide_empty' => false,
			'exact_terms' => array(),
			'autocomplete_field' => '',
			'autocomplete_field_value' => '',
			'autocomplete_ajax' => false,
			'placeholder' => '',
			'depth' => 1,
			'term_id' => 0,
	), $params);
	extract($attrs);
	
	// unique ID need when we place some dropdowns groups on one page
	if (!$uID) {
		$uID = rand(1, 10000);
	}
	
	if (!$field_name) {
		$field_name = 'selected_tax[' . $uID . ']';
	}
	
	// we use array_merge with empty array because we need to flush keys in terms array
	if ($count) {
		$terms = array_merge(
				// there is a wp bug with pad_counts in get_terms function - so we use this construction
				wp_list_filter(
						get_categories(array(
								'taxonomy' => $tax,
								'pad_counts' => true,
								'hide_empty' => $hide_empty,
						)),
						array('parent' => 0)
				), array());
	} else {
		$terms = array_merge(
				get_categories(array(
						'taxonomy' => $tax,
						'pad_counts' => true,
						'hide_empty' => $hide_empty,
						'parent' => 0,
				)), array());
	}
	
	if ($terms) {
		foreach ($terms AS $id=>$term) {
			if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
				unset($terms[$id]);
			}
		}
		
		// when selected exact sub-categories of non-root category
		if (empty($terms) && !empty($exact_terms)) {
			if ($count) {
				// there is a wp bug with pad_counts in get_terms function - so we use this construction
				$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty)));
			} else {
				$terms = get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty));
			}
		}
		
		$selected_tax_text = '';
		if ($term_id) {
			$term = get_term($term_id);
			$selected_tax_text = $term->name;
			$parents = alsp_get_term_parents($term_id, $tax, false, false, ', ');
			if ($parents) {
				$selected_tax_text .= ', ' . $parents;
			}
		}
		
		echo '<div id="alsp-tax-dropdowns-wrap-' . $uID . '" class="alsp-tax-dropdowns-wrap">';
		echo '<input type="hidden" name="' . $field_name . '" id="selected_tax[' . $uID . ']" class="selected_tax_' . $tax . '" value="' . $term_id . '" />';
		echo '<input type="hidden" name="' . $field_name . '_text" id="selected_tax_text[' . $uID . ']" class="selected_tax_text_' . $tax . '" value="' . $selected_tax_text . '" />';
		if ($exact_terms) {
			echo '<input type="hidden" id="exact_terms[' . $uID . ']" value="' . addslashes(implode(',', $exact_terms)) . '" />';
		}
		if ($autocomplete_field) {
			$autocomplete_data = 'data-autocomplete-name="' . esc_attr($autocomplete_field) . '" data-autocomplete-value="' . esc_attr($autocomplete_field_value) . '"';
			if ($autocomplete_ajax) {
				$autocomplete_data .= ' data-ajax-search=1';
			}
		} else {
			$autocomplete_data = '';
		}
		echo '<select class="alsp-form-control alsp-selectmenu-' . $tax . '" data-id="' . $uID . '" data-placeholder="' . esc_attr($placeholder) . '" ' . $autocomplete_data . '>';
		foreach ($terms AS $term) {
			if ($count) {
				$term_count = 'data-count="' . $term->count . ' ' . _n("result", "results", $term->count, "ALSP") . '"';
			} else {
				$term_count = '';
			}
			if ($term->term_id == $term_id) {
				$selected = 'data-selected="selected"';
			} else {
				$selected = '';
			}
			if($tax == 'alsp-category' || $tax == 'alsp-listingtype'){
				if($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'font'){
					$search_icon_type = 'font';
				}elseif($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'img'){
					$search_icon_type = 'img';
				}elseif($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'svg'){
					$search_icon_type = 'svg';
				}else{
					$search_icon_type = 'img';
				}
			}else{
				$search_icon_type = 'img';
			}
			if($search_icon_type == 'img'){
				$icon_type = 'img';
				$icon_color = '';
				if ($icon_file = alsp_getTermIconUrl($term->term_id)) {
					$icon = 'data-icon="' . $icon_file . '"';
				} else {
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				}
			}elseif($search_icon_type == 'font' && $tax == 'alsp-category'){
				$icon_type = 'font';
				if($cat_color_set = alsp_getCategorycolor($term->term_id)){
					$icon_color = $cat_color_set;
				}else{
					global $pacz_settings;
					$icon_color = $pacz_settings['accent-color'];
				}
				if($icon = alsp_getCategoryMarkerIcon($term->term_id)){
					$icon = 'data-icon="'.$icon.'"';
				}else{
					$icon = 'data-icon="pacz-theme-icon-search"';
				}
			}elseif($search_icon_type == 'font' && $tax == 'alsp-listingtype'){
				$icon_type = 'font';
				if($cat_color_set = alsp_getListingTypecolor($term->term_id)){
					$icon_color = $cat_color_set;
				}else{
					global $pacz_settings;
					$icon_color = $pacz_settings['accent-color'];
				}
				if($icon = alsp_getListingTypeMarkerIcon($term->term_id)){
					$icon = 'data-icon="'.$icon.'"';
				}else{
					$icon = 'data-icon="pacz-theme-icon-search"';
				}
			}elseif($search_icon_type == 'svg' && $tax == 'alsp-category'){
				$icon_type = 'svg';
				$icon_color = '';
				if(metadata_exists('term', $term->term_id, 'category-svg-image-id' ) ) {
					$image_id = get_term_meta ($term ->term_id, 'category-svg-image-id', true );
					$image_url =  wp_get_attachment_image_src( $attachment_id = $image_id, $size = array(18, 18), $icon = false);
					$image = $image_url[0];
						$icon = 'data-icon="' . $image . '"';
				}else{
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				}
			}elseif($search_icon_type == 'svg'  && $tax == 'alsp-listingtype'){
				$icon_type = 'svg';
				$icon_color = '';
				if(metadata_exists('term', $term->term_id, 'listingtype-svg-image-id' ) ) {
					$image_id = get_term_meta ($term ->term_id, 'listingtype-svg-image-id', true );
					$image_url =  wp_get_attachment_image_src( $attachment_id = $image_id, $size = array(18, 18), $icon = false);
					$image = $image_url[0];
						$icon = 'data-icon="' . $image . '"';
				}else{
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				}
			}else{
				$icon_color = '';
				$icon = 'pacz-theme-icon-search';
			}
			/* if ($icon_file = alsp_getTermIconUrl($term->term_id)) {
				$icon = 'data-icon="' . $icon_file . '"';
			} else {
				$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
			} */
			$option_id_inc = uniqid();
			echo '<option id="' . $term->slug .$option_id_inc. '" value="' . $term->term_id . '" data-fonticolor="'.$icon_color.'" data-name="' . $term->name  . '" data-sublabel="" ' . $selected . ' ' . $icon . ' data-icontype="'.$icon_type.'" ' . $term_count . '>' . $term->name . '</option>';
			if ($depth > 1) {
				echo _alsp_tax_dropdowns_menu($tax, $term->term_id, $depth, 1, $term_id, $count, $exact_terms, $hide_empty);
			}
		}
		echo '</select>';
		echo '</div>';
	}
}

function _alsp_tax_dropdowns_menu($tax, $parent = 0, $depth = 2, $current_level = 1, $term_id = null, $count = false, $exact_terms = array(), $hide_empty = false) {
	global $ALSP_ADIMN_SETTINGS;
	if ($count) {
		// there is a wp bug with pad_counts in get_terms function - so we use this construction
		$terms = wp_list_filter(
				get_categories(array(
						'taxonomy' => $tax,
						'pad_counts' => true,
						'hide_empty' => $hide_empty,
				)),
				array('parent' => $parent)
		);
	} else {
		$terms = get_categories(array(
				'taxonomy' => $tax,
				'pad_counts' => true,
				'hide_empty' => $hide_empty,
				'parent' => $parent,
		));
	}
	
	$html = '';
	if ($terms && ($depth == 0 || !is_numeric($depth) || $depth > $current_level)) {
		foreach ($terms AS $key=>$term) {
			if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
				unset($terms[$key]);
			}
		}
	
		if ($terms) {
			$current_level++;
			
			$sublabel = alsp_get_term_parents($term->parent, $tax, false, false, ', ');

			foreach ($terms AS $term) {
				if ($count) {
					$term_count = 'data-count="' . $term->count . ' ' . _n("result", "results", $term->count, "ALSP") . '"';
				} else {
					$term_count = '';
				}
				if ($term->term_id == $term_id) {
					$selected = 'data-selected="selected"';
				} else {
					$selected = '';
				}
				
				/* tax icon */
			if($tax == 'alsp-category' ||  $tax == ALSP_TYPE_TAX){
				if($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'font'){
					$search_icon_type = 'font';
				}elseif($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'img'){
					$search_icon_type = 'img';
				}elseif($ALSP_ADIMN_SETTINGS['search_cat_icon_type'] == 'svg'){
					$search_icon_type = 'svg';
				}else{
					$search_icon_type = 'img';
				}
			}else{
				$search_icon_type = 'img';
			}
			if($search_icon_type == 'img'){
				$icon_type = 'img';
				$icon_color = '';
				if ($icon_file = alsp_getTermIconUrl($term->term_id)) {
					$icon = 'data-icon="' . $icon_file . '"';
				} else {
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				}
			}elseif($search_icon_type == 'font' && $tax == 'alsp-category'){
				$icon_type = 'font';
				if($cat_color_set = alsp_getCategorycolor($term->term_id)){
					$icon_color = $cat_color_set;
				}else{
					global $pacz_settings;
					$icon_color = $pacz_settings['accent-color'];
				}
				if($icon = alsp_getCategoryMarkerIcon($term->term_id)){
					$icon = 'data-icon="'.$icon.'"';
				}else{
					$icon = 'data-icon="pacz-theme-icon-search"';
				}
			}elseif($search_icon_type == 'font' && $tax == 'alsp-listingtype'){
				$icon_type = 'font';
				if($cat_color_set = alsp_getListingTypecolor($term->term_id)){
					$icon_color = $cat_color_set;
				}else{
					global $pacz_settings;
					$icon_color = $pacz_settings['accent-color'];
				}
				if($icon = alsp_getListingTypeMarkerIcon($term->term_id)){
					$icon = 'data-icon="'.$icon.'"';
				}else{
					$icon = 'data-icon="pacz-theme-icon-search"';
				}
			}elseif($search_icon_type == 'svg'){
				$icon_type = 'svg';
				$icon_color = '';
				/*if(metadata_exists('term', $term->term_id, 'category-svg-image-id' ) ) {
					$image_id = get_term_meta ($term ->term_id, 'category-svg-image-id', true );
					$image_url =  wp_get_attachment_image( $image_id, 'full');
					//$icon_code = get_term_meta ($term->term_id, 'category-svg-image-id', true);
					$image = $image_url[0];
						$icon = 'data-icon="' . $image . '"';
				}else{*/
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				//}
			}else{
				$icon_color = '';
				$icon = 'pacz-theme-icon-search';
			}
				/* if ($icon_file = alsp_getTermIconUrl($term->term_id)) {
					$icon = 'data-icon="' . $icon_file . '"';
				} else {
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				} */
			$option_id_inc = uniqid();
				echo '<option id="' . $term->slug .$option_id_inc. '" value="' . $term->term_id . '" data-fonticolor="'.$icon_color.'" data-name="' . $term->name  . '" data-sublabel="' . $sublabel . '" ' . $selected . ' ' . $icon . ' data-icontype="' .$icon_type. '" ' . $term_count . '>' . $term->name . '</option>';
				if ($depth > $current_level) {
					echo _alsp_tax_dropdowns_menu($tax, $term->term_id, $depth, $current_level, $term_id, $count, $exact_terms, $hide_empty);
				}
			}
		}
	}
	return $html;
}
/* function alsp_tax_dropdowns_init($tax = 'category', $field_name = null, $term_id = null, $count = true, $labels = array(), $titles = array(), $uID = null) {
	// unique ID need when we place some dropdowns groups on one page
	if (!$uID)
		$uID = rand(1, 10000);

	global $ALSP_ADIMN_SETTINGS;
	if($cat_maker_icon = alsp_getCategoryMarkerIcon($term_id)){
		$icon_image = '<span class="cat-icon '.$cat_maker_icon.'"></span>';
	}else{
		$icon_image ='';
	}
	
	$localized_data[$uID] = array(
			'labels' => $labels,
			'titles' => $titles,
			'icons' => $icon_image
	);
	echo "<script> alsp_js_objects['tax_search_dropdowns_" . $uID . "'] = " . json_encode($localized_data) . "</script>";

	if (!is_null($term_id) && $term_id != 0) {
		$chain = array();
		$parent_id = $term_id;
		while ($parent_id != 0) {
			if ($term = get_term($parent_id, $tax)) {
				$chain[] = $term->term_id;
				$parent_id = $term->parent;
			} else
				break;
		}
	}
	
	$path_chain = array();
	$chain[] = 0;
	$chain = array_reverse($chain);
	$level_num = 1;

	if (!$field_name) {
		$field_name = 'selected_tax[' . $uID . ']';
		$path_field_name = 'selected_tax_path[' . $uID . ']';
	} else {
		$path_field_name = $field_name . '_path';
	}
	if($tax == 'alsp-category'){
		$term_title = esc_html__('Category', 'ALSP');
	}else if($tax == 'alsp-location'){
		$term_title = esc_html__('Location', 'ALSP');
	}
	
	if($tax == 'alsp-category' && $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search']){
		$show_count = 1;
	}elseif($tax == 'alsp-location' && $ALSP_ADIMN_SETTINGS['alsp_show_location_count_in_search']){
		$show_count = 1;
	}else{
		$show_count = 0;
	}

	echo '<div id="alsp-tax-dropdowns-search-wrap-' . $uID . '" class="' . $tax . ' cs_count_' . (int)$count . ' alsp-tax-dropdowns-search-wrap">';
	echo '<input type="hidden" name="' . $field_name . '" id="selected_tax[' . $uID . ']" class="selected_tax_' . $tax . '" value="' . $term_id . '" />';
	if($tax == 'alsp-category'){
		if (isset($_GET['categories']) && $_GET['categories'] != '0' && is_numeric($_GET['categories'])){
			$term_idf = get_term_by('id', $_GET['categories'], $tax);
			$term_title = $term_idf->name;
		}else{
			$term_title = esc_html__('Category', 'ALSP');
		}
	}elseif($tax == 'alsp-location'){
		if (isset($_GET['location_id']) && $_GET['location_id'] != '0' && is_numeric($_GET['location_id'])){
			$term_idf = get_term_by('id', $_GET['location_id'], $tax);
			$term_title = $term_idf->name;
		}else{
			$term_title = esc_html__('Location', 'ALSP');
		}
	}
	$args = array(
    'show_option_none'   => $term_title,
	'option_none_value'     => 0, // string
    'taxonomy'           => $tax,
    'id'                 => 'tax-type',
	'hierarchical' => true,
    'echo'               => false,
	'hide_empty' => false,
	'show_count'=> $show_count,
	'class' => $term_id,
);

$cat_dropdown = wp_dropdown_categories( $args );

$cat_dropdown = preg_replace( 
        '^' . preg_quote( '<select ' ) . '^', 
        '<select id="chainlist_' . $level_num . '_' . $uID . '" class="cs-select alsp-location-input pacz-select2"',
		
        $cat_dropdown
    );

echo $cat_dropdown;
	echo '<input type="hidden" name="' . $path_field_name . '" id="selected_tax_path[' . $uID . ']" class="selected_tax_path_' . $tax . '" value="' . implode(', ', $path_chain) . '" />';
	echo '</div>';

} */
function alsp_tax_dropdowns_init($tax = 'category', $field_name = null, $term_id = null, $count = true, $labels = array(), $titles = array(), $uID = null, $exact_terms = array(), $hide_empty = false) {
	// unique ID need when we place some dropdowns groups on one page
	if (!$uID) {
		$uID = rand(1, 10000);
	}

	$localized_data[$uID] = array(
			'labels' => $labels,
			'titles' => $titles
	);
	echo "<script>alsp_js_objects['tax_dropdowns_" . $uID . "'] = " . json_encode($localized_data) . "</script>";

	if (!is_null($term_id) && $term_id != 0) {
		$chain = array();
		$parent_id = $term_id;
		while ($parent_id != 0) {
			if ($term = get_term($parent_id, $tax)) {
				$chain[] = $term->term_id;
				$parent_id = $term->parent;
			} else {
				break;
			}
		}
	}
	$chain[] = 0;
	$chain = array_reverse($chain);

	if (!$field_name) {
		$field_name = 'selected_tax[' . $uID . ']';
	}

	echo '<div id="alsp-tax-dropdowns-wrap-' . $uID . '" class="' . $tax . ' cs_count_' . (int)$count . ' cs_hide_empty_' . (int)$hide_empty . ' alsp-tax-dropdowns-wrap">';
	echo '<input type="hidden" name="' . $field_name . '" id="selected_tax[' . $uID . ']" class="selected_tax_' . $tax . '" value="' . $term_id . '" />';
	if ($exact_terms) {
		echo '<input type="hidden" id="exact_terms[' . $uID . ']" value="' . addslashes(implode(',', $exact_terms)) . '" />';
	}
	foreach ($chain AS $key=>$term_id) {
		if ($count) {
			// there is a wp bug with pad_counts in get_terms function - so we use this construction
			$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty)), array('parent' => $term_id));
		} else {
			$terms = get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty, 'parent' => $term_id));
		}

		if (!empty($terms)) {
			foreach ($terms AS $id=>$term) {
				if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
					unset($terms[$id]);
				}
			}

			// when selected exact sub-categories of non-root category
			if (empty($terms) && !empty($exact_terms)) {
				if ($count) {
					// there is a wp bug with pad_counts in get_terms function - so we use this construction
					$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty)));
				} else {
					$terms = get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty));
				}
			}

			if (!empty($terms)) {
				$level_num = $key + 1;
				echo '<div id="wrap_chainlist_' . $level_num . '_' .$uID . '" class="alsp-location-input clearfix">';
					echo '<div class="row">';
						if (isset($labels[$key])) {
							echo '<div class="col-md-12">';
								echo '<label class="alsp-control-label" for="chainlist_' . $level_num . '_' . $uID . '">' . $labels[$key] . '</label>';
							echo '</div>';
						}
						echo '<div class="col-md-12">';
							echo '<select id="chainlist_' . $level_num . '_' . $uID . '" class="alsp-form-control alsp-selectmenu pacz-select2">';
								echo '<option value="">- ' . ((isset($titles[$key])) ? $titles[$key] : __('Select term', 'ALSP')) . ' -</option>';
								foreach ($terms AS $term) {
									if ($count)
										$term_count = " ($term->count)";
									else
										 $term_count = '';
									if (isset($chain[$key+1]) && $term->term_id == $chain[$key+1]) {
										$selected = 'selected';
									} else
										$selected = '';
											
									if ($icon_file = alsp_getTermIconUrl($term->term_id))
										$icon = 'data-class="term-icon" data-icon="' . $icon_file . '"';
									else
										$icon = '';
			
									echo '<option id="' . $term->slug . '" value="' . $term->term_id . '" ' . $selected . ' ' . $icon . '>' . $term->name . $term_count . '</option>';
								}
							echo '</select>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		}
	}
	echo '</div>';
}

function alsp_tax_dropdowns_updateterms() {
	$parentid = alsp_getValue($_POST, 'parentid');
	$next_level = alsp_getValue($_POST, 'next_level');
	$tax = alsp_getValue($_POST, 'tax');
	$count = alsp_getValue($_POST, 'count');
	$hide_empty = alsp_getValue($_POST, 'hide_empty');
	$exact_terms = array_filter(explode(',', alsp_getValue($_POST, 'exact_terms')));
	if (!$label = alsp_getValue($_POST, 'label'))
		$label = '';
	if (!$title = alsp_getValue($_POST, 'title'))
		$title = __('Select term', 'ALSP');
	$uID = alsp_getValue($_POST, 'uID');
	
	if ($hide_empty == 'cs_hide_empty_1') {
		$hide_empty = true;
	} else {
		$hide_empty = false;
	}

	if ($count == 'cs_count_1') {
		// there is a wp bug with pad_counts in get_terms function - so we use this construction
		$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty)), array('parent' => $parentid));
	} else {
		$terms = get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty, 'parent' => $parentid));
	}
	if (!empty($terms)) {
		foreach ($terms AS $id=>$term) {
			if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
				unset($terms[$id]);
			}
		}

		if (!empty($terms)) {
			echo '<div id="wrap_chainlist_' . $next_level . '_' . $uID . '" class="alsp-location-input">';
				echo '<div class="row">';
					if ($label) {
						echo '<div class="col-md-12">';
						echo '<label class="alsp-control-label" for="chainlist_' . $next_level . '_' . $uID . '">' . $label . '</label>';
						echo '</div>';
					}
					echo '<div class="col-md-12">';
						echo '<select id="chainlist_' . $next_level . '_' . $uID . '" class="alsp-form-control alsp-selectmenu pacz-select2">';
							echo '<option value="">- ' . $title . ' -</option>';
							foreach ($terms as $term) {
								if (!$exact_terms || (in_array($term->term_id, $exact_terms) || in_array($term->slug, $exact_terms))) {
									if ($count == 'cs_count_1') {
										$term_count = " ($term->count)";
									} else {
										$term_count = '';
									}
									
									if ($icon_file = alsp_getTermIconUrl($term->term_id))
										$icon = 'data-class="term-icon" data-icon="' . $icon_file . '"';
									else
										$icon = '';
									
									echo '<option id="' . $term->slug . '" value="' . $term->term_id . '" ' . $icon . '>' . $term->name . $term_count . '</option>';
								}
							}
						echo '</select>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}
	die();
}

function alsp_renderOptionsTerms($tax, $parent, $selected_terms, $level = 0) {
	$terms = get_terms($tax, array('parent' => $parent, 'hide_empty' => false));

	foreach ($terms AS $term) {
		echo '<option value="' . $term->term_id . '" ' . (($selected_terms && (in_array($term->term_id, $selected_terms) || in_array($term->slug, $selected_terms))) ? 'selected' : '') . '>' . (str_repeat('&nbsp;&nbsp;&nbsp;', $level)) . $term->name . '</option>';
		alsp_renderOptionsTerms($tax, $term->term_id, $selected_terms, $level+1);
	}
	return $terms;
}

function alsp_termsSelectList($name, $tax = 'category', $selected_terms = array()) {
	echo '<select multiple="multiple" name="' . $name . '[]" class="selected_terms_list alsp-form-control alsp-form-group" style="height: 300px">';
	echo '<option value="" ' . ((!$selected_terms) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';

	alsp_renderOptionsTerms($tax, 0, $selected_terms);

	echo '</select>';
}
function alsp_recaptcha() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
		return '<div class="g-recaptcha" data-sitekey="'.$ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'].'"></div>';
	}
}

function alsp_is_recaptcha_passed() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
		if (isset($_POST['g-recaptcha-response']))
			$captcha = $_POST['g-recaptcha-response'];
		else
			return false;
		
		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=".$ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if (!is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$json = json_decode($body);
			if ($json->success === false)
				return false;
			else
				return true;
		} else
			return false;
	} else
		return true;
}

function alsp_orderLinks($base_url, $defaults = array(), $return = false, $shortcode_hash = null) {
	global $alsp_instance;
	global $ALSP_ADIMN_SETTINGS;
	if (isset($_GET['order_by']) && $_GET['order_by']) {
		$order_by = $_GET['order_by'];
		$order = alsp_getValue($_GET, 'order', 'ASC');
	} else {
		if (isset($defaults['order_by']) && $defaults['order_by']) {
			$order_by = $defaults['order_by'];
			$order = alsp_getValue($defaults, 'order', 'ASC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$ordering['array'] = array();
	if ($ALSP_ADIMN_SETTINGS['alsp_orderby_date'])
		$ordering['array']['post_date'] = __('Date', 'ALSP');
	if ($ALSP_ADIMN_SETTINGS['alsp_orderby_title'])
		$ordering['array']['title'] = __('Title', 'ALSP');

	$exact_categories = array();
	if (!empty($defaults['categories'])) {
		$exact_categories = array_filter(explode(',', $defaults['categories']));
	}
	if ($current_category = alsp_is_category()) {
		$exact_categories[] = $current_category->term_id;
	}
	$content_fields = $alsp_instance->content_fields->getOrderingContentFields();
	foreach ($content_fields AS $content_field) {
		if ($exact_categories && $content_field->categories) {
			if (array_intersect($content_field->categories, $exact_categories)) {
				$ordering['array'][$content_field->slug] = $content_field->name;
			}
		} else {
			$ordering['array'][$content_field->slug] = $content_field->name;
		}
	}
	
	$ordering['links'] = array();
	$ordering['struct'] = array();
	foreach ($ordering['array'] AS $field_slug=>$field_name) {
		$class = '';
		$next_order = 'DESC';
		if ($order_by == $field_slug) {
			if ($order == 'ASC') {
				$class = 'ascending';
				$next_order = 'ASC';
				$url = esc_url(add_query_arg(array('order_by' => $field_slug, 'order' => $next_order), $base_url));
			} elseif ($order == 'DESC') {
				$class = 'descending';
				$next_order = 'DESC';
				$url = esc_url(add_query_arg('order_by', $field_slug, $base_url));
			}
		} else {
			if ($field_slug == 'title') {
				$next_order = 'ASC';
				$url = esc_url(add_query_arg(array('order_by' => $field_slug, 'order' => $next_order), $base_url));
			} else
				$url = esc_url(add_query_arg('order_by', $field_slug, $base_url));
		}

		$ordering['links'][$field_slug] = '<a class="' . $class . '" href="' . $url . '" rel="nofollow">' .$field_name . '</a>';
		$ordering['struct'][$field_slug] = array('class' => $class, 'url' => $url, 'field_name' => $field_name, 'order' => $next_order);
	}

	$ordering = apply_filters('alsp_ordering_options', $ordering, $base_url, $defaults, $shortcode_hash);

	if ($return)
		return $ordering;
	else
		echo __('Order by: ', 'ALSP') . implode(' | ', $ordering['links']);
}

function alsp_orderingItems() {
	global $alsp_instance;

	$ordering = array(
	'post_date' => __('Date', 'ALSP'),
	'title' => __('Title', 'ALSP'),
	'rand' => __('Random', 'ALSP')
	);
	if($alsp_instance === null){
		$content_fields = $alsp_instance->content_fields->getOrderingContentFields();
		foreach ($content_fields AS $content_field) {
			$ordering[$content_field->slug] = $content_field->name;
		}
	}
	$ordering = apply_filters('alsp_default_orderby_options', $ordering);
	$ordering_items = array();
	foreach ($ordering AS $field_slug=>$field_name) {
		$ordering_items[] = array('value' => $field_slug, 'label' => $field_name);
	}
	$new_listing_ordering = array();
	foreach($ordering_items as $listItem) {
		$new_listing_ordering[$listItem['value']] = $listItem['label'];
	}
	return $new_listing_ordering;
	//return $ordering_items;
}

function alsp_renderSubCategories($parent_category_slug = '', $columns = 2, $count = false) {
	if ($parent_category = alsp_get_term_by_path($parent_category_slug))
		$parent_category_id = $parent_category->term_id;
	else
		$parent_category_id = 0;
	
	alsp_renderAllCategories($parent_category_id, 1, $columns, $count);
}

function alsp_renderSubLocations($parent_location_slug = '', $columns = 2, $count = false) {
	if ($parent_location = alsp_get_term_by_path($parent_location_slug))
		$parent_location_id = $parent_location->term_id;
	else
		$parent_location_id = 0;
	
	alsp_renderAllLocations($parent_location_id, 1, $columns, $count);
}

/* function alsp_terms_checklist($post_id) {
	if ($terms = get_categories(array('taxonomy' => ALSP_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => 0))) {
		$checked_categories_ids = array();
		$checked_categories = wp_get_object_terms($post_id, ALSP_CATEGORIES_TAX);
		foreach ($checked_categories AS $term)
			$checked_categories_ids[] = $term->term_id;

		echo '<ul id="alsp-categorychecklist" class="alsp-categorychecklist">';
		foreach ($terms AS $term) {
			$checked = '';
			if (in_array($term->term_id, $checked_categories_ids))
				$checked = 'checked';
				
			echo '
<li id="' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '">';
			echo '<label class="alsp-parent-cat selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_CATEGORIES_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			echo _alsp_terms_checklist($term->term_id, $checked_categories_ids);
			echo '</li>';
		}
		echo '</ul>';
	}
} */
function alsp_terms_checklist($post_id) {
	if ($terms = get_categories(array('taxonomy' => ALSP_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => 0))) {
		$checked_categories_ids = array();
		$checked_categories = wp_get_object_terms($post_id, ALSP_CATEGORIES_TAX);
		foreach ($checked_categories AS $term)
			$checked_categories_ids[] = $term->term_id;

		echo '<ul id="alsp-categorychecklist" class="alsp-categorychecklist">';
		foreach ($terms AS $term) {
			$classes = '';
			$checked = '';
			if (in_array($term->term_id, $checked_categories_ids)) {
				$checked = 'checked';
			}
			
			if (defined('ALSP_EXPANDED_CATEGORIES_TREE') && ALSP_EXPANDED_CATEGORIES_TREE) {
				$classes .= 'active ';
			}
				
			echo '<li id="' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" class="' . $classes . '">';
			echo '<label class="alsp-parent-cat selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_CATEGORIES_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			echo _alsp_terms_checklist($term->term_id, $checked_categories_ids);
			echo '</li>';
		}
		echo '</ul>';
	}
}
function alsp_terms_checklist_listingtypes($post_id) {
	if($terms = get_categories(array('taxonomy' => ALSP_TYPE_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => 0))) {
		$checked_listingtypes_ids = array();
		$checked_listingtypes = wp_get_object_terms($post_id, ALSP_TYPE_TAX);
		foreach ($checked_listingtypes AS $term)
			$checked_listingtypes_ids[] = $term->term_id;

		echo '<ul id="alsp-listingtypechecklist" class="alsp-listingtypechecklist">';
		foreach ($terms AS $term) {
			$classes = '';
			$checked = '';
			if (in_array($term->term_id, $checked_listingtypes_ids)) {
				$checked = 'checked';
			}
			
			if (defined('ALSP_EXPANDED_LISTINGTYPES_TREE') && ALSP_EXPANDED_LISTINGTYPES_TREE) {
				$classes .= 'active ';
			}
				
			echo '<li id="' . ALSP_TYPE_TAX . '-' . $term->term_id . '" class="' . $classes . '">';
			echo '<label class="alsp-parent-listingtype selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_TYPE_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_TYPE_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			echo _alsp_terms_checklist_listingtypes($term->term_id, $checked_listingtypes_ids);
			echo '</li>';
		}
		echo '</ul>';
		
	}
}

function _alsp_terms_checklist($parent = 0, $checked_categories_ids = array()) {
	$html = '';
	if ($terms = get_categories(array('taxonomy' => ALSP_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => $parent))) {
		$html .= '<ul class="children">';
		foreach ($terms AS $term) {
			$checked = '';
			if (in_array($term->term_id, $checked_categories_ids)) {
				$checked = 'checked';
			}
			
			$classes = '';
			if (defined('ALSP_EXPANDED_CATEGORIES_TREE') && ALSP_EXPANDED_CATEGORIES_TREE) {
				$classes .= 'active ';
			}

			$html .= '<li id="' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" class="' . $classes . '">';
			$html .= '<label class="selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_CATEGORIES_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			$html .= _alsp_terms_checklist($term->term_id, $checked_categories_ids);
			$html .= '</li>';
		}
		$html .= '</ul>';
	}
	return $html;
}

function _alsp_terms_checklist_listingtypes($parent = 0, $checked_listingtypes_ids = array()) {
	$html = '';
	if ($terms = get_categories(array('taxonomy' => ALSP_TYPE_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => $parent))) {
		$html .= '<ul class="children">';
		foreach ($terms AS $term) {
			$checked = '';
			if (in_array($term->term_id, $checked_listingtypes_ids)) {
				$checked = 'checked';
			}
			
			$classes = '';
			if (defined('ALSP_EXPANDED_LISTINGTYPES_TREE') && ALSP_EXPANDED_LISTINGTYPES_TREE) {
				$classes .= 'active ';
			}

			$html .= '<li id="' . ALSP_TYPE_TAX . '-' . $term->term_id . '" class="' . $classes . '">';
			$html .= '<label class="selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_TYPE_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_TYPE_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			$html .= _alsp_terms_checklist($term->term_id, $checked_listingtypes_ids);
			$html .= '</li>';
		}
		$html .= '</ul>';
	}
	return $html;
}
function alsp_tags_selectbox($post_id) {
	$terms = get_categories(array('taxonomy' => ALSP_TAGS_TAX, 'pad_counts' => true, 'hide_empty' => false));
	$checked_tags_ids = array();
	$checked_tags_names = array();
	$checked_tags = wp_get_object_terms($post_id, ALSP_TAGS_TAX);
	foreach ($checked_tags AS $term) {
		$checked_tags_ids[] = $term->term_id;
		$checked_tags_names[] = $term->name;
	}

	echo '<select name="' . ALSP_TAGS_TAX . '[]" multiple="multiple" class="alsp-tokenizer">';
	foreach ($terms AS $term) {
		$checked = '';
		if (in_array($term->term_id, $checked_tags_ids))
			$checked = 'selected';
		echo '<option value="' . esc_attr($term->name) . '" ' . $checked . '>' . $term->name . '</option>';
	}
	echo '</select>';
}
function alsp_getTermIconUrl($term_id) {
	$term = get_term($term_id);

	if (!is_wp_error($term)) {
		if ($term->taxonomy == ALSP_CATEGORIES_TAX && ($category_icon = alsp_getCategoryIcon($term_id))) {
			return ALSP_CATEGORIES_ICONS_URL . $category_icon;
		}
		if ($term->taxonomy == ALSP_TYPE_TAX && ($listingtype_icon = alsp_getListingTypeIcon($term_id))) {
			return ALSP_LISTINGTYPE_ICONS_URL . $listingtype_icon;
		}
		if ($term->taxonomy == ALSP_LOCATIONS_TAX && ($location_icon = alsp_getCategoryIcon($term_id))) {
			return ALSP_LOCATIONS_ICONS_URL . $location_icon;
		}
	}
}

function alsp_getDefaultTermIconUrl($tax) {
	if ($tax == ALSP_CATEGORIES_TAX) {
		return ALSP_CATEGORIES_ICONS_URL . 'search.png';
	}
	if ($tax == ALSP_LOCATIONS_TAX) {
		return ALSP_LOCATIONS_ICONS_URL . 'icon1.png';
	}
}
function alsp_categoriesOfLevels($allowed_levels = array()) {
	global $alsp_instance;
	
	$allowed_categories = array();
	foreach ((array) $allowed_levels AS $level_id) {
		if (isset($alsp_instance->levels->levels_array[$level_id])) {
			$level = $alsp_instance->levels->levels_array[$level_id];
			$allowed_categories = array_merge($allowed_categories, $level->categories);
		}
	}
	
	return $allowed_categories;
}

function alsp_displayCategoriesTable($category_id = 0) {
	global $alsp_instance, $ALSP_ADIMN_SETTINGS;

	if ($alsp_instance->current_directory->categories) {
		$exact_categories = $alsp_instance->current_directory->categories;
	} else {
		$exact_categories = array();
	}
	if($ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$params = array(
				'parent' => $category_id,
				'depth' => $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level'],
				'hide_empty' => 0,
				'columns' => 1,
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_category_count'],
				'max_subterms' => $ALSP_ADIMN_SETTINGS['alsp_subcategories_items'],
				'exact_terms' => $exact_categories,
				'menu' => 0,
				'cat_style' =>  3,
				'cat_icon_type' => $ALSP_ADIMN_SETTINGS['cat_icon_type']
		);
	}else{
		$params = array(
				'parent' => $category_id,
				'depth' => $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level'],
				'hide_empty' => 0,
				'columns' => $ALSP_ADIMN_SETTINGS['alsp_categories_columns'],
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_category_count'],
				'max_subterms' => $ALSP_ADIMN_SETTINGS['alsp_subcategories_items'],
				'exact_terms' => $exact_categories,
				'menu' => 0,
				'cat_style' =>  $ALSP_ADIMN_SETTINGS['alsp_categories_style'],
				'cat_icon_type' => $ALSP_ADIMN_SETTINGS['cat_icon_type']
		);
	}
	$categories_view = new alsp_categories_view($params);
	$categories_view->display();
}
function alsp_displayListingTypeTable($listingtype_id = 0) {
	global $alsp_instance, $ALSP_ADIMN_SETTINGS;

	if ($alsp_instance->current_directory->listingtypes) {
		$exact_listingtypes = $alsp_instance->current_directory->listingtypes;
	} else {
		$exact_listingtypes = array();
	}
	if($ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$params = array(
				'parent' => $listingtype_id,
				'depth' => $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level'],
				'hide_empty' => 0,
				'columns' => 1,
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_category_count'],
				'max_subterms' => $ALSP_ADIMN_SETTINGS['alsp_subcategories_items'],
				'exact_terms' => $exact_listingtypes,
				'menu' => 0,
				'cat_style' =>  3,
				'cat_icon_type' => $ALSP_ADIMN_SETTINGS['cat_icon_type']
		);
	}else{
		$params = array(
				'parent' => $listingtype_id,
				'depth' => $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level'],
				'hide_empty' => 0,
				'columns' => $ALSP_ADIMN_SETTINGS['alsp_categories_columns'],
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_category_count'],
				'max_subterms' => $ALSP_ADIMN_SETTINGS['alsp_subcategories_items'],
				'exact_terms' => $exact_listingtypes,
				'menu' => 0,
				'cat_style' =>  $ALSP_ADIMN_SETTINGS['alsp_categories_style'],
				'cat_icon_type' => $ALSP_ADIMN_SETTINGS['cat_icon_type']
		);
	}
	$listingtypes_view = new alsp_listingtypes_view($params);
	$listingtypes_view->display();
}
function alsp_displayLocationsTable($location_id = 0) {
	global $alsp_instance, $ALSP_ADIMN_SETTINGS;

	if ($alsp_instance->current_directory->locations) {
		$exact_locations = $alsp_instance->current_directory->locations;
	} else {
		$exact_locations = array();
	}
	if($ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$params = array(
				'parent' => $location_id,
				'depth' => 1,
				'hide_empty' => 0,
				'columns' => 1,
				'count' => 1,
				'max_subterms' => 0,
				'exact_terms' => $exact_locations,
				'menu' => 0,
				'location_style' => 0,
				'location_padding' => 0,
		);
	}else{
		$params = array(
				'parent' => $location_id,
				'depth' => $ALSP_ADIMN_SETTINGS['alsp_locations_nesting_level'],
				'hide_empty' => 0,
				'columns' => $ALSP_ADIMN_SETTINGS['alsp_locations_columns'],
				'count' => $ALSP_ADIMN_SETTINGS['alsp_show_location_count'],
				'max_subterms' => $ALSP_ADIMN_SETTINGS['alsp_sublocations_items'],
				'exact_terms' => $exact_locations,
				'menu' => 0,
				'location_style' => $ALSP_ADIMN_SETTINGS['alsp_location_style'],
				'location_padding' => $ALSP_ADIMN_SETTINGS['alsp_location_padding'],
		);
	}
	$locations_view = new alsp_locations_view($params);
	$locations_view->display();
}


function alsp_getCategoryIcon($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->categories_manager->getCategoryIconFile($term_id))
		return $icon_file;
}

function alsp_getCategoryIcon2($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->categories_manager->getCategoryIconFile2($term_id))
		return $icon_file;
}
function alsp_getCategorycolor($term_id) {
	global $alsp_instance;
	
	if ($cat_bg_color = $alsp_instance->categories_manager->getCategoryMarkerColor($term_id))
		return $cat_bg_color;
}
function alsp_getListingTypeIcon($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->listingtype_manager->getListingTypeIconFile($term_id))
		return $icon_file;
}

function alsp_getListingTypeIcon2($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->listingtype_manager->getListingTypeIconFile2($term_id))
		return $icon_file;
}
function alsp_getListingTypecolor($term_id) {
	global $alsp_instance;
	
	if ($listingtype_bg_color = $alsp_instance->listingtype_manager->getListingTypeMarkerColor($term_id))
		return $listingtype_bg_color;
}
function alsp_getCategoryMarkerIcon($term_id) {
	global $alsp_instance;
	
	if ($cat_maker_icon = $alsp_instance->categories_manager->getCategoryMarkerIcon($term_id))
		return $cat_maker_icon;
}
function alsp_getListingTypeMarkerIcon($term_id) {
	global $alsp_instance;
	
	if ($cat_maker_icon = $alsp_instance->listingtype_manager->getListingTypeMarkerIcon($term_id))
		return $cat_maker_icon;
}
function alsp_getLocationIcon($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->locations_manager->getLocationIconFile($term_id))
		return $icon_file;
}

function alsp_show_404() {
	status_header(404);
	nocache_headers();
	include(get_404_template());
	exit;
}

function alsp_login_form($args = array()) {
	$defaults = array(
			'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
			'form_id' => 'loginform',
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in' => __( 'Log In' ),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => '',
			'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked
	);
	$args = wp_parse_args($args, apply_filters( 'login_form_defaults', $defaults));
	
	echo '<div class="alsp-content">';
	
	echo '
		<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post" class="alsp_login_form" role="form">
			' . apply_filters( 'login_form_top', '', $args ) . '
			<p class="form-group">
				<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
				<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="form-control" value="' . esc_attr( $args['value_username'] ) . '" />
			</p>
			<p class="login-password">
				<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
				<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="form-control" value="" />
			</p>
			' . apply_filters( 'login_form_middle', '', $args ) . '
			' . ( $args['remember'] ? '<p class="checkbox"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
			<p class="login-submit">
				<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="btn btn-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
			</p>
			' . apply_filters( 'login_form_bottom', '', $args ) . '
		</form>';

	do_action('login_form');
	do_action('login_footer');
	echo '<p id="nav">';
	if (get_option('users_can_register'))
		echo '<a href="' . esc_url( wp_registration_url() ) . '" rel="nofollow">' . __('Register', 'ALSP') . '</a> | ';

	echo '<a title="' . esc_attr__('Password Lost and Found', 'ALSP') . '" href="' . esc_url( wp_lostpassword_url() ) . '">' . __('Lost your password?', 'ALSP') . '</a>';
	echo '</p>';

	echo '</div>';
}


if (!function_exists('alsp_renderPaginator')) {
	function alsp_renderPaginator($query, $hash = null, $show_more_button = false, $public_control = null) {
		global $alsp_instance;
		
		if (empty($public_control)) {
			$directory = $alsp_instance->current_directory;
		} else {
			$directory = $public_control->getListingsDirectory();
		}
		if (get_class($query) == 'WP_Query') {
			if (get_query_var('page'))
				$paged = get_query_var('page');
			elseif (get_query_var('paged'))
				$paged = get_query_var('paged');
			else
				$paged = 1;

			$total_pages = $query->max_num_pages;
			$total_lines = ceil($total_pages/10);
		
			if ($total_pages > 1){
				$current_page = max(1, $paged);
				$current_line = floor(($current_page-1)/10) + 1;
		
				$previous_page = $current_page - 1;
				$next_page = $current_page + 1;
				$previous_line_page = floor(($current_page-1)/10)*10;
				$next_line_page = ceil($current_page/10)*10 + 1;
				
				if (!$show_more_button) {
					echo '<div class="alsp-pagination-wrapper">';
					echo '<ul class="pagination">';
					if ($total_pages > 10 && $current_page > 10)
						echo '<li class="alsp-inactive previous_line"><a href="' . get_pagenum_link($previous_line_page) . '" title="' . esc_attr__('Previous Line', 'ALSP') . '" data-page=' . $previous_line_page . ' data-controller-hash=' . $hash . '><<</a></li>' ;
			
					if ($total_pages > 3 && $current_page > 1)
						echo '<li class="alsp-inactive previous"><a href="' . get_pagenum_link($previous_page) . '" title="' . esc_attr__('Previous Page', 'ALSP') . '" data-page=' . $previous_page . ' data-controller-hash=' . $hash . '><</i></a></li>' ;
			
					$count = ($current_line-1)*10;
					$end = ($total_pages < $current_line*10) ? $total_pages : $current_line*10;
					while ($count < $end) {
						$count = $count + 1;
						if ($count == $current_page)
							echo '<li class="active"><a href="' . get_pagenum_link($count) . '">' . $count . '</a></li>' ;
						else
							echo '<li class="alsp-inactive"><a href="' . get_pagenum_link($count) . '" data-page=' . $count . ' data-controller-hash=' . $hash . '>' . $count . '</a></li>' ;
					}
			
					if ($total_pages > 3 && $current_page < $total_pages)
						echo '<li class="alsp-inactive next"><a href="' . get_pagenum_link($next_page) . '" title="' . esc_attr__('Next Page', 'ALSP') . '" data-page=' . $next_page . ' data-controller-hash=' . $hash . '>></i></a></li>' ;
			
					if ($total_pages > 10 && $current_line < $total_lines)
						echo '<li class="alsp-inactive next_line"><a href="' . get_pagenum_link($next_line_page) . '" title="' . esc_attr__('Next Line', 'ALSP') . '" data-page=' . $next_line_page . ' data-controller-hash=' . $hash . '>>></a></li>' ;
			
					echo '</ul>';
					echo '</div>';
				} else {
					if ($public_control && !empty($public_control->args['scrolling_paginator'])) {
						$scrolling_paginator_class = "alsp-scrolling-paginator";
					} else {
						$scrolling_paginator_class = '';
					}
					echo '<button class="btn btn-primary btn-lg btn-block alsp-show-more-button pacz-new-btn-4 ' . $scrolling_paginator_class . '" data-controller-hash="' . $hash . '">' . sprintf(__('Show more %s', 'ALSP'), $directory->plural) . '</button>';
				}
			}
		}
	}
}

function alsp_renderSharingButton($post_id, $button) {
	global $alsp_social_services, $ALSP_ADIMN_SETTINGS;
	$post_title = urlencode(get_the_title($post_id));
	$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), array(200, 200));
	$post_thumbnail = urlencode($thumb_url[0]);
	if (get_post_type($post_id) == ALSP_POST_TYPE) {
		$listing = new alsp_listing;
		if ($listing->loadListingFromPost($post_id))
			$post_title = urlencode($listing->title());
	}
	$post_url = urlencode(get_permalink($post_id));

	if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled']) {
		$share_url = false;
		$share_counter = false;
		switch ($button) {
			case 'Facebook':
				$share_url = 'http://www.facebook.com/sharer.php?u=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json[0]->total_count)) ? intval($json[0]->total_count) : 0;
					}
				}
			break;
			case 'Twitter':
				$share_url = 'http://twitter.com/share?url=' . $post_url . '&amp;text=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://urls.api.twitter.com/1/urls/count.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Digg':
				$share_url = 'http://www.digg.com/submit?url=' . $post_url;
			break;
			case 'Reddit':
				$share_url = 'http://reddit.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.reddit.com/api/info.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->data->children[0]->data->score)) ? intval($json->data->children[0]->data->score) : 0;
					}
				}
			break;
			case 'LinkedIn':
				$share_url = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.linkedin.com/countserv/count/share?url=' . $post_url . '&format=json');
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Pinterest':
				$share_url = 'https://www.pinterest.com/pin/create/button/?url=' . $post_url . '&amp;media=' . $post_thumbnail . '&amp;description=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://api.pinterest.com/v1/urls/count.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $response['body']);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Stumbleupon':
				$share_url = 'http://www.stumbleupon.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->result->views)) ? intval($json->result->views) : 0;
					}
				}
			break;
			case 'Tumblr':
				$share_url = 'http://www.tumblr.com/share/link?url=' . str_replace('http://', '', str_replace('https://', '', $post_url)) . '&amp;name=' . $post_title;
			break;
			case 'vk':
				$share_url = 'http://vkontakte.ru/share.php?url=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://vkontakte.ru/share.php?act=count&index=1&url=' . $post_url);
					if (!is_wp_error($response)) {
						$tmp = array();
						preg_match('/^VK.Share.count\(1, (\d+)\);$/i', $response['body'], $tmp);
						$share_counter = (isset($tmp[1])) ? intval($tmp[1]) : 0;
					}
				}
			break;
			case 'Email':
				$share_url = 'mailto:?Subject=' . $post_title . '&amp;Body=' . $post_url;
			break;
		}

		//if ($share_url !== false) {
			echo '<a href="'.$share_url.'" data-toggle="tooltip" title="'.sprintf(__('Share on %s', 'ALSP'), $button).'" target="_blank"><img src="'.ALSP_RESOURCES_URL.'images/social/'.$ALSP_ADIMN_SETTINGS['alsp_share_buttons_style'].'/'.$button.'.png" /></a>';
			if ($ALSP_ADIMN_SETTINGS['alsp_share_counter'] && $share_counter !== false)
				echo '<span class="alsp-share-count">'.number_format($share_counter).'</span>';
		//}
	}
}
function alsp_hintMessage($message, $placement = 'auto', $return = false) {
	$out = '<a class="alsp-hint-icon" href="javascript:void(0);" data-content="' . esc_attr($message) . '" data-html="true" rel="popover" data-placement="' . $placement . '" data-trigger="hover"></a>';
	if ($return) {
		return $out;
	} else {
		echo $out;
	}
}
function alsp_levelPriceString($level) {
	global $ALSP_ADIMN_SETTINGS;
	$price = apply_filters('alsp_submitlisting_level_price', null, $level);
	if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-4'){
		$spliter = '';
		$for = __('For', 'ALSP');
	}else{
		$spliter = '&#47;';
		$for = '';
	}
	if (!is_null($price)) {
		if (!$level->eternal_active_period) {
			if ($level->active_period == 'day' && $level->active_interval == 1)
				$price .= '<span class="alsp-price-period">'.$spliter . __('Per day', 'ALSP') . '</span>';
			elseif ($level->active_period == 'day' && $level->active_interval > 1)
				$price .= '<span class="alsp-price-period">'.$spliter . $for.' '.  $level->active_interval . ' ' . _n('day', 'days', $level->active_interval, 'ALSP') . '</span>';
			elseif ($level->active_period == 'week' && $level->active_interval == 1)
				$price .= '<span class="alsp-price-period">'.$spliter . __('Per week', 'ALSP');
			elseif ($level->active_period == 'week' && $level->active_interval > 1)
				$price .= '<span class="alsp-price-period">'.$spliter . $for.' '. $level->active_interval . ' ' . _n('week', 'weeks', $level->active_interval, 'ALSP') . '</span>';
			elseif ($level->active_period == 'month' && $level->active_interval == 1)
				$price .= '<span class="alsp-price-period">'.$spliter . __('Per month', 'ALSP');
			elseif ($level->active_period == 'month' && $level->active_interval > 1)
				$price .= '<span class="alsp-price-period">'.$spliter . $for.' '. $level->active_interval . ' ' . _n('month', 'months', $level->active_interval, 'ALSP') . '</span>';
			elseif ($level->active_period == 'year' && $level->active_interval == 1)
				$price .= '<span class="alsp-price-period">'.$spliter . __('Per Year', 'ALSP') . '</span>';
			elseif ($level->active_period == 'year' && $level->active_interval > 1)
				$price .= '<span class="alsp-price-period">'.$spliter . $for.' '. $level->active_interval . ' ' . _n('year', 'years', $level->active_interval, 'ALSP') . '</span>';
		}
		return '<span class="alsp-price">' . $price . '</span>';
	}
}
?>