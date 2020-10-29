<div class="wrap about-wrap pacz-admin-wrap">
	<?php Alsp_Admin_Panel::listing_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php
					if ($field_id)
						_e('Edit content field', 'ALSP');
					else
						_e('Create new content field', 'ALSP');
					?>
				</div>
				<div class="pacz-box-content wp-clearfix">
<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<div class="alsp-configuration-page-wrap">
<?php
if ($field_id && $content_field->isConfigurationPage())
	printf('<a href="?page=%s&action=%s&field_id=%d">' . __('Configure', 'ALSP') . '</a>', $_GET['page'], 'configure', $field_id);
?>

<?php
if ($field_id && $content_field->isSearchConfigurationPage())
	printf('<a href="?page=%s&action=%s&field_id=%d">' . __('Configure search', 'ALSP') . '</a>', $_GET['page'], 'configure_search', $field_id);
?>

<?php if ($content_field->is_core_field): ?>
<p class="description"><?php esc_attr_e("You can't select assigned categories for core fields such as content, excerpt, categories, tags and addresses", 'ALSP'); ?></p>
<?php endif; ?>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#content_field_name").keyup(function() {
				$("#content_field_slug").val(alsp_make_slug($("#content_field_name").val()));
			});
	
			<?php if (!$content_field->is_core_field): ?>
			$("#type").change(function() {
				if (
					<?php
					foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
						$field_class_name = 'alsp_content_field_' . $content_field_type;
						if (class_exists($field_class_name)) {
							$_content_field = new $field_class_name;
							if (!$_content_field->canBeOrdered()) {
					?>
					$(this).val() == '<?php echo $content_field_type; ?>' ||
					<?php
							}
						}
					} ?>
				'x'=='y')
					$("#is_ordered_block").hide();
				else
					$("#is_ordered_block").show();
	
				if (
					<?php
					foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
						$field_class_name = 'alsp_content_field_' . $content_field_type;
						if (class_exists($field_class_name)) {
							$_content_field = new $field_class_name;
							if (!$_content_field->canBeRequired()) {
					?>
					$(this).val() == '<?php echo $content_field_type; ?>' ||
					<?php
							}
						}
					} ?>
				'x'=='y')
					$("#is_required_block").hide();
				else
					$("#is_required_block").show();
			});
			<?php endif; ?>
	
			<?php if ($content_field->icon_image): ?>
			$(".alsp-icon-tag").removeClass().addClass('alsp-icon-tag fa '+$("#icon_image").val());
			$(".alsp-icon-tag").show();
			<?php else: ?>
			$(".alsp-icon-tag").hide();
			<?php endif; ?>
	
			$(document).on("click", ".content_field_select_icon_image", function() {
				var dialog = $('<div id="select_field_icon_dialog"></div>').dialog({
					dialogClass: 'alsp-content',
					width: ($(window).width()*0.5),
					height: ($(window).height()*0.8),
					modal: true,
					resizable: false,
					draggable: false,
					title: '<?php echo esc_js(__('Select content field icon', 'ALSP')); ?>',
					open: function() {
						//alsp_ajax_loader_show();
						$.ajax({
							type: "POST",
							url: alsp_js_objects.ajaxurl,
							data: {'action': 'alsp_select_field_icon'},
							dataType: 'html',
							success: function(response_from_the_action_function){
								if (response_from_the_action_function != 0) {
									$('#select_field_icon_dialog').html(response_from_the_action_function);
									if ($("#icon_image").val())
										$("#"+$("#icon_image").val()).addClass("alsp-selected-icon");
								}
							},
							complete: function() {
								//alsp_ajax_loader_hide();
							}
						});
						$(document).on("click", ".ui-widget-overlay", function() { $('#select_field_icon_dialog').remove(); });
					},
					close: function() {
						$('#select_field_icon_dialog').remove();
					}
				});
			});
			$(document).on("click", ".fa-icon", function() {
				$(".alsp-selected-icon").removeClass("alsp-selected-icon");
				$("#icon_image").val($(this).attr('id'));
				$(".alsp-icon-tag").removeClass().addClass('alsp-icon-tag fa '+$("#icon_image").val());
				$(".alsp-icon-tag").show();
				$(this).addClass("alsp-selected-icon");
				$('#select_field_icon_dialog').remove();
			});
			$(document).on("click", "#reset_fa_icon", function() {
				$(".alsp-selected-icon").removeClass("alsp-selected-icon");
				$(".alsp-icon-tag").removeClass();
				$(".alsp-icon-tag").hide();
				$("#icon_image").val('');
				$('#select_field_icon_dialog').remove();
			});
		});
	})(jQuery);
