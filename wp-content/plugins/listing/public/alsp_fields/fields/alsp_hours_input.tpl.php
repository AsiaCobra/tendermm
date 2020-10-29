<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?> clearfix">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?></label>
	<div class="hours-field-wrap alsp-submit-field-title">
		<?php foreach ($week_days AS $key=>$day): ?>
		<div class="">
			<span class="alsp-week-day"><?php echo $content_field->week_days_names[$key]; ?></span> <span class="alsp-week-day-controls"><select name="<?php echo $day; ?>_from_hour_<?php echo $content_field->id; ?>" class="alsp-week-day-input pacz-select2"><?php echo $content_field->getOptionsHour($day.'_from'); ?></select><?php if ($content_field->hours_clock == 12): ?> <select name="<?php echo $day; ?>_from_am_pm_<?php echo $content_field->id; ?>" class="alsp-week-day-input pacz-select2"><?php echo $content_field->getOptionsAmPm($day.'_from'); ?></select><?php endif; ?></span> &nbsp;&nbsp;-&nbsp;&nbsp; <span class="alsp-week-day-controls"><select name="<?php echo $day; ?>_to_hour_<?php echo $content_field->id; ?>" class="alsp-week-day-input pacz-select2"><?php echo $content_field->getOptionsHour($day.'_to'); ?></select><?php if ($content_field->hours_clock == 12): ?> <select name="<?php echo $day; ?>_to_am_pm_<?php echo $content_field->id; ?>" class="alsp-week-day-input pacz-select2"><?php echo $content_field->getOptionsAmPm($day.'_to'); ?></select><?php endif; ?></span> <label><input type="checkbox" name="<?php echo $day; ?>_closed_<?php echo $content_field->id; ?>" class="alsp-closed-day-option" <?php checked($content_field->value[$day.'_closed'], 1); ?> class="closed_cb" value="1" /> <?php _e('Closed', 'ALSP'); ?></label>
		</div>
		<?php endforeach; ?>
		<div class="">
			<button id="clear_hours_<?php echo $content_field->id; ?>" class="btn submit-page-buton hours-field-btn"><?php _e('Reset hours & minutes', 'ALSP'); ?></button>
		</div>
	</div>
</div>