<?php 
class alsp_terms_view {
	public $attrs;
	public $depth;
	public $columns;
	public $hide_empty;
	public $count;
	public $max_subterms;
	public $exact_terms = array();
	public $exact_terms_obj = array();
	public $col_md;
	public $tax;
	public $terms_icons_url;
	public $grid;
	public $grid_view;
	public $icons;
	public $menu;
	public $view_all_terms;
	public $directory;
	
	public function __construct($params) {
		$this->attrs = array_merge(array(
				'directory' => 0,
				'parent' => 0,
				'depth' => 2,
				'columns' => 2,
				'count' => true,
				'hide_empty' => false,
				'max_subterms' => 0,
				'exact_terms' => array(),
				'grid' => 0,
				'grid_view' => 0,
				'icons' => 1,
				'subcats' =>  0,
				'cat_style' =>  1,
				'cat_icon_type' =>  1,
				'scroll' =>  0,
				'desktop_items' =>  3,
				'tab_landscape_items' =>  3,
				'tab_items' =>  2,
				'autoplay' =>  true,
				'loop' =>  true,
				'owl_nav' =>  'false',
				'delay' =>  1000,
				'autoplay_speed' =>  1000,
				'gutter' =>  30,
				'allowed_levels' =>  array(),
				'exact_categories' =>  array(),
				'cat_font_size' =>  '',
				'cat_font_weight' =>  '',
				'cat_font_line_height' =>  '',
				'cat_font_transform' =>  '',
				'child_cat_font_size' =>  '',
				'child_cat_font_weight' =>  '',
				'child_cat_font_line_height' =>  '',
				'child_cat_font_transform' =>  '',
				'parent_cat_title_color' =>  '',
				'parent_cat_title_color_hover' =>  '',
				'parent_cat_title_bg' =>  '',
				'parent_cat_title_bg_hover' =>  '',
				'subcategory_title_color' =>  '',
				'subcategory_title_color_hover' =>  '',
				'cat_bg' =>  '',
				'cat_bg_hover' =>  '',
				'cat_border_color' =>  '',
				'cat_border_color_hover' =>  '',
				'location_style' => 0,
				'location_bg' => '#333',
				'location_bg_image' => '',
				'gradientbg1' => '',
				'gradientbg2' => '',
				'opacity1' => '',
				'opacity2' => '',
				'gradient_angle' => '',
				'location_width' => 30,
				'location_height' => 300,
				'location_padding' => 15
		), $params);

		$this->directory = $this->attrs['directory'];
		if (is_numeric($this->attrs['parent'])) {
			$this->parent = $this->attrs['parent'];
		} else {
			$term_obj = get_term_by('slug', $this->attrs['parent'], $this->tax);
			if(!empty($term_obj)){
				$this->parent = $term_obj->term_id;
			}else{
				$this->parent = 0;
			}
		}
		$this->args['id'] = alsp_generateRandomVal();
		$this->depth = $this->attrs['depth'];
		$this->columns = $this->attrs['columns'];
		$this->count = $this->attrs['count'];
		$this->hide_empty = $this->attrs['hide_empty'];
		$this->max_subterms = $this->attrs['max_subterms'];
		$this->grid = $this->attrs['grid'];
		$this->grid_view = $this->attrs['grid_view'];
		$this->icons = $this->attrs['icons'];
		//$this->menu = $this->attrs['menu'];
		
		$this->cat_style = $this->attrs['cat_style'];
		$this->cat_icon_type = $this->attrs['cat_icon_type'];
		$this->scroll = $this->attrs['scroll'];
		$this->desktop_items = $this->attrs['desktop_items'];
		$this->tab_landscape_items = $this->attrs['tab_landscape_items'];
		$this->tab_items = $this->attrs['tab_items'];
		$this->autoplay = $this->attrs['autoplay'];
		$this->loop = $this->attrs['loop'];
		$this->owl_nav = $this->attrs['owl_nav'];
		$this->delay = $this->attrs['delay'];
		$this->autoplay_speed = $this->attrs['autoplay_speed'];
		$this->gutter = $this->attrs['gutter'];
		$this->allowed_levels = $this->attrs['allowed_levels'];
		$this->exact_categories = $this->attrs['exact_categories'];
		$this->cat_font_size = $this->attrs['cat_font_size'];
		$this->cat_font_weight = $this->attrs['cat_font_weight'];
		$this->cat_font_line_height = $this->attrs['cat_font_line_height'];
		$this->cat_font_transform = $this->attrs['cat_font_transform'];
		$this->child_cat_font_size = $this->attrs['child_cat_font_size'];
		$this->child_cat_font_weight = $this->attrs['child_cat_font_weight'];
		$this->child_cat_font_line_height = $this->attrs['child_cat_font_line_height'];
		$this->child_cat_font_transform = $this->attrs['child_cat_font_transform'];
		$this->parent_cat_title_color = $this->attrs['parent_cat_title_color'];
		$this->parent_cat_title_color_hover = $this->attrs['parent_cat_title_color_hover'];
		$this->parent_cat_title_bg = $this->attrs['parent_cat_title_bg'];
		$this->parent_cat_title_bg_hover = $this->attrs['parent_cat_title_bg_hover'];
		$this->subcategory_title_color = $this->attrs['subcategory_title_color'];
		$this->subcategory_title_color_hover = $this->attrs['subcategory_title_color_hover'];
		$this->cat_bg = $this->attrs['cat_bg'];
		$this->cat_bg_hover = $this->attrs['cat_bg_hover'];
		$this->cat_border_color = $this->attrs['cat_border_color'];
		$this->cat_border_color_hover = $this->attrs['cat_border_color_hover'];
				
		$this->location_style = $this->attrs['location_style'];		
		$this->location_bg = $this->attrs['location_bg'];
		$this->location_bg_image = $this->attrs['location_bg_image'];
		$this->gradientbg1 = $this->attrs['gradientbg1'];
		$this->gradientbg2 = $this->attrs['gradientbg2'];
		$this->opacity1 = $this->attrs['opacity1'];
		$this->opacity2 = $this->attrs['opacity2'];
		$this->gradient_angle = $this->attrs['gradient_angle'];
		$this->location_width = $this->attrs['location_width'];
		$this->location_height = $this->attrs['location_height'];
		$this->location_padding = $this->attrs['location_padding'];
		
		
		if (is_array($this->attrs['exact_terms']) && !empty($this->attrs['exact_terms'])) {
			foreach ($this->attrs['exact_terms'] AS $term) {
				if (is_numeric($term)) {
					if ($term_obj = get_term_by('id', $term, $this->tax)) {
						$this->exact_terms[] = $term_obj->term_id;
						$this->exact_terms_obj[] = $term_obj;
					}
				} else {
					if ($term_obj = get_term_by('slug', $term, $this->tax)) {
						$this->exact_terms[] = $term_obj->term_id;
						$this->exact_terms_obj[] = $term_obj;
					}
				}
			}
		}
		
		if ($this->attrs['depth'] > 2) {
			$this->depth = 2;
		}
		if ($this->depth == 0 || !is_numeric($this->depth)) {
			$this->depth = 1;
		}
		if ($this->columns > 6) {
			$this->columns = 6;
		}
		if ($this->columns == 0 || !is_numeric($this->columns || $this->cat_style == 4 || $this->cat_style == 9)) {
			$columns = 'inline';
		}
		//$this->col_md = 12/$this->columns;
	}
	
