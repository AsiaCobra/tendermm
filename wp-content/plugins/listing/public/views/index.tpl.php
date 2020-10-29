<?php 
	global $ALSP_ADIMN_SETTINGS;
	$public_control->args['scroll'] = 0 ;
	
	if($ALSP_ADIMN_SETTINGS['archive_page_style'] == 1){ 
		echo '<div class="listings listing-archive archive-style-nosidebar">';
			if(!empty($public_control->archive_top_banner)){
				echo '<div class="archive-banner">';
					echo $public_control->archive_top_banner;
				echo '</div>';
			}
			echo '<div class="map-listings">';
				if ($ALSP_ADIMN_SETTINGS['alsp_map_on_index']){
					$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, $ALSP_ADIMN_SETTINGS['alsp_start_map_zoom'], alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
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
					alsp_displayCategoriesTable();
				echo '</div>';
				if(!empty($public_control->archive_below_category_banner)){
					echo '<div class="archive-banner">';
						echo $public_control->archive_below_category_banner;
					echo '</div>';
				}
				
			} 
			
			if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_index']){
				echo '<div class="archive-locations-wrapper location-grid-wrapper clearfix">';
					alsp_displayLocationsTable();
				echo '</div>';
				if(!empty($public_control->archive_below_locations_banner)){
					echo '<div class="archive-banner">';
						echo $public_control->archive_below_locations_banner;
					echo '</div>';
				}
			}
			
			
			if ($ALSP_ADIMN_SETTINGS['alsp_listings_on_index']){
				echo '<div class="archive-listings-wrapper">';
					alsp_renderTemplate('views/listings_wrapper.tpl.php', array('public_control' => $public_control));
					echo '<div class="alsp-content" id="alsp-controller-'.$public_control->hash.'" data-controller-hash="'.$public_control->hash.'"></div>';
				echo '</div>';
				if(!empty($public_control->archive_below_listings_banner)){
					echo '<div class="archive-banner">';
						echo $public_control->archive_below_listings_banner;
					echo '</div>';
				}
			}
		echo '</div>';
	}elseif($ALSP_ADIMN_SETTINGS['archive_page_style'] == 2){ // style2 
		echo '<div class="listings listing-archive listing-index archive-style-sidebar">';
			echo '<div class="map-listings">';
				if ($ALSP_ADIMN_SETTINGS['alsp_map_on_index'] && (isset($ALSP_ADIMN_SETTINGS['archive_map_position']) && $ALSP_ADIMN_SETTINGS['archive_map_position'] == 1)){
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
					if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_index']){
						alsp_displayCategoriesTable();
					}
					if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_index']){
						alsp_displayLocationsTable();
					}
				echo '</div>';
				echo '<div class="listing-archive-content clearfix">';
					if ($ALSP_ADIMN_SETTINGS['alsp_map_on_index'] && (isset($ALSP_ADIMN_SETTINGS['archive_map_position']) && $ALSP_ADIMN_SETTINGS['archive_map_position'] == 2)){
						echo '<div class="map-listings">';
							if ($ALSP_ADIMN_SETTINGS['alsp_map_on_index']){
								$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
							}
						echo '</div>';
					}
					alsp_renderMessages();
					if ($ALSP_ADIMN_SETTINGS['alsp_listings_on_index']){
						alsp_renderTemplate('views/listings_wrapper.tpl.php', array('public_control' => $public_control));
						echo '<div class="alsp-content" id="alsp-controller-'.$public_control->hash.'" data-controller-hash="'.$public_control->hash.'"></div>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}elseif($ALSP_ADIMN_SETTINGS['archive_page_style'] == 3){ // style3
		echo '<div class="listings listing-archive alsp-content">';
			echo '<div class="map-listings">';
				if ($ALSP_ADIMN_SETTINGS['alsp_map_on_index']){
					$public_control->map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, alsp_getSelectedMapStyleName(), false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); 
				}
			echo '</div>';

			if ($ALSP_ADIMN_SETTINGS['alsp_main_search']){
				echo '<div class="main-search-bar">';
					$public_control->search_form->display();
				echo '</div>';
			}
			
			alsp_renderMessages();
			if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_index']){
				alsp_displayCategoriesTable();
			}

			if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_index']){
				alsp_displayLocationsTable();
			}
			
			if ($ALSP_ADIMN_SETTINGS['alsp_listings_on_index']){
				alsp_renderTemplate('views/listings_wrapper.tpl.php', array('public_control' => $public_control));
				echo '<div class="alsp-content" id="alsp-controller-'.$public_control->hash.'" data-controller-hash="'.$public_control->hash.'"></div>';
			}
		echo '</div>';
	}