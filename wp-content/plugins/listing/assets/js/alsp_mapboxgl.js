if (alsp_js_objects.is_maps_used) {
	var alsp_3rd_party_maps_plugin = false;
	var _warn = console.warn,
	    _error = console.error;
	console.error = function() {
	    if (typeof arguments[0].message != "undefined" && arguments[0].message) {
	    	alert(arguments[0].message);
	    }
	    return _error.apply(console, arguments);
	};
}

var alsp_draws = [];
var alsp_draw_features = [];

//mapboxgl_edit.js -------------------------------------------------------------------------------------------------------------------------------------------
(function($) {
	"use strict";

	window.alsp_load_maps_api_backend = function() {
		if ($("#alsp-maps-canvas").length) {
			mapboxgl.accessToken = alsp_maps_objects.mapbox_api_key;
			alsp_map_backend = new mapboxgl.Map({
			    container: "alsp-maps-canvas",
			    style: 'mapbox://styles/mapbox/'+alsp_maps_objects.map_style
			});
			var navigationControl = new mapboxgl.NavigationControl({
		        showCompass: false,
		        showZoom: true,
		    });
			alsp_map_backend.addControl(navigationControl);

			if (alsp_isAnyLocation_backend()) {
				alsp_generateMap_backend();
			} else {
				alsp_map_backend.setCenter([0, 34]);
			}

			alsp_map_backend.on('zoom', function() {
				if (alsp_allow_map_zoom_backend) {
					$(".alsp-map-zoom").val(Math.round(alsp_map_backend.getZoom()));
				}
			});
			
		}
		alsp_setupAutocomplete();
	}

	window.alsp_setupAutocomplete = function() {
		$(".alsp-field-autocomplete").address_autocomplete();
	}

	function alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2) {
		var count = 0;
		var bounds = new mapboxgl.LngLatBounds();
		for (count == 0; count<alsp_coords_array_1.length; count++)  {
			bounds.extend([alsp_coords_array_2[count], alsp_coords_array_1[count]]);
		}
		if (count == 1) {
			// required workaround: first zoom, then setCenter for initial load when single marker
			if ($(".alsp-map-zoom").val() == '' || $(".alsp-map-zoom").val() == 0) {
				var zoom_level = 1;
			} else {
				var zoom_level = parseInt($(".alsp-map-zoom").val());
			}
			
			// allow/disallow map zoom in listener, this option needs because alsp_map.setZoom() also calls this listener
			alsp_allow_map_zoom_backend = false;
			alsp_map_backend.setZoom(zoom_level);
			alsp_allow_map_zoom_backend = true;
			
			alsp_map_backend.setCenter([alsp_coords_array_2[0], alsp_coords_array_1[0]]);
		} else {
			alsp_map_backend.fitBounds(bounds, {padding: 50, duration: 0});
		}
	}
	
	var alsp_coords_array_1 = new Array();
	var alsp_coords_array_2 = new Array();
	var alsp_attempts = 0;
	window.alsp_generateMap_backend = function() {
		alsp_ajax_loader_target_show($("#alsp-maps-canvas"));
		alsp_coords_array_1 = new Array();
		alsp_coords_array_2 = new Array();
		alsp_attempts = 0;
		alsp_clearOverlays_backend();
		alsp_geocodeAddress_backend(0);
	}
	
	function alsp_setFoundPoint(point, location_obj, i) {
		$(".alsp-map-coords-1:eq("+i+")").val(point.lat);
		$(".alsp-map-coords-2:eq("+i+")").val(point.lng);
		var map_coords_1 = point.lat;
		var map_coords_2 = point.lng;
		alsp_coords_array_1.push(map_coords_1);
		alsp_coords_array_2.push(map_coords_2);
		location_obj.setPoint(point);
		location_obj.alsp_placeMarker();
		alsp_geocodeAddress_backend(i+1);

		if ((i+1) == $(".alsp-location-in-metabox").length) {
			alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2);
			alsp_ajax_loader_target_hide("alsp-maps-canvas");
		}
	}

	window.alsp_geocodeAddress_backend = function(i) {
		if ($(".alsp-location-in-metabox:eq("+i+")").length) {
			var locations_drop_boxes = [];
			$(".alsp-location-in-metabox:eq("+i+")").find("select").each(function(j, val) {
				if ($(this).val())
					locations_drop_boxes.push($(this).children(":selected").text());
			});
	
			var location_string = locations_drop_boxes.reverse().join(', ');
	
			if ($(".alsp-manual-coords:eq("+i+")").is(":checked") && $(".alsp-map-coords-1:eq("+i+")").val()!='' && $(".alsp-map-coords-2:eq("+i+")").val()!='' && ($(".alsp-map-coords-1:eq("+i+")").val()!=0 || $(".alsp-map-coords-2:eq("+i+")").val()!=0)) {
				var map_coords_1 = $(".alsp-map-coords-1:eq("+i+")").val();
				var map_coords_2 = $(".alsp-map-coords-2:eq("+i+")").val();
				if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
					var point = new mapboxgl.LngLat(map_coords_2, map_coords_1);
					alsp_coords_array_1.push(map_coords_1);
					alsp_coords_array_2.push(map_coords_2);
	
					var location_obj = new alsp_glocation_backend(i, point, 
						location_string,
						$(".alsp-address-line-1:eq("+i+")").val(),
						$(".alsp-address-line-2:eq("+i+")").val(),
						$(".alsp-zip-or-postal-index:eq("+i+")").val(),
						$(".alsp-map-icon-file:eq("+i+")").val()
					);
					location_obj.alsp_placeMarker();
				}
				alsp_geocodeAddress_backend(i+1);
				if ((i+1) == $(".alsp-location-in-metabox").length) {
					alsp_setMapCenter_backend(alsp_coords_array_1, alsp_coords_array_2);
					alsp_ajax_loader_target_hide("alsp-maps-canvas");
				}
			} else if (location_string || $(".alsp-address-line-1:eq("+i+")").val() || $(".alsp-address-line-2:eq("+i+")").val() || $(".alsp-zip-or-postal-index:eq("+i+")").val()) {
				var location_obj = new alsp_glocation_backend(i, null, 
					location_string,
					$(".alsp-address-line-1:eq("+i+")").val(),
					$(".alsp-address-line-2:eq("+i+")").val(),
					$(".alsp-zip-or-postal-index:eq("+i+")").val(),
					$(".alsp-map-icon-file:eq("+i+")").val()
				);

				// Geocode by address
				function _alsp_geocodeAddress_backend(status, lat, lng) {
					if (status) {
						alsp_setFoundPoint(new mapboxgl.LngLat(lng, lat), location_obj, i);
					} else {
						alert("Sorry, we are unable to geocode that address (address #"+(i)+") for the following reason: " + status);
						alsp_ajax_loader_target_hide("alsp-maps-canvas");
					}
				}

				alsp_geocodeAddress(location_obj.compileAddress(), _alsp_geocodeAddress_backend, alsp_maps_objects.address_autocomplete_code);
			} else
				alsp_ajax_loader_target_hide("alsp-maps-canvas");
		}
	}

	window.alsp_placeMarker_backend = function(alsp_glocation) {
		if (alsp_maps_objects.map_markers_type != 'icons') {
			if (alsp_maps_objects.global_map_icons_path != '') {
				var re = /(?:\.([^.]+))?$/;
				if (alsp_glocation.map_icon_file && typeof re.exec(alsp_maps_objects.global_map_icons_path+'icons/'+alsp_glocation.map_icon_file)[1] != "undefined")
					var icon_file = alsp_maps_objects.global_map_icons_path+'icons/'+alsp_glocation.map_icon_file;
				else
					var icon_file = alsp_maps_objects.global_map_icons_path+"blank.png";

				var el = $("<div>", {
					id: 'marker-id-'+alsp_glocation.index,
					style: 'background-image: url('+icon_file+'); width: '+parseInt(alsp_maps_objects.marker_image_width)+'px; height: '+parseInt(alsp_maps_objects.marker_image_height)+'px',
					class: 'alsp-mapbox-marker'
				});
				var marker_div = el[0];
				
				var marker_options = {
						anchor: 'bottom',
						offset: [0, -20],
						element: marker_div,
						draggable: true
				};
				
				var popup = new mapboxgl.Popup({ offset: 25 })
			    .setText(alsp_glocation.compileAddress());
				
				var marker = new mapboxgl.Marker(marker_options)
	    		.setLngLat(alsp_glocation.point)
	    		.addTo(alsp_map_backend)
	    		.setPopup(popup);
			} else {
				var marker = new mapboxgl.Marker()
	    		.setLngLat(location.point)
	    		.addTo(alsp_map_backend);
			}
		} else {
			var map_marker_color = alsp_maps_objects.default_marker_color;

			if (typeof alsp_glocation.map_icon_file == 'string' && alsp_glocation.map_icon_file.indexOf("alsp-fa-") != -1) {
				var map_marker_icon = '<span class="alsp-map-marker-icon alsp-fa '+alsp_glocation.map_icon_file+'" style="color: '+map_marker_color+';"></span>';
				var map_marker_class = 'alsp-map-marker';
			} else {
				if (alsp_maps_objects.default_marker_icon) {
					var map_marker_icon = '<span class="alsp-map-marker-icon alsp-fa '+alsp_maps_objects.default_marker_icon+'" style="color: '+map_marker_color+';"></span>';
					var map_marker_class = 'alsp-map-marker';
				} else {
					var map_marker_icon = '';
					var map_marker_class = 'alsp-map-marker-empty';
				}
			}

			var el = $("<div>", {
				id: 'marker-id-'+alsp_glocation.index,
				class: 'alsp-mapbox-marker',
				html: '<div class="'+map_marker_class+'" style="background: '+map_marker_color+' none repeat scroll 0 0;">'+map_marker_icon+'</div>'
			});
			var marker_div = el[0];
			
			var marker_options = {
				anchor: 'bottom',
				offset: [0, -20],
				element: marker_div,
				draggable: true
			};
			
			var popup = new mapboxgl.Popup({ offset: 25 })
		    .setText(alsp_glocation.compileAddress());

			var marker = new mapboxgl.Marker(marker_options)
    		.setLngLat(alsp_glocation.point)
    		.addTo(alsp_map_backend)
    		.setPopup(popup);
		}
		
		alsp_markersArray_backend.push(marker);
		
		marker.on('drag', function() {
			var point = marker.getLngLat();
			if (point !== undefined) {
				var selected_location_num = alsp_glocation.index;
				$(".alsp-manual-coords:eq("+alsp_glocation.index+")").attr("checked", true);
				$(".alsp-manual-coords:eq("+alsp_glocation.index+")").parents(".alsp-manual-coords-wrapper").find(".alsp-manual-coords-block").show(200);
				
				$(".alsp-map-coords-1:eq("+alsp_glocation.index+")").val(point.lat);
				$(".alsp-map-coords-2:eq("+alsp_glocation.index+")").val(point.lng);
			}
		});
	}

	function alsp_clearOverlays_backend() {
		if (alsp_markersArray_backend) {
			for(var i = 0; i<alsp_markersArray_backend.length; i++){
				alsp_markersArray_backend[i].remove();
			}
		}
	}
	
	function alsp_isAnyLocation_backend() {
		var is_location = false;
		$(".alsp-location-in-metabox").each(function(i, val) {
			var locations_drop_boxes = [];
			$(this).find("select").each(function(j, val) {
				if ($(this).val()) {
					is_location = true;
					return false;
				}
			});
	
			if ($(".alsp-manual-coords:eq("+i+")").is(":checked") && $(".alsp-map-coords-1:eq("+i+")").val()!='' && $(".alsp-map-coords-2:eq("+i+")").val()!='' && ($(".alsp-map-coords-1:eq("+i+")").val()!=0 || $(".alsp-map-coords-2:eq("+i+")").val()!=0)) {
				is_location = true;
				return false;
			}
		});
		if (is_location)
			return true;
	
		if ($(".alsp-address-line-1[value!='']").length != 0)
			return true;
	
		if ($(".alsp-address-line-2[value!='']").length != 0)
			return true;
	
		if ($(".alsp-zip-or-postal-index[value!='']").length != 0)
			return true;
	}
})(jQuery);

