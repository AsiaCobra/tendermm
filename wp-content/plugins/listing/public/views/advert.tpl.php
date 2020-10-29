<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php 
	if(($listing->listings_view_type == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$listing->fchash])) || (isset($_COOKIE['alsp_listings_view_'.$listing->fchash]) && $_COOKIE['alsp_listings_view_'.$listing->fchash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}elseif(($listing->listings_view_type == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$listing->fchash])) || (isset($_COOKIE['alsp_listings_view_'.$listing->fchash]) && $_COOKIE['alsp_listings_view_'.$listing->fchash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($listing->listings_view_type == 'list' && !isset($_COOKIE['alsp_listings_view_'.$listing->fchash])) || (isset($_COOKIE['alsp_listings_view_'.$listing->fchash]) && $_COOKIE['alsp_listings_view_'.$listing->fchash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($listing->listings_view_type == 'list' && !isset($_COOKIE['alsp_listings_view_'.$listing->fchash])) || (isset($_COOKIE['alsp_listings_view_'.$listing->fchash]) && $_COOKIE['alsp_listings_view_'.$listing->fchash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}else{
		if($ALSP_ADIMN_SETTINGS['alsp_views_switcher_default'] == 'grid'){
			$listing_style_to_show = 'show_grid_style';
		}else{
			$listing_style_to_show = 'show_list_style';
		}
	}
	
	if ($listing->level->featured){
		$is_featured =  'featured-ad';
	}else{
		$is_featured =  'normal';
	}
	if($is_featured != 'featured-ad'){
		$no_featured = 'no_featured_tag';
	}else{
		$no_featured = '';
	}
	
	require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
	if(isset($listing->logo_image) && !empty($listing->logo_image)){
		$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
		$image_src = $image_src_array[0];
	}elseif(isset($ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url']) && !empty($ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url'])){
		$image_src_array = $ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url'];
		$image_src = $image_src_array;
	}else{
		$image_src = ALSP_RESOURCES_URL.'images/no-thumbnail.jpg';
	}
	if($listing_style_to_show == 'show_grid_style'){		
		if ($ALSP_ADIMN_SETTINGS['listing_image_width_height'] == 1){
			if($listing->listing_post_style == 1){
				$width= 360;
				$height= 390;
			}elseif($listing->listing_post_style == 2){
				$width= 350;
				$height= 300;
			}elseif($listing->listing_post_style == 3){
				$width= 360;
				$height= 290;
			}elseif($listing->listing_post_style == 4){
				$width= 350;
				$height= 280;
			}elseif($listing->listing_post_style == 5){
				$width= 370;
				$height= 260;
			}elseif($listing->listing_post_style == 6){
				$width= 370;
				$height= 450;
			}elseif($listing->listing_post_style == 7){
				$width= 370;
				$height= 380;
			}elseif($listing->listing_post_style == 8){
				$width= 370;
				$height= 270;
			}elseif($listing->listing_post_style == 9){
				$width= 350;
				$height= 240;
			}elseif($listing->listing_post_style == 10){
				$width= 370;
				$height= 260;
			}elseif($listing->listing_post_style == 11){
				$width= 270;
				$height= 220;
			}elseif($listing->listing_post_style == 12){
				$width= 270;
				$height= 220;
			}elseif($listing->listing_post_style == 13){
				$width= 270;
				$height= 270;
			}elseif($listing->listing_post_style == 14){
				$width= 290;
				$height= 190;
			}else{
				$width= 370;
				$height= 260;
			}
			
		}else{
			$width = $listing->listing_image_width;
			$height = $listing->listing_image_height;
		}
		
		$param = array(
			'width' => $width,
			'height' => $height,
			'crop' => true
		);
		//$image_src = $image_src_array[0];
	}else{
		if($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_mod'){
			$lwidth= 250;
			$lheight= 210;
				
		}else{
			$lwidth= 130;
			$lheight= 130;
		}
		$lparam = array(
			'width' => $lwidth,
			'height' => $lheight,
			'crop' => true
		);
	}
		

	/* feature ad */	
	$feature_tag_style = (isset($listing->listing_featured_tag_style) && !empty($listing->listing_featured_tag_style ))? $listing->listing_featured_tag_style : $listing->listing_post_style;				
	if($feature_tag_style == 1){
		$feature_tag = '<span class="featured-tag-1">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 2){
		$feature_tag = '<span class="featured-tag-2">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 3){
		$feature_tag = '<span class="featured-tag-3"><i class="pacz-icon-star"></i></span>';
	}elseif($feature_tag_style == 4){
		$feature_tag = '<span class="featured-tag-4"><i class="pacz-icon-star"></i></span>';
	}elseif($feature_tag_style == 5){
		$feature_tag = '<span class="featured-tag-5">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 6){
		$feature_tag = '<span class="featured-tag-6">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 7){
		$feature_tag = '<span class="featured-tag-7"><i class="pacz-icon-star"></i></span>';
	}elseif($feature_tag_style == 8){
		$feature_tag = '<span class="featured-tag-8"><i class="pacz-icon-star"></i></span>';
	}elseif($feature_tag_style == 9){
		$feature_tag = '<span class="featured-tag-9"><i class="pacz-icon-star"></i></span>';
	}elseif($feature_tag_style == 10){
		$feature_tag = '<span class="featured-tag-10">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 11){
		$feature_tag = '<span class="featured-tag-11">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 12){
		$feature_tag = '<span class="featured-tag-12">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 13){
		$feature_tag = '<span class="featured-tag-13">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 14){
		$feature_tag = '<span class="featured-tag-14">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 15){
		$feature_tag = '<span class="featured-tag-15">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 16){
		$feature_tag = '<span class="featured-tag-15">'.esc_html__('Featured', 'ALSP').'</span>';
	}elseif($feature_tag_style == 17){
		$feature_tag = '<span class="featured-tag-17">'.esc_html__('Featured', 'ALSP').'</span>';
	}			
				
/*price*/
global $term, $icon_image, $wpdb, $wpdb, $pacz_settings;
$field_ids = $wpdb->get_results('SELECT id, type, slug FROM '.$wpdb->prefix.'alsp_content_fields');	
	
if (defined('PACZ_THEME_SETTINGS')) {
	$id = uniqid();
	global $alsp_dynamic_styles;
	$alsp_styles = '';
	if($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_mod'){
		$lwidth= 250;
		$lheight= 210;
					
	}else{
		$lwidth= 130;
		$lheight= 130;
	}
$calc_content_width = $lwidth + 145;
$alsp_styles .= '
.listing-post-style-listview_default .alsp-listing-text-content-wrap,
.listing-post-style-listview_ultra .alsp-listing-text-content-wrap {
    width:calc(100% - '.$lwidth.'px);
	width: -webkit-calc(100% - '.$lwidth.'px);
    width: -moz-calc(100% - '.$lwidth.'px);
	float:left;
}
.listing-post-style-listview_mod .alsp-listing-text-content-wrap {
    width:calc(100% - '.$calc_content_width.'px);
	width: -webkit-calc(100% - '.$calc_content_width.'px);
    width: -moz-calc(100% - '.$calc_content_width.'px);
	float:left;
}
.listing-post-style-listview_default figure,
.listing-post-style-listview_ultra figure,
.listing-post-style-listview_mod figure{
	width:'.$lwidth.'px;
	
	float:left;
}
.listing-post-style-listview_mod .list-author-content-area{
	height:'.($lheight + 11).'px;
}
';
}


global $direviews_plugin;
if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
	$rating = $direviews_plugin->get_average_rating( $listing->post->ID);
}
	
 if ($listing->level->listings_own_page){ 
 $alsp_listings_own_page = 'alsp-listings-own-page';
 }else{
	$alsp_listings_own_page = ''; 
 }
 
 /* cat icon */
	if($ALSP_ADIMN_SETTINGS['cat_icon_type_on_listing'] == 3){
		$svg_class_wrap = 'svg-wrap';
	}else{
		$svg_class_wrap = '';
	}
	$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0') );
	if(is_array($terms)){
		foreach ($terms AS $key=>$term){
			if($ALSP_ADIMN_SETTINGS['cat_icon_type_on_listing'] == 1){
				if($listing->listing_post_style == 13){
					if($cat_color_set = alsp_getCategorycolor($term->term_id)){
						$cat_color = $cat_color_set;
					}elseif(isset($ALSP_ADIMN_SETTINGS['listing_cat_icon_color']['rgba']) && !empty($ALSP_ADIMN_SETTINGS['listing_cat_icon_color']['color'])){
						$cat_color = $ALSP_ADIMN_SETTINGS['listing_cat_icon_color']['rgba'];
					}else{
						global $pacz_settings;
						$cat_color = $pacz_settings['accent-color'];
					}
					$icon_file = alsp_getCategoryMarkerIcon($term->term_id);
					$icon = '<span class="font-icon" style="color:'.$cat_color.'; border-color:'.$cat_color.';"><span class="cat-icon '.$icon_file.'"></span></span>';	
					if($icon_file){
						$cat_icon =  $icon;
					}else{
						$cat_icon = '<span class="font-icon" style="color:'.$cat_color.'; border-color:'.$cat_color.';"><span class="cat-icon pacz-icon-folder-o"></span></span>';
					}
				}else{
					if($cat_color_set = alsp_getCategorycolor($term->term_id)){
						$cat_color = 'style="background-color:'.$cat_color_set.';"';
					}else{
						$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
					}
					$icon_file = alsp_getCategoryMarkerIcon($term->term_id);
					$icon = '<span class="font-icon" '.$cat_color.'><span class="cat-icon '.$icon_file.'"></span></span>';	
					if($icon_file){
						$cat_icon =  $icon;
					}else{
						$cat_icon = '<span class="font-icon" '.$cat_color.'><span class="cat-icon pacz-icon-folder-o"></span></span>';
					}
				}
				
			}elseif($ALSP_ADIMN_SETTINGS['cat_icon_type_on_listing'] == 2){
				$icon_file = alsp_getCategoryIcon2($term->term_id);
				$icon = '<img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="listing cat" />';
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}
				
			}elseif($ALSP_ADIMN_SETTINGS['cat_icon_type_on_listing'] == 3){
				if(metadata_exists('term', $term->term_id, 'category-svg-image-id' ) ) {
					$image_id = get_term_meta ($term ->term_id, 'category-svg-image-id', true );
					$image_url =  wp_get_attachment_image_src( $attachment_id = $image_id, $size = array(50, 50), $icon = false);
					$image = $image_url[0];
						$cat_icon = '<img class="svg_icon-img" src="' . $image . '" alt="'.$term->name.'" />';
				}elseif(!metadata_exists('term', $term->term_id, 'category-svg-image-id' ) ) {
					$icon_file = get_term_meta ($term->term_id, 'category-svg-icon-id', true);
					$icon = '<span class="cat-icon svg_icon">'.$icon_file.'</span>';	
					if($icon_file){
						$cat_icon =  $icon;
					}
				}else{
					$icon = 'data-icon="' . alsp_getDefaultTermIconUrl($tax) . '"';
				}
				
			}else{
				if($cat_color_set = alsp_getCategorycolor($term->term_id)){
					$cat_color = 'style="background-color:'.$cat_color_set.';"';
				}else{
					$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
				}
				$icon_file = alsp_getCategoryMarkerIcon($term->term_id);
				$icon = '<span class="font-icon" '.$cat_color.'><span class="cat-icon '.$icon_file.'"></span></span>';	
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}
			}
		}
	}
 
 /* fav icon */
 
if (alsp_checkQuickList($listing->post->ID)){
	$hear_icon = 'heart';
	$hear_icon_1 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Remove From Bookmarks', 'ALSP').'"><span class="style1 pacz-icon-heart"></span></a>';
	$hear_icon_2 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Remove From Bookmarks', 'ALSP').'"><span class="style2 checked pacz-icon-heart"></span></a>';
	$hear_icon_3 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Remove From Bookmarks', 'ALSP').'"><span class="style3 checked pacz-icon-bookmark"></span></a>';
	}else{
	$hear_icon_1 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Add To Bookmarks', 'ALSP').'"><span class="style1 pacz-icon-heart-o"></span></a>';
	$hear_icon_2 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Add To Bookmarks', 'ALSP').'"><span class="style2 unchecked pacz-icon-heart"></span></a>';
	$hear_icon_3 = '<a id="'.$listing->post->ID.'" href="javascript:void(0);" class="add_to_favourites btn" data-listingid="'.$listing->post->ID.'" title="'. esc_attr__('Add To Bookmarks', 'ALSP').'"><span class="style3 unchecked pacz-icon-bookmark-o"></span></a>';
	$hear_icon = 'heart-o';

}

/* nofollow */

	if($listing->level->nofollow){
		$nofollow = 'rel="nofollow"';
	}else{
	$nofollow = '';
	}
	
						
/* listing title */
	$title_limit = $ALSP_ADIMN_SETTINGS['max_title_length'];
	if (!$listing->level->listings_own_page){
		$listing_title = '<h2 itemprop="name">'.$listing->title().'</h2>';
	}elseif($listing->level->listings_own_page && $ALSP_ADIMN_SETTINGS['alsp_exert_type'] == 'words'){
		$listing_title = '<h2><a href="'.get_permalink().'" title="'.esc_attr($listing->title()).'" '.$nofollow.'>'.wp_trim_words($listing->title(), $title_limit, '').'</a>'.$author_verified_icon.'</h2>';
	}elseif($listing->level->listings_own_page  && $ALSP_ADIMN_SETTINGS['alsp_exert_type'] != 'words'){
		$listing_title = '<h2><a href="'.get_permalink().'" title="'.esc_attr($listing->title()).'" '.$nofollow.'>'.substr($listing->title(), 0, $title_limit).'</a>'.$author_verified_icon.'</h2>';
	}
//$public_control = new alsp_listings_controller();


$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array('parent' => '0' ) );
if(!empty($terms) && !is_wp_error($terms)){
	$term = array_pop($terms);
	$terms_childs = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array('parent' => $term->term_id ) );
	$seperator_1 = '<span class="cat-seperator pacz-icon-angle-right"></span>';
	$parent_term_1 = '<a class="listing-cat" href="'.get_term_link($term->slug, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
	
}else{
	$parent_term_1 = '';
	$seperator_1 = '';
	$terms_childs = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
}
if(!empty($terms_childs) && !is_wp_error($terms_childs)){
	$terms_child = array_pop($terms_childs);
	$child_term_1 = '<a class="listing-cat" href="'.get_term_link($terms_child->slug, ALSP_CATEGORIES_TAX).'" rel="tag">'.$terms_child->name.'</a>';
}else{
	$child_term_1 = '';
}

