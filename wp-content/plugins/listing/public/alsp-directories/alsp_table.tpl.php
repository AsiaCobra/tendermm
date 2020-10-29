<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Listings directories', 'ALSP'); ?>
					<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new directory', 'ALSP') . '</a>', $_GET['page'], 'add'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<?php _e('Create pages with following shortcodes. Each directory must have own page with its unique shortcode. <strong>All these pages are mandatory pages.</strong>', 'ALSP'); ?>
					<form method="POST" action="<?php echo admin_url('admin.php?page=alsp_directories'); ?>">
						<?php 
							$directories_table->display();
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>