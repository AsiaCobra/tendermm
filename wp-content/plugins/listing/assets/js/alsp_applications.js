var alsp_maps = [];
var alsp_maps_attrs = [];
var alsp_infoWindows = [];
var alsp_drawCircles = [];
var alsp_searchAddresses = [];
var alsp_polygons = [];
var alsp_fullScreens = [];
var alsp_global_markers_array = [];
var alsp_global_locations_array = [];
var alsp_markerClusters = [];
var alsp_stop_touchmove_listener = function(e){
	e.preventDefault();
}
var alsp_glocation = (function(id, point, map_icon_file, map_icon_color, listing_title, listing_logo, listing_url, content_fields, anchor, nofollow, show_summary_button, show_readmore_button, map_id, is_ajax_markers) {
	this.id = id;
	this.point = point;
	this.map_icon_file = map_icon_file;
	this.map_icon_color = map_icon_color;
	this.listing_title = listing_title;
	this.listing_logo = listing_logo;
	this.listing_url = listing_url;
	this.content_fields = content_fields;
	this.anchor = anchor;
	this.nofollow = nofollow;
	this.show_summary_button = show_summary_button;
	this.show_readmore_button = show_readmore_button;
	this.alsp_placeMarker = function(map_id) {
		this.marker = alsp_placeMarker(this, map_id);
		return this.marker;
	};
	this.is_ajax_markers = is_ajax_markers;
});
var _alsp_map_markers_attrs_array;
var alsp_dragended;
var ZOOM_FOR_SINGLE_MARKER = 17;

var alsp_map_backend = null;
var alsp_allow_map_zoom_backend = true; // allow/disallow map zoom in listener, this option needs because alsp_map_backend.setZoom() also calls this listener
var alsp_geocoder_backend = null;
var alsp_infoWindow_backend = null;
var alsp_markersArray_backend = [];
var alsp_glocation_backend = (function(index, point, location, address_line_1, address_line_2, zip_or_postal_index, map_icon_file) {
	this.index = index;
	this.point = point;
	this.location = location;
	this.address_line_1 = address_line_1;
	this.address_line_2 = address_line_2;
	this.zip_or_postal_index = zip_or_postal_index;
	this.map_icon_file = map_icon_file;
	this.alsp_placeMarker = function() {
		return alsp_placeMarker_backend(this);
	};
	this.compileAddress = function() {
		var address = this.address_line_1;
		if (this.address_line_2)
			address += ", "+this.address_line_2;
		if (this.location) {
			if (address)
				address += " ";
			address += this.location;
		}
		if (alsp_maps_objects.default_geocoding_location) {
			if (address)
				address += " ";
			address += alsp_maps_objects.default_geocoding_location;
		}
		if (this.zip_or_postal_index) {
			if (address)
				address += " ";
			address += this.zip_or_postal_index;
		}
		return address;
	};
	this.compileHtmlAddress = function() {
		var address = this.address_line_1;
		if (this.address_line_2)
			address += ", "+this.address_line_2;
		if (this.location) {
			if (this.address_line_1 || this.address_line_2)
				address += "<br />";
			address += this.location;
		}
		if (this.zip_or_postal_index)
			address += " "+this.zip_or_postal_index;
		return address;
	};
	this.setPoint = function(point) {
		this.point = point;
	};
});

/* Stack-based Douglas Peucker line simplification routine 
returned is a reduced GLatLng array 
After code by  Dr. Gary J. Robinson,
Environmental Systems Science Centre,
University of Reading, Reading, UK
*/
function alsp_GDouglasPeucker(source, kink) {
	var n_source, n_stack, n_dest, start, end, i, sig;    
	var dev_sqr, max_dev_sqr, band_sqr;
	var x12, y12, d12, x13, y13, d13, x23, y23, d23;
	var F = ((Math.PI / 180.0) * 0.5 );
	var index = new Array();
	var sig_start = new Array();
	var sig_end = new Array();

	if ( source.length < 3 ) 
		return(source);

	n_source = source.length;
	band_sqr = kink * 360.0 / (2.0 * Math.PI * 6378137.0);
	band_sqr *= band_sqr;
	n_dest = 0;
	sig_start[0] = 0;
	sig_end[0] = n_source-1;
	n_stack = 1;

	while ( n_stack > 0 ) {
		start = sig_start[n_stack-1];
		end = sig_end[n_stack-1];
		n_stack--;

		if ( (end - start) > 1 ) {
			x12 = (source[end].lng() - source[start].lng());
			y12 = (source[end].lat() - source[start].lat());
			if (Math.abs(x12) > 180.0) 
				x12 = 360.0 - Math.abs(x12);
			x12 *= Math.cos(F * (source[end].lat() + source[start].lat()));
			d12 = (x12*x12) + (y12*y12);

			for ( i = start + 1, sig = start, max_dev_sqr = -1.0; i < end; i++ ) {                                    
				x13 = (source[i].lng() - source[start].lng());
				y13 = (source[i].lat() - source[start].lat());
				if (Math.abs(x13) > 180.0) 
					x13 = 360.0 - Math.abs(x13);
				x13 *= Math.cos (F * (source[i].lat() + source[start].lat()));
				d13 = (x13*x13) + (y13*y13);

				x23 = (source[i].lng() - source[end].lng());
				y23 = (source[i].lat() - source[end].lat());
				if (Math.abs(x23) > 180.0) 
					x23 = 360.0 - Math.abs(x23);
				x23 *= Math.cos(F * (source[i].lat() + source[end].lat()));
				d23 = (x23*x23) + (y23*y23);

				if ( d13 >= ( d12 + d23 ) )
					dev_sqr = d23;
				else if ( d23 >= ( d12 + d13 ) )
					dev_sqr = d13;
				else
					dev_sqr = (x13 * y12 - y13 * x12) * (x13 * y12 - y13 * x12) / d12;// solve triangle

				if ( dev_sqr > max_dev_sqr  ){
					sig = i;
					max_dev_sqr = dev_sqr;
				}
			}

			if ( max_dev_sqr < band_sqr ) {
				index[n_dest] = start;
				n_dest++;
			} else {
				n_stack++;
				sig_start[n_stack-1] = sig;
				sig_end[n_stack-1] = end;
				n_stack++;
				sig_start[n_stack-1] = start;
				sig_end[n_stack-1] = sig;
			}
		} else {
			index[n_dest] = start;
			n_dest++;
		}
	}
	index[n_dest] = n_source-1;
	n_dest++;

	var r = new Array();
	for(var i=0; i < n_dest; i++)
		r.push(source[index[i]]);

	return r;
}

