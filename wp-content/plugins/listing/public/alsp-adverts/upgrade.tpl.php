<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php echo sprintf(__('Change level of listing "%s"', 'ALSP'), $listing->title()); ?>
				</div>
				<div class="pacz-box-content wp-clearfix">
					<p><?php _e('The level of listing will be changed. You may upgrade or downgrade the level. If new level has an option of limited active period - expiration date of listing will be reassigned automatically.', 'ALSP'); ?></p>

					<form action="<?php echo admin_url('options.php?page=alsp_upgrade&listing_id=' . $listing->post->ID . '&upgrade_action=upgrade&referer=' . urlencode($referer)); ?>" method="POST">
						<?php if ($action == 'show'): ?>
						<h3><?php _e('Choose new level', 'ALSP'); ?></h3>
						<?php foreach ($levels->levels_array AS $level): ?>
						<?php if ($listing->level->id != $level->id && (!isset($listing->level->upgrade_meta[$level->id]) || !$listing->level->upgrade_meta[$level->id]['disabled'] || (current_user_can('editor') || current_user_can('administrator')))): ?>
						<p>
							<label><input type="radio" name="new_level_id" value="<?php echo $level->id; ?>" /> <?php echo apply_filters('alsp_level_upgrade_option', $level->name, $listing->level, $level); ?></label>
						</p>
						<?php endif; ?>
						<?php endforeach; ?>

						<input type="submit" value="<?php esc_attr_e('Change level', 'ALSP'); ?>" class="button button-primary" id="submit" name="submit">
						&nbsp;&nbsp;&nbsp;
						<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Cancel', 'ALSP'); ?></a>
						<?php elseif ($action == 'upgrade'): ?>
						<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Go back ', 'ALSP'); ?></a>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>