<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php
					if ($locations_level_id)
						_e('Edit locations level', 'ALSP');
					else
						_e('Create new locations level', 'ALSP');
					?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<form method="POST" action="">
						<?php wp_nonce_field(ALSP_PATH, 'alsp_locations_levels_nonce');?>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<label><?php _e('Level name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="name"
											type="text"
											class="regular-text"
											value="<?php echo $locations_level->name; ?>" />
										<?php alsp_wpmlTranslationCompleteNotice(); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('In address line', 'ALSP'); ?></label>
									</th>
									<td>
										<input type="checkbox" value="1" name="in_address_line" <?php if ($locations_level->in_address_line) echo 'checked'; ?> />
										<p class="description"><?php _e("Render locations of this level in address line", 'ALSP'); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
						
						<?php
						if ($locations_level_id)
							submit_button(__('Save changes', 'ALSP'));
						else
							submit_button(__('Create locations level', 'ALSP'));
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>