</script>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Field name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						id="content_field_name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->name); ?>" />
					<?php alsp_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<?php if ($content_field->isSlug()) :?>
			<tr>
				<th scope="row">
					<label><?php _e('Field slug', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="slug"
						id="content_field_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->slug); ?>" />
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th scope="row">
					<label><?php _e('Hide name on single listing page', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_hide_name"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_hide_name); ?> />
					<p class="description"><?php _e("Hide field name at the frontend? on single listing page", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Hide name on grid style', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="is_hide_name_on_grid" id="is_hide_name_on_grid">
						<option value=""><?php _e('Select Option', 'ALSP'); ?></option>
						<option value="hide" <?php selected($content_field->is_hide_name_on_grid, 'hide'); ?> ><?php _e("Hide", 'ALSP'); ?></option>
						<option value="show_only_label" <?php selected($content_field->is_hide_name_on_grid, 'show_only_label'); ?> ><?php _e("Show only label", 'ALSP'); ?></option>
						<option value="show_icon_label" <?php selected($content_field->is_hide_name_on_grid, 'show_icon_label'); ?> ><?php _e("Show icon and label", 'ALSP'); ?></option>
						<option value="show_only_icon" <?php selected($content_field->is_hide_name_on_grid, 'show_only_icon'); ?> ><?php _e("Show only icon", 'ALSP'); ?></option>
					</select>
					<p class="description"><?php _e("Hide field name at the frontend? on grid style", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Hide name on list style', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="is_hide_name_on_list" id="is_hide_name_on_list">
						<option value=""><?php _e('Select Option', 'ALSP'); ?></option>
						<option value="hide" <?php selected($content_field->is_hide_name_on_list, 'hide'); ?> ><?php _e("Hide", 'ALSP'); ?></option>
						<option value="show_only_label" <?php selected($content_field->is_hide_name_on_list, 'show_only_label'); ?> ><?php _e("Show only label", 'ALSP'); ?></option>
						<option value="show_icon_label" <?php selected($content_field->is_hide_name_on_list, 'show_icon_label'); ?> ><?php _e("Show icon and label", 'ALSP'); ?></option>
						<option value="show_only_icon" <?php selected($content_field->is_hide_name_on_list, 'show_only_icon'); ?> ><?php _e("Show only icon", 'ALSP'); ?></option>
					</select>
					<p class="description"><?php _e("Hide field name at the frontend? on list style", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Hide name search on forms', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_hide_name_on_search"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_hide_name_on_search); ?> />
					<p class="description"><?php _e("Hide field name at the frontend? on search forms", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Display field inline', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_field_in_line"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_field_in_line); ?> />
					<p class="description"><?php _e("Display field inline on grid style", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Field description', 'ALSP'); ?></label>
				</th>
				<td>
					<textarea
						name="description"
						cols="60"
						rows="4" ><?php echo esc_textarea($content_field->description); ?></textarea>
					<?php alsp_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Field width', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="fieldwidth"
						id="content_field_width"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->fieldwidth); ?>" />
						<p class="description"><?php _e("value will be in %, this value will set content field width in custom Search form", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Field width on Archive Form', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="fieldwidth_archive"
						id="content_field_width_archive"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->fieldwidth_archive); ?>" />
						<p class="description"><?php _e("value will be in %, this value will set content field width in Archive Search form", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Icon image', 'ALSP'); ?></label>
				</th>
				<td>
					<span class="alsp-icon-tag"></span>
					<input type="hidden" name="icon_image" id="icon_image" value="<?php echo esc_attr($content_field->icon_image); ?>">
					<div>
						<a class="content_field_select_icon_image" href="javascript: void(0);"><?php _e('Select field icon', 'ALSP'); ?></a>
					</div>
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<label><?php _e('Field type', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<select name="type" id="type" <?php disabled($content_field->is_core_field); ?>>
						<option value=""><?php _e('- Select field type -', 'ALSP'); ?></option>
						<?php if ($content_field->is_core_field) :?>
						<option value="excerpt" <?php selected($content_field->type, 'excerpt'); ?> ><?php echo $fields_types_names['excerpt']; ?></option>
						<option value="content" <?php selected($content_field->type, 'content'); ?> ><?php echo $fields_types_names['content']; ?></option>
						<option value="categories" <?php selected($content_field->type, 'categories'); ?> ><?php echo $fields_types_names['categories']; ?></option>
						<option value="tags" <?php selected($content_field->type, 'tags'); ?> ><?php echo $fields_types_names['tags']; ?></option>
						<option value="address" <?php selected($content_field->type, 'address'); ?> ><?php echo $fields_types_names['address']; ?></option>
						<?php endif; ?>
						<option value="string" <?php selected($content_field->type, 'string'); ?> ><?php echo $fields_types_names['string']; ?></option>
						<option value="textarea" <?php selected($content_field->type, 'textarea'); ?> ><?php echo $fields_types_names['textarea']; ?></option>
						<option value="number" <?php selected($content_field->type, 'number'); ?> ><?php echo $fields_types_names['number']; ?></option>
						<option value="select" <?php selected($content_field->type, 'select'); ?> ><?php echo $fields_types_names['select']; ?></option>
						<option value="radio" <?php selected($content_field->type, 'radio'); ?> ><?php echo $fields_types_names['radio']; ?></option>
						<option value="checkbox" <?php selected($content_field->type, 'checkbox'); ?> ><?php echo $fields_types_names['checkbox']; ?></option>
						<option value="website" <?php selected($content_field->type, 'website'); ?> ><?php echo $fields_types_names['website']; ?></option>
						<option value="email" <?php selected($content_field->type, 'email'); ?> ><?php echo $fields_types_names['email']; ?></option>
						<option value="datetime" <?php selected($content_field->type, 'datetime'); ?> ><?php echo $fields_types_names['datetime']; ?></option>
						<option value="price" <?php selected($content_field->type, 'price'); ?> ><?php echo $fields_types_names['price']; ?></option>
						<option value="hours" <?php selected($content_field->type, 'hours'); ?> ><?php echo $fields_types_names['hours']; ?></option>
						<option value="fileupload" <?php selected($content_field->type, 'fileupload'); ?> ><?php echo $fields_types_names['fileupload']; ?></option>
					</select>
					<?php if ($content_field->is_core_field): ?>
					<p class="description"><?php esc_attr_e("You can't change the type of core fields", 'ALSP'); ?></p>
					<?php endif; ?>
				</td>
			</tr>

			<tr id="is_required_block" <?php if (!$content_field->canBeRequired()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php _e('Is this field required?', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_required"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_required); ?> />
				</td>
			</tr>
			<tr id="is_ordered_block" <?php if (!$content_field->canBeOrdered()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php _e('Order by field', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_ordered"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_ordered); ?> />
					<p class="description"><?php _e("Is it possible to order listings by this field?", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('On Grid view', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="on_exerpt_page"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_exerpt_page); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('On List view', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="on_exerpt_page_list"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_exerpt_page_list); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('On listing detail page', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="on_listing_page"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_listing_page); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('In map marker InfoWindow', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="on_map"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_map); ?> />
				</td>
			</tr>
			
			<script>
				(function($) {
					"use strict";
	
					$(function() {
						<?php if (!$content_field->is_core_field): ?>
						$("#type").change(function() {
							if (
								<?php 
								foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
									$field_class_name = 'alsp_content_field_' . $content_field_type;
									if (class_exists($field_class_name)) {
										$_content_field = new $field_class_name;
										if (!$_content_field->canBeSearched()) {
								?>
								$(this).val() == '<?php echo $content_field_type; ?>' ||
								<?php
										}
									}
								} ?>
							$(this).val() === '')
								$(".can_be_searched_block").hide();
							else
								$(".can_be_searched_block").show();
						});
						$("#on_search_form").click( function() {
							if ($(this).is(':checked'))
								$('input[name="advanced_search_form"]').removeAttr('disabled');
							else 
								$('input[name="advanced_search_form"]').attr('disabled', true);
						});
						$("#on_search_form_archive").click( function() {
							if ($(this).is(':checked'))
								$('input[name="advanced_archive_search_form"]').removeAttr('disabled');
							else 
								$('input[name="advanced_archive_search_form"]').attr('disabled', true);
						});
						$("#on_search_form_widget").click( function() {
							if ($(this).is(':checked'))
								$('input[name="advanced_widget_search_form"]').removeAttr('disabled');
							else 
								$('input[name="advanced_widget_search_form"]').attr('disabled', true);
						});
						<?php endif; ?>
					});
				})(jQuery);
			</script>
			<tr class="can_be_searched_block" <?php if (!$content_field->canBeSearched()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php _e('Search by this field', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						id="on_search_form"
						name="on_search_form"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_search_form); ?> />
				</td>
			</tr>
			<tr class="can_be_searched_block" <?php if (!$content_field->canBeSearched()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php _e('On advanced search panel?', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="advanced_search_form"
						type="checkbox"
						value="1"
						<?php checked($content_field->advanced_search_form); ?>
						<?php disabled(!$content_field->on_search_form)?> />
				</td>
			</tr>
			<?php do_action('alsp_content_field_html', $content_field); ?>
			
			<?php if ($content_field->isCategories()): ?>
			<tr>
				<th scope="row">
					<label><?php _e('Assigned categories', 'ALSP'); ?></label>
				</th>
				<td>
					<?php alsp_termsSelectList('categories', ALSP_CATEGORIES_TAX, $content_field->categories); ?>
				</td>
			</tr>
			<?php endif; ?>
			
		</tbody>
	</table>
	
	<?php
	if ($field_id)
		submit_button(__('Save changes', 'ALSP'));
	else
		submit_button(__('Create content field', 'ALSP'));
	?>
</form>
</div>
<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>
</div>
</div>
</div>
</div>
</div>