	public function getTerms($parent) {
		// we use array_merge with empty array because we need to flush keys in terms array
		//if ($this->count) {
			$terms = array_merge(
					// there is a wp bug with pad_counts in get_terms function - so we use this construction
					wp_list_filter(
							get_categories(array(
									'taxonomy' => $this->tax,
									'pad_counts' => true,
									'hide_empty' => $this->hide_empty,
									'include' => $this->exact_terms,
							)),
							array('parent' => $parent)
					), array());
		/* } else {
			$terms = array_merge(
					get_categories(array(
							'taxonomy' => $this->tax,
							'pad_counts' => true,
							'hide_empty' => $this->hide_empty,
							'parent' => $parent,
							'include' => $this->exact_terms,
					)), array());
		} */
		
		return $terms;
	}
	
	public function getCount($term) {
		if ($this->exact_terms) {
			$q = new WP_Query(array(
					'nopaging' => true,
					'tax_query' => array(
							array(
									'taxonomy' => $this->tax,
									'field' => 'id',
									'terms' => $term->term_id,
									'include_children' => true,
							),
					),
					'fields' => 'ids',
			));
			$terms_count = $q->post_count;
		} else {
			$terms_count = $term->count;
		}

		return $terms_count;
	}
	
	public function getWrapperClasses() {
		$classes[] = "alsp-content";
		$classes[] = $this->wrapper_classes;
		$classes[] = "alsp-terms-columns-" . $this->columns;
		if ($this->menu) {
			$classes[] = "alsp-terms-menu";
		}
		if ($this->grid) {
			$classes[] = $this->grid_classes;
		}
		$classes[] = "alsp-terms-depth-" . $this->depth;
		
		return implode(' ', $classes);
	}
	

	

	public function renderTermCount($term) {
		
		if ($this->count) {
			if ($this->attrs['cat_style'] == 5){
				$term_count = $this->getCount($term).' '. esc_html__('Tenders', 'ALSP');
			}elseif($this->attrs['cat_style'] == 6){
				$term_count = $this->getCount($term);
			}else{
				$term_count = ' ('.$this->getCount($term).')';
			}
		}else{
			$term_count = '';
		}
		return $term_count;
	}
	
	public function display() {
		global $alsp_directory_flag;
		if ($this->directory) {
			$alsp_directory_flag = $this->directory;
		}
		
		$terms = $this->getTerms($this->parent);
		
		if (!$terms && $this->exact_terms && (get_terms($this->tax, array('hide_empty' => false, 'parent' => $this->parent)))) {
			$terms = $this->exact_terms_obj;
		}

		if ($terms && $this->tax == ALSP_CATEGORIES_TAX) {
			echo '<div id="alsp-category-'.$this->args['id'].'" class="cat-style-'.$this->cat_style.' alsp-content alsp-categories-columns alsp-categories-columns-' . $this->columns . '">';
			
				$terms_count = count($terms);
				$terms_number = count($terms);
				$counter = 0;
				$tcounter = 0;
				if($this->scroll == 1){
					$scroll_attr = 'data-items="'.$this->desktop_items.'" data-items-1024="'. $this->tab_landscape_items.'" data-items-768="'. $this->tab_items.'" data-autoplay="'.$this->autoplay.'" data-loop="'.$this->loop.'" data-arrow="'.$this->owl_nav.'" data-delay="'.$this->delay.'" data-autoplay-speed="'.$this->autoplay_speed.'" data-gutter="'.$this->gutter.'"';
					$scroll_class = 'slick-carousel';
				}else{
					$scroll_attr = '';
					$scroll_class = '';
				}
				
				
				echo '<div class="alsp-categories-row '.$scroll_class.' '. (($this->attrs['columns'] == 1) ? 'alsp-categories-row-one-column': '') . ' clearfix" '.$scroll_attr.'>';
				
				
					foreach ($terms AS $key=>$term) {
					$tcounter++;
				
						if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
							$more_cat_icon = '<i class="pacz-fic4-more" data-popup-open="' . $term->term_id .'"></i>';
						}else{
							$more_cat_icon = '';
						}
				 
						
							// term wrapper
							echo '<div class="alsp-categories-column alsp-categories-column-' . $this->attrs['columns'] . '">';
						
								echo '<div id="cat-wrapper-'.$term->term_id.'" class="alsp-categories-column-wrapper clearfix">';		
									if ($this->cat_style == 1){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 2){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 3){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 4){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'</a></div>';
									}elseif ($this->cat_style == 5){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). $more_cat_icon.'</span></a></div>';
									}elseif ($this->cat_style == 6){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 7){
										if($cat_color_set = alsp_getCategorycolor($term->term_id)){
											$cat_color = $cat_color_set;
										}else{
											global $pacz_settings;
											$cat_color = $pacz_settings['accent-color'];
										}
										echo '<div class="cat-7-icon" id="cat-'.$term->term_id.'" style="border-color:'.$cat_color.'">' . $this->termIcon($term->term_id) .'</div>';
										echo '<div class="cat-7-content">';
											echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '"><span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
											echo $this->_display($term->term_id, 1);
										echo '</div>';
										echo '<script>
											$("#cat-wrapper-'.$term->term_id.'").hover(function(e) {
												$("#cat-'.$term->term_id.'").css("background-color",e.type === "mouseenter"?"'.$cat_color.'":"transparent");
											});
										</script>';
									}elseif ($this->cat_style == 8){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 9){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'</a></div>';
									}elseif ($this->cat_style == 10){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $term->name .'</a></div>';
									}elseif ($this->cat_style == 11){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}
									if ($this->cat_style == 3 || $this->cat_style == 4 || $this->cat_style == 6 || $this->cat_style == 10){
										echo $this->_display($term->term_id, 1);
									}
								echo '</div>';
						
								/* -----Start popup----*/
								if ($this->cat_style == 3 || $this->cat_style == 4 || $this->cat_style == 5 || $this->cat_style == 6 || $this->cat_style == 7 || $this->cat_style == 10){
									echo '<div class="alsp-custom-popup" data-popup="' . $term->term_id . '">';
										echo '<div class="alsp-custom-popup-inner">';
											echo '<div class="sub-level-cat"><div class="categories-title">'.esc_html__('Select your Department', 'ALSP').'<a class="alsp-custom-popup-close" data-popup-close="' . $term->term_id . '" href="#"><i class="pacz-fic4-error"></i></a></div><ul class="cat-sub-main-ul clearfix">';
											
												wp_list_categories( array(
													'orderby'            => 'name',
													'show_count'         => true,
													'use_desc_for_title' => false,
													'child_of'           => $term->term_id,
													'hide_empty' => false,
													'taxonomy'           => ALSP_CATEGORIES_TAX,
													'title_li' => ''
												) ); 
												 
											echo '</ul></div>';
										echo '</div>';
									echo '</div>';
								}
								/* -----End popup----*/
							echo '</div>';
					
						$counter++;
					
						//if ($counter == $this->columns || ($tcounter == $terms_number && $counter != $this->columns) && $this->scroll == 0){
							//echo '</<div>';
						//}
						if ($counter == $this->columns) {
							$counter = 0;
						}
				
					}
				//if($this->scroll == 1){
					echo '</div>';
				//}
			
