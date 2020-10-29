<article class="alsp-listing-location" id="post-<?php echo $location->id; ?>" data-location-id="<?php echo $location->id; ?>" style="height: auto;">
	<div class="alsp-listing-location-content">
		<?php
		if ($listing->logo_image) {
			$img_src = $listing->get_logo_url(array(150, 150));
		} else {
			$img_src = get_option('alsp_nologo_url');
		}
	
		?>
		<div class="w2gm-map-listing-logo-wrap">
			<figure class="alsp-map-listing-logo">
				<div class="alsp-map-listing-logo-img-wrap">
					<div style="background-image: url('<?php echo $img_src; ?>');" class="alsp-map-listing-logo-img">
						<img src="<?php echo $img_src; ?>" />
					</div>
				</div>
			</figure>
		</div>
		<div class="alsp-map-listing-content-wrap">
			<header class="alsp-map-listing-header">
				<h2><?php echo $listing->title(); ?> <?php do_action('alsp_listing_title_html', $listing, false); ?></h2>
			</header>
			<?php $listing->renderMapSidebarContentFields($location); ?>
		</div>
	</div>
	<?php 
		if ($show_directions_button || $show_readmore_button):
			if (!$show_directions_button || !$show_readmore_button) {
				$buttons_class = 'alsp-map-info-window-buttons-single';
			} else {
				$buttons_class = 'alsp-map-info-window-buttons';
			}
	?>
	<div class="<?php echo $buttons_class; ?> alsp-clearfix">
		<?php if ($show_directions_button): ?>
		<a href="https://www.google.com/maps/dir/Current+Location/<?php echo $location->map_coords_1; ?>,<?php echo $location->map_coords_2; ?>" target="_blank" class="btn btn-primary"><?php _e('« Directions', 'ALSP'); ?></a>
		<?php endif; ?>
		<?php if ($show_readmore_button): ?>
		<a href="javascript:void(0);" data-location-id="<?php echo $location->id; ?>" class="btn btn-primary alsp-show-on-map"><?php _e('On map »', 'ALSP')?></a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</article>