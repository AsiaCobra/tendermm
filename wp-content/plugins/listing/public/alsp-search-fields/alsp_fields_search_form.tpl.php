<?php if ($search_fields || $search_fields_advanced): ?>

		<script>
			(function($) {
				"use strict";
				
				$(function() {
					var fields_in_categories = new Array();
			<?php
			foreach ($search_fields_all AS $search_field): 
				if (!$search_field->content_field->isCategories() || $search_field->content_field->categories === array()): ?>
					fields_in_categories[<?php echo $search_field->content_field->id; ?>] = [];
			<?php else: ?>
					fields_in_categories[<?php echo $search_field->content_field->id; ?>] = [<?php echo implode(',', $search_field->content_field->categories); ?>];
			<?php endif; ?>
			<?php endforeach; ?>
			
					$(document).on("change", ".selected_tax_<?php echo ALSP_CATEGORIES_TAX; ?>", function() {
						hideShowFields($(this).val());
					});
			
					if ($(".selected_tax_<?php echo ALSP_CATEGORIES_TAX; ?>").length > 0) {
						hideShowFields($(".selected_tax_<?php echo ALSP_CATEGORIES_TAX; ?>").val());
					} else {
						hideShowFields(0);
					}
			
					function hideShowFields(id) {
						var selected_categories_ids = [id];
			
						$(".alsp-field-search-block-<?php echo $search_form_id; ?>").hide();
						$.each(fields_in_categories, function(index, value) {
							var show_field = false;
							if (value != undefined) {
								if (value.length > 0) {
									var key;
									for (key in value) {
										var key2;
										for (key2 in selected_categories_ids)
											if (value[key] == selected_categories_ids[key2])
												show_field = true;
									}
								}
								if ((value.length == 0 || show_field) && $(".alsp-field-search-block-"+index+"_<?php echo $search_form_id; ?>").length)
									$(".alsp-field-search-block-"+index+"_<?php echo $search_form_id; ?>").show();
							}
						});
					}
						// hack to remove visibility off hidden fields on initial load
				setTimeout(function(){
			        $('[class*="alsp-field-search-block-"]').unwrap();
				},500);
				});
			   
				
			})(jQuery);
		</script>

        <div id="temp-field-wrapper" style="display:none;">
		<?php
			foreach ($search_fields AS $search_field):
				$search_field->renderSearch($search_form_id, $columns, $defaults, $gap_in_fields); 
			endforeach; 
		?>
	    </div>
		<?php if ($is_advanced_search_panel): ?>
			<input type="hidden" name="use_advanced" id="use_advanced_<?php echo $search_form_id; ?>" value="<?php echo (int)$advanced_open; ?>" autocomplete="off" />
			<div id="alsp_advanced_search_fields_<?php echo $search_form_id; ?>" <?php if (!$advanced_open): ?>style="display: none; clear:both;"<?php endif; ?> class="alsp_search_fields_block clearfix">
				<?php
					foreach ($search_fields_advanced AS $search_field):
						$search_field->renderSearch($search_form_id, $columns, $defaults, $gap_in_fields);
					endforeach; 
				?>
			</div>
		<?php endif; ?>
<?php endif; ?>