(function($) {
	"use strict";
	
	window.alsp_buildPoint = function(lat, lng) {
		return [lng, lat];
	}

	window.alsp_buildBounds = function() {
		return new mapboxgl.LngLatBounds();
	}

	window.alsp_extendBounds = function(bounds, point) {
		bounds.extend(point);
	}

	window.alsp_mapFitBounds = function(map_id, bounds) {
		alsp_maps[map_id].fitBounds(bounds, {padding: 50, duration: 0});
	}

	window.alsp_getMarkerPosition = function(marker) {
		return marker.getLngLat();
	}

	window.alsp_closeInfoWindow = function(map_id) {
		if (typeof alsp_infoWindows[map_id] != 'undefined') {
			alsp_infoWindows[map_id].remove();
		}
	}
	
	class alsp_point {
		constructor(lng, lat) {
			this.coord_1 = lng;
			this.coord_2 = lat;
		}
		lng() {
			return this.coord_1;
		}
		lat() {
			return this.coord_2;
		}
	}

	window.alsp_setAjaxMarkersListener = function(map_id) {
		alsp_setMapAjaxListener(alsp_maps[map_id], map_id);
	}
	
	window.alsp_geocodeAddress = function(address, callback, address_autocomplete_code) {
		if (typeof address_autocomplete_code != 'undefined' && address_autocomplete_code != '')
			var country = '&country='+address_autocomplete_code;
		else
			var country = '';

		$.get("https://api.mapbox.com/geocoding/v5/mapbox.places/"+encodeURIComponent(address)+".json?access_token="+alsp_maps_objects.mapbox_api_key+country, function(data) {
			if (data.features.length) {
				// data.features[0].geometry.coordinates[0] - longitude
				// data.features[0].geometry.coordinates[1] - latitude
				callback(true, data.features[0].geometry.coordinates[1], data.features[0].geometry.coordinates[0]);
			} else {
				callback(false, 0, 0);
			}
		}).fail(function() {
			callback(false, 0, 0);
		});
	}
	
	window.alsp_callMapResize = function(map_id) {
		alsp_maps[map_id].resize();
	}

	window.alsp_setMapCenter = function(map_id, center) {
		alsp_maps[map_id].setCenter(center);
	}
	
	window.alsp_setMapZoom = function(map_id, zoom) {
		alsp_maps[map_id].setZoom(parseInt(zoom));
	}

	window.alsp_autocompleteService = function(term, address_autocomplete_code, common_array, response, callback) {
		if (address_autocomplete_code != '')
			var country = '&country='+address_autocomplete_code;
		else
			var country = '';

		var output_predictions = [];
		$.get("https://api.mapbox.com/geocoding/v5/mapbox.places/"+encodeURIComponent(term)+".json?access_token="+alsp_maps_objects.mapbox_api_key+country, function(data) {
			$.map(data.features, function (prediction, i) {
				var output_prediction = {
						label: prediction.text,
						value: prediction.place_name,
						name: prediction.place_name,
						sublabel: prediction.place_name.replace(prediction.text + ", ", ""),
				};
				output_predictions.push(output_prediction);
			});
			
			callback(output_predictions, common_array, response);
		}).fail(function() {
			callback(output_predictions, common_array, response);
		});;
	}
	
	function alsp_addPolygon(map_id) {
		var map = alsp_maps[map_id];
		
		map.addSource('geo-poly-'+map_id, {
			'type': 'geojson',
			'data': alsp_draw_features[map_id]
		});
		map.addLayer({
			'id': 'geo-poly-'+map_id,
			'type': 'fill',
			'source': 'geo-poly-'+map_id,
			'layout': {},
			'paint': {
				'fill-color': '#0099FF',
				'fill-opacity': 0.3,
				'fill-outline-color': '#AA2143'
			}
		});

		alsp_polygons[map_id] = true;
	}
	
	function alsp_drawFreeHandPolygon(map_id) {
		var geojson = {
				"type": "FeatureCollection",
				"features": []
		};

		var linestring = {
				"type": "Feature",
				"geometry": {
					"type": "LineString",
					"coordinates": []
				}
		};
		
		var map = alsp_maps[map_id];

		map.addSource('geo-lines', {
			"type": "geojson",
			"data": geojson
		});

	    map.addLayer({
	        id: 'geo-lines',
	        type: 'line',
	        source: 'geo-lines',
	        layout: {
	            'line-cap': 'round',
	            'line-join': 'round'
	        },
	        paint: {
	            'line-color': '#AA2143',
	            'line-width': 2
	        },
	        filter: ['in', '$type', 'LineString']
	    });

	    var draw_move_event = function(e) {
	    	var features = map.queryRenderedFeatures(e.point, { layers: ['geo-lines'] });

	        // Remove the linestring from the group
	        // So we can redraw it based on the points collection
	        if (geojson.features.length > 1) geojson.features.pop();

	        var point = {
	        		"type": "Feature",
	                "geometry": {
	                    "type": "Point",
	                    "coordinates": [
	                        e.lngLat.lng,
	                        e.lngLat.lat
	                    ]
	                },
	                "properties": {
	                    "id": String(new Date().getTime())
	                }
	        };

	        geojson.features.push(point);

	        if (geojson.features.length > 1) {
	            linestring.geometry.coordinates = geojson.features.map(function(point) {
	                return point.geometry.coordinates;
	            });

	            geojson.features.push(linestring);
	        }

	        map.getSource('geo-lines').setData(geojson);
	    };
	    map.on('mousemove', draw_move_event);
	    map.on('touchmove', draw_move_event);
	    
	    var draw_up_event = function(e) {
	    	map.off('mousemove', draw_move_event);
	    	map.off('touchmove', draw_move_event);
	    	map.removeLayer('geo-lines');
	    	map.removeSource('geo-lines');

	    	var theArrayofLngLat = [];
	    	linestring.geometry.coordinates.map(function(point_feature) {
	    		theArrayofLngLat.push(new alsp_point(point_feature[0], point_feature[1]));
	    	});
			var ArrayforPolygontoUse = alsp_GDouglasPeucker(theArrayofLngLat, 1);
			
			var geo_poly_json = [];
			var geo_poly_ajax = [];
			if (ArrayforPolygontoUse.length) {
				var lat_lng;
				for (lat_lng in ArrayforPolygontoUse) {
					geo_poly_json.push([ArrayforPolygontoUse[lat_lng].lng(), ArrayforPolygontoUse[lat_lng].lat()]);
					geo_poly_ajax.push({ 'lat': ArrayforPolygontoUse[lat_lng].lat(), 'lng': ArrayforPolygontoUse[lat_lng].lng() });
				}
				geo_poly_json.push([ArrayforPolygontoUse[0].lng(), ArrayforPolygontoUse[0].lat()]);
			}

			if (geo_poly_json.length) {
				alsp_sendGeoPolyAJAX(map_id, geo_poly_ajax);
				
				var geo_poly_feature = {
						'id': 'geo-poly-feature-'+map_id,
						'type': 'Feature',
						'properties': {},
		                'geometry': {
		                    'type': 'Polygon',
		                    'coordinates': [geo_poly_json]
		                }
				};
				
				alsp_draw_features[map_id] = geo_poly_feature;
				
				alsp_addPolygon(map_id);
				
				var editButton = $(map.getContainer()).find('.alsp-map-edit').get(0);
				$(editButton).removeAttr('disabled');
			}
			var drawButton = $(map.getContainer()).find('.alsp-map-draw').get(0);
			drawButton.drawing_state = 0;
			window.removeEventListener('touchmove', alsp_stop_touchmove_listener, { passive: false });
			map.getCanvas().style.cursor = '';
			$(drawButton).removeClass('btn-active');
			alsp_disableDrawingMode(map_id);
	    };
		map.once('mouseup', draw_up_event); 
		map.once('touchend', draw_up_event); 
	}
	function alsp_enableDrawingMode(map_id) {
		$(alsp_maps[map_id].getContainer()).find('.alsp-map-custom-controls').hide();
		// if sidebar was not opened - hide search field
		if (!alsp_isSidebarOpen(map_id) && $('#alsp-map-search-wrapper-'+map_id).length) {
			$('#alsp-map-search-wrapper-'+map_id).hide();
		}
		var map = alsp_maps[map_id];

		map.scrollZoom.disable();
		map.dragRotate.disable();
		map.touchZoomRotate.disable();
		map.dragPan.disable();
	}
	function alsp_disableDrawingMode(map_id) {
		var map = alsp_maps[map_id];

		$(map.getContainer()).find('.alsp-map-custom-controls').show();
		if ($('#alsp-map-search-wrapper-'+map_id).length) $('#alsp-map-search-wrapper-'+map_id).show();

		var attrs_array = alsp_get_map_markers_attrs_array(map_id);
		var enable_wheel_zoom = attrs_array.enable_wheel_zoom;
		var enable_dragging_touchscreens = attrs_array.enable_dragging_touchscreens;
		if (enable_dragging_touchscreens || !('ontouchstart' in document.documentElement)) {
			map.dragRotate.enable();
			map.dragPan.enable();
			map.touchZoomRotate.enable();
		}
		if (enable_wheel_zoom) {
			map.scrollZoom.enable();
		}
	}
	
	window.alsp_setMapZoomCenter = function(map_id, map_attrs, markers_array) {
		if (typeof map_attrs.start_zoom != 'undefined' && map_attrs.start_zoom > 0)
			var zoom_level = map_attrs.start_zoom;
	    else if (markers_array.length == 1)
			var zoom_level = markers_array[0][5];
		else if (markers_array.length > 1)
			// fitbounds does not need zoom
			var zoom_level = false;
		else
			var zoom_level = 2;
	
	    if (typeof map_attrs.start_latitude != 'undefined' && map_attrs.start_latitude && typeof map_attrs.start_longitude != 'undefined' && map_attrs.start_longitude) {
			var start_latitude = map_attrs.start_latitude;
			var start_longitude = map_attrs.start_longitude;
			if (zoom_level == false) {
				zoom_level = 12;
			}
			// required workaround: first zoom, then setCenter
			alsp_setMapZoom(map_id, zoom_level);
			alsp_setMapCenter(map_id, [start_longitude, start_latitude]);
			
			if (typeof map_attrs.ajax_loading != 'undefined' && map_attrs.ajax_loading == 1) {
			    // use closures here
			    alsp_setMapAjaxListener(alsp_maps[map_id], map_id);
			}
	    } else if (typeof map_attrs.start_address != 'undefined' && map_attrs.start_address) {
	    	// use closures here
	    	alsp_geocodeStartAddress(map_attrs, map_id, zoom_level);
	    } else if (markers_array.length == 1) {
	    	alsp_setMapZoom(map_id, zoom_level);
		} else if (zoom_level) {
			// no fitbounds here
			// required workaround: first zoom, then setCenter for initial load when single marker
		    alsp_setMapZoom(map_id, zoom_level);
		    alsp_setMapCenter(map_id, [34, 0]);
		}
    }

	window.alsp_show_on_map_links = function() {
		$(".alsp-show-on-map").each(function() {
			var location_id = $(this).data("location-id");

			var passed = false;
			for (var map_id in alsp_maps) {
				if (typeof alsp_global_locations_array[map_id] != 'undefined') {
					for (var i=0; i<alsp_global_locations_array[map_id].length; i++) {
						if (typeof alsp_global_locations_array[map_id][i] == 'object') {
							if (location_id == alsp_global_locations_array[map_id][i].id) {
								passed = true;
							}
						}
					}
				}
			}
			if (passed) {
				$(this).parent('.alsp-listing-figcaption-option').show();
			} else {
				$(this).css({'cursor': 'auto'});
				if ($(this).hasClass('btn')) {
					$(this).hide();
				}
			}
		});
	}

	function alsp_load_maps() {
		for (var i=0; i<alsp_map_markers_attrs_array.length; i++) {
			if (typeof alsp_maps[alsp_map_markers_attrs_array[i].map_id] == 'undefined') { // workaround for "tricky" themes and plugins to load maps twice
				alsp_load_map(i);
			}
		}

		alsp_show_on_map_links();
		
		alsp_geolocatePosition();
	}

	window.alsp_load_maps_api = function() {
		$(document).trigger('alsp_mapbox_api_loaded');

		// are there any markers?
		if (typeof alsp_map_markers_attrs_array != 'undefined' && alsp_map_markers_attrs_array.length) {
			_alsp_map_markers_attrs_array = JSON.parse(JSON.stringify(alsp_map_markers_attrs_array));

			alsp_load_maps();
		}

		alsp_load_ajax_initial_elements();
		
		$(".alsp-field-autocomplete").address_autocomplete();
		
		$('body').on('click', '.alsp-show-on-map', function() {
			var location_id = $(this).data("location-id");

			for (var map_id in alsp_maps) {
				if (typeof alsp_global_locations_array[map_id] != 'undefined') {
					for (var i=0; i<alsp_global_locations_array[map_id].length; i++) {
						if (typeof alsp_global_locations_array[map_id][i] == 'object') {
							if (location_id == alsp_global_locations_array[map_id][i].id) {
								var location_obj = alsp_global_locations_array[map_id][i];
								var side_offset = 0;
								if ($("#alsp-maps-canvas-"+map_id).hasClass("alsp-sidebar-open")) {
									if (alsp_js_objects.is_rtl) {
										side_offset = 200;
									} else {
										side_offset = -200;
									}
								}
								alsp_maps[map_id].panToWithOffset(location_obj.marker.getLngLat(), side_offset, -100);
								alsp_setInfoWindow(location_obj, location_obj.marker, map_id, 'bottom', 'onbuttonclick');
							}
						}
					}
				}
			}
		});
	}

	document.addEventListener("DOMContentLoaded", function() {
		window[alsp_maps_callback.callback]();
	});
	
	function alsp_positionCustomControls(map_id, customControls) {
		var mapDiv = alsp_maps[map_id].getContainer();
	    if ($(mapDiv).parent().hasClass('alsp-map-search-input-enabled') && $(mapDiv).width() <= 500) {
	    	$(customControls).addClass('alsp-map-custom-controls-lower');
	    } else {
	    	$(customControls).removeClass('alsp-map-custom-controls-lower');
	    }
	}

	function alsp_load_map(i) {
		var map_id = alsp_map_markers_attrs_array[i].map_id;
		var markers_array = alsp_map_markers_attrs_array[i].markers_array;
		var enable_radius_circle = alsp_map_markers_attrs_array[i].enable_radius_circle;
		var enable_clusters = alsp_map_markers_attrs_array[i].enable_clusters;
		var show_summary_button = alsp_map_markers_attrs_array[i].show_summary_button;
		var map_style = alsp_map_markers_attrs_array[i].map_style;
		var draw_panel = alsp_map_markers_attrs_array[i].draw_panel;
		var show_readmore_button = alsp_map_markers_attrs_array[i].show_readmore_button;
		var enable_full_screen = alsp_map_markers_attrs_array[i].enable_full_screen;
		var enable_wheel_zoom = alsp_map_markers_attrs_array[i].enable_wheel_zoom;
		var enable_dragging_touchscreens = alsp_map_markers_attrs_array[i].enable_dragging_touchscreens;
		var show_directions = alsp_map_markers_attrs_array[i].show_directions;
		var map_attrs = alsp_map_markers_attrs_array[i].map_attrs;
		if (document.getElementById("alsp-maps-canvas-"+map_id)) {
			if (typeof alsp_fullScreens[map_id] == "undefined" || !alsp_fullScreens[map_id]) {
				
				if (typeof alsp_maps[map_id] != 'undefined') {
					alsp_maps[map_id].remove();
				}
				
				mapboxgl.accessToken = alsp_maps_objects.mapbox_api_key;
				var map = new mapboxgl.Map({
				    container: "alsp-maps-canvas-"+map_id,
				    style: 'mapbox://styles/mapbox/'+map_style
				});
				if (!enable_wheel_zoom) {
					map.scrollZoom.disable();
				}

				alsp_maps[map_id] = map;
			    alsp_maps_attrs[map_id] = map_attrs;
			    
			    if (show_directions) {
					var directions = new MapboxDirections({
					    accessToken: mapboxgl.accessToken
					});
					
					if (alsp_js_objects.is_rtl) {
						var cposition = 'top-right';
					} else {
						var cposition = 'top-left';
					}
					map.addControl(directions, cposition);
				}

			    class alsp_custom_controls {
					  onAdd(map){
					    this.map = map;

					    var customControls = document.createElement('div');
					    $(customControls).addClass('mapboxgl-ctrl alsp-map-custom-controls');
					    $(customControls).html('<div class="btn-group"><button class="btn btn-primary alsp-map-btn-zoom-in"><span class="glyphicon glyphicon-plus"></span></button><button class="btn btn-primary alsp-map-btn-zoom-out"><span class="glyphicon glyphicon-minus"></span></button></div> <div class="btn-group">'+(enable_full_screen ? '<button class="btn btn-primary alsp-map-btn-fullscreen"><span class="glyphicon glyphicon-fullscreen"></span></button>' : '')+'</div>');
					    
					    alsp_positionCustomControls(map_id, customControls);
					    map.on('resize', function() {
					    	alsp_positionCustomControls(map_id, customControls);
					    });
					    
					    this.container = customControls;
					    return this.container;
					  }
					  onRemove(){
					    this.container.parentNode.removeChild(this.container);
					    this.map = undefined;
					  }
				}
				var customControls = new alsp_custom_controls();
				
				if (alsp_js_objects.is_rtl) {
					var cposition = 'top-left';
				} else {
					var cposition = 'top-right';
				}
				map.addControl(customControls, cposition);
				
				$(customControls.container).find('.alsp-map-btn-zoom-in').on("click", function() {
			    	alsp_maps[map_id].zoomIn();
			    });
			    $(customControls.container).find('.alsp-map-btn-zoom-out').on("click", function() {
			    	alsp_maps[map_id].zoomOut();
			    });
				
			    var interval;
			    var mapDiv = alsp_maps[map_id].getContainer();
			    var mapDivParent = $(mapDiv).parent().parent();
			    var divStyle = mapDiv.style;
			    if (mapDiv.runtimeStyle)
			        divStyle = mapDiv.runtimeStyle;
			    var originalPos = divStyle.position;
			    var originalWidth = divStyle.width;
			    var originalHeight = divStyle.height;
			    // ie8 hack
			    if (originalWidth === "")
			        originalWidth = mapDiv.style.width;
			    if (originalHeight === "")
			        originalHeight = mapDiv.style.height;
			    var originalTop = divStyle.top;
			    var originalLeft = divStyle.left;
			    var originalZIndex = divStyle.zIndex;
			    var bodyStyle = document.body.style;
			    if (document.body.runtimeStyle)
			        bodyStyle = document.body.runtimeStyle;
			    var originalOverflow = bodyStyle.overflow;
			    var thePanoramaOpened = false;

			    //alsp_fullScreens[map_id] = true;
			    //openFullScreen();

			    function openFullScreen() {
			    	mapDivParent.after("<div id='alsp-map-placeholder-"+map_id+"'></div>");
			    	mapDivParent.appendTo('body');
			    	
			    	var elements_to_zindex = [
			                                  "#alsp-map-search-wrapper-"+map_id,
			                                  "#alsp-map-search-panel-wrapper-"+map_id,
			                                  "#alsp-map-sidebar-toggle-container-"+map_id,
			        ];
			        $(elements_to_zindex).each(function() {
			        	if ($(this).length) {
			        		$(this).css('position', 'fixed').zIndex(100001);
			        	}
			        });
			    	
			    	var center = alsp_maps[map_id].getCenter();
			        mapDiv.style.position = "fixed";
			        mapDiv.style.width = "100%";
			        mapDiv.style.height = "100%";
			        mapDiv.style.top = "0";
			        mapDiv.style.left = "0";
			        mapDiv.style.zIndex = "100000";
			        $(mapDiv).parent(".alsp-maps-canvas-wrapper").zIndex(100000).css('overflow', 'initial');
			        document.body.style.overflow = "hidden";
			        $(customControls.container).find('.alsp-map-btn-fullscreen span').removeClass('glyphicon-fullscreen');
			        $(customControls.container).find('.alsp-map-btn-fullscreen span').addClass('glyphicon-resize-small');
			        
			        alsp_callMapResize(map_id);
			        alsp_setMapCenter(map_id, center);
			        
			        
			        
			        $(window).trigger('resize');
			        if ($(".alsp-map-listings-panel").length) {
			        	$(".alsp-map-listings-panel").getNiceScroll().resize();
			        }
			    }
			    function closeFullScreen() {
			    	$('#alsp-map-placeholder-'+map_id).after(mapDivParent);
			    	$('#alsp-map-placeholder-'+map_id).detach();
			    	
			    	var elements_to_zindex = [
			                                  "#alsp-map-search-wrapper-"+map_id,
			                                  "#alsp-map-search-panel-wrapper-"+map_id,
			                                  "#alsp-map-sidebar-toggle-container-"+map_id,
			        ];
			        $(elements_to_zindex).each(function() {
			        	if ($(this).length) {
			        		$(this).css('position', 'absolute').zIndex(1);
			        	}
			        });
			    	
		            if (originalPos === "") {
		                mapDiv.style.position = "relative";
		            } else {
		                mapDiv.style.position = originalPos;
		            }
		            var center = alsp_maps[map_id].getCenter();
		            mapDiv.style.width = originalWidth;
		            mapDiv.style.height = originalHeight;
		            mapDiv.style.top = originalTop;
		            mapDiv.style.left = originalLeft;
		            mapDiv.style.zIndex = originalZIndex;
		            $(mapDiv).parent(".alsp-maps-canvas-wrapper").zIndex(originalZIndex).css('overflow', 'hidden');;
		            document.body.style.overflow = originalOverflow;
		            $(customControls.container).find('.alsp-map-btn-fullscreen span').removeClass('glyphicon-resize-small');
			        $(customControls.container).find('.alsp-map-btn-fullscreen span').addClass('glyphicon-fullscreen');

			        alsp_callMapResize(map_id);
			        alsp_setMapCenter(map_id, center);
		            
			        $(window).trigger('resize');
			        if ($(".alsp-map-listings-panel").length) {
			        	$(".alsp-map-listings-panel").getNiceScroll().resize();
			        }
			    }
			    if (enable_full_screen) {
			    	$(customControls.container).find('.alsp-map-btn-fullscreen').on("click", function() {
				    	if (typeof alsp_fullScreens[map_id] == "undefined" || !alsp_fullScreens[map_id]) {
				    		$("#alsp-maps-canvas-wrapper-"+map_id).addClass("alsp-map-full-screen");
				    		alsp_fullScreens[map_id] = true;
				    		openFullScreen();
				    	} else {
				    		$("#alsp-maps-canvas-wrapper-"+map_id).removeClass("alsp-map-full-screen");
				    		alsp_fullScreens[map_id] = false;
				    		closeFullScreen();
				    	}
				    });
				    $(document).on("keyup", function(e) {
				    	if (typeof alsp_fullScreens[map_id] != "undefined" && alsp_fullScreens[map_id] && e.keyCode == 27) {
				    		$("#alsp-maps-canvas-wrapper-"+map_id).removeClass("alsp-map-full-screen");
				    		alsp_fullScreens[map_id] = false;
				    		closeFullScreen();
				    	}
				    });
			    }

			    if (draw_panel) {
				    var drawPanel = document.createElement('div');
				    $(drawPanel).addClass('alsp-map-draw-panel');

				    class alsp_dummy_control {
				    	constructor(drawPanel) {
				    		this.drawPanel = drawPanel;
				    	}
				    	onAdd(map){
						    this.map = map;

						    var customControls = document.createElement('div');
						    $(customControls).addClass('mapboxgl-ctrl alsp-map-draw-panel');
						    customControls.appendChild(this.drawPanel);
						    
						    this.container = customControls;
						    return this.container;
						  }
						  onRemove(){
						    this.container.parentNode.removeChild(this.container);
						    this.map = undefined;
						  }
					}
					var dummyDiv = new alsp_dummy_control(drawPanel);
					map.addControl(dummyDiv, cposition);

				    var drawButton = document.createElement('button');
				    $(drawButton)
				    .addClass('btn btn-primary alsp-map-draw')
				    .attr("title", alsp_maps_objects.draw_area_button)
				    .html('<span class="glyphicon glyphicon-pencil"></span>');
				    
				    drawPanel.appendChild(drawButton);
				    drawButton.map_id = map_id;
					drawButton.drawing_state = 0;
					$(drawButton).on("click", function(e) {
						var map_id = drawButton.map_id;
						if (this.drawing_state == 0) {
							this.drawing_state = 1;
							window.addEventListener('touchmove', alsp_stop_touchmove_listener, { passive: false });
							alsp_clearMarkers(map_id);
							alsp_closeInfoWindow(map_id);
							alsp_removeShapes(map_id);
		
							alsp_enableDrawingMode(map_id);
							
							var editButton = $(alsp_maps[map_id].getContainer()).find('.alsp-map-edit').get(0);
							$(editButton).removeClass('btn-active');
							$(editButton).attr('disabled', 'disabled');
							$(editButton).find('.alsp-map-edit-label').text(alsp_maps_objects.edit_area_button);
							editButton.editing_state = 0;
		
							// remove ajax_loading and set drawing_state
							var map_attrs_array;
							if (map_attrs_array = alsp_get_map_markers_attrs_array(map_id)) {
								map_attrs_array.map_attrs.drawing_state = 1;
								delete map_attrs_array.map_attrs.ajax_loading;
							}
			
							alsp_maps[map_id].getCanvas().style.cursor = 'crosshair';
							$(this).toggleClass('btn-active');

							alsp_maps[map_id].getContainer().map_id = map_id;
							
							var draw_down_event = function(e) {
								var el = e.target;
			                    do {
			                        if ($(el).hasClass('alsp-map-draw-panel')) {
			                            return;
			                        }
			                    } while (el = el.parentNode);
								alsp_drawFreeHandPolygon(map_id);
							};
							
							alsp_maps[map_id].once('mousedown', draw_down_event);
							alsp_maps[map_id].once('touchstart', draw_down_event);
						} else if (this.drawing_state == 1) {
							this.drawing_state = 0;
							window.removeEventListener('touchmove', alsp_stop_touchmove_listener, { passive: false });
							map.getCanvas().style.cursor = '';
							$(drawButton).removeClass('btn-active');
							alsp_disableDrawingMode(map_id);

							// repair ajax_loading and set drawing_state
							var map_attrs_array;
							if (map_attrs_array = alsp_get_map_markers_attrs_array(map_id)) {
								map_attrs_array.map_attrs.drawing_state = 0;
								if (typeof alsp_get_original_map_markers_attrs_array(map_id).map_attrs.ajax_loading != 'undefined' && alsp_get_original_map_markers_attrs_array(map_id).map_attrs.ajax_loading == 1) {
									map_attrs_array.map_attrs.ajax_loading = 1;
								}
							}
						}
					});
				    
				    var editButton = document.createElement('button');
				    $(editButton)
				    .addClass('btn btn-primary alsp-map-edit')
				    .attr("title", alsp_maps_objects.edit_area_button)
				    .html('<span class="glyphicon glyphicon-edit"></span>')
				    .attr('disabled', 'disabled');
				    
				    drawPanel.appendChild(editButton);
				    editButton.map_id = map_id;
				    editButton.editing_state = 0;
				    $(editButton).on("click", function(e) {
				    	var map_id = editButton.map_id;
						if (this.editing_state == 0) {
							this.editing_state = 1;
							$(this).toggleClass('btn-active');
							$(this).attr("title", alsp_maps_objects.apply_area_button);

							alsp_removeShapes(map_id);

							var draw = new MapboxDraw({
								displayControlsDefault: false,
								styles: [
										// line stroke
										{
											"id": "gl-draw-line",
											"type": "line",
											"filter": ["all", ["==", "$type", "LineString"], ["!=", "mode", "static"]],
											"layout": {
												"line-cap": "round",
												"line-join": "round"
											},
											"paint": {
												"line-color": "#AA2143",
												"line-dasharray": [0.2, 2],
												"line-width": 1
											}
										},
										// polygon fill
										{
											"id": "gl-draw-polygon-fill",
											"type": "fill",
											"filter": ["all", ["==", "$type", "Polygon"], ["!=", "mode", "static"]],
											"paint": {
												"fill-color": "#0099FF",
												"fill-outline-color": "#AA2143",
												"fill-opacity": 0.3
											}
										},
										// vertex point halos
										{
											"id": "gl-draw-polygon-and-line-vertex-halo-active",
											"type": "circle",
											"filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
											"paint": {
												"circle-radius": 5,
												"circle-color": "#FFF"
											}
										},
										// vertex points
										{
											"id": "gl-draw-polygon-and-line-vertex-active",
											"type": "circle",
											"filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
											"paint": {
												"circle-radius": 3,
												"circle-color": "#AA2143",
											}
										}
								]
							});
							map.addControl(draw);
							draw.add(alsp_draw_features[map_id]);
							draw.changeMode('direct_select', { featureId: alsp_draw_features[map_id].id });

							alsp_draws[map_id] = draw;
							
						} else if (this.editing_state == 1) {
							this.editing_state = 0;
							$(this).toggleClass('btn-active');
							$(this).attr("title", alsp_maps_objects.edit_area_button);
							if (typeof alsp_draws[map_id] != 'undefined' && alsp_draws[map_id]) {
								var draw = alsp_draws[map_id];
								draw.changeMode('simple_select', { featureId: alsp_draw_features[map_id].id });
								alsp_draw_features[map_id] = draw.get(alsp_draw_features[map_id].id);
								alsp_addPolygon(map_id);

								var geo_poly_ajax = [];
								alsp_draw_features[map_id].geometry.coordinates[0].map(function(point_feature) {
									geo_poly_ajax.push({ 'lat': point_feature[1], 'lng': point_feature[0] });
						    	});

								if (geo_poly_ajax.length) {
									alsp_sendGeoPolyAJAX(map_id, geo_poly_ajax);
								}
							}
							map.removeControl(alsp_draws[map_id]);
							alsp_draws[map_id] = false;
						}
				    });
				    
				    var reloadButton = document.createElement('button');
				    $(reloadButton)
				    .addClass('btn btn-primary alsp-map-reload')
				    .attr("title", alsp_maps_objects.reload_map_button)
				    .html('<span class="glyphicon glyphicon-refresh"></span>');
				    
				    drawPanel.appendChild(reloadButton);
				    reloadButton.map_id = map_id;
				    $(reloadButton).on("click", function(e) {
						var map_id = reloadButton.map_id;
						for (var i=0; i<alsp_map_markers_attrs_array.length; i++) {
							if (alsp_map_markers_attrs_array[i].map_id == map_id) {
								alsp_map_markers_attrs_array[i] = JSON.parse(JSON.stringify(_alsp_map_markers_attrs_array[i]));

								window.removeEventListener('touchmove', alsp_stop_touchmove_listener, { passive: false });
		
								var editButton = $(alsp_maps[map_id].getContainer()).find('.alsp-map-edit').get(0);
								$(editButton).removeClass('btn-active');
								$(editButton).find('.alsp-map-edit-label').text(alsp_maps_objects.edit_area_button);
								$(editButton).attr('disabled', 'disabled');

								alsp_disableDrawingMode(map_id);
								alsp_clearMarkers(map_id);
								alsp_closeInfoWindow(map_id);
								alsp_removeShapes(map_id);
								alsp_load_map(i);
								if (alsp_global_markers_array[map_id].length) {
									var markers_array = [];
									var bounds = alsp_buildBounds();
									for (var j=0; j<alsp_global_markers_array[map_id].length; j++) {
										var marker = alsp_global_markers_array[map_id][j];
									    alsp_extendBounds(bounds, alsp_getMarkerPosition(marker));
									    markers_array.push(marker);
						    		}
									alsp_mapFitBounds(map_id, bounds);
									
									var map_attrs = alsp_map_markers_attrs_array[i].map_attrs;
									alsp_setMapZoomCenter(map_id, map_attrs, markers_array);
						    	}
								break;
							}
						}
						
					});

				    if (alsp_maps_objects.enable_my_location_button) {
				    	var locationButton = document.createElement('button');
						$(locationButton)
						.addClass('btn btn-primary alsp-map-location')
						.attr("title", alsp_maps_objects.my_location_button)
						.html('<span class="glyphicon glyphicon-screenshot"></span>');

						drawPanel.appendChild(locationButton);
						
						locationButton.map_id = map_id;
					    $(locationButton).on("click", function(e) {
							var map_id = locationButton.map_id;
							if (navigator.geolocation) {
						    	navigator.geolocation.getCurrentPosition(
						    		function(position) {
							    		var start_latitude = position.coords.latitude;
							    		var start_longitude = position.coords.longitude;
									    alsp_setMapCenter(map_id, alsp_buildPoint(start_latitude, start_longitude));
							    	},
							    	function(e) {
								   		//alert(e.message);
								    },
								   	{timeout: 10000}
							    );
							}
						});
				    }
			    }
			} // end of (!fullScreen)

		    alsp_global_markers_array[map_id] = [];
		    alsp_global_locations_array[map_id] = [];
		    
		    
		    if (markers_array.length) {
		    	var bounds = alsp_buildBounds();
		    		
			    if (typeof map_attrs.ajax_markers_loading != 'undefined' && map_attrs.ajax_markers_loading == 1) {
					var is_ajax_markers = true;
			    } else {
					var is_ajax_markers = false;
			    }
		
			    var markers = [];
			    for (var j=0; j<markers_array.length; j++) {
		    		var map_coords_1 = markers_array[j][1];
				   	var map_coords_2 = markers_array[j][2];
				   	if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
				    	var point = [map_coords_2, map_coords_1];
				    	alsp_extendBounds(bounds, point);

		    			var location_obj = new alsp_glocation(
		    				markers_array[j][0],  // location ID
		    				point, 
		    				markers_array[j][3],  // map icon file
		    				markers_array[j][4],  // map icon color
		    				markers_array[j][6],  // listing title
		    				markers_array[j][7],  // logo image
		    				markers_array[j][8],  // listing link
		    				markers_array[j][9],  // content fields output
		    				markers_array[j][10],  // listing link anchor
		    				markers_array[j][11], // is nofollow link
		    				show_summary_button,
		    				show_readmore_button,
		    				map_id,
		    				is_ajax_markers
			    		);
			    		var marker = location_obj.alsp_placeMarker(map_id);
			    		markers.push(marker);
		
			    		alsp_global_locations_array[map_id].push(location_obj);
			    	}
	    		}
			    	
			    alsp_mapFitBounds(map_id, bounds);

			    alsp_setClusters(enable_clusters, map_id);
			    
			    if (enable_radius_circle && typeof window['radius_params_'+map_id] != 'undefined') {
		    		var radius_params = window['radius_params_'+map_id];
					var map_radius = parseFloat(radius_params.radius_value);
					alsp_draw_radius(radius_params, map_radius, map_id);
				}
		    }

		    alsp_setMapZoomCenter(map_id, map_attrs, markers_array);
		}
	}

	function alsp_setMapAjaxListener(map, map_id, search_button_obj) {
		var search_button_obj = typeof search_button_obj !== 'undefined' ? search_button_obj : null;

		map.on('load', function() {
			alsp_setAjaxMarkers(map, map_id, search_button_obj);
		});
		map.on('moveend', function() {
			alsp_setAjaxMarkers(map, map_id, search_button_obj);
		});
		map.on('zoomend', function() {
			alsp_setAjaxMarkers(map, map_id, search_button_obj);
		});
	}
	function alsp_geocodeStartAddress(map_attrs, map_id, zoom_level) {
		var start_address = map_attrs.start_address;
		function _geocodeStartAddress(status, start_latitude, start_longitude) {
			if (status == true) {
				alsp_setMapZoom(map_id, zoom_level);
			    alsp_setMapCenter(map_id, [start_longitude, start_latitude]);
			    
			    if (typeof map_attrs.ajax_loading != 'undefined' && map_attrs.ajax_loading == 1) {
				    // use closures here
				    alsp_setMapAjaxListener(alsp_maps[map_id], map_id);
			    }
			}
		}
		alsp_geocodeAddress(start_address, _geocodeStartAddress);
	}
	function alsp_geolocatePosition() {
		if (navigator.geolocation) {
			var geolocation_maps = [];
	    	for (var map_id in alsp_maps_attrs) {
	    		if (typeof alsp_maps_attrs[map_id].geolocation != 'undefined' && alsp_maps_attrs[map_id].geolocation == 1) {
	    			geolocation_maps.push({ 'map': alsp_maps[map_id], 'map_id': map_id});
	    		}
	    	}
	    	if (geolocation_maps.length) {
	    		navigator.geolocation.getCurrentPosition(
	    			function(position) {
		    			var start_latitude = position.coords.latitude;
		    			var start_longitude = position.coords.longitude;
				    	for (var i in geolocation_maps) {
				    		var map_id = geolocation_maps[i].map_id;
				    		
				    		alsp_setMapCenter(geolocation_maps[i].map_id, [start_longitude, start_latitude]);
				    		
				    		if (typeof alsp_maps_attrs[map_id].start_zoom != 'undefined' && alsp_maps_attrs[map_id].start_zoom > 0) {
				    			alsp_setMapZoom(map_id, alsp_maps_attrs[map_id].start_zoom);
				    		}
				    		
				    		for (var j=0; j<alsp_map_markers_attrs_array.length; j++) {
								if (alsp_map_markers_attrs_array[j].map_id == map_id) {
									alsp_map_markers_attrs_array[j].map_attrs.start_latitude = start_latitude;
									alsp_map_markers_attrs_array[j].map_attrs.start_longitude = start_longitude;
								}
				    		}
				    	}
		    		}, 
		    		function(e) {
		    			//alert(e.message);
			    	},
			    	{timeout: 10000}
		    	);
	    	}
		}
	}

	window.alsp_setAjaxMarkers = function(map, map_id, search_button_obj) {
		var attrs_array = alsp_get_map_markers_attrs_array(map_id);
		var map_attrs = attrs_array.map_attrs;
		var enable_radius_circle = attrs_array.enable_radius_circle;
		var enable_clusters = attrs_array.enable_clusters;
		var show_summary_button = attrs_array.show_summary_button;
		var show_readmore_button = attrs_array.show_readmore_button;
		var search_button_obj = typeof search_button_obj !== 'undefined' ? search_button_obj : null;

		var address_string = '';
		if (typeof map_attrs.address != 'undefined' && map_attrs.address) {
			var address_string = map_attrs.address;
		} else if (typeof map_attrs.location_id_text != 'undefined' && map_attrs.location_id_text) {
			var address_string = map_attrs.location_id_text;
		}
		if (address_string) {
			if (typeof alsp_searchAddresses[map_id] == "undefined" || alsp_searchAddresses[map_id] != address_string) {
				function _geocodeSearchAddress(status, latitude, longitude) {
					if (status == true) {
						map.panTo([longitude, latitude]);
	
						if (search_button_obj) {
							alsp_delete_iloader_from_element(search_button_obj);
						}
						alsp_setAjaxMarkers(map, map_id);
					}
				}
				alsp_geocodeAddress(address_string, _geocodeSearchAddress);
				
				alsp_searchAddresses[map_id] = address_string;
			}
		}
	
		var bounds_new = map.getBounds();
		if (bounds_new) {
			var south_west = bounds_new.getSouthWest();
			var north_east = bounds_new.getNorthEast();
		} else
			return false;
		
		function inBoundingBox(bl/*bottom left*/, tr/*top right*/, p) {
			// in case longitude 180 is inside the box
			function isLongInRange(bl, tr, p) {
				if (tr.lng < bl.lng) {
					if (p.lng >= bl.lng || p.lng <= tr.lng) {
						return true;
					}
				} else
					if (p.lng >= bl.lng && p.lng <= tr.lng) {
						return true;
					}
			}

			if (p.lat >= bl.lat  &&  p.lat <= tr.lat  &&  isLongInRange(bl, tr, p)) {
				return true;
			} else {
				return false;
			}
		}
	
		if (typeof map_attrs.swLat != 'undefined' && typeof map_attrs.swLng != 'undefined' && typeof map_attrs.neLat != 'undefined' && typeof map_attrs.neLng != 'undefined') {
			var sw_point = new mapboxgl.LngLat(map_attrs.swLng, map_attrs.swLat);
		    var ne_point = new mapboxgl.LngLat(map_attrs.neLng, map_attrs.neLat);

		    var worldCoordinate_new = map.project(sw_point);
		    var worldCoordinate_old = map.project(south_west);
		    if (
		    	(inBoundingBox(sw_point, ne_point, south_west) && inBoundingBox(sw_point, ne_point, north_east))
		    	||
			    	(140 > Math.abs(Math.floor(worldCoordinate_new.x) - Math.floor(worldCoordinate_old.x))
			    	&&
			    	140 > Math.abs(Math.floor(worldCoordinate_new.y) - Math.floor(worldCoordinate_old.y)))
		    )
		    	return false;
		}
		map_attrs.swLat = south_west.lat;
		map_attrs.swLng = south_west.lng;
		map_attrs.neLat = north_east.lat;
		map_attrs.neLng = north_east.lng;
		
		alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+map_id));
	
		var ajax_params = {};
		for (var attrname in map_attrs) {
			if (attrname != 'start_latitude' && attrname != 'start_longitude') {
				ajax_params[attrname] = map_attrs[attrname];
			}
		}
		ajax_params.action = 'alsp_get_map_markers';
		ajax_params.hash = map_id;

		var listings_args_array;
		if (listings_args_array = alsp_get_controller_args_array(map_id)) {
			ajax_params.hide_order = listings_args_array.hide_order;
			ajax_params.hide_count = listings_args_array.hide_count;
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
		} else
			ajax_params.without_listings = 1;
		
		if ($("#alsp-map-listings-panel-"+map_id).length) {
			ajax_params.map_listings = 1;
			alsp_ajax_loader_target_show($("#alsp-map-search-panel-wrapper-"+map_id));
		}
	
		$.ajax({
			type: "POST",
			url: alsp_js_objects.ajaxurl,
			data: ajax_params,
			dataType: 'json',
			success: function(response_from_the_action_function) {
				if (response_from_the_action_function) {
					var responce_hash = response_from_the_action_function.hash;
	
					if (response_from_the_action_function.html) {
						var listings_block = $('#alsp-controller-'+responce_hash);
						listings_block.replaceWith(response_from_the_action_function.html);
						alsp_ajax_loader_target_hide('alsp-controller-'+responce_hash);
					}
					
					var map_listings_block = $('#alsp-map-listings-panel-'+responce_hash);
			    	if (map_listings_block.length) {
			    		map_listings_block.html(response_from_the_action_function.map_listings);
			    		alsp_ajax_loader_target_hide('alsp-map-search-panel-wrapper-'+responce_hash);
			    	}
	
					alsp_clearMarkers(map_id);
					alsp_removeShapes(map_id);

					if (typeof map_attrs.ajax_markers_loading != 'undefined' && map_attrs.ajax_markers_loading == 1)
						var is_ajax_markers = true;
					else
						var is_ajax_markers = false;
		
					var markers_array = response_from_the_action_function.map_markers;
					alsp_global_locations_array[map_id] = [];
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
			    				map_id,
			    				is_ajax_markers
				    		);
				    		var marker = location_obj.alsp_placeMarker(map_id);
	
				    		alsp_global_locations_array[map_id].push(location_obj);
				    	}
		    		}
			    	alsp_setClusters(enable_clusters, map_id, alsp_global_markers_array[map_id]);

			    	if (enable_radius_circle && typeof response_from_the_action_function.radius_params != 'undefined') {
			    		var radius_params = response_from_the_action_function.radius_params;
						var map_radius = parseFloat(radius_params.radius_value);
						alsp_draw_radius(radius_params, map_radius, responce_hash);
					}
				}
			},
			complete: alsp_completeAJAXSearchOnMap(map_id, search_button_obj)
		});
	}
	var alsp_completeAJAXSearchOnMap = function(map_id, search_button_obj) {
		return function() {
			alsp_ajax_loader_target_hide("alsp-controller-"+map_id);
			alsp_ajax_loader_target_hide("alsp-maps-canvas-"+map_id);
			alsp_equalColumnsHeight();
			if (search_button_obj) {
				alsp_delete_iloader_from_element(search_button_obj);
			}
		}
	}
	window.alsp_draw_radius = function(radius_params, map_radius, map_id) {
		if (radius_params.dimension == 'miles')
			map_radius *= 1.609344;
		var map_coords_1 = radius_params.map_coords_1;
		var map_coords_2 = radius_params.map_coords_2;

		if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
			var map = alsp_maps[map_id];
			 map.on('load', function() {
			      map.addSource("source-circle-"+map_id, {
			        "type": "geojson",
			        "data": {
			          "type": "FeatureCollection",
			          "features": [{
			            "type": "Feature",
			            "geometry": {
			              "type": "Point",
			              "coordinates": [map_coords_2, map_coords_1]
			            }
			          }]
			        }
			      });
	
			      const metersToPixelsAtMaxZoom = (meters, latitude) =>
			      meters / 0.075 / Math.cos(latitude * Math.PI / 180)
			      
			      map.addLayer({
			        "id": "radius-circle-"+map_id,
			        "type": "circle",
			        "source": "source-circle-"+map_id,
			        "paint": {
			        	"circle-radius": {
			        		  stops: [
			        		    [0, 0],
			        		    [20, metersToPixelsAtMaxZoom(map_radius*1000, map_coords_1)]
			        		  ],
			        		  base: 2
			        		},
			          "circle-color": "#FF0000",
			          "circle-opacity": 0.1,
			          "circle-stroke-width": 1,
			          "circle-stroke-color": "#FF0000",
			          "circle-stroke-opacity": 0.25
			        }
			      });
			      
			      alsp_drawCircles[map_id] = true;
			    });
		}
	}
	mapboxgl.Map.prototype.panToWithOffset = function(lnglat, offsetX, offsetY) {
		var map = this;
		var aPoint = map.project(lnglat);
		aPoint.x = aPoint.x+offsetX;
		aPoint.y = aPoint.y+offsetY;
		map.panTo(map.unproject(aPoint));
	};
	window.alsp_placeMarker = function(location, map_id) {
		if (alsp_maps_objects.map_markers_type != 'icons') {
			if (alsp_maps_objects.global_map_icons_path != '') {
				var re = /(?:\.([^.]+))?$/;
				if (location.map_icon_file && typeof re.exec(alsp_maps_objects.global_map_icons_path+'icons/'+location.map_icon_file)[1] != "undefined")
					var icon_file = alsp_maps_objects.global_map_icons_path+'icons/'+location.map_icon_file;
				else
					var icon_file = alsp_maps_objects.global_map_icons_path+"blank.png";

				var el = $("<div>", {
					id: 'marker-id-'+location.id,
					style: 'background-image: url('+icon_file+'); width: '+parseInt(alsp_maps_objects.marker_image_width)+'px; height: '+parseInt(alsp_maps_objects.marker_image_height)+'px',
					class: 'alsp-mapbox-marker'
				});
				var marker_div = el[0];
				
				var marker_options = {
						anchor: 'bottom',
						element: marker_div
				};
				
				var marker = new mapboxgl.Marker(marker_options)
	    		.setLngLat(location.point)
	    		.addTo(alsp_maps[map_id]);
			} else {
				var marker = new mapboxgl.Marker()
	    		.setLngLat(location.point)
	    		.addTo(alsp_maps[map_id]);
			}
		} else {
			if (location.map_icon_color)
				var map_marker_color = location.map_icon_color;
			else
				var map_marker_color = alsp_maps_objects.default_marker_color;

			if (typeof location.map_icon_file == 'string' && location.map_icon_file.indexOf("alsp-fa-") != -1) {
				var map_marker_icon = '<span class="alsp-map-marker-icon alsp-fa '+location.map_icon_file+'" style="color: '+map_marker_color+';"></span>';
				var map_marker_class = 'alsp-map-marker';
			} else {
				if (alsp_maps_objects.default_marker_icon) {
					var map_marker_icon = '<span class="alsp-map-marker-icon alsp-fa '+alsp_maps_objects.default_marker_icon+'" style="color: '+map_marker_color+';"></span>';
					var map_marker_class = 'alsp-map-marker';
				} else {
					var map_marker_icon = '';
					var map_marker_class = 'alsp-map-marker-empty';
				}
			}

			var el = $("<div>", {
				id: 'marker-id-'+location.id,
				class: 'alsp-mapbox-marker',
				html: '<div class="'+map_marker_class+'" style="background: '+map_marker_color+' none repeat scroll 0 0;">'+map_marker_icon+'</div>'
			});
			var marker_div = el[0];
			
			var marker_options = {
				anchor: 'bottom',
				offset: [0, -20],
				element: marker_div
			};

			var marker = new mapboxgl.Marker(marker_options)
    		.setLngLat(location.point)
    		.addTo(alsp_maps[map_id]);
		}
		
		alsp_global_markers_array[map_id].push(marker);

		marker_div.addEventListener('click', function() {
			var attrs_array = alsp_get_map_markers_attrs_array(map_id);
			if (attrs_array.center_map_onclick) {
				var map_attrs = attrs_array.map_attrs;
				if (typeof map_attrs.ajax_loading == 'undefined' || map_attrs.ajax_loading == 0) {
					//alsp_maps[map_id].panTo(marker.getLngLat());
					alsp_maps[map_id].panToWithOffset(marker.getLngLat(), 0, -100);
					alsp_setInfoWindow(location, marker, map_id, 'bottom', 'onmarkerclick');
				}
			} else {
				alsp_setInfoWindow(location, marker, map_id, '', 'onmarkerclick');
			}
			
			if ($('#alsp-map-listings-panel-'+map_id).length) {
				if ($('#alsp-map-listings-panel-'+map_id+' #post-'+location.id).length) {
					$('#alsp-map-listings-panel-'+map_id).animate({scrollTop: $('#alsp-map-listings-panel-'+map_id).scrollTop() + $('#alsp-map-listings-panel-'+map_id+' #post-'+location.id).position().top}, 'fast');
				}
			}

			
		});

		return marker;
	}
	
	window.alsp_setInfoWindow = function(location, marker, map_id, anchor, event) {
		if (!location.is_ajax_markers) {
			alsp_showInfoWindow(location, marker, map_id, anchor, event);
		} else {
			alsp_ajax_loader_target_show($('#alsp-maps-canvas-'+map_id));

			var post_data = {'location_id': location.id, 'action': 'alsp_get_map_marker_info'};
			$.ajax({
	    		type: "POST",
	    		url: alsp_js_objects.ajaxurl,
	    		data: eval(post_data),
	    		dataType: 'json',
	    		success: function(response_from_the_action_function) {
	    			var marker_array = response_from_the_action_function;
	    			var map_coords_1 = marker_array[1];
			    	var map_coords_2 = marker_array[2];
			    	if ($.isNumeric(map_coords_1) && $.isNumeric(map_coords_2)) {
		    			var point = alsp_buildPoint(map_coords_1, map_coords_2);

		    			var new_location_obj = new alsp_glocation(marker_array[0], point, 
		    				marker_array[3],
		    				marker_array[4],
		    				marker_array[6],
		    				marker_array[7],
		    				marker_array[8],
		    				marker_array[9],
		    				marker_array[10],
		    				marker_array[11],
		    				location.show_summary_button,
		    				location.show_readmore_button,
		    				map_id,
		    				true
			    		);
		    			alsp_showInfoWindow(new_location_obj, marker, map_id, anchor, 'onbuttonclick');
			    	}
	    		},
	    		complete: function() {
					alsp_ajax_loader_target_hide("alsp-maps-canvas-"+map_id);
				}
			});
		}
	}
	
	// This function builds info Window and shows it hiding another
	function alsp_showInfoWindow(alsp_glocation, marker, map_id, anchor, event) {
		// we use global infoWindow, not to close/open it - just to set new content (in order to prevent blinking)
	    if (typeof alsp_infoWindows[map_id] != 'undefined' && alsp_infoWindows[map_id]) {
	    	alsp_infoWindows[map_id].remove();
	    	alsp_infoWindows[map_id] = false;
	    }
	    
		if (alsp_glocation.nofollow)
			var nofollow = 'rel="nofollow"';
		else
			var nofollow = '';
	
		var windowHtml = '<div class="alsp-map-info-window">';
		windowHtml += '<div class="alsp-map-info-window-title">';
		if (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)
			windowHtml += '<a class="alsp-map-info-window-title-link" href="' + alsp_glocation.listing_url + '" ' + nofollow + '>';
		windowHtml += alsp_glocation.listing_title;
		if (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)
			windowHtml += '</a>';
		windowHtml += '<span class="alsp-close-info-window alsp-fa alsp-fa-close" onClick="alsp_infoWindows[&quot;' + map_id + '&quot;].remove();"></span>';
		windowHtml += '</div>';

		if (alsp_glocation.listing_logo) {
			windowHtml += '<div class="alsp-map-info-window-logo" style="width: ' + (alsp_maps_objects.infowindow_logo_width+10) + 'px">';
			if (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)
				windowHtml += '<a href="' + alsp_glocation.listing_url + '" ' + nofollow + '>';
			windowHtml += '<img width="' + alsp_maps_objects.infowindow_logo_width + 'px" src="' + alsp_glocation.listing_logo + '" />';
			if (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)
				windowHtml += '</a>';
			windowHtml += '</div>';
		}
	
		windowHtml += '<div class="alsp-map-info-window-content alsp-clearfix">';
		if (alsp_glocation.content_fields) {
			for (var i=0; i<alsp_glocation.content_fields.length; i++) {
				if (alsp_glocation.content_fields[i]) {
					windowHtml += '<div class="alsp-map-info-window-field">';
					if (alsp_maps_objects.alsp_map_content_fields_icons[i])
						windowHtml += '<span class="alsp-map-field-icon alsp-fa ' + alsp_maps_objects.alsp_map_content_fields_icons[i] + '"></span>';
					windowHtml += alsp_glocation.content_fields[i];
					windowHtml += '</div>';
				}
			}
		}
		windowHtml += '</div>';
	
		if ((alsp_glocation.show_summary_button && $("#"+alsp_glocation.anchor).length) || (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)) {
			if (!(alsp_glocation.show_summary_button && $("#"+alsp_glocation.anchor).length) || !(alsp_glocation.listing_url && alsp_glocation.show_readmore_button))
				var button_class = 'alsp-map-info-window-buttons-single';
			else
				var button_class = 'alsp-map-info-window-buttons';
	
			windowHtml += '<div class="' + button_class + ' alsp-clearfix">';
			if (alsp_glocation.show_summary_button && $("#"+alsp_glocation.anchor).length)
				windowHtml += '<a href="javascript:void(0);" class="btn btn-primary alsp-scroll-to-listing" onClick="alsp_scrollToListing(&quot;' + alsp_glocation.anchor + '&quot;, &quot;' + map_id + '&quot;);">' + alsp_maps_objects.alsp_map_info_window_button_summary + '</a>';
			if (alsp_glocation.listing_url && alsp_glocation.show_readmore_button)
				windowHtml += '<a href="' +  alsp_glocation.listing_url + '" ' + nofollow + ' class="btn btn-primary">' + alsp_maps_objects.alsp_map_info_window_button_readmore + '</a>';
			windowHtml += '</div>';
		}

		windowHtml += '</div>';

		var options = {
				offset: {'bottom': [0,-30]},
				closeOnClick: false,
				anchor: anchor
		};
		var popup = new mapboxgl.Popup(options)
		.setHTML(windowHtml)
		.addTo(alsp_maps[map_id]);

		marker.setPopup(popup);
		// This is needed workaround, otherwise it will not open infoWindow on "On map" button click due to popup.addTo(alsp_maps[map_id])
		if (event == 'onmarkerclick') {
			marker.addTo(alsp_maps[map_id]);
		}
		
		alsp_infoWindows[map_id] = popup;
	}

	window.alsp_scrollToListing = function(anchor, map_id) {
		var scroll_to_anchor = $("#"+anchor);
		var sticky_scroll_toppadding = 0;
		if (typeof window["alsp_sticky_scroll_toppadding_"+map_id] != 'undefined') {
			sticky_scroll_toppadding = window["alsp_sticky_scroll_toppadding_"+map_id];
		}

		if (scroll_to_anchor.length) {
			$('html,body').animate({scrollTop: scroll_to_anchor.position().top - sticky_scroll_toppadding}, 'fast');
		}
	}

	window.alsp_setClusters = function(enable_clusters, map_id) {
		if (enable_clusters) {
			var map = alsp_maps[map_id],
			clusters = {},
			markers = [],
			clustersGeojson = {};

			var displayFeatures = function (features) {
				if (alsp_global_locations_array[map_id].length) {
		            $.each(alsp_global_locations_array[map_id], function (i, marker) {
		            	// Do not remove markers, only hide. Otherwise on each move it will remove opened opoup as well.
		            	$("#marker-id-"+alsp_global_locations_array[map_id][i].id).hide();
		            });
				}

				$.each(features, function (i, feature) {
					var isCluster = (!!feature.properties.cluster) ? true : false,
						$feature;

					if (isCluster) {
						var count = feature.properties.point_count,
							className;
						if (count > 50) {
							className = 'alsp-mapbox-cluster-extralarge';
						} else if (count > 25) {
							className = 'alsp-mapbox-cluster-large';
						} else if (count > 15) {
							className = 'alsp-mapbox-cluster-medium';
						} else if (count > 10) {
							className = 'alsp-mapbox-cluster-small';
						} else {
							className = 'alsp-mapbox-cluster-extrasmall';
						}

						$feature = $('<div class="alsp-mapbox-cluster ' + className + '" tabindex="0">' + feature.properties.point_count_abbreviated + '</div>');
						clusters[feature.properties.cluster_id] = new mapboxgl.Marker($feature[0]).setLngLat(feature.geometry.coordinates).addTo(map);
					} else {
						$("#marker-id-"+feature.location_id).show();
					}
				});
			};

			var updateClusters = function () {
				var bounds = map.getBounds(),
					zoom = map.getZoom();

				clustersGeojson = clusterIndex.getClusters([
					bounds.getWest(),
					bounds.getSouth(),
					bounds.getEast(),
					bounds.getNorth()
				], Math.floor(zoom));

				if (Object.keys(clusters).length) {
					$.each(clusters, function (i, cluster) {
						cluster.remove();
					});
				}

				displayFeatures(clustersGeojson);
			};

			var feature_collection = [];
			for (var j=0; j<alsp_global_locations_array[map_id].length; j++) {
				feature_collection.push({
					"type": "Feature",
					"properties": {},
					"geometry": {
						"type": "Point",
						"coordinates": alsp_global_locations_array[map_id][j].point
					},
					"location_id": alsp_global_locations_array[map_id][j].id
				});
			}

			var clusterIndex = supercluster({
				maxZoom: 20
			});
			clusterIndex.load(feature_collection);
			map.on('moveend', updateClusters);
			updateClusters();

			alsp_markerClusters[map_id] = clusters;
		}
	}
	window.alsp_clearMarkers = function(map_id) {
		if (typeof alsp_markerClusters[map_id] != 'undefined') {
			for (var i = 0; i < alsp_markerClusters[map_id].length; i++) {
				alsp_markerClusters[map_id][i].remove();
			};
		}
	
		if (alsp_global_markers_array[map_id]) {
			for (var i = 0; i < alsp_global_markers_array[map_id].length; i++) {
				alsp_global_markers_array[map_id][i].remove();
			}
		}
		alsp_global_markers_array[map_id] = [];
		alsp_global_locations_array[map_id] = [];
	}
	window.alsp_removeShapes = function(map_id) {
		if (typeof alsp_drawCircles[map_id] != 'undefined' && alsp_drawCircles[map_id]) {
			alsp_maps[map_id].removeLayer('radius-circle-'+map_id);
			alsp_maps[map_id].removeSource('radius-circle-'+map_id);
			alsp_drawCircles[map_id] = false;
		}

		if (typeof alsp_polygons[map_id] != 'undefined' && alsp_polygons[map_id]) {
			alsp_maps[map_id].removeLayer('geo-poly-'+map_id);
			alsp_maps[map_id].removeSource('geo-poly-'+map_id);
			alsp_polygons[map_id] = false;
		}
		
		if (typeof alsp_draws[map_id] != 'undefined' && alsp_draws[map_id]) {
			alsp_maps[map_id].removeControl(alsp_draws[map_id]);
			alsp_draws[map_id] = false;
		}
	}
	window.alsp_setZoomCenter = function(map) {
		var zoom = map.getZoom();
		var center = map.getCenter();
		map.resize();
		map.setZoom(zoom);
		map.setCenter(center);
	}

	window.alsp_geocodeField = function(field, error_message) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				function(position) {
					$.get("https://api.mapbox.com/geocoding/v5/mapbox.places/"+position.coords.longitude + ',' + position.coords.latitude+".json?access_token="+alsp_maps_objects.mapbox_api_key, function(data) {
						if (data.features.length) {
							field.val(data.features[0].place_name);
							field.trigger('change');
						}
					});
			    },
			    function(e) {
			    	//alert(e.message);
		    	},
			    {enableHighAccuracy: true, timeout: 10000, maximumAge: 0}
		    );
		} else
			alert(error_message);
	}
})(jQuery);

