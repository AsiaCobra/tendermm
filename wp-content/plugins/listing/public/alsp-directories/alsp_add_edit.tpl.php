<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php
					if ($directory_id)
						_e('Edit directory', 'ALSP');
					else
						_e('Create new directory', 'ALSP');
					?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<form method="POST" action="">
						<?php wp_nonce_field(ALSP_PATH, 'alsp_directories_nonce');?>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<label><?php _e('Directory name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="name"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->name); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Single form', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="single"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->single); ?>" />
										<?php alsp_wpmlTranslationCompleteNotice(); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Plural form', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="plural"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->plural); ?>" />
										<?php alsp_wpmlTranslationCompleteNotice(); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<?php _e('Notice about slugs:', 'ALSP'); ?>
										<br />
										<?php _e('Slugs must contain only alpha-numeric characters, underscores or dashes. All slugs must be unique and different.', 'ALSP'); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Listing slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="listing_slug"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->listing_slug); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Category slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="category_slug"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->category_slug); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Listing Type slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="listingtype_slug"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->listingtype_slug); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Location slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="location_slug"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->location_slug); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Tag slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
									</th>
									<td>
										<input
											name="tag_slug"
											type="text"
											class="regular-text"
											value="<?php echo esc_attr($directory->tag_slug); ?>" />
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Assigned categories', 'ALSP'); ?></label>
										<?php echo alsp_get_wpml_dependent_option_description(); ?>
									</th>
									<td>
										<p class="description"><?php _e('You may define some special categories, those would be available for this directory', 'ALSP'); ?></p>
										<?php alsp_termsSelectList('categories', ALSP_CATEGORIES_TAX, $directory->categories); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Assigned Listing Types', 'ALSP'); ?></label>
										<?php echo alsp_get_wpml_dependent_option_description(); ?>
									</th>
									<td>
										<p class="description"><?php _e('You may define some special Listing Types, those would be available for this directory', 'ALSP'); ?></p>
										<?php alsp_termsSelectList('listingtypes', ALSP_TYPE_TAX, $directory->listingtypes); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Assigned locations', 'ALSP'); ?></label>
										<?php echo alsp_get_wpml_dependent_option_description(); ?>
									</th>
									<td>
										<p class="description"><?php _e('You may define some special locations, those would be available for this directory', 'ALSP'); ?></p>
										<?php alsp_termsSelectList('locations', ALSP_LOCATIONS_TAX, $directory->locations); ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label><?php _e('Listings levels', 'ALSP'); ?></label>
									</th>
									<td>
										<p class="description"><?php _e('You may define some special levels, those would be available for this directory', 'ALSP'); ?></p>
										<select multiple="multiple" name="levels[]" class="form-control alsp-form-group" style="height: 300px">
											<option value="" <?php if (!$directory->levels) echo 'selected'; ?>><?php _e('- Select All -', 'ALSP'); ?></option>
											<?php
											foreach ($alsp_instance->levels->levels_array AS $level):
											?>
											<option value="<?php echo $level->id; ?>" <?php if (in_array($level->id, $directory->levels)) echo 'selected'; ?>><?php echo $level->name; ?></option>
											<?php endforeach; ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
						
						<?php
						if ($directory_id)
							submit_button(__('Save changes', 'ALSP'));
						else
							submit_button(__('Create directory', 'ALSP'));
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>