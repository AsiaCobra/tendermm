<div class="alsp-content">
<?php if (!$static_image): ?>
	<script>
		alsp_map_markers_attrs_array.push(new alsp_map_markers_attrs('<?php echo $map_id; ?>', eval(<?php echo $locations_options; ?>), <?php echo ($enable_radius_circle) ? 1 : 0; ?>, <?php echo ($enable_clusters) ? 1 : 0; ?>, <?php echo ($show_summary_button) ? 1 : 0; ?>, <?php echo ($show_readmore_button) ? 1 : 0; ?>, <?php echo ($draw_panel) ? 1 : 0; ?>, '<?php echo $map_style; ?>', <?php echo ($enable_full_screen) ? 1 : 0; ?>, <?php echo ($enable_wheel_zoom) ? 1 : 0; ?>, <?php echo ($enable_dragging_touchscreens) ? 1 : 0; ?>, <?php echo ($center_map_onclick) ? 1 : 0; ?>, <?php echo ($show_directions) ? 1 : 0; ?>, <?php echo $map_args; ?>));
	</script>

	<?php
	//if ($search_form) {
		//$search_form = new alsp_search_map_form($map_id, $controller, $args, $directories, $listings_content);
	//}
	?>
	<div id="alsp-maps-canvas-wrapper-<?php echo $map_id; ?>" class="alsp-maps-canvas-wrapper <?php if ($search_form && $search_form->isCategoriesOrKeywords()) echo 'alsp-map-search-input-enabled'; ?> <?php if ($sticky_scroll):?>alsp-sticky-scroll<?php endif; ?>" data-id="<?php echo $map_id; ?>" <?php if ($sticky_scroll_toppadding):?>data-toppadding="<?php echo $sticky_scroll_toppadding; ?>"<?php endif; ?> data-height="<?php echo $height; ?>">
		<?php
		if ($search_form) {
			echo $search_form->display();
		} ?>
		<div id="alsp-maps-canvas-<?php echo $map_id; ?>" class="alsp-maps-canvas <?php if (!empty($args['search_on_map_open'])) echo 'alsp-sidebar-open'; ?>" <?php if ($custom_home): ?>data-custom-home="1"<?php endif; ?> data-shortcode-hash="<?php echo $map_id; ?>" style="<?php if ($width) echo 'max-width:' . $width . 'px'; ?> height: <?php if ($height) { if ($height == '100%') echo '100%'; else echo $height.'px'; } else echo '300px'; ?>"></div>
	</div>

	<?php if ($show_directions && alsp_getMapEngine() == 'google'): ?>
		<?php alsp_renderTemplate('alsp-maps/google_directions.tpl.php', array('map_id' => $map_id, 'locations_array' => $locations_array))?>
	<?php endif; ?>
<?php else: ?>
	<?php echo $map_object->buildStaticMap(); ?>
<?php endif; ?>
</div>