$output = '';
		//echo $listing_style_to_show;
		if($listing_style_to_show == 'show_grid_style'){
			if ($alsp_instance->getShortcodeProperty('alsp-main', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
					echo '<div class="alsp-remove-from-favourites-list" data-listingid="'.$listing->post->ID.'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
			}
			if($listing->listing_post_style == 1){
				// style one elca
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"><a href="'.get_permalink().'"></a></div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					if(has_term( '', ALSP_CATEGORIES_TAX ) ) {
						echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					do_action('alsp_listing_title_html', $listing);
				echo '</div>';
			}else if($listing->listing_post_style == 2){
				//style 2 emo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
				echo '</div>';
			}else if($listing->listing_post_style == 3){
				//style 3 lemo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
				echo '</div>';
				
			}else if($listing->listing_post_style == 4){
				//style 4 max
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];

					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){			
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					
				echo '</div>';
				
			}elseif($listing->listing_post_style == 5){
				// style 5 default
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
								//echo $avatar_id;
							}  else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>';
					echo '<div class="cat-wrapper">';
						echo $parent_term_1 . $seperator_1 . $child_term_1;
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					echo '<div class="listing-content-fields">';
						
						global $wpdb;
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt'){	
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
								if($field_id->type != 'excerpt' && $field_id->type != 'content' && $field_id->type != 'address' && $field_id->type != 'categories' && $field_id->type != 'price' && ($field_id->slug != 'price' || $field_id->slug != 'Price') ){			
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
					echo '</div>';
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
					echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}elseif($listing->listing_post_style == 6){
				// style 6 exo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"><a href="'.get_permalink().'"></a></div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					
				echo '</div>';
			}elseif($listing->listing_post_style == 7){
			
				//style 7 exotic
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
			}elseif($listing->listing_post_style == 8){
				//style 8 snow
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.' alsp-anim-style-6">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<figcaption>';
					echo '<a class="listing8-overlay-link" href="'.get_permalink().'"></a>';
					echo '<div class="alsp-figcaption">';
						echo '<div class="alsp-figcaption-middle">';
							echo '<ul class="alsp-figcaption-options">';
								echo '<li class="alsp-listing-figcaption-option">';
										echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
								echo '</li>';
								echo '<li class="alsp-listing-figcaption-option">';
									foreach ($listing->locations AS $location){
										echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
											if ($location->map_coords_1 && $location->map_coords_2){
												echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
											}
											echo $location->getWholeAddress_ongrid();
											if ($location->map_coords_1 && $location->map_coords_2){
												echo '</span>';
											}
										echo '</span>';
									}
								echo '</li>';
							echo '</ul>';
						echo '</div>';
					echo '</div>';
				echo '</figcaption>';
				echo '</figure>';
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){			
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
				echo '<div class="listing-bottom-content clearfix">';
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					echo '<p class="listing-views">'. sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
				echo '</div>';
			}elseif($listing->listing_post_style == 9){
				// style 9 zee
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){	
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						echo '<div class="listing_marked_as '.$no_featured.'">';
							echo '<p>' . $content . '</p>';
						echo '</div>';
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
						if(!empty($author_avatar_url)) {
							$params = array( 'width' => 60, 'height' => 60, 'crop' => true );
							echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
						}else { 
							$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
							echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
						}
						echo $author_log_status;		
					echo '</div>';
					//$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];

					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){			
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					echo '<div class="listing-ratting-icon-fields clearfix">';
						if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
							echo '<div class="listing-rating grid-rating">';
								echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
								echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
							echo '</div>';
						}
						echo '<div class="tooltip_fields clearfix">';
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo $hear_icon_2;
							}
							echo '<div id="fields-block-inline-tooltip'.$listing->post->ID.'" class="inline-tooltip-fields clearfix" data-id="'.$listing->post->ID.'">';
										$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line, options FROM '.$wpdb->prefix.'alsp_content_fields');
										foreach( $field_ids as $field_id ) {
											$singlefield_id = $field_id->id;
											if($field_id->on_exerpt_page){	
												$array = unserialize($field_id->options);
												if(isset($array['is_phone'])){
													$is_phone = $array['is_phone'];
												}else{
													$is_phone = 0;
												}
												if($field_id->type == 'website' || $field_id->type == 'email' || ($field_id->type == 'string' && $is_phone == 1)){			
													$listing->renderContentField($singlefield_id);
												}
											}
										}
							echo '</div>';
						echo '</div>';
					echo '</div>';
					if(isField_on_exerpt()){
						if(isField_inLine()){
							echo '<div id="fields-block-inline'.$listing->post->ID.'" class="grid-fields-wrapper inline-fields clearfix" data-id="'.$listing->post->ID.'">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						}
						//if(isField_inBlock()){
							echo '<div class="grid-fields-wrapper block-fields clearfix">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line == 0){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						//}
						echo '<div class="grid-exerpt-field clearfix">';
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt' && $field_id->on_exerpt_page == 1){	
									$listing->renderContentField($singlefield_id);
								}
							}
						echo '</div>';
					}
					
				echo '</div>';
				echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
								}
									echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
				echo '</p>';
			}elseif($listing->listing_post_style == 10){
				// style 10 ultra
				if ($listing->logo_image){
					echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
						echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
						
						if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
							$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
							echo '<div class="listing_marked_as '.$no_featured.'">';
								echo '<p>' . $content . '</p>';
							echo '</div>';
						}
						if ($is_featured == 'featured-ad'){
							echo $feature_tag;
						}
						if ($listing->level->sticky){
							echo '<div class="alsp-sticky-icon"></div>';
						}
					echo '</figure>';
				}
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
							} else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>';
					echo '<div class="cat-wrapper">';
							echo $parent_term_1 . $seperator_1 . $child_term_1;
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;

					echo '</header>';
					if(isField_on_exerpt()){
						if(isField_inLine()){
							echo '<div id="fields-block-inline'.$listing->post->ID.'" class="grid-fields-wrapper inline-fields clearfix" data-id="'.$listing->post->ID.'">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						}
						//if(isField_inBlock()){
							echo '<div class="grid-fields-wrapper block-fields clearfix">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line == 0){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						//}
						echo '<div class="grid-exerpt-field clearfix">';
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt' && $field_id->on_exerpt_page == 1){	
									$listing->renderContentField($singlefield_id);
								}
							}
						echo '</div>';
					}
					
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
					echo '<div class="listing-ratting-icon-fields clearfix">';
						if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
							echo '<div class="listing-rating grid-rating">';
								echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
								echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
							echo '</div>';
						}
						echo '<div class="tooltip_fields clearfix">';
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo $hear_icon_2;
							}
							echo '<div id="fields-block-inline-tooltip'.$listing->post->ID.'" class="inline-tooltip-fields clearfix" data-id="'.$listing->post->ID.'">';
										$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line, options FROM '.$wpdb->prefix.'alsp_content_fields');
										foreach( $field_ids as $field_id ) {
											$singlefield_id = $field_id->id;
											if($field_id->on_exerpt_page){	
												$array = unserialize($field_id->options);
												if(isset($array['is_phone'])){
													$is_phone = $array['is_phone'];
												}else{
													$is_phone = 0;
												}
												if($field_id->type == 'website' || $field_id->type == 'email' || ($field_id->type == 'string' && $is_phone == 1)){			
													$listing->renderContentField($singlefield_id);
												}
											}
										}
							echo '</div>';
						echo '</div>';
					echo '</div>';
					echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}elseif($listing->listing_post_style == 11){
				// style 11 Mintox
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
					echo '</div>';
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header clearfix">';
						echo '<span class="listing-cat-icon1 '.$svg_class_wrap.'">'.$cat_icon.'</span>';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
			}elseif($listing->listing_post_style == 12){
				// style 12 Solic
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
					echo '<span class="listing-cat-icon1 '.$svg_class_wrap.'">'.$cat_icon.'</span>';
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
					echo '</div>';
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
					echo '</div>';
				echo '</div>';
			}elseif($listing->listing_post_style == 13){
				// style 11 zoco
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
					echo '</div>';
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listing-content-left">';
						echo '<header class="alsp-listing-header">';
							echo $listing_title;
						echo '</header>';
						echo '<div class="cat-wrapper">';
							$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
							foreach ($terms as $term){
								echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="listing-content-right">';
						echo '<span id="post-cat-'.$listing->post->ID.'" class="listing-cat-icon1 '.$svg_class_wrap.'">'.$cat_icon.'</span>';
					echo '</div>';
				echo '</div>';
				if($ALSP_ADIMN_SETTINGS['cat_icon_type_on_listing'] == 1){
					echo '<script>
						$("#post-'.$listing->post->ID.' .listing-wrapper").hover(function(e) {
							$("#post-cat-'.$listing->post->ID.' .font-icon").css("background-color",e.type === "mouseenter"?"'.$cat_color.'":"transparent");
						});
					</script>';
				}
			}elseif($listing->listing_post_style == 14){
				// style 14 fantro
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						if(!empty($content)){
							echo '<div class="listing_marked_as '.$no_featured.'">';
								echo '<p>' . $content . '</p>';
							echo '</div>';
						}
					}
					if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
						echo '</div>';
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
							}else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );
							
							foreach ($terms2 as $term){
								
								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.substr($term->name, 0, 12).'</a>';
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					if(isField_on_exerpt()){
						if(isField_inLine()){
							echo '<div id="fields-block-inline'.$listing->post->ID.'" class="grid-fields-wrapper inline-fields clearfix" data-id="'.$listing->post->ID.'">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line){	
										if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						}
						//if(isField_inBlock()){
							echo '<div class="grid-fields-wrapper block-fields clearfix">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line == 0){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						//}
						echo '<div class="grid-exerpt-field clearfix">';
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt' && $field_id->on_exerpt_page == 1){	
									$listing->renderContentField($singlefield_id);
								}
							}
						echo '</div>';
					}
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
				echo '</div>';	
				echo '<div class="listing-bottom-metas clearfix">';
						
						//echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
						
						echo '</div>';
						
						echo '<div class="listing-ratting-icon-fields clearfix">';
							echo '<div class="tooltip_fields clearfix">';
								if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
									echo $hear_icon_2;
								}
								echo '<div id="fields-block-inline-tooltip'.$listing->post->ID.'" class="inline-tooltip-fields clearfix" data-id="'.$listing->post->ID.'">';
											$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line, options FROM '.$wpdb->prefix.'alsp_content_fields');
											foreach( $field_ids as $field_id ) {
												$singlefield_id = $field_id->id;
												if($field_id->on_exerpt_page){	
													$array = unserialize($field_id->options);
													if(isset($array['is_phone'])){
														$is_phone = $array['is_phone'];
													}else{
														$is_phone = 0;
													}
													if($field_id->type == 'website' || $field_id->type == 'email' || ($field_id->type == 'string' && $is_phone == 1)){			
														$listing->renderContentField($singlefield_id);
													}
												}
											}
								echo '</div>';
							echo '</div>';
						echo '</div>';
						//echo do_shortcode('[alike_link text="compare" preview="text" icon_class="ion-arrow-swap" parent_class="custom-css-class" post_id="'.$listing->post->ID.'"]');
				echo '</div>';
			}elseif($listing->listing_post_style == 15){
				// style Directo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						if(!empty($content)){
							echo '<div class="listing_marked_as '.$no_featured.'">';
								echo '<p>' . $content . '</p>';
							echo '</div>';
						}
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 44, 'height' => 44, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
							}else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>';
					
					echo '<header class="alsp-listing-header">';
						echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
						echo $listing_title;
					echo '</header>';
					if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
						if (!empty($rating)){
							echo '<div class="listing-rating grid-rating">';
								echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
								echo '<span class="rating-stars">'.display_average_listing_rating().'</span>';
							echo '</div>';
						}else{
							echo '<div class="listing-rating grid-rating">';
								echo '<span class="rating-numbers">'.esc_html__('N/A', 'ALSP').'</span>';
									echo '&nbsp;<span class="review_rate"></span>';
							echo '</div>';
						}
					}
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_3;
					}
					global $wpdb;
					$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'excerpt'){		
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
				echo '</div>';	
				echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-location">';
							//echo '<i class="pacz-fic3-pin-1"></i>';
							foreach ($listing->locations AS $location){
								echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
									}
									echo $location->getWholeAddress_ongrid();
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '</span>';
									}
								echo '</span>';
							}
						echo '</p>';
						//echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
						
						echo '</div>';
				echo '</div>';
			}elseif($listing->listing_post_style == 16){
				if (alsp_checkQuickList($listing->post->ID)){
					$hear_icon15 = 'bookmark';
				}else{
					$hear_icon15 = 'bookmark-o';
				}
				// style olx style
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';	
			}elseif($listing->listing_post_style == 17){
				// style 17
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. bfi_thumb($image_src, $param).'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						if(!empty($content)){
							echo '<div class="listing_marked_as '.$no_featured.'">';
								echo '<p>' . $content . '</p>';
							echo '</div>';
						}
					}
					/* if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
						echo '</div>';
					} */
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					/* echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
							}else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>'; */
					/* echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );
							
							foreach ($terms2 as $term){
								
								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.substr($term->name, 0, 12).'</a>';
							}
						}
					echo '</div>'; */
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					/* if(isField_on_exerpt()){
						if(isField_inLine()){
							echo '<div id="fields-block-inline'.$listing->post->ID.'" class="grid-fields-wrapper inline-fields clearfix" data-id="'.$listing->post->ID.'">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line){	
										if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						}
						//if(isField_inBlock()){
							echo '<div class="grid-fields-wrapper block-fields clearfix">';
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								foreach( $field_ids as $field_id ) {
									$singlefield_id = $field_id->id;
									if($field_id->on_exerpt_page && $field_id->is_field_in_line == 0){	
										if($field_id->type == 'select' || $field_id->type == 'radio'){			
											$listing->renderContentField($singlefield_id);
										}
									}
								}
							echo '</div>';
						//}
						echo '<div class="grid-exerpt-field clearfix">';
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt' && $field_id->on_exerpt_page == 1){	
									$listing->renderContentField($singlefield_id);
								}
							}
						echo '</div>';
					} */
					echo '<p class="listing-location">';
						//echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
				echo '</div>';	
				echo '<div class="listing-bottom-metas clearfix">';
				$time = strtotime( $listing->post->post_date );
					echo '<div class="publish_date">'.alsp_time_ago($time).'</div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo $hear_icon_1;
					}
						
				echo '</div>';
			}elseif($listing->listing_post_style == 'footer_widget'){
				$image_src_array_w = wp_get_attachment_image_src($listing->logo_image, 'full');
				$image_src_w = bfi_thumb($image_src_array_w[0], array(
						'width' => 150,
						'height' => 150,
						'crop' => true
					));
				// style olx style
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. pacz_thumbnail_image_gen($image_src_w, 150, 150).'" width="150" height="150" /><span class="listing-widget-hover-overlay"><i class="pacz-icon-share"></i></span></a>';
				echo '</figure>';
			}
		}elseif($listing_style_to_show == 'show_list_style'){
			if ($alsp_instance->getShortcodeProperty('alsp-main', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
					echo '<div class="alsp-remove-from-favourites-list" data-listingid="'.$listing->post->ID.'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
			}
			if($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_default'){
				// style list default
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'.bfi_thumb($image_src, $lparam).'" width="'.$lwidth.'" height="'.$lheight.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){			
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
						echo '<div class="listing-metas clearfix">';
							echo '<p class="listing-location">';
								echo '<i class="pacz-fic3-pin-1"></i>';
								foreach ($listing->locations AS $location){
									echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
										}
											echo $location->getWholeAddress_ongrid();
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '</span>';
										}
									echo '</span>';
								}
							echo '</p>';
							echo '<em class="alsp-listing-date" itemprop="dateCreated" datetime="'.date("Y-m-d", mysql2date('U', $listing->post->post_date)).'T'.date("H:i", mysql2date('U', $listing->post->post_date)).'"><i class="pacz-fic3-clock-circular-outline"></i>'. get_the_date().'</em>';
							echo '<p class="listing-views"><i class="pacz-fic3-medical"></i>'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo $hear_icon_1;
							}
						echo '</div>';
					echo '</header>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'){
				// style list Ultra
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					
					
				echo '</figure>';
	
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
						echo '<div class="listing-location">';
							echo $parent_term_1 . $seperator_1 . $child_term_1;
						echo '</div>';
							$aa = [];
						$aa = $wpdb->get_results('SELECT meta_value FROM wp_postmeta WHERE post_id='.$listing->post->ID.' AND meta_key="_content_field_86"');
													echo $aa[0]->meta_value;
						
						$bb = [];
						$bb = $wpdb->get_results('SELECT meta_value FROM wp_postmeta WHERE post_id='.$listing->post->ID.' AND meta_key="_content_field_88"');
													echo $bb[0]->meta_value;
						$cc = [];
						$cc = $wpdb->get_results('SELECT meta_value FROM wp_postmeta WHERE post_id='.$listing->post->ID.' AND meta_key="_content_field_93"');
													echo $cc[0]->meta_value;
				
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}				
						}
					echo '</div>';
				
				
				
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
							echo '<div >';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								echo '<div class="list-exerpt-field clearfix">';
									foreach( $field_ids as $field_id ) {
										$singlefield_id = $field_id->id;
										if($field_id->type == 'excerpt' && $field_id->on_exerpt_page_list == 1){	
											$listing->renderContentField($singlefield_id);
										}
									}
								echo '</div>';
						echo '<div>';
				
									echo '<div class="list-fields-wrapper block-fields clearfix>';
									$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
									foreach( $field_ids as $field_id ) {
										$singlefield_id = $field_id->id;
										if($field_id->on_exerpt_page_list && $field_id->is_field_in_line == 0){	
											// if($field_id->type == 'datetime'){			
											// 	$listing->renderContentField($singlefield_id);
											// }
											if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){
												if($field_id->type == 'select' && $field_id->id == 92){			
													$listing->renderContentField($singlefield_id);
												}			
												// $listing->renderContentField($singlefield_id);
											}
										}
									}
									echo '</div>';
				echo '</div>';
				
				
						echo '<div class="listing-metas clearfix">';
							echo '<p class="listing-location">';
								echo '<i class="pacz-fic3-pin-1"></i>';
								foreach ($listing->locations AS $location){
									echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
										}
											echo $location->getWholeAddress_ongrid();
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '</span>';
										}
									echo '</span>';
								}
							echo '</p>';
							echo '<em class="alsp-listing-date" itemprop="dateCreated" datetime="'.date("Y-m-d", mysql2date('U', $listing->post->post_date)).'T'.date("H:i", mysql2date('U', $listing->post->post_date)).'"><i class="pacz-fic3-clock-circular-outline"></i>'. get_the_date().'</em>';
							echo '<p class="listing-views"><i class="pacz-fic3-medical"></i>'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
							
						echo '</div>';
					echo '</header>';
				echo '</div>';
				echo '<div style="padding-top:30px;width:100px;" align="center" class="listng-author-img">';
				
					echo '<div class="list-fields-wrapper block-fields clearfix">';
					$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
					foreach( $field_ids as $field_id ) {
						$singlefield_id = $field_id->id;
						if($field_id->on_exerpt_page_list && $field_id->is_field_in_line == 0){	
							if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){
								if($field_id->type == 'select' && $field_id->id != 92){			
									$listing->renderContentField($singlefield_id);
								}			
								// $listing->renderContentField($singlefield_id);
							}
							if($field_id->type == 'datetime'){			
								$listing->renderContentField($singlefield_id);
							}
						}
					}
					echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_mod'){
				// style list Mod
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'.bfi_thumb($image_src, $lparam).'" width="'.$lwidth.'" height="'.$lheight.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo $feature_tag;
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					
				echo '</figure>';
	
					echo '<div class="clearfix alsp-listing-text-content-wrap">';
						echo '<div class="clearfix mod-inner-content">';
							echo '<div class="cat-wrapper">';
								echo $parent_term_1 . $seperator_1 . $child_term_1;
							echo '</div>';
					
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo $hear_icon_1;
							}
							echo '<header class="alsp-listing-header">';
								echo $listing_title;
							echo '</header>';
							if(isField_on_exerpt_list()){
								$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
								echo '<div class="list-exerpt-field clearfix">';
									foreach( $field_ids as $field_id ) {
										$singlefield_id = $field_id->id;
										if($field_id->type == 'excerpt' && $field_id->on_exerpt_page_list == 1){	
											$listing->renderContentField($singlefield_id);
										}
									}
								echo '</div>';
								if(isField_inLine()){
									echo '<div id="fields-block-inline'.$listing->post->ID.'" class="list-fields-wrapper inline-fields clearfix" data-id="'.$listing->post->ID.'">';
										$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
										foreach( $field_ids as $field_id ) {
											$singlefield_id = $field_id->id;
											if($field_id->on_exerpt_page_list && $field_id->is_field_in_line){	
												if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){			
													$listing->renderContentField($singlefield_id);
												}
											}
										}
									echo '</div>';
								}
								if(isField_inBlock()){
									echo '<div class="list-fields-wrapper block-fields clearfix">';
										$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page_list, is_field_in_line FROM '.$wpdb->prefix.'alsp_content_fields');
										foreach( $field_ids as $field_id ) {
											$singlefield_id = $field_id->id;
											if($field_id->on_exerpt_page_list && $field_id->is_field_in_line == 0){	
												if($field_id->type == 'select' || $field_id->type == 'radio' || $field_id->type == 'number'){			
													$listing->renderContentField($singlefield_id);
												}
											}
										}
									echo '</div>';
								}
							}
							echo '<p class="listing-location">';
								echo '<i class="pacz-fic3-pin-1"></i>';
								foreach ($listing->locations AS $location){
									echo '<span class="alsp-location"  itemscope itemtype="http://schema.org/PostalAddress">';
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
										}
											echo $location->getWholeAddress_ongrid();
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '</span>';
										}
									echo '</span>';
								}
							echo '</p>';
						echo '</div>';	
					echo '<div class="modlist-bottom-area clearfix">';
						// rattings
						if($ALSP_ADIMN_SETTINGS['alsp_ratings_addon']){
								echo '<div class="listing-rating grid-rating">';
									echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
									echo '<span class="rating-stars">'.display_average_listing_rating().'</span>';
								echo '</div>';
						}
						// price
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){				
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}				
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="list-author-content-area">';
					echo '<div class="listng-author-img">';
							if(!empty($author_avatar_url)) {
								$params = array( 'width' => 44, 'height' => 44, 'crop' => true );
								echo "<img class='pacz-user-avatar' src='" . bfi_thumb($src, $params ) . "' alt='author' />";
							}else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';		
							}
							echo $author_log_status;		
					echo '</div>';
					echo '<div class="listng-author-name">';
						echo  the_author_meta( 'display_name', $authorID );
					echo '</div>';
					echo '<div class="listng-author-url-link">';
						echo  '<a href="'.get_author_posts_url($authorID).'">'.esc_html__('see all ads', 'ALSP').'</a>';
					echo '</div>';
					echo '<div class="listng-author-url">';
						echo  '<a href="'.get_author_posts_url($authorID).'">'.esc_html__('contacts', 'ALSP').'</a>';
					echo '</div>';
				echo '</div>';
			}else{
				
			}
		}
		
	// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
echo '</div>';
?>
<style>
span.alsp-field-content.content-multi {
    display: inline-block;
    padding: 0 0px;
    margin: 0 15px;
    padding-left: 0;
    margin-left: 0;
    border-bottom: 1px solid white;
}
</style>
<?php

// Export styles to json for faster page load
$alsp_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $alsp_styles
);
		
