<?php global $ALSP_ADIMN_SETTINGS; ?>
<div width="100%" style="background-color:#dddddd;padding:30px;text-align:center;font-size:25px;font-weight:bold;margin-bottom:30px;"><p><br>
Ads<br></p></div>


	<?php


  echo'<div class="listing-counts-wrap clearfix">';
		echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
			echo'<div class="total-listing-count-item">';
				echo '<i class="total pacz-fic3-list"></i>';
				echo '<span class="listing-conut-main"><span class="listing-number">'.$public_control->listings_count.'</span>'.esc_html__('Total Tenders', 'ALSP').'</span>';
			echo'</div>';
		echo'</div>';
		echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
			echo'<div class="total-listing-count-item">';
				echo '<i class="active pacz-fic4-tick"></i>';
				echo '<span class="listing-conut-main"><span class="listing-number">'.$public_control->listings_count2.'</span>'.esc_html__('Active Tenders', 'ALSP').'</span>';
			echo'</div>';
		echo'</div>';
		echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
			echo'<div class="total-listing-count-item">';
				echo '<i class="expired pacz-fic4-warning-1"></i>';
				echo '<span class="listing-conut-main"><span class="listing-number">'.$public_control->listings_count3.'</span>'.esc_html__('Expired Tenders', 'ALSP').'</span>';
			echo'</div>';
		echo'</div>';
		echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
			echo'<div class="total-listing-count-item">';
				echo '<i class="pending pacz-fic-clock-4"></i>';
				echo '<span class="listing-conut-main"><span class="listing-number">'.$public_control->listings_count4.'</span>'.esc_html__('Pending Approval', 'ALSP').'</span>';
			echo'</div>';
		echo'</div>';
	echo'</div>';

	?>
	
	
	
	<?php if ($public_control->listings): ?>
		<?php
		

		 
		 //echo $public_control->listings_count3;
		?>
		<div class="alsp-table alsp-table-striped clearfix">
		    
				<div class="row clearfix">
		<?php while ($public_control->query->have_posts()): ?>
			<?php $public_control->query->the_post(); ?>
			<?php 
				$listing = $public_control->listings[get_the_ID()]; 
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
				
				//$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
				$param = array(
					'width' => 480,
					'height' => 380,
					'crop' => true
				);
			?>
			<div class="userpanel-item-wrap">
			<div class="td-listing-wrapper">
				
				
				<div class="td_listings_content">
					<div class="td_listings_status">
						<?php
						if ($listing->status == 'active' && $listing->post->post_status != 'pending' && $listing->post->post_status  != 'draft' )
							echo '<span class="label label-success">' . __('active', 'ALSP') . '</span>';
						elseif ($listing->status == 'expired')
							echo '<span class="label label-danger">' . __('expired', 'ALSP') . '</span>';
						elseif ($listing->status == 'unpaid')
							echo '<span class="label label-warning">' . __('unpaid', 'ALSP') . '</span>';
						elseif ($listing->status == 'stopped')
							echo '<span class="label label-danger">' . __('stopped', 'ALSP') . '</span>';
						elseif ($listing->post->post_status == 'pending')
							echo '<span class="label label-default">' . __('pending', 'ALSP') . '</span>';
						elseif ($listing->post->post_status == 'draft') 
							echo '<span class="label label-danger">' . __('draft', 'ALSP') . '</span>';
						do_action('alsp_listing_status_option', $listing);
							
						if ($listing->level->isUpgradable()):
							echo '<a class="label label-info" href="' . alsp_dashboardUrl(array('alsp_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'ALSP') . '">'; 
								echo $listing->level->name;
							if ($listing->level->isUpgradable()){
								echo ' <i class="pacz-icon-cog"></i>'; 
							}
						?>
							</a>
						<?php endif; ?>
					</div>
					<div class="td_listings_title">
						<h5>
						<?php
						if (alsp_current_user_can_edit_advert($listing->post->ID))
							echo '<a href="' . alsp_get_edit_advert_link($listing->post->ID) . '">' . $listing->title() . '</a>';
						else
							echo $listing->title();
						do_action('alsp_dashboard_listing_title', $listing);
						?>
						<?php if ($listing->post->post_status == 'pending') echo '<span class="badge">' . __('Pending', 'ALSP').'</span>'; ?>
						<?php if ($listing->post->post_status == 'draft') echo '<span class="badge">' . __('Draft', 'ALSP').'</span>'; ?>
						<?php if ($listing->claim && $listing->claim->isClaimed()) echo '<div class="claim-message">' . $listing->claim->getClaimMessage() . '</div>'; ?>
						</h5>
					</div>
					<?php 
					// adapted for WPML
					global $sitepress;
					if (function_exists('wpml_object_id_filter') && $sitepress && $ALSP_ADIMN_SETTINGS['alsp_enable_frontend_translations'] && ($languages = $sitepress->get_active_languages()) && count($languages) > 1): ?>
					<div class="td_listings_translations">
					<?php if (alsp_current_user_can_edit_advert($listing->post->ID)):
						global $sitepress;
						$trid = $sitepress->get_element_trid($listing->post->ID, 'post_' . ALSP_POST_TYPE);
						$translations = $sitepress->get_element_translations($trid); ?>
						<?php foreach ($languages AS $lang_code=>$lang): ?>
						<?php if ($lang_code != ICL_LANGUAGE_CODE && apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page', false, $lang_code)): ?>
						<?php $lang_details = $sitepress->get_language_details($lang_code); ?>
						<?php do_action('wpml_switch_language', $lang_code); ?>
						<?php if (isset($translations[$lang_code])): ?>
						<a style="text-decoration:none" title="<?php echo sprintf(__('Edit the %s translation', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo add_query_arg(array('alsp_action' => 'edit_advert', 'listing_id' => apply_filters('wpml_object_id', $listing->post->ID, ALSP_POST_TYPE, true, $lang_code)), get_permalink(apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page', true, $lang_code))); ?>">
							<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/edit_translation.png" alt="<?php esc_attr_e(__('edit translation', 'ALSP')); ?>" />
						</a>&nbsp;&nbsp;
						<?php else: ?>
						<a style="text-decoration:none" title="<?php echo sprintf(__('Add translation to %s', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'add_translation', 'listing_id' => $listing->post->ID, 'to_lang' => $lang_code)); ?>">
							<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/add_translation.png" alt="<?php esc_attr_e(__('add translation', 'ALSP')); ?>" /><?php esc_attr_e(__('Add Translation', 'ALSP')); ?>
						</a>&nbsp;&nbsp;
						<?php endif; ?>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php do_action('wpml_switch_language', ICL_LANGUAGE_CODE); ?>
					<?php endif; ?>
					</div>
					<?php endif; ?>
			
				</div>
				<div class="td_listings_bottom clearfix">
				<div class="td_listings_id"><span class="pacz-fic4-bookmark-white"></span><span class="id-label"><?php echo esc_html__('AD ID', 'ALSP').' :'; ?></span><?php echo $listing->post->ID; ?></div>
				<div class="td_listings_options">
					<?php if (alsp_current_user_can_edit_advert($listing->post->ID)){ ?>
					
					<div class="dropdown show">
						  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?PHP echo esc_html__('options', 'ALSP'); ?>
						  </a>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a href="<?php echo alsp_get_edit_advert_link($listing->post->ID); ?>" class=""><span class="pacz-fic3-edit"></span><?php esc_attr_e('edit listing', 'ALSP'); ?></a>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-flaticon-trash27"></span><?php esc_attr_e('delete listing', 'ALSP'); ?></a>
							<?php
							if ($listing->level->raiseup_enabled && $listing->status == 'active' && $listing->post->post_status == 'publish') {
								$raise_up_link = strip_tags(apply_filters('alsp_raiseup_option', __('raise up listing', 'ALSP'), $listing));
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-fic3-arrows"></span>' . esc_attr($raise_up_link) . '</a>';
							}?>
							<?php
							if ($listing->status == 'expired') {
								$renew_link = strip_tags(apply_filters('alsp_renew_option', __('renew listing', 'ALSP'), $listing));
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $listing->post->ID)) . '" class="" title=""><span class="pacz-icon-refresh"></span>' . esc_attr($renew_link) . '</a>';
							}?>
							<?php
							if ($ALSP_ADIMN_SETTINGS['alsp_enable_stats']) {
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-icon-signal"></span>' . esc_attr__('view clicks stats', 'ALSP') . '</a>';
							}?>
							<?php
							if ($listing->status == 'active' && $listing->post->post_status == 'publish') {
								echo '<a href="' . get_permalink($listing->post->ID) . '" class=""><span class="pacz-li-view"></span>' . esc_attr__('view listing', 'ALSP') . '</a>';
							}?>
							<?php
							//if ($listing->status == 'active' && $listing->post->post_status == 'publish') {
								//echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-li-settings"></span>' . esc_attr__('Change Status', 'ALSP') . '</a>';
							//}
							?>
							<?php $listing_status = get_post_meta($listing->post->ID, '_listing_status', true);  ?>
							<?php if($listing_status == 'active' && $listing->post->post_status == 'publish'){ ?>
							
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $listing->post->ID, 'status_action' => 'private', 'referer' => urlencode($public_control->referer))); ?>" class=""><span class="pacz-li-settings"><?php _e('Make Private', 'ALSP'); ?></a>
							<?php }elseif($listing_status == 'active' && $listing->post->post_status == 'private'){ ?>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $listing->post->ID, 'status_action' => 'publish', 'referer' => urlencode($public_control->referer))); ?>" class=""><span class="pacz-li-settings"><?php _e('Make Public', 'ALSP'); ?></a>
							<?php } ?>
							
							
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'notice_to_admin', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-li-notepad"></span><?php esc_attr_e('Note to Admin', 'ALSP'); ?></a>
							<?php do_action('alsp_dashboard_listing_options', $listing); ?>
						 </div>
					</div>
					<?php } ?>
				</div>
				</div>
			</div>
			</div>
		<?php endwhile; ?>
		</div>
		</div>
		<?php alsp_renderPaginator($public_control->query, '', false); ?>
		<?php endif; ?>