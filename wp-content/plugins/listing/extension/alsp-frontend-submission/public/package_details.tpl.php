<?php
	global $ALSP_ADIMN_SETTINGS;
	// active period with builtin gateway
	if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment' && $args['show_period']){
		echo '<li class="alsp-list-group-item">';
			echo $level->getActivePeriodString();
		echo '</li>';
	}
	if ($args['columns_same_height'] || (!$args['columns_same_height'])){
		// sticksy option
		if ($args['show_sticky']){
			echo '<li class="alsp-list-group-item">';
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){
					_e('Sticky', 'ALSP');
				}
				if ($level->sticky){
					echo '<i class="pacz-icon-check"></i>';
				}else{
					echo '<i class="pacz-icon-remove"></i>';
				}
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){
					_e('Sticky', 'ALSP'); 
				}
			echo '</li>';
		}
		// featured option
		if ($args['show_featured']){
			echo '<li class="alsp-list-group-item">';
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){
					_e('Featured', 'ALSP'); 
				}
				if ($level->featured){
					echo '<i class="pacz-icon-check"></i>';
				}else{
					echo '<i class="pacz-icon-remove"></i>';
				}
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){ 
					_e('Featured', 'ALSP'); 
				}
			echo '</li>';
		}
		// resurva option
		if ($args['allow_resurva_booking']){
			echo '<li class="alsp-list-group-item">';
				if ($level->allow_resurva_booking){
					echo '<i class="pacz-icon-check"></i>';
				}else{
					echo '<i class="pacz-icon-remove"></i>';
				}
				_e('Resurva Booking', 'ALSP');
			echo '</li>';
		}
		// map option
		if ($args['show_maps']){
			echo '<li class="alsp-list-group-item">';
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){
					_e('Google map', 'ALSP'); 
				}
				if ($level->map){
					echo '<i class="pacz-icon-check"></i>';
				}else{
					echo '<i class="pacz-icon-remove"></i>';
				}
				if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){
					_e('Google map', 'ALSP');
				}
			echo '</li>';
		}
		// category option
		if ($args['show_categories']){
			echo '<li class="alsp-list-group-item">';
				if (!$level->unlimited_categories){
					if ($level->categories_number == 1){
						_e('1 category', 'ALSP');
					}elseif ($level->categories_number != 0){
						printf(__('Up to <strong>%d</strong> categories', 'ALSP'), $level->categories_number);
					}else{
						_e('No categories', 'ALSP');
					}
				}else{
					_e('Unlimited categories', 'ALSP');
				}
			echo '</li>';
		}
		// location option
		if ($args['show_locations']){
			echo '<li class="alsp-list-group-item">';
				if ($level->locations_number == 1){
					_e('1 location', 'ALSP');
				}elseif ($level->locations_number != 0){
					printf(__('Up to <strong>%d</strong> locations', 'ALSP'), $level->locations_number);
				}else{
					_e('No locations', 'ALSP');
				}
			echo '</li>';
		}
		// images option
		if ($args['show_images']){
			echo '<li class="alsp-list-group-item">';
				if ($level->images_number == 1){
					_e('1 image', 'ALSP');
				}elseif ($level->images_number != 0){
					printf(__('Up to <strong>%d</strong> images', 'ALSP'), $level->images_number);
				}else{
					_e('No images', 'ALSP');
				}
			echo '</li>';
		}
		// videos option
		if ($args['show_videos']){
			echo '<li class="alsp-list-group-item">';
				if ($level->videos_number == 1){
					_e('1 video', 'ALSP');
				}elseif ($level->videos_number != 0){
					printf(__('Up to <strong>%d</strong> videos', 'ALSP'), $level->videos_number);
				}else{
					_e('No videos', 'ALSP');
				}
			echo '</li>';
		}
	}