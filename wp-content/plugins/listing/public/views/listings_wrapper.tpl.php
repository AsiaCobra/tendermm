<?php	
	global $ALSP_ADIMN_SETTINGS;
	if(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}elseif(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
		$listing_style_to_show = 'show_list_style';
	}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
		$listing_style_to_show = 'show_grid_style';
	}else{
		if($ALSP_ADIMN_SETTINGS['alsp_views_switcher_default'] == 'grid'){
			$listing_style_to_show = 'show_grid_style';
		}else{
			$listing_style_to_show = 'show_list_style';
		}
	}
	
	//$detect = new Mobile_Detect;
	if($public_control->args['masonry_layout'] && $listing_style_to_show == 'show_grid_style' && !wp_is_mobile()){
		$pacz_loop_main_wrapper2 = 'pacz-loop-main-wrapper2';
		$masonry = 'masonry';
		$isotope_el_class = 'isotop-enabled pacz-theme-loop ';
		$masonry_classes = 'pacz-isotop-item isotop-item masonry-'.$public_control->hash.'';
	}elseif($public_control->args['masonry_layout'] && $public_control->args['2col_responsive'] && $listing_style_to_show == 'show_grid_style' && ($public_control->args['listing_post_style'] == 10 || $public_control->args['listing_post_style'] == 14) && wp_is_mobile()){
		$pacz_loop_main_wrapper2 = 'pacz-loop-main-wrapper2';
		$masonry = 'masonry';
		$isotope_el_class = 'isotop-enabled pacz-theme-loop ';
		$masonry_classes = 'pacz-isotop-item isotop-item masonry-'.$public_control->hash.'';
	}else{
		$pacz_loop_main_wrapper2 = '';
		$masonry = '';
		$isotope_el_class = '';
		$masonry_classes = '';
	}
	if(wp_is_mobile() && $public_control->args['2col_responsive']){
		$grid_padding = 5;
		$alsp_grid_margin_bottom = 10;
	}else{
		$grid_padding = (isset($public_control->args['grid_padding']))? $public_control->args['grid_padding'] : $ALSP_ADIMN_SETTINGS['alsp_grid_padding'];
		$alsp_grid_margin_bottom = $ALSP_ADIMN_SETTINGS['alsp_grid_margin_bottom'];
	}
	
