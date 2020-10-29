<script>
(function($) {
	"use strict";
	
	$(document).on('keyup', '#search_icon', function() {
		if ($(this).val()) {
			$(".alsp-icons-theme-block .fa-icon").hide();
			$(".alsp-icons-theme-block .fa-icon[id*='"+$(this).val()+"']").show();
		} else
			$(".alsp-icons-theme-block .fa-icon").show();
	});
})(jQuery);
</script>

<div class="alsp-content">
	<div class="row icon-search-wrapper">
		<div class="col-md-6 form-group pull-left">
			<input type="text" id="search_icon" class="form-control" placeholder="<?php _e('Search Icon', 'ALSP'); ?>" />
		</div>
		<div class="pull-right alsp-text-right">
			<input type="button" id="reset_fa_icon" class="button button-primary btn btn-primary form-control" value="<?php esc_attr_e('Reset Icon', 'ALSP'); ?>" />
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="alsp-icons-theme-block clearfix">
	<?php foreach ($icons AS $icon): ?>
		<span class="fa-icon fa fa-lg <?php echo $icon; ?>" id="<?php echo $icon; ?>" title="<?php echo $icon; ?>"></span>
	<?php endforeach;?>
	</div>
	<div class="clearfix"></div>
</div>