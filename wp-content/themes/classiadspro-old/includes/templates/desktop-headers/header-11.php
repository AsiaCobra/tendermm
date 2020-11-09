<?php
	global $pacz_settings;
	$post_id = global_get_post_id();
	$preset_headers = $pacz_settings['preset_headers'];
	$header_style = $pacz_settings['_header_style'];
	/* preset values */

	$boxed_header = $pacz_settings['boxed-header'];
	if($post_id || !$post_id) {
	global $pacz_settings;

		$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
		$header_align = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-align', true ) : $pacz_settings['header-align'];
		$header_grid = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-grid', true ) : $pacz_settings['header-grid'];
		$sticky_header = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'sticky-header', true ) : $pacz_settings['sticky-header'];
		$squeeze_sticky_header =isset($pacz_settings['squeeze-sticky-header']) ? $pacz_settings['squeeze-sticky-header'] : 1;
		
	}
	$toolbar =(isset($pacz_settings['header-toolbar']) && !empty($pacz_settings['header-toolbar'])) ? $pacz_settings['header-toolbar'] : 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	
	$header_toolbar_grid = $pacz_settings['toolbar-grid'];
	
	$pacz_logo_location = $pacz_settings['header-logo-location'];
	$pacz_logo_align = $pacz_settings['header-logo-align']; 
	
	$header_toolbar_social_location = $pacz_settings['header-social-select']; 
	$header_toolbar_social_align = $pacz_settings['header-social-align'];
	
	$listing_btn_location = $pacz_settings['listing-btn-location'];
	$listing_btn_align = $pacz_settings['listing-btn-align'];
	
	$login_reg_btn_location = $pacz_settings['header-login-reg-location'];
	$login_reg_btn_align =  $pacz_settings['log-reg-btn-align'];
	
	$header_contact_details_location = $pacz_settings['header-contact-select'] ;
	$header_contact_details_align = $pacz_settings['header-contact-align'] ;
	$header_postion = $pacz_settings['header-grid_postion'];
	if($header_postion){
		$header_grid_postion = 'postion-absolute';
	}else{
		$header_grid_postion = '';
	}
	
	
	/* Header Main Settings  */
	$trans_header_skin = '';
	if($post_id) {
		global $pacz_settings, $pacz_accent_color;
		$post_id = global_get_post_id();
		$header_search_form_onpage = get_post_meta( $post_id, '_header_search_form', true );
		$header_search_form = $pacz_settings['_header_search_form'];
		$header_style_true = get_post_meta($post_id, '_header_style', true );
		$boxed_layout = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'background_selector_orientation', true ) : $pacz_settings['body-layout'];
		if($preset_headers == 6){
			$header_style = 'transparent';
		}else{
			$header_style = get_post_meta($post_id, '_header_style', true );
		}
		$trans_header_skin = get_post_meta( $post_id, '_trans_header_skin', true );
		$trans_header_skin_class = ($trans_header_skin != '') ? ($trans_header_skin.'-header-skin') : '';

	} 
	
	$logo_height = (!empty($pacz_settings['logo']['height'])) ? $pacz_settings['logo']['height'] : 50;
		if(isset($squeeze_sticky_header)) {
			$header_sticky_height =	$logo_height/1.2 + ($pacz_settings['header-padding']/2.4 * 2);
		} else {
		}
		$header_height = $logo_height + ($pacz_settings['header-padding'] * 2);

		// Export settings to json 
		$classiadspro_json[] = array(
			'name' => 'theme_header',
			'params' => array(
				'stickyHeight' => $header_sticky_height
			)
		);
	
	if($header_style == 'transparent') {
		  $header_class = 'transparent-header ' . $trans_header_skin_class;
		} else {
		  $header_class = $sticky_header ? 'sticky-header' : '';
		  $header_padding_class = $sticky_header ? 'sticky-header' : '';
		}
		if($header_grid == 'true' && is_page() && $header_structure != 'vertical'){
			$header_grid = $header_grid ? 'pacz-grid' : '';
		}elseif($pacz_settings['header-grid'] && $header_structure != 'vertical'){
			$header_grid = $header_grid ? 'pacz-grid' : '';
		}

		$header_grid_margin ='header_grid_margin';



		$header_class .= ($boxed_header) ? ' boxed-header' : ' full-header';
		$header_class .= ($preset_headers) ? ' header-style-v'.$preset_headers : 'header-style-v12';
		$header_class .= ($header_structure != 'vertical') ? ($header_align) ? ' header-align-'.$header_align : '' : '';
		$header_class .= ($header_structure) ? ' header-structure-'.$header_structure : '';
		$header_class .= ($header_structure == 'standard') ? (' header-hover-style-'.$pacz_settings['header-hover-style']) : '';
		$header_class .= ($header_structure == 'standard') ? (' put-header-'.$pacz_settings['header-location']) : '';
	
	/* Header content */
	echo '<header id="pacz-header" class="'.esc_attr($header_class).' '.esc_attr($header_grid).' '.esc_attr($header_grid_margin).' '.$header_grid_postion.' theme-main-header pacz-header-module" data-header-style="'.esc_attr($header_style).'" data-header-structure="'.esc_attr($header_structure).'" data-transparent-skin="'.esc_attr($trans_header_skin).'" data-height="'.intval($header_height).'" data-sticky-height="'.intval($header_sticky_height).'">';
		if($boxed_header && $header_structure != 'vertical') {
			echo '<div class="pacz-header-mainnavbar"><div class="pacz-grid clearfix">';
		}	
			if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
				$menu_location = $pacz_settings['loggedin_menu'];
				do_action( 'vertical_navigation', $menu_location );
				do_action( 'main_navigation', $menu_location );
			}else{
				$pacz_menu_location = 'primary-menu';
				do_action( 'vertical_navigation', 'primary-menu' );
				do_action( 'main_navigation', 'primary-menu' );
			}
		if($pacz_settings['boxed-header'] && $header_structure != 'vertical') {
			echo '</div></div>';
		}
	echo '</header>';