			echo '</div>';
		
			$this->getDynamicStyles($term->term_id);
	
		}elseif ($terms && $this->tax == ALSP_TYPE_TAX) {
			echo '<div id="alsp-category-'.$this->args['id'].'" class="cat-style-'.$this->cat_style.' alsp-content alsp-categories-columns alsp-categories-columns-' . $this->columns . '">';
			
				$terms_count = count($terms);
				$terms_number = count($terms);
				$counter = 0;
				$tcounter = 0;
				if($this->scroll == 1){
					$scroll_attr = 'data-items="'.$this->desktop_items.'" data-items-1024="'. $this->tab_landscape_items.'" data-items-768="'. $this->tab_items.'" data-autoplay="'.$this->autoplay.'" data-loop="'.$this->loop.'" data-arrow="'.$this->owl_nav.'" data-delay="'.$this->delay.'" data-autoplay-speed="'.$this->autoplay_speed.'" data-gutter="'.$this->gutter.'"';
					$scroll_class = 'slick-carousel';
				}else{
					$scroll_attr = '';
					$scroll_class = '';
				}
				
				
				echo '<div class="alsp-categories-row '.$scroll_class.' '. (($this->attrs['columns'] == 1) ? 'alsp-categories-row-one-column': '') . ' clearfix" '.$scroll_attr.'>';
				
				
					foreach ($terms AS $key=>$term) {
					$tcounter++;
				
						if ( count( get_term_children( $term->term_id, ALSP_TYPE_TAX ) ) > 0 ) {
							$more_cat_icon = '<i class="pacz-fic4-more" data-popup-open="' . $term->term_id .'"></i>';
						}else{
							$more_cat_icon = '';
						}
				 
						
							// term wrapper
							echo '<div class="alsp-categories-column alsp-categories-column-' . $this->attrs['columns'] . '">';
						
								echo '<div id="cat-wrapper-'.$term->term_id.'" class="alsp-categories-column-wrapper clearfix">';		
									if ($this->cat_style == 1){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 2){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 3){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 4){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'</a></div>';
									}elseif ($this->cat_style == 5){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'<span class="categories-count">'.$this->renderTermCount($term). $more_cat_icon.'</span></a></div>';
									}elseif ($this->cat_style == 6){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 7){
										if($cat_color_set = alsp_getCategorycolor($term->term_id)){
											$cat_color = $cat_color_set;
										}else{
											global $pacz_settings;
											$cat_color = $pacz_settings['accent-color'];
										}
										echo '<div class="cat-7-icon" id="cat-'.$term->term_id.'" style="border-color:'.$cat_color.'">' . $this->termIcon($term->term_id) .'</div>';
										echo '<div class="cat-7-content">';
											echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '"><span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
											echo $this->_display($term->term_id, 1);
										echo '</div>';
										echo '<script>
											$("#cat-wrapper-'.$term->term_id.'").hover(function(e) {
												$("#cat-'.$term->term_id.'").css("background-color",e.type === "mouseenter"?"'.$cat_color.'":"transparent");
											});
										</script>';
									}elseif ($this->cat_style == 8){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) .'<span class="categories-name" style="line-height:40px;">'. $term->name .'</span><span class="categories-count">'.$this->renderTermCount($term). '</span></a></div>';
									}elseif ($this->cat_style == 9){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $this->termIcon($term->term_id) . $term->name .'</a></div>';
									}elseif ($this->cat_style == 10){
										echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $term->name .'</a></div>';
									}
									if ($this->cat_style == 3 || $this->cat_style == 4 || $this->cat_style == 6 || $this->cat_style == 10){
										echo $this->_display($term->term_id, 1);
									}
								echo '</div>';
						
								/* -----Start popup----*/
								if ($this->cat_style == 3 || $this->cat_style == 4 || $this->cat_style == 5 || $this->cat_style == 6 || $this->cat_style == 7){
									echo '<div class="alsp-custom-popup" data-popup="' . $term->term_id . '">';
										echo '<div class="alsp-custom-popup-inner">';
											echo '<div class="sub-level-cat"><div class="categories-title">'.esc_html__('Select your Category', 'ALSP').'<a class="alsp-custom-popup-close" data-popup-close="' . $term->term_id . '" href="#"><i class="pacz-fic4-error"></i></a></div><ul class="cat-sub-main-ul clearfix">';
											
												wp_list_categories( array(
													'orderby'            => 'name',
													'show_count'         => true,
													'use_desc_for_title' => false,
													'child_of'           => $term->term_id,
													'hide_empty' => false,
													'taxonomy'           => ALSP_TYPE_TAX,
													'title_li' => ''
												) ); 
												 
											echo '</ul></div>';
										echo '</div>';
									echo '</div>';
								}
								/* -----End popup----*/
							echo '</div>';
					
						$counter++;
					
						//if ($counter == $this->columns || ($tcounter == $terms_number && $counter != $this->columns) && $this->scroll == 0){
							//echo '</<div>';
						//}
						if ($counter == $this->columns) {
							$counter = 0;
						}
				
					}
				//if($this->scroll == 1){
					echo '</div>';
				//}
			
			echo '</div>';
		
			$this->getDynamicStyles($term->term_id);
			
		}elseif ($terms && $this->tax == ALSP_LOCATIONS_TAX) {
			$terms_count = count($terms);
			$terms_number = count($terms);
			$counter = 0;
			$tcounter = 0;
			if($this->location_style == 4  || $this->location_style == 8 || $this->location_style == 9){
				$gutter = 'margin: 0 -15px;';
				//$gutter_padding = '0;';
			}else{
				$gutter = 'padding:'.$this->location_padding.'px;';
				//$padding = ($this->location_padding * 2).'px;';
				//$gutter_padding = 'padding:'.$padding;
			}
			echo '<div id="loaction-styles'.$this->args['id'].'" class="location-style'.$this->location_style.' grid-item alsp-locations-columns alsp-locations-columns-' . $this->columns . ' clearfix"  style="'.$gutter.'">';
			
				foreach ($terms AS $key=>$term) {
					$tcounter++;
					
					//if ($counter == 0)
						
					if ($this->count && $this->location_style != 2){
						$term_count = ' ('.$this->getCount($term).')';
					}elseif ($this->count ){
						$term_count = $this->getCount($term);
					}else{
						$term_count = '';
					}
					
					if ($icon_file = alsp_getLocationIcon($term->term_id)){
						if($this->location_style == 7){
							$icon_image = '';
						}else{
							$icon_image = '<span class="location-icon"><i class="pacz-icon-map-marker"></i></span>';
						}
					}else{
							$icon_image = '<span class="location-icon"><i class="pacz-icon-map-marker"></i></span>';
					}
					
					echo '<div class="alsp-locations-column-wrapper">';
					if($this->location_style == 10){
						echo '<div class="alsp-locations-column-holder">';
					}
					if($this->location_style == 0){
						echo '<div class="alsp-locations-column-wrapper-inner" style="">';
					}else{
						echo '<div class="alsp-locations-column-wrapper-inner" style=""><i class="location-plus-icon pacz-fic4-more" data-popup-open="' . $term->term_id . '"></i>';
					}
					if($this->location_style == 1){
						echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
					} elseif($this->location_style == 2 || $this->location_style == 3){
						echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '"><span class="location-count">'.$term_count . esc_html__(' ads', 'alsp').'</span><span class="loaction-name">' . $icon_image . $term->name .'</span></a></div>';
					}elseif($this->location_style == 4){
						echo '<div class="alsp-locations-root">';
							echo '<a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '"><span class="loaction-name">' . $icon_image . $term->name .'</span><span class="location-count">'.$term_count.'</span></a>';
							echo $this->_display($term->term_id, 1);
						echo '</div>';
					}else{
						echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
					}
					echo '<div class="alsp-custom-popup" data-popup="' . $term->term_id . '">';
								echo '<div class="alsp-custom-popup-inner">';
									echo '<div class="sub-level-cat"><div class="categories-title">'.esc_html__('Select your Location', 'ALSP').'<a class="alsp-custom-popup-close" data-popup-close="' . $term->term_id . '" href="#"><i class="pacz-fic4-error"></i></a></div><ul class="loc-sub-main-ul clearfix">';
										
											wp_list_categories( array(
												'orderby' => 'name',
												'show_count' => true,
												'use_desc_for_title' => false,
												'child_of' => $term->term_id,
												'hide_empty' => false,
												'taxonomy' => ALSP_LOCATIONS_TAX,
												'title_li' => ''
											) ); 
											 
									echo '</ul>';
								echo '</div>';
								
							echo '</div>';
					echo '</div>';
					if($this->location_style != 4){
						echo $this->_display($term->term_id, 1);
					}
					
					echo '</div>';
					if($this->location_style == 10){
						echo '</div>';
					}
					echo '</div>';
					
		
					$counter++;
					//if ($counter == $this->columns)
					
					/*if ($tcounter == $terms_count && $counter != $this->columns) {
						while ($counter != $this->columns) {
							echo '<div class="alsp-locations-column alsp-locations-column-' . $this->columns . ' alsp-locations-column-hidden"></div>';
							$counter++;
						}
						echo '</div>';
						
					}*/
					if ($counter == $this->columns) {
						$counter = 0;
					}
				
			}
			echo '</div>';
				
			
			
			$this->getDynamicStyles($term->term_id);
		}
		
		$alsp_directory_flag = 0;
	}
	
	function _display($parent, $depth_level) {
		$html = '';
		if ($this->depth == 0 || !is_numeric($this->depth) || $this->depth > $depth_level) {
			$terms = $this->getTerms($parent);
			if ($terms && $this->tax == ALSP_CATEGORIES_TAX) {
				$depth_level++;
				$counter = 0;
				$html .= '<div class="subcategories">';
					$html .= '<ul>';
					foreach ($terms AS $term) {
							if ($this->count){
								$term_count = ' ('.$this->getCount($term).')';
							}else{
								$term_count = '';
							}
							
							if ($this->icons && $icon_url = $this->getTermIconFile($term->term_id)) {
								$icon_image = '<img class="alsp-field-icon" src="' . $icon_url . '" />';
							} else {
								$icon_image = '';
							}
							$counter++;
							if($this->cat_style == 6){
								if ($this->max_subterms != 0 && $counter > $this->max_subterms) {
									$html .= '<li style="line-height:25px;">';
									$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all Departments', 'ALSP') .'</a>';
									$html .= '</li>';
									break;
								} else{
									  if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
									/* pacz customized*/
									$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
										
									$html .='</li>';
									  }else{
										$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
									  }
								}
							}else{
								if ($this->max_subterms != 0 && $counter > $this->max_subterms) {
									$html .= '<li>';
									$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all Departments', 'ALSP') .'</a>';
									$html .= '</li>';
									break;
								} else{
									  if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
									/* pacz customized*/
									$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
										
									$html .='</li>';
									  }else{
										$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
									  }
								}
							}
						
					}
					$html .= '</ul>';
						
					$html .= '</div>';
			}elseif ($terms && $this->tax == ALSP_TYPE_TAX) {
				$depth_level++;
				$counter = 0;
				$html .= '<div class="subcategories">';
					$html .= '<ul>';
					foreach ($terms AS $term) {
							if ($this->count){
								$term_count = ' ('.$this->getCount($term).')';
							}else{
								$term_count = '';
							}
							
							if ($this->icons && $icon_url = $this->getTermIconFile($term->term_id)) {
								$icon_image = '<img class="alsp-field-icon" src="' . $icon_url . '" />';
							} else {
								$icon_image = '';
							}
							$counter++;
							if($this->cat_style == 6){
								if ($this->max_subterms != 0 && $counter > $this->max_subterms) {
									$html .= '<li>';
									$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all Types', 'ALSP') .'</a>';
									$html .= '</li>';
									break;
								} else{
									  if ( count( get_term_children( $term->term_id, ALSP_TYPE_TAX ) ) > 0 ) {
									/* pacz customized*/
									$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
										
									$html .='</li>';
									  }else{
										$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
									  }
								}
							}else{
								if ($this->max_subterms != 0 && $counter > $this->max_subterms) {
									$html .= '<li>';
									$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all', 'ALSP') .'</a>';
									$html .= '</li>';
									break;
								} else{
									  if ( count( get_term_children( $term->term_id, ALSP_TYPE_TAX ) ) > 0 ) {
									/* pacz customized*/
									$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
										
									$html .='</li>';
									  }else{
										$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
									  }
								}
							}
						
					}
					$html .= '</ul>';
						
					$html .= '</div>';
			}elseif ($terms && $this->tax == ALSP_LOCATIONS_TAX) {
			
				if ($this->depth == 0 || !is_numeric($this->depth) || $this->depth > $depth_level) {
					$depth_level++;
					$counter = 0;
					
					$html .= '<div class="sublocations">';
					$html .= '<ul>';
					foreach ($terms AS $term) {
						
							if ($this->count){
								$term_count = ' ('.$this->getCount($term).')';
							}else{
								$term_count = '';
							}
							
							if ($this->icons && $icon_url = $this->getTermIconFile($term->term_id)) {
								$icon_image = '<img class="alsp-field-icon" src="' . $icon_url . '" />';
							} else {
								$icon_image = '';
							}
							
							$counter++;
							if ($this->max_subterms != 0 && $counter > $this->max_subterms) {
								$html .= '<li><a href="' . get_term_link(intval($parent), ALSP_LOCATIONS_TAX) . '">' . __('View All Locations', 'ALSP') . '</a></li>';
								break;
							} else
								$html .= '<li style="line-height:25px;"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name . $term_count . '</a></li>';
						
					}
					$html .= '</ul>';
					$html .= '</div>';
				}
			
			
			}
		}
		return $html;
	}
}

