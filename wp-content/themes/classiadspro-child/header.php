<!DOCTYPE html>
<html <?php if(function_exists('custom_vc_init')){ pacz_html_tag_schema();} ?> <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        
		<?php if ( ! function_exists( 'wp_site_icon' ) ) : ?>
		<?php $pacz_settings = $GLOBALS['pacz_settings'];?>
		<?php if ( $pacz_settings['favicon']['url'] ) { ?>
          <link rel="shortcut icon" href="<?php echo esc_url($pacz_settings['favicon']['url']); ?>"  />
        <?php } ?>
		<?php endif; ?>
		
    <?php wp_head(); ?>
    	<?php if( is_home() || is_front_page() ) : ?>
<!-- 
<link rel='stylesheet' id='rs-plugin-settings-css'  href='https://mmtender.com/wp-content/plugins/akpslider/rs6.css?ver=6.2.2' type='text/css' media='all' />
<script type='text/javascript' src='https://mmtender.com/wp-content/plugins/akpslider/rbtools.min.js?ver=6.0'></script>
<script type='text/javascript' src='https://mmtender.com/wp-content/plugins/akpslider/rs6.min.js?ver=6.2.2'></script> -->


		<script type="text/javascript">function setREVStartSize(e){			
			try {								
				var pw = document.getElementById(e.c).parentNode.offsetWidth,
					newh;
				pw = pw===0 || isNaN(pw) ? window.innerWidth : pw;
				e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
				e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
				e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
				e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
				e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
				e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
				e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);		
				if(e.layout==="fullscreen" || e.l==="fullscreen") 						
					newh = Math.max(e.mh,window.innerHeight);				
				else{					
					e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
					for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];					
					e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
					e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
					for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
										
					var nl = new Array(e.rl.length),
						ix = 0,						
						sl;					
					e.tabw = e.tabhide>=pw ? 0 : e.tabw;
					e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
					e.tabh = e.tabhide>=pw ? 0 : e.tabh;
					e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;					
					for (var i in e.rl) nl[i] = e.rl[i]<window.innerWidth ? 0 : e.rl[i];
					sl = nl[0];									
					for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}															
					var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);					

					newh =  (e.type==="carousel" && e.justify==="true" ? e.gh[ix] : (e.gh[ix] * m)) + (e.tabh + e.thumbh);
				}			
				
				if(window.rs_init_css===undefined) window.rs_init_css = document.head.appendChild(document.createElement("style"));					
				document.getElementById(e.c).height = newh;
				window.rs_init_css.innerHTML += "#"+e.c+"_wrapper { height: "+newh+"px }";				
			} catch(e){
				console.log("Failure at Presize of Slider:" + e)
			}					   
		  };
		</script>
		
		<noscript><style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style></noscript>
<?php endif; ?>
    </head>


<body <?php body_class('skin-blue'); ?>>


<?php


	


global $pacz_settings;
if(defined('GD_SINGLE_PAGE_TEMP_ID')){
	$post_id = GD_SINGLE_PAGE_TEMP_ID;	
}else{
	$post_id = global_get_post_id();	
}

 $preset_headers = $pacz_settings['preset_headers'];
if($preset_headers == 10){
	
}else if($preset_headers == 12){ 
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
	
	$login_reg_btn_location = 'header-section';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = $pacz_settings['header-contact-select'] ;
	$header_contact_details_align = $pacz_settings['header-contact-align'] ;

}else{
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
}


  $boxed_layout = $pacz_settings['body-layout'];

  $header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';

  if($header_structure == 'margin' && $preset_headers == 12) {
    $pacz_main_wrapper_class = ' add-corner-margin';  
  } else if($header_structure == 'vertical') {
	  $header_state = $pacz_settings['vertical-header-state'];
    $pacz_main_wrapper_class = ' vertical-header vertical-' . $header_state . '-state';
  }
  
   
  

	if($post_id) {
		global $pacz_settings, $pacz_accent_color;
		//$post_id = global_get_post_id();
		$preloader = get_post_meta( $post_id, '_preloader', true );
   
        if($preloader == 'true') { 
		?>
			<div class="pacz-body-loader-overlay"></div>
			
		<?php  } ?>
	<?php  } ?>
	<div class="theme-main-wrapper <?php echo esc_attr($pacz_main_wrapper_class); ?>">

		<?php if($header_structure == 'margin' && $preset_headers == 12) { ?>
			<div class="pacz-top-corner"></div>
			<div class="pacz-right-corner"></div>
			<div class="pacz-left-corner"></div>
			<div class="pacz-bottom-corner"></div>
		<?php } ?>
	<div id="pacz-boxed-layout" class="pacz-<?php echo esc_attr($boxed_layout); ?>-enabled">
	<?php
		$layout_template = $post_id ? get_post_meta($post_id, '_template', true ) : '';
		if($layout_template == 'no-header-title' || $layout_template == 'no-header-title-footer' || $layout_template == 'no-header-title-only-footer') return;
		
		if($layout_template != 'no-header' && $layout_template !='no-header-footer') :
		
		//$detect_mobile = new Mobile_Detect();
		if(wp_is_mobile()){
			get_template_part( 'includes/templates/mobile-header');
		}else{
			
		if($preset_headers == 1){
			get_template_part( 'includes/templates/desktop-headers/header-1');
		}elseif($preset_headers == 2){
			get_template_part( 'includes/templates/desktop-headers/header-2');
		}elseif($preset_headers == 3){
			get_template_part( 'includes/templates/desktop-headers/header-3');
		}elseif($preset_headers == 4){
			get_template_part( 'includes/templates/desktop-headers/header-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-4');
		}elseif($preset_headers == 5){
			get_template_part( 'includes/templates/desktop-headers/header-5-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-5');
		}elseif($preset_headers == 6){
			get_template_part( 'includes/templates/desktop-headers/header-6-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-6');
		}elseif($preset_headers == 7){
			get_template_part( 'includes/templates/desktop-headers/header-7-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-7');
		}elseif($preset_headers == 8){
			get_template_part( 'includes/templates/desktop-headers/header-8-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-8');
		}elseif($preset_headers == 9){
			get_template_part( 'includes/templates/desktop-headers/header-9');
		}elseif($preset_headers == 10){
			get_template_part( 'includes/templates/desktop-headers/header-10');
		}elseif($preset_headers == 11){
			get_template_part( 'includes/templates/desktop-headers/header-custom-toolbar');
			get_template_part( 'includes/templates/desktop-headers/header-11');
		}elseif($preset_headers == 12){
			get_template_part( 'includes/templates/desktop-headers/header-12');
		}elseif($preset_headers == 13){
			get_template_part( 'includes/templates/desktop-headers/header-11');
		}else{
			get_template_part( 'includes/templates/desktop-headers/header-1');
		}
				

				if($header_toolbar_social_location == 'header_section') {
					do_action('header_social', 'outside-grid');
				}
			
} ?>



<?php if($pacz_settings['header-location'] != 'bottom') : ?>
<div class="sticky-header-padding <?php echo esc_attr($header_padding_class);?>"></div>
<?php endif; ?>

<?php endif; ?>


<?php

if($post_id && $layout_template != 'no-title') {
  if($layout_template != 'no-footer-title' && $layout_template != 'no-sub-footer-title' && $layout_template != 'no-title-footer' && $layout_template != 'no-title-sub-footer' && $layout_template != 'no-title-footer-sub-footer') {
      do_action('page_title');
  }
}
?>

