	<?php global $ALSP_ADIMN_SETTINGS; ?>
	<div class="alsp-row alsp-form-group">
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_directions_functionality'] == 'builtin'): ?>
		<div class="alsp-col-md-12">
			<label class="alsp-control-label"><?php _e('Get directions from:', 'ALSP'); ?></label>
			<div class="has-feedback">
				<input type="text" id="from_direction_<?php echo $map_id; ?>" class="form-control <?php if ($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete']): ?>alsp-field-autocomplete<?php endif; ?>" placeholder="<?php esc_attr_e('Enter address or zip code', 'ALSP'); ?>" />
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
				<span class="alsp-get-location alsp-form-control-feedback glyphicon glyphicon-screenshot"></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="alsp-col-md-12">
			<?php $i = 1; ?>
			<?php foreach ($locations_array AS $location): ?>
			<div class="alsp-radio">
				<label>
					<input type="radio" name="select_direction" class="select_direction_<?php echo $map_id; ?>" <?php checked($i, 1); ?> value="<?php esc_attr_e($location->map_coords_1.' '.$location->map_coords_2); ?>" />
					<?php 
					if ($address = $location->getWholeAddress(false))
						echo $address;
					else 
						echo $location->map_coords_1.' '.$location->map_coords_2;
					?>
				</label>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="alsp-col-md-12">
			<input type="button" class="direction_button front-btn btn btn-primary" id="get_direction_button_<?php echo $map_id; ?>" value="<?php esc_attr_e('Get directions', 'ALSP'); ?>">
		</div>
		<div class="alsp-col-md-12">
			<div id="route_<?php echo $map_id; ?>" class="alsp-maps-direction-route"></div>
		</div>
		<?php elseif ($ALSP_ADIMN_SETTINGS['alsp_directions_functionality'] == 'google'): ?>
		<label class="alsp-col-md-12 alsp-control-label"><?php _e('directions to:', 'ALSP'); ?></label>
		<form action="//maps.google.com" target="_blank">
			<input type="hidden" name="saddr" value="Current Location" />
			<div class="alsp-col-md-12">
				<?php $i = 1; ?>
				<?php foreach ($locations_array AS $location): ?>
				<div class="alsp-radio">
					<label>
						<input type="radio" name="daddr" class="select_direction_<?php echo $map_id; ?>" <?php checked($i, 1); ?> value="<?php esc_attr_e($location->map_coords_1.','.$location->map_coords_2); ?>" />
						<?php 
						if ($address = $location->getWholeAddress(false))
							echo $address;
						else 
							echo $location->map_coords_1.' '.$location->map_coords_2;
						?>
					</label>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="alsp-col-md-12">
				<input class="btn btn-primary" type="submit" value="<?php esc_attr_e('Get directions', 'ALSP'); ?>" />
			</div>
		</form>
		<?php endif; ?>
	</div>