// supercluster.js
//https://unpkg.com/supercluster@3.0.2/dist/supercluster.min.js
!function(t){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{("undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this).supercluster=t()}}(function(){return function t(n,o,e){function r(s,u){if(!o[s]){if(!n[s]){var a="function"==typeof require&&require;if(!u&&a)return a(s,!0);if(i)return i(s,!0);var h=new Error("Cannot find module '"+s+"'");throw h.code="MODULE_NOT_FOUND",h}var p=o[s]={exports:{}};n[s][0].call(p.exports,function(t){var o=n[s][1][t];return r(o||t)},p,p.exports,t,n,o,e)}return o[s].exports}for(var i="function"==typeof require&&require,s=0;s<e.length;s++)r(e[s]);return r}({1:[function(t,n,o){"use strict";function e(t){return new r(t)}function r(t){this.options=h(Object.create(this.options),t),this.trees=new Array(this.options.maxZoom+1)}function i(t){return{type:"Feature",properties:s(t),geometry:{type:"Point",coordinates:[function(t){return 360*(t-.5)}(t.x),function(t){var n=(180-360*t)*Math.PI/180;return 360*Math.atan(Math.exp(n))/Math.PI-90}(t.y)]}}}function s(t){var n=t.numPoints,o=n>=1e4?Math.round(n/1e3)+"k":n>=1e3?Math.round(n/100)/10+"k":n;return h(h({},t.properties),{cluster:!0,cluster_id:t.id,point_count:n,point_count_abbreviated:o})}function u(t){return t/360+.5}function a(t){var n=Math.sin(t*Math.PI/180),o=.5-.25*Math.log((1+n)/(1-n))/Math.PI;return o<0?0:o>1?1:o}function h(t,n){for(var o in n)t[o]=n[o];return t}function p(t){return t.x}function f(t){return t.y}var c=t("kdbush");n.exports=e,n.exports.default=e,r.prototype={options:{minZoom:0,maxZoom:16,radius:40,extent:512,nodeSize:64,log:!1,reduce:null,initial:function(){return{}},map:function(t){return t}},load:function(t){var n=this.options.log;n&&console.time("total time");var o="prepare "+t.length+" points";n&&console.time(o),this.points=t;for(var e=[],r=0;r<t.length;r++)t[r].geometry&&e.push(function(t,n){var o=t.geometry.coordinates;return{x:u(o[0]),y:a(o[1]),zoom:1/0,id:n,parentId:-1}}(t[r],r));this.trees[this.options.maxZoom+1]=c(e,p,f,this.options.nodeSize,Float32Array),n&&console.timeEnd(o);for(var i=this.options.maxZoom;i>=this.options.minZoom;i--){var s=+Date.now();e=this._cluster(e,i),this.trees[i]=c(e,p,f,this.options.nodeSize,Float32Array),n&&console.log("z%d: %d clusters in %dms",i,e.length,+Date.now()-s)}return n&&console.timeEnd("total time"),this},getClusters:function(t,n){if(t[0]>t[2]){var o=this.getClusters([t[0],t[1],180,t[3]],n),e=this.getClusters([-180,t[1],t[2],t[3]],n);return o.concat(e)}for(var r=this.trees[this._limitZoom(n)],s=r.range(u(t[0]),a(t[3]),u(t[2]),a(t[1])),h=[],p=0;p<s.length;p++){var f=r.points[s[p]];h.push(f.numPoints?i(f):this.points[f.id])}return h},getChildren:function(t){var n=t>>5,o=t%32,e="No cluster with the specified id.",r=this.trees[o];if(!r)throw new Error(e);var s=r.points[n];if(!s)throw new Error(e);for(var u=this.options.radius/(this.options.extent*Math.pow(2,o-1)),a=r.within(s.x,s.y,u),h=[],p=0;p<a.length;p++){var f=r.points[a[p]];f.parentId===t&&h.push(f.numPoints?i(f):this.points[f.id])}if(0===h.length)throw new Error(e);return h},getLeaves:function(t,n,o){n=n||10,o=o||0;var e=[];return this._appendLeaves(e,t,n,o,0),e},getTile:function(t,n,o){var e=this.trees[this._limitZoom(t)],r=Math.pow(2,t),i=this.options.extent,s=this.options.radius/i,u=(o-s)/r,a=(o+1+s)/r,h={features:[]};return this._addTileFeatures(e.range((n-s)/r,u,(n+1+s)/r,a),e.points,n,o,r,h),0===n&&this._addTileFeatures(e.range(1-s/r,u,1,a),e.points,r,o,r,h),n===r-1&&this._addTileFeatures(e.range(0,u,s/r,a),e.points,-1,o,r,h),h.features.length?h:null},getClusterExpansionZoom:function(t){for(var n=t%32-1;n<this.options.maxZoom;){var o=this.getChildren(t);if(n++,1!==o.length)break;t=o[0].properties.cluster_id}return n},_appendLeaves:function(t,n,o,e,r){for(var i=this.getChildren(n),s=0;s<i.length;s++){var u=i[s].properties;if(u&&u.cluster?r+u.point_count<=e?r+=u.point_count:r=this._appendLeaves(t,u.cluster_id,o,e,r):r<e?r++:t.push(i[s]),t.length===o)break}return r},_addTileFeatures:function(t,n,o,e,r,i){for(var u=0;u<t.length;u++){var a=n[t[u]];i.features.push({type:1,geometry:[[Math.round(this.options.extent*(a.x*r-o)),Math.round(this.options.extent*(a.y*r-e))]],tags:a.numPoints?s(a):this.points[a.id].properties})}},_limitZoom:function(t){return Math.max(this.options.minZoom,Math.min(t,this.options.maxZoom+1))},_cluster:function(t,n){for(var o=[],e=this.options.radius/(this.options.extent*Math.pow(2,n)),r=0;r<t.length;r++){var i=t[r];if(!(i.zoom<=n)){i.zoom=n;var s=this.trees[n+1],u=s.within(i.x,i.y,e),a=i.numPoints||1,h=i.x*a,p=i.y*a,f=null;this.options.reduce&&(f=this.options.initial(),this._accumulate(f,i));for(var c=(r<<5)+(n+1),l=0;l<u.length;l++){var d=s.points[u[l]];if(!(d.zoom<=n)){d.zoom=n;var m=d.numPoints||1;h+=d.x*m,p+=d.y*m,a+=m,d.parentId=c,this.options.reduce&&this._accumulate(f,d)}}1===a?o.push(i):(i.parentId=c,o.push(function(t,n,o,e,r){return{x:t,y:n,zoom:1/0,id:o,parentId:-1,numPoints:e,properties:r}}(h/a,p/a,c,a,f)))}}return o},_accumulate:function(t,n){var o=n.numPoints?n.properties:this.options.map(this.points[n.id].properties);this.options.reduce(t,o)}}},{kdbush:2}],2:[function(t,n,o){"use strict";function e(t,n,o,e,i){n=n||function(t){return t[0]},o=o||function(t){return t[1]},i=i||Array,this.nodeSize=e||64,this.points=t,this.ids=new i(t.length),this.coords=new i(2*t.length);for(var s=0;s<t.length;s++)this.ids[s]=s,this.coords[2*s]=n(t[s]),this.coords[2*s+1]=o(t[s]);r(this.ids,this.coords,this.nodeSize,0,this.ids.length-1,0)}var r=t("./sort"),i=t("./range"),s=t("./within");n.exports=function(t,n,o,r,i){return new e(t,n,o,r,i)},e.prototype={range:function(t,n,o,e){return i(this.ids,this.coords,t,n,o,e,this.nodeSize)},within:function(t,n,o){return s(this.ids,this.coords,t,n,o,this.nodeSize)}}},{"./range":3,"./sort":4,"./within":5}],3:[function(t,n,o){"use strict";n.exports=function(t,n,o,e,r,i,s){for(var u,a,h=[0,t.length-1,0],p=[];h.length;){var f=h.pop(),c=h.pop(),l=h.pop();if(c-l<=s)for(var d=l;d<=c;d++)u=n[2*d],a=n[2*d+1],u>=o&&u<=r&&a>=e&&a<=i&&p.push(t[d]);else{var m=Math.floor((l+c)/2);u=n[2*m],a=n[2*m+1],u>=o&&u<=r&&a>=e&&a<=i&&p.push(t[m]);var v=(f+1)%2;(0===f?o<=u:e<=a)&&(h.push(l),h.push(m-1),h.push(v)),(0===f?r>=u:i>=a)&&(h.push(m+1),h.push(c),h.push(v))}}return p}},{}],4:[function(t,n,o){"use strict";function e(t,n,o,i,s,u){if(!(s-i<=o)){var a=Math.floor((i+s)/2);r(t,n,a,i,s,u%2),e(t,n,o,i,a-1,u+1),e(t,n,o,a+1,s,u+1)}}function r(t,n,o,e,s,u){for(;s>e;){if(s-e>600){var a=s-e+1,h=o-e+1,p=Math.log(a),f=.5*Math.exp(2*p/3),c=.5*Math.sqrt(p*f*(a-f)/a)*(h-a/2<0?-1:1);r(t,n,o,Math.max(e,Math.floor(o-h*f/a+c)),Math.min(s,Math.floor(o+(a-h)*f/a+c)),u)}var l=n[2*o+u],d=e,m=s;for(i(t,n,e,o),n[2*s+u]>l&&i(t,n,e,s);d<m;){for(i(t,n,d,m),d++,m--;n[2*d+u]<l;)d++;for(;n[2*m+u]>l;)m--}n[2*e+u]===l?i(t,n,e,m):i(t,n,++m,s),m<=o&&(e=m+1),o<=m&&(s=m-1)}}function i(t,n,o,e){s(t,o,e),s(n,2*o,2*e),s(n,2*o+1,2*e+1)}function s(t,n,o){var e=t[n];t[n]=t[o],t[o]=e}n.exports=e},{}],5:[function(t,n,o){"use strict";function e(t,n,o,e){var r=t-o,i=n-e;return r*r+i*i}n.exports=function(t,n,o,r,i,s){for(var u=[0,t.length-1,0],a=[],h=i*i;u.length;){var p=u.pop(),f=u.pop(),c=u.pop();if(f-c<=s)for(var l=c;l<=f;l++)e(n[2*l],n[2*l+1],o,r)<=h&&a.push(t[l]);else{var d=Math.floor((c+f)/2),m=n[2*d],v=n[2*d+1];e(m,v,o,r)<=h&&a.push(t[d]);var g=(p+1)%2;(0===p?o-i<=m:r-i<=v)&&(u.push(c),u.push(d-1),u.push(g)),(0===p?o+i>=m:r+i>=v)&&(u.push(d+1),u.push(f),u.push(g))}}return a}},{}]},{},[1])(1)});