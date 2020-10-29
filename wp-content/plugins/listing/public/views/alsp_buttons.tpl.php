<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php
global $alsp_instance;
if (($alsp_instance->getShortcodeProperty('alsp-main', 'is_single') || $alsp_instance->getShortcodeProperty('alsp-listing', 'is_single')) && ($ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2 || $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 3)){
	do_action('alsp_directory_frontpanel', $buttons_view);
	
	if ($buttons_view->isFavouritesButton()){
		if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list']){ 
			echo '<li>'; 
				if (alsp_checkQuickList($buttons_view->getListingId())){
			?>
				<a href="javascript:void(0);" class="add_to_favourites btn" data-listingid="<?php echo $buttons_view->getListingId(); ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList($buttons_view->getListingId())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="style1 checked pacz-icon-heart"></span><?php if (!$buttons_view->hide_button_text): ?> <?php if (ALSP_checkQuickList($buttons_view->getListingId())) _e('Bookmark', 'ALSP'); else _e('Bookmark', 'ALSP'); ?><?php endif; ?></a>
			<?php }else{ ?>
					<a href="javascript:void(0);" class="add_to_favourites btn" data-listingid="<?php echo $buttons_view->getListingId(); ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList($buttons_view->getListingId())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="style1 unchecked pacz-icon-heart-o"></span><?php if (!$buttons_view->hide_button_text): ?> <?php if (ALSP_checkQuickList($buttons_view->getListingId())) _e('Bookmark', 'ALSP'); else _e('Bookmark', 'ALSP'); ?><?php endif; ?></a>
			<?php }

			echo '</li>';
		} 
	}?>
	<li>
		<a href="#" data-popup-open="single_report_form" class="" data-toggle="tooltip" title="<?php _e('Report listing', 'ALSP'); ?>"><i class="pacz-fic4-warning-sign"></i><?php if (!$buttons_view->hide_button_text): ?><?php _e('Report', 'ALSP'); ?><?php endif; ?></a>
	</li>
	<?php if ($buttons_view->isEditButton()){ ?>
		<li>
			<a class="alsp-edit-listing-link btn" href="<?php echo alsp_get_edit_advert_link($buttons_view->getListingId()); ?>" data-toggle="tooltip" title="<?php _e('Edit listing', 'ALSP'); ?>"><span class="pacz-fic3-edit"></span><?php if (!$buttons_view->hide_button_text): ?><?php _e('Edit', 'ALSP'); ?><?php endif; ?></a>
		</li>
	<?php } ?>
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_print_button']){ ?>
	<?php if ($buttons_view->isPrintButton()){ ?>
		<script>
			var window_width = 860;
			var window_height = 800;
			var leftPosition, topPosition;
			(function($) {
				"use strict";
	
				$(function() {
					leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
					topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
				});
			})(jQuery);
		</script>
		<li>
			<a href="javascript:void(0);" class="alsp-print-listing-link btn" onClick="window.open('<?php echo add_query_arg('alsp_action', 'printlisting', get_permalink($buttons_view->getListingId())); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');"   data-toggle="tooltip" title="<?php _e('Print listing', 'ALSP'); ?>"><span class="pacz-fic3-printer"></span><?php if (!$buttons_view->hide_button_text): ?><?php _e('Print', 'ALSP'); ?><?php endif; ?></a>
		</li>
	<?php }
	} ?>
	
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_pdf_button']){
		if ($buttons_view->isPdfButton()){ ?>
		<li>
			<a href="javascript:void(0);" class="alsp-pdf-listing-link btn" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('alsp_action', 'pdflisting', $buttons_view->getListingId())); ?>');"   data-toggle="tooltip" title="<?php _e('Save listing in PDF', 'ALSP'); ?>"><span class="pacz-fic3-download"></span><?php if (!$buttons_view->hide_button_text): ?><?php _e('Download', 'ALSP'); ?><?php endif; ?></a>
		</li>
	<?php }} ?>
	<?php add_action('alsp_directory_frontpanel_after', $buttons_view); ?>