class alsp_categories_view extends alsp_terms_view {
	public $tax = ALSP_CATEGORIES_TAX;
	public $wrapper_classes = 'alsp-categories-table';
	public $row_classes = 'alsp-categories-row';
	public $column_classes = 'alsp-categories-column';
	public $root_classes = 'alsp-categories-root';
	public $subterms_classes = 'alsp-subcategories';
	public $item_classes = 'alsp-category-item';
	public $term_count_classes = 'alsp-category-count';
	public $grid_classes = 'alsp-categories-grid';
	
	public function __construct($params) {
		parent::__construct($params);
		
		$this->view_all_terms = __("View all subcategories ->", "ALSP");
	}
	
	public function getTermIconFile($term_id) {
		if ($file = alsp_getCategoryIconFile($term_id)) {
			return ALSP_CATEGORIES_ICONS_URL . $file;
		}
	}

	public function getTermImageUrl($term_id, $size) {
		return alsp_getCategoryImageUrl($term_id, $size);
	}
	
	public function termIcon($term_id) {
		$image_id = get_term_meta ($term_id, 'category-image-id', true);
		$bg_image = wp_get_attachment_image_src( $image_id, 'full' );
		$term = get_term_by('id', $term_id, ALSP_CATEGORIES_TAX);
		global $ALSP_ADIMN_SETTINGS;
		$cat_style = $this->cat_style;
		$cat_icon_type = $this->cat_icon_type;
		if($cat_color_set = alsp_getCategorycolor($term_id)){
			if($cat_style == 6){
				$cat_color = 'style="background-color:'.$cat_color_set.';"';
			}else{
				$cat_color = 'style="color:'.$cat_color_set.';"';	
			}
		}else{
			if($cat_style == 6){
				global $pacz_settings;
				$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
			}elseif($cat_style == 7){
				global $pacz_settings;
				$cat_color = 'style="color:'.$pacz_settings['accent-color'].';"';
			}else{
				$cat_color = '';
			}
		}
		if(isset($cat_icon_type )){
			$cat_icon_type_set = $cat_icon_type;
		}elseif(isset($ALSP_ADIMN_SETTINGS['cat_icon_type'])){
			$cat_icon_type_set = $ALSP_ADIMN_SETTINGS['cat_icon_type'];
		}else{
			$cat_icon_type_set = 1;
		}
		if($cat_icon_type_set == 1){
			if($cat_marker_icon = alsp_getCategoryMarkerIcon($term_id)){
				$icon_image = '<span class="cat-icon font-icon '.$cat_marker_icon.'" '.$cat_color.'></span>';
			}else{
				$icon_image = '<span class="cat-icon font-icon pacz-icon-folder-o" '.$cat_color.'></span>';
			}
					
		}elseif($cat_icon_type_set == 2) {
			if ($icon_file = alsp_getCategoryIcon($term_id)){
				if ($cat_style == 2){
					$icon_image = '<span class="cat-icon" style="background-image:url('.esc_url($bg_image[0]).');"><img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
				}else{
					$icon_image = '<span class="cat-icon"><img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
				}
			}else{
				if ($cat_style == 2){
					$icon_image = '<span class="cat-icon" style="background-image:url('.esc_url($bg_image[0]).');"><img class="alsp-field-icon" src="' . alsp_getDefaultTermIconUrl('alsp-category') . '" alt="'.$term->name.'" /></span>';
				}else{
					$icon_image = '<span class="cat-icon"><img class="alsp-field-icon" src="' . alsp_getDefaultTermIconUrl('alsp-category') . '" alt="'.$term->name.'" /></span>';
				}
			}
		}elseif($cat_icon_type_set == 3){
			$icon_image_code = get_term_meta ($term_id, 'category-svg-icon-id', true);
			$icon_image_id = get_term_meta ($term_id, 'category-svg-image-id', true);
			//$icon_image_url = wp_get_attachment_image_src($attachment_id = $icon_image_code, $size = array(60, 60), $icon = false);
			$image =  wp_get_attachment_image_src( $attachment_id = $icon_image_id, $size = array(18, 18), $icon = false);
			$image_url = $image[0];
			if(!empty($image_url)){
				$icon_image = '<span class="cat-icon"><img class="svg_icon" src="'.$image_url.'" alt="'.$term->name.'" /></span>';
			}elseif(empty($image_url) && !empty($icon_image_code)){
				$icon_image_code = get_term_meta ($term->term_id, 'category-svg-icon-id', true);
				$icon_image = '<span class="cat-icon"><span class="svg_icon">'.$icon_image_code.'</span></span>';
			}else{
				$icon_image = '<span class="cat-icon"><img class="svg_icon" src="'.ALSP_CATEGORIES_ICONS_URL.'blank.svg" alt="'.$term->name.'" /></span>';
			}
		}else{
			$icon_image = '<span class="cat-icon empty-icon"></span>';
		}
		
		return $icon_image;
	}
	