?>
		<?php if (!isset($public_control->custom_home) || !$public_control->custom_home || ($public_control->custom_home && $ALSP_ADIMN_SETTINGS['alsp_listings_on_index'])): ?>
		<div class="alsp-content listing-parent pacz-loop-main-wrapper <?php echo $pacz_loop_main_wrapper2; ?>" id="alsp-controller-<?php echo $public_control->hash; ?>" data-controller-hash="<?php echo $public_control->hash; ?>" <?php if (isset($public_control->custom_home) && $public_control->custom_home): ?>data-custom-home="1"<?php endif; ?>>
			<?php 
			
			//$GLOBALS['listing_style_to_show'] = $listing_style_to_show;
			$view_swither_panel_style = (isset($ALSP_ADIMN_SETTINGS['view_switther_panel_style']))? $ALSP_ADIMN_SETTINGS['view_switther_panel_style'] : 1;
			if($view_swither_panel_style == 1){ 
				$view_swither_panel_style_class = 'view_swither_panel_style1';
			}elseif($view_swither_panel_style == 2){
				$view_swither_panel_style_class = 'view_swither_panel_style2';
			}elseif($view_swither_panel_style == 3){
				$view_swither_panel_style_class = 'view_swither_panel_style3';
			}else{
				$view_swither_panel_style_class = 'view_swither_panel_style1';
			}
			if($view_swither_panel_style != 3){
				if(isset($public_control->args['listing_order_by_txt']) && (!empty($public_control->args['listing_order_by_txt']))){
					$order_by_txt = $public_control->args['listing_order_by_txt'].':';
				}else{
					$order_by_txt = esc_html__('Sort By:', 'ALSP');
				}
			}else{
				$order_by_txt = '';
			}
			
			
			 if($public_control->args['2col_responsive'] && $listing_style_to_show == 'show_grid_style' && ($public_control->args['listing_post_style'] == 10 || $public_control->args['listing_post_style'] == 14)){
				$alsp_responsive_col = 'responsive-2col';
			 }else{
				$alsp_responsive_col = '';
			 }
			 if($public_control->args['scroll'] == 1){
				 $carousel = 'carousel-active';
			 }else{
				 $carousel = 'no-carousel';
			 }
			 
			?>
			<script>
			alsp_controller_args_array['<?php echo $public_control->hash; ?>'] = <?php echo json_encode(array_merge(array('controller' => $public_control->request_by, 'base_url' => $public_control->base_url), $public_control->args)); ?>;
			
			</script>
			<?php if ($public_control->do_initial_load): ?>
				<?php if ($listing_style_to_show == 'show_grid_style'): ?>
				
				<div class="alsp-container-fluid alsp-listings-block alsp-listings-grid <?php  global $alsp_instance; if($alsp_instance->getShortcodeProperty('alsp-main', 'is_favourites')){ echo 'infavourites'; } ?> alsp-listings-grid-<?php echo $public_control->args['listings_view_grid_columns']; ?> <?php if($public_control->args['scroll'] == 0) { echo $masonry; } ?>">
				<?php else: ?>
					<div class="alsp-container-fluid alsp-listings-block cz-listview">
				<?php endif; ?>
				<?php if ($public_control->query->found_posts && $public_control->args['scroll'] == 0): ?>
				<div class="row alsp-listings-block-header">
					<?php if (!$public_control->args['hide_count']): ?>
					<div class="alsp-found-listings">
						<?php printf(__('Found', "ALSP") . ' <span class="badge">%d</span> %s', $public_control->query->found_posts, _n($public_control->getListingsDirectory()->single, $public_control->getListingsDirectory()->plural, $public_control->query->found_posts)); ?>
					</div>
					<?php endif; ?>
					<?php if ($public_control->args['show_views_switcher'] || !$public_control->args['hide_order']): ?>
					<div class="<?php echo $view_swither_panel_style_class; ?> alsp-options-links clearfix">
						<?php if(!$public_control->args['hide_order']): ?>
						<?php $ordering = alsp_orderLinks($public_control->base_url, $public_control->args, true, $public_control->hash); ?>
						<?php if ($ordering['struct']):?>
							<div class="alsp-orderby-links-label"><?php if($view_swither_panel_style != 3){ echo $order_by_txt; } ?></div>
							<div class="alsp-orderby-links btn-group" role="group">
								<?php foreach ($ordering['struct'] AS $field_slug=>$link): ?>
								<a class="btn btn-default <?php if ($link['class']): ?>btn-primary<?php endif; ?>" href="<?php echo $link['url']; ?>" data-controller-hash="<?php echo $public_control->hash; ?>" data-orderby="<?php echo $field_slug; ?>" data-order="<?php echo $link['order']; ?>" rel="nofollow">
									<?php if ($link['class']): ?>
									<span class="glyphicon glyphicon-arrow-<?php if ($link['class'] == 'ascending'): ?>up<?php elseif ($link['class'] == 'descending'): ?>down<?php endif; ?>" aria-hidden="true"></span>
									<?php endif; ?>
									<span class="order-before-main"><span class="order-before-inner"></span></span>
									<?php echo $link['field_name']; ?>
								</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php endif; ?>
						
						<?php if ($public_control->args['show_views_switcher']): ?>
						<div id="view-btn-<?php echo $public_control->hash; ?>" class="alsp-views-links pull-right">
							<div class="btn-group" role="group">
								<a class="btn <?php if ($listing_style_to_show == 'show_list_style'): ?>btn-primary<?php else: ?>btn-default<?php endif; ?> alsp-list-view-btn" href="javascript: void(0);" title="<?php _e('List View', 'ALSP'); ?>" data-shortcode-hash="<?php echo $public_control->hash; ?>">
									<?php if($view_swither_panel_style == 1) { ?><span class="pacz-fic3-list-4" aria-hidden="true"></span> <?php }else{ ?> <span class="pacz-icon-list" aria-hidden="true"></span> <?php } ?>
								</a>
								<a class="btn <?php if ($listing_style_to_show == 'show_grid_style'): ?>btn-primary<?php else: ?>btn-default<?php endif; ?> alsp-grid-view-btn" href="javascript: void(0);" title="<?php _e('Grid View', 'ALSP'); ?>" data-shortcode-hash="<?php echo $public_control->hash; ?>" data-columns=<?php echo $public_control->args['listings_view_grid_columns']; ?>>
									<span class="pacz-fic3-3x3-grid" aria-hidden="true"></span>
								</a>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					</div>
					
				<?php endif; ?>
				<?php if ($public_control->listings): ?>
				
					<div id="listing-block-<?php echo $public_control->hash; ?>" class="alsp-listings-block-content <?php echo $carousel; ?>  <?php if($public_control->args['scroll'] == 0){ echo $isotope_el_class; } ?> clearfix" <?php if ($listing_style_to_show == 'show_grid_style'){ ?> style="margin-left:-<?php echo $grid_padding; ?>px; margin-right: -<?php echo $grid_padding; ?>px;" <?php } ?> <?php if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display']){ ?> data-style="masonry" data-uniqid="<?php echo $public_control->hash; } ?>">
						<?php if ($public_control->args['scroll'] == 1): ?><!--cz custom -->
							<div class="slick-carousel owl-on-grid"
								data-items="<?php echo $public_control->args['desktop_items']; ?>"
								data-items-1024="<?php echo $public_control->args['tab_landscape_items']; ?>"
								data-items-768="<?php echo $public_control->args['tab_items']; ?>"
								data-slide-to-scroll="1"
								data-slide-speed="1000"
								data-autoplay="<?php echo $public_control->args['autoplay']; ?>"
								data-center-padding ="<?php echo $public_control->args['gutter']; ?>"
								data-center="false"
								data-autoplay-speed ="<?php echo $public_control->args['autoplay_speed']; ?>"
								data-loop="<?php echo $public_control->args['loop']; ?>"
								data-list-margin="<?php echo $grid_padding; ?>"
								data-arrow="<?php echo $public_control->args['owl_nav']; ?>"
							>
						<?php endif; ?>
							<?php if($listing_style_to_show == 'show_list_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'): ?>
								<div class="listing-list-view-inner-wrap">
							<?php endif; ?>
								<?php while ($public_control->query->have_posts()):
									$public_control->query->the_post();
									if($public_control->args['scroll']): 
								?>
										<div class="listing-box">	
									<?php endif; // slick listing box div ?>
											<article id="post-<?php the_ID(); ?>" class="<?php if ($public_control->args['scroll'] == 1){ echo 'listing-scroll'; } ?> row alsp-listing <?php  echo $alsp_responsive_col.' '.$masonry_classes; ?> listing-post-style-<?php if ($listing_style_to_show == 'show_grid_style'){ echo $public_control->args['listing_post_style']; }else{ echo $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style']; } ?> <?php if ($public_control->listings[get_the_ID()]->level->featured) { echo 'alsp-featured';} ?> <?php if ($public_control->listings[get_the_ID()]->level->sticky) echo 'alsp-sticky'; ?> clearfix" <?php if ($listing_style_to_show == 'show_grid_style'){ ?> style="padding-left:<?php echo $grid_padding; ?>px; padding-right: <?php echo $grid_padding; ?>px; margin-bottom: <?php echo $alsp_grid_margin_bottom; ?>px;" <?php } ?>>
												<div class="listing-wrapper clearfix">
													<?php $public_control->listings[get_the_ID()]->display($public_control); ?>
												</div>
											</article>
									<?php if($public_control->args['scroll']): ?>
										</div>
									<?php endif; //slick listing box end ?>
								<?php endwhile; ?>
							<?php if($listing_style_to_show == 'show_list_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'): ?>
								</div>
							<?php endif; ?>
						<?php if ($public_control->args['scroll'] == 1): ?><!--cz custom -->
							</div>
						<?php endif; ?>
					</div>

					<?php if (!$public_control->args['hide_paginator']): ?>
						<?php alsp_renderPaginator($public_control->query, $public_control->hash, $ALSP_ADIMN_SETTINGS['alsp_show_more_button']); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php printf(__('Found', "ALSP") . ' <span class="badge">%d</span> %s', $public_control->query->found_posts, _n($public_control->getListingsDirectory()->single, $public_control->getListingsDirectory()->plural, $public_control->query->found_posts)); ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>