<?php }elseif (($alsp_instance->getShortcodeProperty('alsp-main', 'is_single') || $alsp_instance->getShortcodeProperty('alsp-listing', 'is_single')) && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 4){ ?>
	
	<div class="alsp-content">
	<div class="alsp-directory-frontpanel">
		<div class="cz-custom-btn-wrap">
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $buttons_view->isFavouritesButton()): ?>
				<div class="cz-btn-wrap">
					<a class="favourites-link btn" href="<?php echo alsp_directoryUrl(array('alsp_action' => 'myfavourites')); ?>"  data-toggle="tooltip" title="<?php _e('My bookmarks', 'ALSP'); ?>"><span class="glyphicon glyphicon-star"></span></a>
				</div>
			<?php endif; ?>
			<div class="cz-btn-wrap">
				<a href="#" data-popup-open="single_report_form" class="" data-toggle="tooltip" title="<?php _e('Report listing', 'ALSP'); ?>"><i class="pacz-fic4-warning-sign"></i><?php if (!$buttons_view->hide_button_text): ?><?php _e('Report', 'ALSP'); ?><?php endif; ?></a>
			</div>
			<?php if ($buttons_view->isEditButton()): ?>
				<div class="cz-btn-wrap">
					<a class="alsp-edit-listing-link btn" href="<?php echo alsp_get_edit_advert_link($buttons_view->getListingId()); ?>" data-toggle="tooltip" title="<?php _e('Edit listing', 'ALSP'); ?>"><span class="pacz-fic3-edit"></span></a>
				</div>
			<?php endif; ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_print_button'] && $buttons_view->isPrintButton()): ?>
				<script>
					var window_width = 860;
					var window_height = 800;
					var leftPosition, topPosition;
					(function($) {
						"use strict";
			
						$(function() {
							leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
								topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
						});
					})(jQuery);
				</script>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="alsp-print-listing-link btn" onClick="window.open('<?php echo add_query_arg('alsp_action', 'printlisting', get_permalink($buttons_view->getListingId())); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');"   data-toggle="tooltip" title="<?php _e('Print listing', 'ALSP'); ?>"><span class="pacz-fic3-printer"></span></a>
				</div>
			<?php endif; ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $buttons_view->isBookmarkButton()): ?>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="add_to_favourites btn" data-listingid="<?php echo $buttons_view->getListingId(); ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList($buttons_view->getListingId())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="style3 pacz-icon-<?php if (alsp_checkQuickList($buttons_view->getListingId())){ echo 'bookmark checked';}else{ echo 'bookmark-o unchecked';} ?>"></span></a>
				</div>
			<?php endif; ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_pdf_button'] && $buttons_view->isPdfButton()): ?>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="alsp-pdf-listing-link btn" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('alsp_action', 'pdflisting', get_permalink($buttons_view->getListingId()))); ?>');"   data-toggle="tooltip" title="<?php _e('Save listing in PDF', 'ALSP'); ?>"><span class="pacz-fic3-download"></span></a>
				</div>
			<?php endif; ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled']): ?>
				<div class="cz-btn-wrap">
				<?php 
					echo '<a class="alsp-sharing-btn"  data-popup-open="single_sharing_data" href="#"><i class="pacz-icon-share-alt"></i></a>';
					echo '<div class="alsp-custom-popup" data-popup="single_sharing_data">';
						echo '<div class="alsp-custom-popup-inner single-contact">';
							echo '<div class="alsp-popup-title">'.esc_html__('Share This Listing', 'ALSP').'<a class="alsp-custom-popup-close" data-popup-close="single_sharing_data" href="#"><i class="pacz-fic4-error"></i></a></div>';
							echo '<div class="alsp-popup-content">';
								alsp_renderTemplate('views/aslp_share_call_ajax.tpl.php', array('post_id' => $buttons_view->getListingId()));
							echo'</div>';
						echo'</div>';
					echo'</div>';
				?>
				</div>
			<?php endif; ?>
			<?php add_action('alsp_directory_frontpanel_after', $buttons_view); ?>
		</div>
	</div>
</div>
<?php
}else{ ?>
<div class="alsp-content">
	<div class="alsp-directory-frontpanel">
		<div class="cz-custom-btn-wrap">
			<?php do_action('alsp_directory_frontpanel', $buttons_view); ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $buttons_view->isFavouritesButton()): ?>
				<div class="cz-btn-wrap">
					<a class="favourites-link btn" href="<?php echo alsp_directoryUrl(array('alsp_action' => 'myfavourites')); ?>"  data-toggle="tooltip" title="<?php _e('My bookmarks', 'ALSP'); ?>"><span class="glyphicon glyphicon-star"></span></a>
				</div>
			<?php endif; ?>
		
				<div class="cz-btn-wrap">
					<a href="#" data-popup-open="single_report_form" class="" data-toggle="tooltip" title="<?php _e('Report listing', 'ALSP'); ?>"><i class="pacz-fic4-warning-sign"></i><?php if (!$buttons_view->hide_button_text): ?><?php _e('Report', 'ALSP'); ?><?php endif; ?></a>
				</div>
				<?php if ($buttons_view->isEditButton()): ?>
				<div class="cz-btn-wrap">
					<a class="alsp-edit-listing-link btn" href="<?php echo alsp_get_edit_advert_link($buttons_view->getListingId()); ?>" data-toggle="tooltip" title="<?php _e('Edit listing', 'ALSP'); ?>"><span class="pacz-fic3-edit"></span></a>
				</div>
				<?php endif; ?>
			
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_print_button'] && $buttons_view->isPrintButton()): ?>
				<script>
					var window_width = 860;
					var window_height = 800;
					var leftPosition, topPosition;
					(function($) {
						"use strict";
		
						$(function() {
							leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
							topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
						});
					})(jQuery);
				</script>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="alsp-print-listing-link btn" onClick="window.open('<?php echo add_query_arg('alsp_action', 'printlisting', get_permalink($buttons_view->getListingId())); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');"   data-toggle="tooltip" title="<?php _e('Print listing', 'ALSP'); ?>"><span class="pacz-fic3-printer"></span></a>
				</div>
				<?php endif; ?>
			
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $buttons_view->isBookmarkButton()): ?>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="add_to_favourites btn" data-listingid="<?php echo $buttons_view->getListingId(); ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList($buttons_view->getListingId())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="style3 pacz-icon-<?php if (alsp_checkQuickList($buttons_view->getListingId())){ echo 'bookmark checked';}else{ echo 'bookmark-o unchecked';} ?>"></span></a>
				</div>
				<?php endif; ?>
			
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_pdf_button'] && $buttons_view->isPdfButton()): ?>
				<div class="cz-btn-wrap">
					<a href="javascript:void(0);" class="alsp-pdf-listing-link btn" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('alsp_action', 'pdflisting', get_permalink($buttons_view->getListingId()))); ?>');"   data-toggle="tooltip" title="<?php _e('Save listing in PDF', 'ALSP'); ?>"><span class="pacz-fic3-download"></span></a>
				</div>
				<?php endif; ?>
			
			<?php add_action('alsp_directory_frontpanel_after', $buttons_view); ?>
		</div>
	</div>
</div>
<?php } ?>