	public function getDynamicStyles($term_id) {
		global $ALSP_ADIMN_SETTINGS, $alsp_dynamic_styles;
		
		/* custom styles */
		$alsp_styles = '';
		$category_id = '#alsp-category-'.$this->args['id'];
		$id = $this->args['id'];
		$cat_font_size = (isset($this->cat_font_size))? ('font-size:' . $this->cat_font_size . 'px;') : '';
		$cat_font_weight = (isset($this->cat_font_weight))? ('font-weight:' . $this->cat_font_weight . ';') : '';
		$cat_font_line_height = (isset($this->cat_font_line_height))? ('line-height:' . $this->cat_font_line_height . 'px;') : '';
		$cat_font_transform = (isset($this->cat_font_transform) && !empty($this->cat_font_transform)) ? ('text-transform: ' . $this->cat_font_transform . ';') : '';
		
		$parent_cat_title_color = (isset($this->parent_cat_title_color))? ('color:' . $this->parent_cat_title_color . ' !important;') : '';
		$parent_cat_title_color_hover = (isset($this->parent_cat_title_color_hover))? ('color:' . $this->parent_cat_title_color_hover . ' !important;') : '';
		
		
		$child_cat_font_size = (isset($this->child_cat_font_size))? ('font-size:' . $this->child_cat_font_size . 'px;') : '';
		$child_cat_font_weight = (isset($this->child_cat_font_weight))? ('font-weight:' . $this->child_cat_font_weight . ';') : '';
		$child_cat_font_line_height = (isset($this->child_cat_font_line_height))? ('line-height:' . $this->child_cat_font_line_height . 'px;') : '';
		$child_cat_font_transform = (isset($this->child_cat_font_transform) && !empty($this->child_cat_font_transform)) ? ('text-transform: ' . $this->child_cat_font_transform . ';') : '';
		
		$subcategory_title_color = (isset($this->subcategory_title_color))? ('color:' . $this->subcategory_title_color . ' !important;') : '';
		$subcategory_title_color_hover = (isset($this->subcategory_title_color_hover))? ('color:' . $this->subcategory_title_color_hover . ' !important;') : '';
		
		if(isset($this->cat_bg) && !empty($this->cat_bg)){
			$alsp_styles = '
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
				'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-8 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper{
					background:'.$this->cat_bg.';
				}
			';
		}
		if(isset($this->cat_bg_hover) && !empty($this->cat_bg_hover)){
			$alsp_styles = '
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
				'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-8 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper:hover{
					background:'.$cat_bg_hover.';
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color)){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper{
					box-shadow: 0 2px 0 0 '.$cat_border_color.';
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover)){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover{
					box-shadow: 0 2px 0 0 '.$cat_border_color_hover.';
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		if(isset($this->parent_cat_title_bg) && !empty($this->parent_cat_title_bg) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper .alsp-categories-root{
					background:'.$parent_cat_title_bg.' !important;
				}
			';
		}
		if(isset($this->parent_cat_title_bg_hover) && !empty($this->parent_cat_title_bg_hover) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root{
					background:'.$parent_cat_title_bg_hover.' !important;
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper .subcategories ul li a.view-all-btn{
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper:hover .subcategories ul li a.view-all-btn{
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color) && $this->cat_style == 7){
			$alsp_styles = '
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper{
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover) && $this->cat_style == 7){
			$alsp_styles = '
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover{
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		$alsp_styles = '
			'.$category_id.' .alsp-categories-root a{
				'.$parent_cat_title_color.'
				'.$cat_font_size.'
				'.$cat_font_weight.'
				'.$cat_font_line_height.'
				'.$cat_font_transform.'
			}
			'.$category_id.' .alsp-categories-root a:hover,
			'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper:hover .alsp-categories-root a{
				'.$parent_cat_title_color_hover.'
			}
			'.$category_id.' .subcategories ul li a,
			'.$category_id.' .subcategories ul li a span{
				'.$subcategory_title_color.'
				'.$child_cat_font_size.'
				'.$child_cat_font_weight.'
				'.$child_cat_font_line_height.'
				'.$child_cat_font_transform.'
			}
			'.$category_id.' .subcategories ul li a:hover,
			'.$category_id.' .subcategories ul li a:hover span{
				'.$subcategory_title_color_hover.'
			}
			.cat-style-7 .alsp-categories-column-wrapper:hover .cat-7-icon .cat-icon.font-icon{
				color:#fff !important;
			}
		';
		
		// Hidden styles node for head injection after page load through ajax
			echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
			echo '</div>';

			// Export styles to json for faster page load
			$alsp_dynamic_styles[] = array(
			  'id' => 'ajax-'.$id ,
			  'inject' => $alsp_styles
			);
	}
}

class alsp_listingtypes_view extends alsp_terms_view {
	public $tax = ALSP_TYPE_TAX;
	public $wrapper_classes = 'alsp-categories-table';
	public $row_classes = 'alsp-categories-row';
	public $column_classes = 'alsp-categories-column';
	public $root_classes = 'alsp-categories-root';
	public $subterms_classes = 'alsp-subcategories';
	public $item_classes = 'alsp-category-item';
	public $term_count_classes = 'alsp-category-count';
	public $grid_classes = 'alsp-categories-grid';
	
	public function __construct($params) {
		parent::__construct($params);
		
		$this->view_all_terms = __("View all subcategories ->", "ALSP");
	}
	
	public function getTermIconFile($term_id) {
		if ($file = alsp_getListingTypeIconFile($term_id)) {
			return ALSP_LISTINGTYPE_ICONS_URL . $file;
		}
	}

	public function getTermImageUrl($term_id, $size) {
		return alsp_getListingTypeImageUrl($term_id, $size);
	}
	
	public function termIcon($term_id) {
		$image_id = get_term_meta ($term_id, 'category-image-id', true);
		$bg_image = wp_get_attachment_image_src( $image_id, 'full' );
		$term = get_term_by('id', $term_id, ALSP_TYPE_TAX);
		global $ALSP_ADIMN_SETTINGS;
		$cat_style = $this->cat_style;
		$cat_icon_type = $this->cat_icon_type;
		if($cat_color_set = alsp_getListingTypecolor($term_id)){
			if($cat_style == 6){
				$cat_color = 'style="background-color:'.$cat_color_set.';"';
			}else{
				$cat_color = 'style="color:'.$cat_color_set.';"';	
			}
		}else{
			if($cat_style == 6){
				global $pacz_settings;
				$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
			}elseif($cat_style == 7){
				global $pacz_settings;
				$cat_color = 'style="color:'.$pacz_settings['accent-color'].';"';
			}else{
				$cat_color = '';
			}
		}
		if(isset($cat_icon_type )){
			$cat_icon_type_set = $cat_icon_type;
		}elseif(isset($ALSP_ADIMN_SETTINGS['cat_icon_type'])){
			$cat_icon_type_set = $ALSP_ADIMN_SETTINGS['cat_icon_type'];
		}else{
			$cat_icon_type_set = 1;
		}
		if($cat_icon_type_set == 1){
			if($cat_marker_icon = alsp_getListingTypeMarkerIcon($term_id)){
				$icon_image = '<span class="cat-icon font-icon '.$cat_marker_icon.'" '.$cat_color.'></span>';
			}else{
				$icon_image = '<span class="cat-icon font-icon pacz-icon-folder-o" '.$cat_color.'></span>';
			}
					
		}elseif($cat_icon_type_set == 2) {
			if ($icon_file = alsp_getListingTypeIcon($term_id)){
				if ($cat_style == 2){
					$icon_image = '<span class="cat-icon" style="background-image:url('.esc_url($bg_image[0]).');"><img class="alsp-field-icon" src="' . ALSP_LISTINGTYPE_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
				}else{
					$icon_image = '<span class="cat-icon"><img class="alsp-field-icon" src="' . ALSP_LISTINGTYPE_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
				}
			}else{
				if ($cat_style == 2){
					$icon_image = '<span class="cat-icon" style="background-image:url('.esc_url($bg_image[0]).');"><img class="alsp-field-icon" src="' . alsp_getDefaultTermIconUrl('alsp-category') . '" alt="'.$term->name.'" /></span>';
				}else{
					$icon_image = '<span class="cat-icon"><img class="alsp-field-icon" src="' . alsp_getDefaultTermIconUrl('alsp-category') . '" alt="'.$term->name.'" /></span>';
				}
			}
		}elseif($cat_icon_type_set == 3){
			$icon_image_code = get_term_meta ($term_id, 'category-svg-icon-id', true);
			$icon_image_id = get_term_meta ($term_id, 'category-svg-image-id', true);
			//$icon_image_url = wp_get_attachment_image_src($attachment_id = $icon_image_code, $size = array(60, 60), $icon = false);
			$image =  wp_get_attachment_image_src( $attachment_id = $icon_image_id, $size = array(18, 18), $icon = false);
			$image_url = $image[0];
			if(!empty($image_url)){
				$icon_image = '<span class="cat-icon"><img class="svg_icon" src="'.$image_url.'" alt="'.$term->name.'" /></span>';
			}elseif(empty($image_url) && !empty($icon_image_code)){
				$icon_image_code = get_term_meta ($term->term_id, 'category-svg-icon-id', true);
				$icon_image = '<span class="cat-icon"><span class="svg_icon">'.$icon_image_code.'</span></span>';
			}else{
				$icon_image = '<span class="cat-icon"><img class="svg_icon" src="'.ALSP_LISTINGTYPE_ICONS_URL.'blank.svg" alt="'.$term->name.'" /></span>';
			}
		}else{
			$icon_image = '<span class="cat-icon empty-icon"></span>';
		}
		
		return $icon_image;
	}
	
	public function getDynamicStyles($term_id) {
		global $ALSP_ADIMN_SETTINGS, $alsp_dynamic_styles;
		
		/* custom styles */
		$alsp_styles = '';
		$category_id = '#alsp-category-'.$this->args['id'];
		$id = $this->args['id'];
		$cat_font_size = (isset($this->cat_font_size))? ('font-size:' . $this->cat_font_size . 'px;') : '';
		$cat_font_weight = (isset($this->cat_font_weight))? ('font-weight:' . $this->cat_font_weight . ';') : '';
		$cat_font_line_height = (isset($this->cat_font_line_height))? ('line-height:' . $this->cat_font_line_height . 'px;') : '';
		$cat_font_transform = (isset($this->cat_font_transform) && !empty($this->cat_font_transform)) ? ('text-transform: ' . $this->cat_font_transform . ';') : '';
		
		$parent_cat_title_color = (isset($this->parent_cat_title_color))? ('color:' . $this->parent_cat_title_color . ' !important;') : '';
		$parent_cat_title_color_hover = (isset($this->parent_cat_title_color_hover))? ('color:' . $this->parent_cat_title_color_hover . ' !important;') : '';
		
		
		$child_cat_font_size = (isset($this->child_cat_font_size))? ('font-size:' . $this->child_cat_font_size . 'px;') : '';
		$child_cat_font_weight = (isset($this->child_cat_font_weight))? ('font-weight:' . $this->child_cat_font_weight . ';') : '';
		$child_cat_font_line_height = (isset($this->child_cat_font_line_height))? ('line-height:' . $this->child_cat_font_line_height . 'px;') : '';
		$child_cat_font_transform = (isset($this->child_cat_font_transform) && !empty($this->child_cat_font_transform)) ? ('text-transform: ' . $this->child_cat_font_transform . ';') : '';
		
		$subcategory_title_color = (isset($this->subcategory_title_color))? ('color:' . $this->subcategory_title_color . ' !important;') : '';
		$subcategory_title_color_hover = (isset($this->subcategory_title_color_hover))? ('color:' . $this->subcategory_title_color_hover . ' !important;') : '';
		
		if(isset($this->cat_bg) && !empty($this->cat_bg)){
			$alsp_styles = '
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon,
				'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-8 .alsp-categories-column-wrapper,
				'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper{
					background:'.$this->cat_bg.';
				}
			';
		}
		if(isset($this->cat_bg_hover) && !empty($this->cat_bg_hover)){
			$alsp_styles = '
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
				.theme-page-wrapper '.$category_id.'.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .cat-icon:hover,
				'.$category_id.'.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a:hover .cat-icon,
				'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-8 .alsp-categories-column-wrapper:hover,
				'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper:hover{
					background:'.$cat_bg_hover.';
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color)){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper{
					box-shadow: 0 2px 0 0 '.$cat_border_color.';
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover)){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover{
					box-shadow: 0 2px 0 0 '.$cat_border_color_hover.';
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		if(isset($this->parent_cat_title_bg) && !empty($this->parent_cat_title_bg) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper .alsp-categories-root{
					background:'.$parent_cat_title_bg.' !important;
				}
			';
		}
		if(isset($this->parent_cat_title_bg_hover) && !empty($this->parent_cat_title_bg_hover) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root{
					background:'.$parent_cat_title_bg_hover.' !important;
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper .subcategories ul li a.view-all-btn{
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover) && $this->cat_style == 6){
			$alsp_styles = '
				'.$category_id.'.cat-style-6 .alsp-categories-row .alsp-categories-column-wrapper:hover .subcategories ul li a.view-all-btn{
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		if(isset($this->cat_border_color) && !empty($this->cat_border_color) && $this->cat_style == 7){
			$alsp_styles = '
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper{
					border-color: '.$cat_border_color.';
				}
			';
		}
		if(isset($this->cat_border_color_hover) && !empty($this->cat_border_color_hover) && $this->cat_style == 7){
			$alsp_styles = '
				'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover{
					border-color: '.$cat_border_color_hover.';
				}
			';
		}
		$alsp_styles = '
			'.$category_id.' .alsp-categories-root a{
				'.$parent_cat_title_color.'
				'.$cat_font_size.'
				'.$cat_font_weight.'
				'.$cat_font_line_height.'
				'.$cat_font_transform.'
			}
			'.$category_id.' .alsp-categories-root a:hover,
			'.$category_id.'.cat-style-3 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-4 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-5 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-6 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-7 .alsp-categories-column-wrapper:hover .alsp-categories-root a,
			'.$category_id.'.cat-style-9 .alsp-categories-column-wrapper:hover .alsp-categories-root a{
				'.$parent_cat_title_color_hover.'
			}
			'.$category_id.' .subcategories ul li a,
			'.$category_id.' .subcategories ul li a span{
				'.$subcategory_title_color.'
				'.$child_cat_font_size.'
				'.$child_cat_font_weight.'
				'.$child_cat_font_line_height.'
				'.$child_cat_font_transform.'
			}
			'.$category_id.' .subcategories ul li a:hover,
			'.$category_id.' .subcategories ul li a:hover span{
				'.$subcategory_title_color_hover.'
			}
			.cat-style-7 .alsp-categories-column-wrapper:hover .cat-7-icon .cat-icon.font-icon{
				color:#fff !important;
			}
		';
		
		// Hidden styles node for head injection after page load through ajax
			echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
			echo '</div>';

			// Export styles to json for faster page load
			$alsp_dynamic_styles[] = array(
			  'id' => 'ajax-'.$id ,
			  'inject' => $alsp_styles
			);
	}
}


class alsp_locations_view extends alsp_terms_view {
	public $tax = ALSP_LOCATIONS_TAX;
	public $wrapper_classes = 'alsp-locations-table';
	public $row_classes = 'alsp-locations-row';
	public $column_classes = 'alsp-locations-column';
	public $root_classes = 'alsp-locations-root';
	public $subterms_classes = 'alsp-sublocations';
	public $item_classes = 'alsp-location-item';
	public $term_count_classes = 'alsp-location-count';
	public $grid_classes = 'alsp-locations-grid';
	
	public function __construct($params) {
		parent::__construct($params);
		
		$this->view_all_terms = __("View all sublocations ->", "ALSP");
	}
	
	public function getTermIconFile($term_id) {
		if ($file = alsp_getLocationIconFile($term_id)) {
			return ALSP_LOCATIONS_ICONS_URL . $file;
		}
	}

	public function getTermImageUrl($term_id, $size) {
		return alsp_getLocationImageUrl($term_id, $size);
	}
	
	public function getDynamicStyles($term_id) {
		global $ALSP_ADIMN_SETTINGS, $alsp_dynamic_styles;
		$id = $this->args['id'];
		$location_bg = $this->location_bg;
		$location_bg_image = $this->location_bg_image;
		$gradientbg1 = $this->gradientbg1;
		$gradientbg2 = $this->gradientbg2;
		$opacity1 = $this->opacity1;
		$opacity2 = $this->opacity2;
		$gradient_angle = $this->gradient_angle;
		$location_width = $this->location_width;
		$location_height = $this->location_height;
		$location_padding = $this->location_padding;
		
		$responsive_width = $location_width;
		$responsive_height = $location_height / 2;
		global $alsp_dynamic_styles;
		$alsp_styles = '';
		if ( $location_padding  ) {
		   $alsp_styles .= '
				.alsp-masonry-grid{
					margin:-'.$location_padding.'px;
					box-sizing: border-box;
				}
				.alsp-masonry-grid:after,.alsp-masonry-grid:before{
					clear:both;
					content:"";
					display:table;
				}
				';
		}
		if ( $this->location_style) {
			$opacitybg1 = '0.'.$opacity1;
			$opacitybg2 = '0.'.$opacity2;
			$gradient_bg_color1 = pacz_convert_rgba($gradientbg1, $opacitybg1);
			$gradient_bg_color2 = pacz_convert_rgba($gradientbg2, $opacitybg2);
			$alsp_styles .= '
		.alsp-locations-column-wrapper{background-size:cover !important;}	
		.alsp-locations-column-wrapper-inner{transition:all 0.5s ease;}
		#loaction-styles'.$id.'.location-style1 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
		#loaction-styles'.$id.'.location-style2 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
		#loaction-styles'.$id.'.location-style3 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
		#loaction-styles'.$id.'.location-style5 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
		#loaction-styles'.$id.'.location-style6 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
		#loaction-styles'.$id.'.location-style7 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner {
			background: -webkit-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
			background: -moz-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
			background: -o-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
			background: -ms-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
			background: linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
			transition:all 2.5s ease;
		}

			';
		}
		if(!empty($location_bg_image)){
			$locationbg = 'url('.$location_bg_image.')';
		}else{
			$locationbg = $location_bg;
		}
		$gradient_bg_color3 = 'rgba(0,0,0,0)';
		$gradient_bg_color4 = 'rgba(0,0,0,0)';
		$alsp_styles .= '
			#loaction-styles'.$id.'.alsp-locations-columns.location-style1 .alsp-locations-column-wrapper,
			#loaction-styles'.$id.'.alsp-locations-columns.location-style2 .alsp-locations-column-wrapper,
			#loaction-styles'.$id.'.alsp-locations-columns.location-style3 .alsp-locations-column-wrapper,
			#loaction-styles'.$id.'.alsp-locations-columns.location-style5 .alsp-locations-column-wrapper,
			#loaction-styles'.$id.'.alsp-locations-columns.location-style6 .alsp-locations-column-wrapper,
			#loaction-styles'.$id.'.alsp-locations-columns.location-style7 .alsp-locations-column-wrapper{ 
				background:'.$locationbg.';
				height:100%;
				
			}
			#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper .alsp-locations-column-holder{ 
				background:'.$locationbg.';
				height:100%;
				transform:scale(1);
				transition:all 0.3s ease;
			}
			#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper{
				overflow:hidden;
				height:100%;
			}
			#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper .alsp-locations-column-holder .alsp-locations-column-wrapper-inner{
				transform:scale(1);
				height:100%;
				text-align:center;
			}
			#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper:hover .alsp-locations-column-holder .alsp-locations-column-wrapper-inner{
				transform:scale(1);
				height:100%;
				text-align:center;
			}
			#loaction-styles'.$id.'.location-style1.grid-item,
			#loaction-styles'.$id.'.location-style2.grid-item,
			#loaction-styles'.$id.'.location-style3.grid-item,
			#loaction-styles'.$id.'.location-style5.grid-item,
			#loaction-styles'.$id.'.location-style6.grid-item,
			#loaction-styles'.$id.'.location-style7.grid-item,
			#loaction-styles'.$id.'.location-style10.grid-item{
				width:'.$location_width.'%;
				height:'.$location_height.'px;
				float:left;
			}
			.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before,
			.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before{
				background-image: url("'.ALSP_RESOURCES_URL .'images/alsp-location-icon.png");
			}
			.widget #loaction-styles'.$id.'.grid-item{
				width:100% !important;
				height:100% !important;
			}
			@media screen and (max-width:480px) {
				#loaction-styles'.$id.'.location-style1.grid-item,
				#loaction-styles'.$id.'.location-style2.grid-item,
				#loaction-styles'.$id.'.location-style3.grid-item,
				#loaction-styles'.$id.'.location-style5.grid-item,
				#loaction-styles'.$id.'.location-style6.grid-item,
				#loaction-styles'.$id.'.location-style7.grid-item,
				#loaction-styles'.$id.'.location-style10.grid-item{
					width:100%;
					height:'.$location_height.'px;
					float:left;
				}
			}
			.widget #loaction-styles'.$id.'.location-style1 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
			.widget #loaction-styles'.$id.'.location-style2 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
			.widget #loaction-styles'.$id.'.location-style3 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
			.widget #loaction-styles'.$id.'.location-style4 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
			.widget #loaction-styles'.$id.' .alsp-locations-column-wrapper{
				background: -webkit-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
				background: -moz-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
				background: -o-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
				background: -ms-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
				background: linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
				transition:all 2.5s ease;
			}
			.widget #loaction-styles'.$id.'{padding:0 !important;}
			.alsp-masonry-grid .grid-sizer{
				width:'.$location_width.'%;
			}

			#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper:hover .alsp-locations-column-holder{
				transform:scale(1.05);
				transition:all 0.3s ease;
			}
		';
		/* if($this->location_style != 4){
			$alsp_styles .= '
				.wpb_wrapper{margin: 0 -'.$location_padding.'px;};
			';
		} */
		
		// Hidden styles node for head injection after page load through ajax
		echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
		echo '</div>';


		// Export styles to json for faster page load
		$alsp_dynamic_styles[] = array(
		  'id' => 'ajax-'.$id ,
		  'inject' => $alsp_styles
		);
	}
}

?>