<?php 
	global $ALSP_ADIMN_SETTINGS;
	$public_control->args['scroll'] = 0 ;
	$public_control->args['scroller_nav_style'] = 2 ;
	if(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}elseif(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}
	
	if($ALSP_ADIMN_SETTINGS['archive_page_style'] == 1){ 
		echo '<div class="listings listing-archive archive-style-nosidebar">';
			if(!empty($public_control->archive_top_banner)){
				echo '<div class="archive-banner">';
					echo $public_control->archive_top_banner;
				echo '</div>';
			}
			echo '<div class="map-listings">';
				if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']){
					$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
				}
			echo '</div>';

			if ($ALSP_ADIMN_SETTINGS['alsp_main_search']){
				echo '<div class="main-search-bar">';
						  $public_control->search_form->display();
				echo '</div>';
				if(!empty($public_control->archive_below_search_banner)){
					echo '<div class="archive-banner">';
						echo $public_control->archive_below_search_banner;
					echo '</div>';
				}
			}
			alsp_renderMessages();
			if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_index']){
				echo '<div class="archive-categories-wrapper">';
					if ($parent_category = alsp_get_term_by_path(get_query_var('category-alsp'))){
						alsp_displayCategoriesTable($parent_category->term_id);
					}
				echo '</div>';
				if(!empty($public_control->archive_below_category_banner)){
					echo '<div class="archive-banner">';
						echo $public_control->archive_below_category_banner;
					echo '</div>';
				}
			}
			echo '<div class="archive-listings-wrapper">';
				alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $public_control));
				echo '<div class="alsp-content" id="alsp-controller-'.$public_control->hash.'" data-controller-hash="'.$public_control->hash.'"></div>';
			echo '</div>';
			if(!empty($public_control->archive_below_listings_banner)){
				echo '<div class="archive-banner">';
					echo $public_control->archive_below_listings_banner;
				echo '</div>';
			}
		echo '</div>';
	}elseif($ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){ // style2 
		echo '<div class="listings listing-archive listing-category archive-style-sidebar">';
			echo '<div class="map-listings">';
				if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'] && (isset($ALSP_ADIMN_SETTINGS['archive_map_position']) && $ALSP_ADIMN_SETTINGS['archive_map_position'] == 1)){
					$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
				}
			echo '</div>';
			echo '<div class="archive-content-wrapper clearfix">';
				echo '<div class="listing-archive-sidearea clearfix">';
					if ($ALSP_ADIMN_SETTINGS['alsp_main_search']){
						echo '<div class="main-search-bar">';
							$public_control->search_form->display();
						echo '</div>';
					}
					if ($parent_category = alsp_get_term_by_path(get_query_var('category-alsp'))){
						alsp_displayCategoriesTable($parent_category->term_id);
					}
				echo '</div>';
				echo '<div class="listing-archive-content clearfix">';
					if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'] && (isset($ALSP_ADIMN_SETTINGS['archive_map_position']) && $ALSP_ADIMN_SETTINGS['archive_map_position'] == 2)){
						echo '<div class="map-listings">';
							if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']){
								$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
							}
						echo '</div>';
					}
					alsp_renderMessages();
					alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $public_control));
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}elseif($ALSP_ADIMN_SETTINGS['archive_page_style'] == 3){ // style3
		echo '<div class="listings listing-archive alsp-content">';
				echo '<div class="map-listings">';
					if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']){
						$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
					}
				echo '</div>';

				if ($ALSP_ADIMN_SETTINGS['alsp_main_search']){
					echo '<div class="main-search-bar">';
							  $public_control->search_form->display();
					echo '</div>';
				}
			
				alsp_renderMessages();
				if ($parent_category = alsp_get_term_by_path(get_query_var('category-alsp'))){
					alsp_displayCategoriesTable($parent_category->term_id);
				}
				alsp_renderTemplate('views/alsp_adverts_wrapper.tpl.php', array('public_control' => $public_control));
		echo '</div>';
	}