(function($) {
	"use strict";
	
	var listingtype_icon_image_input, listingtype_font_icon_input, listingtype_font_icon_tag;
	
	$(function() {
		var listingtype_icon_image_url = listingtype_icons.listingtype_icons_url;

		$(document).on("click", ".listingtype_select_icon_image", function() {
			listingtype_icon_image_input = $(this).parent().find('.listingtype_icon_image');

			var dialog = $('<div id="select_field_icon_dialog"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: listingtype_icons.ajax_dialog_title,
				open: function() {
					alsp_ajax_loader_show();
					
					$.ajax({
						type: "POST",
						url: alsp_js_objects.ajaxurl,
						data: {'action': 'alsp_select_listingtype_icon_dialog'},
						dataType: 'html',
						success: function(response_from_the_action_function){
							if (response_from_the_action_function != 0) {
								$('#select_field_icon_dialog').html(response_from_the_action_function);
								if (listingtype_icon_image_input.val())
									$(".alsp-icon[icon_file='"+listingtype_icon_image_input.val()+"']").addClass("alsp-selected-icon");
							}
						},
						complete: function() {
							alsp_ajax_loader_hide();
						}
					});
					$(document).on("click", ".ui-widget-overlay", function() { $('#select_map_icon_dialog').remove(); });
				},
				close: function() {
					$('#select_field_icon_dialog').remove();
				}
			});
		});
		$(document).on("click", ".listingtype_alsp-icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			var icon_file = $(this).attr('icon_file');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_listingtype_icon', 'icon_file': icon_file, 'listingtype_id': listingtype_icon_image_input.parent().find(".listingtype_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (listingtype_icon_image_input) {
							listingtype_icon_image_input.val(icon_file);
							listingtype_icon_image_input.parent().find(".listingtype_icon_image_tag").attr('src', listingtype_icon_image_url+icon_file).show();
							listingtype_icon_image_input = false;
						}
					}
				},
				complete: function() {
					$(this).addClass("alsp-selected-icon");
					$('#select_field_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		$(document).on("click", "#listingtype_reset_icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_listingtype_icon', 'listingtype_id': listingtype_icon_image_input.parent().find(".listingtype_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (listingtype_icon_image_input) {
						listingtype_icon_image_input.val('');
						listingtype_icon_image_input.parent().find(".listingtype_icon_image_tag").attr('src', '').hide();
						listingtype_icon_image_input = false;
					}
				},
				complete: function() {
					$('#select_field_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		
		$(document).on("click", ".select_font_icon_image", function() {
			listingtype_font_icon_input = $(this).parent().find('.font_icon_image');
			listingtype_font_icon_tag = $(this).parent().find('.alsp-font-icon-tag');

			var dialog = $('<div id="select_font_icon_dialog"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: listingtype_icons.ajax_font_dialog_title,
				open: function() {
					alsp_ajax_loader_show();
					$.ajax({
						type: "POST",
						url: alsp_js_objects.ajaxurl,
						data: {'action': 'alsp_select_field_icon'},
						dataType: 'html',
						success: function(response_from_the_action_function){
							if (response_from_the_action_function != 0) {
								$('#select_font_icon_dialog').html(response_from_the_action_function);
								if (listingtype_font_icon_input.val())
									$("#"+listingtype_font_icon_input.val()).addClass("alsp-selected-icon");
							}
						},
						complete: function() {
							alsp_ajax_loader_hide();
						}
					});
					$(document).on("click", ".ui-widget-overlay", function() { $('#select_font_icon_dialog').remove(); });
				},
				close: function() {
					$('#select_field_icon_dialog').remove();
				}
			});
		});
		$(document).on("click", ".fa-icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			listingtype_font_icon_input.val($(this).attr('id'));
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_listingtype_font_icon', 'icon_name': listingtype_font_icon_input.val(), 'listingtype_id': listingtype_font_icon_input.parent().find(".listingtype_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (listingtype_font_icon_input) {
							listingtype_font_icon_tag.removeClass().addClass('alsp-font-icon-tag fa '+listingtype_font_icon_input.val());
							listingtype_font_icon_input = false;
						}
					}
				},
				complete: function() {
					$(this).addClass("alsp-selected-icon");
					$('#select_font_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		$(document).on("click", "#reset_fa_icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			listingtype_font_icon_input.val('');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_listingtype_font_icon', 'listingtype_id': listingtype_font_icon_input.parent().find(".listingtype_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (listingtype_font_icon_input) {
						listingtype_font_icon_tag.removeClass().addClass('alsp-font-icon-tag');
						listingtype_font_icon_input = false;
					}
				},
				complete: function() {
					$('#select_font_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		
		$(".font_color").wpColorPicker();
		$(document).on('focus', '.font_color', function(){
			var parent = $(this).parent();
            $(this).wpColorPicker()
            parent.find('.wp-color-result').click();
        }); 
		$(document).on("click", ".save_color", function() {
			var listingtype_font_color_input = $(this).parents(".alsp-content").find(".font_color");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_listingtype_font_color', 'color': listingtype_font_color_input.val(), 'listingtype_id': listingtype_font_color_input.parents(".alsp-content").find(".listingtype_id").val()},
				dataType: 'html',
				complete: function() {
					alsp_ajax_loader_hide();
				}
			});
		});
	});
	
})(jQuery);
