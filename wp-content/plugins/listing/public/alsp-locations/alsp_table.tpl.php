<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Locations levels', 'ALSP'); ?>
					<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new locations level', 'ALSP') . '</a>', $_GET['page'], 'add'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<?php $locations_levels_table->display(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>
