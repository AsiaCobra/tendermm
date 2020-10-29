<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php
$search_form->getSearchFormStyles(); 
$search_form_type = $search_form->args['search_form_type'];
if($search_form_type != 1){
	echo '<form action="'.$search_url.'" class="search-form-style-header1 alsp-content alsp-search-form clearfix" data-id="'.$search_form_id.'" id="alsp-search-form-'.$search_form_id.'">';
		echo $search_form->outputHiddenFields();
		
		//if(class_exists('Mobile_Detect')){
		//	$detect_mobile = new Mobile_Detect();
			if(!wp_is_mobile()){
				do_action( 'nav_listing_btn' );
			}
		//}
		
		$location_field_width = $ALSP_ADIMN_SETTINGS['location_field_width_header'];
		//$search_form->args['category_field_width'] = $ALSP_ADIMN_SETTINGS['category_field_width_header'];
		$keyword_field_width = $ALSP_ADIMN_SETTINGS['keyword_field_width_header'];
		//$button_field_width = $ALSP_ADIMN_SETTINGS['button_field_width_header'];
	
		echo '<div class="search-wrap row clearfix pull-right">';
			 if(!wp_is_mobile()){
					echo '<div class="search-button search-element-col pull-right">';
						echo $search_form->displaySearchButton_header(true);
					echo '</div>';
			}
			
			if ($search_form->isCategoriesOrKeywords()){
				do_action('pre_search_what_form_html', $search_form_id);
				if ($search_form->isCategories()) { 
					echo '<div class="keyword-search search-element-col pull-right alsp-search-input-field-wrap" style="width:'. $keyword_field_width.'%;">';
						if($search_form->isDefaultFieldsLabel()){
							echo '<label>'.esc_html__('Search By:', 'ALSP').'</label>';
						}
						alsp_tax_dropdowns_menu_init($search_form->getCategoriesDropdownsMenuParams(__('Select category', 'ALSP'), __('Enter Keyword', 'ALSP')));
						/* if ($search_form->isKeywordsExamples()){
							echo '<p class="alsp-search-suggestions">';
								echo printf(__("Try to search: %s", "ALSP"), $search_form->getKeywordsExamples());
							echo '</p>';
						} */
					echo '</div>';
				}else{
					if ($search_form->isKeywordsAJAX()){
						$keywords_autocomplete_class = 'alsp-keywords-autocomplete';
					}else{
						$keywords_autocomplete_class = '';
					}
					echo '<div class="keyword-search search-element-col pull-left alsp-search-input-field-wrap" style="width:'. $keyword_field_width.'%;">';
						if($search_form->isDefaultFieldsLabel()){
							echo '<label>'.esc_html__('Search In:', 'ALSP').'</label>';
						}
						echo '<div class="has-feedback">';
							echo '<input name="what_search" value="'.esc_attr($search_form->getKeywordValue()).'" placeholder="'.esc_attr_e('Enter keywords', 'ALSP').'" class="'.$keywords_autocomplete_class.' form-control alsp-main-search-field" autocomplete="off" />';
							echo '<span class="alsp-dropdowns-menu-button glyphicon alsp-form-control-feedback"></span>';
						echo '</div>';
						if ($search_form->isKeywordsExamples()){
							echo '<p class="alsp-search-suggestions">';
								echo printf(__("Try to search: %s", "ALSP"), $search_form->getKeywordsExamples());
							echo '</p>';
						}
					echo '</div>';
				}
				do_action('post_search_what_form_html', $search_form_id);
			}
			if ($search_form->isLocationsOrAddress()){
				do_action('pre_search_where_form_html', $search_form_id);
				echo '<div class="search-element-col pull-right alsp-search-input-field-wrap" style="width:'.$location_field_width.'%; padding-right:10px;">';
					if($search_form->isDefaultFieldsLabel()){
						echo '<label>'.esc_html__('Search in Location', 'ALSP').'</label>';
					}
					if ($search_form->isLocations()) {
						alsp_tax_dropdowns_menu_init($search_form->getLocationsDropdownsMenuParams(__('Select Location', 'ALSP'), __('Enter Address', 'ALSP')));
					}else {
						echo '<div class="has-feedback">';
							echo '<input name="address" value="'.esc_attr($search_form->getAddressValue()).'" placeholder="'.esc_attr_e('Enter address', 'ALSP').'" class="address-autocomplete form-control alsp-main-search-field" autocomplete="off" />';
							echo '<span class="alsp-dropdowns-menu-button alsp-form-control-feedback glyphicon glyphicon-map-marker"></span>';
						echo '</div>';
					} 
				echo '</div>';
				do_action('post_search_where_form_html', $search_form_id);
			}
			if(wp_is_mobile()){
				echo '<div class="search-button search-element-col pull-right">';
					echo $search_form->displaySearchButton(true);
				echo '</div>';
			} 
		
		echo '</div>';
	
	echo '</form>';
}else{
	
	 if ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE) && $ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){
		$search_style = 2;
		$field_width = '100';
		$keyword_field_width = '100';
		$listingtype_field_width = '100';
		$location_field_width = '100';
		$radius_field_width = '100';
		$button_field_width = '100';
	}else{
		$search_style = $ALSP_ADIMN_SETTINGS['search-form-style'];
		$keyword_field_width = $search_form->args['keyword_field_width'];
		$listingtype_field_width = $search_form->args['listingtype_field_width'];
		$location_field_width = $search_form->args['location_field_width'];
		$radius_field_width = $search_form->args['radius_field_width'];
		$button_field_width = $search_form->args['button_field_width'];
	}

	echo '<form action="'.$search_url.'" class="search-form-style'.$search_style.' alsp-content alsp-search-form" data-id="'.$search_form_id.'" id="alsp-search-form-'.$search_form_id.'">';
			echo $search_form->outputHiddenFields();
		echo '<div class="search-wrap clearfix">';
			echo '<div class="search-container clearfix" style="margin-left:-'.$search_form->args['gap_in_fields'].'px; margin-right:-'.$search_form->args['gap_in_fields'].'px;">';
				if((!$directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) && $ALSP_ADIMN_SETTINGS['search-form-style'] == 2){
					echo '<h5>'.esc_html__('SEARCH LISTINGS', 'ALSP').'</h5>';
				}
				if ($search_form->isCategoriesOrKeywords()){
					do_action('pre_search_what_form_html', $search_form_id);
					if ($search_form->isCategories()) { 
						echo '<div class="keyword-search search-element-col pull-left alsp-search-input-field-wrap" style="width:'. $keyword_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px;">';
							if($search_form->isDefaultFieldsLabel()){
								echo '<label>'.esc_html__('Search By:', 'ALSP').'</label>';
							}
							alsp_tax_dropdowns_menu_init($search_form->getCategoriesDropdownsMenuParams(__('Select category', 'ALSP'), __('Enter Keyword', 'ALSP')));
							if ($search_form->isKeywordsExamples()){
								echo '<p class="alsp-search-suggestions">';
									echo printf(__("Try to search: %s", "ALSP"), $search_form->getKeywordsExamples());
								echo '</p>';
							}
						echo '</div>';
					}else{
						if ($search_form->isKeywordsAJAX()){
							$keywords_autocomplete_class = 'alsp-keywords-autocomplete';
						}else{
							$keywords_autocomplete_class = '';
						}
						echo '<div class="keyword-search search-element-col pull-left alsp-search-input-field-wrap" style="width:'. $keyword_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px;">';
							if($search_form->isDefaultFieldsLabel()){
								echo '<label>'.esc_html__('Search In:', 'ALSP').'</label>';
							}
							echo '<div class="has-feedback">';
								echo '<input name="what_search" value="'.esc_attr($search_form->getKeywordValue()).'" placeholder="'.esc_attr__('Enter keywords', 'ALSP').'" class="'.$keywords_autocomplete_class.' form-control alsp-main-search-field" autocomplete="off" />';
								echo '<span class="alsp-dropdowns-menu-button glyphicon alsp-form-control-feedback glyphicon-search"></span>';
							echo '</div>';
							if ($search_form->isKeywordsExamples()){
								echo '<p class="alsp-search-suggestions">';
									echo printf(__("Try to search: %s", "ALSP"), $search_form->getKeywordsExamples());
								echo '</p>';
							}
						echo '</div>';
					}
					do_action('post_search_what_form_html', $search_form_id);
				}
				do_action('pre_search_what_form_html', $search_form_id);
				if ($search_form->isListingType()) {
					echo '<div class="listingtype-search search-element-col pull-left alsp-search-input-field-wrap" style="width:'. $listingtype_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px;">';
						if($search_form->isDefaultFieldsLabel()){
							echo '<label>'.esc_html__('Search By Type:', 'ALSP').'</label>';
						}
						alsp_tax_dropdowns_menu_init($search_form->getListingTypeDropdownsMenuParams(__('Select Type', 'ALSP'), __('Enter Keyword', 'ALSP')));
					echo '</div>';
				}
				do_action('post_search_what_form_html', $search_form_id);
				if ($search_form->isLocationsOrAddress()){
					do_action('pre_search_where_form_html', $search_form_id);
					echo '<div class="search-element-col pull-left alsp-search-input-field-wrap" style="width:'.$location_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px;">';
						if($search_form->isDefaultFieldsLabel()){
							echo '<label>'.esc_html__('Search in Location', 'ALSP').'</label>';
						}
						if ($search_form->isLocations()) {
							alsp_tax_dropdowns_menu_init($search_form->getLocationsDropdownsMenuParams(__('Select Location', 'ALSP'), __('Enter Address', 'ALSP')));
						}else {
							echo '<div class="has-feedback">';
								echo '<input name="address" value="'.esc_attr($search_form->getAddressValue()).'" placeholder="'.esc_attr__('Enter address', 'ALSP').'" class="address-autocomplete form-control alsp-main-search-field" autocomplete="off" />';
								echo '<span class="alsp-dropdowns-menu-button alsp-form-control-feedback glyphicon glyphicon-map-marker"></span>';
							echo '</div>';
						} 
					echo '</div>';
					do_action('post_search_where_form_html', $search_form_id);
				}
				
				if ($search_form->args['on_row_search_button']){
					echo '<div class="search-element-col pull-right alsp-search-submit-button-wrap" style="width:'.$button_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px; margin-top:'.$search_form->args['search_button_margin_top'].'px;">';
						echo $search_form->displaySearchButton(true);
					echo '</div>';
				}
			
				if ($search_form->isRadius()){
					if ($ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search'] == 'miles'){
						$parameter = __('Mi', 'ALSP');
						$parameter_full = __('Mile', 'ALSP');
					}else{
						$parameter = __('Km', 'ALSP');
						$parameter_full = __('Kilometer', 'ALSP');
					}
					echo '<div class="cz-areaalider search-element-col pull-left" style="width:'.$radius_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px;">';
						if(!$ALSP_ADIMN_SETTINGS['alsp_show_radius_tooltip'] && $search_form->isDefaultFieldsLabel()){
								echo '<label>'.esc_html__('Search In', 'ALSP').'</label>';
								echo '<div class="alsp-search-radius-label" style="padding-left:5px; display:inline-block;">';
									echo '<strong id="radius_label_'.$search_form_id.'">'.$search_form->getRadiusValue().'</strong>';
									echo ' '.$parameter;
								echo '</div>';
								
							}elseif($ALSP_ADIMN_SETTINGS['alsp_show_radius_tooltip'] && $search_form->isDefaultFieldsLabel()){
								echo '<label>'.esc_html__('Search In Radius', 'ALSP'). $search_form->getRadiusValue(). $parameter.'</label>';
							}
						echo '<div class="form-group alsp-jquery-ui-slider">';
							if(!$ALSP_ADIMN_SETTINGS['alsp_show_radius_tooltip'] && !$search_form->isDefaultFieldsLabel()){
								echo '<div class="alsp-search-radius-label">';
									echo '<strong id="radius_label_'.$search_form_id.'">'.$search_form->getRadiusValue().'</strong>';
									echo ' '.$parameter_full;
								echo '</div>';
							}
							echo '<div class="pacz-radius-slider">';
								echo '<div class="alsp-radius-slider" id="radius_slider_'.$search_form_id.'" data-id="'.$search_form_id.'" title="'.$search_form->getRadiusValue().'"></div>';
								echo '<input type="hidden" name="radius" id="radius_'.$search_form_id.'" value="'.$search_form->getRadiusValue().'" />';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}

				$alsp_instance->search_fields->render_content_fields($search_form_id, $search_form->args['columns'], $search_form->args['gap_in_fields'], $search_form);

				if (!$search_form->args['on_row_search_button']){
					echo '<div class="search-element-col pull-right alsp-search-submit-button-wrap" style="width:'.$button_field_width.'%; padding:0 '.$search_form->args['gap_in_fields'].'px; margin-top:'.$search_form->args['search_button_margin_top'].'px;">';
						echo $search_form->displaySearchButton(true);
					echo '</div>';
				}
				echo '<div class="clear_float"></div>';
			echo '</div>';
			do_action('post_search_form_html', $search_form_id);
		echo '</div>';
			echo '<div class="alsp-search-section alsp-search-form-bottom clearfix">';
				if ($search_form->is_advanced_search_panel){
					$less =  esc_html__('Less filters', 'ALSP');
					$more =  esc_html__('More filters', 'ALSP');
					echo '<script>
						(function($) {
							"use strict";

							$(function() {
								alsp_advancedSearch('.$search_form_id.', "'.$more.'", "'.$less.'");
							});
						})(jQuery);
					</script>';
					echo '<div class="alsp-col-md-6 form-group pull-left">';
						echo '<a id="alsp-advanced-search-label_'.$search_form_id.'" class="alsp-advanced-search-label" href="javascript: void(0);"><span class="alsp-advanced-search-text">'. esc_html__('More filters', 'ALSP').'</span> <span class="alsp-advanced-search-toggle glyphicon glyphicon-chevron-down"></span></a>';
					echo '</div>';
				}

				do_action('buttons_search_form_html', $search_form_id);
				
			echo '</div>';
	echo '</form>';

 } // end form type
 
 
 