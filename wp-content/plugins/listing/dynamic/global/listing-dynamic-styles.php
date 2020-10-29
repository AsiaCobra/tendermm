<?php
global $pacz_settings;
if($pacz_settings['minify-css']){
	$output2 = '';
	$output2 .= alsp_merge_css();
	Pacz_Static_Files::addGlobalStyle("
		{$output2}
	"); 
}
		
global $pacz_settings, $ALSP_ADIMN_SETTINGS, $accent_color, $heading_font_family;
$accent_color = $pacz_settings['accent-color'];
$body_font_backup = (isset($pacz_settings['body-font']['font-backup']) && !empty($pacz_settings['body-font']['font-backup'])) ? ('font-family:' . $pacz_settings['body-font']['font-backup'] . ';') : '';
$body_font_family = (isset($pacz_settings['body-font']['font-family']) && !empty($pacz_settings['body-font']['font-family'])) ? ('font-family:' . $pacz_settings['body-font']['font-family'] . ';') : '';
$heading_font_family = (isset($pacz_settings['heading-font']['font-family']) && !empty($pacz_settings['heading-font']['font-family'])) ? ('font-family:' . $pacz_settings['heading-font']['font-family'] . ';') : '';
Pacz_Static_Files::addGlobalStyle("

.sidebar-wrapper .alsp-widget-listing-title a{color: {$pacz_settings['sidebar-title-color']} !important;}
.listing-widget-hover-overlay{
	background: {$pacz_settings['btn-hover']} !important;
}
.listing-post-style-11 figure .price .alsp-field-content{
	background-color:{$pacz_settings['accent-color']};
}
.listing-post-style-13 figure .price .alsp-field-content{
	background-color:{$pacz_settings['accent-color']};
}
");

if(is_rtl()){
Pacz_Static_Files::addGlobalStyle("
		.listing-post-style-13 figure .price .alsp-field-content:after{
			border-bottom-color:{$pacz_settings['accent-color']};
			border-right-color:{$pacz_settings['accent-color']};
			border-top-color:{$pacz_settings['accent-color']};
		}
	");
}else{
	Pacz_Static_Files::addGlobalStyle("
		.listing-post-style-13 figure .price .alsp-field-content:after{
			border-bottom-color:{$pacz_settings['accent-color']};
			border-left-color:{$pacz_settings['accent-color']};
			border-top-color:{$pacz_settings['accent-color']};
		}
");
}

Pacz_Static_Files::addGlobalStyle("
.listing-post-style-13 .cat-wrapper .listing-cat{
	color:{$pacz_settings['accent-color']} !important;
}
.location-style8.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a .location-icon{
	background-color:{$pacz_settings['accent-color']};
}
.location-style8.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a:hover{
	color:{$pacz_settings['accent-color']};
}
.location-style9.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover{
	color:{$pacz_settings['accent-color']};
	border-color:{$pacz_settings['accent-color']};
}
.location-style9.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover .location-icon{
	color:{$pacz_settings['accent-color']};
}
.cat-style-6 .alsp-categories-row:not(.owl-carousel) .alsp-categories-column-wrapper .subcategories ul li:last-child a:hover{
	
	background-color:{$pacz_settings['accent-color']};
}

.listing-main-content .alsp-field .alsp-field-caption .alsp-field-name,
.alsp-fields-group-caption,
.alsp-video-field-name{
	{$heading_font_family};
	color:{$pacz_settings['heading-color']};
	
}

.alsp-advanced-search-label{
	background: {$accent_color} ;
	color:#fff;
}
.single-listing  .alsp-field-output-block-checkbox .alsp-field-content li:before{
	color: {$accent_color} ;
}

.ui-widget-header, .ui-slider-horizontal {
    background:{$pacz_settings['btn-hover']} ;
    
}
.ui-slider .ui-slider-handle{
	border-color: {$accent_color} ;
	background:#fff;
}
");

###########################################
# SEARCH FORM
###########################################
$search_border_20 = pacz_convert_rgba($pacz_settings['main-searchbar-border-color'], 0.2);
//$main_searchbar_bg_color = (isset($pacz_settings['main-searchbar-bg-color']['rgba'])) ? $pacz_settings['main-searchbar-bg-color']['rgba'] : '';

/* padding */
$search_box_padding_top = (isset($ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-top'])) ? ('padding-top:'.$ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-top'].'px;') : '';
$search_box_padding_bottom = (isset($ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-bottom'])) ? ('padding-bottom:'.$ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-bottom'].'px;') : '';
$search_box_padding_left = (isset($ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-left'])) ? ('padding-left:'.$ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-left'].'px;') : '';
$search_box_padding_right = (isset($ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-right'])) ? ('padding-right:'.$ALSP_ADIMN_SETTINGS['search_form_box_padding']['margin-right'].'px;') : '';


$input_field_height = (isset($ALSP_ADIMN_SETTINGS['search_form_field_height'])) ? ('height:'.$ALSP_ADIMN_SETTINGS['search_form_field_height'].'px !important;') : '';
$select_selector_line_height = (isset($ALSP_ADIMN_SETTINGS['search_form_field_height'])) ? ('line-height:'.$ALSP_ADIMN_SETTINGS['search_form_field_height'].'px;') : '';
$input_field_height_min = (isset($ALSP_ADIMN_SETTINGS['search_form_field_height'])) ? ('min-height:'.$ALSP_ADIMN_SETTINGS['search_form_field_height'].'px;') : '';

$input_field_bg = (isset($ALSP_ADIMN_SETTINGS['search_box_input_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_box_input_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_box_input_bg']['rgba'].';') : '';
$input_field_border_color = (isset($ALSP_ADIMN_SETTINGS['search_box_input_border']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_box_input_border']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_box_input_border']['rgba'].';') : '';
$input_field_placeholder_color = (isset($ALSP_ADIMN_SETTINGS['search_box_input_placeholer_color'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['search_box_input_placeholer_color'].';') : '';
$input_field_text_color = (isset($ALSP_ADIMN_SETTINGS['search_box_input_text_color'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['search_box_input_text_color'].';') : '';
$input_field_label_color = (isset($ALSP_ADIMN_SETTINGS['search_box_input_label_color'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['search_box_input_label_color'].';') : '';

$input_field_border_width = (isset($ALSP_ADIMN_SETTINGS['search_form_field_border_width'])) ? ('border-width:'.$ALSP_ADIMN_SETTINGS['search_form_field_border_width'].'px;') : '';
$input_field_border_radius = (isset($ALSP_ADIMN_SETTINGS['search_form_field_radius'])) ? ('border-radius:'.$ALSP_ADIMN_SETTINGS['search_form_field_radius'].'px;') : '';

/* typography */

$search_field_font_family = (isset($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['search_form_field_text']['font-family'] . ' !important;') : '';
$search_field_font_size = (isset($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['search_form_field_text']['font-size'] . ' !important;') : '';
$search_field_font_weight = (isset($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_text']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['search_form_field_text']['font-weight'] . ' !important;') : '';
$search_field_font_line_height = (isset($ALSP_ADIMN_SETTINGS['search_form_field_text']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_text']['line-height'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['search_form_field_text']['line-height'] . ' !important;') : '';
$search_field_font_transform = (isset($ALSP_ADIMN_SETTINGS['search_field_text_transform']) && !empty($ALSP_ADIMN_SETTINGS['search_field_text_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['search_field_text_transform'] . ' !important;') : '';

$search_field_label_font_family = (isset($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['search_form_field_label']['font-family'] . ' !important;') : '';
$search_field_label_font_size = (isset($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['search_form_field_label']['font-size'] . ' !important;') : '';
$search_field_label_font_weight = (isset($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_label']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['search_form_field_label']['font-weight'] . ' !important;') : '';
$search_field_label_font_line_height = (isset($ALSP_ADIMN_SETTINGS['search_form_field_label']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['search_form_field_label']['line-height'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['search_form_field_label']['line-height'] . ' !important;') : '';
$search_field_label_font_transform = (isset($ALSP_ADIMN_SETTINGS['search_field_label_transform']) && !empty($ALSP_ADIMN_SETTINGS['search_field_label_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['search_field_label_transform'] . ' !important;') : '';

$search_button_family = (isset($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['search_form_button_text']['font-family'] . ' !important;') : '';
$search_button_font_size = (isset($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['search_form_button_text']['font-size'] . ' !important;') : '';
$search_button_font_weight = (isset($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['search_form_button_text']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['search_form_button_text']['font-weight'] . ' !important;') : '';
$search_button_font_line_height = (isset($ALSP_ADIMN_SETTINGS['search_form_button_text']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['search_form_button_text']['line-height'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['search_form_button_text']['line-height'] . ' !important;') : '';
$search_button_font_transform = (isset($ALSP_ADIMN_SETTINGS['search_button_text_transform']) && !empty($ALSP_ADIMN_SETTINGS['search_button_text_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['search_button_text_transform'] . ' !important;') : '';

/* border radius */

$search_button_border_radius = (isset($ALSP_ADIMN_SETTINGS['search_form_button_border_radius'])) ? ('border-radius:'.$ALSP_ADIMN_SETTINGS['search_form_button_border_radius'].'px;') : '';

/* background */

//$main_searchbar_bg_color = (isset($ALSP_ADIMN_SETTINGS['search_box_background']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_box_background']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['search_box_background']['rgba'].' !important;') : '';
$main_searchbar_bg = (isset($ALSP_ADIMN_SETTINGS['main_searchbar_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['main_searchbar_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['main_searchbar_bg']['rgba'].' !important;') : '';
$search_button_bg = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_color_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_form_btn_color_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_form_btn_color_bg']['rgba'].';') : '';
$search_button_bg_hover = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_color_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_form_btn_color_bg_hover']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_form_btn_color_bg_hover']['rgba'].';') : '';
$search_button_border_color = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_form_btn_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_form_btn_border_color']['rgba'].';') : '';
$search_button_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_border_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_form_btn_border_color_hover']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_form_btn_border_color_hover']['rgba'].';') : '';


/* border width */

$search_button_border_width = (isset($ALSP_ADIMN_SETTINGS['search_form_button_border_width'])) ? ('border-width:'.$ALSP_ADIMN_SETTINGS['search_form_button_border_width'].'px;') : '';

/* text color*/

$search_button_text_color = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_color']['regular'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['search_form_btn_color']['regular']. ';') : '';
$search_button_text_color_hover = (isset($ALSP_ADIMN_SETTINGS['search_form_btn_color']['hover'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['search_form_btn_color']['hover']. ';') : '';
$search_button_icon = (isset($ALSP_ADIMN_SETTINGS['search_form_button_icon'])) ? $ALSP_ADIMN_SETTINGS['search_form_button_icon'] : '';

/* Radius Slider */

$search_radius_slider_border_radius_top_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-top'].';') : '';
$search_radius_slider_border_radius_top_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-bottom'].';') : '';
$search_radius_slider_border_radius_bottom_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-left'].';') : '';
$search_radius_slider_border_radius_bottom_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_radius']['padding-right'].';') : '';


$search_radius_slider_border_width = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_border_width'])) ? ('border-width:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_border_width']. 'px;') : '';
$search_radius_slider_height = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_height'])) ? $ALSP_ADIMN_SETTINGS['search_radius_slider_height'] : '10';


$search_radius_slider_bg = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_bg']['rgba'].' !important;') : '';
$search_radius_slider_border_color = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_border_color']['rgba'].' !important;') : '';

$search_radius_slider_range_border_radius_top_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-top'].';') : '';
$search_radius_slider_range_border_radius_top_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-bottom'].';') : '';
$search_radius_slider_range_border_radius_bottom_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-left'].';') : '';
$search_radius_slider_range_border_radius_bottom_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_radius']['padding-right'].';') : '';

$search_radius_slider_range_height = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_height'])) ? ('height:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_height'].'px;') : '';
$search_radius_slider_range_top = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_top'])) ? ('top:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_top']. 'px;') : '';
$search_radius_slider_range_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_range_top'])) ? ('left:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_range_top']. 'px;') : '';
$search_radius_slider_range_width = (round($search_radius_slider_height));
$search_radius_slider_rage_bg = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_rage_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_rage_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_rage_bg']['rgba'].' !important;') : '';

$search_radius_slider_handle_border_radius_top_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-top'].';') : '';
$search_radius_slider_handle_border_radius_top_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-bottom'].';') : '';
$search_radius_slider_handle_border_radius_bottom_right = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-left'].';') : '';
$search_radius_slider_handle_border_radius_bottom_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_radius']['padding-right'].';') : '';



$search_radius_slider_handle_top = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_top'])) ? ('top:-'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_top'].'px;') : '';
$search_radius_slider_handle_width = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'])) ? ('width:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'].'px;') : '';
$search_radius_slider_handle_height = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'])) ? ('height:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'].'px;') : '';
$search_radius_slider_handle_border_width = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_border_width'])) ? ('border-width:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_border_width'].'px;') : '';

$search_radius_slider_barwidth = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'])) ? ('width: calc(100% - '.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'].'px); width: -webkit-calc(100% - '.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'].'px); width: -moz-calc(100% - '.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'].'px);') : '';
if(is_rtl()){
	$search_radius_slider_barmargin = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'])) ? ('margin-right:'.round($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'] / 2).'px;') : '';
}else{
	$search_radius_slider_barmargin = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'])) ? ('margin-left:'.round($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_width'] / 2).'px;') : '';
}
$search_radius_slider_handle_bg = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_bg']['rgba'].';') : '';
$search_radius_slider_handle_border_color = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_handle_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_handle_border_color']['rgba'].';') : '';

$search_radius_slider_tooltip_top = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_top'])) ? ('top:-'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_top'].'px;') : '';
$search_radius_slider_tooltip_left = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_left'])) ? ('left:-'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_left'].'px;') : '';
$search_radius_slider_tooltip_width = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_width'])) ? ('width:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_width'].'px;') : '';

$search_radius_slider_tooltip_bg = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['color'])) ? ('background-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['rgba'].';') : '';
$search_radius_slider_tooltip_border_color = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_border_color']['rgba'].';') : '';
$search_radius_slider_tooltip_text_color = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_text_color'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_text_color']. ';') : '';
$search_selectbox_selector_icon_bg = (isset($ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_bg'])) ? ('background:' .$ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_bg']. ';') : '';
$search_selectbox_selector_icon_color = (isset($ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color']. ';') : '';
$search_selectbox_selector_icon_border_color = (isset($ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color']. ' transparent transparent transparent;') : '';
$search_selectbox_selector_icon_border_color_open = (isset($ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color'])) ? ('border-color: transparent transparent ' .$ALSP_ADIMN_SETTINGS['search_selectbox_selector_icon_color']. ' transparent;') : '';
$search_radius_slider_tooltip_border_top_color = (isset($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['color'])) ? ('border-top-color:'.$ALSP_ADIMN_SETTINGS['search_radius_slider_tooltip_bg']['rgba'].';') : '';
$featured_text = esc_html__('Featured', 'ALSP');

Pacz_Static_Files::addGlobalStyle("
.search-wrap{
	{$search_box_padding_top}
	{$search_box_padding_bottom}
	{$search_box_padding_left}
	{$search_box_padding_right}
}
.alsp-search-form,
.search-form-style1 .advanced-search-button{
	{$main_searchbar_bg}
	
}
.search-form-style1 .advanced-search-button a{color:{$pacz_settings['body-txt-color']} !important;}

.search-wrap .btn.btn-primary{
	{$search_button_bg}
	{$search_button_border_color}
	{$search_button_border_width}
	{$search_button_border_radius}
	{$search_button_text_color}
	{$search_button_font_transform}
	{$search_button_font_size};
	{$search_button_font_weight}
	{$search_button_font_line_height}
	{$search_button_family};
	border-style: solid;
}
.search-wrap .btn.btn-primary:hover{
	{$search_button_bg_hover}
	{$search_button_border_color_hover}
	{$search_button_text_color_hover}
}

.search-wrap .alsp-search-form-button .btn.btn-primary,
.search-wrap .bootstrap-select > .dropdown-toggle,
.search-wrap .form-control,
.search-wrap .alsp-dropdowns-menu-locations-autocomplete input,
.search-wrap .select2-container--default .select2-selection--single .select2-selection__arrow,
.search-wrap .select2-selection--single,
.search-wrap .select2-container--default .select2-selection--single .select2-selection__rendered {
    {$input_field_height}
	{$input_field_height_min}
}
.search-wrap .form-control,
.search-wrap .select2-selection--single,
.search-wrap .select2-container--default .select2-selection--single{
	{$input_field_bg}
	{$input_field_border_color}
	{$input_field_border_width}
	{$input_field_border_radius}
	{$input_field_text_color}
	{$search_field_font_size}
	{$search_field_font_weight}
	{$search_field_font_line_height}
	{$search_field_font_family}
	{$search_field_font_transform}
	border-style: solid;
}

.search-wrap .form-control:focus{
	{$input_field_border_color}
	{$input_field_border_width}
	{$input_field_border_radius}
	{$input_field_text_color}
	{$search_field_font_size}
	{$search_field_font_weight}
	{$search_field_font_line_height}
	{$search_field_font_family}
	{$search_field_font_transform}
	border-style: solid;
}
.alsp-search-radius-label{
	{$input_field_label_color}
	{$search_field_label_font_size}
	{$search_field_label_font_weight}
	{$search_field_label_font_line_height}
	{$search_field_label_font_family}
	{$search_button_font_transform}
}
.search-wrap .form-control::-moz-placeholder,
.search-wrap .form-control::placeholder{
	{$input_field_placeholder_color}
}
.search-wrap .alsp-form-control-feedback,
.search-wrap .select2-container--default .select2-selection--single .select2-selection__arrow {
    {$input_field_height}
	{$input_field_height_min}
	{$select_selector_line_height}
	{$search_selectbox_selector_icon_bg}
	{$search_selectbox_selector_icon_color}

}
.search-wrap .select2-container--default .select2-selection--single .select2-selection__arrow {
	width:0px;
	text-align: center;
	right: 10%;
	top: 0;
}
.search-wrap .alsp-form-control-feedback{
	width:36px;
	font-size:10px;
}
.search-wrap .select2-container--default .select2-selection--single .select2-selection__arrow b{
	margin-left:-3px;
	{$search_selectbox_selector_icon_border_color}
}
.search-wrap .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
	{$search_selectbox_selector_icon_border_color_open}
}
.pacz-radius-slider .tooltip.top{
	opacity:1 !important;
	{$search_radius_slider_tooltip_top}
	{$search_radius_slider_tooltip_left}
}
.pacz-radius-slider .tooltip.top .tooltip-arrow{
	{$search_radius_slider_tooltip_border_top_color}
}
.pacz-radius-slider .tooltip.top .tooltip-inner{
	{$search_radius_slider_tooltip_bg}
	{$search_radius_slider_tooltip_text_color}
	{$search_radius_slider_tooltip_width}
	{$search_radius_slider_tooltip_border_color}
}
.ui-slider.ui-slider-horizontal{
	{$search_radius_slider_bg}
	{$search_radius_slider_border_color}
	{$search_radius_slider_border_radius_top_left}
	{$search_radius_slider_border_radius_top_right}
	{$search_radius_slider_border_radius_bottom_right}
	{$search_radius_slider_border_radius_bottom_left}
	{$search_radius_slider_border_width}
	{$search_radius_slider_barwidth}
	{$search_radius_slider_barmargin}
	height:{$search_radius_slider_height}px !important;
}
.ui-slider.ui-slider-horizontal .ui-slider-range{
	{$search_radius_slider_rage_bg}
	{$search_radius_slider_range_height}
	{$search_radius_slider_range_border_radius_top_left}
	{$search_radius_slider_range_border_radius_top_right}
	{$search_radius_slider_range_border_radius_bottom_right}
	{$search_radius_slider_range_border_radius_bottom_left}
	{$search_radius_slider_range_top};
	{$search_radius_slider_range_left}
}
.alsp-content .ui-slider .ui-slider-handle.ui-corner-all {

    {$search_radius_slider_handle_height}
    {$search_radius_slider_handle_top}
    {$search_radius_slider_handle_width}
    {$search_radius_slider_handle_border_width}
	{$search_radius_slider_handle_bg}
	{$search_radius_slider_handle_border_color}
	{$search_radius_slider_handle_border_radius_top_left}
	{$search_radius_slider_handle_border_radius_top_right}
	{$search_radius_slider_handle_border_radius_bottom_right}
	{$search_radius_slider_handle_border_radius_bottom_left}

}
");

###########################################
# Categories
###########################################

$cat_font_family = (isset($ALSP_ADIMN_SETTINGS['category_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['category_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['category_typo']['font-family'] . ';') : '';
$cat_font_size = (isset($ALSP_ADIMN_SETTINGS['category_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['category_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['category_typo']['font-size'] . 'px;') : '';
$cat_font_weight = (isset($ALSP_ADIMN_SETTINGS['category_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['category_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['category_typo']['font-weight'] . ';') : '';
$cat_font_line_height = (isset($ALSP_ADIMN_SETTINGS['category_typo']['line-heigh']) && !empty($ALSP_ADIMN_SETTINGS['category_typo']['line-heigh'])) ? ('line-heigh:' . $ALSP_ADIMN_SETTINGS['category_typo']['line-heigh'] . 'px;') : '';
$cat_font_transform = (isset($ALSP_ADIMN_SETTINGS['category_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['category_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['category_typo_transform'] . ';') : '';

$child_cat_font_family = (isset($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['childcategory_typo']['font-family'] . ';') : '';
$child_cat_font_size = (isset($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['childcategory_typo']['font-size'] . 'px;') : '';
$child_cat_font_weight = (isset($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['childcategory_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['childcategory_typo']['font-weight'] . ';') : '';
$child_cat_font_line_height = (isset($ALSP_ADIMN_SETTINGS['childcategory_typo']['line-heigh']) && !empty($ALSP_ADIMN_SETTINGS['childcategory_typo']['line-heigh'])) ? ('line-heigh:' . $ALSP_ADIMN_SETTINGS['childcategory_typo']['line-heigh'] . 'px;') : '';
$child_cat_font_transform = (isset($ALSP_ADIMN_SETTINGS['category_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['category_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['category_typo_transform'] . ';') : '';

$parent_cat_title_color = (isset($ALSP_ADIMN_SETTINGS['parent_cat_title_color']['regular'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['parent_cat_title_color']['regular']. ';') : '';
$parent_cat_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['parent_cat_title_color']['hover'])) ?('color:'.$ALSP_ADIMN_SETTINGS['parent_cat_title_color']['hover']. ';') : '';
$parent_cat_title_bg = (isset($ALSP_ADIMN_SETTINGS['parent_cat_title_color']['bg'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['parent_cat_title_color']['bg']. ';') : '';
$parent_cat_title_bg_hover = (isset($ALSP_ADIMN_SETTINGS['parent_cat_title_color']['bg-hover'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['parent_cat_title_color']['bg-hover']. ';') : '';
$subcategory_title_color = (isset($ALSP_ADIMN_SETTINGS['subcategory_title_color']['regular'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['subcategory_title_color']['regular']. ';') : '';
$subcategory_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['subcategory_title_color']['hover'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['subcategory_title_color']['hover']. ';') : '';

$cat_bg = (isset($ALSP_ADIMN_SETTINGS['cat_bg_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['cat_bg_color']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['cat_bg_color']['rgba'].';') : '';
$cat_bg_hover = (isset($ALSP_ADIMN_SETTINGS['cat_bg_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['cat_bg_color_hover']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['cat_bg_color_hover']['rgba'].';') : '';

$cat_border_color = (isset($ALSP_ADIMN_SETTINGS['cat_border_color']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['cat_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['cat_border_color']['rgba']. ';') : '';
$cat_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['cat_border_color_hover']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['cat_border_color_hover']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['cat_border_color_hover']['rgba']. ';') : '';

$cat_box_shadow = (isset($ALSP_ADIMN_SETTINGS['cat_border_color']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['cat_border_color']['color'])) ? ('box-shadow: 0 2px 0 0'.$ALSP_ADIMN_SETTINGS['cat_border_color']['rgba']. ';') : '';
$cat_box_shadow_hover = (isset($ALSP_ADIMN_SETTINGS['cat_border_color_hover']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['cat_border_color_hover']['color'])) ? ('box-shadow: 0 2px 0 0'.$ALSP_ADIMN_SETTINGS['cat_border_color_hover']['rgba']. ';') : '';


$cat_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-top'].';') : '';
$cat_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-bottom'].';') : '';
$cat_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-left'].';') : '';
$cat_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['cat_border_radius']['padding-right'].';') : '';



Pacz_Static_Files::addGlobalStyle("

.theme-page-wrapper .cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
.cat-style-3 .alsp-categories-column-wrapper,
.cat-style-4 .alsp-categories-column-wrapper,
.cat-style-5 .alsp-categories-column-wrapper,
.cat-style-6 .alsp-categories-column-wrapper,
.cat-style-7 .alsp-categories-column-wrapper,
.cat-style-8 .alsp-categories-column-wrapper,
.cat-style-9 .alsp-categories-column-wrapper{
	{$cat_bg}
	{$cat_border_radius_top}
	{$cat_border_radius_right}
	{$cat_border_radius_bottom}
	{$cat_border_radius_left}
	
}
.theme-page-wrapper .cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
.theme-page-wrapper .cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
.cat-style-3 .alsp-categories-column-wrapper:hover,
.cat-style-4 .alsp-categories-column-wrapper:hover,
.cat-style-5 .alsp-categories-column-wrapper:hover,
.cat-style-6 .alsp-categories-column-wrapper:hover,
.cat-style-7 .alsp-categories-column-wrapper:hover,
.cat-style-8 .alsp-categories-column-wrapper:hover,
.cat-style-9 .alsp-categories-column-wrapper:hover{
	{$cat_bg_hover}
}
.cat-style-6 .alsp-categories-column-wrapper{
	{$cat_box_shadow}
	{$cat_border_color}
}
.cat-style-6 .alsp-categories-column-wrapper:hover{
	{$cat_box_shadow_hover}
	{$cat_border_color_hover}
}
.cat-style-6 .alsp-categories-column-wrapper .alsp-categories-root{
	{$parent_cat_title_bg}
}
.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root{
	{$parent_cat_title_bg_hover}
}
.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper .subcategories ul li a.view-all-btn{
	{$cat_border_color}
}

.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper:hover .subcategories ul li a.view-all-btn{
	{$cat_border_color_hover}
}

.cat-style-7 .alsp-categories-column-wrapper{
	{$cat_border_color}
}

.cat-style-7 .alsp-categories-column-wrapper:hover{
	border-color: {$cat_border_color_hover};
}

.alsp-categories-root a{
	{$parent_cat_title_color}
	{$cat_font_size}
	{$cat_font_weight}
	{$cat_font_line_height}
	{$cat_font_family};
	{$cat_font_transform}
}
.alsp-categories-root a:hover,
.cat-style-3 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
.cat-style-4 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
.cat-style-5 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
.cat-style-7 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
.cat-style-9 .alsp-categories-column-wrapper:hover .alsp-categories-root a{
	{$parent_cat_title_color_hover}
}
.subcategories ul li a,
.subcategories ul li a span{
	{$subcategory_title_color}
	{$child_cat_font_size}
	{$child_cat_font_weight};
	{$child_cat_font_line_height}
	{$child_cat_font_family}
	{$child_cat_font_transform}
}
.subcategories ul li a:hover,
.subcategories ul li a:hover span{
	{$subcategory_title_color_hover}
}

");

###########################################
# Locations
###########################################

$loc_font_family = (isset($ALSP_ADIMN_SETTINGS['loccation_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['loccation_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['loccation_typo']['font-family'] . ';') : '';
$loc_font_size = 'font-size:' . $ALSP_ADIMN_SETTINGS['loccation_typo']['font-size'] . ';';
$loc_font_weight = 'font-weight:' . $ALSP_ADIMN_SETTINGS['loccation_typo']['font-weight'] . ';';
$loc_font_line_height = 'line-height:' . $ALSP_ADIMN_SETTINGS['loccation_typo']['line-height'] . ';';
$loc_font_transform = (isset($ALSP_ADIMN_SETTINGS['loccation_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['loccation_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['loccation_typo_transform'] . ';') : ('text-transform: uppercase;');

$child_loc_font_family = (isset($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['childlocation_typo']['font-family'] . ';') : '';
$child_loc_font_size = (isset($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['childlocation_typo']['font-size'] . ';') : '';
$child_loc_font_weight = (isset($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['childlocation_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['childlocation_typo']['font-weight'] . ';') : '';
$child_loc_font_line_height = (isset($ALSP_ADIMN_SETTINGS['childlocation_typo']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['childlocation_typo']['line-heigh'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['childlocation_typo']['line-height'] . ';') : '';
$child_loc_font_transform = (isset($ALSP_ADIMN_SETTINGS['childlocation_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['childlocation_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['childlocation_typo_transform'] . ';') : ('text-transform: uppercase;');

$parent_loc_title_color = (isset($ALSP_ADIMN_SETTINGS['parent_loc_title_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_title_color']['regular'] : '';
$parent_loc_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['parent_loc_title_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_title_color']['hover'] : '';
$parent_loc_title_bg = (isset($ALSP_ADIMN_SETTINGS['parent_loc_title_color']['bg'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_title_color']['bg'] : '';
$parent_loc_title_bg_hover = (isset($ALSP_ADIMN_SETTINGS['parent_loc_title_color']['bg-hover'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_title_color']['bg-hover'] : '';
$sublocation_title_color = (isset($ALSP_ADIMN_SETTINGS['subloc_title_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['subloc_title_color']['regular'] : '';
$sublocation_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['subloc_title_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['subloc_title_color']['hover'] : '';

$loc_bg = (isset($ALSP_ADIMN_SETTINGS['loc_bg_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['loc_bg_color']['color'])) ? $ALSP_ADIMN_SETTINGS['loc_bg_color']['rgba'] : '';
$loc_bg_hover = (isset($ALSP_ADIMN_SETTINGS['loc_bg_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['loc_bg_color_hover']['color'])) ? $ALSP_ADIMN_SETTINGS['loc_bg_color_hover']['rgba'] : '';

$parent_loc_icon_bg = (isset($ALSP_ADIMN_SETTINGS['parent_loc_icon_bg']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['parent_loc_icon_bg']['color'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_icon_bg']['rgba'] : '';
$parent_loc_icon_bg_hover = (isset($ALSP_ADIMN_SETTINGS['parent_loc_icon_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['parent_loc_icon_bg_hover']['color'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_icon_bg_hover']['rgba'] : '';
$parent_loc_icon_border_radius = (isset($ALSP_ADIMN_SETTINGS['parent_loc_icon_border_radius'])) ? $ALSP_ADIMN_SETTINGS['parent_loc_icon_border_radius'] : '';

$loc_border_color = (isset($ALSP_ADIMN_SETTINGS['loc_border_color']['rgba'])) ? $ALSP_ADIMN_SETTINGS['loc_border_color']['rgba'] : '';
$loc_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['loc_border_color_hover']['rgba'])) ? $ALSP_ADIMN_SETTINGS['loc_border_color_hover']['rgba'] : '';

$loc_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-top'])) ? $ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-top'] : '';
$loc_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-bottom'])) ? $ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-bottom'] : '';
$loc_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-left'])) ? $ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-left'] : '';
$loc_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-right'])) ? $ALSP_ADIMN_SETTINGS['loc_border_radius']['padding-right'] : '';


Pacz_Static_Files::addGlobalStyle("
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a {
    {$loc_font_family}
	{$loc_font_size}
	{$loc_font_weight}
	{$loc_font_line_height}
	{$loc_font_transform}
	color: {$parent_loc_title_color};
}

.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper:hover .alsp-locations-root a,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper:hover .alsp-locations-root a {
	color: {$parent_loc_title_color_hover};
}
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root{
	background-color:{$loc_bg};
	border-top-left-radius:{$loc_border_radius_top};
	border-top-right-radius:{$loc_border_radius_right};
	border-bottom-right-radius:{$loc_border_radius_bottom};
	border-bottom-left-radius:{$loc_border_radius_left};
}
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper:hover  .alsp-locations-root{
	background-color:{$loc_bg_hover};
}

.alsp-locations-widget .alsp-locations-root a .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a::before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a::before{
	background-color:{$parent_loc_icon_bg} !important;
	border-radius:{$parent_loc_icon_border_radius}px;
}
.alsp-locations-widget .alsp-locations-root:hover a .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper:hover .alsp-locations-root a::before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper:hover .alsp-locations-root a::before{
	background-color:{$parent_loc_icon_bg_hover} !important;
}
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root .sublocations ul li a{
	{$child_loc_font_family}
	{$child_loc_font_size}
	{$child_loc_font_weight}
	{$child_loc_font_line_height}
	{$child_loc_font_transform}
	color: {$sublocation_title_color};
	line-heigh:{$child_loc_font_transform};
}
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root .sublocations ul li a:hover{
	color: {$sublocation_title_color_hover};
}

");


###########################################
# Pricing Plan
###########################################

/* font family */

$pp_title_font_family = (isset($ALSP_ADIMN_SETTINGS['pp_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['pp_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['pp_typo']['font-family'] . ' !important;') : '';
$pp_title_font_size = (isset($ALSP_ADIMN_SETTINGS['pp_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['pp_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['pp_typo']['font-size'] . ' !important;') : '';
$pp_title_font_weight = (isset($ALSP_ADIMN_SETTINGS['pp_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['pp_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['pp_typo']['font-weight'] . ' !important;') : '';
$pp_title_font_line_height = (isset($ALSP_ADIMN_SETTINGS['pp_typo']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['pp_typo']['line-height'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['pp_typo']['line-height'] . ' !important;') : '';
$pp_title_font_transform = (isset($ALSP_ADIMN_SETTINGS['pp_title_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['pp_title_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['pp_title_typo_transform'] . ' !important;') : ('text-transform: uppercase;');

$pp_price_font_family = (isset($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['pp_price_typo']['font-family'] . ';') : '';
$pp_price_font_size = (isset($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['pp_price_typo']['font-size'] . ';') : '';
$pp_price_font_weight = (isset($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['pp_price_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['pp_price_typo']['font-weight'] . ';') : '';
$pp_price_font_line_height = (isset($ALSP_ADIMN_SETTINGS['pp_price_typo']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['pp_price_typo']['line-heigh'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['pp_price_typo']['line-height'] . ';') : '';
$pp_price_font_transform = (isset($ALSP_ADIMN_SETTINGS['pp_price_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['pp_price_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['pp_price_typo_transform'] . ';') : ('text-transform: uppercase;');

$pp_list_font_family = (isset($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['pp_list_typo']['font-family'] . ';') : '';
$pp_list_font_size = (isset($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['pp_list_typo']['font-size'] . ';') : '';
$pp_list_font_weight = (isset($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['pp_list_typo']['font-weight'] . ';') : '';
$pp_list_font_line_height = (isset($ALSP_ADIMN_SETTINGS['pp_list_typo']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_typo']['line-heigh'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['pp_list_typo']['line-height'] . ';') : '';
$pp_list_font_transform = (isset($ALSP_ADIMN_SETTINGS['pp_list_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['pp_list_typo_transform'] . ' !important;') : '';

/* text color */

$pp_title_color = (isset($ALSP_ADIMN_SETTINGS['pp_title_color']['regular'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_title_color']['regular']. ' !important;') : '';
$pp_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_title_color']['hover'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_title_color']['hover']. ' !important;') : '';

$pp_list_color = (isset($ALSP_ADIMN_SETTINGS['pp_list_color']['regular'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_list_color']['regular']. ';') : '';
$pp_list_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_list_color']['hover'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_list_color']['hover']. ';') : '';

$pp_price_color = (isset($ALSP_ADIMN_SETTINGS['pp_price_color']['regular'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_price_color']['regular']. ' !important;') : '';
$pp_price_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_price_color']['hover'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_price_color']['hover']. '!important;') : '';

$pp_button_color = (isset($ALSP_ADIMN_SETTINGS['pp_button_color']['regular'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_button_color']['regular']. ' !important;') : '';
$pp_button_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_button_color']['hover'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_button_color']['hover']. ' !important;') : '';

$pp_icon_check_color = (isset($ALSP_ADIMN_SETTINGS['pp_check_icon_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_check_icon_color']['color'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_check_icon_color']['rgba']. ';') : '';
$pp_icon_remove_color = (isset($ALSP_ADIMN_SETTINGS['pp_remove_icon_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_remove_icon_color']['color'])) ? ('color:' .$ALSP_ADIMN_SETTINGS['pp_remove_icon_color']['rgba']. ';') : '';

/* background color */

$pp_wrapper_bg = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_bg']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_bg']['rgba']. ';') : '';
$pp_wrapper_bg_hover = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_bg_hover']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_bg_hover']['rgba']. ';') : '';

$pp_list_bg = (isset($ALSP_ADIMN_SETTINGS['pp_list_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_bg']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_list_bg']['rgba']. ' !important;') : '';
$pp_list_bg_hover = (isset($ALSP_ADIMN_SETTINGS['pp_list_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_bg_hover']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_list_bg_hover']['rgba']. ' !important;') : '';

$pp_button_bg = (isset($ALSP_ADIMN_SETTINGS['pp_button_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_bg']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_button_bg']['rgba']. ' !important;') : '';
$pp_button_bg_hover = (isset($ALSP_ADIMN_SETTINGS['pp_button_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_bg_hover']['color'])) ? ('background-color:' .$ALSP_ADIMN_SETTINGS['pp_button_bg_hover']['rgba']. ' !important;') : '';

/* border color */

$pp_wrapper_border_color = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_border_color']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_border_color']['rgba']. ';') : '';
$pp_wrapper_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_border_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_border_color_hover']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_border_color_hover']['rgba']. ';') : '';

$pp_list_border_color = (isset($ALSP_ADIMN_SETTINGS['pp_list_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_border_color']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_list_border_color']['rgba']. ' !important;') : '';
$pp_list_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_list_border_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_list_border_color_hover']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_list_border_color_hover']['rgba']. ' !important;') : '';

$pp_button_border_color = (isset($ALSP_ADIMN_SETTINGS['pp_button_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_border_color']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_button_border_color']['rgba']. ' !important;') : '';
$pp_button_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['pp_button_border_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_border_color_hover']['color'])) ? ('border-color:' .$ALSP_ADIMN_SETTINGS['pp_button_border_color_hover']['rgba']. ';') : '';

/* border radius */

$pp_wrapper_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-top'].';') : '';
$pp_wrapper_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-bottom'].';') : '';
$pp_wrapper_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-left'].';') : '';
$pp_wrapper_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['pp_wrapper_radius']['padding-right'].';') : '';

$pp_button_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-top'].' !important;') : '';
$pp_button_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-bottom'].' !important;') : '';
$pp_button_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-left'].' !important;') : '';
$pp_button_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['pp_button_radius']['padding-right'].' !important;') : '';

/* box shadow */

$pp_wrapper_shadow = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_shadow'])) ? ('box-shadow:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_shadow']. ' !important;') : '';

/* border width */

$pp_wrapper_border_width = (isset($ALSP_ADIMN_SETTINGS['pp_wrapper_border_width'])) ? ('border-width:' .$ALSP_ADIMN_SETTINGS['pp_wrapper_border_width']. 'px;') : '';
$pp_list_border_width = (isset($ALSP_ADIMN_SETTINGS['pp_list_border_width'])) ? ('border-width:' .$ALSP_ADIMN_SETTINGS['pp_list_border_width']. 'px !important;') : '';
$pp_button_border_width = (isset($ALSP_ADIMN_SETTINGS['pp_button_border_width'])) ? ('border-width:' .$ALSP_ADIMN_SETTINGS['pp_button_border_width']. 'px;') : '';

/* css */

Pacz_Static_Files::addGlobalStyle("
	.alsp-choose-plan{
		{$pp_wrapper_bg}
		{$pp_wrapper_border_color}
		{$pp_wrapper_border_width}
		{$pp_wrapper_shadow}
		{$pp_wrapper_border_radius_top}
		{$pp_wrapper_border_radius_bottom}
		{$pp_wrapper_border_radius_left}
		{$pp_wrapper_border_radius_right}
		
	}
	.alsp-choose-plan:hover{
		{$pp_wrapper_bg_hover}
		{$pp_wrapper_border_color_hover}
	}
	.alsp-choose-plan .alsp-panel-heading h3{
		{$pp_title_font_family}
		{$pp_title_font_size}
		{$pp_title_font_weight}
		{$pp_title_font_line_height}
		{$pp_title_font_transform}
		{$pp_title_color}
	}
	.alsp-choose-plan:hover .alsp-panel-heading h3{
		{$pp_title_color_hover}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item.pp-price .alsp-price{
		{$pp_price_font_family}
		{$pp_price_font_size}
		{$pp_price_font_weight}
		{$pp_price_font_line_height}
		{$pp_price_font_transform}
		{$pp_price_color}
	}
	.alsp-choose-plan:hover .alsp-list-group .alsp-list-group-item.pp-price .alsp-price{
		{$pp_price_color_hover}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item,
	.pplan-style-4 .alsp-choose-plan ul.alsp-list-group .alsp-list-group-item{
		{$pp_list_font_family}
		{$pp_list_font_size}
		{$pp_list_font_weight}
		{$pp_list_font_line_height}
		{$pp_list_font_transform}
		{$pp_list_color}
		{$pp_list_border_width}
		{$pp_list_border_color}
		{$pp_list_bg}
	}
	.alsp-choose-plan:hover .alsp-list-group .alsp-list-group-item,
	.pplan-style-4 .alsp-choose-plan:hover ul.alsp-list-group .alsp-list-group-item{
		{$pp_list_color_hover}
		{$pp_list_border_color_hover}
		{$pp_list_bg_hover}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item .pacz-icon-check{
		{$pp_icon_check_color}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item .pacz-icon-remove{
		{$pp_icon_remove_color}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item.pp-button a.btn.btn-primary{
		{$pp_button_bg}
		{$pp_button_border_width}
		{$pp_button_border_color}
		{$pp_button_border_radius_top}
		{$pp_button_border_radius_bottom}
		{$pp_button_border_radius_left}
		{$pp_button_border_radius_right}
		{$pp_button_color}
	}
	.alsp-choose-plan .alsp-list-group .alsp-list-group-item.pp-button a.btn.btn-primary:hover{
		{$pp_button_bg_hover}
		{$pp_button_border_color_hover}
		{$pp_button_color_hover}
	}
");


###########################################
# Listing 
###########################################

/* listing title */
$listing_font_family = (isset($ALSP_ADIMN_SETTINGS['listing_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['listing_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['listing_typo']['font-family'] . ';') : '';
$listing_font_size = 'font-size:' . $ALSP_ADIMN_SETTINGS['listing_typo']['font-size'] . ';';
$listing_font_weight = 'font-weight:' . $ALSP_ADIMN_SETTINGS['listing_typo']['font-weight'] . ';';
$listing_font_line_height = 'line-height:' . $ALSP_ADIMN_SETTINGS['listing_typo']['line-height'] . ';';
$listing_font_transform = (isset($ALSP_ADIMN_SETTINGS['listing_title_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['listing_title_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['listing_title_typo_transform'] . ';') : ('text-transform: uppercase;');

$listing_title_color = (isset($ALSP_ADIMN_SETTINGS['listing_title_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['listing_title_color']['regular'] : '';
$listing_title_color_hover = (isset($ALSP_ADIMN_SETTINGS['listing_title_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['listing_title_color']['hover'] : '';


/* listing category */

$listing_cat_font_family = (isset($ALSP_ADIMN_SETTINGS['listing_cat_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['listing_cat_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['listing_cat_typo']['font-family'] . ';') : '';
$listing_cat_font_size = 'font-size:' . $ALSP_ADIMN_SETTINGS['listing_cat_typo']['font-size'] . ';';
$listing_cat_font_weight = 'font-weight:' . $ALSP_ADIMN_SETTINGS['listing_cat_typo']['font-weight'] . ';';
$listing_cat_font_line_height = 'line-height:' . $ALSP_ADIMN_SETTINGS['listing_cat_typo']['line-height'] . ';';
$listing_cat_font_transform = (isset($ALSP_ADIMN_SETTINGS['listing_cat_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['listing_cat_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['listing_cat_typo_transform'] . ';') : ('text-transform: uppercase;');

$listing_category_color = (isset($ALSP_ADIMN_SETTINGS['listing_cat_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['listing_cat_color']['regular'] : '';
$listing_category_color_hover = (isset($ALSP_ADIMN_SETTINGS['listing_cat_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['listing_cat_color']['hover'] : '';


/* listing meta */

$listing_meta_font_family = (isset($ALSP_ADIMN_SETTINGS['listing_meta_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['listing_meta_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['listing_meta_typo']['font-family'] . ';') : '';
$listing_meta_font_size = 'font-size:' . $ALSP_ADIMN_SETTINGS['listing_meta_typo']['font-size'] . ';';
$listing_meta_font_weight = 'font-weight:' . $ALSP_ADIMN_SETTINGS['listing_meta_typo']['font-weight'] . ';';
$listing_meta_font_line_height = 'line-height:' . $ALSP_ADIMN_SETTINGS['listing_meta_typo']['line-height'] . ';';
$listing_meta_font_transform = (isset($ALSP_ADIMN_SETTINGS['listing_meta_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['listing_meta_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['listing_meta_typo_transform'] . ';') : ('text-transform: uppercase;');
	
$listing_meta_color = (isset($ALSP_ADIMN_SETTINGS['listing_meta_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['listing_meta_color']['regular'] : '';
$listing_meta_color_hover = (isset($ALSP_ADIMN_SETTINGS['listing_meta_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['listing_meta_color']['hover'] : '';

/* listing wrapper */

$listing_bg = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_bg']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_bg']['rgba'].';') : '';
$listing_bg_hover = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_bg_hover']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_bg_hover']['rgba'].';') : '';
$listing_content_bg = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg']['rgba'].';') : '';
$listing_content_bg_hover = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg_hover']['color'])) ? ('background:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_bg_hover']['rgba'].';') : '';
$listing_border_color = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_border_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_border_color']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_border_color']['rgba'].';') : '';
$listing_border_color_hover = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_border_color_hover']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_border_color_hover']['color'])) ? ('border-color:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_border_color_hover']['rgba'].';') : '';


$listing_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-top'].';') : '';
$listing_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-bottom'].';') : '';
$listing_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-left'].';') : '';
$listing_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_radius']['padding-right'].';') : '';

$listing_content_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-top'].';') : '';
$listing_content_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-bottom'].';') : '';
$listing_content_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-left'].';') : '';
$listing_content_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_content_wrapper_radius']['padding-right'].';') : '';

$listing_border_width = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_border_width']) && $ALSP_ADIMN_SETTINGS['listing_wrapper_border_width'] != 0) ? ('min-width:' . $ALSP_ADIMN_SETTINGS['listing_wrapper_border_width'] . 'px;') : ''; 
$listing_box_shadow = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_shadow']) && !empty($ALSP_ADIMN_SETTINGS['listing_wrapper_shadow'])) ? ('box-shadow:'.$ALSP_ADIMN_SETTINGS['listing_wrapper_shadow'].';') : '';
$listing_box_shadow_hover = (isset($ALSP_ADIMN_SETTINGS['listing_wrapper_shadow_hover'])) ? $ALSP_ADIMN_SETTINGS['listing_wrapper_shadow_hover'] : '';

/* Featured tag */

$featured_tag_font_family = (isset($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-family'] . ';') : '';
$featured_tag_font_size = (isset($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-size']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-size'])) ? ('font-size:' . $ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-size'] . ';') : '';
$featured_tag_font_weight = (isset($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-weight']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-weight'])) ? ('font-weight:' . $ALSP_ADIMN_SETTINGS['featured_tag_typo']['font-weight'] . ';') : '';
$featured_tag_font_line_height = (isset($ALSP_ADIMN_SETTINGS['featured_tag_typo']['line-height']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_typo']['line-height'])) ? ('line-height:' . $ALSP_ADIMN_SETTINGS['featured_tag_typo']['line-height'] . ';') : '';
$featured_tag_font_transform = (isset($ALSP_ADIMN_SETTINGS['featured_tag_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['featured_tag_typo_transform'] . ';') : '';

$featured_tag_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-top']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-top'])) ? ('border-top-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-top'].';') : '';
$featured_tag_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-bottom']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-bottom'])) ? ('border-bottom-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-bottom'].';') : '';
$featured_tag_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-left']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-left'])) ? ('border-bottom-left-radius:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-left'].';') : '';
$featured_tag_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-right']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-right'])) ? ('border-top-right-radius:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_radius']['padding-right'].';') : '';

$featured_tag_position_top = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_top']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_top'])) ? ('top:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_position_top'].' !important;') : '';
$featured_tag_position_bottom = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_bottom']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_bottom'])) ? ('bottom:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_position_bottom'].' !important;') : '';
$featured_tag_position_left = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_left']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_left'])) ? ('left:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_position_left'].' !important;') : '';
$featured_tag_position_right = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_right']) && !empty($ALSP_ADIMN_SETTINGS['listing_featured_tag_position_right'])) ? ('right:'.$ALSP_ADIMN_SETTINGS['listing_featured_tag_position_right'].' !important;') : '';
global $pacz_settings;

$featured_tag_width = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_width']) && $ALSP_ADIMN_SETTINGS['listing_featured_tag_width'] != 0) ? ('min-width:' . $ALSP_ADIMN_SETTINGS['listing_featured_tag_width'] . 'px;') : ''; 
$featured_tag_height = (isset($ALSP_ADIMN_SETTINGS['listing_featured_tag_height']) && $ALSP_ADIMN_SETTINGS['listing_featured_tag_height'] != 0) ? ('min-height:' . $ALSP_ADIMN_SETTINGS['listing_featured_tag_height'] . 'px;') : '';
$featured_tag_bg = (isset($ALSP_ADIMN_SETTINGS['featured_tag_bg']['rgba']) && (!empty($ALSP_ADIMN_SETTINGS['featured_tag_bg']['color']))) ? ('background:'.$ALSP_ADIMN_SETTINGS['featured_tag_bg']['rgba'].';') : '';
$featured_tag_bg_hover = (isset($ALSP_ADIMN_SETTINGS['featured_tag_bg_hover']['rgba']) && (!empty($ALSP_ADIMN_SETTINGS['featured_tag_bg_hover']['color']))) ? ('background:'.$ALSP_ADIMN_SETTINGS['featured_tag_bg_hover']['rgba'].';') : '';
$featured_tag_color = (isset($ALSP_ADIMN_SETTINGS['featured_tag_color']['regular']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_color']['regular'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['featured_tag_color']['regular'].';') : '';
$featured_tag_color_hover = (isset($ALSP_ADIMN_SETTINGS['featured_tag_color']['hover']) && !empty($ALSP_ADIMN_SETTINGS['featured_tag_color']['hover'])) ? ('color:'.$ALSP_ADIMN_SETTINGS['featured_tag_color']['hover'].';') : '';

/* listing price */

$listing_price_font_family = (isset($ALSP_ADIMN_SETTINGS['listing_price_typo']['font-family']) && !empty($ALSP_ADIMN_SETTINGS['listing_price_typo']['font-family'])) ? ('font-family:' . $ALSP_ADIMN_SETTINGS['listing_price_typo']['font-family'] . ';') : '';
$listing_price_font_size = 'font-size:' . $ALSP_ADIMN_SETTINGS['listing_price_typo']['font-size'] . ';';
$listing_price_font_weight = 'font-weight:' . $ALSP_ADIMN_SETTINGS['listing_price_typo']['font-weight'] . ';';
$listing_price_font_line_height = 'line-height:' . $ALSP_ADIMN_SETTINGS['listing_price_typo']['line-height'] . ';';
$listing_price_font_transform = (isset($ALSP_ADIMN_SETTINGS['listing_price_typo_transform']) && !empty($ALSP_ADIMN_SETTINGS['listing_price_typo_transform'])) ? ('text-transform: ' . $ALSP_ADIMN_SETTINGS['listing_price_typo_transform'] . ';') : ('text-transform: uppercase;');

$listing_price_color = (isset($ALSP_ADIMN_SETTINGS['listing_price_color']['regular'])) ? $ALSP_ADIMN_SETTINGS['listing_price_color']['regular'] : '';
$listing_price_color_hover = (isset($ALSP_ADIMN_SETTINGS['listing_price_color']['hover'])) ? $ALSP_ADIMN_SETTINGS['listing_price_color']['hover'] : '';

$price_tag_border_radius_top = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-top'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-top'] : '';
$price_tag_border_radius_bottom = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-bottom'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-bottom'] : '';
$price_tag_border_radius_left = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-left'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-left'] : '';
$price_tag_border_radius_right = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-right'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_radius']['padding-right'] : '';

$price_tag_position_top = (isset($ALSP_ADIMN_SETTINGS['price_tag_position']['padding-top'])) ? $ALSP_ADIMN_SETTINGS['price_tag_position']['padding-top'] : '';
$price_tag_position_bottom = (isset($ALSP_ADIMN_SETTINGS['price_tag_position']['padding-bottom'])) ? $ALSP_ADIMN_SETTINGS['price_tag_position']['padding-bottom'] : '';
$price_tag_position_left = (isset($ALSP_ADIMN_SETTINGS['price_tag_position']['padding-left'])) ? $ALSP_ADIMN_SETTINGS['price_tag_position']['padding-left'] : '';
$price_tag_position_right = (isset($ALSP_ADIMN_SETTINGS['price_tag_position']['padding-right'])) ? $ALSP_ADIMN_SETTINGS['price_tag_position']['padding-right'] : '';

$price_tag_width = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_width'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_width'] : '';
$price_tag_height = (isset($ALSP_ADIMN_SETTINGS['listing_price_tag_height'])) ? $ALSP_ADIMN_SETTINGS['listing_price_tag_height'] : '';
$price_tag_bg = (isset($ALSP_ADIMN_SETTINGS['listing_price_bg']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_price_bg']['color'])) ? $ALSP_ADIMN_SETTINGS['listing_price_bg']['rgba'] : $pacz_settings['accent-color'];
$price_tag_bg_hover = (isset($ALSP_ADIMN_SETTINGS['listing_price_bg_hover']['rgba'])  && !empty($ALSP_ADIMN_SETTINGS['listing_price_bg_hover']['color'])) ? $ALSP_ADIMN_SETTINGS['listing_price_bg_hover']['rgba'] : $pacz_settings['btn-hover'];

Pacz_Static_Files::addGlobalStyle("
	.alsp-listing .listing-wrapper{
		{$listing_bg}
		{$listing_border_color}
		{$listing_border_radius_top}
		{$listing_border_radius_right}
		{$listing_border_radius_bottom}
		{$listing_border_radius_left}
		{$listing_box_shadow}
		{$listing_border_width}
	}
	.alsp-listing .listing-wrapper:hover{
		{$listing_bg_hover}
		{$listing_border_color_hover}
		box-shadow: {$listing_box_shadow_hover};
	}
	.alsp-listing .listing-wrapper .alsp-listing-text-content-wrap{
		{$listing_content_bg}
		{$listing_content_border_radius_top}
		{$listing_content_border_radius_right}
		{$listing_content_border_radius_bottom}
		{$listing_content_border_radius_left}
		overflow:hidden;
	}
	.alsp-listing .listing-wrapper:hover .alsp-listing-text-content-wrap{
		{$listing_content_bg_hover}
	}
	.alsp-listing .listing-wrapper .alsp-listing-text-content-wrap .alsp-listing-header h2 a{
		{$listing_font_family}
		{$listing_font_size}
		{$listing_font_weight}
		{$listing_font_line_height}
		{$listing_font_transform}
		color: {$listing_title_color} !important;
	}
	.alsp-listing .listing-wrapper:hover .alsp-listing-text-content-wrap .alsp-listing-header h2 a{
		color: {$listing_title_color_hover} !important;
	}
	
	.featured-tag-1,
	.featured-tag-2,
	.featured-tag-3,
	.featured-tag-4,
	.featured-tag-5,
	.featured-tag-6,
	.featured-tag-7,
	.featured-tag-8,
	.featured-tag-9,
	.featured-tag-10,
	.featured-tag-11,
	.featured-tag-12,
	.featured-tag-13,
	.featured-tag-14,
	.featured-tag-15,
	.featured-tag-16{
		{$featured_tag_font_family}
		{$featured_tag_font_size}
		{$featured_tag_font_weight}
		{$featured_tag_font_line_height}
		{$featured_tag_font_transform}
		{$featured_tag_width}
		{$featured_tag_height}
		{$featured_tag_bg}
		{$featured_tag_color}
		{$featured_tag_border_radius_top}
		{$featured_tag_border_radius_right}
		{$featured_tag_border_radius_bottom}
		{$featured_tag_border_radius_left}
		{$featured_tag_position_top}
		{$featured_tag_position_bottom}
		{$featured_tag_position_left}
		{$featured_tag_position_right}

	}
	.alsp-listing .listing-wrapper:hover .featured-tag-1,
	.alsp-listing .listing-wrapper:hover .featured-tag-2,
	.alsp-listing .listing-wrapper:hover .featured-tag-3,
	.alsp-listing .listing-wrapper:hover .featured-tag-4,
	.alsp-listing .listing-wrapper:hover .featured-tag-5,
	.alsp-listing .listing-wrapper:hover .featured-tag-6,
	.alsp-listing .listing-wrapper:hover .featured-tag-7,
	.alsp-listing .listing-wrapper:hover .featured-tag-8,
	.alsp-listing .listing-wrapper:hover .featured-tag-9,
	.alsp-listing .listing-wrapper:hover .featured-tag-10,
	.alsp-listing .listing-wrapper:hover .featured-tag-11,
	.alsp-listing .listing-wrapper:hover .featured-tag-12,
	.alsp-listing .listing-wrapper:hover .featured-tag-13,
	.alsp-listing .listing-wrapper:hover .featured-tag-14,
	.alsp-listing .listing-wrapper:hover .featured-tag-15,
	.alsp-listing .listing-wrapper:hover .featured-tag-16{
		{$featured_tag_color_hover}
		{$featured_tag_bg_hover}
	}
	.alsp-listing .listing-wrapper figure .price{
		top:{$price_tag_position_top};
		bottom:{$price_tag_position_bottom};
		left:{$price_tag_position_left};
		right:{$price_tag_position_right};
	}
	.alsp-listing .listing-wrapper .price .alsp-field-content {
		{$listing_price_font_family}
		{$listing_price_font_size}
		{$listing_price_font_weight}
		{$listing_price_font_line_height}
		{$listing_price_font_transform}
		color: {$listing_price_color} !important;
	}
	.alsp-listing .listing-wrapper:hover .price .alsp-field-content {
		color: {$listing_price_color_hover} !important;
	}
	.alsp-listing .listing-wrapper figure .price .alsp-field-content {
		background:{$price_tag_bg};
		min-width:{$price_tag_width}px;
		min-height:{$price_tag_height}px;
		border-top-left-radius:{$price_tag_border_radius_top};
		border-top-right-radius:{$price_tag_border_radius_right};
		border-bottom-right-radius:{$price_tag_border_radius_bottom};
		border-bottom-left-radius:{$price_tag_border_radius_left};
		top:{$price_tag_position_top};
		bottom:{$price_tag_position_bottom};
		left:{$price_tag_position_left};
		right:{$price_tag_position_right};
	}
	.alsp-listing .listing-wrapper:hover figure .price .alsp-field-content {
		background:{$price_tag_bg_hover} !important;
	}
	.listing-post-style-13 .listing-wrapper figure .price .alsp-field-content::after {
		border-bottom-color: {$price_tag_bg};
		border-left-color: {$price_tag_bg};
		border-top-color: {$price_tag_bg};
		min-height:{$price_tag_height}px;
	}
	.listing-post-style-13 .listing-wrapper:hover figure .price .alsp-field-content::after {
		border-bottom-color: {$price_tag_bg_hover};
		border-left-color: {$price_tag_bg_hover};
		border-top-color: {$price_tag_bg_hover};
	}
	.listing-pre,
	.listing-next{
		color:{$pacz_settings['accent-color']};
		border-color:{$pacz_settings['accent-color']};
	}
	.listing-pre:hover,
	.listing-next:hover{
		background-color:{$pacz_settings['accent-color']};
		color:#fff;
	}
	.view_swither_panel_style3 .btn.btn-primary.alsp-list-view-btn,
	.view_swither_panel_style3 .btn.btn-primary.alsp-grid-view-btn{
		color:{$pacz_settings['accent-color']};
		background:#fff !important;
	}
");
###########################################
# Archive
###########################################
$archive_content_area_width = (isset($ALSP_ADIMN_SETTINGS['archive_content_area_width'])) ? $ALSP_ADIMN_SETTINGS['archive_content_area_width'] : 67;
$archive_side_area_width = (isset($ALSP_ADIMN_SETTINGS['archive_side_area_width'])) ? $ALSP_ADIMN_SETTINGS['archive_side_area_width'] : 33;
$archive_side_area_padding = (isset($ALSP_ADIMN_SETTINGS['archive_side_area_padding'])) ? $ALSP_ADIMN_SETTINGS['archive_side_area_padding'] : 15;
$archive_side_area_position = (isset($ALSP_ADIMN_SETTINGS['archive_side_area_position'])) ? $ALSP_ADIMN_SETTINGS['archive_side_area_position'] : 'right';
$archive_top_map_width_box = ($ALSP_ADIMN_SETTINGS['archive_top_map_width']) ? ('width:100%; left:auto;') : '';
$archive_content_area_location_margin_top = (isset($ALSP_ADIMN_SETTINGS['archive_content_area_location_margin_top'])) ? $ALSP_ADIMN_SETTINGS['archive_content_area_location_margin_top'] : 70;
$archive_content_area_category_margin_top = (isset($ALSP_ADIMN_SETTINGS['archive_content_area_category_margin_top'])) ? $ALSP_ADIMN_SETTINGS['archive_content_area_category_margin_top'] : 70;
$archive_content_area_listings_margin_top = (isset($ALSP_ADIMN_SETTINGS['archive_content_area_listings_margin_top'])) ? $ALSP_ADIMN_SETTINGS['archive_content_area_listings_margin_top'] : 70;

Pacz_Static_Files::addGlobalStyle("
	.archive-content-wrapper{
		margin-left:-{$archive_side_area_padding}px;
		margin-right:-{$archive_side_area_padding}px;
	}
	.listing-archive-sidearea{
		width:{$archive_side_area_width}%;
		float:{$archive_side_area_position};
		padding-left:{$archive_side_area_padding}px;
		padding-right:{$archive_side_area_padding}px;
	}
	.listing-archive-content{
		width:{$archive_content_area_width}%;
		float:{$archive_side_area_position};
		padding-left:{$archive_side_area_padding}px;
		padding-right:{$archive_side_area_padding}px;
	}
	.listing-archive .map-listings{
		{$archive_top_map_width_box}
	}
	.listing-archive-content .map-listings{
		width:100%;
		left:auto;
	}
	.archive-style-nosidebar .archive-locations-wrapper .alsp-locations-columns {
		
	}
	.listing-archive-content .map-listings .alsp-maps-canvas{
		border-radius:0;
	}
	.archive-style-nosidebar .archive-locations-wrapper{
		margin-top:{$archive_content_area_location_margin_top}px;
	}
	.archive-style-nosidebar .archive-categories-wrapper{
		margin-top:{$archive_content_area_category_margin_top}px;
	}
	.archive-style-nosidebar .archive-listings-wrapper{
		margin-top:{$archive_content_area_listings_margin_top}px;
	}
	
");

###########################################
# Misc
###########################################
global $pacz_settings;
$new_reset_link = $pacz_settings['accent-color'];

Pacz_Static_Files::addGlobalStyle("
.alsp-drop-attached-item .alsp-ajax-iloader > div{
	background-color:{$pacz_settings['accent-color']} !important;
}
.alsp-remove-from-favourites-list{
	background-color:{$accent_color};
}
.alsp-listing-header h2 a,
.alsp-content .btn-default,
.alsp-price span,
.premium-listing-text,
.premium-listing-text:hover{
	color:{$pacz_settings['heading-color']} !important;
	font-weight:{$pacz_settings['heading-font']['font-weight']};
	text-transform:capitalize;
}
.alsp-listing-header h2 a,
.premium-listing-text span,
.alsp-orderby-links .btn-default.btn-primary,
.handpick-locations .alsp-locations-column-wrapper a,
.alsp-categories-root a,
.alsp-price{
	{$heading_font_family}
}
.alsp-listing-header h2 a:hover,
.alsp-price,
.premium-listing-text span,
.alsp-price:hover,
.view-all-btn,
.view-all-btn:hover{
	color:{$accent_color} !important;
}
.alsp-close-info-window{
	background-color:{$accent_color};
}
.alsp-listings-grid .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .alsp-listing  figcaption .alsp-figcaption .alsp-location span{
	{$body_font_family}
	
}

.alsp-list-group-item{
	
	color:{$pacz_settings['body-txt-color']};
}

.alsp-listings-grid .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-content .btn-primary.alsp-grid-view-btn,
.alsp-content .btn-primary.alsp-list-view-btn{
	background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff;
	border-radius:0;
}
.btn-primary {
	background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff;
}
.view_swither_panel_style2 .btn-primary.alsp-grid-view-btn,
.view_swither_panel_style2 .btn-primary.alsp-list-view-btn{
	background:none !important;
	color:{$pacz_settings['btn-hover']} !important;
	border:none !important;
}
.alsp-orderby-links a.btn.btn-default.btn-primary{
	background:none !important;
	padding:6px 12px !important;
}



.alsp-content .btn-default:hover,
.alsp-orderby-links .btn-default.btn-primary,
.alsp-orderby-links .btn-default.btn-primary:hover{
	color:{$pacz_settings['link-color']['hover']} !important;
}
.view_swither_panel_style2 .alsp-orderby-links a.btn-default:hover,
.view_swither_panel_style2 .alsp-orderby-links a.btn-primary,
.view_swither_panel_style2 .alsp-orderby-links a.btn-primary:hover{
	border-color:{$pacz_settings['link-color']['hover']} !important;
}
.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .categories-count{
	color:{$pacz_settings['body-txt-color']} !important;
}
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .categories-count,
.author-name{
	color:{$pacz_settings['heading-color']} !important;
}

.btn-primary:hover{
	
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
}
.single-listing.alsp-content .nav-tabs > li a,
.single-listing.alsp-content .nav-tabs > li a:hover,
.access-press-social .apsl-login-new-text{
	color:{$pacz_settings['heading-color']} !important;
}
.single-listing.alsp-content .nav-tabs > li a i,
.author-phone a i{
	color:{$accent_color} !important;
}
.cat-scroll-header,
.search-form-style2 .search-wrap h5,
.alsp-single-listing-text-content-wrap .alsp-fields-group .alsp-fields-group-caption,
.alsp-single-listing-text-content-wrap .alsp-field-output-block .alsp-field-caption{
	{$heading_font_family};
	color:{$pacz_settings['heading-color']} !important;
}

.handpick-locations .alsp-locations-column-wrapper a{}
.alsp-dashboard-tabs-content .alsp-table ul li.td_listings_options .btn-group a{
	background-color:#fff !important;
	border-color: #fff !important;
}
.alsp-dashboard-tabs-content .alsp-table ul li.td_listings_options .btn-group a span{
	color:{$accent_color} !important;
}
.alsp-dashboard-tabs-content .alsp-table ul:first-child li,
.alsp-dashboard-tabs-content .alsp-table ul:first-child li a,
.alsp-dashboard-tabs-content .alsp-table ul:first-child li a span,
.alsp-content .alsp-submit-section-adv .alsp-panel-default > .alsp-panel-heading h3{
	{$heading_font_family};
}

.pacz-user-avatar-delete a,
.single-listing .alsp-field-content a,
.author-avatar-btn a{
	color:{$pacz_settings['link-color']['regular']} !important;
}
.pacz-user-avatar-delete a:hover,
.author-avatar-btn a:hover{
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
	color:#fff !important;
}

.save-avatar-btn .profile-avatar-btn,
.listing-author-box .author-info .author-btn a,
.alsp-social-widget ul.alsp-social li a{
	background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff !important;
}
.save-avatar-btn .profile-avatar-btn:hover,
.listing-author-box .author-info .author-btn a:hover,
.alsp-social-widget ul.alsp-social li a:hover{
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
	color:#fff !important;
}
.search-form-style2 .search-wrap h5:before,
.listing-author-box .author-info .author-info-list ul li i,
.alsp-listing-header .rating-numbers{
	background-color:{$accent_color};
}

.alsp-listing.alsp-featured .alsp-listing-logo a.alsp-listing-logo-img-wrap::after{
	background-color:#ff5656 !important;
}

.cz-datetime .datetime-reset-btn .btn.btn-primary{
	background-color:{$accent_color} !important;
}
.cz-datetime .datetime-reset-btn .btn.btn-primary:hover{
	background:{$pacz_settings['btn-hover']} !important;
}
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a{
	
}
.alsp-locations-column-wrapper  .alsp-locations-root a .loaction-name{
	{$heading_font_family}
}
:not(.listing-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.location-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.cat-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.search-result) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.listing-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.location-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.cat-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.search-result) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before{
	background-color:{$accent_color} !important;
	color:#fff;
}



.alsp_search_widget .bs-caret,
.alsp-locations-widget .alsp-locations-root a .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before{
	background-color:{$accent_color};
}
.alsp_search_widget .has-feedback:hover .glyphicon-screenshot,
.alsp-locations-widget .alsp-locations-root a:hover .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover:before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover:before{
	background-color:{$pacz_settings['btn-hover']};
}

.alsp-listings-block.cz-listview article .alsp-field-caption{
	color:{$pacz_settings['heading-color']};
}
.alsp-listings-block.cz-listview article .alsp-field-output-block.alsp-field-output-block-categories .field-content .label.label-primary{
	background-color:{$accent_color} !important;
}
.alsp-listings-block.cz-listview article .alsp-field-output-block .alsp-field-caption .alsp-field-icon{
	color:{$accent_color} !important;
}
.alsp-single-listing-logo-wrap header.alsp-listing-header .statVal span.ui-rater-rating {
	background-color:{$accent_color} !important;
}
.cz-checkboxes .checkbox .radio-check-item:before,
.alsp-price.alsp-payments-free,
.alsp-content .alsp-list-group-item i.pacz-icon-check,
.checkbox-wrap .checkbox label:before,
label span.radio-check-item:before{
    color:{$accent_color} !important;
}
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del .woocommerce-Price-amount,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del .woocommerce-Price-amount .woocommerce-Price-currencySymbol,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del,
.alsp-choose-plan ul li .alsp-price del,
.alsp-price del .woocommerce-Price-amount,
.alsp-price del .woocommerce-Price-amount .woocommerce-Price-currencySymbol{
	color:{$pacz_settings['body-txt-color']} !important;
}
.pplan-style-3 .alsp-choose-plan ul li .alsp-price span,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price{
	color:{$pacz_settings['heading-color']} !important;
}
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child {
	background-color:{$accent_color} !important;
	border-color:#fff;
	box-shadow:none;
	
}
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child span,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child .alsp-price,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child .alsp-price span{
	color:#fff !important;
}
.alsp-categories-widget .alsp-categories-root a .categories-count{
	color: {$pacz_settings['sidebar-txt-color']};
}
.alsp-categories-widget .alsp-categories-root a:hover,
.alsp-categories-widget .alsp-categories-root a:hover .categories-count,
a.alsp-hint-icon:after{
	color:{$accent_color} !important;
}
.listing-post-style-2 .featured-ad{
	background:{$accent_color};
}
.listing-post-style-2:hover .featured-ad{
background:{$pacz_settings['btn-hover']};
}
.listing-post-style-3 figure .price,
.listing-post-style-7 figure .price .alsp-field-output-block-price .alsp-field-content{
	background:{$accent_color};
}
.listing-post-style-3:hover figure .price,
.listing-post-style-7:hover figure .price .alsp-field-output-block-price .alsp-field-content{
	background:{$pacz_settings['btn-hover']};
}
.alsp-listings-grid .listing-post-style-3 .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .listing-post-style-5 .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-listings-grid .listing-post-style-9 .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.popular-level{
	background-color:{$accent_color} !important;
}
.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-listings-grid .listing-post-style-5 .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .listing-post-style-9 .alsp-listing-text-content-wrap .alsp-field-output-block-price {
	color:{$accent_color} !important;
}
.location-style2 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner .alsp-locations-root a .location-count,
.location-style3 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner .alsp-locations-root a .location-count{
	background-color:{$accent_color} !important;
}
.single-listing .alsp-label, {
	color:{$pacz_settings['body-txt-color']} !important;
	background:none !important;
}

.single-listing .alsp-label-primary {background:none;}
.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap{
	background:{$pacz_settings['heading-color']};
}
.single-listing-btns ul li a{
	color:{$pacz_settings['body-txt-color']};
}


.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-label-primary a{
	color:{$pacz_settings['btn-hover']} !important;
}

.alsp-listings-grid .listing-post-style-7 .alsp-listing-text-content-wrap .second-content-field .alsp-field-output-block-string .alsp-field-caption .alsp-field-icon {
	color:{$accent_color};
}
.alsp-listings-grid .listing-post-style-8 .listing-wrapper:hover .alsp-listing-text-content-wrap{
	
}
.alsp-listing .alsp-listing-text-content-wrap .listing-metas em.alsp-listing-date i,
.alsp-listing .alsp-listing-text-content-wrap .listing-views i,
.alsp-listing .alsp-listing-text-content-wrap .listing-id i,
.alsp-listing .listing-wrapper .alsp-listing-text-content-wrap .listing-location i,
.single-listing .alsp-listing-date i,
.single-listing .listing-views i,
.single-location-address i,
.dashbeard-btn-panel .cz-btn-wrap a.favourites-link:hover{
	color:{$pacz_settings['btn-hover']};
}
.alsp-listings-grid .listing-post-style-10 .listing-wrapper .alsp-listing-text-content-wrap .listing-location i{
	color:{$pacz_settings['body-txt-color']};
}
.dashbeard-btn-panel .cz-btn-wrap a.favourites-link{
	background-color:{$accent_color};
}
.alsp-listing.listing-post-style-9 .alsp-listing-logo .price .alsp-field span.alsp-field-content{
	{$heading_font_family};
	font-weight:bold;
}
.alsp-listing.listing-post-style-6.alsp-featured .alsp-listing-logo a.alsp-listing-logo-img-wrap:after,
{
    content: '{$featured_text}';
	font-family: inherit;
    display: inline-block;
    height: auto;
    width: auto;
    padding: 7px 12px;
    position: absolute;
	bottom:30px;
	left:30px !important;
	color:#fff;
	z-index:1;
	font-size:14px;
	border-radius:3px;
	line-height:1;
	text-transform:uppercase;
	background-color:{$pacz_settings['btn-hover']};
}
.alsp-listing.listing-post-style-9 .alsp-listing-logo .price .alsp-field span.alsp-field-content{
	background:{$pacz_settings['btn-hover']} !important;
}
.cz-listview .alsp-listing-text-content-wrap .price span.alsp-field-content{
	background:{$pacz_settings['btn-hover']} !important;
}
.cz-listview .listing-post-style-listview_ultra .alsp-listing-text-content-wrap .price span.alsp-field-content{
	background:{$accent_color} !important;
}


.author-verified{
	
}
.author_type,
.author_verifed{
	border-color:{$accent_color};
	color:{$accent_color};
}
.author_unverifed{
	border-color:#E37B33;
	color:#E37B33;
}
.alsp-listings-grid .listing-post-style-10 .alsp-listing-text-content-wrap .alsp-field-output-block-price{
	color:{$pacz_settings['heading-color']};
}
.alsp-listings-grid .listing-post-style-10 .alsp-listing-text-content-wrap .listing-cat{
	color:{$pacz_settings['body-txt-color']};
}
.single-listing .listing-main-content,
#pacz-sidebar .widget,
.listing-list-view-inner-wrap,
.single-listing .listing-wrapper,
.single-style-default .content-field-block,
.single-style-default .alsp-fields-group,
.single-style-default.single-listing .tab-content,
.single-style-default.single-listing .alsp-share-buttons {
	border-radius:{$pacz_settings['sidebar_content_radius']}px;
}
.single-style-default .alsp-single-listing-logo-wrap{
	border-bottom-left-radius:{$pacz_settings['sidebar_content_radius']}px;
	border-bottom-right-radius:{$pacz_settings['sidebar_content_radius']}px;
	overflow:hidden;
}
.user-panel .author-thumbnail{
	border:3px solid {$accent_color};
}

.skin-blue .user-panel-main .sidebar-menu > li.active > a,
.skin-blue .user-panel-main .sidebar-menu>li>.treeview-menu{
	border-left-color:{$accent_color};
}
.verified-ad-tag,
.unverified-ad-tag{
	color:{$pacz_settings['body-txt-color']};
}
.single-listing .owl-nav .owl-prev:hover, .single-listing .owl-nav .owl-next:hover {
	color: {$pacz_settings['btn-hover']} !important;
}

.td_listings_id span.pacz-fic4-bookmark-white,
.td_listings_options .dropdown .dropdown-menu a span,
.comments_numbers
{
	color: {$accent_color};
}
.listing-post-style-9 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-10 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-14 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-15 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-listview_ultra .listing-rating.grid-rating .rating-numbers{
	background-color:{$accent_color};
}
.new_reset_link{
	color:{$new_reset_link};
}
");


	
	$listing_title_font = $ALSP_ADIMN_SETTINGS['alsp_listing_title_font'];
	$alsp_search_style3_mtop = $ALSP_ADIMN_SETTINGS['alsp_search_style3_mtop'];
	Pacz_Static_Files::addGlobalStyle("
	
		header.alsp-listing-header h2 {
		font-size: {$listing_title_font}px;
		}
		.search-form-style3.alsp-content.alsp-search-form {
		margin-top: {$alsp_search_style3_mtop}px !important;
		}
	");

	if (!$ALSP_ADIMN_SETTINGS['alsp_search_style3_shadow']){ 
		Pacz_Static_Files::addGlobalStyle("
			.search-form-style3 {
				box-shadow:none;
			}
		");
	}
	if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']){ 
		Pacz_Static_Files::addGlobalStyle("
			.listings.cat-archive .main-search-bar .alsp-content.alsp-search-form {margin: 0 !important;}
			.listings.location-archive .main-search-bar .alsp-content.alsp-search-form {margin: 0 !important;}
		");
	}
	



/* single listing*/
$sliderGutter = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayGutter']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayGutter']: 5;
Pacz_Static_Files::addGlobalStyle("
	.slick-carousel-single .slick-slide{
		padding: 0 {$sliderGutter}px;
	}
	.slick-carousel2.slick-carousel-single .slick-slide,
	.slider-nav.slick-carousel-single .slick-slide{
		padding:0;
	}
	.single-listing .listing-top-content .slick-carousel .listing-pre:hover,
	.single-listing .listing-top-content .slick-carousel .listing-next:hover{
	color:{$pacz_settings['accent-color']} !important;
	background:#fff !important;
}
.single-listing .listing-header-wrap header .price .alsp-field-output-block span.alsp-field-content,
.single-listing .alsp-single-listing-logo-wrap .price .alsp-field-output-block span.alsp-field-content{
	background-color:{$accent_color};
}

");


