<?php global $ALSP_ADIMN_SETTINGS; ?>
<div class="alsp-content">
	<?php alsp_renderMessages(); ?>
	
	<div class="alsp-submit-section-adv <?php echo $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style']; ?>">
		<?php $max_columns_in_row = $public_control->args['columns']; ?>
		<?php $levels_counter = count($public_control->levels); ?>
		<?php if ($levels_counter > $max_columns_in_row) $levels_counter = $max_columns_in_row; ?>
		<?php $cols_width = floor(12/$levels_counter); ?>
		<?php $cols_width_percents = (100-1)/$levels_counter; ?>

		<?php $counter = 0; ?>
		<?php $tcounter = 0; ?>
		<?php foreach ($public_control->levels AS $level): ?>
		<?php $tcounter++; ?>
		<?php if ($counter == 0): ?>
		<div class="row" style="text-align: center;">
		<?php endif; ?>
			<div class="col-sm-<?php echo $cols_width; ?> alsp-plan-column  <?php if($level->featured_level && ($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-3' || $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-4')): ?> feature-plan-col <?php endif; ?>" style="width: <?php echo $cols_width_percents; ?>%;">
				<div class="alsp-panel alsp-panel-default alsp-text-center alsp-choose-plan <?php if($level->featured_level && ($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-3' || $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-4')): ?> feature-plan-scale <?php endif; ?>">
					<div class="alsp-panel-heading <?php if ($level->featured): ?>alsp-featured<?php endif; ?>">
						<?php if ($level->featured_level && $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-2'): ?>
							<span class="popular-level"><?php _e('most popular', 'ALSP'); ?></span>	
						<?php endif; ?>
						<h3>
							<?php echo $level->name; ?>
						</h3>
							<?php if ($alsp_instance->listings_packages->submitlisting_level_message($level, $directory)): ?>
							<div class="alsp-choose-plan-package-number">
								<?php echo $alsp_instance->listings_packages->submitlisting_level_message($level, $directory); ?>
							</div>
							<?php endif; ?>
							<?php do_action('alsp_submitlisting_level_name', $level); ?>
						<?php echo alsp_levelPriceString($level); ?>
						<?php if ($level->listings_in_package > 1): ?>
						<div class="alsp-choose-plan-package-number">
							<?php printf(__("for <strong>%d</strong> %s in the package", "ALSP"), $level->listings_in_package, _n($directory->single, $directory->plural, $level->listings_in_package)); ?>
						</div>
						<?php endif; ?>
						<?php if ($level->description) alsp_hintMessage(nl2br($level->description), 'bottom'); ?>
					</div>
					<ul class="alsp-list-group">
						<?php do_action('alsp_submitlisting_levels_rows_before', $level, '<li class="alsp-list-group-item pp-price">', '</li>'); ?>
						<?php alsp_renderTemplate(array(ALSP_FSUBMIT_TEMPLATES_PATH, 'package_details.tpl.php'), array('args' => $public_control->args, 'level' => $level)); ?>
						<?php do_action('alsp_submitlisting_levels_rows_after', $level, '<li class="alsp-list-group-item alsp-choose-plan-option">', '</li>'); ?>
						<?php if (!empty($alsp_instance->submit_pages_all)): ?>
						<li class="alsp-list-group-item pp-button">
							<a href="<?php echo alsp_submitUrl(array('level' => $level->id, 'directory' => $directory->id)); ?>" class="btn btn-primary  pricing dynamic-btn"><?php _e('Submit', 'ALSP'); ?></a>
						</li>
						<?php endif; ?>
					</ul>
				</div>          
			</div>

		<?php $counter++; ?>
		<?php if ($counter == $max_columns_in_row || $tcounter == $levels_counter || $tcounter == count($public_control->levels)): ?>
		</div>
		<?php endif; ?>
		<?php if ($counter == $max_columns_in_row) $counter = 0; ?>
		<?php endforeach; ?>
	</div>
</div>