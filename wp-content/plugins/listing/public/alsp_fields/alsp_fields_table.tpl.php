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
											$("#content_fields_order").val($(".content_field_weight_id").map(function() {
												return $(this).val();
											}).get());
										}
									});
								});
							})(jQuery);
</script>
<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Content fields', 'ALSP'); ?>
					<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new field', 'ALSP') . '</a>', $_GET['page'], 'add'); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<div class="alsp-manager-page-wrap">
						<?php _e('You may order content fields by drag & drop.', 'ALSP'); ?>
						<form method="POST" action="<?php echo admin_url('admin.php?page=alsp_content_fields'); ?>">
							<input type="hidden" id="content_fields_order" name="content_fields_order" value="" />
							<?php 
							$content_fields_table->display();
							submit_button(__('Save changes', 'ALSP'), 'primary', 'submit_table');
							?>
						</form>
					</div>
				</div>
			</div>
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php _e('Content fields groups', 'ALSP'); ?>
					<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new fields group', 'ALSP') . '</a>', $_GET['page'], 'add_group'); ?>

				</div>
				<div class="pacz-box-content wp-clearfix">
					<form method="POST" action="<?php echo admin_url('admin.php?page=alsp_content_fields'); ?>">
						<?php $content_fields_groups_table->display(); ?>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>