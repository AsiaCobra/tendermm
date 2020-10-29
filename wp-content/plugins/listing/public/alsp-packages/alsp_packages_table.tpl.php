<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<script>
	(function($) {
	"use strict";

		$(function() {
			$("#the-list").sortable({
				placeholder: "ui-sortable-placeholder",
				helper: function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				},
				start: function(e, ui){
					ui.placeholder.height(ui.item.height());
				},
				update: function( event, ui ) {
					$("#levels_order").val($(".level_weight_id").map(function() {
						return $(this).val();
					}).get());
				}
		    }).disableSelection();
		});
	})(jQuery);
</script>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Listings levels', 'ALSP'); ?>
					<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new level', 'ALSP') . '</a>', $_GET['page'], 'add'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<?php _e('You may order listings levels by drag & drop rows in the table.', 'ALSP'); ?>

					<form method="POST" action="<?php echo admin_url('admin.php?page=alsp_levels'); ?>">
						<input type="hidden" id="levels_order" name="levels_order" value="" />
						<?php 
							$levels_table->display();
							
							submit_button(__('Save order', 'ALSP'));
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>