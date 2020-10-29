<?php global $ALSP_ADIMN_SETTINGS, $alsp_dynamic_styles;
$alsp_styles = '';
			$search_form_id = $uid;
			$alsp_styles = "
				".$search_form_id." .search-wrap{
					padding-top:".$search_box_padding_top."px;
					padding-bottom:".$search_box_padding_bottom."px;
					padding-left:".$search_box_padding_left."px;
					padding-right:".$search_box_padding_right."px;
				}
				".$search_form_id." .search-form-style1 .advanced-search-button a{color:".$pacz_settings['body-txt-color']." !important;}

				".$search_form_id." .search-wrap .cz-submit-btn.btn.btn-primary{
					background-color:".$search_button_bg." !important;
					border-color:".$search_button_border_color."!important;
					border-width:".$search_button_border_width."px;
					border-radius: ".$search_button_border_radius."px;
					color:".$search_button_text_color."!important;
				}
				".$search_form_id." .search-wrap .cz-submit-btn.btn.btn-primary:hover{
					background-color:".$search_button_bg_hover."!important;
					border-color:".$search_button_border_color_hover."!important;
					color:".$search_button_text_color_hover."!important;
				}
				".$search_form_id." .search-wrap .form-control{
					background-color:".$input_field_bg.";
					border-color:".$input_field_border_color.";
					border-width:".$input_field_border_width."px;
					border-radius: ".$input_field_border_radius."px;
					color:".$input_field_text_color.";
				}

				".$search_form_id." .search-wrap .form-control:focus{
					border-color:".$input_field_border_color.";
					border-width:".$input_field_border_width."px;
					border-radius: ".$input_field_border_radius."px;
					color:".$input_field_text_color.";
				}
				".$search_form_id." .alsp-search-radius-label{
					color:".$input_field_label_color.";
				}
				".$search_form_id." .search-wrap .form-control::-moz-placeholder,
				".$search_form_id." .search-wrap .form-control::placeholder{
					color:".$input_field_placeholder_color." !important;
				}
			";


?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<div class="alsp-content alsp-widget alsp_search_widget">
	<?php
	$search_form = new alsp_search_form($uid);
				$advanced_open = $ALSP_ADIMN_SETTINGS['advanced_open_widget'];
				$keyword_field_width = (isset($ALSP_ADIMN_SETTINGS['keyword_field_width']))? $ALSP_ADIMN_SETTINGS['keyword_field_width'] : 100;
				$listingtype_field_width = (isset($ALSP_ADIMN_SETTINGS['listingtype_field_width']))? $ALSP_ADIMN_SETTINGS['listingtype_field_width'] : 100;
				$category_field_width = (isset($ALSP_ADIMN_SETTINGS['category_field_width']))? $ALSP_ADIMN_SETTINGS['category_field_width'] : 100;
				$location_field_width = (isset($ALSP_ADIMN_SETTINGS['location_field_width']))? $ALSP_ADIMN_SETTINGS['location_field_width'] : 100;
				$address_field_width = (isset($ALSP_ADIMN_SETTINGS['address_field_width']))? $ALSP_ADIMN_SETTINGS['address_field_width'] : 100;
				$radius_field_width = (isset($ALSP_ADIMN_SETTINGS['radius_field_width']))? $ALSP_ADIMN_SETTINGS['radius_field_width'] : 100;
				$button_field_width = (isset($ALSP_ADIMN_SETTINGS['button_field_width']))? $ALSP_ADIMN_SETTINGS['button_field_width'] : 100;
				$gap_in_fields = (isset($ALSP_ADIMN_SETTINGS['gap_in_fields']))? $ALSP_ADIMN_SETTINGS['gap_in_fields'] : 0;
				$search_form_type = 3;
	$search_form->display(
	$advanced_open,
	$keyword_field_width,
	$listingtype_field_width,
	$category_field_width,
	$location_field_width,
	$address_field_width,
	$radius_field_width,
	$button_field_width,
	$gap_in_fields,
	$search_form_type
	);
	?>
</div>
<?php echo $args['after_widget']; ?>
<?php
if($search_custom_style){
			// Hidden styles node for head injection after page load through ajax
			echo '<div id="ajax-'.$search_form_id.'" class="alsp-dynamic-styles">';
			echo '</div>';

			// Export styles to json for faster page load
			$alsp_dynamic_styles[] = array(
			  'id' => 'ajax-'.$search_form_id ,
			  'inject' => $alsp_styles
			);
}
 ?>