(function($) {
	"use strict";
	
	$(function() {
		//alsp_get_rid_of_select2_choosen();
		alsp_process_main_search_fields();
		alsp_nice_scroll();
		alsp_custom_input_controls();
		alsp_my_location_buttons();
		alsp_tokenizer();
		alsp_add_body_classes();
		alsp_equalColumnsHeight();
		//alsp_equalColumnsHeightEvent();
		alsp_listings_carousel();
		alsp_radius_slider();
		alsp_hint();
		alsp_favourites();
		alsp_check_is_week_day_closed();
		alsp_listing_tabs();
		alsp_dashboard_tabs();
		alsp_lightbox();
		alsp_sticky_scroll();
		alsp_tooltips();
		alsp_ratings();
		alsp_hours_content_field();
		alsp_full_height_maps();
		alsp_grid_field_drop_menu();
		alsp_load_ajax_initial_elements();
		//append_inline_fields_content();
		//isotop_load_fix_tab();
		if($('.pacz-loop-main-wrapper').hasClass("pacz-loop-main-wrapper2")){
			alsp_masonry_layout();
			isotop_load_fix2();
			//isotop_distroy();
		}
	});
	
	window.alsp_nice_scroll = function() {
		var nice_scroll_params = {
				cursorcolor: "#bdbdbd",
				cursorborderradius: "2px",
				cursorwidth: "7px",
				autohidemode: false
		}
		$(".alsp-map-listings-panel").niceScroll(nice_scroll_params);
		$(".alsp-dropdowns-menu").niceScroll(nice_scroll_params);
	}

	window.alsp_my_location_buttons = function() {
		if (alsp_maps_objects.enable_my_location_button) {
			$(".alsp-get-location").attr("title", alsp_maps_objects.my_location_button);
			$("body").on("click", ".alsp-get-location", function() {
				if (!$(this).hasClass('alsp-search-input-reset')) {
					var input = $(this).parent().find("input");
					alsp_geocodeField(input, alsp_maps_objects.my_location_button_error);
				}
			});
		}
	}
	
	window.alsp_tokenizer = function() {
		$(".alsp-tokenizer").tokenize({ });
	}

	window.alsp_add_body_classes = function() {
		if ("ontouchstart" in document.documentElement)
			$("body").addClass("alsp-touch");
		else
			$("body").addClass("alsp-no-touch");
	}
	
	window.alsp_listing_tabs = function() {
		$(document).on('click', '.alsp-listing-tabs a', function(e) {	  
			  e.preventDefault();
			  alsp_show_tab($(this));
		});
		var hash = window.location.hash.substring(1);
		if (hash == 'respond' || hash.indexOf('comment-', 0) >= 0) {
			alsp_show_tab($('.alsp-listing-tabs a[data-tab="#comments-tab"]'));
		} else if (hash && $('.alsp-listing-tabs a[data-tab="#'+hash+'"]').length) {
			alsp_show_tab($('.alsp-listing-tabs a[data-tab="#'+hash+'"]'));
		}
	}
	window.alsp_show_tab = function(tab) {
		$('.alsp-listing-tabs li').removeClass('active');
		tab.parent().addClass('active');
		$('.tab-content .tab-pane').removeClass('in active');
		$('.tab-content '+tab.data('tab')).addClass('in active');
		if (tab.data('tab') == '#addresses-tab')
			 for (var key in alsp_maps) {
				if (typeof alsp_maps[key] == 'object') {
					alsp_setZoomCenter(alsp_maps[key]);
				}
			 }
	};
	
	window.alsp_radius_slider = function () {
		$('.alsp-radius-slider').each(function() {
			var id = $(this).data("id");
			if(alsp_js_objects.alsp_miles_kilometers_in_search == 'miles'){
				var parameters = 'Mi';
			}else{
				var parameters = 'Km';
			}
			$('#radius_slider_'+id).slider({
				isRTL: alsp_js_objects.is_rtl,
				min: parseInt(slider_params.min),
				max: parseInt(slider_params.max),
				range: "min",
				value: $("#radius_"+id).val(),
				slide: function(event, ui) {
					//$("#radius_label_"+id).html(ui.value);
					if(alsp_js_objects.alsp_show_radius_tooltip){
						$('.ui-slider-handle:first').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.value + ' '+ parameters +'</div></div>');
					}else{
						$("#radius_label_"+id).html(ui.value);
						//$("#radius_label_ $search_form_id;").html(ui.value);
						//$("#radius_$search_form_id;").val(ui.value);
					}
				},
				stop: function(event, ui) {
					$("#radius_"+id).val(ui.value);
					if (
						$("#radius_"+id).val() > 0 &&
						$(this).parents("form").find("input[name='address']").length &&
						$(this).parents("form").find("input[name='address']").val()
					) {
						$("#radius_"+id).trigger("change");
					}
				}
			});
		});
	}
	
	window.alsp_hint = function () {
		$("a.alsp-hint-icon").each(function() {
			$(this).popover({
				trigger: "hover",
				//trigger: "manual",
				container: $(this).parents(".alsp-content")
			});
		});
	}
	
	window.alsp_favourites = function () {
		// Place listings to/from favourites list
		if ($('.add_to_favourites').length) {
			$('.add_to_favourites').click(function() {
				var listing_id = $(this).data("listingid");
				//alert(listing_id);
				if ($.cookie("favourites") != null) {
					var favourites_array = $.cookie("favourites").split('*');
				} else {
					var favourites_array = new Array();
				}
				if (alsp_in_array(listing_id, favourites_array) === false) {
					favourites_array.push(listing_id);
					$(this).find('span.style1').removeClass(alsp_js_objects.not_in_favourites_icon).addClass(alsp_js_objects.in_favourites_icon);
					$(this).find('span.style2').removeClass(alsp_js_objects.not_in_favourites_icon2).addClass(alsp_js_objects.in_favourites_icon2);
					$(this).find('span.style3').removeClass(alsp_js_objects.not_in_favourites_icon3).addClass(alsp_js_objects.in_favourites_icon3);
					$(this).find('span.alsp-bookmark-button').text(alsp_js_objects.not_in_favourites_msg);
				} else {
					for (var count=0; count<favourites_array.length; count++) {
						if (favourites_array[count] == listing_id) {
							delete favourites_array[count];
						}
					}
					$(this).find('span.style1').removeClass(alsp_js_objects.in_favourites_icon).addClass(alsp_js_objects.not_in_favourites_icon);
					$(this).find('span.style2').removeClass(alsp_js_objects.in_favourites_icon2).addClass(alsp_js_objects.not_in_favourites_icon2);
					$(this).find('span.style3').removeClass(alsp_js_objects.in_favourites_icon3).addClass(alsp_js_objects.not_in_favourites_icon3);
					$(this).find('span.alsp-bookmark-button').text(alsp_js_objects.in_favourites_msg);
				}
				$.cookie("favourites", favourites_array.join('*'), {expires: 365, path: "/"});
				return false;
			});
		}
	}
	window.alsp_check_is_week_day_closed = function () {
		$('.closed_cb').each(function() {
			_alsp_check_is_week_day_closed($(this));
	    });
		$('.closed_cb').click(function() {
			_alsp_check_is_week_day_closed($(this));
	    });
	}

	window._alsp_check_is_week_day_closed = function (cb) {
		if (cb.is(":checked"))
			cb.parent().find(".alsp-week-day-input").attr('disabled', 'disabled');
    	else
    		cb.parent().find(".alsp-week-day-input").removeAttr('disabled');
	}
	
	if (!(/^((?!chrome|android).)*safari/i.test(navigator.userAgent))) {
		// refresh page on page back button (except safari)
		$(window).on('popstate', function() {
			//location.reload(true);
		});
	}
	
	window.alsp_dashboard_tabs = function() {
		$(".alsp-dashboard-tabs.nav-tabs li").click(function(e) {
			window.location = $(this).find("a").attr("href");
		});
	}
	
	window.alsp_lightbox = function() {
		// Special trick for lightbox
		if (typeof lightbox != 'undefined') {
			var dataLightboxValue = $("#alsp-lighbox-images a").data("alsp-lightbox");
			$("#alsp-lighbox-images a").removeAttr("data-alsp-lightbox").attr("data-lightbox", dataLightboxValue);
			$('body').on('click', 'a[data-alsp-lightbox]', function(event) {
				event.preventDefault();
				var link = $('#alsp-lighbox-images a[href="'+$(this).attr('href')+'"]');
				lightbox.option({
				      'wrapAround': true
				    })
				lightbox.start(link);
			});
		}
	}
	
	window.alsp_sticky_scroll = function() {
		$('.alsp-sticky-scroll').each(function() {
			var element = $(this);
			var id = element.data("id");
			var toppadding = (element.data("toppadding")) ? element.data("toppadding") : 0;
			//var height = (element.data("height")) ? element.data("height") : null;
			
			if (toppadding == 0 && $("body").hasClass("admin-bar")) {
				toppadding = 32;
			}
			
			if ($('.site-header.header-fixed.fixed:visible').length) {
				var headerHeight = $('.site-header.header-fixed.fixed').outerHeight();
				toppadding = toppadding + headerHeight;
			}

			if (!$("#alsp-scroller-anchor-"+id).length) {
				var anchor = $("<div>", {
					id: 'alsp-scroller-anchor-'+id
				});
				element.before(anchor);
	
				var background = $("<div>", {
					id: 'alsp-sticky-scroll-background-'+id,
					style: {position: 'relative'}
				});
				element.after(background);
			}
				
			window["alsp_sticky_scroll_toppadding_"+id] = toppadding;
	
			$("#alsp-sticky-scroll-background-"+id).position().left = element.position().left;
			$("#alsp-sticky-scroll-background-"+id).position().top = element.position().top;
			$("#alsp-sticky-scroll-background-"+id).width(element.width());
			$("#alsp-sticky-scroll-background-"+id).height(element.height());

			var alsp_scroll_function = function(e) {
				var id = e.data.id;
				var toppadding = e.data.toppadding;
				var b = $(document).scrollTop();
				var d = $("#alsp-scroller-anchor-"+id).offset().top - toppadding;
				var c = e.data.obj;
				var e = $("#alsp-sticky-scroll-background-"+id);
				
				c.width(c.parent().width()).css({ 'z-index': 100 });
		
				// .alsp-scroller-bottom - this is special class used to restrict the area of scroll of map canvas
				if ($(".alsp-scroller-bottom").length) {
					var f = $(".alsp-scroller-bottom").offset().top - (c.height() + toppadding);
				} else {
					var f = $(document).height();
				}
		
				if (f > c.height()) {
					if (b >= d && b < f) {
						c.css({ position: "fixed", top: toppadding });
						e.css({ position: "relative" });
					} else {
						if (b <= d) {
							c.stop().css({ position: "relative", top: "" });
							e.css({ position: "absolute" });
						}
						if (b >= f) {
							c.css({ position: "absolute" });
							c.stop().offset({ top: f + toppadding });
							e.css({ position: "relative" });
						}
					}
				} else {
					c.css({ position: "relative", top: "" });
					e.css({ position: "absolute" });
				}
			};
			if ($(document).width() >= 768) {
				var args = {id: id, obj: $(this), toppadding: toppadding};
				$(window).scroll(args, alsp_scroll_function);
				alsp_scroll_function({data: args});
			}

			$("#alsp-sticky-scroll-background-"+id).css({ position: "absolute" });

			/*if (height == '100%') {
				element.height(function(index, height) {
					return window.innerHeight - $("#scroller_anchor_"+id).outerHeight(true) - toppadding;
				});
				$(window).resize(function(){
					element.height(function(index, height) {
						return window.innerHeight - $("#scroller_anchor_"+id).outerHeight(true) - toppadding;
					});
				});
			}*/
		});
	}
	
	window.alsp_full_height_maps = function() {
		$('.alsp-maps-canvas-wrapper').each(function() {
			var element = $(this);
			var height = (element.data("height")) ? element.data("height") : null;
			
			if (height == '100%') {
				var toppadding = (element.data("toppadding")) ? element.data("toppadding") : 0;
				
				if (toppadding == 0 && $("body").hasClass("admin-bar")) {
					toppadding = 32;
				}
				
				if ($('.site-header.header-fixed.fixed:visible').length) {
					var headerHeight = $('.site-header.header-fixed.fixed').outerHeight();
					toppadding = toppadding + headerHeight;
				}

				element.height(function(index, height) {
					return window.innerHeight - toppadding;
				});
				$(window).resize(function(){
					element.height(function(index, height) {
						return window.innerHeight - toppadding;
					});
				});
			}
		});
	}
	
	window.alsp_tooltips = function() {
		$('[data-toggle="tooltip"]').tooltip({
			 trigger : 'hover',
			 html: true
		});
	}
	
	window.alsp_ratings = function() {
		$('body').on('click', '.alsp-rating-active .alsp-rating-icon', function() {
			var rating = $(this).parent(".alsp-rating-stars");
			var rating_wrapper = $(this).parents(".alsp-rating");
			
			rating_wrapper.fadeTo(2000, 0.3);
			
			$.ajax({
	        	url: alsp_js_objects.ajaxurl,
	        	type: "POST",
	        	dataType: "json",
	            data: {
	            	action: 'alsp_save_rating',
	            	rating: $(this).data("rating"),
	            	post_id: rating.data("listing"),
	            	_wpnonce: rating.data("nonce")
	            },
	            rating_wrapper: rating_wrapper,
	            success: function(response_from_the_action_function){
	            	if (response_from_the_action_function != 0 && response_from_the_action_function.html) {
	            		this.rating_wrapper
	            		.replaceWith(response_from_the_action_function.html)
	            		.fadeIn("fast");
	            	}
	            }
	        });
		});
	}
	
	window.alsp_hours_content_field = function() {
		function close_option(option) {
			if (option.is(":checked")) {
				option.parents(".alsp-week-day-wrap").find("select").attr("disabled", "disabled");
			} else {
				option.parents(".alsp-week-day-wrap").find("select").removeAttr("disabled");
			}
		}
		$(".alsp-closed-day-option").each(function() {
			close_option($(this));
		});
		$("body").on("change", ".alsp-closed-day-option", function() {
			close_option($(this));
		});
		
		$("body").on("click", ".alsp-clear-hours", function() {
			$(this).parents(".alsp-field-input-block").find("select").each( function() { $(this).val($(this).find("option:first").val()).removeAttr('disabled'); });
			$(this).parents(".alsp-field-input-block").find('input[type="checkbox"]').each( function() { $(this).attr('checked', false); });
			return false;
		});
	}
	
	window.alsp_custom_input_controls = function() {
		// Custom input controls
		$(".alsp-checkbox label, .alsp-radio label").each(function() {
			if (!$(this).find(".alsp-control-indicator").length) {
				$(this).append($("<div>").addClass("alsp-control-indicator"));
			}
		});
	}
	$(document).ajaxComplete(function(event, xhr, settings) {
		if (settings.url === alsp_js_objects.ajaxurl) {
			alsp_custom_input_controls();
		}
	});

	window.alsp_get_rid_of_select2_choosen = function() {
		$("select.form-control").each(function (i, obj) {
			// get rid of select2
			if ($(obj).hasClass('select2-hidden-accessible') || $('#s2id_' + $(obj).attr('id')).length) {
				$(obj).select2('destroy');
			}
			// get rid of chosen
			if ($('#' + $(obj).attr('id') + '_chosen').length) {
				$(obj).chosen('destroy');
			}
		});
	}
	
	window.alsp_process_main_search_fields = function() {
		if (typeof categories_combobox != "undefined") {
			$(".alsp-selectmenu-alsp-category").categories_combobox();
			$(".alsp-selectmenu-alsp-type").listingtype_combobox();
			$(".alsp-selectmenu-alsp-location").locations_combobox();
			$(".alsp-address-autocomplete").address_autocomplete();
			$(".alsp-keywords-autocomplete").keywords_autocomplete();
		}
	}
	
	window.alsp_advancedSearch = function(uID, more_filters, less_filters) {
		if ($("#use_advanced_" + uID).val() == 1) {
			$("#alsp-advanced-search-label_" + uID).find(".alsp-advanced-search-text").text(less_filters);

			$("#alsp-advanced-search-label_" + uID).find(".alsp-advanced-search-toggle")
			.removeClass("glyphicon-chevron-down")
			.addClass("glyphicon-chevron-up");
		}
		$("#alsp-advanced-search-label_" + uID).off("click");
		$("#alsp-advanced-search-label_" + uID).click(function(e) {
			if ($("#alsp_advanced_search_fields_" + uID).is(":hidden")) {
				$(this).find(".alsp-advanced-search-text").text(less_filters);
				$("#use_advanced_" + uID).val(1);
				$("#alsp_advanced_search_fields_" + uID).show();

				$(this).find(".alsp-advanced-search-toggle")
				.removeClass("glyphicon-chevron-down")
				.addClass("glyphicon-chevron-up");
			} else {
				$(this).find(".alsp-advanced-search-text").text(more_filters);
				$("#use_advanced_" + uID).val(0);
				$("#alsp_advanced_search_fields_" + uID).hide();

				$(this).find(".alsp-advanced-search-toggle")
				.removeClass("glyphicon-chevron-up")
				.addClass("glyphicon-chevron-down");
			}
		});
	};
	
	window.alsp_equalColumnsHeight = function() {
		/* var heights = new Array();

		// Loop to get all element heights
		setTimeout(function(){
		$('.alsp-listings-grid:not(.masonry) .no-carousel .alsp-listing, .userpanel-item-wrap').each(function() {

			// Need to let sizes be whatever they want so no overflow on resize
			$(this).css('min-height', '0');
			$(this).css('max-height', 'none');
			$(this).css('height', 'auto');

			// Then add size (no units) to array
	 		heights.push($(this).height());
		});

		// Find max height of all elements
		var max = Math.max.apply( Math, heights );

		// Set all heights to max height
		$('.alsp-listings-grid .no-carousel .alsp-listing, .userpanel-item-wrap').each(function() {
			$(this).css('height', max + 'px');
		});	
		}, 500); */
		
		if ($(document).width() >= 768) {
			setTimeout(function(){
				$(".alsp-listings-grid:not(.masonry) .no-carousel .alsp-listing, .userpanel-item-wrap").css('height', '');

				var currentTallest = 0;
				var currentRowStart = 0;
				var rowDivs = new Array();
				var $el;
				var topPosition = 0;
				$(".alsp-listings-grid:not(.masonry) .no-carousel .alsp-listing, .userpanel-item-wrap").each(function() {
					$el = $(this);
					var topPostion = $el.position().top;
					if (currentRowStart != topPostion) {
						for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
							rowDivs[currentDiv].height(currentTallest);
						}
						rowDivs.length = 0;
						currentRowStart = topPostion;
						currentTallest = $el.height();
						rowDivs.push($el);
					} else {
						rowDivs.push($el);
						currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
					}
					for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
						rowDivs[currentDiv].height(currentTallest);
					}
				});
			}, 500);
		}
	}
	//equal column height has been customized for better porformance
	window.alsp_equalColumnsHeightCat = function() {
		var heights = new Array();

		// Loop to get all element heights
		$('.cat-style-3 .alsp-categories-column, .cat-style-6 .alsp-categories-column, .cat-style-7 .alsp-categories-column').each(function() {

			// Need to let sizes be whatever they want so no overflow on resize
			$(this).css('min-height', '0');
			$(this).css('max-height', 'none');
			$(this).css('height', 'auto');

			// Then add size (no units) to array
	 		heights.push($(this).height());
		});

		// Find max height of all elements
		var max = Math.max.apply( Math, heights );

		// Set all heights to max height
		$('.cat-style-3 .alsp-categories-column, .cat-style-6 .alsp-categories-column, .cat-style-7 .alsp-categories-column').each(function() {
			$(this).css('height', max + 'px');
		});	
	}
	
	window.alsp_sendGeoPolyAJAX = function(map_id, geo_poly_ajax) {
		var map_attrs_array;
		if (map_attrs_array = alsp_get_map_markers_attrs_array(map_id)) {
			alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+map_id));
			
			var ajax_params = {};
			for (var attrname in map_attrs_array.map_attrs) { ajax_params[attrname] = map_attrs_array.map_attrs[attrname]; }
			ajax_params.action = 'alsp_search_by_poly';
			ajax_params.hash = map_id;
			ajax_params.geo_poly = geo_poly_ajax;
			ajax_params.num = -1; // do not limit markers on map

			var listings_args_array;
			if (listings_args_array = alsp_get_controller_args_array(map_id)) {
				ajax_params.hide_order = listings_args_array.hide_order;
				ajax_params.hide_count = listings_args_array.hide_count;
				ajax_params.hide_content = listings_args_array.hide_content;
				ajax_params.hide_paginator = listings_args_array.hide_paginator;
				ajax_params.show_views_switcher = listings_args_array.show_views_switcher;
				ajax_params.listings_view_type = listings_args_array.listings_view_type;
				ajax_params.listings_view_grid_columns = listings_args_array.listings_view_grid_columns;
				ajax_params.listing_thumb_width = listings_args_array.listing_thumb_width;
				ajax_params.wrap_logo_list_view = listings_args_array.wrap_logo_list_view;
				ajax_params.logo_animation_effect = listings_args_array.logo_animation_effect;
				ajax_params.grid_view_logo_ratio = listings_args_array.grid_view_logo_ratio;
				ajax_params.scrolling_paginator = listings_args_array.scrolling_paginator;
				ajax_params.perpage = listings_args_array.perpage;
				ajax_params.onepage = listings_args_array.onepage;
				ajax_params.order = listings_args_array.order;
				ajax_params.order_by = listings_args_array.order_by;
				ajax_params.base_url = listings_args_array.base_url;

				alsp_ajax_loader_target_show($('#alsp-controller-'+map_id));
			} else {
				ajax_params.without_listings = 1;
			}
			
			if ($("#alsp-map-listings-panel-"+map_id).length) {
				ajax_params.map_listings = 1;
				alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+map_id));
			}

			$.post(
				alsp_js_objects.ajaxurl,
				ajax_params,
				function(response_from_the_action_function) {
					alsp_process_listings_ajax_responce(response_from_the_action_function, true, false, false);
				},
				'json'
			);
		}
	}
	
	window.alsp_isSidebarOpen = function(map_id) {
		return ($("#alsp-maps-canvas-"+map_id).length && $("#alsp-maps-canvas-"+map_id).hasClass("alsp-sidebar-open"));
	}
	
	var alsp_animation_finished = true;
	window.alsp_listings_carousel = function() {

		if ($(document).width() >= 768) {
			$(".alsp-listings-carousel-wrapper").each(function() {
				var id = $(this).data("controller-hash");
				var currentTallest = 0;
				$(this).find("article.alsp-listing").each(function() {
					currentTallest = (currentTallest < $(this).height()) ? ($(this).height()) : (currentTallest);
				});
				$(this).height(currentTallest);
				
				var content = $("#alsp-controller-"+id+" .alsp-listings-block-content");
				var width = content.find("article.alsp-listing").width();
				var margin = 20;
				var slide_width = width + margin;
				$("body").on("click", "#alsp-controller-"+id+" .alsp-listings-carousel-button-left", function() {
					alsp_prev_slide(content, slide_width);
				});
				$("body").on("click", "#alsp-controller-"+id+" .alsp-listings-carousel-button-right", function() {
					alsp_next_slide(content, slide_width);
				});
				$("body").on("swiperight", "#alsp-controller-"+id+" .alsp-listings-carousel", function() {
					alsp_prev_slide(content, slide_width);
				});
				$("body").on("swipeleft", "#alsp-controller-"+id+" .alsp-listings-carousel", function() {
					alsp_next_slide(content, slide_width);
				});
				$("body").on("mousewheel", "#alsp-controller-"+id+" .alsp-listings-carousel", function(event, delta, deltaX, deltaY) {
					if (delta > 0) {
						alsp_prev_slide(content, slide_width);
					}
					if (deltaY < 0) {
						alsp_next_slide(content, slide_width);
					}
					event.stopPropagation();
					event.preventDefault();
				});
			});
		}
	}
	window.alsp_prev_slide = function(content, slide_width) {
		if (alsp_animation_finished) {
			var listing = content.find("article.alsp-listing:last");
			content
			.css({ "margin-left": -slide_width })
			.prepend(listing.clone());
			
			alsp_animation_finished = false;
			content.animate({
				"margin-left": 0
			}, 300, function () { 
				listing.remove();
				alsp_animation_finished = true;
			});
		}
	}
	window.alsp_next_slide = function(content, slide_width) {
		if (alsp_animation_finished) {
			var listing = content.find("article.alsp-listing:first");
			content.append(listing.clone());
			
			alsp_animation_finished = false;
			content.animate({
				"margin-left": -slide_width
			}, 300, function () { 
				listing.remove();
				content.css({ "margin-left": 0 })
				alsp_animation_finished = true;
			});
		}
	}
	
	window.alsp_ajax_loader_target_show = function(target, scroll_to_anchor, offest_top) {
		if (typeof scroll_to_anchor != 'undefined' && scroll_to_anchor) {
			if (typeof offest_top == 'undefined' || !offest_top) {
				var offest_top = 0;
			}
			$('html,body').animate({scrollTop: scroll_to_anchor.offset().top - offest_top}, 'slow');
		}
		var id = target.attr("id");
		if (!$("[data-loader-id='"+id+"']").length) {
			var loader = $('<div data-loader-id="'+id+'" class="alsp-ajax-target-loading"><div class="alsp-loader"></div></div>');
			target.prepend(loader);
			loader.css({
				width: target.outerWidth()+10,
				height: target.outerHeight()+10
			});
			if (target.outerHeight() > 600) {
				loader.find(".alsp-loader").addClass("alsp-loader-max-top");
			}
		}
	}
	window.alsp_ajax_loader_target_hide = function(id) {
		$("[data-loader-id='"+id+"']").remove();
	}
	
	window.alsp_ajax_loader_show = function(msg) {
		var overlay = $('<div id="alsp-ajax-loader-overlay"><div class="alsp-loader"></div></div>');
	    $('body').append(overlay);
	}
	
	window.alsp_ajax_loader_hide = function() {
		$("#alsp-ajax-loader-overlay").remove();
	}
	
	window.alsp_get_controller_args_array = function(hash) {
		if (typeof alsp_controller_args_array != 'undefined' && Object.keys(alsp_controller_args_array))
			for (var controller_hash in alsp_controller_args_array)
				if (controller_hash == hash)
					return alsp_controller_args_array[controller_hash];
	}

	window.alsp_get_map_markers_attrs_array = function(hash) {
		if (typeof alsp_map_markers_attrs_array != 'undefined' && Object.keys(alsp_map_markers_attrs_array))
			for (var i=0; i<alsp_map_markers_attrs_array.length; i++)
				if (hash == alsp_map_markers_attrs_array[i].map_id)
					return alsp_map_markers_attrs_array[i];
	}

	window.alsp_get_original_map_markers_attrs_array = function(hash) {
		if (typeof _alsp_map_markers_attrs_array != 'undefined' && Object.keys(_alsp_map_markers_attrs_array))
			for (var i=0; i<_alsp_map_markers_attrs_array.length; i++)
				if (hash == _alsp_map_markers_attrs_array[i].map_id)
					return _alsp_map_markers_attrs_array[i];
	}
	
	window.alsp_process_listings_ajax_responce = function(response_from_the_action_function, do_replace, remove_shapes, do_replace_markers) {
		var responce_hash = response_from_the_action_function.hash;
		if (response_from_the_action_function) {
			var listings_block = $('#alsp-controller-'+responce_hash);
			if (do_replace) {
				listings_block.replaceWith(response_from_the_action_function.html);
			} else {
				if($('.alsp-listings-block-content div').hasClass("listing-list-view-inner-wrap")){
					listings_block.find(".listing-list-view-inner-wrap").append(response_from_the_action_function.html);
				}else if($('.pacz-loop-main-wrapper').hasClass("pacz-loop-main-wrapper2")){
					var $items = $(response_from_the_action_function.html);
					var $grid = $(listings_block.find(".alsp-listings-block-content"));
					setTimeout(function() {
						$grid.append( $items ).isotope( 'appended', $items );
					},500);	
				}else{
					var $items = $(response_from_the_action_function.html);
					var $grid = $(listings_block.find(".alsp-listings-block-content"));
					$grid.append( $items );
				}
				//alsp_ajax_listings_loader_hide(responce_hash);
			}
			alsp_ajax_loader_target_hide("alsp-controller-"+responce_hash);
			if (response_from_the_action_function.map_markers && typeof alsp_maps[responce_hash] != 'undefined') {
				if (do_replace) {
					alsp_clearMarkers(responce_hash);
				}
				if (remove_shapes) {
					alsp_removeShapes(responce_hash);
				}
				alsp_closeInfoWindow(responce_hash);
				
				var markers_array = response_from_the_action_function.map_markers;
				
				var enable_radius_circle = 0;
				var enable_clusters = 0;
				var show_summary_button = 1;
				var show_readmore_button = 1;
				var attrs_array;
				if (attrs_array = alsp_get_map_markers_attrs_array(responce_hash)) {
					var enable_radius_circle = attrs_array.enable_radius_circle;
					var enable_clusters = attrs_array.enable_clusters;
					var show_summary_button = attrs_array.show_summary_button;
					var show_readmore_button = attrs_array.show_readmore_button;
					var map_attrs = attrs_array.map_attrs;

					if (do_replace_markers) {
						attrs_array.markers_array = eval(response_from_the_action_function.map_markers);
					}
				}

		    	for (var j=0; j<markers_array.length; j++) {
	    			var map_coords_1 = markers_array[j][1];
			    	var map_coords_2 = markers_array[j][2];
			    	if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
		    			var point = alsp_buildPoint(map_coords_1, map_coords_2);

		    			var location_obj = new alsp_glocation(markers_array[j][0], point, 
		    				markers_array[j][3],
		    				markers_array[j][4],
		    				markers_array[j][6],
		    				markers_array[j][7],
		    				markers_array[j][8],
		    				markers_array[j][9],
		    				markers_array[j][10],
		    				markers_array[j][11],
		    				show_summary_button,
		    				show_readmore_button,
		    				responce_hash,
		    				false
			    		);
			    		var marker = location_obj.alsp_placeMarker(responce_hash);
			    		alsp_global_locations_array[responce_hash].push(location_obj);
			    	}
	    		}
		    	if (alsp_global_markers_array[responce_hash].length) {
		    		var bounds = alsp_buildBounds();
		    		for (var j=0; j<alsp_global_markers_array[responce_hash].length; j++) {
		    			var marker = alsp_global_markers_array[responce_hash][j];
		    			var marker_position = alsp_getMarkerPosition(marker);
		    			alsp_extendBounds(bounds, marker_position);
		    		}
		    		alsp_mapFitBounds(responce_hash, bounds);

		    		if (alsp_global_markers_array[responce_hash].length == 1) {
		    			alsp_setMapZoom(responce_hash, ZOOM_FOR_SINGLE_MARKER);
		    		}
		    	}

		    	alsp_ajax_loader_target_hide('alsp-maps-canvas-'+responce_hash);

		    	if (do_replace) {
	    			alsp_setClusters(enable_clusters, responce_hash, alsp_global_markers_array[responce_hash]);
		    	}

		    	if (remove_shapes) {
			    	if (enable_radius_circle && typeof response_from_the_action_function.radius_params != 'undefined') {
			    		var radius_params = response_from_the_action_function.radius_params;
						var map_radius = parseFloat(radius_params.radius_value);
						alsp_draw_radius(radius_params, map_radius, responce_hash);
					}
		    	}
			}
			if (typeof response_from_the_action_function.map_listings != 'undefined' && typeof alsp_maps[responce_hash] != 'undefined') {
				var map_listings_block = $('#alsp-map-listings-panel-'+responce_hash);
		    	if (map_listings_block.length) {
		    		if (do_replace) {
		    			map_listings_block.html(response_from_the_action_function.map_listings);
		    		} else {
		    			map_listings_block.append(response_from_the_action_function.map_listings);
		    		}
		    	}
		    	alsp_ajax_loader_target_hide('alsp-map-search-panel-wrapper-'+responce_hash);
			}
		}
		alsp_ajax_loader_target_hide('alsp-controller-'+responce_hash);
		alsp_ajax_loader_target_hide('alsp-maps-canvas-'+responce_hash);
		alsp_equalColumnsHeight();
		if(alsp_js_objects.is_maps_used){
			alsp_show_on_map_links();
		}
		alsp_sticky_scroll();
	}
	
	window.alsp_load_ajax_initial_elements = function() {
		// We have to wait while Google Maps API will be completely loaded
		if (typeof alsp_controller_args_array != 'undefined' && Object.keys(alsp_controller_args_array)) {
			for (var controller_hash in alsp_controller_args_array) {
				var post_params = alsp_controller_args_array[controller_hash];
				if (alsp_js_objects.ajax_initial_load || (typeof post_params.ajax_initial_load != 'undefined' && post_params.ajax_initial_load == 1)) {
					var ajax_params = {'action': 'alsp_controller_request', 'hash': controller_hash};
					for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }
	
					if ((typeof post_params['with_map'] != 'undefined' && post_params['with_map']) || $("#alsp-maps-canvas-"+controller_hash).length) {
						var map_attrs_array;
						if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash))
							if (typeof map_attrs_array.map_attrs.ajax_loading != "undefined" && map_attrs_array.map_attrs.ajax_loading == 1)
								continue;
							
						post_params['with_map'] = 1;
						alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+controller_hash));
					}
	
				   	alsp_ajax_loader_target_show($('#alsp-controller-'+controller_hash));
					$.post(
						alsp_js_objects.ajaxurl,
						post_params,
						function(response_from_the_action_function) {
							alsp_process_listings_ajax_responce(response_from_the_action_function, true, true, true);
							var responce_hash = response_from_the_action_function.hash;
							if (response_from_the_action_function.map_markers && typeof alsp_maps[responce_hash] != 'undefined')
								if (typeof _alsp_map_markers_attrs_array != 'undefined' && _alsp_map_markers_attrs_array.length) {
									for (var i=0; i<_alsp_map_markers_attrs_array.length; i++)
										if (responce_hash == _alsp_map_markers_attrs_array[i].map_id)
											_alsp_map_markers_attrs_array[i].markers_array = eval(response_from_the_action_function.map_markers);
								}
						},
						'json'
					);
				}
			}
		}
	}
	
	window.alsp_ajax_iloader = $("<div>", { class: 'alsp-ajax-iloader' }).html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
	window.alsp_add_iloader_on_element = function(button) {
		button
		.attr('disabled', 'disabled')
		.wrapInner('<div class="alsp-hidden"></div>')
		.append(alsp_ajax_iloader);
	}
	window.alsp_delete_iloader_from_element = function(button) {
		button.find(".alsp-hidden").contents().unwrap();
		button.removeAttr('disabled').find(".alsp-ajax-iloader").remove();
	}
	
	var alsp_show_more_button_processing = false;
	$(window).scroll(function() {
		$('.alsp-show-more-button.alsp-scrolling-paginator').each(function() {
			if ($(window).scrollTop() + $(window).height() > $(this).position().top) {
				if (!alsp_show_more_button_processing) {
					alsp_callShowMoreListings($(this));
				}
			}
		});
	});
	$('body').on('click', '.alsp-show-more-button', function(e) {
		e.preventDefault();
		alsp_callShowMoreListings($(this));
		setTimeout(function() {
        	$('.pacz-theme-loop.isotope').isotope('reLayout');
        },1000);
	});
	var alsp_callShowMoreListings = function(button) {
		var controller_hash = button.data("controller-hash");
		var listings_args_array;
		if (listings_args_array = alsp_get_controller_args_array(controller_hash)) {
			alsp_add_iloader_on_element(button);

			var post_params = $.extend({}, listings_args_array);
			if (typeof post_params.paged != 'undefined')
				var paged = parseInt(post_params.paged)+1;
			else
				var paged = 2;
			listings_args_array.paged = paged;
			
			var existing_listings = '';
			$("#alsp-controller-"+controller_hash+" .alsp-listings-block-content article").each(function(index) {
				existing_listings = $(this).attr("id").replace("post-", "") + "," + existing_listings;
			});

			var ajax_params = {'action': 'alsp_controller_request', 'do_append': 1, 'paged': paged, 'existing_listings': existing_listings, 'hash': controller_hash};
			for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }

			if ($("#alsp-maps-canvas-"+controller_hash).length) {
				var map_attrs_array;
				if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash)) {
					if ((typeof map_attrs_array.map_attrs.ajax_loading == 'undefined' || map_attrs_array.map_attrs.ajax_loading == 0)
					&&
					(typeof map_attrs_array.map_attrs.drawing_state == 'undefined' || map_attrs_array.map_attrs.drawing_state == 0)
					&&
					(typeof map_attrs_array.map_attrs.map_markers_is_limit == 'undefined' || map_attrs_array.map_attrs.map_markers_is_limit == 1)) {
						alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+controller_hash));
					  	post_params.with_map = 1;
					  	post_params.map_markers_is_limit = 1;
					  	if ($("#alsp-map-listings-panel-"+controller_hash).length) {
							post_params.map_listings = 1;
							alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+controller_hash));
						}
					} else {
						post_params.with_map = 0;
						post_params.map_listings = 0;
					}
				}
			}

			alsp_show_more_button_processing = true;
			$.post(
				alsp_js_objects.ajaxurl,
				post_params,
				alsp_completeAJAXShowMore(button),
				'json'
			);
		}
	}
	var alsp_completeAJAXShowMore = function(button) {
		return function(response_from_the_action_function) {
			alsp_process_listings_ajax_responce(response_from_the_action_function, false, false, false);
			alsp_show_more_button_processing = false;
			alsp_delete_iloader_from_element(button);
			if (response_from_the_action_function.hide_show_more_listings_button) {
				button.hide();
			}
		}
	}

	if (alsp_js_objects.ajax_load) {
		$("form.alsp-search-form-submit").each(function() {
			var form = $(this);
			if (form.find('.alsp-submit-button-hidden').length) {
				var inputs = form.find('input, select').not(':input[type=text], :input[type=submit], :input[type=reset]');
				inputs.on("change", {"form": form}, function(e) {
					var form = e.data.form;
					//form.find('button.alsp-submit-button-hidden').trigger('click');
					//console.log(e);
					alsp_callAJAXSearch(form, e);
				});
			}
		});
		$("body").on("submit", ".alsp-search-form-submit", function(e) {
			//e.preventDefault();
			
			alsp_callAJAXSearch($(this), e);
		});
		var alsp_callAJAXSearch = function(form, e) {
			var search_inputs = form.serializeArray();
			var post_params = {};
			for (var attr in search_inputs) {
				// checkboxes search form values
				if (search_inputs[attr]['name'].indexOf('[]') != -1) {
					if (typeof post_params[search_inputs[attr]['name']] == 'undefined')
						post_params[search_inputs[attr]['name']] = [];
					post_params[search_inputs[attr]['name']].push(search_inputs[attr]['value']);
				} else
					post_params[search_inputs[attr]['name']] = search_inputs[attr]['value'];
			}
			
			var controller_hash = false;
			if (typeof post_params['hash'] != 'undefined' && post_params['hash']) {
				controller_hash = post_params['hash'];
			}

			if (!controller_hash) {
				if (typeof alsp_controller_args_array != 'undefined' && Object.keys(alsp_controller_args_array)) {
					for (var _controller_hash in alsp_controller_args_array) {
						if ($("#alsp-controller-"+_controller_hash).data("custom-home") == 1) {
							controller_hash = _controller_hash;
							post_params["custom_home"] = 1;
							post_params["controller"] = 'directory_controller';
							break;
						}
					}
				}
			}
			if (!controller_hash) {
				$(".alsp-maps-canvas").each(function() {
					if (form.data("custom-home") == 1) {
						controller_hash = form.data("shortcode-hash");
						post_params["custom_home"] = 1;
						post_params["controller"] = 'directory_controller';
						return false;
					}
				});
			}

			if (controller_hash) {
				e.preventDefault();

				var search_button_obj = null;
				if (form.find('button[type="submit"]')) {
					search_button_obj = form.find('button[type="submit"]');
					if (search_button_obj.is(":visible")) {
						alsp_add_iloader_on_element(search_button_obj);
					}
				}

				post_params['hash'] = controller_hash;

				var ajax_params = {'action': 'alsp_controller_request'};
				// collect needed params from listing block
				var listings_args_array;
				if (listings_args_array = alsp_get_controller_args_array(controller_hash)) {
					ajax_params.hide_order = listings_args_array.hide_order;
					ajax_params.hide_count = listings_args_array.hide_count;
					ajax_params.hide_content = listings_args_array.hide_content;
					ajax_params.hide_paginator = listings_args_array.hide_paginator;
					ajax_params.show_views_switcher = listings_args_array.show_views_switcher;
					ajax_params.listings_view_type = listings_args_array.listings_view_type;
					ajax_params.listings_view_grid_columns = listings_args_array.listings_view_grid_columns;
					ajax_params.listing_thumb_width = listings_args_array.listing_thumb_width;
					ajax_params.wrap_logo_list_view = listings_args_array.wrap_logo_list_view;
					ajax_params.logo_animation_effect = listings_args_array.logo_animation_effect;
					ajax_params.grid_view_logo_ratio = listings_args_array.grid_view_logo_ratio;
					ajax_params.scrolling_paginator = listings_args_array.scrolling_paginator;
					ajax_params.perpage = listings_args_array.perpage;
					ajax_params.onepage = listings_args_array.onepage;
					// do not send order params by defaut, send them when already was a click on order buttons, and we prevent failure when ordering by distance
					if (alsp_find_get_parameter('order_by')) {
						ajax_params.order = listings_args_array.order;
						ajax_params.order_by = listings_args_array.order_by;
						post_params["order"] = listings_args_array.order;
						post_params["order_by"] = listings_args_array.order_by;
					}
					ajax_params.base_url = listings_args_array.base_url;
					if (typeof listings_args_array.directories != 'undefined') {
						ajax_params.directories = listings_args_array.directories;
					}
				}
				// collect needed params from map attributes
				if (typeof ajax_params.perpage == 'undefined') {
					var map_attrs_array;
					if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash))
						if (typeof map_attrs_array.map_attrs.num != 'undefined')
							ajax_params.perpage = map_attrs_array.map_attrs.num;
				}

				var map_attrs_array;
				if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash)) {
					// save new search parameters for the map
					for (var attrname in post_params) { map_attrs_array.map_attrs[attrname] = post_params[attrname]; }

					// repair ajax_loading after alsp_drawFreeHandPolygon
					if (typeof alsp_get_original_map_markers_attrs_array(controller_hash).map_attrs.ajax_loading != 'undefined' && alsp_get_original_map_markers_attrs_array(controller_hash).map_attrs.ajax_loading == 1) {
						map_attrs_array.map_attrs.ajax_loading = 1;
						alsp_setAjaxMarkersListener(controller_hash)
					}
					// remove drawing_state after alsp_drawFreeHandPolygon
					if (typeof map_attrs_array.map_attrs.drawing_state != 'undefined') {
						delete map_attrs_array.map_attrs.drawing_state;
					}
					if (typeof map_attrs_array.map_attrs.ajax_loading != 'undefined' && map_attrs_array.map_attrs.ajax_loading == 1) {
						delete map_attrs_array.map_attrs.locations;
						delete map_attrs_array.map_attrs.swLat;
						delete map_attrs_array.map_attrs.swLng;
						delete map_attrs_array.map_attrs.neLat;
						delete map_attrs_array.map_attrs.neLng;
						delete map_attrs_array.map_attrs.action;
						var enable_clusters = map_attrs_array.enable_clusters;
						var enable_radius_circle = map_attrs_array.enable_radius_circle;
						var show_summary_button = map_attrs_array.show_summary_button;
						var show_readmore_button = map_attrs_array.show_readmore_button;

						map_attrs_array.map_attrs.include_categories_children = 1;
						alsp_setAjaxMarkers(alsp_maps[controller_hash], controller_hash, search_button_obj);
						return false;
					}
				}
				
				if ($("#alsp-map-listings-panel-"+controller_hash).length) {
					post_params.map_listings = 1;
					alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+controller_hash));
				}

				if ($("#alsp-controller-"+controller_hash).length) {
					if (form.hasClass('alsp-map-search-form')) {
						var anchor = false;
					} else {
						if (form.data("scroll-to") == "listings") {
							var anchor = $('#alsp-controller-'+controller_hash);
						} else if (form.data("scroll-to") == "map") {
							var anchor = $('#alsp-maps-canvas-'+controller_hash);
						}
					}
					if (typeof window["alsp_sticky_scroll_toppadding_"+controller_hash] != 'undefined') {
						var sticky_scroll_toppadding = window["alsp_sticky_scroll_toppadding_"+controller_hash];
					} else {
						var sticky_scroll_toppadding = 0;
					}
					alsp_ajax_loader_target_show($('#alsp-controller-'+controller_hash), anchor, sticky_scroll_toppadding);
				} else {
			   		post_params.without_listings = 1;
				}

				for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }

				if ($("#alsp-maps-canvas-"+controller_hash).length) {
					alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+controller_hash));
			   		post_params.with_map = 1;
			   		if (map_attrs_array && (typeof map_attrs_array.map_attrs.map_markers_is_limit == 'undefined' || map_attrs_array.map_attrs.map_markers_is_limit == 1)) {
			   			post_params.map_markers_is_limit = 1;
			   		}
			   	}
				
				window.alsp_geocoderResponseOnSearch = function(success, lat, lng) {
					post_params.start_latitude = 0;
					post_params.start_longitude = 0;
					if (success) {
						post_params.start_latitude = lat;
						post_params.start_longitude = lng;
					}
					alsp_startAJAXSearch(post_params, search_button_obj);
				}

				if (
						//(typeof post_params.location_id == 'undefined' || post_params.location_id == 0 || !post_params.address) &&
						typeof post_params.address != 'undefined' &&
						post_params.address &&
						typeof post_params.radius != 'undefined' &&
						post_params.radius
				) {
					alsp_geocodeAddress(post_params.address, alsp_geocoderResponseOnSearch);
				} else {
					alsp_startAJAXSearch(post_params, search_button_obj);
				}
			} else {
				form.find('button.alsp-submit-button-hidden').trigger('click');
			}
		}
		var alsp_search_requests_counter = 0;
		var alsp_startAJAXSearch = function(post_params, search_button_obj) {
			
			window.history.pushState("", "", "?"+$.param(post_params));
			var url = document.location.pathname;
			for (var attrname in post_params) {
				var sep = (url.indexOf('?') > -1) ? '&' : '?';
				url = url + sep + attrname + '=' + post_params[attrname];
			}
			if (typeof ga == 'function') {
				ga('send', 'pageview', url);
			}
			
			alsp_search_requests_counter++;
			$.post(
				alsp_js_objects.ajaxurl,
				post_params,
				alsp_completeAJAXSearch(search_button_obj),
				'json'
			);
		}
		var alsp_completeAJAXSearch = function(search_button_obj) {
			return function(response_from_the_action_function) {
				alsp_search_requests_counter--;
				if (alsp_search_requests_counter == 0) {
					alsp_process_listings_ajax_responce(response_from_the_action_function, true, true, true);
					if (search_button_obj) {
						alsp_delete_iloader_from_element(search_button_obj);
					}
				}
			}
		}
		// needed hack for mobile devices - draggable makes input text fields uneditable
		$('body').on('click', '.alsp-map-search-wrapper input', function() {
		    $(this).focus();
		});

		$('body').on('click', '.alsp-map-search-toggle, .alsp-map-sidebar-toggle', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			$("#alsp-map-search-form-"+id).toggleClass("alsp-sidebar-open");
			$("#alsp-maps-canvas-"+id).toggleClass("alsp-sidebar-open");
			$("#alsp-map-search-panel-wrapper-"+id).on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
				alsp_callMapResize(id);
			});
		});

		$('body').on('click', '.alsp-orderby-links a', function(e) {
			e.preventDefault();

			var href = $(this).attr('href');
			var controller_hash = $(this).data('controller-hash');
			var listings_args_array;
			if (listings_args_array = alsp_get_controller_args_array(controller_hash)) {
				var post_params = $.extend({}, listings_args_array);
				var ajax_params = {'action': 'alsp_controller_request', 'order_by': $(this).data('orderby'), 'order': $(this).data('order'), 'paged': 1, 'hash': controller_hash};
				for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }

				if ($("#alsp-maps-canvas-"+controller_hash).length) {
					var map_attrs_array;
					if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash)) {
						if ((typeof map_attrs_array.map_attrs.ajax_loading == 'undefined' || map_attrs_array.map_attrs.ajax_loading == 0)
						&&
						(typeof map_attrs_array.map_attrs.drawing_state == 'undefined' || map_attrs_array.map_attrs.drawing_state == 0)
						&&
						(typeof map_attrs_array.map_attrs.map_markers_is_limit == 'undefined' || map_attrs_array.map_attrs.map_markers_is_limit == 1)) {
							alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+controller_hash));
						  	post_params.with_map = 1;
						  	post_params.map_markers_is_limit = 1;
						  	if ($("#alsp-map-listings-panel-"+controller_hash).length) {
								post_params.map_listings = 1;
								alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+controller_hash));
							}
						} else {
							post_params.with_map = 0;
							post_params.map_listings = 0;
						}
							
					}
				}
				
				window.history.pushState("", "", href);

				alsp_ajax_loader_target_show($('#alsp-controller-'+controller_hash));
				$.post(
					alsp_js_objects.ajaxurl,
					post_params,
					function(response_from_the_action_function) {
						alsp_process_listings_ajax_responce(response_from_the_action_function, true, true, true);
					},
					'json'
				);
			}
		});

		$('body').on('click', '.alsp-pagination li a', function(e) {
			if ($(this).data('controller-hash')) {
				e.preventDefault();

				var href = $(this).attr('href');
				var controller_hash = $(this).data('controller-hash');
				var paged = $(this).data('page');
				var listings_args_array;
				if (listings_args_array = alsp_get_controller_args_array(controller_hash)) {
					var post_params = $.extend({}, listings_args_array);
					
					var existing_listings = '';
					$("#alsp-controller-"+controller_hash+" .alsp-listings-block-content article").each(function(index) {
						existing_listings = $(this).attr("id").replace("post-", "") + "," + existing_listings;
					});

					var ajax_params = {'action': 'alsp_controller_request', 'paged': paged, 'existing_listings': existing_listings, 'hash': controller_hash};
					for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }
							
					if ($("#alsp-maps-canvas-"+controller_hash).length) {
						var map_attrs_array;
						if (map_attrs_array = alsp_get_map_markers_attrs_array(controller_hash))
							if ((typeof map_attrs_array.map_attrs.ajax_loading == 'undefined' || map_attrs_array.map_attrs.ajax_loading == 0)
							&&
							(typeof map_attrs_array.map_attrs.drawing_state == 'undefined' || map_attrs_array.map_attrs.drawing_state == 0)
							&&
							(typeof map_attrs_array.map_attrs.map_markers_is_limit == 'undefined' || map_attrs_array.map_attrs.map_markers_is_limit == 1)) {
								alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+controller_hash));
							  	post_params.with_map = 1;
							  	post_params.map_markers_is_limit = 1;
							  	if ($("#alsp-map-listings-panel-"+controller_hash).length) {
									post_params.map_listings = 1;
									alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+controller_hash));
								}
							} else {
								post_params.with_map = 0;
								post_params.map_listings = 0;
							}
					}
					var anchor = $('#alsp-controller-'+controller_hash);
					
					window.history.pushState("", "", href);

					if (typeof window["alsp_sticky_scroll_toppadding_"+controller_hash] != 'undefined') {
						var sticky_scroll_toppadding = window["alsp_sticky_scroll_toppadding_"+controller_hash];
					} else {
						var sticky_scroll_toppadding = 0;
					}
					alsp_ajax_loader_target_show($('#alsp-controller-'+controller_hash), anchor, sticky_scroll_toppadding);
					$.post(
						alsp_js_objects.ajaxurl,
						post_params,
						function(response_from_the_action_function) {
							alsp_process_listings_ajax_responce(response_from_the_action_function, true, false, true);
						},
						'json'
					);
				}
			}
		});
	}
	
	$('body').on('click', '.alsp-list-view-btn', function() {
		var button = $(this);
		var hash = button.data('shortcode-hash');
		var listings_block = $('#alsp-controller-'+hash).find('.alsp-listings-block');
		if (listings_block.hasClass('alsp-listings-grid')) {
			listings_block.find('.alsp-listings-block-content').fadeTo("fast", 0, function() {
				button.removeClass('btn-default').addClass('btn-primary');
				button.parents('.alsp-views-links').find('.alsp-grid-view-btn').removeClass('btn-primary').addClass('btn-default');
				listings_block.removeClass('alsp-listings-grid alsp-listings-grid-1 alsp-listings-grid-2 alsp-listings-grid-3 alsp-listings-grid-4');
				listings_block.addClass('alsp-listings-list-view');
				listings_block.find('article.alsp-listing').each(function() {
					$(this).css('height', 'auto');
				});
				$.cookie("alsp_listings_view_"+hash, 'list', {expires: 365, path: "/"});
			});
			setTimeout(location.reload.bind(location), 300);
			//listings_block.find('.alsp-listings-block-content').fadeTo("fast", 1);
		}
	});
	$('body').on('click', '.alsp-grid-view-btn', function() {
		var button = $(this);
		var hash = button.data('shortcode-hash');
		var listings_block = $('#alsp-controller-'+hash).find('.alsp-listings-block');
		if (!listings_block.hasClass('alsp-listings-grid')) {
			listings_block.find('.alsp-listings-block-content').fadeTo("fast", 0, function() {
				button.removeClass('btn-default').addClass('btn-primary');
				button.parents('.alsp-views-links').find('.alsp-list-view-btn').removeClass('btn-primary').addClass('btn-default');
				listings_block.removeClass('alsp-listings-list-view');
				listings_block.addClass('alsp-listings-grid').addClass('alsp-listings-grid-'+button.data('grid-columns'));
				alsp_equalColumnsHeight();
				$.cookie("alsp_listings_view_"+hash, 'grid', {expires: 365, path: "/"});
			});
			//listings_block.find('.alsp-listings-block-content').fadeTo("fast", 1);
			setTimeout(location.reload.bind(location), 300);
		}
	});
	
	$(".alsp-remove-from-favourites-list").click(function() {
		var listing_id = $(this).data("listingid");
		
		if ($.cookie("favourites") != null) {
			var favourites_array = $.cookie("favourites").split('*');
		} else {
			var favourites_array = new Array();
		}

		for (var count=0; count<favourites_array.length; count++) {
			if (favourites_array[count] == listing_id) {
				delete favourites_array[count];
			}
		}

		$(".alsp-listing#post-"+listing_id).remove();
		
		$.cookie("favourites", favourites_array.join('*'), {expires: 365, path: "/"});
		return false;
	});
	
	// AJAX Contact form
	$(document).on('submit', '#alsp_contact_form, #alsp_report_form', function(e) {
		e.preventDefault();
	    var $this = $(this);
		if ($this.attr('id') == 'alsp_contact_form') {
			var type = 'contact';
		} else if ($this.attr('id') == 'alsp_report_form') {
			var type = 'report';
		}
		var warning = $this.find('#'+type+'_warning');
		var listing_id = $this.find('#'+type+'_listing_id');
		var nonce = $this.find('#'+type+'_nonce');
		var name = $this.find('#'+type+'_name');
		var email = $this.find('#'+type+'_email');
		var message = $this.find('#'+type+'_message');
		var button = $this.find('.alsp-send-message-button');
		var recaptcha = ($this.find('.g-recaptcha-response').length ? $this.find('.g-recaptcha-response').val() : '');
		
	    $this.css('opacity', '0.5');
		warning.hide();
		button.val(alsp_js_objects.send_button_sending).attr('disabled', 'disabled');

	    var data = {
				action: "alsp_contact_form",
				type: type,
				listing_id: listing_id.val(),
				name: name.val(),
				email: email.val(),
				message: message.val(),
				security: nonce.val(),
				'g-recaptcha-response': recaptcha
		};

	    $.ajax({
				url: alsp_js_objects.ajaxurl,
				type: "POST",
				dataType: "json",
				data: data,
				global: false,
				success: function(response_from_the_action_function) {
					if (response_from_the_action_function != 0) {
						if (response_from_the_action_function.error == '') {
							name.val(''),
							email.val(''),
							message.val(''),
							warning.html(response_from_the_action_function.success).show();
						} else {
							var error;
							if (typeof response_from_the_action_function.error == 'object') {
								error = '<ul>';
								$.each(response_from_the_action_function.error, function(key, value) {
									error = error + '<li>' + value + '</li>';
								});
	            				error = error + '</ul>';
	            			} else {
	            				error = response_from_the_action_function.error;
	            			}
							warning.html(error).show();
	            		}
	            		$this.css('opacity', '1');
	            		button.val(alsp_js_objects.send_button_text).removeAttr('disabled');
					}
				}
		});
	});
	
	window.alsp_masonry_layout = function(){
		
		$('.pacz-loop-main-wrapper').each(function() {
						var $this = $(this),
							$pacz_container = $this.find('.pacz-theme-loop'),
							$pacz_container_item = '.' + $pacz_container.attr('data-style') + '-' + $pacz_container.attr('data-uniqid'),
							$load_button = $this.find('.alsp-show-more-button'),
							$pagination_items = $this.find('.pacz-pagination');



						if ($pacz_container.hasClass('isotop-enabled')) {
							$pacz_container.imagesLoaded(function() {
								$pacz_container.isotope({
									itemSelector: $pacz_container_item,
									animationEngine: "best-available",
									masonry: {
										columnWidth: 1
									}
								});
							});
						}
					});
	}
	window.isotop_load_fix2 = function() {
		
		if ($.exists('.alsp-listings-block-content')) {
			
			$('.alsp-listings-block-content article').each(function(i) {
				
				$(this).delay(i * 100).animate({
					'opacity': 1
				}, 100);
				
			}).promise().done(function() {
				
				setTimeout(function() {
					$('.pacz-theme-loop.isotope').isotope('reLayout');
					
				},700);
			});
		}

	}
	window.isotop_load_fix_tab = function() {
		$('.ult_tab_li a').on('click', function(e) {	
			$('.ult_tabcontent .pacz-theme-loop.isotope').isotope('reLayout');
		});

	}
	window.isotop_distroy = function() {
		if ($(window).width() < 600) {
		$('.pacz-theme-loop').isotope( 'destroy' );
	}

	}
	
	window.alsp_grid_field_drop_menu = function() {
		$('.tooltip_fields .alsp-field').each( function() {
			var el = $(this).attr('data-id');
			var $mytooltip = $(this);
			$mytooltip.jBox('Tooltip',{
				attach: '#alsp-'+el,
				closeOnMouseleave: true,
				animation: 'zoomIn',
				delayOpen: 0,
				target: '#alsp-'+el,
				content: $('#'+el),
				position: {
					x: 'center',
					y: 'top'
				  },
				outside: 'y'
			});	
		});
		$('.tooltip_fields .add_to_favourites').each( function() {
			var el = $(this).data('listingid');
			var el_title = $(this).attr('title');
			var $mytooltip = $(this);
			$mytooltip.jBox('Tooltip',{
				attach: '#'+el,
				target: '#'+el,
				closeOnMouseleave: true,
				animation: 'zoomIn',
				delayOpen: 0,
				content: el_title,
				position: {
					x: 'center',
					y: 'top'
				  },
				outside: 'y'
			});	
		});
	}; 
	
})(jQuery);

