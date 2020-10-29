(function($) {
	"use strict";
	
	$(function() {
		if (level_listingtypes.level_listingtypes_array.length > 0)
			removeUnnecessaryListingTypes();
	
		function removeUnnecessaryListingTypes() {
			$('ul.alsp-listingtypechecklist li').each(function(i) {
				if ($(this).find('>ul>li').length > 0) {
					if ($.inArray($(this).find('>label>input[type="checkbox"]').val(), level_listingtypes.level_listingtypes_array) == -1) {
						$(this).find('>label>input[type="checkbox"]').attr('disabled', 'disabled');
						var passed = false;
						$(this).find('ul>li>label>input[type="checkbox"]').each(function() {
							if ($.inArray($(this).val(), level_listingtypes.level_listingtypes_array) != -1) {
								passed = true;
								return false;
							}
						});
						if (!passed) {
							$(this).remove();
							removeUnnecessaryListingTypes();
							return false;
						}
					}
				} else if ($.inArray($(this).find('>label>input[type="checkbox"]').val(), level_listingtypes.level_listingtypes_array) == -1) {
					$(this).remove();
					removeUnnecessaryListingTypes();
					return false;
				}
			});
			$("ul.alsp-listingtypechecklist ul.children").filter( function() {
			    return $.trim($(this).html()) == '';
			}).remove();
		}
		
		$('ul.alsp-listingtypechecklist li').each(function() {
			if ($(this).children('ul').length > 0) {
				$(this).addClass('parent');
				$(this).prepend('<span class="alsp-listingtype-parent"></span>');
				if ($(this).find('ul input[type="checkbox"]:checked').length > 0)
					$(this).find('.alsp-listingtype-parent').prepend('<span class="alsp-listingtype-has-checked"></span>');
			} else
				$(this).prepend('<span class="alsp-listingtype-empty"></span>');
		});
		$('ul.alsp-listingtypechecklist li:not(.active) ul').each(function() {
			$(this).hide();
		});
		$('ul.alsp-listingtypechecklist li.parent > .alsp-listingtype-parent').click(function() {
			$(this).parent().toggleClass('active');
			$(this).parent().children('ul').slideToggle('fast');
		});
		$('ul.alsp-listingtypechecklist li input[type="checkbox"]').change(function() {
			$('ul.alsp-listingtypechecklist li').each(function() {
				if ($(this).children('ul').length > 0) {
					if ($(this).find('ul input[type="checkbox"]:checked').length > 0) {
						if ($(this).find('.alsp-listingtype-parent .alsp-listingtype-has-checked').length == 0)
							$(this).find('.alsp-listingtype-parent').prepend('<span class="alsp-listingtype-has-checked"></span>');
					} else
							$(this).find('.alsp-listingtype-parent .alsp-listingtype-has-checked').remove();
				}
			});
		});
		
		$("input[name=tax_input\\[alsp-listingtype\\]\\[\\]]").change(function() {alsp_manageListingTypes($(this))});
		$("#alsp-listingtype-pop input[type=checkbox]").change(function() {alsp_manageListingTypes($(this))});
		
		function alsp_manageListingTypes(checked_object) {
			if (checked_object.is(":checked") && level_listingtypes.level_listingtypes_number != 'unlimited') {
				if ($("input[name=tax_input\\[alsp-listingtype\\]\\[\\]]:checked").length > level_listingtypes.level_listingtypes_number) {
					alert(level_listingtypes.level_listingtypes_notice_number);
					$("#in-alsp-listingtype-"+checked_object.val()).attr("checked", false);
					$("#in-popular-alsp-listingtype-"+checked_object.val()).attr("checked", false);
					checked_object.trigger("change");
				}
			}
	
			if (checked_object.is(":checked") && level_listingtypes.level_listingtypes_array.length > 0) {
				var result = false;
				if ($.inArray(checked_object.val(), level_listingtypes.level_listingtypes_array) == -1) {
					alert(level_listingtypes.level_listingtypes_notice_disallowed);
					$("#in-alsp-listingtype-"+checked_object.val()).attr("checked", false);
					$("#in-popular-alsp-listingtype-"+checked_object.val()).attr("checked", false);
					checked_object.trigger("change");
				} else
					return true;
			} else
				return true;
		}
		
		$(".submit-listintype-hide-expand .alsp-expand-terms").click(function() {
			$('.alsp-listingtypes-tree-panel ul.alsp-listingtypechecklist li.parent').each(function() {
				$(this).addClass('active');
				$(this).children('ul').slideDown('fast');
			});
		});
		$(".submit-listintype-hide-expand .alsp-collapse-terms").click(function() {
			$('.alsp-listingtypes-tree-panel ul.alsp-listingtypechecklist li.parent').each(function() {
				$(this).removeClass('active');
				$(this).children('ul').slideUp('fast');
			});
		});
	});
})(jQuery);