function alsp_make_slug(name) {
	name = name.toLowerCase();
	
	var defaultDiacriticsRemovalMap = [
	                                   {'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
	                                   {'base':'AA','letters':/[\uA732]/g},
	                                   {'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
	                                   {'base':'AO','letters':/[\uA734]/g},
	                                   {'base':'AU','letters':/[\uA736]/g},
	                                   {'base':'AV','letters':/[\uA738\uA73A]/g},
	                                   {'base':'AY','letters':/[\uA73C]/g},
	                                   {'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
	                                   {'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
	                                   {'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
	                                   {'base':'DZ','letters':/[\u01F1\u01C4]/g},
	                                   {'base':'Dz','letters':/[\u01F2\u01C5]/g},
	                                   {'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
	                                   {'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
	                                   {'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
	                                   {'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
	                                   {'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
	                                   {'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
	                                   {'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
	                                   {'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
	                                   {'base':'LJ','letters':/[\u01C7]/g},
	                                   {'base':'Lj','letters':/[\u01C8]/g},
	                                   {'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
	                                   {'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
	                                   {'base':'NJ','letters':/[\u01CA]/g},
	                                   {'base':'Nj','letters':/[\u01CB]/g},
	                                   {'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
	                                   {'base':'OI','letters':/[\u01A2]/g},
	                                   {'base':'OO','letters':/[\uA74E]/g},
	                                   {'base':'OU','letters':/[\u0222]/g},
	                                   {'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
	                                   {'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
	                                   {'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
	                                   {'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
	                                   {'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
	                                   {'base':'TZ','letters':/[\uA728]/g},
	                                   {'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
	                                   {'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
	                                   {'base':'VY','letters':/[\uA760]/g},
	                                   {'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
	                                   {'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
	                                   {'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
	                                   {'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
	                                   {'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
	                                   {'base':'aa','letters':/[\uA733]/g},
	                                   {'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
	                                   {'base':'ao','letters':/[\uA735]/g},
	                                   {'base':'au','letters':/[\uA737]/g},
	                                   {'base':'av','letters':/[\uA739\uA73B]/g},
	                                   {'base':'ay','letters':/[\uA73D]/g},
	                                   {'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
	                                   {'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
	                                   {'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
	                                   {'base':'dz','letters':/[\u01F3\u01C6]/g},
	                                   {'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
	                                   {'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
	                                   {'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
	                                   {'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
	                                   {'base':'hv','letters':/[\u0195]/g},
	                                   {'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
	                                   {'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
	                                   {'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
	                                   {'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
	                                   {'base':'lj','letters':/[\u01C9]/g},
	                                   {'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
	                                   {'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
	                                   {'base':'nj','letters':/[\u01CC]/g},
	                                   {'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
	                                   {'base':'oi','letters':/[\u01A3]/g},
	                                   {'base':'ou','letters':/[\u0223]/g},
	                                   {'base':'oo','letters':/[\uA74F]/g},
	                                   {'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
	                                   {'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
	                                   {'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
	                                   {'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
	                                   {'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
	                                   {'base':'tz','letters':/[\uA729]/g},
	                                   {'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
	                                   {'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
	                                   {'base':'vy','letters':/[\uA761]/g},
	                                   {'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
	                                   {'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
	                                   {'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
	                                   {'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
	                               ];
	for(var i=0; i<defaultDiacriticsRemovalMap.length; i++)
		name = name.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);

	//change spaces and other characters by '_'
	name = name.replace(/\W/gi, "_");
	// remove double '_'
	name = name.replace(/(\_)\1+/gi, "_");
	
	return name;
}

function alsp_in_array(val, arr) 
{
	for (var i = 0; i < arr.length; i++) {
		if (arr[i] == val)
			return i;
	}
	return false;
}

function alsp_find_get_parameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}


/*!
 * jQuery Mousewheel 3.1.13 -------------------------------------------------------------------------------------------------------------------------------------------
 *
 * Copyright 2015 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});



// tax_dropdowns.js -------------------------------------------------------------------------------------------------------------------------------------------
(function($) {
	"use strict";
	
	window.alsp_sort_autocomplete_items = function(a, b) {
		if (typeof a.is_listing != "undefined" && a.is_listing && (typeof b.is_listing == "undefined" || !b.is_listing)) {
			return -1;
		} else if (typeof a.is_listing == "undefined" || !a.is_listing) {
			if (a.term_in_name && !b.term_in_name) {
				return -1;
			} else if (!a.term_in_name && b.term_in_name) {
				return 1;
			} else if (a.is_term && !b.is_term) {
				return -1;
			} else if (!a.is_term && b.is_term) {
				return 1;
			} else if (a.parents == '' && b.parents != '') {
				return -1;
			} else if (a.parents != '' && b.parents == '') {
				return 1;
			} else if (a.name > b.name) {
				return 1;
			} else if (b.name > a.name) {
				return -1;
			} else {
				return 0;
			}
		}
	}
	
	if (typeof $.ui.selectmenu != 'undefined' && typeof $.ui.autocomplete != 'undefined') {
		// search suggestions links
		$(document).on("click", ".alsp-search-suggestions a", function() {
			var input = $(this).parents(".alsp-search-input-field-wrap").find(".alsp-main-search-field");
			var value = $(this).text();

			input.val(value)
			.trigger("focus")
			.trigger("change");
			
			if (input.hasClass('ui-autocomplete-input')) {
				input.autocomplete("search", value);
			}
		});
		// redirect to listing
		$(document).on("click", ".alsp-dropdowns-menu a", function() {
			if ($(this).attr("target") == "_blank") {
				window.open($(this).attr("href"), '_blank');
			} else {
				window.location = $(this).attr("href");
			}
		});
		// correct menu width
		$.ui.autocomplete.prototype._resizeMenu = function () {
			var ul = this.menu.element;
			ul.outerWidth(this.element.outerWidth());
		}
		
		$(document).on('change paste keyup', '.alsp-main-search-field', function() {
			var input = $(this);
			if (input.val()) {
				input.parent().find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-reset");
			} else {
				input.parent().find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-reset");
			}
		});
		$(document).on('click', '.alsp-search-input-reset', function(e) {
			var input = $(this).parent().find('.alsp-main-search-field');
			input.val('');
			if (input.hasClass('ui-autocomplete-input')) {
				input.autocomplete("search", '');
			}
			$(this).removeClass('alsp-search-input-reset');
		});

		window.categories_combobox = $.widget("custom.categories_combobox", {
			input_icon_class: "glyphicon-search",
			cache: new Object(),

			_create: function() {
				this.wrapper = $("<div>")
				.addClass("alsp-dropdowns-menu-categories-autocomplete")
				.insertAfter(this.element);

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_appendWrapper: function() {
				// when combobox is placed on sticky map or sticky search - append to its wrapper
				if (this.wrapper.parents(".alsp-maps-canvas-wrapper.alsp-sticky-scroll, .alsp-search-form.alsp-sticky-scroll").length) {
					var append_to = this.wrapper;
				} else {
					var append_to = null;
				}
				return append_to;
			},
			
			_autocompleteWithOptions: function(input) {
				input.autocomplete({
					delay: 300,
					minLength: 0,
					appendTo: this._appendWrapper(),
					source: $.proxy(this, "_source"),
					open: function(event, ui) {
						if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
							$('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
						}
					}/*,
					close: function() {
						input.trigger("focus");
						input.autocomplete("search", "");
					}*/
				});
			},
			
			_autocompleteRenderItem: function(input) {
				input.autocomplete("widget").addClass("alsp-dropdowns-menu");
				input.autocomplete("instance")._renderItem = function(ul, item) {
					var label = item.label;
					
					var counter_markup = '';
					if (typeof item.count != "undefined") {
						counter_markup = '<span class="alsp-dropdowns-menu-search-counter">' + item.count + '</span>';
					}
					
					var item_class = "alsp-dropdowns-menu-search";
					if (typeof item.is_term != "undefined" && item.is_term) {
						item_class = item_class + " alsp-dropdowns-menu-search-term";
					}
					if (typeof item.is_listing != "undefined" && item.is_listing) {
						item_class = item_class + " alsp-dropdowns-menu-search-listing";
					}

					var li = $("<li>"),
					wrapper = $("<div>", {
						html: label + counter_markup,
						class: item_class
					});

					if (item.icon && item.icontype == 'img') {
						var icon_class = "alsp-ui-icon ";
						$("<span>", {
							style: "background-image: url('" + item.icon + "'); background-size: 18px; background-repeat:no-repeat;",
							class: icon_class
						})
						.appendTo(wrapper);
					}else if(item.icon && item.icontype == 'font'){
						if(item.fonticolor != ''){
							var fontcolor = item.fonticolor;
						}else{
							var fontcolor = '';
						}
						var icon_class = "alsp-ui-icon font-icon " + item.icon;
						$("<span>", {
							style:"color:" + fontcolor + ";",
							class: icon_class
						})
						.appendTo(wrapper);
					}else if(item.icon && item.icontype == 'svg'){
						var icon_class = "alsp-ui-icon svg-icon";
						var img = '<img src="'+item.icon+'" alt="'+item.label+'" />';
						$("<span>", {
							html: img,
							class: icon_class
						})
						.appendTo(wrapper);
					}else if (item.icon) {
						var icon_class = "alsp-ui-icon ";
						$("<span>", {
							style: "background-image: url('" + item.icon + "'); background-size: 40px; background-repeat:no-repeat;",
							class: icon_class
						})
						.appendTo(wrapper);
					}

					if (item.sublabel) {
						var sublabel = item.sublabel;

						$("<span>")
						.html(sublabel)
						.addClass("alsp-dropdowns-menu-search-sublabel")
						.appendTo(wrapper);
					} else {
						wrapper.addClass("alsp-dropdowns-menu-search-root");
					}
		
					return li.append(wrapper).appendTo(ul);
				};
			},
			
			_openMobileKeyboard: function() {
				if (!this.element.data("autocomplete-name") && screen.height <= 768) {
					return true;
				} else {
					return false;
				}
			},
			
			_createAutocomplete: function() {
				var selected = this.element.find("[data-selected=\"selected\"]");
				if (this.element.data("autocomplete-name") && this.element.data("autocomplete-value")) {
					var value = this.element.data("autocomplete-value");
				} else {
					var value = selected.data("name") ? selected.data("name") : "";
				}

				this.input = $("<input>", {
							name: this.element.data("autocomplete-name") ? this.element.data("autocomplete-name") : "",
							readonly: this._openMobileKeyboard() ? "true" : false
				})
				.appendTo(this.wrapper)
				.val(value)
				.attr("placeholder", this.element.data("placeholder"))
				.addClass("form-control alsp-main-search-field");
				
				this._autocompleteWithOptions(this.input);
				this._autocompleteRenderItem(this.input);

				var input = this.input;
				var id = this.element.data("id");

				this._on(input, {
					autocompleteselect: function(event, ui) {
						this._trigger("select", event, {
							item: ui.item
						});

						if (ui.item.is_term) {
							var name = ui.item.name;
							$('#selected_tax\\['+id+'\\]').val(ui.item.value).trigger("change");
							$('#selected_tax_text\\['+id+'\\]').val(ui.item.full_value).trigger("change");
						} else {
							var name = ui.item.value;
							$('#selected_tax\\['+id+'\\]').val('');
							$('#selected_tax_text\\['+id+'\\]').val('');
						}
						name = $('<textarea />').html(name).text(); // HTML Entity Decode
						this.input.val(name);
						this.input.trigger('change');

						event.preventDefault();
					},
					autocompletefocus: function(event, ui) {
						event.preventDefault();
					},
					click: function(event, ui) {
						if (this._openMobileKeyboard()) {
							input.trigger("focusout");
							input.autocomplete("search", '');
						} else {
							input.trigger("focus");
							input.autocomplete("search", input.val());
						}
					},
					autocompletesearch: function(event, ui) {
						if (input.val() == '') {
							$('#selected_tax\\['+id+'\\]').val('');
							$('#selected_tax_text\\['+id+'\\]').val('');
						}
					}
				});
				
				$(document).on("submit", "form", function() {
					input.autocomplete("close");
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
				_this = this,
				wasOpen = false;

				this.wrapper.addClass("has-feedback");
				$("<span>", {
					class: "alsp-dropdowns-menu-button glyphicon alsp-form-control-feedback " + this.input_icon_class
				})
				.appendTo(this.wrapper)
				.on("mousedown", function() {
					wasOpen = input.autocomplete("widget").is(":visible");
				})
				.on("click", function(e) {
					input.trigger("focus");

					// Close if already visible
					if (wasOpen) {
						return;
					}

					// Pass empty string as value to search for, displaying all results
					if (_this._openMobileKeyboard()) {
						input.autocomplete("search", '');
					} else {
						//input.autocomplete("search", input.val());
					}
				});
				
				// place reset button on the page load when input has a value
				if (input.val()) {
					this.wrapper.find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-reset");
				}
			},

			_source: function(request, response) {
				var term = $.trim(request.term).toLowerCase();
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
				var common_array = [];
				
				this.element.children("option").map(function() {
					var text = $(this).text(),
					value = $(this).val(),
					name = $(this).data("name"),
					icon = $(this).data("icon"),
					fonticolor  = $(this).data("fonticolor"),
					icontype = $(this).data("icontype"),
					count = $(this).data("count"),
					sublabel = $(this).data("sublabel"),
					term_in_name = matcher.test(name),
					term_in_sublabel = matcher.test(sublabel);
					if (this.value && (!term || term_in_name || term_in_sublabel)) {
						common_array.push({
							label: text,
							value: value,
							name: name,
							full_value: name + ', ' + sublabel,
							count: count,
							icon: icon,
							fonticolor: fonticolor,
							icontype: icontype,
							sublabel: sublabel,
							option: this,
							is_term: true,
							is_listing: false,
							term_in_name: term_in_name
						});
					}
				});

				if (this.element.data("ajax-search") && term) {
					this.wrapper.find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-loader");

					if (term in this.cache) {
						var cache_array = this.cache[term];
						this.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
						common_array = cache_array.slice(0); // simply duplicate this array

						response(common_array);
					} else {
						if (this.input.parents("form").find("[name=directories]").length) {
							var directories = this.input.parents("form").find("[name=directories]").val();
						} else {
							var directories = 0; 
						}
						
						$.ajax({
				        	url: alsp_js_objects.ajaxurl,
				        	type: "POST",
				        	dataType: "json",
				            data: {
				            	action: 'alsp_keywords_search',
				            	term: term,
				            	directories: directories
				            },
				            combobox: this,
				            success: function(response_from_the_action_function){
				            	if (response_from_the_action_function != 0 && response_from_the_action_function.listings) {
				            		var cache_array = [];
				            		response_from_the_action_function.listings.map(function(listing) {
				            			var item = {
											label: listing.title,      // text in option
											value: listing.name,      // value depends on is_term
											name: listing.name,       // text to place in input
											full_value: listing.name,       // full value of the item
											icon: listing.icon,
											sublabel: listing.sublabel,  // sub-description
											option: listing,
											is_term: false,
											is_listing: true,
											term_in_name: true
										}
				            			common_array.push(item);
				            			cache_array.push(item);
				            		});
				            		common_array.sort(alsp_sort_autocomplete_items);

				            		this.combobox.cache[term] = common_array;
				            	}
				            	response(common_array);
				            },
				            complete: function() {
				            	this.combobox.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
				            }
				        });
					}
				} else {
					if (term) {
						common_array.sort(alsp_sort_autocomplete_items);
					}
					response(common_array);
				}
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
		window.listingtype_combobox = $.widget("custom.listingtype_combobox", {
			input_icon_class: "glyphicon-filter",
			cache: new Object(),

			_create: function() {
				this.wrapper = $("<div>")
				.addClass("alsp-dropdowns-menu-listingtype-autocomplete")
				.insertAfter(this.element);

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_appendWrapper: function() {
				// when combobox is placed on sticky map or sticky search - append to its wrapper
				if (this.wrapper.parents(".alsp-maps-canvas-wrapper.alsp-sticky-scroll, .alsp-search-form.alsp-sticky-scroll").length) {
					var append_to = this.wrapper;
				} else {
					var append_to = null;
				}
				return append_to;
			},
			
			_autocompleteWithOptions: function(input) {
				input.autocomplete({
					delay: 300,
					minLength: 0,
					appendTo: this._appendWrapper(),
					source: $.proxy(this, "_source"),
					open: function(event, ui) {
						if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
							$('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
						}
					}/*,
					close: function() {
						input.trigger("focus");
						input.autocomplete("search", "");
					}*/
				});
			},
			
			_autocompleteRenderItem: function(input) {
				input.autocomplete("widget").addClass("alsp-dropdowns-menu");
				input.autocomplete("instance")._renderItem = function(ul, item) {
					var label = item.label;
					
					var counter_markup = '';
					if (typeof item.count != "undefined") {
						counter_markup = '<span class="alsp-dropdowns-menu-search-counter">' + item.count + '</span>';
					}
					
					var item_class = "alsp-dropdowns-menu-search";
					if (typeof item.is_term != "undefined" && item.is_term) {
						item_class = item_class + " alsp-dropdowns-menu-search-term";
					}
					if (typeof item.is_listing != "undefined" && item.is_listing) {
						item_class = item_class + " alsp-dropdowns-menu-search-listing";
					}

					var li = $("<li>"),
					wrapper = $("<div>", {
						html: label + counter_markup,
						class: item_class
					});

					if (item.icon && item.icontype == 'img') {
						var icon_class = "alsp-ui-icon ";
						$("<span>", {
							style: "background-image: url('" + item.icon + "'); background-size: 18px; background-repeat:no-repeat;",
							class: icon_class
						})
						.appendTo(wrapper);
					}else if(item.icon && item.icontype == 'font'){
						if(item.fonticolor != ''){
							var fontcolor = item.fonticolor;
						}else{
							var fontcolor = '';
						}
						var icon_class = "alsp-ui-icon font-icon " + item.icon;
						$("<span>", {
							style:"color:" + fontcolor + ";",
							class: icon_class
						})
						.appendTo(wrapper);
					}else if(item.icon && item.icontype == 'svg'){
						var icon_class = "alsp-ui-icon svg-icon";
						var img = '<img src="'+item.icon+'" alt="'+item.label+'" />';
						$("<span>", {
							html: img,
							class: icon_class
						})
						.appendTo(wrapper);
					}else if (item.icon) {
						var icon_class = "alsp-ui-icon ";
						$("<span>", {
							style: "background-image: url('" + item.icon + "'); background-size: 40px; background-repeat:no-repeat;",
							class: icon_class
						})
						.appendTo(wrapper);
					}

					if (item.sublabel) {
						var sublabel = item.sublabel;

						$("<span>")
						.html(sublabel)
						.addClass("alsp-dropdowns-menu-search-sublabel")
						.appendTo(wrapper);
					} else {
						wrapper.addClass("alsp-dropdowns-menu-search-root");
					}
		
					return li.append(wrapper).appendTo(ul);
				};
			},
			
			_openMobileKeyboard: function() {
				if (!this.element.data("autocomplete-name") && screen.height <= 768) {
					return true;
				} else {
					return false;
				}
			},
			
			_createAutocomplete: function() {
				var selected = this.element.find("[data-selected=\"selected\"]");
				if (this.element.data("autocomplete-name") && this.element.data("autocomplete-value")) {
					var value = this.element.data("autocomplete-value");
				} else {
					var value = selected.data("name") ? selected.data("name") : "";
				}

				this.input = $("<input>", {
							name: this.element.data("autocomplete-name") ? this.element.data("autocomplete-name") : "",
							readonly: this._openMobileKeyboard() ? "true" : false
				})
				.appendTo(this.wrapper)
				.val(value)
				.attr("placeholder", this.element.data("placeholder"))
				.addClass("form-control alsp-main-search-field");
				
				this._autocompleteWithOptions(this.input);
				this._autocompleteRenderItem(this.input);

				var input = this.input;
				var id = this.element.data("id");

				this._on(input, {
					autocompleteselect: function(event, ui) {
						this._trigger("select", event, {
							item: ui.item
						});

						if (ui.item.is_term) {
							var name = ui.item.name;
							$('#selected_tax\\['+id+'\\]').val(ui.item.value).trigger("change");
							$('#selected_tax_text\\['+id+'\\]').val(ui.item.full_value).trigger("change");
						} else {
							var name = ui.item.value;
							$('#selected_tax\\['+id+'\\]').val('');
							$('#selected_tax_text\\['+id+'\\]').val('');
						}
						name = $('<textarea />').html(name).text(); // HTML Entity Decode
						this.input.val(name);
						this.input.trigger('change');

						event.preventDefault();
					},
					autocompletefocus: function(event, ui) {
						event.preventDefault();
					},
					click: function(event, ui) {
						if (this._openMobileKeyboard()) {
							input.trigger("focusout");
							input.autocomplete("search", '');
						} else {
							input.trigger("focus");
							input.autocomplete("search", input.val());
						}
					},
					autocompletesearch: function(event, ui) {
						if (input.val() == '') {
							$('#selected_tax\\['+id+'\\]').val('');
							$('#selected_tax_text\\['+id+'\\]').val('');
						}
					}
				});
				
				$(document).on("submit", "form", function() {
					input.autocomplete("close");
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
				_this = this,
				wasOpen = false;

				this.wrapper.addClass("has-feedback");
				$("<span>", {
					class: "alsp-dropdowns-menu-button glyphicon alsp-form-control-feedback " + this.input_icon_class
				})
				.appendTo(this.wrapper)
				.on("mousedown", function() {
					wasOpen = input.autocomplete("widget").is(":visible");
				})
				.on("click", function(e) {
					input.trigger("focus");

					// Close if already visible
					if (wasOpen) {
						return;
					}

					// Pass empty string as value to search for, displaying all results
					if (_this._openMobileKeyboard()) {
						input.autocomplete("search", '');
					} else {
						//input.autocomplete("search", input.val());
					}
				});
				
				// place reset button on the page load when input has a value
				if (input.val()) {
					this.wrapper.find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-reset");
				}
			},

			_source: function(request, response) {
				var term = $.trim(request.term).toLowerCase();
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
				var common_array = [];
				
				this.element.children("option").map(function() {
					var text = $(this).text(),
					value = $(this).val(),
					name = $(this).data("name"),
					icon = $(this).data("icon"),
					fonticolor  = $(this).data("fonticolor"),
					icontype = $(this).data("icontype"),
					count = $(this).data("count"),
					sublabel = $(this).data("sublabel"),
					term_in_name = matcher.test(name),
					term_in_sublabel = matcher.test(sublabel);
					if (this.value && (!term || term_in_name || term_in_sublabel)) {
						common_array.push({
							label: text,
							value: value,
							name: name,
							full_value: name + ', ' + sublabel,
							count: count,
							icon: icon,
							fonticolor: fonticolor,
							icontype: icontype,
							sublabel: sublabel,
							option: this,
							is_term: true,
							is_listing: false,
							term_in_name: term_in_name
						});
					}
				});

				if (this.element.data("ajax-search") && term) {
					this.wrapper.find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-loader");

					if (term in this.cache) {
						var cache_array = this.cache[term];
						this.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
						common_array = cache_array.slice(0); // simply duplicate this array

						response(common_array);
					} else {
						if (this.input.parents("form").find("[name=directories]").length) {
							var directories = this.input.parents("form").find("[name=directories]").val();
						} else {
							var directories = 0; 
						}
						
						$.ajax({
				        	url: alsp_js_objects.ajaxurl,
				        	type: "POST",
				        	dataType: "json",
				            data: {
				            	action: 'alsp_keywords_search',
				            	term: term,
				            	directories: directories
				            },
				            combobox: this,
				            success: function(response_from_the_action_function){
				            	if (response_from_the_action_function != 0 && response_from_the_action_function.listings) {
				            		var cache_array = [];
				            		response_from_the_action_function.listings.map(function(listing) {
				            			var item = {
											label: listing.title,      // text in option
											value: listing.name,      // value depends on is_term
											name: listing.name,       // text to place in input
											full_value: listing.name,       // full value of the item
											icon: listing.icon,
											sublabel: listing.sublabel,  // sub-description
											option: listing,
											is_term: false,
											is_listing: true,
											term_in_name: true
										}
				            			common_array.push(item);
				            			cache_array.push(item);
				            		});
				            		common_array.sort(alsp_sort_autocomplete_items);

				            		this.combobox.cache[term] = common_array;
				            	}
				            	response(common_array);
				            },
				            complete: function() {
				            	this.combobox.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
				            }
				        });
					}
				} else {
					if (term) {
						common_array.sort(alsp_sort_autocomplete_items);
					}
					response(common_array);
				}
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
		window.keywords_autocomplete = $.widget("custom.keywords_autocomplete", categories_combobox, {
			cache: new Object(),

			_create: function() {
				this.wrapper = this.element.parent();
				this.wrapper.addClass("alsp-dropdowns-menu-keywords-autocomplete");

				this._createAutocomplete();
			},
			
			_createAutocomplete: function() {
				this._autocompleteWithOptions(this.element);
				this._autocompleteRenderItem(this.element);
				
				var input = this.element;

				this._on(input, {
					autocompleteselect: function(event, ui) {
						this._trigger("select", event, {
							item: ui.item
						});

						input.val(ui.item.value);
						input.trigger('change');

						event.preventDefault();
					},
					autocompletefocus: function(event, ui) {
						event.preventDefault();
					},
					click: function(event, ui) {
						input.trigger("focus");
						input.autocomplete("search", input.val());
					}
				});
			},

			_source: function(request, response) {
				var term = $.trim(request.term).toLowerCase();
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
				var common_array = [];
				
				if (term) {
					this.wrapper.find(".alsp-dropdowns-menu-button").addClass("alsp-search-input-loader");

					if (term in this.cache) {
						var cache_array = this.cache[term];
						this.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
						common_array = cache_array.slice(0); // simply duplicate this array
						response(common_array);
					} else {
						if (this.element.parents("form").find("[name=directories]").length) {
							var directories = this.element.parents("form").find("[name=directories]").val();
						} else {
							var directories = 0; 
						}
						
						$.ajax({
							url: alsp_js_objects.ajaxurl,
							type: "POST",
							dataType: "json",
							data: {
								action: 'alsp_keywords_search',
								term: term,
								directories: directories
							},
							combobox: this,
							success: function(response_from_the_action_function){
								if (response_from_the_action_function != 0 && response_from_the_action_function.listings) {
									response_from_the_action_function.listings.map(function(listing) {
										var item = {
												label: listing.title,      // text in option
												value: listing.name,      // value depends on is_term
												name: listing.name,       // text to place in input
												full_value: listing.name,       // full value of the item
												icon: listing.icon,
												sublabel: listing.sublabel,  // sub-description
												option: listing,
												is_term: false,
												is_listing: true,
												term_in_name: true
										}
										common_array.push(item);
									});
									common_array.sort(alsp_sort_autocomplete_items);

									this.combobox.cache[term] = common_array;
								}
								response(common_array);
							},
							complete: function() {
								this.combobox.wrapper.find(".alsp-dropdowns-menu-button").removeClass("alsp-search-input-loader");
							}
						});
					}
				}
			},
		});
		window.locations_combobox = $.widget("custom.locations_combobox", categories_combobox, {
			input_icon_class: "glyphicon-map-marker",
			placeholder: "",

			_create: function() {
				this.wrapper = $("<div>")
				.addClass("alsp-dropdowns-menu-locations-autocomplete")
				.insertAfter(this.element);
				
				this.uID = this.element.data("id");
				this.placeholder = this.element.data("placeholder");

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
				this._addMyLocationButton();
			},
			
			_createAutocomplete: function() {
				this._super();

				this._on(this.input, {
					autocompleteselect: function(event, ui) {
						var form = this.input.parents("form");
						var id = form.data("id");
						if ($("#radius_"+id).val() > 0) {
							form.trigger("submit");
						}
						this.input.trigger('change');
					}
				});
			},
			
			_addMyLocationButton: function() {
				if (this.element.data("autocomplete-name")) {
					this.wrapper.find(".alsp-form-control-feedback").addClass("alsp-get-location");
				}
			},
			
			_autocompleteRenderItem: function(input) {
				input.autocomplete("widget").addClass("alsp-dropdowns-menu");
				input.autocomplete("instance")._renderItem = function(ul, item) {
					var label = item.label;
					var counter_markup = '';
					if (typeof item.count != "undefined") {
						counter_markup = '<span class="alsp-dropdowns-menu-search-counter">' + item.count + '</span>';
					}
					//var term = $.trim(term).toLowerCase();
					var item_class = "alsp-dropdowns-menu-search";
					if (typeof item.is_term != "undefined" && item.is_term) {
						item_class = item_class + " alsp-dropdowns-menu-search-term";
					}
					if (typeof item.is_listing != "undefined" && item.is_listing) {
						item_class = item_class + " alsp-dropdowns-menu-search-listing";
					}

					var li = $("<li>"),
					wrapper = $("<div>", {
						html: label + counter_markup,
						class: item_class
					});

					if (item.icon) {
						var icon_class = "alsp-ui-icon-location";
						$("<span>", {
							style: "background-image: url('" + item.icon + "'); background-repeat:no-repeat;",
							class: icon_class
						})
						.appendTo(wrapper);
					}

					if (item.sublabel) {
						var sublabel = item.sublabel;

						$("<span>")
						.html(sublabel)
						.addClass("alsp-dropdowns-menu-search-sublabel")
						.appendTo(wrapper);
					} else {
						wrapper.addClass("alsp-dropdowns-menu-search-root");
					}
		
					return li.append(wrapper).appendTo(ul);
				};
			},

			_source: function(request, response) {
				var term = $.trim(request.term);
				
				var common_array = [];
				
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
				this.element.children("option").map(function() {
					var text = $(this).text(),
					value = $(this).val(),
					name = $(this).data("name"),
					icon = $(this).data("icon"),
					count = $(this).data("count"),
					sublabel = $(this).data("sublabel"),
					term_in_name = matcher.test(name),
					term_in_sublabel = matcher.test(sublabel);
					if (this.value && (!term || term_in_name || term_in_sublabel)) {
						common_array.push({
							label: text,
							value: value,
							name: name,
							full_value: name + ', ' + sublabel,
							icon: icon,
							count: count,
							sublabel: sublabel,
							option: this,
							is_term: true,
							term_in_name: term_in_name
						});
					}
				});

				window.alsp_collectLocationsPreditions = function(predictions, common_array, response) {
					$.map(predictions, function (prediction, i) {
						common_array.push({
							label: prediction.label,
							value: prediction.value,
							name: prediction.name,
							icon: "",
							sublabel: prediction.sublabel,
							is_term: false,
							term_in_name: true
						});
					})

					common_array.sort(alsp_sort_autocomplete_items);
					response(common_array);
				}

				if (this.element.data("autocomplete-name")) {
					if (term && alsp_maps_objects.address_autocomplete) {
						alsp_autocompleteService(term, alsp_maps_objects.address_autocomplete_code, common_array, response, alsp_collectLocationsPreditions);
					} else {
						if (term) {
							common_array.sort(alsp_sort_autocomplete_items);
						}
						response(common_array);
					}
				} else {
					if (term) {
						common_array.sort(alsp_sort_autocomplete_items);
					}
					response(common_array);
				}
			},
		});
		window.address_autocomplete = $.widget("custom.address_autocomplete", categories_combobox, {
			input_icon_class: "glyphicon-map-marker",

			_create: function() {
				this.wrapper = this.element.parent();
				this.wrapper.addClass("alsp-dropdowns-menu-locations-autocomplete");
				
				this._createAutocomplete();
				this._addMyLocationButton();
			},
			
			_addMyLocationButton: function() {
				this.element.next(".alsp-form-control-feedback").addClass("alsp-get-location");
			},
			
			_createAutocomplete: function() {
				this._autocompleteWithOptions(this.element);
				this._autocompleteRenderItem(this.element);

				var input = this.element;

				this._on(input, {
					autocompleteselect: function(event, ui) {
						this._trigger("select", event, {
							item: ui.item
						});

						input.val(ui.item.value);
						input.trigger('change');
						
						var form = input.parents("form");
						var id = form.data("id");
						if ($("#radius_"+id).val() > 0) {
							form.trigger("submit");
						}
						
						return false;
					},
					autocompletefocus: function(event, ui) {
						event.preventDefault();
					},
					click: function(event, ui) {
						input.trigger("focus");
						input.autocomplete("search", input.val());
					}
				});
			},
			
			_autocompleteRenderItem: function(input) {
				this._super(input);

				this.element.autocomplete("widget").addClass("alsp-dropdowns-menu-only-address");
			},
			
			_source: function(request, response) {
				var term = $.trim(request.term);
				
				var common_array = [];

				window.alsp_collectAddressPreditions = function(predictions, common_array, response) {
					$.map(predictions, function (prediction, i) {
						common_array.push({
							label: prediction.label,
							value: prediction.value,
							name: prediction.name,
							icon: "",
							sublabel: prediction.sublabel,
							is_term: false,
						});
					})

					common_array.sort(function(a,b) {return (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0);} );
					response(common_array);
				}

				if (term && alsp_maps_objects.address_autocomplete) {
					alsp_autocompleteService(term, alsp_maps_objects.address_autocomplete_code, common_array, response, alsp_collectAddressPreditions);
				} else {
					response(common_array);
				}
			},
		});
	}
	$(document).on('change', '.alsp-tax-dropdowns-wrap select', function() {
		var select_box = $(this).attr('id').split('_');
		var parent = $(this).val();
		var current_level = select_box[1];
		var uID = select_box[2];

		var divclass = $(this).parents('.alsp-tax-dropdowns-wrap').attr('class').split(' ');
		var tax = divclass[0];
		var count = divclass[1];
		var hide_empty = divclass[2];

		alsp_update_tax(parent, tax, current_level, count, hide_empty, uID, function() {});
	});

	function alsp_update_tax(parent, tax, current_level, count, hide_empty, uID, callback) {
		var current_level = parseInt(current_level);
		var next_level = current_level + 1;
		var prev_level = current_level - 1;
		var selects_length = $('#alsp-tax-dropdowns-wrap-'+uID+' select').length;
		
		if (parent)
			$('#selected_tax\\['+uID+'\\]').val(parent).trigger('change');
		else if (current_level > 1)
			$('#selected_tax\\['+uID+'\\]').val($('#chainlist_'+prev_level+'_'+uID).val()).trigger('change');
		else
			$('#selected_tax\\['+uID+'\\]').val(0).trigger('change');

		var exact_terms = $('#exact_terms\\['+uID+'\\]').val();

		for (var i=next_level; i<=selects_length; i++)
			$('#wrap_chainlist_'+i+'_'+uID).remove();
		
		if (parent) {
			var labels_source = alsp_js_objects['tax_dropdowns_'+uID][uID];

			if (labels_source.labels[current_level] != undefined)
				var label = labels_source.labels[current_level];
			else
				var label = '';
			if (labels_source.titles[current_level] != undefined)
				var title = labels_source.titles[current_level];
			else
				var title = '';

			$('#chainlist_'+current_level+'_'+uID).addClass('alsp-ajax-loading').attr('disabled', 'disabled');
			$.post(
				alsp_js_objects.ajaxurl,
				{'action': 'alsp_tax_dropdowns_hook', 'parentid': parent, 'next_level': next_level, 'tax': tax, 'count': count, 'hide_empty': hide_empty, 'label': label, 'title': title, 'exact_terms': exact_terms, 'uID': uID},
				function(response_from_the_action_function){
					if (response_from_the_action_function != 0)
						$('#alsp-tax-dropdowns-wrap-'+uID).append(response_from_the_action_function);

					$('#chainlist_'+current_level+'_'+uID).removeClass('alsp-ajax-loading').removeAttr('disabled');
					
					callback();
				}
			);
		}
	}
	
	function first(p){for(var i in p)return p[i];}
}(jQuery));


// jquery.coo_kie.js -------------------------------------------------------------------------------------------------------------------------------------------
jQuery.cookie=function(e,i,o){if("undefined"==typeof i){var n=null;if(document.cookie&&""!=document.cookie)for(var r=document.cookie.split(";"),t=0;t<r.length;t++){var p=jQuery.trim(r[t]);if(p.substring(0,e.length+1)==e+"="){n=decodeURIComponent(p.substring(e.length+1));break}}return n}o=o||{},null===i&&(i="",o.expires=-1);var u="";if(o.expires&&("number"==typeof o.expires||o.expires.toUTCString)){var s;"number"==typeof o.expires?(s=new Date,s.setTime(s.getTime()+24*o.expires*60*60*1e3)):s=o.expires,u="; expires="+s.toUTCString()}var a=o.path?"; path="+o.path:"",c=o.domain?"; domain="+o.domain:"",m=o.secure?"; secure":"";document.cookie=[e,"=",encodeURIComponent(i),u,a,c,m].join("")};



// jquery.bxslider.min.js -------------------------------------------------------------------------------------------------------------------------------------------
/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
!function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);


// jquery.tokenize.js -------------------------------------------------------------------------------------------------------------------------------------------
!function(e){var t={BACKSPACE:8,TAB:9,ENTER:13,ESCAPE:27,ARROW_UP:38,ARROW_DOWN:40},n=null,o="tokenize",s=function(t,n){if(!n.data(o)){var s=new e.tokenize(e.extend({},e.fn.tokenize.defaults,t));n.data(o,s),s.init(n)}return n.data(o)};e.tokenize=function(t){void 0==t&&(t=e.fn.tokenize.defaults),this.options=t},e.extend(e.tokenize.prototype,{init:function(t){var n=this;this.select=t.attr("multiple","multiple").css({margin:0,padding:0,border:0}).hide(),this.container=e("<div />").attr("class",this.select.attr("class")).addClass("Tokenize"),1==this.options.maxElements&&this.container.addClass("OnlyOne"),this.dropdown=e("<ul />").addClass("Dropdown"),this.tokensContainer=e("<ul />").addClass("TokensContainer"),this.options.autosize&&this.tokensContainer.addClass("Autosize"),this.searchToken=e("<li />").addClass("TokenSearch").appendTo(this.tokensContainer),this.searchInput=e("<input />").appendTo(this.searchToken),this.options.searchMaxLength>0&&this.searchInput.attr("maxlength",this.options.searchMaxLength),this.select.prop("disabled")&&this.disable(),this.options.sortable&&("undefined"!=typeof e.ui?this.tokensContainer.sortable({items:"li.Token",cursor:"move",placeholder:"Token MovingShadow",forcePlaceholderSize:!0,update:function(){n.updateOrder()},start:function(){n.searchToken.hide()},stop:function(){n.searchToken.show()}}).disableSelection():(this.options.sortable=!1,console.log("jQuery UI is not loaded, sortable option has been disabled"))),this.container.append(this.tokensContainer).append(this.dropdown).insertAfter(this.select),this.tokensContainer.on("click",function(e){e.stopImmediatePropagation(),n.searchInput.get(0).focus(),n.updatePlaceholder(),n.dropdown.is(":hidden")&&""!=n.searchInput.val()&&n.search()}),this.searchInput.on("blur",function(){n.tokensContainer.removeClass("Focused")}),this.searchInput.on("focus click",function(){n.tokensContainer.addClass("Focused"),n.options.displayDropdownOnFocus&&"select"==n.options.datas&&n.search()}),this.searchInput.on("keydown",function(e){n.resizeSearchInput(),n.keydown(e)}),this.searchInput.on("keyup",function(e){n.keyup(e)}),this.searchInput.on("keypress",function(e){n.keypress(e)}),this.searchInput.on("paste",function(){setTimeout(function(){n.resizeSearchInput()},10),setTimeout(function(){var t=n.searchInput.val().split(",");t.length>1&&e.each(t,function(e,t){n.tokenAdd(t.trim(),"")})},20)}),e(document).on("click",function(){n.dropdownHide(),1==n.options.maxElements&&n.searchInput.val()&&n.tokenAdd(n.searchInput.val(),"")}),this.resizeSearchInput(),this.remap(!0),this.updatePlaceholder()},updateOrder:function(){if(this.options.sortable){var t,n,o=this;e.each(this.tokensContainer.sortable("toArray",{attribute:"data-value"}),function(s,i){n=e('option[value="'+i+'"]',o.select),void 0==t?n.prependTo(o.select):t.after(n),t=n}),this.options.onReorder(this)}},updatePlaceholder:function(){0!=this.options.placeholder&&(void 0==this.placeholder&&(this.placeholder=e("<li />").addClass("Placeholder").html(this.options.placeholder),this.placeholder.insertBefore(e("li:first-child",this.tokensContainer))),0==this.searchInput.val().length&&0==e("li.Token",this.tokensContainer).length?this.placeholder.show():this.placeholder.hide())},dropdownShow:function(){this.dropdown.show()},dropdownPrev:function(){e("li.Hover",this.dropdown).length>0?e("li.Hover",this.dropdown).is("li:first-child")?(e("li.Hover",this.dropdown).removeClass("Hover"),e("li:last-child",this.dropdown).addClass("Hover")):e("li.Hover",this.dropdown).removeClass("Hover").prev().addClass("Hover"):e("li:first",this.dropdown).addClass("Hover")},dropdownNext:function(){e("li.Hover",this.dropdown).length>0?e("li.Hover",this.dropdown).is("li:last-child")?(e("li.Hover",this.dropdown).removeClass("Hover"),e("li:first-child",this.dropdown).addClass("Hover")):e("li.Hover",this.dropdown).removeClass("Hover").next().addClass("Hover"):e("li:first",this.dropdown).addClass("Hover")},dropdownAddItem:function(t,n,o){if(void 0==o&&(o=n),!e('li[data-value="'+t+'"]',this.tokensContainer).length){var s=this,i=e("<li />").attr("data-value",t).attr("data-text",n).html(o).on("click",function(t){t.stopImmediatePropagation(),s.tokenAdd(e(this).attr("data-value"),e(this).attr("data-text"))}).on("mouseover",function(){e(this).addClass("Hover")}).on("mouseout",function(){e("li",s.dropdown).removeClass("Hover")});this.dropdown.append(i),this.options.onDropdownAddItem(t,n,o,this)}return this},dropdownHide:function(){this.dropdownReset(),this.dropdown.hide()},dropdownReset:function(){this.dropdown.html("")},resizeSearchInput:function(){this.searchInput.attr("size",Number(this.searchInput.val().length)+5),this.updatePlaceholder()},resetSearchInput:function(){this.searchInput.val(""),this.resizeSearchInput()},resetPendingTokens:function(){e("li.PendingDelete",this.tokensContainer).removeClass("PendingDelete")},keypress:function(e){String.fromCharCode(e.which)==this.options.delimiter&&(e.preventDefault(),this.tokenAdd(this.searchInput.val(),""))},keydown:function(n){switch(n.keyCode){case t.BACKSPACE:0==this.searchInput.val().length&&(n.preventDefault(),e("li.Token.PendingDelete",this.tokensContainer).length?this.tokenRemove(e("li.Token.PendingDelete").attr("data-value")):e("li.Token:last",this.tokensContainer).addClass("PendingDelete"),this.dropdownHide());break;case t.TAB:case t.ENTER:if(e("li.Hover",this.dropdown).length){var o=e("li.Hover",this.dropdown);n.preventDefault(),this.tokenAdd(o.attr("data-value"),o.attr("data-text"))}else this.searchInput.val()&&(n.preventDefault(),this.tokenAdd(this.searchInput.val(),""));this.resetPendingTokens();break;case t.ESCAPE:this.resetSearchInput(),this.dropdownHide(),this.resetPendingTokens();break;case t.ARROW_UP:n.preventDefault(),this.dropdownPrev();break;case t.ARROW_DOWN:n.preventDefault(),this.dropdownNext();break;default:this.resetPendingTokens()}},keyup:function(e){switch(this.updatePlaceholder(),e.keyCode){case t.TAB:case t.ENTER:case t.ESCAPE:case t.ARROW_UP:case t.ARROW_DOWN:break;case t.BACKSPACE:this.searchInput.val()?this.search():this.dropdownHide();break;default:this.searchInput.val()&&this.search()}},search:function(){var t=this,n=1;if(this.options.maxElements>0&&e("li.Token",this.tokensContainer).length>=this.options.maxElements)return!1;if("select"==this.options.datas){var o=!1,s=new RegExp(this.searchInput.val().replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),"i");this.dropdownReset(),e("option",this.select).not(":selected, :disabled").each(function(){return n<=t.options.nbDropdownElements?void(s.test(e(this).html())&&(t.dropdownAddItem(e(this).attr("value"),e(this).html()),o=!0,n++)):!1}),o?(e("li:first",this.dropdown).addClass("Hover"),this.dropdownShow()):this.dropdownHide()}else this.debounce(function(){e.ajax({url:t.options.datas,data:t.options.searchParam+"="+t.searchInput.val(),dataType:t.options.dataType,success:function(o){return o&&(t.dropdownReset(),e.each(o,function(e,o){if(!(n<=t.options.nbDropdownElements))return!1;var s=void 0;o[t.options.htmlField]&&(s=o[t.options.htmlField]),t.dropdownAddItem(o[t.options.valueField],o[t.options.textField],s),n++}),e("li",t.dropdown).length)?(e("li:first",t.dropdown).addClass("Hover"),t.dropdownShow(),!0):void t.dropdownHide()},error:function(e,t){console.log("Error : "+t)}})},this.options.debounce)},debounce:function(e,t){var o=this,s=arguments,i=function(){e.apply(o,s),n=null};n&&clearTimeout(n),n=setTimeout(i,t||this.options.debounce)},tokenAdd:function(t,n,o){if(t=this.escape(t),void 0==t||""==t)return this;if((void 0==n||""==n)&&(n=t),void 0==o&&(o=!1),this.options.maxElements>0&&e("li.Token",this.tokensContainer).length>=this.options.maxElements)return this.resetSearchInput(),this;var s=this,i=e("<a />").addClass("Close").html("&#215;").on("click",function(e){e.stopImmediatePropagation(),s.tokenRemove(t)});if(e('option[value="'+t+'"]',this.select).length)e('option[value="'+t+'"]',this.select).attr("selected",!0).prop("selected",!0);else{if(!(this.options.newElements||!this.options.newElements&&e('li[data-value="'+t+'"]',this.dropdown).length>0))return this.resetSearchInput(),this;var a=e("<option />").attr("selected",!0).attr("value",t).attr("data-type","custom").prop("selected",!0).html(n);this.select.append(a)}return e('li.Token[data-value="'+t+'"]',this.tokensContainer).length>0?this:(e("<li />").addClass("Token").attr("data-value",t).append("<span>"+n+"</span>").prepend(i).insertBefore(this.searchToken),o||this.options.onAddToken(t,n,this),this.resetSearchInput(),this.dropdownHide(),this.updateOrder(),this)},tokenRemove:function(t){var n=e('option[value="'+t+'"]',this.select);return"custom"==n.attr("data-type")?n.remove():n.removeAttr("selected").prop("selected",!1),e('li.Token[data-value="'+t+'"]',this.tokensContainer).remove(),this.options.onRemoveToken(t,this),this.resizeSearchInput(),this.dropdownHide(),this.updateOrder(),this},clear:function(){var t=this;return e("li.Token",this.tokensContainer).each(function(){t.tokenRemove(e(this).attr("data-value"))}),this.options.onClear(this),this.dropdownHide(),this},disable:function(){return this.select.prop("disabled",!0),this.searchInput.prop("disabled",!0),this.container.addClass("Disabled"),this.options.sortable&&this.tokensContainer.sortable("disable"),this},enable:function(){return this.select.prop("disabled",!1),this.searchInput.prop("disabled",!1),this.container.removeClass("Disabled"),this.options.sortable&&this.tokensContainer.sortable("enable"),this},remap:function(t){var n=this,o=e("option:selected",this.select);return void 0==t&&(t=!1),this.clear(),o.each(function(){n.tokenAdd(e(this).val(),e(this).html(),t)}),this},toArray:function(){var t=[];return e("option:selected",this.select).each(function(){t.push(e(this).val())}),t},escape:function(e){return String(e).replace(/["]/g,function(){return""})}}),e.fn.tokenize=function(t){void 0==t&&(t={});var n=this.filter("select");return n.length>1?(n.each(function(){s(t,e(this))}),n):s(t,e(this))},e.fn.tokenize.defaults={datas:"select",placeholder:!1,searchParam:"search",searchMaxLength:0,debounce:0,delimiter:",",newElements:!0,autosize:!1,nbDropdownElements:10,displayDropdownOnFocus:!1,maxElements:0,sortable:!1,dataType:"json",valueField:"value",textField:"text",htmlField:"html",onAddToken:function(){},onRemoveToken:function(){},onClear:function(){},onReorder:function(){},onDropdownAddItem:function(){}}}(jQuery,"tokenize");


/* jquery.nicescroll v3.7.6 InuYaksa - MIT - https://nicescroll.areaaperta.com */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){"use strict";var o=!1,t=!1,r=0,i=2e3,s=0,n=e,l=document,a=window,c=n(a),d=[],u=a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame||!1,h=a.cancelAnimationFrame||a.webkitCancelAnimationFrame||a.mozCancelAnimationFrame||!1;if(u)a.cancelAnimationFrame||(h=function(e){});else{var p=0;u=function(e,o){var t=(new Date).getTime(),r=Math.max(0,16-(t-p)),i=a.setTimeout(function(){e(t+r)},r);return p=t+r,i},h=function(e){a.clearTimeout(e)}}var m=a.MutationObserver||a.WebKitMutationObserver||!1,f=Date.now||function(){return(new Date).getTime()},g={zindex:"auto",cursoropacitymin:0,cursoropacitymax:1,cursorcolor:"#424242",cursorwidth:"6px",cursorborder:"1px solid #fff",cursorborderradius:"5px",scrollspeed:40,mousescrollstep:27,touchbehavior:!1,emulatetouch:!1,hwacceleration:!0,usetransition:!0,boxzoom:!1,dblclickzoom:!0,gesturezoom:!0,grabcursorenabled:!0,autohidemode:!0,background:"",iframeautoresize:!0,cursorminheight:32,preservenativescrolling:!0,railoffset:!1,railhoffset:!1,bouncescroll:!0,spacebarenabled:!0,railpadding:{top:0,right:0,left:0,bottom:0},disableoutline:!0,horizrailenabled:!0,railalign:"right",railvalign:"bottom",enabletranslate3d:!0,enablemousewheel:!0,enablekeyboard:!0,smoothscroll:!0,sensitiverail:!0,enablemouselockapi:!0,cursorfixedheight:!1,directionlockdeadzone:6,hidecursordelay:400,nativeparentscrolling:!0,enablescrollonselection:!0,overflowx:!0,overflowy:!0,cursordragspeed:.3,rtlmode:"auto",cursordragontouch:!1,oneaxismousemode:"auto",scriptpath:function(){var e=l.currentScript||function(){var e=l.getElementsByTagName("script");return!!e.length&&e[e.length-1]}(),o=e?e.src.split("?")[0]:"";return o.split("/").length>0?o.split("/").slice(0,-1).join("/")+"/":""}(),preventmultitouchscrolling:!0,disablemutationobserver:!1,enableobserver:!0,scrollbarid:!1},v=!1,w=function(){if(v)return v;var e=l.createElement("DIV"),o=e.style,t=navigator.userAgent,r=navigator.platform,i={};return i.haspointerlock="pointerLockElement"in l||"webkitPointerLockElement"in l||"mozPointerLockElement"in l,i.isopera="opera"in a,i.isopera12=i.isopera&&"getUserMedia"in navigator,i.isoperamini="[object OperaMini]"===Object.prototype.toString.call(a.operamini),i.isie="all"in l&&"attachEvent"in e&&!i.isopera,i.isieold=i.isie&&!("msInterpolationMode"in o),i.isie7=i.isie&&!i.isieold&&(!("documentMode"in l)||7===l.documentMode),i.isie8=i.isie&&"documentMode"in l&&8===l.documentMode,i.isie9=i.isie&&"performance"in a&&9===l.documentMode,i.isie10=i.isie&&"performance"in a&&10===l.documentMode,i.isie11="msRequestFullscreen"in e&&l.documentMode>=11,i.ismsedge="msCredentials"in a,i.ismozilla="MozAppearance"in o,i.iswebkit=!i.ismsedge&&"WebkitAppearance"in o,i.ischrome=i.iswebkit&&"chrome"in a,i.ischrome38=i.ischrome&&"touchAction"in o,i.ischrome22=!i.ischrome38&&i.ischrome&&i.haspointerlock,i.ischrome26=!i.ischrome38&&i.ischrome&&"transition"in o,i.cantouch="ontouchstart"in l.documentElement||"ontouchstart"in a,i.hasw3ctouch=(a.PointerEvent||!1)&&(navigator.maxTouchPoints>0||navigator.msMaxTouchPoints>0),i.hasmstouch=!i.hasw3ctouch&&(a.MSPointerEvent||!1),i.ismac=/^mac$/i.test(r),i.isios=i.cantouch&&/iphone|ipad|ipod/i.test(r),i.isios4=i.isios&&!("seal"in Object),i.isios7=i.isios&&"webkitHidden"in l,i.isios8=i.isios&&"hidden"in l,i.isios10=i.isios&&a.Proxy,i.isandroid=/android/i.test(t),i.haseventlistener="addEventListener"in e,i.trstyle=!1,i.hastransform=!1,i.hastranslate3d=!1,i.transitionstyle=!1,i.hastransition=!1,i.transitionend=!1,i.trstyle="transform",i.hastransform="transform"in o||function(){for(var e=["msTransform","webkitTransform","MozTransform","OTransform"],t=0,r=e.length;t<r;t++)if(void 0!==o[e[t]]){i.trstyle=e[t];break}i.hastransform=!!i.trstyle}(),i.hastransform&&(o[i.trstyle]="translate3d(1px,2px,3px)",i.hastranslate3d=/translate3d/.test(o[i.trstyle])),i.transitionstyle="transition",i.prefixstyle="",i.transitionend="transitionend",i.hastransition="transition"in o||function(){i.transitionend=!1;for(var e=["webkitTransition","msTransition","MozTransition","OTransition","OTransition","KhtmlTransition"],t=["-webkit-","-ms-","-moz-","-o-","-o","-khtml-"],r=["webkitTransitionEnd","msTransitionEnd","transitionend","otransitionend","oTransitionEnd","KhtmlTransitionEnd"],s=0,n=e.length;s<n;s++)if(e[s]in o){i.transitionstyle=e[s],i.prefixstyle=t[s],i.transitionend=r[s];break}i.ischrome26&&(i.prefixstyle=t[1]),i.hastransition=i.transitionstyle}(),i.cursorgrabvalue=function(){var e=["grab","-webkit-grab","-moz-grab"];(i.ischrome&&!i.ischrome38||i.isie)&&(e=[]);for(var t=0,r=e.length;t<r;t++){var s=e[t];if(o.cursor=s,o.cursor==s)return s}return"url(https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.3.0/css/images/openhand.cur),n-resize"}(),i.hasmousecapture="setCapture"in e,i.hasMutationObserver=!1!==m,e=null,v=i,i},b=function(e,p){function v(){var e=T.doc.css(P.trstyle);return!(!e||"matrix"!=e.substr(0,6))&&e.replace(/^.*\((.*)\)$/g,"$1").replace(/px/g,"").split(/, +/)}function b(){var e=T.win;if("zIndex"in e)return e.zIndex();for(;e.length>0;){if(9==e[0].nodeType)return!1;var o=e.css("zIndex");if(!isNaN(o)&&0!==o)return parseInt(o);e=e.parent()}return!1}function x(e,o,t){var r=e.css(o),i=parseFloat(r);if(isNaN(i)){var s=3==(i=I[r]||0)?t?T.win.outerHeight()-T.win.innerHeight():T.win.outerWidth()-T.win.innerWidth():1;return T.isie8&&i&&(i+=1),s?i:0}return i}function S(e,o,t,r){T._bind(e,o,function(r){var i={original:r=r||a.event,target:r.target||r.srcElement,type:"wheel",deltaMode:"MozMousePixelScroll"==r.type?0:1,deltaX:0,deltaZ:0,preventDefault:function(){return r.preventDefault?r.preventDefault():r.returnValue=!1,!1},stopImmediatePropagation:function(){r.stopImmediatePropagation?r.stopImmediatePropagation():r.cancelBubble=!0}};return"mousewheel"==o?(r.wheelDeltaX&&(i.deltaX=-.025*r.wheelDeltaX),r.wheelDeltaY&&(i.deltaY=-.025*r.wheelDeltaY),!i.deltaY&&!i.deltaX&&(i.deltaY=-.025*r.wheelDelta)):i.deltaY=r.detail,t.call(e,i)},r)}function z(e,o,t,r){T.scrollrunning||(T.newscrolly=T.getScrollTop(),T.newscrollx=T.getScrollLeft(),D=f());var i=f()-D;if(D=f(),i>350?A=1:A+=(2-A)/10,e=e*A|0,o=o*A|0,e){if(r)if(e<0){if(T.getScrollLeft()>=T.page.maxw)return!0}else if(T.getScrollLeft()<=0)return!0;var s=e>0?1:-1;X!==s&&(T.scrollmom&&T.scrollmom.stop(),T.newscrollx=T.getScrollLeft(),X=s),T.lastdeltax-=e}if(o){if(function(){var e=T.getScrollTop();if(o<0){if(e>=T.page.maxh)return!0}else if(e<=0)return!0}()){if(M.nativeparentscrolling&&t&&!T.ispage&&!T.zoomactive)return!0;var n=T.view.h>>1;T.newscrolly<-n?(T.newscrolly=-n,o=-1):T.newscrolly>T.page.maxh+n?(T.newscrolly=T.page.maxh+n,o=1):o=0}var l=o>0?1:-1;B!==l&&(T.scrollmom&&T.scrollmom.stop(),T.newscrolly=T.getScrollTop(),B=l),T.lastdeltay-=o}(o||e)&&T.synched("relativexy",function(){var e=T.lastdeltay+T.newscrolly;T.lastdeltay=0;var o=T.lastdeltax+T.newscrollx;T.lastdeltax=0,T.rail.drag||T.doScrollPos(o,e)})}function k(e,o,t){var r,i;return!(t||!q)||(0===e.deltaMode?(r=-e.deltaX*(M.mousescrollstep/54)|0,i=-e.deltaY*(M.mousescrollstep/54)|0):1===e.deltaMode&&(r=-e.deltaX*M.mousescrollstep*50/80|0,i=-e.deltaY*M.mousescrollstep*50/80|0),o&&M.oneaxismousemode&&0===r&&i&&(r=i,i=0,t&&(r<0?T.getScrollLeft()>=T.page.maxw:T.getScrollLeft()<=0)&&(i=r,r=0)),T.isrtlmode&&(r=-r),z(r,i,t,!0)?void(t&&(q=!0)):(q=!1,e.stopImmediatePropagation(),e.preventDefault()))}var T=this;this.version="3.7.6",this.name="nicescroll",this.me=p;var E=n("body"),M=this.opt={doc:E,win:!1};if(n.extend(M,g),M.snapbackspeed=80,e)for(var L in M)void 0!==e[L]&&(M[L]=e[L]);if(M.disablemutationobserver&&(m=!1),this.doc=M.doc,this.iddoc=this.doc&&this.doc[0]?this.doc[0].id||"":"",this.ispage=/^BODY|HTML/.test(M.win?M.win[0].nodeName:this.doc[0].nodeName),this.haswrapper=!1!==M.win,this.win=M.win||(this.ispage?c:this.doc),this.docscroll=this.ispage&&!this.haswrapper?c:this.win,this.body=E,this.viewport=!1,this.isfixed=!1,this.iframe=!1,this.isiframe="IFRAME"==this.doc[0].nodeName&&"IFRAME"==this.win[0].nodeName,this.istextarea="TEXTAREA"==this.win[0].nodeName,this.forcescreen=!1,this.canshowonmouseevent="scroll"!=M.autohidemode,this.onmousedown=!1,this.onmouseup=!1,this.onmousemove=!1,this.onmousewheel=!1,this.onkeypress=!1,this.ongesturezoom=!1,this.onclick=!1,this.onscrollstart=!1,this.onscrollend=!1,this.onscrollcancel=!1,this.onzoomin=!1,this.onzoomout=!1,this.view=!1,this.page=!1,this.scroll={x:0,y:0},this.scrollratio={x:0,y:0},this.cursorheight=20,this.scrollvaluemax=0,"auto"==M.rtlmode){var C=this.win[0]==a?this.body:this.win,N=C.css("writing-mode")||C.css("-webkit-writing-mode")||C.css("-ms-writing-mode")||C.css("-moz-writing-mode");"horizontal-tb"==N||"lr-tb"==N||""===N?(this.isrtlmode="rtl"==C.css("direction"),this.isvertical=!1):(this.isrtlmode="vertical-rl"==N||"tb"==N||"tb-rl"==N||"rl-tb"==N,this.isvertical="vertical-rl"==N||"tb"==N||"tb-rl"==N)}else this.isrtlmode=!0===M.rtlmode,this.isvertical=!1;if(this.scrollrunning=!1,this.scrollmom=!1,this.observer=!1,this.observerremover=!1,this.observerbody=!1,!1!==M.scrollbarid)this.id=M.scrollbarid;else do{this.id="ascrail"+i++}while(l.getElementById(this.id));this.rail=!1,this.cursor=!1,this.cursorfreezed=!1,this.selectiondrag=!1,this.zoom=!1,this.zoomactive=!1,this.hasfocus=!1,this.hasmousefocus=!1,this.railslocked=!1,this.locked=!1,this.hidden=!1,this.cursoractive=!0,this.wheelprevented=!1,this.overflowx=M.overflowx,this.overflowy=M.overflowy,this.nativescrollingarea=!1,this.checkarea=0,this.events=[],this.saved={},this.delaylist={},this.synclist={},this.lastdeltax=0,this.lastdeltay=0,this.detected=w();var P=n.extend({},this.detected);this.canhwscroll=P.hastransform&&M.hwacceleration,this.ishwscroll=this.canhwscroll&&T.haswrapper,this.isrtlmode?this.isvertical?this.hasreversehr=!(P.iswebkit||P.isie||P.isie11):this.hasreversehr=!(P.iswebkit||P.isie&&!P.isie10&&!P.isie11):this.hasreversehr=!1,this.istouchcapable=!1,P.cantouch||!P.hasw3ctouch&&!P.hasmstouch?!P.cantouch||P.isios||P.isandroid||!P.iswebkit&&!P.ismozilla||(this.istouchcapable=!0):this.istouchcapable=!0,M.enablemouselockapi||(P.hasmousecapture=!1,P.haspointerlock=!1),this.debounced=function(e,o,t){T&&(T.delaylist[e]||!1||(T.delaylist[e]={h:u(function(){T.delaylist[e].fn.call(T),T.delaylist[e]=!1},t)},o.call(T)),T.delaylist[e].fn=o)},this.synched=function(e,o){T.synclist[e]?T.synclist[e]=o:(T.synclist[e]=o,u(function(){T&&(T.synclist[e]&&T.synclist[e].call(T),T.synclist[e]=null)}))},this.unsynched=function(e){T.synclist[e]&&(T.synclist[e]=!1)},this.css=function(e,o){for(var t in o)T.saved.css.push([e,t,e.css(t)]),e.css(t,o[t])},this.scrollTop=function(e){return void 0===e?T.getScrollTop():T.setScrollTop(e)},this.scrollLeft=function(e){return void 0===e?T.getScrollLeft():T.setScrollLeft(e)};var R=function(e,o,t,r,i,s,n){this.st=e,this.ed=o,this.spd=t,this.p1=r||0,this.p2=i||1,this.p3=s||0,this.p4=n||1,this.ts=f(),this.df=o-e};if(R.prototype={B2:function(e){return 3*(1-e)*(1-e)*e},B3:function(e){return 3*(1-e)*e*e},B4:function(e){return e*e*e},getPos:function(){return(f()-this.ts)/this.spd},getNow:function(){var e=(f()-this.ts)/this.spd,o=this.B2(e)+this.B3(e)+this.B4(e);return e>=1?this.ed:this.st+this.df*o|0},update:function(e,o){return this.st=this.getNow(),this.ed=e,this.spd=o,this.ts=f(),this.df=this.ed-this.st,this}},this.ishwscroll){this.doc.translate={x:0,y:0,tx:"0px",ty:"0px"},P.hastranslate3d&&P.isios&&this.doc.css("-webkit-backface-visibility","hidden"),this.getScrollTop=function(e){if(!e){var o=v();if(o)return 16==o.length?-o[13]:-o[5];if(T.timerscroll&&T.timerscroll.bz)return T.timerscroll.bz.getNow()}return T.doc.translate.y},this.getScrollLeft=function(e){if(!e){var o=v();if(o)return 16==o.length?-o[12]:-o[4];if(T.timerscroll&&T.timerscroll.bh)return T.timerscroll.bh.getNow()}return T.doc.translate.x},this.notifyScrollEvent=function(e){var o=l.createEvent("UIEvents");o.initUIEvent("scroll",!1,!1,a,1),o.niceevent=!0,e.dispatchEvent(o)};var _=this.isrtlmode?1:-1;P.hastranslate3d&&M.enabletranslate3d?(this.setScrollTop=function(e,o){T.doc.translate.y=e,T.doc.translate.ty=-1*e+"px",T.doc.css(P.trstyle,"translate3d("+T.doc.translate.tx+","+T.doc.translate.ty+",0)"),o||T.notifyScrollEvent(T.win[0])},this.setScrollLeft=function(e,o){T.doc.translate.x=e,T.doc.translate.tx=e*_+"px",T.doc.css(P.trstyle,"translate3d("+T.doc.translate.tx+","+T.doc.translate.ty+",0)"),o||T.notifyScrollEvent(T.win[0])}):(this.setScrollTop=function(e,o){T.doc.translate.y=e,T.doc.translate.ty=-1*e+"px",T.doc.css(P.trstyle,"translate("+T.doc.translate.tx+","+T.doc.translate.ty+")"),o||T.notifyScrollEvent(T.win[0])},this.setScrollLeft=function(e,o){T.doc.translate.x=e,T.doc.translate.tx=e*_+"px",T.doc.css(P.trstyle,"translate("+T.doc.translate.tx+","+T.doc.translate.ty+")"),o||T.notifyScrollEvent(T.win[0])})}else this.getScrollTop=function(){return T.docscroll.scrollTop()},this.setScrollTop=function(e){T.docscroll.scrollTop(e)},this.getScrollLeft=function(){return T.hasreversehr?T.detected.ismozilla?T.page.maxw-Math.abs(T.docscroll.scrollLeft()):T.page.maxw-T.docscroll.scrollLeft():T.docscroll.scrollLeft()},this.setScrollLeft=function(e){return setTimeout(function(){if(T)return T.hasreversehr&&(e=T.detected.ismozilla?-(T.page.maxw-e):T.page.maxw-e),T.docscroll.scrollLeft(e)},1)};this.getTarget=function(e){return!!e&&(e.target?e.target:!!e.srcElement&&e.srcElement)},this.hasParent=function(e,o){if(!e)return!1;for(var t=e.target||e.srcElement||e||!1;t&&t.id!=o;)t=t.parentNode||!1;return!1!==t};var I={thin:1,medium:3,thick:5};this.getDocumentScrollOffset=function(){return{top:a.pageYOffset||l.documentElement.scrollTop,left:a.pageXOffset||l.documentElement.scrollLeft}},this.getOffset=function(){if(T.isfixed){var e=T.win.offset(),o=T.getDocumentScrollOffset();return e.top-=o.top,e.left-=o.left,e}var t=T.win.offset();if(!T.viewport)return t;var r=T.viewport.offset();return{top:t.top-r.top,left:t.left-r.left}},this.updateScrollBar=function(e){var o,t;if(T.ishwscroll)T.rail.css({height:T.win.innerHeight()-(M.railpadding.top+M.railpadding.bottom)}),T.railh&&T.railh.css({width:T.win.innerWidth()-(M.railpadding.left+M.railpadding.right)});else{var r=T.getOffset();if(o={top:r.top,left:r.left-(M.railpadding.left+M.railpadding.right)},o.top+=x(T.win,"border-top-width",!0),o.left+=T.rail.align?T.win.outerWidth()-x(T.win,"border-right-width")-T.rail.width:x(T.win,"border-left-width"),(t=M.railoffset)&&(t.top&&(o.top+=t.top),t.left&&(o.left+=t.left)),T.railslocked||T.rail.css({top:o.top,left:o.left,height:(e?e.h:T.win.innerHeight())-(M.railpadding.top+M.railpadding.bottom)}),T.zoom&&T.zoom.css({top:o.top+1,left:1==T.rail.align?o.left-20:o.left+T.rail.width+4}),T.railh&&!T.railslocked){o={top:r.top,left:r.left},(t=M.railhoffset)&&(t.top&&(o.top+=t.top),t.left&&(o.left+=t.left));var i=T.railh.align?o.top+x(T.win,"border-top-width",!0)+T.win.innerHeight()-T.railh.height:o.top+x(T.win,"border-top-width",!0),s=o.left+x(T.win,"border-left-width");T.railh.css({top:i-(M.railpadding.top+M.railpadding.bottom),left:s,width:T.railh.width})}}},this.doRailClick=function(e,o,t){var r,i,s,n;T.railslocked||(T.cancelEvent(e),"pageY"in e||(e.pageX=e.clientX+l.documentElement.scrollLeft,e.pageY=e.clientY+l.documentElement.scrollTop),o?(r=t?T.doScrollLeft:T.doScrollTop,s=t?(e.pageX-T.railh.offset().left-T.cursorwidth/2)*T.scrollratio.x:(e.pageY-T.rail.offset().top-T.cursorheight/2)*T.scrollratio.y,T.unsynched("relativexy"),r(0|s)):(r=t?T.doScrollLeftBy:T.doScrollBy,s=t?T.scroll.x:T.scroll.y,n=t?e.pageX-T.railh.offset().left:e.pageY-T.rail.offset().top,i=t?T.view.w:T.view.h,r(s>=n?i:-i)))},T.newscrolly=T.newscrollx=0,T.hasanimationframe="requestAnimationFrame"in a,T.hascancelanimationframe="cancelAnimationFrame"in a,T.hasborderbox=!1,this.init=function(){if(T.saved.css=[],P.isoperamini)return!0;if(P.isandroid&&!("hidden"in l))return!0;M.emulatetouch=M.emulatetouch||M.touchbehavior,T.hasborderbox=a.getComputedStyle&&"border-box"===a.getComputedStyle(l.body)["box-sizing"];var e={"overflow-y":"hidden"};if((P.isie11||P.isie10)&&(e["-ms-overflow-style"]="none"),T.ishwscroll&&(this.doc.css(P.transitionstyle,P.prefixstyle+"transform 0ms ease-out"),P.transitionend&&T.bind(T.doc,P.transitionend,T.onScrollTransitionEnd,!1)),T.zindex="auto",T.ispage||"auto"!=M.zindex?T.zindex=M.zindex:T.zindex=b()||"auto",!T.ispage&&"auto"!=T.zindex&&T.zindex>s&&(s=T.zindex),T.isie&&0===T.zindex&&"auto"==M.zindex&&(T.zindex="auto"),!T.ispage||!P.isieold){var i=T.docscroll;T.ispage&&(i=T.haswrapper?T.win:T.doc),T.css(i,e),T.ispage&&(P.isie11||P.isie)&&T.css(n("html"),e),!P.isios||T.ispage||T.haswrapper||T.css(E,{"-webkit-overflow-scrolling":"touch"});var d=n(l.createElement("div"));d.css({position:"relative",top:0,float:"right",width:M.cursorwidth,height:0,"background-color":M.cursorcolor,border:M.cursorborder,"background-clip":"padding-box","-webkit-border-radius":M.cursorborderradius,"-moz-border-radius":M.cursorborderradius,"border-radius":M.cursorborderradius}),d.addClass("nicescroll-cursors"),T.cursor=d;var u=n(l.createElement("div"));u.attr("id",T.id),u.addClass("nicescroll-rails nicescroll-rails-vr");var h,p,f=["left","right","top","bottom"];for(var g in f)p=f[g],(h=M.railpadding[p]||0)&&u.css("padding-"+p,h+"px");u.append(d),u.width=Math.max(parseFloat(M.cursorwidth),d.outerWidth()),u.css({width:u.width+"px",zIndex:T.zindex,background:M.background,cursor:"default"}),u.visibility=!0,u.scrollable=!0,u.align="left"==M.railalign?0:1,T.rail=u,T.rail.drag=!1;var v=!1;!M.boxzoom||T.ispage||P.isieold||(v=l.createElement("div"),T.bind(v,"click",T.doZoom),T.bind(v,"mouseenter",function(){T.zoom.css("opacity",M.cursoropacitymax)}),T.bind(v,"mouseleave",function(){T.zoom.css("opacity",M.cursoropacitymin)}),T.zoom=n(v),T.zoom.css({cursor:"pointer",zIndex:T.zindex,backgroundImage:"url("+M.scriptpath+"zoomico.png)",height:18,width:18,backgroundPosition:"0 0"}),M.dblclickzoom&&T.bind(T.win,"dblclick",T.doZoom),P.cantouch&&M.gesturezoom&&(T.ongesturezoom=function(e){return e.scale>1.5&&T.doZoomIn(e),e.scale<.8&&T.doZoomOut(e),T.cancelEvent(e)},T.bind(T.win,"gestureend",T.ongesturezoom))),T.railh=!1;var w;if(M.horizrailenabled&&(T.css(i,{overflowX:"hidden"}),(d=n(l.createElement("div"))).css({position:"absolute",top:0,height:M.cursorwidth,width:0,backgroundColor:M.cursorcolor,border:M.cursorborder,backgroundClip:"padding-box","-webkit-border-radius":M.cursorborderradius,"-moz-border-radius":M.cursorborderradius,"border-radius":M.cursorborderradius}),P.isieold&&d.css("overflow","hidden"),d.addClass("nicescroll-cursors"),T.cursorh=d,(w=n(l.createElement("div"))).attr("id",T.id+"-hr"),w.addClass("nicescroll-rails nicescroll-rails-hr"),w.height=Math.max(parseFloat(M.cursorwidth),d.outerHeight()),w.css({height:w.height+"px",zIndex:T.zindex,background:M.background}),w.append(d),w.visibility=!0,w.scrollable=!0,w.align="top"==M.railvalign?0:1,T.railh=w,T.railh.drag=!1),T.ispage)u.css({position:"fixed",top:0,height:"100%"}),u.css(u.align?{right:0}:{left:0}),T.body.append(u),T.railh&&(w.css({position:"fixed",left:0,width:"100%"}),w.css(w.align?{bottom:0}:{top:0}),T.body.append(w));else{if(T.ishwscroll){"static"==T.win.css("position")&&T.css(T.win,{position:"relative"});var x="HTML"==T.win[0].nodeName?T.body:T.win;n(x).scrollTop(0).scrollLeft(0),T.zoom&&(T.zoom.css({position:"absolute",top:1,right:0,"margin-right":u.width+4}),x.append(T.zoom)),u.css({position:"absolute",top:0}),u.css(u.align?{right:0}:{left:0}),x.append(u),w&&(w.css({position:"absolute",left:0,bottom:0}),w.css(w.align?{bottom:0}:{top:0}),x.append(w))}else{T.isfixed="fixed"==T.win.css("position");var S=T.isfixed?"fixed":"absolute";T.isfixed||(T.viewport=T.getViewport(T.win[0])),T.viewport&&(T.body=T.viewport,/fixed|absolute/.test(T.viewport.css("position"))||T.css(T.viewport,{position:"relative"})),u.css({position:S}),T.zoom&&T.zoom.css({position:S}),T.updateScrollBar(),T.body.append(u),T.zoom&&T.body.append(T.zoom),T.railh&&(w.css({position:S}),T.body.append(w))}P.isios&&T.css(T.win,{"-webkit-tap-highlight-color":"rgba(0,0,0,0)","-webkit-touch-callout":"none"}),M.disableoutline&&(P.isie&&T.win.attr("hideFocus","true"),P.iswebkit&&T.win.css("outline","none"))}if(!1===M.autohidemode?(T.autohidedom=!1,T.rail.css({opacity:M.cursoropacitymax}),T.railh&&T.railh.css({opacity:M.cursoropacitymax})):!0===M.autohidemode||"leave"===M.autohidemode?(T.autohidedom=n().add(T.rail),P.isie8&&(T.autohidedom=T.autohidedom.add(T.cursor)),T.railh&&(T.autohidedom=T.autohidedom.add(T.railh)),T.railh&&P.isie8&&(T.autohidedom=T.autohidedom.add(T.cursorh))):"scroll"==M.autohidemode?(T.autohidedom=n().add(T.rail),T.railh&&(T.autohidedom=T.autohidedom.add(T.railh))):"cursor"==M.autohidemode?(T.autohidedom=n().add(T.cursor),T.railh&&(T.autohidedom=T.autohidedom.add(T.cursorh))):"hidden"==M.autohidemode&&(T.autohidedom=!1,T.hide(),T.railslocked=!1),P.cantouch||T.istouchcapable||M.emulatetouch||P.hasmstouch){T.scrollmom=new y(T);T.ontouchstart=function(e){if(T.locked)return!1;if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!1;if(T.hasmoving=!1,T.scrollmom.timer&&(T.triggerScrollEnd(),T.scrollmom.stop()),!T.railslocked){var o=T.getTarget(e);if(o&&/INPUT/i.test(o.nodeName)&&/range/i.test(o.type))return T.stopPropagation(e);var t="mousedown"===e.type;if(!("clientX"in e)&&"changedTouches"in e&&(e.clientX=e.changedTouches[0].clientX,e.clientY=e.changedTouches[0].clientY),T.forcescreen){var r=e;(e={original:e.original?e.original:e}).clientX=r.screenX,e.clientY=r.screenY}if(T.rail.drag={x:e.clientX,y:e.clientY,sx:T.scroll.x,sy:T.scroll.y,st:T.getScrollTop(),sl:T.getScrollLeft(),pt:2,dl:!1,tg:o},T.ispage||!M.directionlockdeadzone)T.rail.drag.dl="f";else{var i={w:c.width(),h:c.height()},s=T.getContentSize(),l=s.h-i.h,a=s.w-i.w;T.rail.scrollable&&!T.railh.scrollable?T.rail.drag.ck=l>0&&"v":!T.rail.scrollable&&T.railh.scrollable?T.rail.drag.ck=a>0&&"h":T.rail.drag.ck=!1}if(M.emulatetouch&&T.isiframe&&P.isie){var d=T.win.position();T.rail.drag.x+=d.left,T.rail.drag.y+=d.top}if(T.hasmoving=!1,T.lastmouseup=!1,T.scrollmom.reset(e.clientX,e.clientY),o&&t){if(!/INPUT|SELECT|BUTTON|TEXTAREA/i.test(o.nodeName))return P.hasmousecapture&&o.setCapture(),M.emulatetouch?(o.onclick&&!o._onclick&&(o._onclick=o.onclick,o.onclick=function(e){if(T.hasmoving)return!1;o._onclick.call(this,e)}),T.cancelEvent(e)):T.stopPropagation(e);/SUBMIT|CANCEL|BUTTON/i.test(n(o).attr("type"))&&(T.preventclick={tg:o,click:!1})}}},T.ontouchend=function(e){if(!T.rail.drag)return!0;if(2==T.rail.drag.pt){if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!1;T.rail.drag=!1;var o="mouseup"===e.type;if(T.hasmoving&&(T.scrollmom.doMomentum(),T.lastmouseup=!0,T.hideCursor(),P.hasmousecapture&&l.releaseCapture(),o))return T.cancelEvent(e)}else if(1==T.rail.drag.pt)return T.onmouseup(e)};var z=M.emulatetouch&&T.isiframe&&!P.hasmousecapture,k=.3*M.directionlockdeadzone|0;T.ontouchmove=function(e,o){if(!T.rail.drag)return!0;if(e.targetTouches&&M.preventmultitouchscrolling&&e.targetTouches.length>1)return!0;if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!0;if(2==T.rail.drag.pt){"changedTouches"in e&&(e.clientX=e.changedTouches[0].clientX,e.clientY=e.changedTouches[0].clientY);var t,r;if(r=t=0,z&&!o){var i=T.win.position();r=-i.left,t=-i.top}var s=e.clientY+t,n=s-T.rail.drag.y,a=e.clientX+r,c=a-T.rail.drag.x,d=T.rail.drag.st-n;if(T.ishwscroll&&M.bouncescroll)d<0?d=Math.round(d/2):d>T.page.maxh&&(d=T.page.maxh+Math.round((d-T.page.maxh)/2));else if(d<0?(d=0,s=0):d>T.page.maxh&&(d=T.page.maxh,s=0),0===s&&!T.hasmoving)return T.ispage||(T.rail.drag=!1),!0;var u=T.getScrollLeft();if(T.railh&&T.railh.scrollable&&(u=T.isrtlmode?c-T.rail.drag.sl:T.rail.drag.sl-c,T.ishwscroll&&M.bouncescroll?u<0?u=Math.round(u/2):u>T.page.maxw&&(u=T.page.maxw+Math.round((u-T.page.maxw)/2)):(u<0&&(u=0,a=0),u>T.page.maxw&&(u=T.page.maxw,a=0))),!T.hasmoving){if(T.rail.drag.y===e.clientY&&T.rail.drag.x===e.clientX)return T.cancelEvent(e);var h=Math.abs(n),p=Math.abs(c),m=M.directionlockdeadzone;if(T.rail.drag.ck?"v"==T.rail.drag.ck?p>m&&h<=k?T.rail.drag=!1:h>m&&(T.rail.drag.dl="v"):"h"==T.rail.drag.ck&&(h>m&&p<=k?T.rail.drag=!1:p>m&&(T.rail.drag.dl="h")):h>m&&p>m?T.rail.drag.dl="f":h>m?T.rail.drag.dl=p>k?"f":"v":p>m&&(T.rail.drag.dl=h>k?"f":"h"),!T.rail.drag.dl)return T.cancelEvent(e);T.triggerScrollStart(e.clientX,e.clientY,0,0,0),T.hasmoving=!0}return T.preventclick&&!T.preventclick.click&&(T.preventclick.click=T.preventclick.tg.onclick||!1,T.preventclick.tg.onclick=T.onpreventclick),T.rail.drag.dl&&("v"==T.rail.drag.dl?u=T.rail.drag.sl:"h"==T.rail.drag.dl&&(d=T.rail.drag.st)),T.synched("touchmove",function(){T.rail.drag&&2==T.rail.drag.pt&&(T.prepareTransition&&T.resetTransition(),T.rail.scrollable&&T.setScrollTop(d),T.scrollmom.update(a,s),T.railh&&T.railh.scrollable?(T.setScrollLeft(u),T.showCursor(d,u)):T.showCursor(d),P.isie10&&l.selection.clear())}),T.cancelEvent(e)}return 1==T.rail.drag.pt?T.onmousemove(e):void 0},T.ontouchstartCursor=function(e,o){if(!T.rail.drag||3==T.rail.drag.pt){if(T.locked)return T.cancelEvent(e);T.cancelScroll(),T.rail.drag={x:e.touches[0].clientX,y:e.touches[0].clientY,sx:T.scroll.x,sy:T.scroll.y,pt:3,hr:!!o};var t=T.getTarget(e);return!T.ispage&&P.hasmousecapture&&t.setCapture(),T.isiframe&&!P.hasmousecapture&&(T.saved.csspointerevents=T.doc.css("pointer-events"),T.css(T.doc,{"pointer-events":"none"})),T.cancelEvent(e)}},T.ontouchendCursor=function(e){if(T.rail.drag){if(P.hasmousecapture&&l.releaseCapture(),T.isiframe&&!P.hasmousecapture&&T.doc.css("pointer-events",T.saved.csspointerevents),3!=T.rail.drag.pt)return;return T.rail.drag=!1,T.cancelEvent(e)}},T.ontouchmoveCursor=function(e){if(T.rail.drag){if(3!=T.rail.drag.pt)return;if(T.cursorfreezed=!0,T.rail.drag.hr){T.scroll.x=T.rail.drag.sx+(e.touches[0].clientX-T.rail.drag.x),T.scroll.x<0&&(T.scroll.x=0);var o=T.scrollvaluemaxw;T.scroll.x>o&&(T.scroll.x=o)}else{T.scroll.y=T.rail.drag.sy+(e.touches[0].clientY-T.rail.drag.y),T.scroll.y<0&&(T.scroll.y=0);var t=T.scrollvaluemax;T.scroll.y>t&&(T.scroll.y=t)}return T.synched("touchmove",function(){T.rail.drag&&3==T.rail.drag.pt&&(T.showCursor(),T.rail.drag.hr?T.doScrollLeft(Math.round(T.scroll.x*T.scrollratio.x),M.cursordragspeed):T.doScrollTop(Math.round(T.scroll.y*T.scrollratio.y),M.cursordragspeed))}),T.cancelEvent(e)}}}if(T.onmousedown=function(e,o){if(!T.rail.drag||1==T.rail.drag.pt){if(T.railslocked)return T.cancelEvent(e);T.cancelScroll(),T.rail.drag={x:e.clientX,y:e.clientY,sx:T.scroll.x,sy:T.scroll.y,pt:1,hr:o||!1};var t=T.getTarget(e);return P.hasmousecapture&&t.setCapture(),T.isiframe&&!P.hasmousecapture&&(T.saved.csspointerevents=T.doc.css("pointer-events"),T.css(T.doc,{"pointer-events":"none"})),T.hasmoving=!1,T.cancelEvent(e)}},T.onmouseup=function(e){if(T.rail.drag)return 1!=T.rail.drag.pt||(P.hasmousecapture&&l.releaseCapture(),T.isiframe&&!P.hasmousecapture&&T.doc.css("pointer-events",T.saved.csspointerevents),T.rail.drag=!1,T.cursorfreezed=!1,T.hasmoving&&T.triggerScrollEnd(),T.cancelEvent(e))},T.onmousemove=function(e){if(T.rail.drag){if(1!==T.rail.drag.pt)return;if(P.ischrome&&0===e.which)return T.onmouseup(e);if(T.cursorfreezed=!0,T.hasmoving||T.triggerScrollStart(e.clientX,e.clientY,0,0,0),T.hasmoving=!0,T.rail.drag.hr){T.scroll.x=T.rail.drag.sx+(e.clientX-T.rail.drag.x),T.scroll.x<0&&(T.scroll.x=0);var o=T.scrollvaluemaxw;T.scroll.x>o&&(T.scroll.x=o)}else{T.scroll.y=T.rail.drag.sy+(e.clientY-T.rail.drag.y),T.scroll.y<0&&(T.scroll.y=0);var t=T.scrollvaluemax;T.scroll.y>t&&(T.scroll.y=t)}return T.synched("mousemove",function(){T.cursorfreezed&&(T.showCursor(),T.rail.drag.hr?T.scrollLeft(Math.round(T.scroll.x*T.scrollratio.x)):T.scrollTop(Math.round(T.scroll.y*T.scrollratio.y)))}),T.cancelEvent(e)}T.checkarea=0},P.cantouch||M.emulatetouch)T.onpreventclick=function(e){if(T.preventclick)return T.preventclick.tg.onclick=T.preventclick.click,T.preventclick=!1,T.cancelEvent(e)},T.onclick=!P.isios&&function(e){return!T.lastmouseup||(T.lastmouseup=!1,T.cancelEvent(e))},M.grabcursorenabled&&P.cursorgrabvalue&&(T.css(T.ispage?T.doc:T.win,{cursor:P.cursorgrabvalue}),T.css(T.rail,{cursor:P.cursorgrabvalue}));else{var L=function(e){if(T.selectiondrag){if(e){var o=T.win.outerHeight(),t=e.pageY-T.selectiondrag.top;t>0&&t<o&&(t=0),t>=o&&(t-=o),T.selectiondrag.df=t}if(0!==T.selectiondrag.df){var r=-2*T.selectiondrag.df/6|0;T.doScrollBy(r),T.debounced("doselectionscroll",function(){L()},50)}}};T.hasTextSelected="getSelection"in l?function(){return l.getSelection().rangeCount>0}:"selection"in l?function(){return"None"!=l.selection.type}:function(){return!1},T.onselectionstart=function(e){T.ispage||(T.selectiondrag=T.win.offset())},T.onselectionend=function(e){T.selectiondrag=!1},T.onselectiondrag=function(e){T.selectiondrag&&T.hasTextSelected()&&T.debounced("selectionscroll",function(){L(e)},250)}}if(P.hasw3ctouch?(T.css(T.ispage?n("html"):T.win,{"touch-action":"none"}),T.css(T.rail,{"touch-action":"none"}),T.css(T.cursor,{"touch-action":"none"}),T.bind(T.win,"pointerdown",T.ontouchstart),T.bind(l,"pointerup",T.ontouchend),T.delegate(l,"pointermove",T.ontouchmove)):P.hasmstouch?(T.css(T.ispage?n("html"):T.win,{"-ms-touch-action":"none"}),T.css(T.rail,{"-ms-touch-action":"none"}),T.css(T.cursor,{"-ms-touch-action":"none"}),T.bind(T.win,"MSPointerDown",T.ontouchstart),T.bind(l,"MSPointerUp",T.ontouchend),T.delegate(l,"MSPointerMove",T.ontouchmove),T.bind(T.cursor,"MSGestureHold",function(e){e.preventDefault()}),T.bind(T.cursor,"contextmenu",function(e){e.preventDefault()})):P.cantouch&&(T.bind(T.win,"touchstart",T.ontouchstart,!1,!0),T.bind(l,"touchend",T.ontouchend,!1,!0),T.bind(l,"touchcancel",T.ontouchend,!1,!0),T.delegate(l,"touchmove",T.ontouchmove,!1,!0)),M.emulatetouch&&(T.bind(T.win,"mousedown",T.ontouchstart,!1,!0),T.bind(l,"mouseup",T.ontouchend,!1,!0),T.bind(l,"mousemove",T.ontouchmove,!1,!0)),(M.cursordragontouch||!P.cantouch&&!M.emulatetouch)&&(T.rail.css({cursor:"default"}),T.railh&&T.railh.css({cursor:"default"}),T.jqbind(T.rail,"mouseenter",function(){if(!T.ispage&&!T.win.is(":visible"))return!1;T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.rail,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}),M.sensitiverail&&(T.bind(T.rail,"click",function(e){T.doRailClick(e,!1,!1)}),T.bind(T.rail,"dblclick",function(e){T.doRailClick(e,!0,!1)}),T.bind(T.cursor,"click",function(e){T.cancelEvent(e)}),T.bind(T.cursor,"dblclick",function(e){T.cancelEvent(e)})),T.railh&&(T.jqbind(T.railh,"mouseenter",function(){if(!T.ispage&&!T.win.is(":visible"))return!1;T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.railh,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}),M.sensitiverail&&(T.bind(T.railh,"click",function(e){T.doRailClick(e,!1,!0)}),T.bind(T.railh,"dblclick",function(e){T.doRailClick(e,!0,!0)}),T.bind(T.cursorh,"click",function(e){T.cancelEvent(e)}),T.bind(T.cursorh,"dblclick",function(e){T.cancelEvent(e)})))),M.cursordragontouch&&(this.istouchcapable||P.cantouch)&&(T.bind(T.cursor,"touchstart",T.ontouchstartCursor),T.bind(T.cursor,"touchmove",T.ontouchmoveCursor),T.bind(T.cursor,"touchend",T.ontouchendCursor),T.cursorh&&T.bind(T.cursorh,"touchstart",function(e){T.ontouchstartCursor(e,!0)}),T.cursorh&&T.bind(T.cursorh,"touchmove",T.ontouchmoveCursor),T.cursorh&&T.bind(T.cursorh,"touchend",T.ontouchendCursor)),M.emulatetouch||P.isandroid||P.isios?(T.bind(P.hasmousecapture?T.win:l,"mouseup",T.ontouchend),T.onclick&&T.bind(l,"click",T.onclick),M.cursordragontouch?(T.bind(T.cursor,"mousedown",T.onmousedown),T.bind(T.cursor,"mouseup",T.onmouseup),T.cursorh&&T.bind(T.cursorh,"mousedown",function(e){T.onmousedown(e,!0)}),T.cursorh&&T.bind(T.cursorh,"mouseup",T.onmouseup)):(T.bind(T.rail,"mousedown",function(e){e.preventDefault()}),T.railh&&T.bind(T.railh,"mousedown",function(e){e.preventDefault()}))):(T.bind(P.hasmousecapture?T.win:l,"mouseup",T.onmouseup),T.bind(l,"mousemove",T.onmousemove),T.onclick&&T.bind(l,"click",T.onclick),T.bind(T.cursor,"mousedown",T.onmousedown),T.bind(T.cursor,"mouseup",T.onmouseup),T.railh&&(T.bind(T.cursorh,"mousedown",function(e){T.onmousedown(e,!0)}),T.bind(T.cursorh,"mouseup",T.onmouseup)),!T.ispage&&M.enablescrollonselection&&(T.bind(T.win[0],"mousedown",T.onselectionstart),T.bind(l,"mouseup",T.onselectionend),T.bind(T.cursor,"mouseup",T.onselectionend),T.cursorh&&T.bind(T.cursorh,"mouseup",T.onselectionend),T.bind(l,"mousemove",T.onselectiondrag)),T.zoom&&(T.jqbind(T.zoom,"mouseenter",function(){T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.zoom,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}))),M.enablemousewheel&&(T.isiframe||T.mousewheel(P.isie&&T.ispage?l:T.win,T.onmousewheel),T.mousewheel(T.rail,T.onmousewheel),T.railh&&T.mousewheel(T.railh,T.onmousewheelhr)),T.ispage||P.cantouch||/HTML|^BODY/.test(T.win[0].nodeName)||(T.win.attr("tabindex")||T.win.attr({tabindex:++r}),T.bind(T.win,"focus",function(e){o=T.getTarget(e).id||T.getTarget(e)||!1,T.hasfocus=!0,T.canshowonmouseevent&&T.noticeCursor()}),T.bind(T.win,"blur",function(e){o=!1,T.hasfocus=!1}),T.bind(T.win,"mouseenter",function(e){t=T.getTarget(e).id||T.getTarget(e)||!1,T.hasmousefocus=!0,T.canshowonmouseevent&&T.noticeCursor()}),T.bind(T.win,"mouseleave",function(e){t=!1,T.hasmousefocus=!1,T.rail.drag||T.hideCursor()})),T.onkeypress=function(e){if(T.railslocked&&0===T.page.maxh)return!0;e=e||a.event;var r=T.getTarget(e);if(r&&/INPUT|TEXTAREA|SELECT|OPTION/.test(r.nodeName)&&(!(r.getAttribute("type")||r.type||!1)||!/submit|button|cancel/i.tp))return!0;if(n(r).attr("contenteditable"))return!0;if(T.hasfocus||T.hasmousefocus&&!o||T.ispage&&!o&&!t){var i=e.keyCode;if(T.railslocked&&27!=i)return T.cancelEvent(e);var s=e.ctrlKey||!1,l=e.shiftKey||!1,c=!1;switch(i){case 38:case 63233:T.doScrollBy(72),c=!0;break;case 40:case 63235:T.doScrollBy(-72),c=!0;break;case 37:case 63232:T.railh&&(s?T.doScrollLeft(0):T.doScrollLeftBy(72),c=!0);break;case 39:case 63234:T.railh&&(s?T.doScrollLeft(T.page.maxw):T.doScrollLeftBy(-72),c=!0);break;case 33:case 63276:T.doScrollBy(T.view.h),c=!0;break;case 34:case 63277:T.doScrollBy(-T.view.h),c=!0;break;case 36:case 63273:T.railh&&s?T.doScrollPos(0,0):T.doScrollTo(0),c=!0;break;case 35:case 63275:T.railh&&s?T.doScrollPos(T.page.maxw,T.page.maxh):T.doScrollTo(T.page.maxh),c=!0;break;case 32:M.spacebarenabled&&(l?T.doScrollBy(T.view.h):T.doScrollBy(-T.view.h),c=!0);break;case 27:T.zoomactive&&(T.doZoom(),c=!0)}if(c)return T.cancelEvent(e)}},M.enablekeyboard&&T.bind(l,P.isopera&&!P.isopera12?"keypress":"keydown",T.onkeypress),T.bind(l,"keydown",function(e){(e.ctrlKey||!1)&&(T.wheelprevented=!0)}),T.bind(l,"keyup",function(e){e.ctrlKey||!1||(T.wheelprevented=!1)}),T.bind(a,"blur",function(e){T.wheelprevented=!1}),T.bind(a,"resize",T.onscreenresize),T.bind(a,"orientationchange",T.onscreenresize),T.bind(a,"load",T.lazyResize),P.ischrome&&!T.ispage&&!T.haswrapper){var C=T.win.attr("style"),N=parseFloat(T.win.css("width"))+1;T.win.css("width",N),T.synched("chromefix",function(){T.win.attr("style",C)})}if(T.onAttributeChange=function(e){T.lazyResize(T.isieold?250:30)},M.enableobserver&&(T.isie11||!1===m||(T.observerbody=new m(function(e){if(e.forEach(function(e){if("attributes"==e.type)return E.hasClass("modal-open")&&E.hasClass("modal-dialog")&&!n.contains(n(".modal-dialog")[0],T.doc[0])?T.hide():T.show()}),T.me.clientWidth!=T.page.width||T.me.clientHeight!=T.page.height)return T.lazyResize(30)}),T.observerbody.observe(l.body,{childList:!0,subtree:!0,characterData:!1,attributes:!0,attributeFilter:["class"]})),!T.ispage&&!T.haswrapper)){var R=T.win[0];!1!==m?(T.observer=new m(function(e){e.forEach(T.onAttributeChange)}),T.observer.observe(R,{childList:!0,characterData:!1,attributes:!0,subtree:!1}),T.observerremover=new m(function(e){e.forEach(function(e){if(e.removedNodes.length>0)for(var o in e.removedNodes)if(T&&e.removedNodes[o]===R)return T.remove()})}),T.observerremover.observe(R.parentNode,{childList:!0,characterData:!1,attributes:!1,subtree:!1})):(T.bind(R,P.isie&&!P.isie9?"propertychange":"DOMAttrModified",T.onAttributeChange),P.isie9&&R.attachEvent("onpropertychange",T.onAttributeChange),T.bind(R,"DOMNodeRemoved",function(e){e.target===R&&T.remove()}))}!T.ispage&&M.boxzoom&&T.bind(a,"resize",T.resizeZoom),T.istextarea&&(T.bind(T.win,"keydown",T.lazyResize),T.bind(T.win,"mouseup",T.lazyResize)),T.lazyResize(30)}if("IFRAME"==this.doc[0].nodeName){var _=function(){T.iframexd=!1;var o;try{(o="contentDocument"in this?this.contentDocument:this.contentWindow._doc).domain}catch(e){T.iframexd=!0,o=!1}if(T.iframexd)return"console"in a&&console.log("NiceScroll error: policy restriced iframe"),!0;if(T.forcescreen=!0,T.isiframe&&(T.iframe={doc:n(o),html:T.doc.contents().find("html")[0],body:T.doc.contents().find("body")[0]},T.getContentSize=function(){return{w:Math.max(T.iframe.html.scrollWidth,T.iframe.body.scrollWidth),h:Math.max(T.iframe.html.scrollHeight,T.iframe.body.scrollHeight)}},T.docscroll=n(T.iframe.body)),!P.isios&&M.iframeautoresize&&!T.isiframe){T.win.scrollTop(0),T.doc.height("");var t=Math.max(o.getElementsByTagName("html")[0].scrollHeight,o.body.scrollHeight);T.doc.height(t)}T.lazyResize(30),T.css(n(T.iframe.body),e),P.isios&&T.haswrapper&&T.css(n(o.body),{"-webkit-transform":"translate3d(0,0,0)"}),"contentWindow"in this?T.bind(this.contentWindow,"scroll",T.onscroll):T.bind(o,"scroll",T.onscroll),M.enablemousewheel&&T.mousewheel(o,T.onmousewheel),M.enablekeyboard&&T.bind(o,P.isopera?"keypress":"keydown",T.onkeypress),P.cantouch?(T.bind(o,"touchstart",T.ontouchstart),T.bind(o,"touchmove",T.ontouchmove)):M.emulatetouch&&(T.bind(o,"mousedown",T.ontouchstart),T.bind(o,"mousemove",function(e){return T.ontouchmove(e,!0)}),M.grabcursorenabled&&P.cursorgrabvalue&&T.css(n(o.body),{cursor:P.cursorgrabvalue})),T.bind(o,"mouseup",T.ontouchend),T.zoom&&(M.dblclickzoom&&T.bind(o,"dblclick",T.doZoom),T.ongesturezoom&&T.bind(o,"gestureend",T.ongesturezoom))};this.doc[0].readyState&&"complete"===this.doc[0].readyState&&setTimeout(function(){_.call(T.doc[0],!1)},500),T.bind(this.doc,"load",_)}},this.showCursor=function(e,o){if(T.cursortimeout&&(clearTimeout(T.cursortimeout),T.cursortimeout=0),T.rail){if(T.autohidedom&&(T.autohidedom.stop().css({opacity:M.cursoropacitymax}),T.cursoractive=!0),T.rail.drag&&1==T.rail.drag.pt||(void 0!==e&&!1!==e&&(T.scroll.y=e/T.scrollratio.y|0),void 0!==o&&(T.scroll.x=o/T.scrollratio.x|0)),T.cursor.css({height:T.cursorheight,top:T.scroll.y}),T.cursorh){var t=T.hasreversehr?T.scrollvaluemaxw-T.scroll.x:T.scroll.x;T.cursorh.css({width:T.cursorwidth,left:!T.rail.align&&T.rail.visibility?t+T.rail.width:t}),T.cursoractive=!0}T.zoom&&T.zoom.stop().css({opacity:M.cursoropacitymax})}},this.hideCursor=function(e){T.cursortimeout||T.rail&&T.autohidedom&&(T.hasmousefocus&&"leave"===M.autohidemode||(T.cursortimeout=setTimeout(function(){T.rail.active&&T.showonmouseevent||(T.autohidedom.stop().animate({opacity:M.cursoropacitymin}),T.zoom&&T.zoom.stop().animate({opacity:M.cursoropacitymin}),T.cursoractive=!1),T.cursortimeout=0},e||M.hidecursordelay)))},this.noticeCursor=function(e,o,t){T.showCursor(o,t),T.rail.active||T.hideCursor(e)},this.getContentSize=T.ispage?function(){return{w:Math.max(l.body.scrollWidth,l.documentElement.scrollWidth),h:Math.max(l.body.scrollHeight,l.documentElement.scrollHeight)}}:T.haswrapper?function(){return{w:T.doc[0].offsetWidth,h:T.doc[0].offsetHeight}}:function(){return{w:T.docscroll[0].scrollWidth,h:T.docscroll[0].scrollHeight}},this.onResize=function(e,o){if(!T||!T.win)return!1;var t=T.page.maxh,r=T.page.maxw,i=T.view.h,s=T.view.w;if(T.view={w:T.ispage?T.win.width():T.win[0].clientWidth,h:T.ispage?T.win.height():T.win[0].clientHeight},T.page=o||T.getContentSize(),T.page.maxh=Math.max(0,T.page.h-T.view.h),T.page.maxw=Math.max(0,T.page.w-T.view.w),T.page.maxh==t&&T.page.maxw==r&&T.view.w==s&&T.view.h==i){if(T.ispage)return T;var n=T.win.offset();if(T.lastposition){var l=T.lastposition;if(l.top==n.top&&l.left==n.left)return T}T.lastposition=n}return 0===T.page.maxh?(T.hideRail(),T.scrollvaluemax=0,T.scroll.y=0,T.scrollratio.y=0,T.cursorheight=0,T.setScrollTop(0),T.rail&&(T.rail.scrollable=!1)):(T.page.maxh-=M.railpadding.top+M.railpadding.bottom,T.rail.scrollable=!0),0===T.page.maxw?(T.hideRailHr(),T.scrollvaluemaxw=0,T.scroll.x=0,T.scrollratio.x=0,T.cursorwidth=0,T.setScrollLeft(0),T.railh&&(T.railh.scrollable=!1)):(T.page.maxw-=M.railpadding.left+M.railpadding.right,T.railh&&(T.railh.scrollable=M.horizrailenabled)),T.railslocked=T.locked||0===T.page.maxh&&0===T.page.maxw,T.railslocked?(T.ispage||T.updateScrollBar(T.view),!1):(T.hidden||(T.rail.visibility||T.showRail(),T.railh&&!T.railh.visibility&&T.showRailHr()),T.istextarea&&T.win.css("resize")&&"none"!=T.win.css("resize")&&(T.view.h-=20),T.cursorheight=Math.min(T.view.h,Math.round(T.view.h*(T.view.h/T.page.h))),T.cursorheight=M.cursorfixedheight?M.cursorfixedheight:Math.max(M.cursorminheight,T.cursorheight),T.cursorwidth=Math.min(T.view.w,Math.round(T.view.w*(T.view.w/T.page.w))),T.cursorwidth=M.cursorfixedheight?M.cursorfixedheight:Math.max(M.cursorminheight,T.cursorwidth),T.scrollvaluemax=T.view.h-T.cursorheight-(M.railpadding.top+M.railpadding.bottom),T.hasborderbox||(T.scrollvaluemax-=T.cursor[0].offsetHeight-T.cursor[0].clientHeight),T.railh&&(T.railh.width=T.page.maxh>0?T.view.w-T.rail.width:T.view.w,T.scrollvaluemaxw=T.railh.width-T.cursorwidth-(M.railpadding.left+M.railpadding.right)),T.ispage||T.updateScrollBar(T.view),T.scrollratio={x:T.page.maxw/T.scrollvaluemaxw,y:T.page.maxh/T.scrollvaluemax},T.getScrollTop()>T.page.maxh?T.doScrollTop(T.page.maxh):(T.scroll.y=T.getScrollTop()/T.scrollratio.y|0,T.scroll.x=T.getScrollLeft()/T.scrollratio.x|0,T.cursoractive&&T.noticeCursor()),T.scroll.y&&0===T.getScrollTop()&&T.doScrollTo(T.scroll.y*T.scrollratio.y|0),T)},this.resize=T.onResize;var O=0;this.onscreenresize=function(e){clearTimeout(O);var o=!T.ispage&&!T.haswrapper;o&&T.hideRails(),O=setTimeout(function(){T&&(o&&T.showRails(),T.resize()),O=0},120)},this.lazyResize=function(e){return clearTimeout(O),e=isNaN(e)?240:e,O=setTimeout(function(){T&&T.resize(),O=0},e),T},this.jqbind=function(e,o,t){T.events.push({e:e,n:o,f:t,q:!0}),n(e).on(o,t)},this.mousewheel=function(e,o,t){var r="jquery"in e?e[0]:e;if("onwheel"in l.createElement("div"))T._bind(r,"wheel",o,t||!1);else{var i=void 0!==l.onmousewheel?"mousewheel":"DOMMouseScroll";S(r,i,o,t||!1),"DOMMouseScroll"==i&&S(r,"MozMousePixelScroll",o,t||!1)}};var Y=!1;if(P.haseventlistener){try{var H=Object.defineProperty({},"passive",{get:function(){Y=!0}});a.addEventListener("test",null,H)}catch(e){}this.stopPropagation=function(e){return!!e&&((e=e.original?e.original:e).stopPropagation(),!1)},this.cancelEvent=function(e){return e.cancelable&&e.preventDefault(),e.stopImmediatePropagation(),e.preventManipulation&&e.preventManipulation(),!1}}else Event.prototype.preventDefault=function(){this.returnValue=!1},Event.prototype.stopPropagation=function(){this.cancelBubble=!0},a.constructor.prototype.addEventListener=l.constructor.prototype.addEventListener=Element.prototype.addEventListener=function(e,o,t){this.attachEvent("on"+e,o)},a.constructor.prototype.removeEventListener=l.constructor.prototype.removeEventListener=Element.prototype.removeEventListener=function(e,o,t){this.detachEvent("on"+e,o)},this.cancelEvent=function(e){return(e=e||a.event)&&(e.cancelBubble=!0,e.cancel=!0,e.returnValue=!1),!1},this.stopPropagation=function(e){return(e=e||a.event)&&(e.cancelBubble=!0),!1};this.delegate=function(e,o,t,r,i){var s=d[o]||!1;s||(s={a:[],l:[],f:function(e){for(var o=s.l,t=!1,r=o.length-1;r>=0;r--)if(!1===(t=o[r].call(e.target,e)))return!1;return t}},T.bind(e,o,s.f,r,i),d[o]=s),T.ispage?(s.a=[T.id].concat(s.a),s.l=[t].concat(s.l)):(s.a.push(T.id),s.l.push(t))},this.undelegate=function(e,o,t,r,i){var s=d[o]||!1;if(s&&s.l)for(var n=0,l=s.l.length;n<l;n++)s.a[n]===T.id&&(s.a.splice(n),s.l.splice(n),0===s.a.length&&(T._unbind(e,o,s.l.f),d[o]=null))},this.bind=function(e,o,t,r,i){var s="jquery"in e?e[0]:e;T._bind(s,o,t,r||!1,i||!1)},this._bind=function(e,o,t,r,i){T.events.push({e:e,n:o,f:t,b:r,q:!1}),Y&&i?e.addEventListener(o,t,{passive:!1,capture:r}):e.addEventListener(o,t,r||!1)},this._unbind=function(e,o,t,r){d[o]?T.undelegate(e,o,t,r):e.removeEventListener(o,t,r)},this.unbindAll=function(){for(var e=0;e<T.events.length;e++){var o=T.events[e];o.q?o.e.unbind(o.n,o.f):T._unbind(o.e,o.n,o.f,o.b)}},this.showRails=function(){return T.showRail().showRailHr()},this.showRail=function(){return 0===T.page.maxh||!T.ispage&&"none"==T.win.css("display")||(T.rail.visibility=!0,T.rail.css("display","block")),T},this.showRailHr=function(){return T.railh&&(0===T.page.maxw||!T.ispage&&"none"==T.win.css("display")||(T.railh.visibility=!0,T.railh.css("display","block"))),T},this.hideRails=function(){return T.hideRail().hideRailHr()},this.hideRail=function(){return T.rail.visibility=!1,T.rail.css("display","none"),T},this.hideRailHr=function(){return T.railh&&(T.railh.visibility=!1,T.railh.css("display","none")),T},this.show=function(){return T.hidden=!1,T.railslocked=!1,T.showRails()},this.hide=function(){return T.hidden=!0,T.railslocked=!0,T.hideRails()},this.toggle=function(){return T.hidden?T.show():T.hide()},this.remove=function(){T.stop(),T.cursortimeout&&clearTimeout(T.cursortimeout);for(var e in T.delaylist)T.delaylist[e]&&h(T.delaylist[e].h);T.doZoomOut(),T.unbindAll(),P.isie9&&T.win[0].detachEvent("onpropertychange",T.onAttributeChange),!1!==T.observer&&T.observer.disconnect(),!1!==T.observerremover&&T.observerremover.disconnect(),!1!==T.observerbody&&T.observerbody.disconnect(),T.events=null,T.cursor&&T.cursor.remove(),T.cursorh&&T.cursorh.remove(),T.rail&&T.rail.remove(),T.railh&&T.railh.remove(),T.zoom&&T.zoom.remove();for(var o=0;o<T.saved.css.length;o++){var t=T.saved.css[o];t[0].css(t[1],void 0===t[2]?"":t[2])}T.saved=!1,T.me.data("__nicescroll","");var r=n.nicescroll;r.each(function(e){if(this&&this.id===T.id){delete r[e];for(var o=++e;o<r.length;o++,e++)r[e]=r[o];--r.length&&delete r[r.length]}});for(var i in T)T[i]=null,delete T[i];T=null},this.scrollstart=function(e){return this.onscrollstart=e,T},this.scrollend=function(e){return this.onscrollend=e,T},this.scrollcancel=function(e){return this.onscrollcancel=e,T},this.zoomin=function(e){return this.onzoomin=e,T},this.zoomout=function(e){return this.onzoomout=e,T},this.isScrollable=function(e){var o=e.target?e.target:e;if("OPTION"==o.nodeName)return!0;for(;o&&1==o.nodeType&&o!==this.me[0]&&!/^BODY|HTML/.test(o.nodeName);){var t=n(o),r=t.css("overflowY")||t.css("overflowX")||t.css("overflow")||"";if(/scroll|auto/.test(r))return o.clientHeight!=o.scrollHeight;o=!!o.parentNode&&o.parentNode}return!1},this.getViewport=function(e){for(var o=!(!e||!e.parentNode)&&e.parentNode;o&&1==o.nodeType&&!/^BODY|HTML/.test(o.nodeName);){var t=n(o);if(/fixed|absolute/.test(t.css("position")))return t;var r=t.css("overflowY")||t.css("overflowX")||t.css("overflow")||"";if(/scroll|auto/.test(r)&&o.clientHeight!=o.scrollHeight)return t;if(t.getNiceScroll().length>0)return t;o=!!o.parentNode&&o.parentNode}return!1},this.triggerScrollStart=function(e,o,t,r,i){if(T.onscrollstart){var s={type:"scrollstart",current:{x:e,y:o},request:{x:t,y:r},end:{x:T.newscrollx,y:T.newscrolly},speed:i};T.onscrollstart.call(T,s)}},this.triggerScrollEnd=function(){if(T.onscrollend){var e=T.getScrollLeft(),o=T.getScrollTop(),t={type:"scrollend",current:{x:e,y:o},end:{x:e,y:o}};T.onscrollend.call(T,t)}};var B=0,X=0,D=0,A=1,q=!1;if(this.onmousewheel=function(e){if(T.wheelprevented||T.locked)return!1;if(T.railslocked)return T.debounced("checkunlock",T.resize,250),!1;if(T.rail.drag)return T.cancelEvent(e);if("auto"===M.oneaxismousemode&&0!==e.deltaX&&(M.oneaxismousemode=!1),M.oneaxismousemode&&0===e.deltaX&&!T.rail.scrollable)return!T.railh||!T.railh.scrollable||T.onmousewheelhr(e);var o=f(),t=!1;if(M.preservenativescrolling&&T.checkarea+600<o&&(T.nativescrollingarea=T.isScrollable(e),t=!0),T.checkarea=o,T.nativescrollingarea)return!0;var r=k(e,!1,t);return r&&(T.checkarea=0),r},this.onmousewheelhr=function(e){if(!T.wheelprevented){if(T.railslocked||!T.railh.scrollable)return!0;if(T.rail.drag)return T.cancelEvent(e);var o=f(),t=!1;return M.preservenativescrolling&&T.checkarea+600<o&&(T.nativescrollingarea=T.isScrollable(e),t=!0),T.checkarea=o,!!T.nativescrollingarea||(T.railslocked?T.cancelEvent(e):k(e,!0,t))}},this.stop=function(){return T.cancelScroll(),T.scrollmon&&T.scrollmon.stop(),T.cursorfreezed=!1,T.scroll.y=Math.round(T.getScrollTop()*(1/T.scrollratio.y)),T.noticeCursor(),T},this.getTransitionSpeed=function(e){return 80+e/72*M.scrollspeed|0},M.smoothscroll)if(T.ishwscroll&&P.hastransition&&M.usetransition&&M.smoothscroll){var j="";this.resetTransition=function(){j="",T.doc.css(P.prefixstyle+"transition-duration","0ms")},this.prepareTransition=function(e,o){var t=o?e:T.getTransitionSpeed(e),r=t+"ms";return j!==r&&(j=r,T.doc.css(P.prefixstyle+"transition-duration",r)),t},this.doScrollLeft=function(e,o){var t=T.scrollrunning?T.newscrolly:T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.scrollrunning?T.newscrollx:T.getScrollLeft();T.doScrollPos(t,e,o)},this.cursorupdate={running:!1,start:function(){var e=this;if(!e.running){e.running=!0;var o=function(){e.running&&u(o),T.showCursor(T.getScrollTop(),T.getScrollLeft()),T.notifyScrollEvent(T.win[0])};u(o)}},stop:function(){this.running=!1}},this.doScrollPos=function(e,o,t){var r=T.getScrollTop(),i=T.getScrollLeft();if(((T.newscrolly-r)*(o-r)<0||(T.newscrollx-i)*(e-i)<0)&&T.cancelScroll(),M.bouncescroll?(o<0?o=o/2|0:o>T.page.maxh&&(o=T.page.maxh+(o-T.page.maxh)/2|0),e<0?e=e/2|0:e>T.page.maxw&&(e=T.page.maxw+(e-T.page.maxw)/2|0)):(o<0?o=0:o>T.page.maxh&&(o=T.page.maxh),e<0?e=0:e>T.page.maxw&&(e=T.page.maxw)),T.scrollrunning&&e==T.newscrollx&&o==T.newscrolly)return!1;T.newscrolly=o,T.newscrollx=e;var s=T.getScrollTop(),n=T.getScrollLeft(),l={};l.x=e-n,l.y=o-s;var a=0|Math.sqrt(l.x*l.x+l.y*l.y),c=T.prepareTransition(a);T.scrollrunning||(T.scrollrunning=!0,T.triggerScrollStart(n,s,e,o,c),T.cursorupdate.start()),T.scrollendtrapped=!0,P.transitionend||(T.scrollendtrapped&&clearTimeout(T.scrollendtrapped),T.scrollendtrapped=setTimeout(T.onScrollTransitionEnd,c)),T.setScrollTop(T.newscrolly),T.setScrollLeft(T.newscrollx)},this.cancelScroll=function(){if(!T.scrollendtrapped)return!0;var e=T.getScrollTop(),o=T.getScrollLeft();return T.scrollrunning=!1,P.transitionend||clearTimeout(P.transitionend),T.scrollendtrapped=!1,T.resetTransition(),T.setScrollTop(e),T.railh&&T.setScrollLeft(o),T.timerscroll&&T.timerscroll.tm&&clearInterval(T.timerscroll.tm),T.timerscroll=!1,T.cursorfreezed=!1,T.cursorupdate.stop(),T.showCursor(e,o),T},this.onScrollTransitionEnd=function(){if(T.scrollendtrapped){var e=T.getScrollTop(),o=T.getScrollLeft();if(e<0?e=0:e>T.page.maxh&&(e=T.page.maxh),o<0?o=0:o>T.page.maxw&&(o=T.page.maxw),e!=T.newscrolly||o!=T.newscrollx)return T.doScrollPos(o,e,M.snapbackspeed);T.scrollrunning&&T.triggerScrollEnd(),T.scrollrunning=!1,T.scrollendtrapped=!1,T.resetTransition(),T.timerscroll=!1,T.setScrollTop(e),T.railh&&T.setScrollLeft(o),T.cursorupdate.stop(),T.noticeCursor(!1,e,o),T.cursorfreezed=!1}}}else this.doScrollLeft=function(e,o){var t=T.scrollrunning?T.newscrolly:T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.scrollrunning?T.newscrollx:T.getScrollLeft();T.doScrollPos(t,e,o)},this.doScrollPos=function(e,o,t){var r=T.getScrollTop(),i=T.getScrollLeft();((T.newscrolly-r)*(o-r)<0||(T.newscrollx-i)*(e-i)<0)&&T.cancelScroll();var s=!1;if(T.bouncescroll&&T.rail.visibility||(o<0?(o=0,s=!0):o>T.page.maxh&&(o=T.page.maxh,s=!0)),T.bouncescroll&&T.railh.visibility||(e<0?(e=0,s=!0):e>T.page.maxw&&(e=T.page.maxw,s=!0)),T.scrollrunning&&T.newscrolly===o&&T.newscrollx===e)return!0;T.newscrolly=o,T.newscrollx=e,T.dst={},T.dst.x=e-i,T.dst.y=o-r,T.dst.px=i,T.dst.py=r;var n=0|Math.sqrt(T.dst.x*T.dst.x+T.dst.y*T.dst.y),l=T.getTransitionSpeed(n);T.bzscroll={};var a=s?1:.58;T.bzscroll.x=new R(i,T.newscrollx,l,0,0,a,1),T.bzscroll.y=new R(r,T.newscrolly,l,0,0,a,1);f();var c=function(){if(T.scrollrunning){var e=T.bzscroll.y.getPos();T.setScrollLeft(T.bzscroll.x.getNow()),T.setScrollTop(T.bzscroll.y.getNow()),e<=1?T.timer=u(c):(T.scrollrunning=!1,T.timer=0,T.triggerScrollEnd())}};T.scrollrunning||(T.triggerScrollStart(i,r,e,o,l),T.scrollrunning=!0,T.timer=u(c))},this.cancelScroll=function(){return T.timer&&h(T.timer),T.timer=0,T.bzscroll=!1,T.scrollrunning=!1,T};else this.doScrollLeft=function(e,o){var t=T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.getScrollLeft();T.doScrollPos(t,e,o)},this.doScrollPos=function(e,o,t){var r=e>T.page.maxw?T.page.maxw:e;r<0&&(r=0);var i=o>T.page.maxh?T.page.maxh:o;i<0&&(i=0),T.synched("scroll",function(){T.setScrollTop(i),T.setScrollLeft(r)})},this.cancelScroll=function(){};this.doScrollBy=function(e,o){z(0,e)},this.doScrollLeftBy=function(e,o){z(e,0)},this.doScrollTo=function(e,o){var t=o?Math.round(e*T.scrollratio.y):e;t<0?t=0:t>T.page.maxh&&(t=T.page.maxh),T.cursorfreezed=!1,T.doScrollTop(e)},this.checkContentSize=function(){var e=T.getContentSize();e.h==T.page.h&&e.w==T.page.w||T.resize(!1,e)},T.onscroll=function(e){T.rail.drag||T.cursorfreezed||T.synched("scroll",function(){T.scroll.y=Math.round(T.getScrollTop()/T.scrollratio.y),T.railh&&(T.scroll.x=Math.round(T.getScrollLeft()/T.scrollratio.x)),T.noticeCursor()})},T.bind(T.docscroll,"scroll",T.onscroll),this.doZoomIn=function(e){if(!T.zoomactive){T.zoomactive=!0,T.zoomrestore={style:{}};var o=["position","top","left","zIndex","backgroundColor","marginTop","marginBottom","marginLeft","marginRight"],t=T.win[0].style;for(var r in o){var i=o[r];T.zoomrestore.style[i]=void 0!==t[i]?t[i]:""}T.zoomrestore.style.width=T.win.css("width"),T.zoomrestore.style.height=T.win.css("height"),T.zoomrestore.padding={w:T.win.outerWidth()-T.win.width(),h:T.win.outerHeight()-T.win.height()},P.isios4&&(T.zoomrestore.scrollTop=c.scrollTop(),c.scrollTop(0)),T.win.css({position:P.isios4?"absolute":"fixed",top:0,left:0,zIndex:s+100,margin:0});var n=T.win.css("backgroundColor");return(""===n||/transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(n))&&T.win.css("backgroundColor","#fff"),T.rail.css({zIndex:s+101}),T.zoom.css({zIndex:s+102}),T.zoom.css("backgroundPosition","0 -18px"),T.resizeZoom(),T.onzoomin&&T.onzoomin.call(T),T.cancelEvent(e)}},this.doZoomOut=function(e){if(T.zoomactive)return T.zoomactive=!1,T.win.css("margin",""),T.win.css(T.zoomrestore.style),P.isios4&&c.scrollTop(T.zoomrestore.scrollTop),T.rail.css({"z-index":T.zindex}),T.zoom.css({"z-index":T.zindex}),T.zoomrestore=!1,T.zoom.css("backgroundPosition","0 0"),T.onResize(),T.onzoomout&&T.onzoomout.call(T),T.cancelEvent(e)},this.doZoom=function(e){return T.zoomactive?T.doZoomOut(e):T.doZoomIn(e)},this.resizeZoom=function(){if(T.zoomactive){var e=T.getScrollTop();T.win.css({width:c.width()-T.zoomrestore.padding.w+"px",height:c.height()-T.zoomrestore.padding.h+"px"}),T.onResize(),T.setScrollTop(Math.min(T.page.maxh,e))}},this.init(),n.nicescroll.push(this)},y=function(e){var o=this;this.nc=e,this.lastx=0,this.lasty=0,this.speedx=0,this.speedy=0,this.lasttime=0,this.steptime=0,this.snapx=!1,this.snapy=!1,this.demulx=0,this.demuly=0,this.lastscrollx=-1,this.lastscrolly=-1,this.chkx=0,this.chky=0,this.timer=0,this.reset=function(e,t){o.stop(),o.steptime=0,o.lasttime=f(),o.speedx=0,o.speedy=0,o.lastx=e,o.lasty=t,o.lastscrollx=-1,o.lastscrolly=-1},this.update=function(e,t){var r=f();o.steptime=r-o.lasttime,o.lasttime=r;var i=t-o.lasty,s=e-o.lastx,n=o.nc.getScrollTop()+i,l=o.nc.getScrollLeft()+s;o.snapx=l<0||l>o.nc.page.maxw,o.snapy=n<0||n>o.nc.page.maxh,o.speedx=s,o.speedy=i,o.lastx=e,o.lasty=t},this.stop=function(){o.nc.unsynched("domomentum2d"),o.timer&&clearTimeout(o.timer),o.timer=0,o.lastscrollx=-1,o.lastscrolly=-1},this.doSnapy=function(e,t){var r=!1;t<0?(t=0,r=!0):t>o.nc.page.maxh&&(t=o.nc.page.maxh,r=!0),e<0?(e=0,r=!0):e>o.nc.page.maxw&&(e=o.nc.page.maxw,r=!0),r?o.nc.doScrollPos(e,t,o.nc.opt.snapbackspeed):o.nc.triggerScrollEnd()},this.doMomentum=function(e){var t=f(),r=e?t+e:o.lasttime,i=o.nc.getScrollLeft(),s=o.nc.getScrollTop(),n=o.nc.page.maxh,l=o.nc.page.maxw;o.speedx=l>0?Math.min(60,o.speedx):0,o.speedy=n>0?Math.min(60,o.speedy):0;var a=r&&t-r<=60;(s<0||s>n||i<0||i>l)&&(a=!1);var c=!(!o.speedy||!a)&&o.speedy,d=!(!o.speedx||!a)&&o.speedx;if(c||d){var u=Math.max(16,o.steptime);if(u>50){var h=u/50;o.speedx*=h,o.speedy*=h,u=50}o.demulxy=0,o.lastscrollx=o.nc.getScrollLeft(),o.chkx=o.lastscrollx,o.lastscrolly=o.nc.getScrollTop(),o.chky=o.lastscrolly;var p=o.lastscrollx,m=o.lastscrolly,g=function(){var e=f()-t>600?.04:.02;o.speedx&&(p=Math.floor(o.lastscrollx-o.speedx*(1-o.demulxy)),o.lastscrollx=p,(p<0||p>l)&&(e=.1)),o.speedy&&(m=Math.floor(o.lastscrolly-o.speedy*(1-o.demulxy)),o.lastscrolly=m,(m<0||m>n)&&(e=.1)),o.demulxy=Math.min(1,o.demulxy+e),o.nc.synched("domomentum2d",function(){if(o.speedx){o.nc.getScrollLeft();o.chkx=p,o.nc.setScrollLeft(p)}if(o.speedy){o.nc.getScrollTop();o.chky=m,o.nc.setScrollTop(m)}o.timer||(o.nc.hideCursor(),o.doSnapy(p,m))}),o.demulxy<1?o.timer=setTimeout(g,u):(o.stop(),o.nc.hideCursor(),o.doSnapy(p,m))};g()}else o.doSnapy(o.nc.getScrollLeft(),o.nc.getScrollTop())}},x=e.fn.scrollTop;e.cssHooks.pageYOffset={get:function(e,o,t){var r=n.data(e,"__nicescroll")||!1;return r&&r.ishwscroll?r.getScrollTop():x.call(e)},set:function(e,o){var t=n.data(e,"__nicescroll")||!1;return t&&t.ishwscroll?t.setScrollTop(parseInt(o)):x.call(e,o),this}},e.fn.scrollTop=function(e){if(void 0===e){var o=!!this[0]&&(n.data(this[0],"__nicescroll")||!1);return o&&o.ishwscroll?o.getScrollTop():x.call(this)}return this.each(function(){var o=n.data(this,"__nicescroll")||!1;o&&o.ishwscroll?o.setScrollTop(parseInt(e)):x.call(n(this),e)})};var S=e.fn.scrollLeft;n.cssHooks.pageXOffset={get:function(e,o,t){var r=n.data(e,"__nicescroll")||!1;return r&&r.ishwscroll?r.getScrollLeft():S.call(e)},set:function(e,o){var t=n.data(e,"__nicescroll")||!1;return t&&t.ishwscroll?t.setScrollLeft(parseInt(o)):S.call(e,o),this}},e.fn.scrollLeft=function(e){if(void 0===e){var o=!!this[0]&&(n.data(this[0],"__nicescroll")||!1);return o&&o.ishwscroll?o.getScrollLeft():S.call(this)}return this.each(function(){var o=n.data(this,"__nicescroll")||!1;o&&o.ishwscroll?o.setScrollLeft(parseInt(e)):S.call(n(this),e)})};var z=function(e){var o=this;if(this.length=0,this.name="nicescrollarray",this.each=function(e){return n.each(o,e),o},this.push=function(e){o[o.length]=e,o.length++},this.eq=function(e){return o[e]},e)for(var t=0;t<e.length;t++){var r=n.data(e[t],"__nicescroll")||!1;r&&(this[this.length]=r,this.length++)}return this};!function(e,o,t){for(var r=0,i=o.length;r<i;r++)t(e,o[r])}(z.prototype,["show","hide","toggle","onResize","resize","remove","stop","doScrollPos"],function(e,o){e[o]=function(){var e=arguments;return this.each(function(){this[o].apply(this,e)})}}),e.fn.getNiceScroll=function(e){return void 0===e?new z(this):this[e]&&n.data(this[e],"__nicescroll")||!1},(e.expr.pseudos||e.expr[":"]).nicescroll=function(e){return void 0!==n.data(e,"__nicescroll")},n.fn.niceScroll=function(e,o){void 0!==o||"object"!=typeof e||"jquery"in e||(o=e,e=!1);var t=new z;return this.each(function(){var r=n(this),i=n.extend({},o);if(e){var s=n(e);i.doc=s.length>1?n(e,r):s,i.win=r}!("doc"in i)||"win"in i||(i.win=r);var l=r.data("__nicescroll")||!1;l||(i.doc=i.doc||r,l=new b(i,r),r.data("__nicescroll",l)),t.push(l)}),1===t.length?t[0]:t},a.NiceScroll={getjQuery:function(){return e}},n.nicescroll||(n.nicescroll=new z,n.nicescroll.options=g)});

!function(i,o){"function"==typeof define&&define.amd?define(["jquery"],function(t){return i.jBox=o(t)}):"object"==typeof module&&module.exports?module.exports=i.jBox=o(require("jquery")):i.jBox=o(i.jQuery)}(this,function(O){var t,i,s=function n(t,i){return this.options={id:null,width:"auto",height:"auto",minWidth:null,minHeight:null,maxWidth:null,maxHeight:null,responsiveWidth:!0,responsiveHeight:!0,responsiveMinWidth:100,responsiveMinHeight:100,attach:null,trigger:"click",preventDefault:!1,content:null,getContent:null,title:null,getTitle:null,footer:null,isolateScroll:!0,ajax:{url:null,data:"",reload:!1,getURL:"data-url",getData:"data-ajax",setContent:!0,spinner:!0,spinnerDelay:300,spinnerReposition:!0},cancelAjaxOnClose:!0,target:null,position:{x:"center",y:"center"},outside:null,offset:0,attributes:{x:"left",y:"top"},fixed:!1,adjustPosition:!0,adjustTracker:!1,adjustDistance:5,reposition:!0,repositionOnOpen:!0,repositionOnContent:!0,holdPosition:!0,pointer:!1,pointTo:"target",fade:180,animation:null,theme:"Default",addClass:null,overlay:!1,zIndex:1e4,delayOpen:0,delayClose:0,closeOnEsc:!1,closeOnClick:!1,closeOnMouseleave:!1,closeButton:!1,appendTo:O("body"),createOnInit:!1,blockScroll:!1,draggable:!1,dragOver:!0,autoClose:!1,delayOnHover:!1,showCountdown:!1,preloadAudio:!0,audio:null,volume:100,onInit:null,onAttach:null,onPosition:null,onCreated:null,onOpen:null,onClose:null,onCloseComplete:null},this._pluginOptions={Tooltip:{getContent:"title",trigger:"mouseenter",position:{x:"center",y:"top"},outside:"y",pointer:!0},Mouse:{responsiveWidth:!1,responsiveHeight:!1,adjustPosition:"flip",target:"mouse",trigger:"mouseenter",position:{x:"right",y:"bottom"},outside:"xy",offset:5},Modal:{target:O(window),fixed:!0,blockScroll:!0,closeOnEsc:!0,closeOnClick:"overlay",closeButton:!0,overlay:!0,animation:"zoomIn"}},this.options=O.extend(!0,this.options,this._pluginOptions[t]?this._pluginOptions[t]:n._pluginOptions[t],i),"string"==O.type(t)&&(this.type=t),this._fireEvent=function(t,i){this.options["_"+t]&&this.options["_"+t].bind(this)(i),this.options[t]&&this.options[t].bind(this)(i)},null===this.options.id&&(this.options.id="jBox"+n._getUniqueID()),this.id=this.options.id,("center"==this.options.position.x&&"x"==this.options.outside||"center"==this.options.position.y&&"y"==this.options.outside)&&(this.options.outside=null),"target"==this.options.pointTo&&(!this.options.outside||"xy"==this.options.outside)&&(this.options.pointer=!1),"object"!=O.type(this.options.offset)?this.options.offset={x:this.options.offset,y:this.options.offset}:this.options.offset=O.extend({x:0,y:0},this.options.offset),"object"!=O.type(this.options.adjustDistance)?this.options.adjustDistance={top:this.options.adjustDistance,right:this.options.adjustDistance,bottom:this.options.adjustDistance,left:this.options.adjustDistance}:this.options.adjustDistance=O.extend({top:5,left:5,right:5,bottom:5},this.options.adjustDistance),this.outside=!(!this.options.outside||"xy"==this.options.outside)&&this.options.position[this.options.outside],this.align=this.outside?this.outside:"center"!=this.options.position.y&&"number"!=O.type(this.options.position.y)?this.options.position.x:"center"!=this.options.position.x&&"number"!=O.type(this.options.position.x)?this.options.position.y:this.options.attributes.x,n.zIndexMax=Math.max(n.zIndexMax||0,"auto"===this.options.zIndex?1e4:this.options.zIndex),"auto"===this.options.zIndex&&(this.adjustZIndexOnOpen=!0,n.zIndexMax+=2,this.options.zIndex=n.zIndexMax,this.trueModal=this.options.overlay),this._getOpp=function(t){return{left:"right",right:"left",top:"bottom",bottom:"top",x:"y",y:"x"}[t]},this._getXY=function(t){return{left:"x",right:"x",top:"y",bottom:"y",center:"x"}[t]},this._getTL=function(t){return{left:"left",right:"left",top:"top",bottom:"top",center:"left",x:"left",y:"top"}[t]},this._getInt=function(t,i){return"auto"==t?"auto":t&&"string"==O.type(t)&&"%"==t.slice(-1)?O(window)["height"==i?"innerHeight":"innerWidth"]()*parseInt(t.replace("%",""))/100:t},this._createSVG=function(t,i){var o=document.createElementNS("http://www.w3.org/2000/svg",t);return O.each(i,function(t,i){o.setAttribute(i[0],i[1]||"")}),o},this._isolateScroll=function(e){e&&e.length&&e.on("DOMMouseScroll.jBoxIsolateScroll mousewheel.jBoxIsolateScroll",function(t){var i=t.wheelDelta||t.originalEvent&&t.originalEvent.wheelDelta||-t.detail,o=0<=this.scrollTop+e.outerHeight()-this.scrollHeight,s=this.scrollTop<=0;(i<0&&o||0<i&&s)&&t.preventDefault()})},this._setTitleWidth=function(){if(!this.titleContainer||"auto"==this.content[0].style.width&&!this.content[0].style.maxWidth)return null;if("none"==this.wrapper.css("display")){this.wrapper.css("display","block");var t=this.content.outerWidth();this.wrapper.css("display","none")}else t=this.content.outerWidth();this.titleContainer.css({maxWidth:Math.max(t,parseInt(this.content[0].style.maxWidth))||null})},this._draggable=function(){if(!this.options.draggable)return!1;var t="title"==this.options.draggable?this.titleContainer:this.options.draggable instanceof O?this.options.draggable:"string"==O.type(this.options.draggable)?O(this.options.draggable):this.wrapper;return!(!(t&&t instanceof O&&t.length)||t.data("jBox-draggable"))&&(t.addClass("jBox-draggable").data("jBox-draggable",!0).on("mousedown",function(t){if(2!=t.button&&!O(t.target).hasClass("jBox-noDrag")&&!O(t.target).parents(".jBox-noDrag").length){this.options.dragOver&&!this.trueModal&&parseInt(this.wrapper.css("zIndex"),10)<=n.zIndexMaxDragover&&(n.zIndexMaxDragover+=1,this.wrapper.css("zIndex",n.zIndexMaxDragover));var i=this.wrapper.outerHeight(),o=this.wrapper.outerWidth(),s=this.wrapper.offset().top+i-t.pageY,e=this.wrapper.offset().left+o-t.pageX;O(document).on("mousemove.jBox-draggable-"+this.id,function(t){this.wrapper.offset({top:t.pageY+s-i,left:t.pageX+e-o})}.bind(this)),t.preventDefault()}}.bind(this)).on("mouseup",function(){if(O(document).off("mousemove.jBox-draggable-"+this.id),("Modal"==this.type||"Confirm"==this.type)&&this.options.holdPosition){var t=O("#"+this.id).offset(),i={x:t.left-O(document).scrollLeft(),y:t.top-O(document).scrollTop()};this.position({position:i,offset:{x:0,y:0}})}}.bind(this)),this.trueModal||(n.zIndexMaxDragover=n.zIndexMaxDragover?Math.max(n.zIndexMaxDragover,this.options.zIndex):this.options.zIndex),this)},this._create=function(){if(!this.wrapper){if(this.wrapper=O("<div/>",{id:this.id,class:"jBox-wrapper"+(this.type?" jBox-"+this.type:"")+(this.options.theme?" jBox-"+this.options.theme:"")+(this.options.addClass?" "+this.options.addClass:"")}).css({position:this.options.fixed?"fixed":"absolute",display:"none",opacity:0,zIndex:this.options.zIndex}).data("jBox",this),this.options.closeOnMouseleave&&this.wrapper.on("mouseleave",function(t){!this.source||t.relatedTarget!=this.source[0]&&-1===O.inArray(this.source[0],O(t.relatedTarget).parents("*"))&&this.close()}.bind(this)),"box"==this.options.closeOnClick&&this.wrapper.on("touchend click",function(){this.close({ignoreDelay:!0})}.bind(this)),this.container=O('<div class="jBox-container"/>').appendTo(this.wrapper),this.content=O('<div class="jBox-content"/>').appendTo(this.container),this.options.footer&&(this.footer=O('<div class="jBox-footer"/>').append(this.options.footer).appendTo(this.container)),this.options.isolateScroll&&this._isolateScroll(this.content),this.options.closeButton){var t=this._createSVG("svg",[["viewBox","0 0 24 24"]]);t.appendChild(this._createSVG("path",[["d","M22.2,4c0,0,0.5,0.6,0,1.1l-6.8,6.8l6.9,6.9c0.5,0.5,0,1.1,0,1.1L20,22.3c0,0-0.6,0.5-1.1,0L12,15.4l-6.9,6.9c-0.5,0.5-1.1,0-1.1,0L1.7,20c0,0-0.5-0.6,0-1.1L8.6,12L1.7,5.1C1.2,4.6,1.7,4,1.7,4L4,1.7c0,0,0.6-0.5,1.1,0L12,8.5l6.8-6.8c0.5-0.5,1.1,0,1.1,0L22.2,4z"]])),this.closeButton=O('<div class="jBox-closeButton jBox-noDrag"/>').on("touchend click",function(t){this.close({ignoreDelay:!0})}.bind(this)).append(t),"box"!=this.options.closeButton&&(!0!==this.options.closeButton||this.options.overlay||this.options.title||this.options.getTitle)||(this.wrapper.addClass("jBox-closeButton-box"),this.closeButton.appendTo(this.container))}if(this.wrapper.appendTo(this.options.appendTo),this.wrapper.find(".jBox-closeButton").length&&O.each(["top","right","bottom","left"],function(t,i){this.wrapper.find(".jBox-closeButton").css(i)&&"auto"!=this.wrapper.find(".jBox-closeButton").css(i)&&(this.options.adjustDistance[i]=Math.max(this.options.adjustDistance[i],this.options.adjustDistance[i]+-1*((parseInt(this.wrapper.find(".jBox-closeButton").css(i))||0)+(parseInt(this.container.css("border-"+i+"-width"))||0))))}.bind(this)),this.options.pointer){if(this.pointer={position:"target"!=this.options.pointTo?this.options.pointTo:this._getOpp(this.outside),xy:"target"!=this.options.pointTo?this._getXY(this.options.pointTo):this._getXY(this.outside),align:"center",offset:0},this.pointer.element=O('<div class="jBox-pointer jBox-pointer-'+this.pointer.position+'"/>').appendTo(this.wrapper),this.pointer.dimensions={x:this.pointer.element.outerWidth(),y:this.pointer.element.outerHeight()},"string"==O.type(this.options.pointer)){var i=this.options.pointer.split(":");i[0]&&(this.pointer.align=i[0]),i[1]&&(this.pointer.offset=parseInt(i[1]))}this.pointer.alignAttribute="x"==this.pointer.xy?"bottom"==this.pointer.align?"bottom":"top":"right"==this.pointer.align?"right":"left",this.wrapper.css("padding-"+this.pointer.position,this.pointer.dimensions[this.pointer.xy]),this.pointer.element.css(this.pointer.alignAttribute,"center"==this.pointer.align?"50%":0).css("margin-"+this.pointer.alignAttribute,this.pointer.offset),this.pointer.margin={},this.pointer.margin["margin-"+this.pointer.alignAttribute]=this.pointer.offset,"center"==this.pointer.align&&this.pointer.element.css("transform","translate("+("y"==this.pointer.xy?-.5*this.pointer.dimensions.x+"px":0)+", "+("x"==this.pointer.xy?-.5*this.pointer.dimensions.y+"px":0)+")"),this.pointer.element.css("x"==this.pointer.xy?"width":"height",parseInt(this.pointer.dimensions[this.pointer.xy])+parseInt(this.container.css("border-"+this.pointer.alignAttribute+"-width"))),this.wrapper.addClass("jBox-pointerPosition-"+this.pointer.position)}this.setContent(this.options.content,!0),this.setTitle(this.options.title,!0),this.options.draggable&&this._draggable(),this._fireEvent("onCreated")}},this.options.createOnInit&&this._create(),this.options.attach&&this.attach(),this._attachEvents=function(){this.options.closeOnEsc&&O(document).on("keyup.jBox-"+this.id,function(t){27==t.keyCode&&this.close({ignoreDelay:!0})}.bind(this)),!0!==this.options.closeOnClick&&"body"!=this.options.closeOnClick||O(document).on("touchend.jBox-"+this.id+" click.jBox-"+this.id,function(t){this.blockBodyClick||"body"==this.options.closeOnClick&&(t.target==this.wrapper[0]||this.wrapper.has(t.target).length)||this.close({ignoreDelay:!0})}.bind(this)),this.options.delayOnHover&&O("#"+this.id).on("mouseenter",function(t){this.isHovered=!0}.bind(this)),this.options.delayOnHover&&O("#"+this.id).on("mouseleave",function(t){this.isHovered=!1}.bind(this)),(this.options.adjustPosition||this.options.reposition)&&!this.fixed&&this.outside&&(this.options.adjustTracker&&O(window).on("scroll.jBox-"+this.id,function(t){this.position()}.bind(this)),(this.options.adjustPosition||this.options.reposition)&&O(window).on("resize.jBox-"+this.id,function(t){this.position()}.bind(this))),"mouse"==this.options.target&&O("body").on("mousemove.jBox-"+this.id,function(t){this.position({mouseTarget:{top:t.pageY,left:t.pageX}})}.bind(this))},this._detachEvents=function(){this.options.closeOnEsc&&O(document).off("keyup.jBox-"+this.id),(!0===this.options.closeOnClick||"body"==this.options.closeOnClick)&&O(document).off("touchend.jBox-"+this.id+" click.jBox-"+this.id),this.options.adjustTracker&&O(window).off("scroll.jBox-"+this.id),(this.options.adjustPosition||this.options.reposition)&&O(window).off("resize.jBox-"+this.id),"mouse"==this.options.target&&O("body").off("mousemove.jBox-"+this.id)},this._showOverlay=function(){this.overlay||(this.overlay=O('<div id="'+this.id+'-overlay"/>').addClass("jBox-overlay"+(this.type?" jBox-overlay-"+this.type:"")).css({display:"none",opacity:0,zIndex:this.options.zIndex-1}).appendTo(this.options.appendTo),("overlay"==this.options.closeButton||!0===this.options.closeButton)&&this.overlay.append(this.closeButton),"overlay"==this.options.closeOnClick&&this.overlay.on("touchend click",function(){this.close({ignoreDelay:!0})}.bind(this)),O("#"+this.id+"-overlay .jBox-closeButton").length&&(this.options.adjustDistance.top=Math.max(O("#"+this.id+"-overlay .jBox-closeButton").outerHeight(),this.options.adjustDistance.top))),!0===this.adjustZIndexOnOpen&&this.overlay.css("zIndex",parseInt(this.wrapper.css("zIndex"),10)-1),"block"!=this.overlay.css("display")&&(this.options.fade?this.overlay.stop()&&this.overlay.animate({opacity:1},{queue:!1,duration:this.options.fade,start:function(){this.overlay.css({display:"block"})}.bind(this)}):this.overlay.css({display:"block",opacity:1}))},this._hideOverlay=function(){this.overlay&&(this.options.fade?this.overlay.stop()&&this.overlay.animate({opacity:0},{queue:!1,duration:this.options.fade,complete:function(){this.overlay.css({display:"none"})}.bind(this)}):this.overlay.css({display:"none",opacity:0}))},this._exposeDimensions=function(){this.wrapper.css({top:-1e4,left:-1e4,right:"auto",bottom:"auto"});var t={x:this.wrapper.outerWidth(),y:this.wrapper.outerHeight()};return this.wrapper.css({top:"auto",left:"auto"}),t},this._generateAnimationCSS=function(){if("object"!=O.type(this.options.animation)&&(this.options.animation={pulse:{open:"pulse",close:"zoomOut"},zoomIn:{open:"zoomIn",close:"zoomIn"},zoomOut:{open:"zoomOut",close:"zoomOut"},move:{open:"move",close:"move"},slide:{open:"slide",close:"slide"},flip:{open:"flip",close:"flip"},tada:{open:"tada",close:"zoomOut"}}[this.options.animation]),!this.options.animation)return null;this.options.animation.open&&(this.options.animation.open=this.options.animation.open.split(":")),this.options.animation.close&&(this.options.animation.close=this.options.animation.close.split(":")),this.options.animation.openDirection=this.options.animation.open[1]?this.options.animation.open[1]:null,this.options.animation.closeDirection=this.options.animation.close[1]?this.options.animation.close[1]:null,this.options.animation.open&&(this.options.animation.open=this.options.animation.open[0]),this.options.animation.close&&(this.options.animation.close=this.options.animation.close[0]),this.options.animation.open&&(this.options.animation.open+="Open"),this.options.animation.close&&(this.options.animation.close+="Close");var n={pulse:{duration:350,css:[["0%","scale(1)"],["50%","scale(1.1)"],["100%","scale(1)"]]},zoomInOpen:{duration:this.options.fade||180,css:[["0%","scale(0.9)"],["100%","scale(1)"]]},zoomInClose:{duration:this.options.fade||180,css:[["0%","scale(1)"],["100%","scale(0.9)"]]},zoomOutOpen:{duration:this.options.fade||180,css:[["0%","scale(1.1)"],["100%","scale(1)"]]},zoomOutClose:{duration:this.options.fade||180,css:[["0%","scale(1)"],["100%","scale(1.1)"]]},moveOpen:{duration:this.options.fade||180,positions:{top:{"0%":-12},right:{"0%":12},bottom:{"0%":12},left:{"0%":-12}},css:[["0%","translate%XY(%Vpx)"],["100%","translate%XY(0px)"]]},moveClose:{duration:this.options.fade||180,timing:"ease-in",positions:{top:{"100%":-12},right:{"100%":12},bottom:{"100%":12},left:{"100%":-12}},css:[["0%","translate%XY(0px)"],["100%","translate%XY(%Vpx)"]]},slideOpen:{duration:400,positions:{top:{"0%":-400},right:{"0%":400},bottom:{"0%":400},left:{"0%":-400}},css:[["0%","translate%XY(%Vpx)"],["100%","translate%XY(0px)"]]},slideClose:{duration:400,timing:"ease-in",positions:{top:{"100%":-400},right:{"100%":400},bottom:{"100%":400},left:{"100%":-400}},css:[["0%","translate%XY(0px)"],["100%","translate%XY(%Vpx)"]]},flipOpen:{duration:600,css:[["0%","perspective(400px) rotateX(90deg)"],["40%","perspective(400px) rotateX(-15deg)"],["70%","perspective(400px) rotateX(15deg)"],["100%","perspective(400px) rotateX(0deg)"]]},flipClose:{duration:this.options.fade||300,css:[["0%","perspective(400px) rotateX(0deg)"],["100%","perspective(400px) rotateX(90deg)"]]},tada:{duration:800,css:[["0%","scale(1)"],["10%, 20%","scale(0.9) rotate(-3deg)"],["30%, 50%, 70%, 90%","scale(1.1) rotate(3deg)"],["40%, 60%, 80%","scale(1.1) rotate(-3deg)"],["100%","scale(1) rotate(0)"]]}};O.each(["pulse","tada"],function(t,i){n[i+"Open"]=n[i+"Close"]=n[i]});var s=function(s,e){return keyframe_css="@keyframes jBox-"+this.id+"-animation-"+this.options.animation[s]+"-"+s+(e?"-"+e:"")+" {",O.each(n[this.options.animation[s]].css,function(t,i){var o=e?i[1].replace("%XY",this._getXY(e).toUpperCase()):i[1];n[this.options.animation[s]].positions&&(o=o.replace("%V",n[this.options.animation[s]].positions[e][i[0]])),keyframe_css+=i[0]+" {transform:"+o+";}"}.bind(this)),keyframe_css+="}",keyframe_css+=".jBox-"+this.id+"-animation-"+this.options.animation[s]+"-"+s+(e?"-"+e:"")+" {",keyframe_css+="animation-duration: "+n[this.options.animation[s]].duration+"ms;",keyframe_css+="animation-name: jBox-"+this.id+"-animation-"+this.options.animation[s]+"-"+s+(e?"-"+e:"")+";",keyframe_css+=n[this.options.animation[s]].timing?"animation-timing-function: "+n[this.options.animation[s]].timing+";":"",keyframe_css+="}",keyframe_css}.bind(this);this._animationCSS="",O.each(["open","close"],function(t,o){if(!this.options.animation[o]||!n[this.options.animation[o]]||"close"==o&&!this.options.fade)return"";n[this.options.animation[o]].positions?O.each(["top","right","bottom","left"],function(t,i){this._animationCSS+=s(o,i)}.bind(this)):this._animationCSS+=s(o)}.bind(this))},this.options.animation&&this._generateAnimationCSS(),this._blockBodyClick=function(){this.blockBodyClick=!0,setTimeout(function(){this.blockBodyClick=!1}.bind(this),10)},this._animate=function(t){if(!t&&(t=this.isOpen?"open":"close"),!this.options.fade&&"close"==t)return null;var i=this.options.animation[t+"Direction"]||("center"!=this.align?this.align:this.options.attributes.x);this.flipped&&this._getXY(i)==this._getXY(this.align)&&(i=this._getOpp(i));var o="jBox-"+this.id+"-animation-"+this.options.animation[t]+"-"+t+" jBox-"+this.id+"-animation-"+this.options.animation[t]+"-"+t+"-"+i;this.wrapper.addClass(o);var s=1e3*parseFloat(this.wrapper.css("animation-duration"));"close"==t&&(s=Math.min(s,this.options.fade)),setTimeout(function(){this.wrapper.removeClass(o)}.bind(this),s)},this._abortAnimation=function(){var t=this.wrapper.attr("class").split(" ").filter(function(t){return 0!==t.lastIndexOf("jBox-"+this.id+"-animation",0)}.bind(this));this.wrapper.attr("class",t.join(" "))},(this.options.responsiveWidth||this.options.responsiveHeight)&&O(window).on("resize.responsivejBox-"+this.id,function(t){this.isOpen&&this.position()}.bind(this)),"string"===O.type(this.options.preloadAudio)&&(this.options.preloadAudio=[this.options.preloadAudio]),"string"===O.type(this.options.audio)&&(this.options.audio={open:this.options.audio}),"number"===O.type(this.options.volume)&&(this.options.volume={open:this.options.volume,close:this.options.volume}),!0===this.options.preloadAudio&&this.options.audio&&(this.options.preloadAudio=[],O.each(this.options.audio,function(t,i){this.options.preloadAudio.push(i+".mp3"),this.options.preloadAudio.push(i+".ogg")}.bind(this))),this.options.preloadAudio.length&&O.each(this.options.preloadAudio,function(t,i){var o=new Audio;o.src=i,o.preload="auto"}),this._fireEvent("onInit"),this};return s.prototype.attach=function(t,s){return!t&&(t=this.options.attach),"string"==O.type(t)&&(t=O(t)),!s&&(s=this.options.trigger),t&&t.length&&O.each(t,function(t,o){(o=O(o)).data("jBox-attached-"+this.id)||("title"==this.options.getContent&&null!=o.attr("title")&&o.data("jBox-getContent",o.attr("title")).removeAttr("title"),this.attachedElements||(this.attachedElements=[]),this.attachedElements.push(o[0]),o.on(s+".jBox-attach-"+this.id,function(t){if(this.timer&&clearTimeout(this.timer),"mouseenter"!=s||!this.isOpen||this.source[0]!=o[0]){if(this.isOpen&&this.source&&this.source[0]!=o[0])var i=!0;this.source=o,!this.options.target&&(this.target=o),"click"==s&&this.options.preventDefault&&t.preventDefault(),this["click"!=s||i?"open":"toggle"]()}}.bind(this)),"mouseenter"==this.options.trigger&&o.on("mouseleave",function(t){if(!this.wrapper)return null;this.options.closeOnMouseleave&&(t.relatedTarget==this.wrapper[0]||O(t.relatedTarget).parents("#"+this.id).length)||this.close()}.bind(this)),o.data("jBox-attached-"+this.id,s),this._fireEvent("onAttach",o))}.bind(this)),this},s.prototype.detach=function(t){return!t&&(t=this.attachedElements||[]),t&&t.length&&O.each(t,function(t,i){(i=O(i)).data("jBox-attached-"+this.id)&&(i.off(i.data("jBox-attached-"+this.id)+".jBox-attach-"+this.id),i.data("jBox-attached-"+this.id,null)),this.attachedElements=O.grep(this.attachedElements,function(t){return t!=i[0]})}.bind(this)),this},s.prototype.setTitle=function(t,i){if(null==t||null==t)return this;!this.wrapper&&this._create();var o=this.wrapper.outerHeight(),s=this.wrapper.outerWidth();return this.title||(this.titleContainer=O('<div class="jBox-title"/>'),this.title=O("<div/>").appendTo(this.titleContainer),this.wrapper.addClass("jBox-hasTitle"),("title"==this.options.closeButton||!0===this.options.closeButton&&!this.options.overlay)&&(this.wrapper.addClass("jBox-closeButton-title"),this.closeButton.appendTo(this.titleContainer)),this.titleContainer.insertBefore(this.content),this._setTitleWidth()),this.title.html(t),s!=this.wrapper.outerWidth()&&this._setTitleWidth(),this.options.draggable&&this._draggable(),!i&&this.options.repositionOnContent&&(o!=this.wrapper.outerHeight()||s!=this.wrapper.outerWidth())&&this.position(),this},s.prototype.setContent=function(t,i){if(null==t||null==t)return this;!this.wrapper&&this._create();var o=this.wrapper.outerHeight(),s=this.wrapper.outerWidth();switch(this.content.children("[data-jbox-content-appended]").appendTo("body").css({display:"none"}),O.type(t)){case"string":this.content.html(t);break;case"object":this.content.html(""),t.attr("data-jbox-content-appended",1).appendTo(this.content).css({display:"block"})}return s!=this.wrapper.outerWidth()&&this._setTitleWidth(),this.options.draggable&&this._draggable(),!i&&this.options.repositionOnContent&&(o!=this.wrapper.outerHeight()||s!=this.wrapper.outerWidth())&&this.position(),this},s.prototype.setDimensions=function(t,i,o){!this.wrapper&&this._create(),null==i&&(i="auto"),this.content.css(t,this._getInt(i)),"width"==t&&this._setTitleWidth(),(null==o||o)&&this.position()},s.prototype.setWidth=function(t,i){this.setDimensions("width",t,i)},s.prototype.setHeight=function(t,i){this.setDimensions("height",t,i)},s.prototype.position=function(o){if(!o&&(o={}),o=O.extend(!0,this.options,o),this.target=o.target||this.target||O(window),!(this.target instanceof O||"mouse"==this.target)&&(this.target=O(this.target)),!this.target.length)return this;this.content.css({width:this._getInt(o.width,"width"),height:this._getInt(o.height,"height"),minWidth:this._getInt(o.minWidth,"width"),minHeight:this._getInt(o.minHeight,"height"),maxWidth:this._getInt(o.maxWidth,"width"),maxHeight:this._getInt(o.maxHeight,"height")}),this._setTitleWidth();var s=this._exposeDimensions();"mouse"!=this.target&&!this.target.data("jBox-"+this.id+"-fixed")&&this.target.data("jBox-"+this.id+"-fixed",this.target[0]!=O(window)[0]&&("fixed"==this.target.css("position")||0<this.target.parents().filter(function(){return"fixed"==O(this).css("position")}).length)?"fixed":"static");var t={x:O(window).outerWidth(),y:O(window).outerHeight(),top:o.fixed&&this.target.data("jBox-"+this.id+"-fixed")?0:O(window).scrollTop(),left:o.fixed&&this.target.data("jBox-"+this.id+"-fixed")?0:O(window).scrollLeft()};t.bottom=t.top+t.y,t.right=t.left+t.x;try{var i=this.target.offset()}catch(t){i={top:0,left:0}}"mouse"!=this.target&&"fixed"==this.target.data("jBox-"+this.id+"-fixed")&&o.fixed&&(i.top=i.top-O(window).scrollTop(),i.left=i.left-O(window).scrollLeft());var e={x:"mouse"==this.target?12:this.target.outerWidth(),y:"mouse"==this.target?20:this.target.outerHeight(),top:"mouse"==this.target&&o.mouseTarget?o.mouseTarget.top:i?i.top:0,left:"mouse"==this.target&&o.mouseTarget?o.mouseTarget.left:i?i.left:0},n=o.outside&&!("center"==o.position.x&&"center"==o.position.y),a={x:t.x-o.adjustDistance.left-o.adjustDistance.right,y:t.y-o.adjustDistance.top-o.adjustDistance.bottom,left:n?e.left-O(window).scrollLeft()-o.adjustDistance.left:0,right:n?t.x-e.left+O(window).scrollLeft()-e.x-o.adjustDistance.right:0,top:n?e.top-O(window).scrollTop()-this.options.adjustDistance.top:0,bottom:n?t.y-e.top+O(window).scrollTop()-e.y-o.adjustDistance.bottom:0},h={x:"x"!=o.outside&&"xy"!=o.outside||"number"==O.type(o.position.x)?null:o.position.x,y:"y"!=o.outside&&"xy"!=o.outside||"number"==O.type(o.position.y)?null:o.position.y},r={x:!1,y:!1};if(h.x&&s.x>a[h.x]&&a[this._getOpp(h.x)]>a[h.x]&&(h.x=this._getOpp(h.x))&&(r.x=!0),h.y&&s.y>a[h.y]&&a[this._getOpp(h.y)]>a[h.y]&&(h.y=this._getOpp(h.y))&&(r.y=!0),o.responsiveWidth||o.responsiveHeight){var p=function(){if(o.responsiveWidth&&s.x>a[h.x||"x"]){var t=a[h.x||"x"]-(this.pointer&&n&&"x"==o.outside?this.pointer.dimensions.x:0)-parseInt(this.container.css("border-left-width"))-parseInt(this.container.css("border-right-width"));this.content.css({width:t>this.options.responsiveMinWidth?t:null,minWidth:t<parseInt(this.content.css("minWidth"))?0:null}),this._setTitleWidth()}s=this._exposeDimensions()}.bind(this);o.responsiveWidth&&p(),o.responsiveWidth&&!r.y&&h.y&&s.y>a[h.y]&&a[this._getOpp(h.y)]>a[h.y]&&(h.y=this._getOpp(h.y))&&(r.y=!0);var l=function(){if(o.responsiveHeight&&s.y>a[h.y||"y"]){var t=function(){if(!this.titleContainer&&!this.footer)return 0;if("none"==this.wrapper.css("display")){this.wrapper.css("display","block");var t=(this.titleContainer?this.titleContainer.outerHeight():0)+(this.footer?this.footer.outerHeight():0);this.wrapper.css("display","none")}else t=(this.titleContainer?this.titleContainer.outerHeight():0)+(this.footer?this.footer.outerHeight():0);return t||0}.bind(this),i=a[h.y||"y"]-(this.pointer&&n&&"y"==o.outside?this.pointer.dimensions.y:0)-t()-parseInt(this.container.css("border-top-width"))-parseInt(this.container.css("border-bottom-width"));this.content.css({height:i>this.options.responsiveMinHeight?i:null}),this._setTitleWidth()}s=this._exposeDimensions()}.bind(this);o.responsiveHeight&&l(),o.responsiveHeight&&!r.x&&h.x&&s.x>a[h.x]&&a[this._getOpp(h.x)]>a[h.x]&&(h.x=this._getOpp(h.x))&&(r.x=!0),o.adjustPosition&&"move"!=o.adjustPosition&&(r.x&&p(),r.y&&l())}var d={},c=function(t){if("number"!=O.type(o.position[t])){var i=o.attributes[t]="x"==t?"left":"top";if(d[i]=e[i],"center"==o.position[t])return d[i]+=Math.ceil((e[t]-s[t])/2),void("mouse"!=this.target&&this.target[0]&&this.target[0]==O(window)[0]&&(d[i]+=.5*(o.adjustDistance[i]-o.adjustDistance[this._getOpp(i)])));i!=o.position[t]&&(d[i]+=e[t]-s[t]),(o.outside==t||"xy"==o.outside)&&(d[i]+=s[t]*(i!=o.position[t]?1:-1))}else d[o.attributes[t]]=o.position[t]}.bind(this);if(c("x"),c("y"),this.pointer&&"target"==o.pointTo&&"number"!=O.type(o.position.x)&&"number"!=O.type(o.position.y)){var u=0;switch(this.pointer.align){case"center":"center"!=o.position[this._getOpp(o.outside)]&&(u+=s[this._getOpp(o.outside)]/2);break;default:switch(o.position[this._getOpp(o.outside)]){case"center":u+=(s[this._getOpp(o.outside)]/2-this.pointer.dimensions[this._getOpp(o.outside)]/2)*(this.pointer.align==this._getTL(this.pointer.align)?1:-1);break;default:u+=this.pointer.align!=o.position[this._getOpp(o.outside)]?this.dimensions[this._getOpp(o.outside)]*(-1!==O.inArray(this.pointer.align,["top","left"])?1:-1)+this.pointer.dimensions[this._getOpp(o.outside)]/2*(-1!==O.inArray(this.pointer.align,["top","left"])?-1:1):this.pointer.dimensions[this._getOpp(o.outside)]/2*(-1!==O.inArray(this.pointer.align,["top","left"])?1:-1)}}u*=o.position[this._getOpp(o.outside)]==this.pointer.alignAttribute?-1:1,u+=this.pointer.offset*(this.pointer.align==this._getOpp(this._getTL(this.pointer.align))?1:-1),d[this._getTL(this._getOpp(this.pointer.xy))]+=u}if(d[o.attributes.x]+=o.offset.x,d[o.attributes.y]+=o.offset.y,this.wrapper.css(d),o.adjustPosition){this.positionAdjusted&&(this.pointer&&this.wrapper.css("padding",0).css("padding-"+this._getOpp(this.outside),this.pointer.dimensions[this._getXY(this.outside)]).removeClass("jBox-pointerPosition-"+this._getOpp(this.pointer.position)).addClass("jBox-pointerPosition-"+this.pointer.position),this.pointer&&this.pointer.element.attr("class","jBox-pointer jBox-pointer-"+this._getOpp(this.outside)).css(this.pointer.margin),this.positionAdjusted=!1,this.flipped=!1);var g=t.top>d.top-(o.adjustDistance.top||0),m=t.right<d.left+s.x+(o.adjustDistance.right||0),f=t.bottom<d.top+s.y+(o.adjustDistance.bottom||0),x=t.left>d.left-(o.adjustDistance.left||0),y=x?"left":m?"right":null,j=g?"top":f?"bottom":null;if(y||j){if(("Modal"==this.type||"Confirm"==this.type)&&"number"==O.type(this.options.position.x)&&"number"==O.type(this.options.position.y)){var b=0,v=0;return this.options.holdPosition&&(x?b=t.left-(d.left-(o.adjustDistance.left||0)):m&&(b=t.right-(d.left+s.x+(o.adjustDistance.right||0))),g?v=t.top-(d.top-(o.adjustDistance.top||0)):f&&(v=t.bottom-(d.top+s.y+(o.adjustDistance.bottom||0))),this.options.position.x=Math.max(t.top,this.options.position.x+b),this.options.position.y=Math.max(t.left,this.options.position.y+v),c("x"),c("y"),this.wrapper.css(d)),this._fireEvent("onPosition"),this}var w=function(t){this.wrapper.css(this._getTL(t),d[this._getTL(t)]+(s[this._getXY(t)]+o.offset[this._getXY(t)]*("top"==t||"left"==t?-2:2)+e[this._getXY(t)])*("top"==t||"left"==t?1:-1)),this.pointer&&this.wrapper.removeClass("jBox-pointerPosition-"+this.pointer.position).addClass("jBox-pointerPosition-"+this._getOpp(this.pointer.position)).css("padding",0).css("padding-"+t,this.pointer.dimensions[this._getXY(t)]),this.pointer&&this.pointer.element.attr("class","jBox-pointer jBox-pointer-"+t),this.positionAdjusted=!0,this.flipped=!0}.bind(this);r.x&&w(this.options.position.x),r.y&&w(this.options.position.y);var B="x"==this._getXY(this.outside)?j:y;if(this.pointer&&"target"==o.pointTo&&"flip"!=o.adjustPosition&&this._getXY(B)==this._getOpp(this._getXY(this.outside))){if("center"==this.pointer.align)var _=s[this._getXY(B)]/2-this.pointer.dimensions[this._getOpp(this.pointer.xy)]/2-parseInt(this.pointer.element.css("margin-"+this.pointer.alignAttribute))*(B!=this._getTL(B)?-1:1);else _=B==this.pointer.alignAttribute?parseInt(this.pointer.element.css("margin-"+this.pointer.alignAttribute)):s[this._getXY(B)]-parseInt(this.pointer.element.css("margin-"+this.pointer.alignAttribute))-this.pointer.dimensions[this._getXY(B)];var C=B==this._getTL(B)?t[this._getTL(B)]-d[this._getTL(B)]+o.adjustDistance[B]:-1*(t[this._getOpp(this._getTL(B))]-d[this._getTL(B)]-o.adjustDistance[B]-s[this._getXY(B)]);B==this._getOpp(this._getTL(B))&&d[this._getTL(B)]-C<t[this._getTL(B)]+o.adjustDistance[this._getTL(B)]&&(C-=t[this._getTL(B)]+o.adjustDistance[this._getTL(B)]-(this.pos[this._getTL(B)]-C)),(C=Math.min(C,_))<=_&&0<C&&(this.pointer.element.css("margin-"+this.pointer.alignAttribute,parseInt(this.pointer.element.css("margin-"+this.pointer.alignAttribute))-C*(B!=this.pointer.alignAttribute?-1:1)),this.wrapper.css(this._getTL(B),d[this._getTL(B)]+C*(B!=this._getTL(B)?-1:1)),this.positionAdjusted=!0)}}}return this._fireEvent("onPosition"),this},s.prototype.open=function(t){if(!t&&(t={}),this.isDestroyed)return!1;if(!this.wrapper&&this._create(),!this._styles&&(this._styles=O("<style/>").append(this._animationCSS).appendTo(O("head"))),this.timer&&clearTimeout(this.timer),this._blockBodyClick(),this.isDisabled)return this;var i=function(){!0===this.adjustZIndexOnOpen&&(s.zIndexMax=Math.max(parseInt(this.wrapper.css("zIndex"),10),this.options.zIndex,s.zIndexMax||0,s.zIndexMaxDragover||0)+2,this.wrapper.css("zIndex",s.zIndexMax),this.options.zIndex=s.zIndexMax),this.source&&this.options.getTitle&&this.source.attr(this.options.getTitle)&&this.setTitle(this.source.attr(this.options.getTitle),!0),this.source&&this.options.getContent&&(this.source.data("jBox-getContent")?this.setContent(this.source.data("jBox-getContent"),!0):this.source.attr(this.options.getContent)?this.setContent(this.source.attr(this.options.getContent),!0):"html"==this.options.getContent&&this.setContent(this.source.html(),!0)),this._fireEvent("onOpen"),(this.options.ajax&&(this.options.ajax.url||this.source&&this.source.attr(this.options.ajax.getURL))&&(!this.ajaxLoaded||this.options.ajax.reload)||t.ajax&&(t.ajax.url||t.ajax.data))&&("strict"==this.options.ajax.reload||!this.source||!this.source.data("jBox-ajax-data")||t.ajax&&(t.ajax.url||t.ajax.data)?this.ajax(t.ajax||null,!0):this.setContent(this.source.data("jBox-ajax-data"))),(!this.positionedOnOpen||this.options.repositionOnOpen)&&this.position(t)&&(this.positionedOnOpen=!0),this.isClosing&&this._abortAnimation(),this.isOpen||(this.isOpen=!0,this.options.autoClose&&(this.options.delayClose=this.options.autoClose)&&this.close(),this._attachEvents(),this.options.blockScroll&&O("body").addClass("jBox-blockScroll-"+this.id),this.options.overlay&&this._showOverlay(),this.options.animation&&!this.isClosing&&this._animate("open"),this.options.audio&&this.options.audio.open&&this.audio(this.options.audio.open,this.options.volume.open),this.options.fade?this.wrapper.stop().animate({opacity:1},{queue:!1,duration:this.options.fade,start:function(){this.isOpening=!0,this.wrapper.css({display:"block"})}.bind(this),always:function(){this.isOpening=!1,setTimeout(function(){this.positionOnFadeComplete&&this.position()&&(this.positionOnFadeComplete=!1)}.bind(this),10)}.bind(this)}):(this.wrapper.css({display:"block",opacity:1}),this.positionOnFadeComplete&&this.position()&&(this.positionOnFadeComplete=!1)))}.bind(this);return!this.options.delayOpen||this.isOpen||this.isClosing||t.ignoreDelay?i():this.timer=setTimeout(i,this.options.delayOpen),this},s.prototype.close=function(t){if(t||(t={}),this.isDestroyed||this.isClosing)return!1;if(this.timer&&clearTimeout(this.timer),this._blockBodyClick(),this.isDisabled)return this;var i=function(){this._fireEvent("onClose"),this.options.cancelAjaxOnClose&&this.abortAjax(),this.isOpen&&(this.isOpen=!1,this._detachEvents(),this.options.blockScroll&&O("body").removeClass("jBox-blockScroll-"+this.id),this.options.overlay&&this._hideOverlay(),this.options.animation&&!this.isOpening&&this._animate("close"),this.options.audio&&this.options.audio.close&&this.audio(this.options.audio.close,this.options.volume.close),this.options.fade?this.wrapper.stop().animate({opacity:0},{queue:!1,duration:this.options.fade,start:function(){this.isClosing=!0}.bind(this),complete:function(){this.wrapper.css({display:"none"}),this._fireEvent("onCloseComplete")}.bind(this),always:function(){this.isClosing=!1}.bind(this)}):(this.wrapper.css({display:"none",opacity:0}),this._fireEvent("onCloseComplete")))}.bind(this);if(t.ignoreDelay)i();else if((this.options.delayOnHover||this.options.showCountdown)&&10<this.options.delayClose){var o=this,s=this.options.delayClose,e=Date.now();if(this.options.showCountdown&&!this.inner){var n=O('<div class="jBox-countdown"></div>');this.inner=O('<div class="jBox-countdown_inner"></div>'),n.prepend(this.inner),O("#"+this.id).append(n)}this.countdown=function(){var t=Date.now();o.isHovered||(s-=t-e),e=t,0<s?(o.options.showCountdown&&o.inner.css("width",100*s/o.options.delayClose+"%"),window.requestAnimationFrame(o.countdown)):i()},window.requestAnimationFrame(this.countdown)}else this.timer=setTimeout(i,Math.max(this.options.delayClose,10));return this},s.prototype.toggle=function(t){return this[this.isOpen?"close":"open"](t),this},s.prototype.disable=function(){return this.isDisabled=!0,this},s.prototype.enable=function(){return this.isDisabled=!1,this},s.prototype.hide=function(){return this.disable(),this.wrapper&&this.wrapper.css({display:"none"}),this},s.prototype.show=function(){return this.enable(),this.wrapper&&this.wrapper.css({display:"block"}),this},s.prototype.ajax=function(o,i){o||(o={}),O.each([["getData","data"],["getURL","url"]],function(t,i){this.options.ajax[i[0]]&&!o[i[1]]&&this.source&&null!=this.source.attr(this.options.ajax[i[0]])&&(o[i[1]]=this.source.attr(this.options.ajax[i[0]])||"")}.bind(this));var t=O.extend(!0,{},this.options.ajax);this.abortAjax();var s=o.beforeSend||t.beforeSend||function(){},e=o.complete||t.complete||function(){},n=o.success||t.success||function(){},a=o.error||t.error||function(){},h=O.extend(!0,t,o);return h.beforeSend=function(t){this.wrapper.addClass("jBox-loading"),h.spinner&&(this.spinnerDelay=setTimeout(function(){this.wrapper.addClass("jBox-loading-spinner"),h.spinnerReposition&&(i?this.positionOnFadeComplete=!0:this.position()),this.spinner=O(!0!==h.spinner?h.spinner:'<div class="jBox-spinner"></div>').appendTo(this.container),this.titleContainer&&"absolute"==this.spinner.css("position")&&this.spinner.css({transform:"translateY("+.5*this.titleContainer.outerHeight()+"px)"})}.bind(this),""==this.content.html()?0:h.spinnerDelay||0)),s.bind(this)(t)}.bind(this),h.complete=function(t){this.spinnerDelay&&clearTimeout(this.spinnerDelay),this.wrapper.removeClass("jBox-loading jBox-loading-spinner jBox-loading-spinner-delay"),this.spinner&&this.spinner.length&&this.spinner.remove()&&h.spinnerReposition&&(i?this.positionOnFadeComplete=!0:this.position()),this.ajaxLoaded=!0,e.bind(this)(t)}.bind(this),h.success=function(t){h.setContent&&this.setContent(t,!0)&&(i?this.positionOnFadeComplete=!0:this.position()),h.setContent&&this.source&&this.source.data("jBox-ajax-data",t),n.bind(this)(t)}.bind(this),h.error=function(t){a.bind(this)(t)}.bind(this),this.ajaxRequest=O.ajax(h),this},s.prototype.abortAjax=function(){this.ajaxRequest&&this.ajaxRequest.abort()},s.prototype.audio=function(t,i){if(!t)return this;if(!s._audio&&(s._audio={}),!s._audio[t]){var o=O("<audio/>");O("<source/>",{src:t+".mp3"}).appendTo(o),O("<source/>",{src:t+".ogg"}).appendTo(o),s._audio[t]=o[0]}s._audio[t].volume=Math.min((null!=i?i:100)/100,1);try{s._audio[t].pause(),s._audio[t].currentTime=0}catch(t){}return s._audio[t].play(),this},s._animationSpeeds={tada:1e3,tadaSmall:1e3,flash:500,shake:400,pulseUp:250,pulseDown:250,popIn:250,popOut:250,fadeIn:200,fadeOut:200,slideUp:400,slideRight:400,slideLeft:400,slideDown:400},s.prototype.animate=function(t,i){!i&&(i={}),!this.animationTimeout&&(this.animationTimeout={}),!i.element&&(i.element=this.wrapper),!i.element.data("jBox-animating-id")&&i.element.data("jBox-animating-id",s._getUniqueElementID()),i.element.data("jBox-animating")&&(i.element.removeClass(i.element.data("jBox-animating")).data("jBox-animating",null),this.animationTimeout[i.element.data("jBox-animating-id")]&&clearTimeout(this.animationTimeout[i.element.data("jBox-animating-id")])),i.element.addClass("jBox-animated-"+t).data("jBox-animating","jBox-animated-"+t),this.animationTimeout[i.element.data("jBox-animating-id")]=setTimeout(function(){i.element.removeClass(i.element.data("jBox-animating")).data("jBox-animating",null),i.complete&&i.complete()},s._animationSpeeds[t])},s.prototype.destroy=function(){return this.detach(),this.isOpen&&this.close({ignoreDelay:!0}),this.wrapper&&this.wrapper.remove(),this.overlay&&this.overlay.remove(),this._styles&&this._styles.remove(),this.isDestroyed=!0,this},s._getUniqueID=(t=1,function(){return t++}),s._getUniqueElementID=(i=1,function(){return i++}),s._pluginOptions={},s.plugin=function(t,i){s._pluginOptions[t]=i},O.fn.jBox=function(t,i){return!t&&(t={}),!i&&(i={}),new s(t,O.extend(i,{attach:this}))},s}),jQuery(document).ready(function(){new jBox.plugin("Confirm",{confirmButton:"Submit",cancelButton:"Cancel",confirm:null,cancel:null,closeOnConfirm:!0,target:window,addClass:"jBox-Modal",fixed:!0,attach:"[data-confirm]",getContent:"data-confirm",content:"Do you really want to do this?",minWidth:360,maxWidth:500,blockScroll:!0,closeOnEsc:!0,closeOnClick:!1,closeButton:!1,overlay:!0,animation:"zoomIn",preventDefault:!0,_onAttach:function(t){if(!this.options.confirm){var i=t.attr("onclick")?t.attr("onclick"):t.attr("href")?t.attr("target")?'window.open("'+t.attr("href")+'", "'+t.attr("target")+'");':'window.location.href = "'+t.attr("href")+'";':"";t.prop("onclick",null).data("jBox-Confirm-submit",i)}},_onCreated:function(){this.footer=jQuery('<div class="jBox-Confirm-footer"/>'),jQuery('<div class="jBox-Confirm-button jBox-Confirm-button-cancel"/>').html(this.options.cancelButton).click(function(){this.options.cancel&&this.options.cancel(),this.close()}.bind(this)).appendTo(this.footer),this.submitButton=jQuery('<div class="jBox-Confirm-button jBox-Confirm-button-submit"/>').html(this.options.confirmButton).appendTo(this.footer),this.footer.appendTo(this.container)},_onOpen:function(){this.submitButton.off("click.jBox-Confirm"+this.id).on("click.jBox-Confirm"+this.id,function(){this.options.confirm?this.options.confirm():eval(this.source.data("jBox-Confirm-submit")),this.options.closeOnConfirm&&this.close()}.bind(this))}})}),jQuery(document).ready(function(){new jBox.plugin("Image",{src:"href",gallery:"data-jbox-image",imageLabel:"title",imageFade:360,imageSize:"contain",imageCounter:!1,imageCounterSeparator:"/",target:window,attach:"[data-jbox-image]",fixed:!0,blockScroll:!0,closeOnEsc:!0,closeOnClick:"button",closeButton:!0,overlay:!0,animation:"zoomIn",preventDefault:!0,width:"100%",height:"100%",downloadButton:!1,downloadButtonText:null,downloadButtonUrl:null,adjustDistance:{top:40,right:5,bottom:40,left:5},_onInit:function(){this.images=this.currentImage={},this.imageZIndex=1,this.attachedElements&&jQuery.each(this.attachedElements,function(t,i){if(!(i=jQuery(i)).data("jBox-image-gallery")){var o=i.attr(this.options.gallery)||"default";!this.images[o]&&(this.images[o]=[]),this.images[o].push({src:i.attr(this.options.src),label:i.attr(this.options.imageLabel)||"",downloadUrl:this.options.downloadButtonUrl&&i.attr(this.options.downloadButtonUrl)?i.attr(this.options.downloadButtonUrl):null}),"title"==this.options.imageLabel&&i.removeAttr("title"),i.data("jBox-image-gallery",o),i.data("jBox-image-id",this.images[o].length-1)}}.bind(this));var e=function(t,i,o,s,e){if(!jQuery("#jBox-image-"+t+"-"+i).length){var n=jQuery("<div/>",{id:"jBox-image-"+t+"-"+i,class:"jBox-image-container"+(e?" jBox-image-not-found":"")+(s||o?"":" jBox-image-"+t+"-current")}).css({backgroundImage:e?"":'url("'+this.images[t][i].src+'")',backgroundSize:this.options.imageSize,opacity:s?1:0,zIndex:o?0:this.imageZIndex++}).appendTo(this.content);jQuery("<div/>",{id:"jBox-image-label-"+t+"-"+i,class:"jBox-image-label"+(s?" active":"")}).html(this.images[t][i].label).click(function(){$(this).toggleClass("expanded")}).appendTo(this.imageLabel),!s&&!o&&n.animate({opacity:1},this.options.imageFade)}}.bind(this);this.downloadImage=function(t){var i=document.createElement("a");i.href=t,i.setAttribute("download",t.substring(t.lastIndexOf("/")+1)),document.body.appendChild(i),i.click()};var n=function(t,i){jQuery(".jBox-image-label.active").removeClass("active expanded"),jQuery("#jBox-image-label-"+t+"-"+i).addClass("active")};this.showImage=function(t){if("open"!=t){var i=this.currentImage.gallery;o=(o=this.currentImage.id+(1*("prev"==t)?-1:1))>this.images[i].length-1?0:o<0?this.images[i].length-1:o}else{i=this.source.data("jBox-image-gallery");var o=this.source.data("jBox-image-id");jQuery(".jBox-image-pointer-prev, .jBox-image-pointer-next").css({display:1<this.images[i].length?"block":"none"})}if(jQuery(".jBox-image-"+i+"-current").length&&jQuery(".jBox-image-"+i+"-current").removeClass("jBox-image-"+i+"-current").animate({opacity:0},"open"==t?0:this.options.imageFade),this.currentImage={gallery:i,id:o},jQuery("#jBox-image-"+i+"-"+o).length?(jQuery("#jBox-image-"+i+"-"+o).addClass("jBox-image-"+i+"-current").css({zIndex:this.imageZIndex++,opacity:0}).animate({opacity:1},"open"==t?0:this.options.imageFade),n(i,o)):(this.wrapper.addClass("jBox-image-loading"),jQuery('<img src="'+this.images[i][o].src+'"/>').each(function(){var t=new Image;t.onload=function(){e(i,o,!1),n(i,o),this.wrapper.removeClass("jBox-image-loading")}.bind(this),t.onerror=function(){e(i,o,!1,null,!0),n(i,o),this.wrapper.removeClass("jBox-image-loading")}.bind(this),t.src=this.images[i][o].src}.bind(this))),this.imageCounter&&(1<this.images[i].length?(this.wrapper.addClass("jBox-image-has-counter"),this.imageCounter.find(".jBox-image-counter-all").html(this.images[i].length),this.imageCounter.find(".jBox-image-counter-current").html(o+1)):this.wrapper.removeClass("jBox-image-has-counter")),this.images[i].length-1){var s=o+1;s=s>this.images[i].length-1?0:s<0?this.images[i].length-1:s,!jQuery("#jBox-image-"+i+"-"+s).length&&jQuery('<img src="'+this.images[i][s].src+'"/>').each(function(){var t=new Image;t.onload=function(){e(i,s,!0)}.bind(this),t.onerror=function(){e(i,s,!0,null,!0)}.bind(this),t.src=this.images[i][s].src}.bind(this))}}},_onCreated:function(){this.imageLabel=jQuery("<div/>",{class:"jBox-image-label-container"}).appendTo(this.wrapper),this.imageLabel.append(jQuery("<div/>",{class:"jBox-image-pointer-prev",click:function(){this.showImage("prev")}.bind(this)})).append(jQuery("<div/>",{class:"jBox-image-pointer-next",click:function(){this.showImage("next")}.bind(this)})),this.options.downloadButton&&(this.downloadButton=jQuery("<div/>",{class:"jBox-image-download-button-wrapper"}).appendTo(this.wrapper).append(this.options.downloadButtonText?jQuery("<div/>",{class:"jBox-image-download-button-text"}).html(this.options.downloadButtonText):null).append(jQuery("<div/>",{class:"jBox-image-download-button-icon"})).on("click touchdown",function(){if(this.images[this.currentImage.gallery][this.currentImage.id].downloadUrl)var t=this.images[this.currentImage.gallery][this.currentImage.id].downloadUrl;else t=this.wrapper.find(".jBox-image-default-current")[0].style.backgroundImage.slice(4,-1).replace(/["']/g,"");this.downloadImage(t)}.bind(this))),this.options.imageCounter&&(this.imageCounter=jQuery("<div/>",{class:"jBox-image-counter-container"}).appendTo(this.wrapper),this.imageCounter.append(jQuery("<span/>",{class:"jBox-image-counter-current"})).append(jQuery("<span/>").html(this.options.imageCounterSeparator)).append(jQuery("<span/>",{class:"jBox-image-counter-all"})))},_onOpen:function(){jQuery(document).on("keyup.jBox-Image-"+this.id,function(t){37==t.keyCode&&this.showImage("prev"),39==t.keyCode&&this.showImage("next")}.bind(this)),this.showImage("open")},_onClose:function(){jQuery(document).off("keyup.jBox-Image-"+this.id)},_onCloseComplete:function(){this.wrapper.find(".jBox-image-container").css("opacity",0)}})}),jQuery(document).ready(function(){new jBox.plugin("Notice",{color:null,stack:!0,stackSpacing:10,autoClose:6e3,attributes:{x:"right",y:"top"},position:{x:15,y:15},responsivePositions:{500:{x:5,y:5},768:{x:10,y:10}},target:window,fixed:!0,animation:"zoomIn",closeOnClick:"box",zIndex:12e3,_onInit:function(){this.defaultNoticePosition=jQuery.extend({},this.options.position),this._adjustNoticePositon=function(){var t=jQuery(window),o=t.width();t.height();this.options.position=jQuery.extend({},this.defaultNoticePosition),jQuery.each(this.options.responsivePositions,function(t,i){if(o<=t)return this.options.position=i,!1}.bind(this)),this.options.adjustDistance={top:this.options.position.y,right:this.options.position.x,bottom:this.options.position.y,left:this.options.position.x}},this.options.content instanceof jQuery&&(this.options.content=this.options.content.clone().attr("id","")),jQuery(window).on("resize.responsivejBoxNotice-"+this.id,function(t){this.isOpen&&this._adjustNoticePositon()}.bind(this)),this.open()},_onCreated:function(){this.wrapper.addClass("jBox-Notice-color jBox-Notice-"+(this.options.color||"gray")),this.wrapper.data("jBox-Notice-position",this.options.attributes.x+"-"+this.options.attributes.y)},_onOpen:function(){this.options.stack||(this._adjustNoticePositon(),jQuery.each(jQuery(".jBox-Notice"),function(t,i){(i=jQuery(i)).attr("id")!=this.id&&i.data("jBox-Notice-position")==this.options.attributes.x+"-"+this.options.attributes.y&&(this.options.stack||i.data("jBox").close({ignoreDelay:!0}))}.bind(this)))},_onPosition:function(){var s={};for(var t in jQuery.each(jQuery(".jBox-Notice"),function(t,i){var o=(i=jQuery(i)).data("jBox-Notice-position");s[o]||(s[o]=[]),s[o].push(i)}),s){var i=t.split("-")[1];s[t].reverse();var o=0;for(var e in s[t])el=s[t][e],el.css("margin-"+i,o),o+=el.outerHeight()+this.options.stackSpacing}},_onCloseComplete:function(){this.destroy(),this.options._onPosition.bind(this).call()}})});

// jQuery autoComplete v1.0.7
// https://github.com/Pixabay/jQuery-autoComplete
!function(e){e.fn.autoComplete=function(t){var o=e.extend({},e.fn.autoComplete.defaults,t);return"string"==typeof t?(this.each(function(){var o=e(this);"destroy"==t&&(e(window).off("resize.autocomplete",o.updateSC),o.off("blur.autocomplete focus.autocomplete keydown.autocomplete keyup.autocomplete"),o.data("autocomplete")?o.attr("autocomplete",o.data("autocomplete")):o.removeAttr("autocomplete"),e(o.data("sc")).remove(),o.removeData("sc").removeData("autocomplete"))}),this):this.each(function(){function t(e){var t=s.val();if(s.cache[t]=e,e.length&&t.length>=o.minChars){for(var a="",c=0;c<e.length;c++)a+=o.renderItem(e[c],t);s.sc.html(a),s.updateSC(0)}else s.sc.hide()}var s=e(this);s.sc=e('<div class="autocomplete-suggestions '+o.menuClass+'"></div>'),s.data("sc",s.sc).data("autocomplete",s.attr("autocomplete")),s.attr("autocomplete","off"),s.cache={},s.last_val="",s.updateSC=function(t,o){if(s.sc.css({top:s.offset().top+s.outerHeight(),left:s.offset().left,width:s.outerWidth()}),!t&&(s.sc.show(),s.sc.maxHeight||(s.sc.maxHeight=parseInt(s.sc.css("max-height"))),s.sc.suggestionHeight||(s.sc.suggestionHeight=e(".autocomplete-suggestion",s.sc).first().outerHeight()),s.sc.suggestionHeight))if(o){var a=s.sc.scrollTop(),c=o.offset().top-s.sc.offset().top;c+s.sc.suggestionHeight-s.sc.maxHeight>0?s.sc.scrollTop(c+s.sc.suggestionHeight+a-s.sc.maxHeight):0>c&&s.sc.scrollTop(c+a)}else s.sc.scrollTop(0)},e(window).on("resize.autocomplete",s.updateSC),s.sc.appendTo("body"),s.sc.on("mouseleave",".autocomplete-suggestion",function(){e(".autocomplete-suggestion.selected").removeClass("selected")}),s.sc.on("mouseenter",".autocomplete-suggestion",function(){e(".autocomplete-suggestion.selected").removeClass("selected"),e(this).addClass("selected")}),s.sc.on("mousedown click",".autocomplete-suggestion",function(t){var a=e(this),c=a.data("val");return(c||a.hasClass("autocomplete-suggestion"))&&(s.val(c),o.onSelect(t,c,a),s.sc.hide()),!1}),s.on("blur.autocomplete",function(){try{over_sb=e(".autocomplete-suggestions:hover").length}catch(t){over_sb=0}over_sb?s.is(":focus")||setTimeout(function(){s.focus()},20):(s.last_val=s.val(),s.sc.hide(),setTimeout(function(){s.sc.hide()},350))}),o.minChars||s.on("focus.autocomplete",function(){s.last_val="\n",s.trigger("keyup.autocomplete")}),s.on("keydown.autocomplete",function(t){if((40==t.which||38==t.which)&&s.sc.html()){var a,c=e(".autocomplete-suggestion.selected",s.sc);return c.length?(a=40==t.which?c.next(".autocomplete-suggestion"):c.prev(".autocomplete-suggestion"),a.length?(c.removeClass("selected"),s.val(a.addClass("selected").data("val"))):(c.removeClass("selected"),s.val(s.last_val),a=0)):(a=40==t.which?e(".autocomplete-suggestion",s.sc).first():e(".autocomplete-suggestion",s.sc).last(),s.val(a.addClass("selected").data("val"))),s.updateSC(0,a),!1}if(27==t.which)s.val(s.last_val).sc.hide();else if(13==t.which||9==t.which){var c=e(".autocomplete-suggestion.selected",s.sc);c.length&&s.sc.is(":visible")&&(o.onSelect(t,c.data("val"),c),setTimeout(function(){s.sc.hide()},20))}}),s.on("keyup.autocomplete",function(a){if(!~e.inArray(a.which,[13,27,35,36,37,38,39,40])){var c=s.val();if(c.length>=o.minChars){if(c!=s.last_val){if(s.last_val=c,clearTimeout(s.timer),o.cache){if(c in s.cache)return void t(s.cache[c]);for(var l=1;l<c.length-o.minChars;l++){var i=c.slice(0,c.length-l);if(i in s.cache&&!s.cache[i].length)return void t([])}}s.timer=setTimeout(function(){o.source(c,t)},o.delay)}}else s.last_val=c,s.sc.hide()}})})},e.fn.autoComplete.defaults={source:0,minChars:3,delay:150,cache:1,menuClass:"",renderItem:function(e,t){t=t.replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&");var o=new RegExp("("+t.split(" ").join("|")+")","gi");return'<div class="autocomplete-suggestion" data-val="'+e+'">'+e.replace(o,"<b>$1</b>")+"</div>"},onSelect:function(e,t,o){}}}(jQuery);

(function($) {
    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
		//$('.theme-main-wrapper').prepend('<div class="alsp-custom-popup-overlay"></div>');
		$('.isotope-item').addClass('zindex-0');
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 
       e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
		//$('.theme-main-wrapper div').remove(".alsp-custom-popup-overlay");
		$('.isotope-item').removeClass('zindex-0');
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
		
        e.preventDefault();
    });
	/* $('.alsp-custom-popup').on('click', function(e)  {
		$('.theme-main-wrapper div').remove(".alsp-custom-popup-overlay");
       // var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('.alsp-custom-popup').fadeOut(350);
		
        e.preventDefault();
    }); */


$('#number').toggle(function() {
    $(this).find('span.number-main').text( $(this).data('last') );
},function() {
    $(this).find('span.number-main').html( $(this).data('pre') );
});	
}(jQuery));
jQuery(window).load(function() {
	//alsp_equalColumnsHeight();
	alsp_equalColumnsHeightCat();
	isotop_load_fix_tab();
	//if ($(window).width() < 600) {
	//	$('.alsp-listings-grid').removeClass('masonry');
	//}
});
