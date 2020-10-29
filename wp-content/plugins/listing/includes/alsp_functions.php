<?php 
if (!function_exists('alsp_getValue')) {
	function alsp_getValue($target, $key, $default = false) {
		$target = is_object($target) ? (array) $target : $target;
	
		if (is_array($target) && isset($target[$key])) {
			$value = $target[$key];
		} else {
			$value = $default;
		}
	
		$value = apply_filters('alsp_get_value', $value, $target, $key, $default);
		return $value;
	}
}

if (!function_exists('alsp_addMessage')) {
	function alsp_addMessage($message, $type = 'updated') {
		global $alsp_messages;
		
		if (is_array($message)) {
			foreach ($message AS $m) {
				alsp_addMessage($m, $type);
			}
			return ;
		}
	
		if (!isset($alsp_messages[$type]) || (isset($alsp_messages[$type]) && !in_array($message, $alsp_messages[$type]))) {
			$alsp_messages[$type][] = $message;
		}
	
		if (session_id() == '') {
			@session_start();
		}
	
		if (!isset($_SESSION['alsp_messages'][$type]) || (isset($_SESSION['alsp_messages'][$type]) && !in_array($message, $_SESSION['alsp_messages'][$type]))) {
			$_SESSION['alsp_messages'][$type][] = $message;
		}
	}
}

if (!function_exists('alsp_renderMessages')) {
	function alsp_renderMessages() {
		global $alsp_messages;
	
		$messages = array();
		if (isset($alsp_messages) && is_array($alsp_messages) && $alsp_messages)
			$messages = $alsp_messages;
	
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			if (session_status() == PHP_SESSION_NONE) {
				@session_start();
			}
		} else {
			if (session_id() == '') {
				@session_start();
			}
		}
		if (isset($_SESSION['alsp_messages'])) {
			$messages = array_merge($messages, $_SESSION['alsp_messages']);
		}
	
		$messages = alsp_superUnique($messages);
	
		foreach ($messages AS $type=>$messages) {
			$message_class = (is_admin()) ? $type : "alsp-" . $type;

			echo '<div class="' . $message_class . '">';
			foreach ($messages AS $message) {
				echo '<p>' . trim(preg_replace("/<p>(.*?)<\/p>/", "$1", $message)) . '</p>';
			}
			echo '</div>';
		}
		
		$alsp_messages = array();
		if (isset($_SESSION['alsp_messages'])) {
			unset($_SESSION['alsp_messages']);
		}
	}
	function alsp_superUnique($array) {
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));
		foreach ($result as $key => $value)
			if (is_array($value))
				$result[$key] = alsp_superUnique($value);
		return $result;
	}
}
if (!function_exists('alsp_time_ago')) {
      function alsp_time_ago($time)
      {
             $periods = array(
               esc_html__("second", 'ALSP'),
               esc_html__("minute", 'ALSP'),
               esc_html__("hour", 'ALSP'),
               esc_html__("day", 'ALSP'),
               esc_html__("week", 'ALSP'),
               esc_html__("month", 'ALSP'),
               esc_html__("year", 'ALSP'),
               esc_html__("decade", 'ALSP')
          );
          $lengths = array(
               "60",
               "60",
               "24",
               "7",
               "4.35",
               "12",
               "10"
          );
          
          $now = time();
          
          $difference = $now - $time;
          $tense      = esc_html__("ago", 'ALSP');
          
          for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
               $difference /= $lengths[$j];
          }
          
          $difference = round($difference);
          
          if ($difference != 1) {
               $periods[$j] .= "s";
          }
          
          return "$difference $periods[$j] {$tense} ";
      }
}
function alsp_calcExpirationDate($date, $level) {
	switch ($level->active_period) {
		case 'day':
			$date = strtotime('+'.$level->active_interval.' day', $date);
			break;
		case 'week':
			$date = strtotime('+'.$level->active_interval.' week', $date);
			break;
		case 'month':
			$date = alsp_addMonths($date, $level->active_interval);
			break;
		case 'year':
			$date = strtotime('+'.$level->active_interval.' year', $date);
			break;
	}
	
	return $date;
}

/**
 * Workaround the last day of month quirk in PHP's strtotime function.
 *
 * Adding +1 month to the last day of the month can yield unexpected results with strtotime().
 * For example:
 * - 30 Jan 2013 + 1 month = 3rd March 2013
 * - 28 Feb 2013 + 1 month = 28th March 2013
 *
 * What humans usually want is for the date to continue on the last day of the month.
 *
 * @param int $from_timestamp A Unix timestamp to add the months too.
 * @param int $months_to_add The number of months to add to the timestamp.
 */
function alsp_addMonths($from_timestamp, $months_to_add) {
	$first_day_of_month = date('Y-m', $from_timestamp) . '-1';
	$days_in_next_month = date('t', strtotime("+ {$months_to_add} month", strtotime($first_day_of_month)));
	
	// Payment is on the last day of the month OR number of days in next billing month is less than the the day of this month (i.e. current billing date is 30th January, next billing date can't be 30th February)
	if (date('d m Y', $from_timestamp) === date('t m Y', $from_timestamp) || date('d', $from_timestamp) > $days_in_next_month) {
		for ($i = 1; $i <= $months_to_add; $i++) {
			$next_month = strtotime('+3 days', $from_timestamp); // Add 3 days to make sure we get to the next month, even when it's the 29th day of a month with 31 days
			$next_timestamp = $from_timestamp = strtotime(date('Y-m-t H:i:s', $next_month));
		}
	} else { // Safe to just add a month
		$next_timestamp = strtotime("+ {$months_to_add} month", $from_timestamp);
	}
	
	return $next_timestamp;
}

function alsp_isResource($resource) {
	if (is_file(get_stylesheet_directory() . '/alsp-listing/assets/' . $resource)) {
		return get_stylesheet_directory_uri() . '/alsp-listing/assets/' . $resource;
	} elseif (is_file(ALSP_RESOURCES_PATH . $resource)) {
		return ALSP_RESOURCES_URL . $resource;
	}
	
	return false;
}

function alsp_isCustomResourceDir($dir) {
	if (is_dir(get_stylesheet_directory() . '/alsp-listing/assets/' . $dir)) {
		return get_stylesheet_directory() . '/alsp-listing/assets/' . $dir;
	}
	
	return false;
}

function alsp_getCustomResourceDirURL($dir) {
	if (is_dir(get_stylesheet_directory() . '/alsp-listing/assets/' . $dir)) {
		return get_stylesheet_directory_uri() . '/alsp-listing/assets/' . $dir;
	}
	
	return false;
}

/**
 * possible variants of templates and their paths:
 * - themes/theme/alsp-listing/public/template-custom.tpl.php
 * - themes/theme/alsp-listing/public/template.tpl.php
 * - plugins/alsp/public/template-custom.tpl.php
 * - plugins/alsp/public/template.tpl.php
 * 
 * templates in addons will be visible by such type of path:
 * - themes/theme/alsp-listing/public/alsp-frontend-submission/template.tpl.php
 * 
 */
function alsp_isTemplate($template) {
	$custom_template = str_replace('.tpl.php', '', $template) . '-custom.tpl.php';
	$templates = array(
			$custom_template,
			$template
	);

	foreach ($templates AS $template_to_check) {
		// check if it is exact path in $template
		if (is_file($template_to_check)) {
			return $template_to_check;
		} elseif (is_file(get_stylesheet_directory() . '/alsp-listing/public/' . $template_to_check)) { // theme or child theme templates folder
			return get_stylesheet_directory() . '/alsp-listing/public/' . $template_to_check;
		} elseif (is_file(ALSP_TEMPLATES_PATH . $template_to_check)) { // native plugin's templates folder
			return ALSP_TEMPLATES_PATH . $template_to_check;
		}
	}

	return false;
}

if (!function_exists('alsp_renderTemplate')) {
	/**
	 * @param string|array $template
	 * @param array $args
	 * @param bool $return
	 * @return string
	 */
	function alsp_renderTemplate($template, $args = array(), $return = false) {
		global $alsp_instance;
	
		if ($args) {
			extract($args);
		}
		
		$template = apply_filters('alsp_render_template', $template, $args);
		
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
			$template = $template_path . $template_file;
		}
		
		$template = alsp_isTemplate($template);

		if ($template) {
			if ($return) {
				ob_start();
			}
		
			include($template);
			
			if ($return) {
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}
		}
	}
}

function alsp_getCurrentListingInAdmin() {
	global $alsp_instance;
	
	return $alsp_instance->current_listing;
}

function alsp_getAllDirectoryPages() {
	global $wpdb;
	
	$flat_index_pages = $wpdb->get_results("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_MAIN_SHORTCODE . "]%') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A);
	$custom_index_pages = $wpdb->get_results("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_MAIN_SHORTCODE . " %') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A);
	$index_pages = array_merge($flat_index_pages, $custom_index_pages);
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		foreach ($index_pages AS $key=>&$cpage) {
			if ($tpage = apply_filters('wpml_object_id', $cpage['id'], 'page')) {
				$cpage['id'] = $tpage;
				$cpage['slug'] = get_post($cpage['id'])->post_name;
			} else {
				unset($index_pages[$key]);
			}
		}
	}
	
	return array_unique($index_pages, SORT_REGULAR);
}

function alsp_getAllListingPages() {
	global $wpdb, $alsp_instance;
	
	$flat_listing_pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_LISTING_SHORTCODE . "]%' OR post_content LIKE '%[alsp-listing]%') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A);
	$custom_listing_pages = $wpdb->get_results("SELECT ID AS id FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_LISTING_SHORTCODE . " %' OR post_content LIKE '%[alsp-listing %') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A);
	$pages = array_merge($flat_listing_pages, $custom_listing_pages);
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		foreach ($pages AS $key=>&$cpage) {
			if ($tpage = apply_filters('wpml_object_id', $cpage['id'], 'page')) {
				$cpage['id'] = $tpage;
			} else {
				unset($pages[$key]);
			}
		}
	}
	
	$pages = array_unique($pages, SORT_REGULAR);
	
	$listing_pages = array();
	
	$shortcodes = array(ALSP_LISTING_SHORTCODE, 'alsp-listing');
	foreach ($pages AS $page_id) {
		$page_id = $page_id['id'];
		$pattern = get_shortcode_regex($shortcodes);
		if (preg_match_all('/'.$pattern.'/s', get_post($page_id)->post_content, $matches) && array_key_exists(2, $matches)) {
			foreach ($matches[2] AS $key=>$shortcode) {
				if (in_array($shortcode, $shortcodes)) {
					if (($attrs = shortcode_parse_atts($matches[3][$key]))) {
						if (isset($attrs['directory']) && is_numeric($attrs['directory']) && ($directory = $alsp_instance->directories->getDirectoryById($attrs['directory']))) {
							$listing_pages[$directory->id] = $page_id;
							break;
						} elseif (!isset($attrs['id'])) {
							$listing_pages[$alsp_instance->directories->getDefaultDirectory()->id] = $page_id;
							break;
						}
					} else {
						$listing_pages[$alsp_instance->directories->getDefaultDirectory()->id] = $page_id;
						break;
					}
				}
			}
		}
	}
	
	return $listing_pages;
}

function alsp_getIndexPage() {
	global $wp, $wp_query, $wpdb, $wp_rewrite, $alsp_instance;
	
	$curr_index_page = array('slug' => '', 'id' => 0, 'url' => '');

	$index_pages = $alsp_instance->index_pages_all;

	if (!$index_pages)
		return $curr_index_page;
	
	if (get_queried_object_id()) {
		foreach ($index_pages AS $page) {
			if ($page['id'] == get_queried_object_id()) {
				$curr_index_page = $page;
				break;
			}
		}
	}
	if (!$curr_index_page['id']) {
		if ($wp_rewrite->using_permalinks()) {
			if (wp_doing_ajax() && isset($_REQUEST['base_url'])) {
				$base_url = $_REQUEST['base_url'];
			} else {
				$base_url = home_url($wp->request);
			}
			$urls_length = array();
			foreach ($index_pages AS $page) {
				$page_url = get_permalink($page['id']);
				if (strpos($base_url, $page_url) !== FALSE)
					$urls_length[$page['id']] = strlen($page_url);
			}
			if ($urls_length) {
				asort($urls_length);
				$urls_length = array_keys($urls_length);
				$page_id = array_pop($urls_length);
				foreach ($index_pages AS $page) {
					if ($page['id'] == $page_id) {
						$curr_index_page = $page;
						break;
					}
				}
			}
		} else {
			$homepage = null;
			if (wp_doing_ajax() && isset($_REQUEST['base_url'])) {
				if (($base_url = wp_parse_args($_REQUEST['base_url'])) && isset($base_url['homepage']))
					$homepage = $base_url['homepage'];
			} else {
				$homepage = get_query_var('homepage');
			}
			foreach ($index_pages AS $page) {
				if ($page['id'] == $homepage) {
					$curr_index_page = $page;
					break;
				}
			}
		}
	}

	if (!$curr_index_page['id']) {
		$curr_index_page = $index_pages[0];
	}

	if ($curr_index_page['id']) {
		if ($wp_rewrite->using_permalinks())
			$curr_index_page['url'] = get_permalink($curr_index_page['id']);
		else
			// found that on some instances of WP "native" trailing slashes may be missing
			$curr_index_page['url'] = add_query_arg('page_id', $curr_index_page['id'], home_url('/'));
	}

	return $curr_index_page;
}

function alsp_getListingPage() {
	global $alsp_instance;
	
	$page_id = null;
	$curr_listing_page = array('slug' => '', 'id' => 0, 'url' => '');
	
	if ($alsp_instance->current_directory && isset($alsp_instance->listing_pages_all[$alsp_instance->current_directory->id])) {
		$page_id = $alsp_instance->listing_pages_all[$alsp_instance->current_directory->id];
	} else {
		// When directory was not installed yet - we can use only the 1st default directory
		if (get_option('alsp_installed_directory')) {
			$directory_id = $alsp_instance->directories->getDefaultDirectory()->id;
		} else {
			$directory_id = 1;
		}
		if (isset($alsp_instance->listing_pages_all[$directory_id])) {
			$page_id = $alsp_instance->listing_pages_all[$directory_id];
		}
	}

	if ($page_id) {
		$curr_listing_page['id'] = $page_id;
		$curr_listing_page['url'] = get_permalink($page_id);
		$curr_listing_page['slug'] = get_post($page_id)->post_name;
	}
	
	return $curr_listing_page;
}

function alsp_getTemplatePage($shortcode) {
	global $wpdb, $wp_rewrite;

	if (!($template_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE post_content LIKE '%[" . $shortcode . "]%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)))
		$template_page = array('slug' => '', 'id' => 0, 'url' => '');
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($tpage = apply_filters('wpml_object_id', $template_page['id'], 'page')) {
			$template_page['id'] = $tpage;
			$template_page['slug'] = get_post($template_page['id'])->post_name;
		} else 
			$template_page = array('slug' => '', 'id' => 0, 'url' => '');
	}

	if ($template_page['id']) {
		if ($wp_rewrite->using_permalinks())
			$template_page['url'] = get_permalink($template_page['id']);
		else
			// found that on some instances of WP "native" trailing slashes may be missing
			$template_page['url'] = add_query_arg('page_id', $template_page['id'], home_url('/'));
	}

	return $template_page;
}

function alsp_directoryUrl($path = '', $directory = null) {
	global $alsp_instance;
	
	if (empty($directory)) {
		$directory_page_url = $alsp_instance->index_page_url;
	} else {
		$directory_page_url = $directory->url;
	}
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$directory_page_url = remove_query_arg('lang', $directory_page_url);
		}
	}

	if (!is_array($path)) {
		if ($path)
			$path = rtrim($path, '/') . '/';
		// found that on some instances of WP "native" trailing slashes may be missing
		$url = rtrim($directory_page_url, '/') . '/' . $path;
	} else
		$url = add_query_arg($path, $directory_page_url);

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$url = $sitepress->convert_url($url);
	}
	
	$url = alsp_add_homepage_id($url);
	
	return utf8_uri_encode($url);
}

function alsp_templatePageUri($slug_array, $page_url) {
	global $alsp_instance;
	
	if ($page_url)
		$page_url = $page_url;
	else
		$page_url = $alsp_instance->index_page_url;
	
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$page_url = remove_query_arg('lang', $page_url);
		}
	}

	$template_url = add_query_arg($slug_array, $page_url);

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$template_url = $sitepress->convert_url($template_url);
	}
	
	$template_url = alsp_add_homepage_id($template_url);

	return utf8_uri_encode($template_url);
}

function alsp_add_homepage_id($url) {
	global $alsp_instance, $wp_rewrite;
	
	$homepage = null;
	if (wp_doing_ajax() && isset($base_url['homepage'])) {
		if ($base_url = wp_parse_args($_REQUEST['base_url']))
			$homepage = $base_url['homepage'];
	} else {
		$homepage = get_queried_object_id();
	}
	if (!$wp_rewrite->using_permalinks() && $homepage && count($alsp_instance->index_pages_all) > 1) {
		foreach ($alsp_instance->index_pages_all AS $page) {
			if ($page['id'] == $homepage) {
				$url = add_query_arg('homepage', $homepage, $url);
				break;
			}
		}
	}
	return $url;
}

function alsp_get_term_parents($id, $tax, $link = false, $return_array = false, $separator = '/', &$chain = array()) {
	$parent = get_term($id, $tax);
	if (is_wp_error($parent) || !$parent) {
		if ($return_array) {
			return array();
		} else { 
			return '';
		}
	}

	$name = $parent->name;
	
	if ($parent->parent && ($parent->parent != $parent->term_id)) {
		alsp_get_term_parents($parent->parent, $tax, $link, $return_array, $separator, $chain);
	}

	$url = get_term_link($parent->slug, $tax);
	if ($link && !is_wp_error($url)) {
		$chain[] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . $url . '" title="' . esc_attr(sprintf(__('View all listings in %s', 'ALSP'), $name)) . '"><span itemprop="name">' . $name . '</span></a></li>';
	} else {
		$chain[] = $name;
	}
	
	if ($return_array) {
		return $chain;
	} else {
		return implode($separator, $chain);
	}
}

function alsp_get_term_parents_slugs($id, $tax, &$chain = array()) {
	$parent = get_term($id, $tax);
	if (is_wp_error($parent) || !$parent) {
		return '';
	}

	$slug = $parent->slug;
	
	if ($parent->parent && ($parent->parent != $parent->term_id)) {
		alsp_get_term_parents_slugs($parent->parent, $tax, $chain);
	}

	$chain[] = $slug;

	return $chain;
}

function alsp_get_term_parents_ids($id, $tax, &$chain = array()) {
	$parent = get_term($id, $tax);
	if (is_wp_error($parent) || !$parent) {
		return '';
	}

	$id = $parent->term_id;
	
	if ($parent->parent && ($parent->parent != $parent->term_id)) {
		alsp_get_term_parents_ids($parent->parent, $tax, $chain);
	}

	$chain[] = $id;

	return $chain;
}

function alsp_checkQuickList($is_listing_id = null)
{
	if (isset($_COOKIE['favourites']))
		$favourites = explode('*', $_COOKIE['favourites']);
	else
		$favourites = array();
	$favourites = array_values(array_filter($favourites));

	if ($is_listing_id)
		if (in_array($is_listing_id, $favourites))
			return true;
		else 
			return false;

	$favourites_array = array();
	foreach ($favourites AS $listing_id)
		if (is_numeric($listing_id))
		$favourites_array[] = $listing_id;
	return $favourites_array;
}

function alsp_getDatePickerFormat() {
	$wp_date_format = get_option('date_format');
	return str_replace(
			array('S',  'd', 'j',  'l',  'm', 'n',  'F',  'Y'),
			array('',  'dd', 'd', 'DD', 'mm', 'm', 'MM', 'yy'),
		$wp_date_format);
}

function alsp_getDatePickerLangFile($locale) {
	if ($locale) {
		$_locale = explode('-', str_replace('_', '-', $locale));
		$lang_code = array_shift($_locale);
		if (is_file(ALSP_RESOURCES_PATH . 'js/i18n/datepicker-'.$locale.'.js'))
			return ALSP_RESOURCES_URL . 'js/i18n/datepicker-'.$locale.'.js';
		elseif (is_file(ALSP_RESOURCES_PATH . 'js/i18n/datepicker-'.$lang_code.'.js'))
			return ALSP_RESOURCES_URL . 'js/i18n/datepicker-'.$lang_code.'.js';
	}
}

function alsp_getDatePickerLangCode($locale) {
	if ($locale) {
		$_locale = explode('-', str_replace('_', '-', $locale));
		$lang_code = array_shift($_locale);
		if (is_file(ALSP_RESOURCES_PATH . 'js/i18n/datepicker-'.$locale.'.js'))
			return $locale;
		elseif (is_file(ALSP_RESOURCES_PATH . 'js/i18n/datepicker-'.$lang_code.'.js'))
			return $lang_code;
	}
}

function alsp_generateRandomVal($val = null) {
	if (!$val)
		return rand(1, 10000);
	else
		return $val;
}

/**
 * Fetch the IP Address
 *
 * @return	string
 */
function alsp_ip_address()
{
	if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	elseif (isset($_SERVER['REMOTE_ADDR']))
		$ip_address = $_SERVER['REMOTE_ADDR'];
	elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		return false;

	if (strstr($ip_address, ',')) {
		$x = explode(',', $ip_address);
		$ip_address = trim(end($x));
	}

	$validation = new alsp_form_validation();
	if (!$validation->valid_ip($ip_address))
		return false;

	return $ip_address;
}

function alsp_crop_content($limit = 35, $strip_html = true, $has_link = true, $nofollow = false, $readmore_text = false) {
	global $ALSP_ADIMN_SETTINGS;
	if (has_excerpt()) {
		$raw_content = apply_filters('the_excerpt', get_the_excerpt());
	} elseif ($ALSP_ADIMN_SETTINGS['alsp_cropped_content_as_excerpt'] && get_post()->post_content !== '') {
		$raw_content = apply_filters('the_content', get_the_content());
	} else {
		return ;
	}
	
	if (!$readmore_text) {
		$readmore_text = __('&#91;...&#93;', 'ALSP');
	}

	$raw_content = str_replace(']]>', ']]&gt;', $raw_content);
	if ($strip_html) {
		$raw_content = strip_tags($raw_content);
		$pattern = get_shortcode_regex();
		// Remove shortcodes from excerpt
		$raw_content = preg_replace_callback("/$pattern/s", 'alsp_remove_shortcodes', $raw_content);
	}

	if (!$limit) {
		return $raw_content;
	}
	
	if ($has_link) {
		$readmore = ' <a href="'.get_permalink(get_the_ID()).'" '.(($nofollow) ? 'rel="nofollow"' : '').' class="alsp-excerpt-link">'.$readmore_text.'</a>';
	} else {
		$readmore = ' ' . $readmore_text;
	}

	$content = explode(' ', $raw_content, $limit);
	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ", $content) . $readmore;
	} else {
		$content = $raw_content;
	}

	return $content;
}



// Remove shortcodes from excerpt
function alsp_remove_shortcodes($m) {
	if (function_exists('su_cmpt') && su_cmpt() !== false)
	if ($m[2] == su_cmpt() . 'dropcap' || $m[2] == su_cmpt() . 'highlight' || $m[2] == su_cmpt() . 'tooltip')
		return $m[0];

	// allow [[foo]] syntax for escaping a tag
	if ($m[1] == '[' && $m[6] == ']')
		return substr($m[0], 1, -1);

	return $m[1] . $m[6];
}

function alsp_is_anyone_in_taxonomy($tax) {
	//global $wpdb;
	//return $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->term_taxonomy . ' WHERE `taxonomy`="' . $tax . '"');
	
	return count(get_categories(array('taxonomy' => $tax, 'hide_empty' => false, 'parent' => 0, 'number' => 1)));
}

function alsp_comments_open() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'enabled' || ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'wp_settings' && comments_open()))
		return true;
	else 
		return false;
}

function alsp_get_term_by_path($term_path, $full_match = true, $output = OBJECT) {
	$term_path = rawurlencode( urldecode( $term_path ) );
	$term_path = str_replace( '%2F', '/', $term_path );
	$term_path = str_replace( '%20', ' ', $term_path );

	global $wp_rewrite;
	if ($wp_rewrite->using_permalinks()) {
		$term_paths = '/' . trim( $term_path, '/' );
		$leaf_path  = sanitize_title( basename( $term_paths ) );
		$term_paths = explode( '/', $term_paths );
		$full_path = '';
		foreach ( (array) $term_paths as $pathdir )
			$full_path .= ( $pathdir != '' ? '/' : '' ) . sanitize_title( $pathdir );
	
		//$terms = get_terms( array(ALSP_CATEGORIES_TAX, ALSP_LOCATIONS_TAX, ALSP_TAGS_TAX), array('get' => 'all', 'slug' => $leaf_path) );
		$terms = array();
		if ($term = get_term_by('slug', $leaf_path, ALSP_CATEGORIES_TAX))
			$terms[] = $term;
		if ($term = get_term_by('slug', $leaf_path, ALSP_TYPE_TAX))
			$terms[] = $term;
		if ($term = get_term_by('slug', $leaf_path, ALSP_LOCATIONS_TAX))
			$terms[] = $term;
		if ($term = get_term_by('slug', $leaf_path, ALSP_TAGS_TAX))
			$terms[] = $term;
	
		if ( empty( $terms ) )
			return null;
	
		foreach ( $terms as $term ) {
			$path = '/' . $leaf_path;
			$curterm = $term;
			while ( ( $curterm->parent != 0 ) && ( $curterm->parent != $curterm->term_id ) ) {
				$curterm = get_term( $curterm->parent, $term->taxonomy );
				if ( is_wp_error( $curterm ) )
					return $curterm;
				$path = '/' . $curterm->slug . $path;
			}

			if ( $path == $full_path ) {
				$term = get_term( $term->term_id, $term->taxonomy, $output );
				_make_cat_compat( $term );
				return $term;
			}
		}
	
		// If full matching is not required, return the first cat that matches the leaf.
		if ( ! $full_match ) {
			$term = reset( $terms );
			$term = get_term( $term->term_id, $term->taxonomy, $output );
			_make_cat_compat( $term );
			return $term;
		}
	} else {
		if ($term = get_term_by('slug', $term_path, ALSP_CATEGORIES_TAX))
			return $term;
		if ($term = get_term_by('slug', $term_path, ALSP_TYPE_TAX))
			return $term;
		if ($term = get_term_by('slug', $term_path, ALSP_LOCATIONS_TAX))
			return $term;
		if ($term = get_term_by('slug', $term_path, ALSP_TAGS_TAX))
			return $term;
	}

	return null;
}

function alsp_get_fa_icons_names() {
	$icons[] = 'pacz-fic1-agenda';
	$icons[] = 'pacz-fic1-ai';
	$icons[] = 'pacz-fic1-ambulance';
	$icons[] = 'pacz-fic1-ammeter';
	$icons[] = 'pacz-fic1-apple';
	$icons[] = 'pacz-fic1-arrow';
	$icons[] = 'pacz-fic1-arrows';
	$icons[] = 'pacz-fic1-attached';
	$icons[] = 'pacz-fic1-avatar';
	$icons[] = 'pacz-fic1-background';
	$icons[] = 'pacz-fic1-background-1';
	$icons[] = 'pacz-fic1-band-aid';
	$icons[] = 'pacz-fic1-barrel';
	$icons[] = 'pacz-fic1-battery';
	$icons[] = 'pacz-fic1-battery-1';
	$icons[] = 'pacz-fic1-battery-2';
	$icons[] = 'pacz-fic1-biodiesel';
	$icons[] = 'pacz-fic1-blueprint';
	$icons[] = 'pacz-fic1-blueprint-1';
	$icons[] = 'pacz-fic1-book';
	$icons[] = 'pacz-fic1-browser';
	$icons[] = 'pacz-fic1-browser-1';
	$icons[] = 'pacz-fic1-browser-2';
	$icons[] = 'pacz-fic1-building';
	$icons[] = 'pacz-fic1-building-1';
	$icons[] = 'pacz-fic1-charity';
	$icons[] = 'pacz-fic1-charity-1';
	$icons[] = 'pacz-fic1-chat';
	$icons[] = 'pacz-fic1-cloud-computing';
	$icons[] = 'pacz-fic1-coin';
	$icons[] = 'pacz-fic1-color-palette';
	$icons[] = 'pacz-fic1-compass';
	$icons[] = 'pacz-fic1-computer';
	$icons[] = 'pacz-fic1-computer-1';
	$icons[] = 'pacz-fic1-contract';
	$icons[] = 'pacz-fic1-css';
	$icons[] = 'pacz-fic1-cursor';
	$icons[] = 'pacz-fic1-cut';
	$icons[] = 'pacz-fic1-delivery-truck';
	$icons[] = 'pacz-fic1-desk';
	$icons[] = 'pacz-fic1-devices';
	$icons[] = 'pacz-fic1-devices-1';
	$icons[] = 'pacz-fic1-diagram';
	$icons[] = 'pacz-fic1-diamond';
	$icons[] = 'pacz-fic1-direction';
	$icons[] = 'pacz-fic1-direction-1';
	$icons[] = 'pacz-fic1-directional';
	$icons[] = 'pacz-fic1-distance';
	$icons[] = 'pacz-fic1-dna';
	$icons[] = 'pacz-fic1-donation';
	$icons[] = 'pacz-fic1-donation-1';
	$icons[] = 'pacz-fic1-donation-2';
	$icons[] = 'pacz-fic1-donation-3';
	$icons[] = 'pacz-fic1-donation-4';
	$icons[] = 'pacz-fic1-donation-5';
	$icons[] = 'pacz-fic1-dove';
	$icons[] = 'pacz-fic1-draw';
	$icons[] = 'pacz-fic1-drop';
	$icons[] = 'pacz-fic1-earth-globe';
	$icons[] = 'pacz-fic1-ecology';
	$icons[] = 'pacz-fic1-ecology-1';
	$icons[] = 'pacz-fic1-ecology-2';
	$icons[] = 'pacz-fic1-ecology-3';
	$icons[] = 'pacz-fic1-electric-car';
	$icons[] = 'pacz-fic1-engineer';
	$icons[] = 'pacz-fic1-expand';
	$icons[] = 'pacz-fic1-factory';
	$icons[] = 'pacz-fic1-factory-1';
	$icons[] = 'pacz-fic1-favorite';
	$icons[] = 'pacz-fic1-file';
	$icons[] = 'pacz-fic1-file-1';
	$icons[] = 'pacz-fic1-file-2';
	$icons[] = 'pacz-fic1-file-3';
	$icons[] = 'pacz-fic1-first-aid-kit';
	$icons[] = 'pacz-fic1-folder';
	$icons[] = 'pacz-fic1-folder-1';
	$icons[] = 'pacz-fic1-folder-2';
	$icons[] = 'pacz-fic1-for-sale';
	$icons[] = 'pacz-fic1-gandhi';
	$icons[] = 'pacz-fic1-garbage';
	$icons[] = 'pacz-fic1-gas-station';
	$icons[] = 'pacz-fic1-generator';
	$icons[] = 'pacz-fic1-geolocalization';
	$icons[] = 'pacz-fic1-global';
	$icons[] = 'pacz-fic1-global-warming';
	$icons[] = 'pacz-fic1-graphic-design';
	$icons[] = 'pacz-fic1-graphic-design-1';
	$icons[] = 'pacz-fic1-graphic-design-2';
	$icons[] = 'pacz-fic1-graphic-design-3';
	$icons[] = 'pacz-fic1-group';
	$icons[] = 'pacz-fic1-group-1';
	$icons[] = 'pacz-fic1-growth';
	$icons[] = 'pacz-fic1-hand';
	$icons[] = 'pacz-fic1-heart';
	$icons[] = 'pacz-fic1-hospital';
	$icons[] = 'pacz-fic1-house';
	$icons[] = 'pacz-fic1-house-1';
	$icons[] = 'pacz-fic1-house-2';
	$icons[] = 'pacz-fic1-house-3';
	$icons[] = 'pacz-fic1-house-4';
	$icons[] = 'pacz-fic1-house-5';
	$icons[] = 'pacz-fic1-house-6';
	$icons[] = 'pacz-fic1-house-7';
	$icons[] = 'pacz-fic1-html';
	$icons[] = 'pacz-fic1-hydro-power';
	$icons[] = 'pacz-fic1-image';
	$icons[] = 'pacz-fic1-image-1';
	$icons[] = 'pacz-fic1-image-2';
	$icons[] = 'pacz-fic1-infographic';
	$icons[] = 'pacz-fic1-injury';
	$icons[] = 'pacz-fic1-interface';
	$icons[] = 'pacz-fic1-interface-1';
	$icons[] = 'pacz-fic1-interface-2';
	$icons[] = 'pacz-fic1-interface-3';
	$icons[] = 'pacz-fic1-interface-4';
	$icons[] = 'pacz-fic1-key';
	$icons[] = 'pacz-fic1-keyboard';
	$icons[] = 'pacz-fic1-landing-page';
	$icons[] = 'pacz-fic1-levels';
	$icons[] = 'pacz-fic1-light-bulb';
	$icons[] = 'pacz-fic1-light-bulb-1';
	$icons[] = 'pacz-fic1-light-bulb-2';
	$icons[] = 'pacz-fic1-light-bulb-3';
	$icons[] = 'pacz-fic1-link';
	$icons[] = 'pacz-fic1-locations';
	$icons[] = 'pacz-fic1-lungs';
	$icons[] = 'pacz-fic1-map';
	$icons[] = 'pacz-fic1-map-1';
	$icons[] = 'pacz-fic1-map-2';
	$icons[] = 'pacz-fic1-medical-history';
	$icons[] = 'pacz-fic1-medicine';
	$icons[] = 'pacz-fic1-medicine-1';
	$icons[] = 'pacz-fic1-medicine-2';
	$icons[] = 'pacz-fic1-money';
	$icons[] = 'pacz-fic1-monitor';
	$icons[] = 'pacz-fic1-mortgage';
	$icons[] = 'pacz-fic1-mortgage-1';
	$icons[] = 'pacz-fic1-mouse';
	$icons[] = 'pacz-fic1-multimedia';
	$icons[] = 'pacz-fic1-networking';
	$icons[] = 'pacz-fic1-nurse';
	$icons[] = 'pacz-fic1-oil';
	$icons[] = 'pacz-fic1-olive';
	$icons[] = 'pacz-fic1-package';
	$icons[] = 'pacz-fic1-paint';
	$icons[] = 'pacz-fic1-paint-roller';
	$icons[] = 'pacz-fic1-password';
	$icons[] = 'pacz-fic1-pencil';
	$icons[] = 'pacz-fic1-photo-camera';
	$icons[] = 'pacz-fic1-pill';
	$icons[] = 'pacz-fic1-placeholder';
	$icons[] = 'pacz-fic1-placeholder-1';
	$icons[] = 'pacz-fic1-placeholder-2';
	$icons[] = 'pacz-fic1-placeholder-3';
	$icons[] = 'pacz-fic1-placeholder-4';
	$icons[] = 'pacz-fic1-placeholder-5';
	$icons[] = 'pacz-fic1-placeholder-6';
	$icons[] = 'pacz-fic1-placeholder-7';
	$icons[] = 'pacz-fic1-planet-earth';
	$icons[] = 'pacz-fic1-plant';
	$icons[] = 'pacz-fic1-plug';
	$icons[] = 'pacz-fic1-pollution';
	$icons[] = 'pacz-fic1-position';
	$icons[] = 'pacz-fic1-position-1';
	$icons[] = 'pacz-fic1-position-2';
	$icons[] = 'pacz-fic1-position-3';
	$icons[] = 'pacz-fic1-position-4';
	$icons[] = 'pacz-fic1-power';
	$icons[] = 'pacz-fic1-praying';
	$icons[] = 'pacz-fic1-profile';
	$icons[] = 'pacz-fic1-psd';
	$icons[] = 'pacz-fic1-pumpjack';
	$icons[] = 'pacz-fic1-real-estate';
	$icons[] = 'pacz-fic1-recycled-bag';
	$icons[] = 'pacz-fic1-renewable-energy';
	$icons[] = 'pacz-fic1-renewable-energy-1';
	$icons[] = 'pacz-fic1-rgb';
	$icons[] = 'pacz-fic1-ribbon';
	$icons[] = 'pacz-fic1-route';
	$icons[] = 'pacz-fic1-route-1';
	$icons[] = 'pacz-fic1-ruler';
	$icons[] = 'pacz-fic1-satellite-dish';
	$icons[] = 'pacz-fic1-science';
	$icons[] = 'pacz-fic1-scissors';
	$icons[] = 'pacz-fic1-search';
	$icons[] = 'pacz-fic1-search-1';
	$icons[] = 'pacz-fic1-shopping';
	$icons[] = 'pacz-fic1-signpost';
	$icons[] = 'pacz-fic1-signs';
	$icons[] = 'pacz-fic1-sketchbook';
	$icons[] = 'pacz-fic1-social';
	$icons[] = 'pacz-fic1-socket';
	$icons[] = 'pacz-fic1-solar-panel';
	$icons[] = 'pacz-fic1-street-map';
	$icons[] = 'pacz-fic1-street-map-1';
	$icons[] = 'pacz-fic1-street-map-2';
	$icons[] = 'pacz-fic1-surgeon';
	$icons[] = 'pacz-fic1-syringe';
	$icons[] = 'pacz-fic1-tank';
	$icons[] = 'pacz-fic1-tap';
	$icons[] = 'pacz-fic1-target';
	$icons[] = 'pacz-fic1-target-1';
	$icons[] = 'pacz-fic1-target-2';
	$icons[] = 'pacz-fic1-tea-cup';
	$icons[] = 'pacz-fic1-teamwork';
	$icons[] = 'pacz-fic1-technology';
	$icons[] = 'pacz-fic1-technology-1';
	$icons[] = 'pacz-fic1-technology-2';
	$icons[] = 'pacz-fic1-technology-3';
	$icons[] = 'pacz-fic1-technology-4';
	$icons[] = 'pacz-fic1-technology-5';
	$icons[] = 'pacz-fic1-technology-6';
	$icons[] = 'pacz-fic1-tesla-coil';
	$icons[] = 'pacz-fic1-text-editor';
	$icons[] = 'pacz-fic1-text-editor-1';
	$icons[] = 'pacz-fic1-thermometer';
	$icons[] = 'pacz-fic1-tooth';
	$icons[] = 'pacz-fic1-transfusion';
	$icons[] = 'pacz-fic1-travel';
	$icons[] = 'pacz-fic1-vector';
	$icons[] = 'pacz-fic1-vector-1';
	$icons[] = 'pacz-fic1-video-player';
	$icons[] = 'pacz-fic1-wagon';
	$icons[] = 'pacz-fic1-web';
	$icons[] = 'pacz-fic1-web-1';
	$icons[] = 'pacz-fic1-web-2';
	$icons[] = 'pacz-fic1-web-3';
	$icons[] = 'pacz-fic1-web-4';
	$icons[] = 'pacz-fic1-web-5';
	$icons[] = 'pacz-fic1-web-design';
	$icons[] = 'pacz-fic1-website';
	$icons[] = 'pacz-fic1-wheelchair';
	$icons[] = 'pacz-fic1-wind-engine';
	$icons[] = 'pacz-fic1-wind-rose';
	$icons[] = 'pacz-fic1-windmill';
	$icons[] = 'pacz-fic1-witch';
	$icons[] = 'pacz-fic1-worldwide';
	$icons[] = 'pacz-fic1-write';
	$icons[] = 'pacz-fic2-abacus';
	$icons[] = 'pacz-fic2-air-conditioner';
	$icons[] = 'pacz-fic2-air-conditioner-1';
	$icons[] = 'pacz-fic2-artichoke';
	$icons[] = 'pacz-fic2-balcony';
	$icons[] = 'pacz-fic2-bar';
	$icons[] = 'pacz-fic2-bar-1';
	$icons[] = 'pacz-fic2-beer';
	$icons[] = 'pacz-fic2-beer-1';
	$icons[] = 'pacz-fic2-bell';
	$icons[] = 'pacz-fic2-bell-pepper';
	$icons[] = 'pacz-fic2-bench';
	$icons[] = 'pacz-fic2-bicycle';
	$icons[] = 'pacz-fic2-birthday-cake';
	$icons[] = 'pacz-fic2-blackboard';
	$icons[] = 'pacz-fic2-blackboard-1';
	$icons[] = 'pacz-fic2-blueprint';
	$icons[] = 'pacz-fic2-blueprint-1';
	$icons[] = 'pacz-fic2-blueprint-2';
	$icons[] = 'pacz-fic2-book';
	$icons[] = 'pacz-fic2-books';
	$icons[] = 'pacz-fic2-books-1';
	$icons[] = 'pacz-fic2-bread';
	$icons[] = 'pacz-fic2-brickwall';
	$icons[] = 'pacz-fic2-brickwall-1';
	$icons[] = 'pacz-fic2-broccoli';
	$icons[] = 'pacz-fic2-building';
	$icons[] = 'pacz-fic2-building-1';
	$icons[] = 'pacz-fic2-burger';
	$icons[] = 'pacz-fic2-burrito';
	$icons[] = 'pacz-fic2-bus';
	$icons[] = 'pacz-fic2-business';
	$icons[] = 'pacz-fic2-cabbage';
	$icons[] = 'pacz-fic2-calculator';
	$icons[] = 'pacz-fic2-car';
	$icons[] = 'pacz-fic2-carrot';
	$icons[] = 'pacz-fic2-champagne';
	$icons[] = 'pacz-fic2-check';
	$icons[] = 'pacz-fic2-cheese';
	$icons[] = 'pacz-fic2-cheese-burger';
	$icons[] = 'pacz-fic2-cherries';
	$icons[] = 'pacz-fic2-city-hall';
	$icons[] = 'pacz-fic2-city-hall-1';
	$icons[] = 'pacz-fic2-cityscape';
	$icons[] = 'pacz-fic2-compass';
	$icons[] = 'pacz-fic2-computer';
	$icons[] = 'pacz-fic2-computer-1';
	$icons[] = 'pacz-fic2-concrete-mixer';
	$icons[] = 'pacz-fic2-construction';
	$icons[] = 'pacz-fic2-construction-1';
	$icons[] = 'pacz-fic2-construction-2';
	$icons[] = 'pacz-fic2-construction-3';
	$icons[] = 'pacz-fic2-construction-4';
	$icons[] = 'pacz-fic2-construction-5';
	$icons[] = 'pacz-fic2-construction-6';
	$icons[] = 'pacz-fic2-construction-7';
	$icons[] = 'pacz-fic2-cooking';
	$icons[] = 'pacz-fic2-crab';
	$icons[] = 'pacz-fic2-crane';
	$icons[] = 'pacz-fic2-cutlery';
	$icons[] = 'pacz-fic2-cutlery-1';
	$icons[] = 'pacz-fic2-cutlery-2';
	$icons[] = 'pacz-fic2-decoration';
	$icons[] = 'pacz-fic2-decoration-1';
	$icons[] = 'pacz-fic2-devices';
	$icons[] = 'pacz-fic2-devices-1';
	$icons[] = 'pacz-fic2-devices-2';
	$icons[] = 'pacz-fic2-diploma';
	$icons[] = 'pacz-fic2-document';
	$icons[] = 'pacz-fic2-documents';
	$icons[] = 'pacz-fic2-door';
	$icons[] = 'pacz-fic2-doughnut';
	$icons[] = 'pacz-fic2-drawing';
	$icons[] = 'pacz-fic2-driller';
	$icons[] = 'pacz-fic2-drink';
	$icons[] = 'pacz-fic2-drink-1';
	$icons[] = 'pacz-fic2-drink-2';
	$icons[] = 'pacz-fic2-drink-3';
	$icons[] = 'pacz-fic2-earth-globe';
	$icons[] = 'pacz-fic2-eggplant';
	$icons[] = 'pacz-fic2-elevator';
	$icons[] = 'pacz-fic2-exam';
	$icons[] = 'pacz-fic2-exam-1';
	$icons[] = 'pacz-fic2-faucet';
	$icons[] = 'pacz-fic2-fence';
	$icons[] = 'pacz-fic2-ferris';
	$icons[] = 'pacz-fic2-fish';
	$icons[] = 'pacz-fic2-food';
	$icons[] = 'pacz-fic2-food-1';
	$icons[] = 'pacz-fic2-food-10';
	$icons[] = 'pacz-fic2-food-11';
	$icons[] = 'pacz-fic2-food-12';
	$icons[] = 'pacz-fic2-food-13';
	$icons[] = 'pacz-fic2-food-14';
	$icons[] = 'pacz-fic2-food-15';
	$icons[] = 'pacz-fic2-food-16';
	$icons[] = 'pacz-fic2-food-17';
	$icons[] = 'pacz-fic2-food-18';
	$icons[] = 'pacz-fic2-food-19';
	$icons[] = 'pacz-fic2-food-2';
	$icons[] = 'pacz-fic2-food-20';
	$icons[] = 'pacz-fic2-food-21';
	$icons[] = 'pacz-fic2-food-22';
	$icons[] = 'pacz-fic2-food-23';
	$icons[] = 'pacz-fic2-food-24';
	$icons[] = 'pacz-fic2-food-25';
	$icons[] = 'pacz-fic2-food-26';
	$icons[] = 'pacz-fic2-food-3';
	$icons[] = 'pacz-fic2-food-4';
	$icons[] = 'pacz-fic2-food-5';
	$icons[] = 'pacz-fic2-food-6';
	$icons[] = 'pacz-fic2-food-7';
	$icons[] = 'pacz-fic2-food-8';
	$icons[] = 'pacz-fic2-food-9';
	$icons[] = 'pacz-fic2-fountain';
	$icons[] = 'pacz-fic2-french-fries';
	$icons[] = 'pacz-fic2-fruit';
	$icons[] = 'pacz-fic2-fruit-1';
	$icons[] = 'pacz-fic2-fruit-2';
	$icons[] = 'pacz-fic2-fruit-3';
	$icons[] = 'pacz-fic2-grapes';
	$icons[] = 'pacz-fic2-hammer';
	$icons[] = 'pacz-fic2-hangar';
	$icons[] = 'pacz-fic2-hard-drive';
	$icons[] = 'pacz-fic2-heater';
	$icons[] = 'pacz-fic2-helmet';
	$icons[] = 'pacz-fic2-high-voltage';
	$icons[] = 'pacz-fic2-home';
	$icons[] = 'pacz-fic2-home-1';
	$icons[] = 'pacz-fic2-hot-air-balloon';
	$icons[] = 'pacz-fic2-house';
	$icons[] = 'pacz-fic2-house-1';
	$icons[] = 'pacz-fic2-ice-cream';
	$icons[] = 'pacz-fic2-imac';
	$icons[] = 'pacz-fic2-imac-1';
	$icons[] = 'pacz-fic2-ink';
	$icons[] = 'pacz-fic2-interface';
	$icons[] = 'pacz-fic2-ipad';
	$icons[] = 'pacz-fic2-iphone';
	$icons[] = 'pacz-fic2-kettle';
	$icons[] = 'pacz-fic2-key';
	$icons[] = 'pacz-fic2-keyboard';
	$icons[] = 'pacz-fic2-kitchen';
	$icons[] = 'pacz-fic2-kitchen-utensils';
	$icons[] = 'pacz-fic2-kitchen-utensils-1';
	$icons[] = 'pacz-fic2-kiwi';
	$icons[] = 'pacz-fic2-knife';
	$icons[] = 'pacz-fic2-ladder';
	$icons[] = 'pacz-fic2-lamp';
	$icons[] = 'pacz-fic2-laptop';
	$icons[] = 'pacz-fic2-lemon';
	$icons[] = 'pacz-fic2-lemonade';
	$icons[] = 'pacz-fic2-letter';
	$icons[] = 'pacz-fic2-library';
	$icons[] = 'pacz-fic2-line-chart';
	$icons[] = 'pacz-fic2-lock';
	$icons[] = 'pacz-fic2-mailbox';
	$icons[] = 'pacz-fic2-mansion';
	$icons[] = 'pacz-fic2-measuring-tape';
	$icons[] = 'pacz-fic2-metro';
	$icons[] = 'pacz-fic2-microchip';
	$icons[] = 'pacz-fic2-mobile-phone';
	$icons[] = 'pacz-fic2-monument';
	$icons[] = 'pacz-fic2-mortarboard';
	$icons[] = 'pacz-fic2-motherboard';
	$icons[] = 'pacz-fic2-mouse';
	$icons[] = 'pacz-fic2-muffin';
	$icons[] = 'pacz-fic2-multimedia';
	$icons[] = 'pacz-fic2-multimedia-1';
	$icons[] = 'pacz-fic2-office';
	$icons[] = 'pacz-fic2-office-block';
	$icons[] = 'pacz-fic2-olive-oil';
	$icons[] = 'pacz-fic2-olives';
	$icons[] = 'pacz-fic2-open-book';
	$icons[] = 'pacz-fic2-orange';
	$icons[] = 'pacz-fic2-padlock';
	$icons[] = 'pacz-fic2-paint-brush';
	$icons[] = 'pacz-fic2-pancakes';
	$icons[] = 'pacz-fic2-parking';
	$icons[] = 'pacz-fic2-parquet';
	$icons[] = 'pacz-fic2-pear';
	$icons[] = 'pacz-fic2-pineapple';
	$icons[] = 'pacz-fic2-pipe';
	$icons[] = 'pacz-fic2-pizza';
	$icons[] = 'pacz-fic2-plug';
	$icons[] = 'pacz-fic2-portfolio';
	$icons[] = 'pacz-fic2-professor';
	$icons[] = 'pacz-fic2-radish';
	$icons[] = 'pacz-fic2-rice';
	$icons[] = 'pacz-fic2-roast-chicken';
	$icons[] = 'pacz-fic2-robot';
	$icons[] = 'pacz-fic2-roller';
	$icons[] = 'pacz-fic2-salad';
	$icons[] = 'pacz-fic2-saw';
	$icons[] = 'pacz-fic2-school-material';
	$icons[] = 'pacz-fic2-scooter';
	$icons[] = 'pacz-fic2-screw';
	$icons[] = 'pacz-fic2-screwdriver';
	$icons[] = 'pacz-fic2-search';
	$icons[] = 'pacz-fic2-shrimp';
	$icons[] = 'pacz-fic2-signs';
	$icons[] = 'pacz-fic2-skyscraper';
	$icons[] = 'pacz-fic2-skyscraper-1';
	$icons[] = 'pacz-fic2-smartphone';
	$icons[] = 'pacz-fic2-smartwatch';
	$icons[] = 'pacz-fic2-soda';
	$icons[] = 'pacz-fic2-soda-1';
	$icons[] = 'pacz-fic2-soda-2';
	$icons[] = 'pacz-fic2-soup';
	$icons[] = 'pacz-fic2-spaghetti';
	$icons[] = 'pacz-fic2-spoon';
	$icons[] = 'pacz-fic2-strawberry';
	$icons[] = 'pacz-fic2-student';
	$icons[] = 'pacz-fic2-student-1';
	$icons[] = 'pacz-fic2-technology';
	$icons[] = 'pacz-fic2-technology-1';
	$icons[] = 'pacz-fic2-tomato';
	$icons[] = 'pacz-fic2-tool';
	$icons[] = 'pacz-fic2-tools';
	$icons[] = 'pacz-fic2-traffic-light';
	$icons[] = 'pacz-fic2-traffic-light-1';
	$icons[] = 'pacz-fic2-travel';
	$icons[] = 'pacz-fic2-trowel';
	$icons[] = 'pacz-fic2-truck';
	$icons[] = 'pacz-fic2-truck-1';
	$icons[] = 'pacz-fic2-university';
	$icons[] = 'pacz-fic2-vehicle';
	$icons[] = 'pacz-fic2-wall';
	$icons[] = 'pacz-fic2-water';
	$icons[] = 'pacz-fic2-water-1';
	$icons[] = 'pacz-fic2-window';
	$icons[] = 'pacz-fic2-wine-glass';
	$icons[] = 'pacz-fic2-wine-glass-1';
	$icons[] = 'pacz-fic2-wrench';
	$icons[] = 'pacz-fic2-wristwatch';
	$icons[] = 'pacz-fic-alien';
	$icons[] = 'pacz-fic-ambulance';
	$icons[] = 'pacz-fic-ambulance-1';
	$icons[] = 'pacz-fic-aries';
	$icons[] = 'pacz-fic-armchair';
	$icons[] = 'pacz-fic-baby';
	$icons[] = 'pacz-fic-baby-1';
	$icons[] = 'pacz-fic-baby-girl';
	$icons[] = 'pacz-fic-back';
	$icons[] = 'pacz-fic-balance';
	$icons[] = 'pacz-fic-bar-chart';
	$icons[] = 'pacz-fic-bar-chart-1';
	$icons[] = 'pacz-fic-battery';
	$icons[] = 'pacz-fic-battery-1';
	$icons[] = 'pacz-fic-battery-2';
	$icons[] = 'pacz-fic-battery-3';
	$icons[] = 'pacz-fic-battery-4';
	$icons[] = 'pacz-fic-bedside-table';
	$icons[] = 'pacz-fic-beer';
	$icons[] = 'pacz-fic-binoculars';
	$icons[] = 'pacz-fic-blind';
	$icons[] = 'pacz-fic-book';
	$icons[] = 'pacz-fic-cancer';
	$icons[] = 'pacz-fic-car';
	$icons[] = 'pacz-fic-car-1';
	$icons[] = 'pacz-fic-car-2';
	$icons[] = 'pacz-fic-center-alignment';
	$icons[] = 'pacz-fic-center-alignment-1';
	$icons[] = 'pacz-fic-chicken';
	$icons[] = 'pacz-fic-chicken-1';
	$icons[] = 'pacz-fic-chicken-2';
	$icons[] = 'pacz-fic-clock';
	$icons[] = 'pacz-fic-clock-1';
	$icons[] = 'pacz-fic-clock-2';
	$icons[] = 'pacz-fic-clock-3';
	$icons[] = 'pacz-fic-clock-4';
	$icons[] = 'pacz-fic-cloud';
	$icons[] = 'pacz-fic-cloud-1';
	$icons[] = 'pacz-fic-cloud-2';
	$icons[] = 'pacz-fic-cloud-computing';
	$icons[] = 'pacz-fic-cloudy';
	$icons[] = 'pacz-fic-coins';
	$icons[] = 'pacz-fic-compass';
	$icons[] = 'pacz-fic-conga';
	$icons[] = 'pacz-fic-copy';
	$icons[] = 'pacz-fic-corndog';
	$icons[] = 'pacz-fic-cow';
	$icons[] = 'pacz-fic-customer-service';
	$icons[] = 'pacz-fic-cutlery';
	$icons[] = 'pacz-fic-diagonal-arrow';
	$icons[] = 'pacz-fic-diagonal-arrow-1';
	$icons[] = 'pacz-fic-diagonal-arrow-2';
	$icons[] = 'pacz-fic-diagonal-arrow-3';
	$icons[] = 'pacz-fic-diamond';
	$icons[] = 'pacz-fic-diaper';
	$icons[] = 'pacz-fic-download';
	$icons[] = 'pacz-fic-download-1';
	$icons[] = 'pacz-fic-electric-guitar';
	$icons[] = 'pacz-fic-emoticon';
	$icons[] = 'pacz-fic-export';
	$icons[] = 'pacz-fic-eye';
	$icons[] = 'pacz-fic-eye-1';
	$icons[] = 'pacz-fic-feeding-bottle';
	$icons[] = 'pacz-fic-file';
	$icons[] = 'pacz-fic-file-1';
	$icons[] = 'pacz-fic-file-2';
	$icons[] = 'pacz-fic-file-3';
	$icons[] = 'pacz-fic-film-strip';
	$icons[] = 'pacz-fic-flag';
	$icons[] = 'pacz-fic-flash';
	$icons[] = 'pacz-fic-fork';
	$icons[] = 'pacz-fic-fountain-pen';
	$icons[] = 'pacz-fic-fountain-pen-1';
	$icons[] = 'pacz-fic-fountain-pen-2';
	$icons[] = 'pacz-fic-fountain-pen-3';
	$icons[] = 'pacz-fic-fountain-pen-4';
	$icons[] = 'pacz-fic-gemini';
	$icons[] = 'pacz-fic-glass-of-water';
	$icons[] = 'pacz-fic-guitar';
	$icons[] = 'pacz-fic-ham';
	$icons[] = 'pacz-fic-happy';
	$icons[] = 'pacz-fic-happy-1';
	$icons[] = 'pacz-fic-head';
	$icons[] = 'pacz-fic-heavy-metal';
	$icons[] = 'pacz-fic-home';
	$icons[] = 'pacz-fic-home-1';
	$icons[] = 'pacz-fic-home-2';
	$icons[] = 'pacz-fic-home-3';
	$icons[] = 'pacz-fic-home-4';
	$icons[] = 'pacz-fic-horse';
	$icons[] = 'pacz-fic-id-card';
	$icons[] = 'pacz-fic-jar';
	$icons[] = 'pacz-fic-justify';
	$icons[] = 'pacz-fic-laundry';
	$icons[] = 'pacz-fic-laundry-1';
	$icons[] = 'pacz-fic-laundry-2';
	$icons[] = 'pacz-fic-laundry-3';
	$icons[] = 'pacz-fic-laundry-4';
	$icons[] = 'pacz-fic-laundry-5';
	$icons[] = 'pacz-fic-left-alignment';
	$icons[] = 'pacz-fic-left-alignment-1';
	$icons[] = 'pacz-fic-lemon';
	$icons[] = 'pacz-fic-lemon-1';
	$icons[] = 'pacz-fic-lemonade';
	$icons[] = 'pacz-fic-lemonade-1';
	$icons[] = 'pacz-fic-leo';
	$icons[] = 'pacz-fic-light-bulb';
	$icons[] = 'pacz-fic-like';
	$icons[] = 'pacz-fic-mail';
	$icons[] = 'pacz-fic-mail-1';
	$icons[] = 'pacz-fic-mail-2';
	$icons[] = 'pacz-fic-mail-3';
	$icons[] = 'pacz-fic-mail-4';
	$icons[] = 'pacz-fic-mail-5';
	$icons[] = 'pacz-fic-man';
	$icons[] = 'pacz-fic-man-1';
	$icons[] = 'pacz-fic-map';
	$icons[] = 'pacz-fic-maths';
	$icons[] = 'pacz-fic-medical-result';
	$icons[] = 'pacz-fic-money';
	$icons[] = 'pacz-fic-monitor';
	$icons[] = 'pacz-fic-monitor-1';
	$icons[] = 'pacz-fic-monitor-2';
	$icons[] = 'pacz-fic-monitor-3';
	$icons[] = 'pacz-fic-monitor-4';
	$icons[] = 'pacz-fic-monitor-5';
	$icons[] = 'pacz-fic-muted';
	$icons[] = 'pacz-fic-next';
	$icons[] = 'pacz-fic-ninja';
	$icons[] = 'pacz-fic-padlock';
	$icons[] = 'pacz-fic-padlock-1';
	$icons[] = 'pacz-fic-pear';
	$icons[] = 'pacz-fic-phone-call';
	$icons[] = 'pacz-fic-phone-call-1';
	$icons[] = 'pacz-fic-phone-call-2';
	$icons[] = 'pacz-fic-phone-call-3';
	$icons[] = 'pacz-fic-photo-camera';
	$icons[] = 'pacz-fic-pie-chart';
	$icons[] = 'pacz-fic-pie-chart-1';
	$icons[] = 'pacz-fic-piggy-bank';
	$icons[] = 'pacz-fic-pin';
	$icons[] = 'pacz-fic-placeholder';
	$icons[] = 'pacz-fic-placeholder-1';
	$icons[] = 'pacz-fic-placeholder-2';
	$icons[] = 'pacz-fic-plug';
	$icons[] = 'pacz-fic-plug-1';
	$icons[] = 'pacz-fic-pointing';
	$icons[] = 'pacz-fic-rain';
	$icons[] = 'pacz-fic-right-alignment';
	$icons[] = 'pacz-fic-right-alignment-1';
	$icons[] = 'pacz-fic-rolling-pin';
	$icons[] = 'pacz-fic-ruler';
	$icons[] = 'pacz-fic-ruler-1';
	$icons[] = 'pacz-fic-sad';
	$icons[] = 'pacz-fic-saturn';
	$icons[] = 'pacz-fic-saturn-1';
	$icons[] = 'pacz-fic-sausage';
	$icons[] = 'pacz-fic-sheep';
	$icons[] = 'pacz-fic-sheep-1';
	$icons[] = 'pacz-fic-shield';
	$icons[] = 'pacz-fic-shop';
	$icons[] = 'pacz-fic-shopping-bag';
	$icons[] = 'pacz-fic-shopping-basket';
	$icons[] = 'pacz-fic-smartphone';
	$icons[] = 'pacz-fic-smartphone-1';
	$icons[] = 'pacz-fic-smartphone-2';
	$icons[] = 'pacz-fic-smartphone-3';
	$icons[] = 'pacz-fic-smile';
	$icons[] = 'pacz-fic-socket';
	$icons[] = 'pacz-fic-speech-bubble';
	$icons[] = 'pacz-fic-speech-bubble-1';
	$icons[] = 'pacz-fic-speech-bubble-2';
	$icons[] = 'pacz-fic-speech-bubble-3';
	$icons[] = 'pacz-fic-spoon';
	$icons[] = 'pacz-fic-sun';
	$icons[] = 'pacz-fic-surprised';
	$icons[] = 'pacz-fic-syringe';
	$icons[] = 'pacz-fic-table';
	$icons[] = 'pacz-fic-tap';
	$icons[] = 'pacz-fic-tap-1';
	$icons[] = 'pacz-fic-tap-2';
	$icons[] = 'pacz-fic-taurus';
	$icons[] = 'pacz-fic-telephone';
	$icons[] = 'pacz-fic-toaster';
	$icons[] = 'pacz-fic-ufo';
	$icons[] = 'pacz-fic-upload';
	$icons[] = 'pacz-fic-upload-1';
	$icons[] = 'pacz-fic-van';
	$icons[] = 'pacz-fic-victory';
	$icons[] = 'pacz-fic-video-camera';
	$icons[] = 'pacz-fic-video-camera-1';
	$icons[] = 'pacz-fic-watermelon';
	$icons[] = 'pacz-fic-weight';
	$icons[] = 'pacz-fic-wifi';
	$icons[] = 'pacz-fic-wifi-1';
	$icons[] = 'pacz-fic-wifi-2';
	$icons[] = 'pacz-fic-wifi-3';
	$icons[] = 'pacz-fic-woman';
	$icons[] = 'pacz-fic-woman-1';
	$icons[] = 'pacz-fic-zip';
	$icons[] = 'pacz-flaticon-amplified';
	$icons[] = 'pacz-flaticon-arrow434';
	$icons[] = 'pacz-flaticon-arrow435';
	$icons[] = 'pacz-flaticon-arrow436';
	$icons[] = 'pacz-flaticon-arrow437';
	$icons[] = 'pacz-flaticon-arrowhead4';
	$icons[] = 'pacz-flaticon-audio28';
	$icons[] = 'pacz-flaticon-battery74';
	$icons[] = 'pacz-flaticon-big80';
	$icons[] = 'pacz-flaticon-big81';
	$icons[] = 'pacz-flaticon-blank20';
	$icons[] = 'pacz-flaticon-camera43';
	$icons[] = 'pacz-flaticon-cassette7';
	$icons[] = 'pacz-flaticon-cinema13';
	$icons[] = 'pacz-flaticon-circular45';
	$icons[] = 'pacz-flaticon-circular46';
	$icons[] = 'pacz-flaticon-circular47';
	$icons[] = 'pacz-flaticon-circular48';
	$icons[] = 'pacz-flaticon-circular49';
	$icons[] = 'pacz-flaticon-circular50';
	$icons[] = 'pacz-flaticon-cloud102';
	$icons[] = 'pacz-flaticon-cloudy12';
	$icons[] = 'pacz-flaticon-coffee17';
	$icons[] = 'pacz-flaticon-cogwheel8';
	$icons[] = 'pacz-flaticon-compact8';
	$icons[] = 'pacz-flaticon-compass39';
	$icons[] = 'pacz-flaticon-connected8';
	$icons[] = 'pacz-flaticon-crop2';
	$icons[] = 'pacz-flaticon-cross39';
	$icons[] = 'pacz-flaticon-curve19';
	$icons[] = 'pacz-flaticon-diamond18';
	$icons[] = 'pacz-flaticon-document58';
	$icons[] = 'pacz-flaticon-dollar79';
	$icons[] = 'pacz-flaticon-door7';
	$icons[] = 'pacz-flaticon-double23';
	$icons[] = 'pacz-flaticon-double24';
	$icons[] = 'pacz-flaticon-downloading3';
	$icons[] = 'pacz-flaticon-drawing4';
	$icons[] = 'pacz-flaticon-empty20';
	$icons[] = 'pacz-flaticon-eyes';
	$icons[] = 'pacz-flaticon-fast10';
	$icons[] = 'pacz-flaticon-fast11';
	$icons[] = 'pacz-flaticon-file24';
	$icons[] = 'pacz-flaticon-film24';
	$icons[] = 'pacz-flaticon-fire13';
	$icons[] = 'pacz-flaticon-flag26';
	$icons[] = 'pacz-flaticon-flat10';
	$icons[] = 'pacz-flaticon-fluff1';
	$icons[] = 'pacz-flaticon-four26';
	$icons[] = 'pacz-flaticon-full21';
	$icons[] = 'pacz-flaticon-grocery10';
	$icons[] = 'pacz-flaticon-half11';
	$icons[] = 'pacz-flaticon-heart66';
	$icons[] = 'pacz-flaticon-hom';
	$icons[] = 'pacz-flaticon-huge3';
	$icons[] = 'pacz-flaticon-increasing5';
	$icons[] = 'pacz-flaticon-kings';
	$icons[] = 'pacz-flaticon-letter11';
	$icons[] = 'pacz-flaticon-light44';
	$icons[] = 'pacz-flaticon-lines';
	$icons[] = 'pacz-flaticon-low20';
	$icons[] = 'pacz-flaticon-magnification3';
	$icons[] = 'pacz-flaticon-maps5';
	$icons[] = 'pacz-flaticon-mathematical3';
	$icons[] = 'pacz-flaticon-microphone26';
	$icons[] = 'pacz-flaticon-molecular';
	$icons[] = 'pacz-flaticon-multiple18';
	$icons[] = 'pacz-flaticon-music63';
	$icons[] = 'pacz-flaticon-mute7';
	$icons[] = 'pacz-flaticon-navigation8';
	$icons[] = 'pacz-flaticon-newspaper8';
	$icons[] = 'pacz-flaticon-no16';
	$icons[] = 'pacz-flaticon-open89';
	$icons[] = 'pacz-flaticon-open90';
	$icons[] = 'pacz-flaticon-padlock18';
	$icons[] = 'pacz-flaticon-paint26';
	$icons[] = 'pacz-flaticon-paper43';
	$icons[] = 'pacz-flaticon-paper44';
	$icons[] = 'pacz-flaticon-personal5';
	$icons[] = 'pacz-flaticon-phone51';
	$icons[] = 'pacz-flaticon-picture10';
	$icons[] = 'pacz-flaticon-plant10';
	$icons[] = 'pacz-flaticon-play35';
	$icons[] = 'pacz-flaticon-previous6';
	$icons[] = 'pacz-flaticon-profile7';
	$icons[] = 'pacz-flaticon-public5';
	$icons[] = 'pacz-flaticon-rainy5';
	$icons[] = 'pacz-flaticon-religion1';
	$icons[] = 'pacz-flaticon-rewind22';
	$icons[] = 'pacz-flaticon-rotating10';
	$icons[] = 'pacz-flaticon-rotating9';
	$icons[] = 'pacz-flaticon-round30';
	$icons[] = 'pacz-flaticon-round31';
	$icons[] = 'pacz-flaticon-rounded25';
	$icons[] = 'pacz-flaticon-rounded26';
	$icons[] = 'pacz-flaticon-royalty';
	$icons[] = 'pacz-flaticon-scissors14';
	$icons[] = 'pacz-flaticon-shopping63';
	$icons[] = 'pacz-flaticon-signal21';
	$icons[] = 'pacz-flaticon-simple47';
	$icons[] = 'pacz-flaticon-small139';
	$icons[] = 'pacz-flaticon-snowflake3';
	$icons[] = 'pacz-flaticon-speech54';
	$icons[] = 'pacz-flaticon-spring11';
	$icons[] = 'pacz-flaticon-square51';
	$icons[] = 'pacz-flaticon-square52';
	$icons[] = 'pacz-flaticon-square53';
	$icons[] = 'pacz-flaticon-square54';
	$icons[] = 'pacz-flaticon-square55';
	$icons[] = 'pacz-flaticon-square56';
	$icons[] = 'pacz-flaticon-square57';
	$icons[] = 'pacz-flaticon-stop20';
	$icons[] = 'pacz-flaticon-sun30';
	$icons[] = 'pacz-flaticon-syncing';
	$icons[] = 'pacz-flaticon-telephon';
	$icons[] = 'pacz-flaticon-trash27';
	$icons[] = 'pacz-flaticon-triangle14';
	$icons[] = 'pacz-flaticon-tshirt14';
	$icons[] = 'pacz-flaticon-umbrella14';
	$icons[] = 'pacz-flaticon-user73';
	$icons[] = 'pacz-flaticon-wide6';
	$icons[] = 'pacz-flaticon-world29';
	$icons[] = 'pacz-li-web';
	$icons[] = 'pacz-li-volume';
	$icons[] = 'pacz-li-vinyl-disk';
	$icons[] = 'pacz-li-view';
	$icons[] = 'pacz-li-video';
	$icons[] = 'pacz-li-users';
	$icons[] = 'pacz-li-user';
	$icons[] = 'pacz-li-unlock';
	$icons[] = 'pacz-li-umbrella';
	$icons[] = 'pacz-li-tshirt';
	$icons[] = 'pacz-li-truck';
	$icons[] = 'pacz-li-tool';
	$icons[] = 'pacz-li-toilet-paper';
	$icons[] = 'pacz-li-ticket';
	$icons[] = 'pacz-li-target';
	$icons[] = 'pacz-li-tablet';
	$icons[] = 'pacz-li-sun';
	$icons[] = 'pacz-li-star';
	$icons[] = 'pacz-li-smile';
	$icons[] = 'pacz-li-shop';
	$icons[] = 'pacz-li-shield';
	$icons[] = 'pacz-li-settings';
	$icons[] = 'pacz-li-scissor';
	$icons[] = 'pacz-li-safe';
	$icons[] = 'pacz-li-rocket';
	$icons[] = 'pacz-li-refresh';
	$icons[] = 'pacz-li-posion';
	$icons[] = 'pacz-li-portfolio';
	$icons[] = 'pacz-li-pinmap';
	$icons[] = 'pacz-li-pill';
	$icons[] = 'pacz-li-photo';
	$icons[] = 'pacz-li-phone';
	$icons[] = 'pacz-li-pencil';
	$icons[] = 'pacz-li-paper-plane';
	$icons[] = 'pacz-li-notepad';
	$icons[] = 'pacz-li-notebook';
	$icons[] = 'pacz-li-news';
	$icons[] = 'pacz-li-net';
	$icons[] = 'pacz-li-music';
	$icons[] = 'pacz-li-mortarboard';
	$icons[] = 'pacz-li-monitor';
	$icons[] = 'pacz-li-money';
	$icons[] = 'pacz-li-micro';
	$icons[] = 'pacz-li-message';
	$icons[] = 'pacz-li-map';
	$icons[] = 'pacz-li-mail';
	$icons[] = 'pacz-li-magnet';
	$icons[] = 'pacz-li-love';
	$icons[] = 'pacz-li-loupe';
	$icons[] = 'pacz-li-lock';
	$icons[] = 'pacz-li-link';
	$icons[] = 'pacz-li-like';
	$icons[] = 'pacz-li-light';
	$icons[] = 'pacz-li-leaf';
	$icons[] = 'pacz-li-lamp';
	$icons[] = 'pacz-li-lab';
	$icons[] = 'pacz-li-key';
	$icons[] = 'pacz-li-joy';
	$icons[] = 'pacz-li-inbox';
	$icons[] = 'pacz-li-ice';
	$icons[] = 'pacz-li-host';
	$icons[] = 'pacz-li-help';
	$icons[] = 'pacz-li-headphones';
	$icons[] = 'pacz-li-graph';
	$icons[] = 'pacz-li-garbage';
	$icons[] = 'pacz-li-game-pad';
	$icons[] = 'pacz-li-food';
	$icons[] = 'pacz-li-flag';
	$icons[] = 'pacz-li-file';
	$icons[] = 'pacz-li-expand';
	$icons[] = 'pacz-li-drop';
	$icons[] = 'pacz-li-cup';
	$icons[] = 'pacz-li-copy';
	$icons[] = 'pacz-li-config';
	$icons[] = 'pacz-li-compass';
	$icons[] = 'pacz-li-comments';
	$icons[] = 'pacz-li-coffee';
	$icons[] = 'pacz-li-cloud';
	$icons[] = 'pacz-li-clock';
	$icons[] = 'pacz-li-clip';
	$icons[] = 'pacz-li-cinema';
	$icons[] = 'pacz-li-check';
	$icons[] = 'pacz-li-cd';
	$icons[] = 'pacz-li-cassette';
	$icons[] = 'pacz-li-cart';
	$icons[] = 'pacz-li-camera';
	$icons[] = 'pacz-li-call';
	$icons[] = 'pacz-li-calendar';
	$icons[] = 'pacz-li-calculator';
	$icons[] = 'pacz-li-brush';
	$icons[] = 'pacz-li-browser';
	$icons[] = 'pacz-li-book';
	$icons[] = 'pacz-li-bicycle';
	$icons[] = 'pacz-li-bell';
	$icons[] = 'pacz-li-battery';
	$icons[] = 'pacz-li-bag';
	$icons[] = 'pacz-li-attention';
	$icons[] = 'pacz-li-atom';
	$icons[] = 'pacz-li-apeaker';
	$icons[] = 'pacz-li-alarm';
	$icons[] = 'pacz-theme-icon-topnav';
	$icons[] = 'pacz-theme-icon-rightsidebar';
	$icons[] = 'pacz-theme-icon-leftsidebar';
	$icons[] = 'pacz-theme-icon-dashboard-o';
	$icons[] = 'pacz-theme-icon-bottomnav';
	$icons[] = 'pacz-theme-icon-boxed';
	$icons[] = 'pacz-theme-icon-wide';
	$icons[] = 'pacz-theme-icon-singlepage';
	$icons[] = 'pacz-theme-icon-multipage';
	$icons[] = 'pacz-theme-icon-woman-bag';
	$icons[] = 'pacz-theme-icon-voicemessage';
	$icons[] = 'pacz-theme-icon-trashcan';
	$icons[] = 'pacz-theme-icon-thermostat';
	$icons[] = 'pacz-theme-icon-tag';
	$icons[] = 'pacz-theme-icon-sitemap';
	$icons[] = 'pacz-theme-icon-shirt';
	$icons[] = 'pacz-theme-icon-printer';
	$icons[] = 'pacz-theme-icon-video';
	$icons[] = 'pacz-theme-icon-user';
	$icons[] = 'pacz-theme-icon-top-small';
	$icons[] = 'pacz-theme-icon-top-bigger';
	$icons[] = 'pacz-theme-icon-top-big';
	$icons[] = 'pacz-theme-icon-tick';
	$icons[] = 'pacz-theme-icon-tick2';
	$icons[] = 'pacz-theme-icon-plus';
	$icons[] = 'pacz-theme-icon-play';
	$icons[] = 'pacz-theme-icon-pause';
	$icons[] = 'pacz-theme-icon-magnifier';
	$icons[] = 'pacz-theme-icon-dashboard2';
	$icons[] = 'pacz-theme-icon-close';
	$icons[] = 'pacz-theme-icon-cart2';
	$icons[] = 'pacz-theme-icon-burgerwide';
	$icons[] = 'pacz-theme-icon-burger';
	$icons[] = 'pacz-theme-icon-text';
	$icons[] = 'pacz-theme-icon-star';
	$icons[] = 'pacz-theme-icon-search';
	$icons[] = 'pacz-theme-icon-quote';
	$icons[] = 'pacz-theme-icon-prev-small';
	$icons[] = 'pacz-theme-icon-prev-big';
	$icons[] = 'pacz-theme-icon-portfolio';
	$icons[] = 'pacz-theme-icon-plus';
	$icons[] = 'pacz-theme-icon-phone';
	$icons[] = 'pacz-theme-icon-permalink';
	$icons[] = 'pacz-theme-icon-pause';
	$icons[] = 'pacz-theme-icon-office';
	$icons[] = 'pacz-theme-icon-next-small';
	$icons[] = 'pacz-theme-icon-next-bigger';
	$icons[] = 'pacz-theme-icon-next-big';
	$icons[] = 'pacz-theme-icon-love';
	$icons[] = 'pacz-theme-icon-prev-bigger';
	$icons[] = 'pacz-theme-icon-image';
	$icons[] = 'pacz-theme-icon-home';
	$icons[] = 'pacz-theme-icon-gallery';
	$icons[] = 'pacz-theme-icon-fax';
	$icons[] = 'pacz-theme-icon-email';
	$icons[] = 'pacz-theme-icon-comment';
	$icons[] = 'pacz-theme-icon-cellphone';
	$icons[] = 'pacz-theme-icon-cart';
	$icons[] = 'pacz-theme-icon-cancel';
	$icons[] = 'pacz-theme-icon-bottom-small';
	$icons[] = 'pacz-theme-icon-bottom-bigger';
	$icons[] = 'pacz-theme-icon-bottom-big';
	$icons[] = 'pacz-theme-icon-blog';
	$icons[] = 'pacz-theme-icon-blog-share';
	$icons[] = 'pacz-theme-icon-macbookair';
	$icons[] = 'pacz-theme-icon-macbook';
	$icons[] = 'pacz-theme-icon-layers';
	$icons[] = 'pacz-theme-icon-lab';
	$icons[] = 'pacz-theme-icon-ipad';
	$icons[] = 'pacz-theme-icon-hamburger';
	$icons[] = 'pacz-theme-icon-folder-2';
	$icons[] = 'pacz-theme-icon-file';
	$icons[] = 'pacz-theme-icon-crop';
	$icons[] = 'pacz-theme-icon-commandconsole';
	$icons[] = 'pacz-theme-icon-chergerfull';
	$icons[] = 'pacz-theme-icon-chargerhalf';
	$icons[] = 'pacz-theme-icon-chargerblank';
	$icons[] = 'pacz-theme-icon-cassette';
	$icons[] = 'pacz-theme-icon-card';
	$icons[] = 'pacz-theme-icon-card-2';
	$icons[] = 'pacz-theme-icon-camera';
	$icons[] = 'pacz-theme-icon-calendar';
	$icons[] = 'pacz-theme-icon-accordion';
	$icons[] = 'pacz-theme-icon-whatsapp';
	$icons[] = 'pacz-theme-icon-weibo';
	$icons[] = 'pacz-theme-icon-wechat';
	$icons[] = 'pacz-theme-icon-vk';
	$icons[] = 'pacz-theme-icon-renren';
	$icons[] = 'pacz-theme-icon-qzone';
	$icons[] = 'pacz-theme-icon-imdb';
	$icons[] = 'pacz-theme-icon-behance';
	$icons[] = 'pacz-icon-glass';
		$icons[] = 'pacz-icon-music';
		$icons[] = 'pacz-icon-search';
		$icons[] = 'pacz-icon-envelope-o';
		$icons[] = 'pacz-icon-heart';
		$icons[] = 'pacz-icon-star';
		$icons[] = 'pacz-icon-star-o';
		$icons[] = 'pacz-icon-user';
		$icons[] = 'pacz-icon-film';
		$icons[] = 'pacz-icon-th-large';
		$icons[] = 'pacz-icon-th';
		$icons[] = 'pacz-icon-th-list';
		$icons[] = 'pacz-icon-check';
		$icons[] = 'pacz-icon-remove';
		$icons[] = 'pacz-icon-close';
		$icons[] = 'pacz-icon-times';
		$icons[] = 'pacz-icon-search-plus';
		$icons[] = 'pacz-icon-search-minus';
		$icons[] = 'pacz-icon-power-off';
		$icons[] = 'pacz-icon-signal';
		$icons[] = 'pacz-icon-gear';
		$icons[] = 'pacz-icon-cog';
		$icons[] = 'pacz-icon-trash-o';
		$icons[] = 'pacz-icon-home';
		$icons[] = 'pacz-icon-file-o';
		$icons[] = 'pacz-icon-clock-o';
		$icons[] = 'pacz-icon-road';
		$icons[] = 'pacz-icon-download';
		$icons[] = 'pacz-icon-arrow-circle-o-down';
		$icons[] = 'pacz-icon-arrow-circle-o-up';
		$icons[] = 'pacz-icon-inbox';
		$icons[] = 'pacz-icon-play-circle-o';
		$icons[] = 'pacz-icon-rotate-right';
		$icons[] = 'pacz-icon-repeat';
		$icons[] = 'pacz-icon-refresh';
		$icons[] = 'pacz-icon-list-alt';
		$icons[] = 'pacz-icon-lock';
		$icons[] = 'pacz-icon-flag';
		$icons[] = 'pacz-icon-headphones';
		$icons[] = 'pacz-icon-volume-off';
		$icons[] = 'pacz-icon-volume-down';
		$icons[] = 'pacz-icon-volume-up';
		$icons[] = 'pacz-icon-qrcode';
		$icons[] = 'pacz-icon-barcode';
		$icons[] = 'pacz-icon-tag';
		$icons[] = 'pacz-icon-tags';
		$icons[] = 'pacz-icon-book';
		$icons[] = 'pacz-icon-bookmark';
		$icons[] = 'pacz-icon-print';
		$icons[] = 'pacz-icon-camera';
		$icons[] = 'pacz-icon-font';
		$icons[] = 'pacz-icon-bold';
		$icons[] = 'pacz-icon-italic';
		$icons[] = 'pacz-icon-text-height';
		$icons[] = 'pacz-icon-text-width';
		$icons[] = 'pacz-icon-align-left';
		$icons[] = 'pacz-icon-align-center';
		$icons[] = 'pacz-icon-align-right';
		$icons[] = 'pacz-icon-align-justify';
		$icons[] = 'pacz-icon-list';
		$icons[] = 'pacz-icon-dedent';
		$icons[] = 'pacz-icon-outdent';
		$icons[] = 'pacz-icon-indent';
		$icons[] = 'pacz-icon-video-camera';
		$icons[] = 'pacz-icon-photo';
		$icons[] = 'pacz-icon-image';
		$icons[] = 'pacz-icon-picture-o';
		$icons[] = 'pacz-icon-pencil';
		$icons[] = 'pacz-icon-map-marker';
		$icons[] = 'pacz-icon-adjust';
		$icons[] = 'pacz-icon-tint';
		$icons[] = 'pacz-icon-edit';
		$icons[] = 'pacz-icon-pencil-square-o';
		$icons[] = 'pacz-icon-share-square-o';
		$icons[] = 'pacz-icon-check-square-o';
		$icons[] = 'pacz-icon-arrows';
		$icons[] = 'pacz-icon-step-backward';
		$icons[] = 'pacz-icon-fast-backward';
		$icons[] = 'pacz-icon-backward';
		$icons[] = 'pacz-icon-play';
		$icons[] = 'pacz-icon-pause';
		$icons[] = 'pacz-icon-stop';
		$icons[] = 'pacz-icon-forward';
		$icons[] = 'pacz-icon-fast-forward';
		$icons[] = 'pacz-icon-step-forward';
		$icons[] = 'pacz-icon-eject';
		$icons[] = 'pacz-icon-chevron-left';
		$icons[] = 'pacz-icon-chevron-right';
		$icons[] = 'pacz-icon-plus-circle';
		$icons[] = 'pacz-icon-minus-circle';
		$icons[] = 'pacz-icon-times-circle';
		$icons[] = 'pacz-icon-check-circle';
		$icons[] = 'pacz-icon-question-circle';
		$icons[] = 'pacz-icon-info-circle';
		$icons[] = 'pacz-icon-crosshairs';
		$icons[] = 'pacz-icon-times-circle-o';
		$icons[] = 'pacz-icon-check-circle-o';
		$icons[] = 'pacz-icon-ban';
		$icons[] = 'pacz-icon-arrow-left';
		$icons[] = 'pacz-icon-arrow-right';
		$icons[] = 'pacz-icon-arrow-up';
		$icons[] = 'pacz-icon-arrow-down';
		$icons[] = 'pacz-icon-mail-forward';
		$icons[] = 'pacz-icon-share';
		$icons[] = 'pacz-icon-expand';
		$icons[] = 'pacz-icon-compress';
		$icons[] = 'pacz-icon-plus';
		$icons[] = 'pacz-icon-minus';
		$icons[] = 'pacz-icon-asterisk';
		$icons[] = 'pacz-icon-exclamation-circle';
		$icons[] = 'pacz-icon-gift';
		$icons[] = 'pacz-icon-leaf';
		$icons[] = 'pacz-icon-fire';
		$icons[] = 'pacz-icon-eye';
		$icons[] = 'pacz-icon-eye-slash';
		$icons[] = 'pacz-icon-warning';
		$icons[] = 'pacz-icon-exclamation-triangle';
		$icons[] = 'pacz-icon-plane';
		$icons[] = 'pacz-icon-calendar';
		$icons[] = 'pacz-icon-random';
		$icons[] = 'pacz-icon-comment';
		$icons[] = 'pacz-icon-magnet';
		$icons[] = 'pacz-icon-chevron-up';
		$icons[] = 'pacz-icon-chevron-down';
		$icons[] = 'pacz-icon-retweet';
		$icons[] = 'pacz-icon-shopping-cart';
		$icons[] = 'pacz-icon-folder';
		$icons[] = 'pacz-icon-folder-open';
		$icons[] = 'pacz-icon-arrows-v';
		$icons[] = 'pacz-icon-arrows-h';
		$icons[] = 'pacz-icon-bar-chart-o';
		$icons[] = 'pacz-icon-bar-chart';
		$icons[] = 'pacz-icon-twitter-square';
		$icons[] = 'pacz-icon-facebook-square';
		$icons[] = 'pacz-icon-camera-retro';
		$icons[] = 'pacz-icon-key';
		$icons[] = 'pacz-icon-gears';
		$icons[] = 'pacz-icon-cogs';
		$icons[] = 'pacz-icon-comments';
		$icons[] = 'pacz-icon-thumbs-o-up';
		$icons[] = 'pacz-icon-thumbs-o-down';
		$icons[] = 'pacz-icon-star-half';
		$icons[] = 'pacz-icon-heart-o';
		$icons[] = 'pacz-icon-sign-out';
		$icons[] = 'pacz-icon-linkedin-square';
		$icons[] = 'pacz-icon-thumb-tack';
		$icons[] = 'pacz-icon-external-link';
		$icons[] = 'pacz-icon-sign-in';
		$icons[] = 'pacz-icon-trophy';
		$icons[] = 'pacz-icon-github-square';
		$icons[] = 'pacz-icon-upload';
		$icons[] = 'pacz-icon-lemon-o';
		$icons[] = 'pacz-icon-phone';
		$icons[] = 'pacz-icon-square-o';
		$icons[] = 'pacz-icon-bookmark-o';
		$icons[] = 'pacz-icon-phone-square';
		$icons[] = 'pacz-icon-twitter';
		$icons[] = 'pacz-icon-facebook';
		$icons[] = 'pacz-icon-github';
		$icons[] = 'pacz-icon-unlock';
		$icons[] = 'pacz-icon-credit-card';
		$icons[] = 'pacz-icon-rss';
		$icons[] = 'pacz-icon-hdd-o';
		$icons[] = 'pacz-icon-bullhorn';
		$icons[] = 'pacz-icon-bell';
		$icons[] = 'pacz-icon-certificate';
		$icons[] = 'pacz-icon-hand-o-right';
		$icons[] = 'pacz-icon-hand-o-left';
		$icons[] = 'pacz-icon-hand-o-up';
		$icons[] = 'pacz-icon-hand-o-down';
		$icons[] = 'pacz-icon-arrow-circle-left';
		$icons[] = 'pacz-icon-arrow-circle-right';
		$icons[] = 'pacz-icon-arrow-circle-up';
		$icons[] = 'pacz-icon-arrow-circle-down';
		$icons[] = 'pacz-icon-globe';
		$icons[] = 'pacz-icon-wrench';
		$icons[] = 'pacz-icon-tasks';
		$icons[] = 'pacz-icon-filter';
		$icons[] = 'pacz-icon-briefcase';
		$icons[] = 'pacz-icon-arrows-alt';
		$icons[] = 'pacz-icon-group';
		$icons[] = 'pacz-icon-users';
		$icons[] = 'pacz-icon-chain';
		$icons[] = 'pacz-icon-link';
		$icons[] = 'pacz-icon-cloud';
		$icons[] = 'pacz-icon-flask';
		$icons[] = 'pacz-icon-cut';
		$icons[] = 'pacz-icon-scissors';
		$icons[] = 'pacz-icon-copy';
		$icons[] = 'pacz-icon-files-o';
		$icons[] = 'pacz-icon-paperclip';
		$icons[] = 'pacz-icon-save';
		$icons[] = 'pacz-icon-floppy-o';
		$icons[] = 'pacz-icon-square';
		$icons[] = 'pacz-icon-navicon';
		$icons[] = 'pacz-icon-reorder';
		$icons[] = 'pacz-icon-bars';
		$icons[] = 'pacz-icon-list-ul';
		$icons[] = 'pacz-icon-list-ol';
		$icons[] = 'pacz-icon-strikethrough';
		$icons[] = 'pacz-icon-underline';
		$icons[] = 'pacz-icon-table';
		$icons[] = 'pacz-icon-magic';
		$icons[] = 'pacz-icon-truck';
		$icons[] = 'pacz-icon-pinterest';
		$icons[] = 'pacz-icon-pinterest-square';
		$icons[] = 'pacz-icon-google-plus-square';
		$icons[] = 'pacz-icon-google-plus';
		$icons[] = 'pacz-icon-money';
		$icons[] = 'pacz-icon-caret-down';
		$icons[] = 'pacz-icon-caret-up';
		$icons[] = 'pacz-icon-caret-left';
		$icons[] = 'pacz-icon-caret-right';
		$icons[] = 'pacz-icon-columns';
		$icons[] = 'pacz-icon-unsorted';
		$icons[] = 'pacz-icon-sort';
		$icons[] = 'pacz-icon-sort-down';
		$icons[] = 'pacz-icon-sort-desc';
		$icons[] = 'pacz-icon-sort-up';
		$icons[] = 'pacz-icon-sort-asc';
		$icons[] = 'pacz-icon-envelope';
		$icons[] = 'pacz-icon-linkedin';
		$icons[] = 'pacz-icon-rotate-left';
		$icons[] = 'pacz-icon-undo';
		$icons[] = 'pacz-icon-legal';
		$icons[] = 'pacz-icon-gavel';
		$icons[] = 'pacz-icon-dashboard';
		$icons[] = 'pacz-icon-tachometer';
		$icons[] = 'pacz-icon-comment-o';
		$icons[] = 'pacz-icon-comments-o';
		$icons[] = 'pacz-icon-flash';
		$icons[] = 'pacz-icon-bolt';
		$icons[] = 'pacz-icon-sitemap';
		$icons[] = 'pacz-icon-umbrella';
		$icons[] = 'pacz-icon-paste';
		$icons[] = 'pacz-icon-clipboard';
		$icons[] = 'pacz-icon-lightbulb-o';
		$icons[] = 'pacz-icon-exchange';
		$icons[] = 'pacz-icon-cloud-download';
		$icons[] = 'pacz-icon-cloud-upload';
		$icons[] = 'pacz-icon-user-md';
		$icons[] = 'pacz-icon-stethoscope';
		$icons[] = 'pacz-icon-suitcase';
		$icons[] = 'pacz-icon-bell-o';
		$icons[] = 'pacz-icon-coffee';
		$icons[] = 'pacz-icon-cutlery';
		$icons[] = 'pacz-icon-file-text-o';
		$icons[] = 'pacz-icon-building-o';
		$icons[] = 'pacz-icon-hospital-o';
		$icons[] = 'pacz-icon-ambulance';
		$icons[] = 'pacz-icon-medkit';
		$icons[] = 'pacz-icon-fighter-jet';
		$icons[] = 'pacz-icon-beer';
		$icons[] = 'pacz-icon-h-square';
		$icons[] = 'pacz-icon-plus-square';
		$icons[] = 'pacz-icon-angle-double-left';
		$icons[] = 'pacz-icon-angle-double-right';
		$icons[] = 'pacz-icon-angle-double-up';
		$icons[] = 'pacz-icon-angle-double-down';
		$icons[] = 'pacz-icon-angle-left';
		$icons[] = 'pacz-icon-angle-right';
		$icons[] = 'pacz-icon-angle-up';
		$icons[] = 'pacz-icon-angle-down';
		$icons[] = 'pacz-icon-desktop';
		$icons[] = 'pacz-icon-laptop';
		$icons[] = 'pacz-icon-tablet';
		$icons[] = 'pacz-icon-mobile-phone';
		$icons[] = 'pacz-icon-mobile';
		$icons[] = 'pacz-icon-circle-o';
		$icons[] = 'pacz-icon-quote-left';
		$icons[] = 'pacz-icon-quote-right';
		$icons[] = 'pacz-icon-spinner';
		$icons[] = 'pacz-icon-circle';
		$icons[] = 'pacz-icon-mail-reply';
		$icons[] = 'pacz-icon-reply';
		$icons[] = 'pacz-icon-github-alt';
		$icons[] = 'pacz-icon-folder-o';
		$icons[] = 'pacz-icon-folder-open-o';
		$icons[] = 'pacz-icon-smile-o';
		$icons[] = 'pacz-icon-frown-o';
		$icons[] = 'pacz-icon-meh-o';
		$icons[] = 'pacz-icon-gamepad';
		$icons[] = 'pacz-icon-keyboard-o';
		$icons[] = 'pacz-icon-flag-o';
		$icons[] = 'pacz-icon-flag-checkered';
		$icons[] = 'pacz-icon-terminal';
		$icons[] = 'pacz-icon-code';
		$icons[] = 'pacz-icon-mail-reply-all';
		$icons[] = 'pacz-icon-reply-all';
		$icons[] = 'pacz-icon-star-half-empty';
		$icons[] = 'pacz-icon-star-half-full';
		$icons[] = 'pacz-icon-star-half-o';
		$icons[] = 'pacz-icon-location-arrow';
		$icons[] = 'pacz-icon-crop';
		$icons[] = 'pacz-icon-code-fork';
		$icons[] = 'pacz-icon-unlink';
		$icons[] = 'pacz-icon-chain-broken';
		$icons[] = 'pacz-icon-question';
		$icons[] = 'pacz-icon-info';
		$icons[] = 'pacz-icon-exclamation';
		$icons[] = 'pacz-icon-superscript';
		$icons[] = 'pacz-icon-subscript';
		$icons[] = 'pacz-icon-eraser';
		$icons[] = 'pacz-icon-puzzle-piece';
		$icons[] = 'pacz-icon-microphone';
		$icons[] = 'pacz-icon-microphone-slash';
		$icons[] = 'pacz-icon-shield';
		$icons[] = 'pacz-icon-calendar-o';
		$icons[] = 'pacz-icon-fire-extinguisher';
		$icons[] = 'pacz-icon-rocket';
		$icons[] = 'pacz-icon-maxcdn';
		$icons[] = 'pacz-icon-chevron-circle-left';
		$icons[] = 'pacz-icon-chevron-circle-right';
		$icons[] = 'pacz-icon-chevron-circle-up';
		$icons[] = 'pacz-icon-chevron-circle-down';
		$icons[] = 'pacz-icon-html5';
		$icons[] = 'pacz-icon-css3';
		$icons[] = 'pacz-icon-anchor';
		$icons[] = 'pacz-icon-unlock-alt';
		$icons[] = 'pacz-icon-bullseye';
		$icons[] = 'pacz-icon-ellipsis-h';
		$icons[] = 'pacz-icon-ellipsis-v';
		$icons[] = 'pacz-icon-rss-square';
		$icons[] = 'pacz-icon-play-circle';
		$icons[] = 'pacz-icon-ticket';
		$icons[] = 'pacz-icon-minus-square';
		$icons[] = 'pacz-icon-minus-square-o';
		$icons[] = 'pacz-icon-level-up';
		$icons[] = 'pacz-icon-level-down';
		$icons[] = 'pacz-icon-check-square';
		$icons[] = 'pacz-icon-pencil-square';
		$icons[] = 'pacz-icon-external-link-square';
		$icons[] = 'pacz-icon-share-square';
		$icons[] = 'pacz-icon-compass';
		$icons[] = 'pacz-icon-toggle-down';
		$icons[] = 'pacz-icon-caret-square-o-down';
		$icons[] = 'pacz-icon-toggle-up';
		$icons[] = 'pacz-icon-caret-square-o-up';
		$icons[] = 'pacz-icon-toggle-right';
		$icons[] = 'pacz-icon-caret-square-o-right';
		$icons[] = 'pacz-icon-euro';
		$icons[] = 'pacz-icon-eur';
		$icons[] = 'pacz-icon-gbp';
		$icons[] = 'pacz-icon-dollar';
		$icons[] = 'pacz-icon-usd';
		$icons[] = 'pacz-icon-rupee';
		$icons[] = 'pacz-icon-inr';
		$icons[] = 'pacz-icon-cny';
		$icons[] = 'pacz-icon-rmb';
		$icons[] = 'pacz-icon-yen';
		$icons[] = 'pacz-icon-jpy';
		$icons[] = 'pacz-icon-ruble';
		$icons[] = 'pacz-icon-rouble';
		$icons[] = 'pacz-icon-rub';
		$icons[] = 'pacz-icon-won';
		$icons[] = 'pacz-icon-krw';
		$icons[] = 'pacz-icon-bitcoin';
		$icons[] = 'pacz-icon-btc';
		$icons[] = 'pacz-icon-file';
		$icons[] = 'pacz-icon-file-text';
		$icons[] = 'pacz-icon-sort-alpha-asc';
		$icons[] = 'pacz-icon-sort-alpha-desc';
		$icons[] = 'pacz-icon-sort-amount-asc';
		$icons[] = 'pacz-icon-sort-amount-desc';
		$icons[] = 'pacz-icon-sort-numeric-asc';
		$icons[] = 'pacz-icon-sort-numeric-desc';
		$icons[] = 'pacz-icon-thumbs-up';
		$icons[] = 'pacz-icon-thumbs-down';
		$icons[] = 'pacz-icon-youtube-square';
		$icons[] = 'pacz-icon-youtube';
		$icons[] = 'pacz-icon-xing';
		$icons[] = 'pacz-icon-xing-square';
		$icons[] = 'pacz-icon-youtube-play';
		$icons[] = 'pacz-icon-dropbox';
		$icons[] = 'pacz-icon-stack-overflow';
		$icons[] = 'pacz-icon-instagram';
		$icons[] = 'pacz-icon-flickr';
		$icons[] = 'pacz-icon-adn';
		$icons[] = 'pacz-icon-bitbucket';
		$icons[] = 'pacz-icon-bitbucket-square';
		$icons[] = 'pacz-icon-tumblr';
		$icons[] = 'pacz-icon-tumblr-square';
		$icons[] = 'pacz-icon-long-arrow-down';
		$icons[] = 'pacz-icon-long-arrow-up';
		$icons[] = 'pacz-icon-long-arrow-left';
		$icons[] = 'pacz-icon-long-arrow-right';
		$icons[] = 'pacz-icon-apple';
		$icons[] = 'pacz-icon-windows';
		$icons[] = 'pacz-icon-android';
		$icons[] = 'pacz-icon-linux';
		$icons[] = 'pacz-icon-dribbble';
		$icons[] = 'pacz-icon-skype';
		$icons[] = 'pacz-icon-foursquare';
		$icons[] = 'pacz-icon-trello';
		$icons[] = 'pacz-icon-female';
		$icons[] = 'pacz-icon-male';
		$icons[] = 'pacz-icon-gittip';
		$icons[] = 'pacz-icon-sun-o';
		$icons[] = 'pacz-icon-moon-o';
		$icons[] = 'pacz-icon-archive';
		$icons[] = 'pacz-icon-bug';
		$icons[] = 'pacz-icon-vk';
		$icons[] = 'pacz-icon-weibo';
		$icons[] = 'pacz-icon-renren';
		$icons[] = 'pacz-icon-pagelines';
		$icons[] = 'pacz-icon-stack-exchange';
		$icons[] = 'pacz-icon-arrow-circle-o-right';
		$icons[] = 'pacz-icon-arrow-circle-o-left';
		$icons[] = 'pacz-icon-toggle-left';
		$icons[] = 'pacz-icon-caret-square-o-left';
		$icons[] = 'pacz-icon-dot-circle-o';
		$icons[] = 'pacz-icon-wheelchair';
		$icons[] = 'pacz-icon-vimeo-square';
		$icons[] = 'pacz-icon-turkish-lira';
		$icons[] = 'pacz-icon-try';
		$icons[] = 'pacz-icon-plus-square-o';
		$icons[] = 'pacz-icon-space-shuttle';
		$icons[] = 'pacz-icon-slack';
		$icons[] = 'pacz-icon-envelope-square';
		$icons[] = 'pacz-icon-wordpress';
		$icons[] = 'pacz-icon-openid';
		$icons[] = 'pacz-icon-institution';
		$icons[] = 'pacz-icon-bank';
		$icons[] = 'pacz-icon-university';
		$icons[] = 'pacz-icon-mortar-board';
		$icons[] = 'pacz-icon-graduation-cap';
		$icons[] = 'pacz-icon-yahoo';
		$icons[] = 'pacz-icon-google';
		$icons[] = 'pacz-icon-reddit';
		$icons[] = 'pacz-icon-reddit-square';
		$icons[] = 'pacz-icon-stumbleupon-circle';
		$icons[] = 'pacz-icon-stumbleupon';
		$icons[] = 'pacz-icon-delicious';
		$icons[] = 'pacz-icon-digg';
		$icons[] = 'pacz-icon-pied-piper';
		$icons[] = 'pacz-icon-pied-piper-alt';
		$icons[] = 'pacz-icon-drupal';
		$icons[] = 'pacz-icon-joomla';
		$icons[] = 'pacz-icon-language';
		$icons[] = 'pacz-icon-fax';
		$icons[] = 'pacz-icon-building';
		$icons[] = 'pacz-icon-child';
		$icons[] = 'pacz-icon-paw';
		$icons[] = 'pacz-icon-spoon';
		$icons[] = 'pacz-icon-cube';
		$icons[] = 'pacz-icon-cubes';
		$icons[] = 'pacz-icon-behance';
		$icons[] = 'pacz-icon-behance-square';
		$icons[] = 'pacz-icon-steam';
		$icons[] = 'pacz-icon-steam-square';
		$icons[] = 'pacz-icon-recycle';
		$icons[] = 'pacz-icon-automobile';
		$icons[] = 'pacz-icon-car';
		$icons[] = 'pacz-icon-cab';
		$icons[] = 'pacz-icon-taxi';
		$icons[] = 'pacz-icon-tree';
		$icons[] = 'pacz-icon-spotify';
		$icons[] = 'pacz-icon-deviantart';
		$icons[] = 'pacz-icon-soundcloud';
		$icons[] = 'pacz-icon-database';
		$icons[] = 'pacz-icon-file-pdf-o';
		$icons[] = 'pacz-icon-file-word-o';
		$icons[] = 'pacz-icon-file-excel-o';
		$icons[] = 'pacz-icon-file-powerpoint-o';
		$icons[] = 'pacz-icon-file-photo-o';
		$icons[] = 'pacz-icon-file-picture-o';
		$icons[] = 'pacz-icon-file-image-o';
		$icons[] = 'pacz-icon-file-zip-o';
		$icons[] = 'pacz-icon-file-archive-o';
		$icons[] = 'pacz-icon-file-sound-o';
		$icons[] = 'pacz-icon-file-audio-o';
		$icons[] = 'pacz-icon-file-movie-o';
		$icons[] = 'pacz-icon-file-code-o';
		$icons[] = 'pacz-icon-vine';
		$icons[] = 'pacz-icon-codepen';
		$icons[] = 'pacz-icon-jsfiddle';
		$icons[] = 'pacz-icon-life-bouy';
		$icons[] = 'pacz-icon-life-buoy';
		$icons[] = 'pacz-icon-life-saver';
		$icons[] = 'pacz-icon-support';
		$icons[] = 'pacz-icon-life-ring';
		$icons[] = 'pacz-icon-circle-o-notch';
		$icons[] = 'pacz-icon-ra';
		$icons[] = 'pacz-icon-rebel';
		$icons[] = 'pacz-icon-ge';
		$icons[] = 'pacz-icon-empire';
		$icons[] = 'pacz-icon-git-square';
		$icons[] = 'pacz-icon-git';
		$icons[] = 'pacz-icon-hacker-news';
		$icons[] = 'pacz-icon-tencent-weibo';
		$icons[] = 'pacz-icon-qq';
		$icons[] = 'pacz-icon-wechat';
		$icons[] = 'pacz-icon-weixin';
		$icons[] = 'pacz-icon-send';
		$icons[] = 'pacz-icon-paper-plane';
		$icons[] = 'pacz-icon-send-o';
		$icons[] = 'pacz-icon-paper-plane-o';
		$icons[] = 'pacz-icon-history';
		$icons[] = 'pacz-icon-circle-thin';
		$icons[] = 'pacz-icon-header';
		$icons[] = 'pacz-icon-paragraph';
		$icons[] = 'pacz-icon-sliders';
		$icons[] = 'pacz-icon-share-alt';
		$icons[] = 'pacz-icon-share-alt-square';
		$icons[] = 'pacz-icon-bomb';
		$icons[] = 'pacz-icon-soccer-ball-o';
		$icons[] = 'pacz-icon-futbol-o';
		$icons[] = 'pacz-icon-tty';
		$icons[] = 'pacz-icon-binoculars';
		$icons[] = 'pacz-icon-plug';
		$icons[] = 'pacz-icon-slideshare';
		$icons[] = 'pacz-icon-twitch';
		$icons[] = 'pacz-icon-yelp';
		$icons[] = 'pacz-icon-newspaper-o';
		$icons[] = 'pacz-icon-wifi';
		$icons[] = 'pacz-icon-calculator';
		$icons[] = 'pacz-icon-paypal';
		$icons[] = 'pacz-icon-google-';
		$icons[] = 'pacz-icon-cc-visa';
		$icons[] = 'pacz-icon-cc-mastercard';
		$icons[] = 'pacz-icon-cc-discover';
		$icons[] = 'pacz-icon-cc-amex';
		$icons[] = 'pacz-icon-cc-paypal';
		$icons[] = 'pacz-icon-cc-stripe';
		$icons[] = 'pacz-icon-bell-slash';
		$icons[] = 'pacz-icon-bell-slash-o';
		$icons[] = 'pacz-icon-trash';
		$icons[] = 'pacz-icon-copyright';
		$icons[] = 'pacz-icon-at';
		$icons[] = 'pacz-icon-eyedropper';
		$icons[] = 'pacz-icon-paint-brush';
		$icons[] = 'pacz-icon-birthday-cake';
		$icons[] = 'pacz-icon-area-chart';
		$icons[] = 'pacz-icon-pie-chart';
		$icons[] = 'pacz-icon-line-chart';
		$icons[] = 'pacz-icon-lastfm';
		$icons[] = 'pacz-icon-lastfm-square';
		$icons[] = 'pacz-icon-toggle-off';
		$icons[] = 'pacz-icon-toggle-on';
		$icons[] = 'pacz-icon-bicycle';
		$icons[] = 'pacz-icon-bus';
		$icons[] = 'pacz-icon-ioxhost';
		$icons[] = 'pacz-icon-angellist';
		$icons[] = 'pacz-icon-cc';
		$icons[] = 'pacz-icon-shekel';
		$icons[] = 'pacz-icon-sheqel';
		$icons[] = 'pacz-icon-ils';
		$icons[] = 'pacz-icon-meanpath';
		$icons[] = 'pacz-automotive-engine-oil';
		$icons[] = 'pacz-automotive-wheel';
		$icons[] = 'pacz-automotive-timing-belt';
		$icons[] = 'pacz-automotive-oil-gauge';
		$icons[] = 'pacz-automotive-door';
		$icons[] = 'pacz-automotive-wheel-1';
		$icons[] = 'pacz-automotive-starter';
		$icons[] = 'pacz-automotive-headlights';
		$icons[] = 'pacz-automotive-automatic-transmission';
		$icons[] = 'pacz-automotive-radiator';
		$icons[] = 'pacz-automotive-seat';
		$icons[] = 'pacz-automotive-mirror';
		$icons[] = 'pacz-automotive-seatbelt';
		$icons[] = 'pacz-automotive-condenser';
		$icons[] = 'pacz-automotive-air-conditioner';
		$icons[] = 'pacz-automotive-hood';
		$icons[] = 'pacz-automotive-car';
		$icons[] = 'pacz-automotive-window';
		$icons[] = 'pacz-automotive-spark-plug';
		$icons[] = 'pacz-automotive-light-bulb';
		$icons[] = 'pacz-automotive-fender';
		$icons[] = 'pacz-automotive-oil-filter';
		$icons[] = 'pacz-automotive-mirror-1';
		$icons[] = 'pacz-automotive-bumper';
		$icons[] = 'pacz-automotive-air-filter';
		$icons[] = 'pacz-automotive-antenna';
		$icons[] = 'pacz-automotive-grid';
		$icons[] = 'pacz-automotive-navigator';
		$icons[] = 'pacz-automotive-brake-pad';
		$icons[] = 'pacz-automotive-accelerator';
		$icons[] = 'pacz-automotive-motor';
		$icons[] = 'pacz-automotive-oil';
		$icons[] = 'pacz-automotive-gas-station';
		$icons[] = 'pacz-automotive-car-wash';
		$icons[] = 'pacz-automotive-steering-wheel';
		$icons[] = 'pacz-automotive-manual';
		$icons[] = 'pacz-automotive-safety-belt';
		$icons[] = 'pacz-automotive-paint';
		$icons[] = 'pacz-automotive-clipboard';
		$icons[] = 'pacz-automotive-disc-brake';
		$icons[] = 'pacz-automotive-speedometer';
		$icons[] = 'pacz-automotive-spark-plug-1';
		$icons[] = 'pacz-automotive-spark-plug-2';
		$icons[] = 'pacz-automotive-speedometer-1';
		$icons[] = 'pacz-automotive-piston';
		$icons[] = 'pacz-automotive-start-button';
		$icons[] = 'pacz-automotive-disc-brake-1';
		$icons[] = 'pacz-automotive-parking-sensor';
		$icons[] = 'pacz-automotive-airbag';
		$icons[] = 'pacz-automotive-speedometer-2';
		$icons[] = 'pacz-automotive-inspection';
		$icons[] = 'pacz-automotive-engine';
		$icons[] = 'pacz-automotive-tire';
		$icons[] = 'pacz-automotive-piston-1';
		$icons[] = 'pacz-automotive-electrical-service';
		$icons[] = 'pacz-automotive-wheel-alignment';
		$icons[] = 'pacz-automotive-alloy-wheel';
		$icons[] = 'pacz-automotive-ignition';
		$icons[] = 'pacz-automotive-work-tools';
		$icons[] = 'pacz-automotive-road';
		$icons[] = 'pacz-automotive-placeholder';
		$icons[] = 'pacz-automotive-24-hours';
		$icons[] = 'pacz-automotive-auto-suspension';
		$icons[] = 'pacz-automotive-battery';
		$icons[] = 'pacz-automotive-gasoline';
		$icons[] = 'pacz-automotive-battery-1';
		$icons[] = 'pacz-automotive-car-1';
		$icons[] = 'pacz-automotive-document';
		$icons[] = 'pacz-automotive-car-2';
		$icons[] = 'pacz-automotive-engine-1';
		$icons[] = 'pacz-automotive-maintenance';
		$icons[] = 'pacz-automotive-car-3';
		$icons[] = 'pacz-automotive-protection';
		$icons[] = 'pacz-automotive-car-service';
		$icons[] = 'pacz-automotive-car-service-1';
		$icons[] = 'pacz-automotive-car-4';
		$icons[] = 'pacz-automotive-car-5';
		$icons[] = 'pacz-automotive-car-6';
		$icons[] = 'pacz-automotive-chain';
		$icons[] = 'pacz-automotive-compressor';
		$icons[] = 'pacz-automotive-cogwheel';
		$icons[] = 'pacz-automotive-disc-brake-2';
		$icons[] = 'pacz-automotive-engine-2';
		$icons[] = 'pacz-automotive-gear-stick';
		$icons[] = 'pacz-automotive-hand';
		$icons[] = 'pacz-automotive-airplane';
		$icons[] = 'pacz-automotive-tractor';
		$icons[] = 'pacz-automotive-airplane-1';
		$icons[] = 'pacz-automotive-airplane-2';
		$icons[] = 'pacz-automotive-boat';
		$icons[] = 'pacz-automotive-vehicle';
		$icons[] = 'pacz-automotive-bus';
		$icons[] = 'pacz-automotive-car-7';
		$icons[] = 'pacz-automotive-car-8';
		$icons[] = 'pacz-automotive-car-9';
		$icons[] = 'pacz-automotive-car-10';
		$icons[] = 'pacz-automotive-crane';
		$icons[] = 'pacz-automotive-cruise';
		$icons[] = 'pacz-automotive-airplane-3';
		$icons[] = 'pacz-automotive-delivery';
		$icons[] = 'pacz-automotive-tractor-1';
		$icons[] = 'pacz-automotive-goods';
		$icons[] = 'pacz-automotive-goods-1';
		$icons[] = 'pacz-automotive-goods-2';
		$icons[] = 'pacz-automotive-jeep';
		$icons[] = 'pacz-automotive-train';
		$icons[] = 'pacz-automotive-lorry';
		$icons[] = 'pacz-automotive-lorry-1';
		$icons[] = 'pacz-automotive-ambulance';
		$icons[] = 'pacz-automotive-airplane-4';
		$icons[] = 'pacz-automotive-airplane-5';
		$icons[] = 'pacz-automotive-steering-wheel-1';
		$icons[] = 'pacz-automotive-oil-1';
		$icons[] = 'pacz-automotive-speedometer-3';
		$icons[] = 'pacz-automotive-key';
		$icons[] = 'pacz-automotive-parking';
		$icons[] = 'pacz-automotive-gauge';
		$icons[] = 'pacz-automotive-car-engine';
		$icons[] = 'pacz-automotive-motorcycle';
		$icons[] = 'pacz-automotive-engine-3';
		$icons[] = 'pacz-automotive-dashboard';
		$icons[] = 'pacz-automotive-formula-1';
		$icons[] = 'pacz-automotive-belt';
		$icons[] = 'pacz-automotive-timing-belt-1';
		$icons[] = 'pacz-automotive-motorcycle-1';
		$icons[] = 'pacz-automotive-windshield';
		$icons[] = 'pacz-automotive-spray-paint';
		$icons[] = 'pacz-automotive-motorcycle-2';
		$icons[] = 'pacz-automotive-engine-4';
		$icons[] = 'pacz-automotive-air-filter-1';
		$icons[] = 'pacz-automotive-helmet';
		$icons[] = 'pacz-automotive-engine-5';
		$icons[] = 'pacz-automotive-engine-6';
		$icons[] = 'pacz-automotive-quad';
		$icons[] = 'pacz-automotive-damper';
		$icons[] = 'pacz-automotive-damper-1';
		$icons[] = 'pacz-automotive-steering-wheel-2';
		$icons[] = 'pacz-automotive-oil-2';
		$icons[] = 'pacz-automotive-piston-2';
		$icons[] = 'pacz-automotive-motorcycle-3';
		$icons[] = 'pacz-automotive-battery-2';
		$icons[] = 'pacz-automotive-car-door';
		$icons[] = 'pacz-automotive-helmet-1';
		$icons[] = 'pacz-automotive-jerrycan';
		$icons[] = 'pacz-automotive-piston-3';
		$icons[] = 'pacz-automotive-helmet-2';
		$icons[] = 'pacz-automotive-suspension';
		$icons[] = 'pacz-automotive-engine-7';
		$icons[] = 'pacz-automotive-car-lights';
		$icons[] = 'pacz-automotive-piston-4';
		$icons[] = 'pacz-automotive-gearshift';
		$icons[] = 'pacz-automotive-cross-wrench';
		$icons[] = 'pacz-automotive-chassis';
		$icons[] = 'pacz-automotive-car-11';
		$icons[] = 'pacz-automotive-crankshaft';
		$icons[] = 'pacz-automotive-alloy-wheel-1';
		$icons[] = 'pacz-automotive-wheel-2';
		$icons[] = 'pacz-automotive-camera';
		$icons[] = 'pacz-automotive-radiator-1';
		$icons[] = 'pacz-automotive-chassis-1';
		$icons[] = 'pacz-automotive-motor-1';
		$icons[] = 'pacz-automotive-tire-1';
		$icons[] = 'pacz-automotive-distribution';
		$icons[] = 'pacz-automotive-route';
		$icons[] = 'pacz-automotive-highway';
		$icons[] = 'pacz-automotive-speedometer-4';
		$icons[] = 'pacz-automotive-gas-station-1';
		$icons[] = 'pacz-automotive-speedometer-5';
		$icons[] = 'pacz-automotive-key-1';
		$icons[] = 'pacz-automotive-battery-3';
		$icons[] = 'pacz-automotive-anchor';
		$icons[] = 'pacz-automotive-quad-1';
		$icons[] = 'pacz-automotive-finish';
		$icons[] = 'pacz-automotive-cross-wrench-1';
		$icons[] = 'pacz-automotive-chopper';
		$icons[] = 'pacz-automotive-cone';
		$icons[] = 'pacz-automotive-case';
		$icons[] = 'pacz-automotive-car-key';
		$icons[] = 'pacz-automotive-battery-4';
		$icons[] = 'pacz-automotive-gasoline-1';
		$icons[] = 'pacz-automotive-navigation';
		$icons[] = 'pacz-automotive-piston-5';
		$icons[] = 'pacz-automotive-tricycle';
		$icons[] = 'pacz-automotive-traffic-light';
		$icons[] = 'pacz-automotive-tools';
		$icons[] = 'pacz-automotive-speedometer-6';
		$icons[] = 'pacz-automotive-podium';
		$icons[] = 'pacz-automotive-street';
		$icons[] = 'pacz-automotive-traffic-light-1';
		$icons[] = 'pacz-automotive-dashboard-1';
		$icons[] = 'pacz-automotive-gear-shift';
		$icons[] = 'pacz-automotive-traffic-cone';
		$icons[] = 'pacz-automotive-warning';
		$icons[] = 'pacz-automotive-traffic-light-2';
		$icons[] = 'pacz-automotive-car-light';
		$icons[] = 'pacz-automotive-stop';
		$icons[] = 'pacz-automotive-road-1';
		$icons[] = 'pacz-automotive-location';
		$icons[] = 'pacz-automotive-street-1';
		$icons[] = 'pacz-automotive-road-2';
		$icons[] = 'pacz-automotive-dashboard-2';
		$icons[] = 'pacz-automotive-sign';
		$icons[] = 'pacz-automotive-car-12';
		$icons[] = 'pacz-automotive-tachometer';
		$icons[] = 'pacz-automotive-car-light-1';
		$icons[] = 'pacz-automotive-road-3';
		$icons[] = 'pacz-automotive-first-aid-kit';
		$icons[] = 'pacz-automotive-battery-5';
		$icons[] = 'pacz-automotive-stop-1';
	
	return $icons;
}

function alsp_current_user_can_edit_advert($listing_id) {
	if (!current_user_can('edit_others_posts')) {
		$post = get_post($listing_id);
		$current_user = wp_get_current_user();
		if ($current_user->ID != $post->post_author)
			return false;
		if ($post->post_status == 'pending'  && !is_admin())
			return false;
	}
	return true;
}

function alsp_get_edit_advert_link($listing_id, $context = 'display') {
	if (alsp_current_user_can_edit_advert($listing_id)) {
		$post = get_post($listing_id);
		$current_user = wp_get_current_user();
		if (current_user_can('edit_others_posts') && $current_user->ID != $post->post_author)
			return get_edit_post_link($listing_id, $context);
		else
			return apply_filters('alsp_get_edit_advert_link', get_edit_post_link($listing_id, $context), $listing_id);
	}
}

function alsp_show_edit_button($listing_id) {
	global $ALSP_ADIMN_SETTINGS;
	global $alsp_instance;
	if (
		alsp_current_user_can_edit_advert($listing_id)
		&&
		(
			($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && isset($alsp_instance->dashboard_page_url) && $alsp_instance->dashboard_page_url)
			||
			((!$ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] || !isset($alsp_instance->dashboard_page_url) || !$alsp_instance->dashboard_page_url) && !$ALSP_ADIMN_SETTINGS['alsp_hide_admin_bar'] && current_user_can('edit_posts'))
		)
	)
		return true;
}

function alsp_hex2rgba($color, $opacity = false) {
	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

// adapted for Relevanssi
function alsp_is_relevanssi_search($defaults = false) {
	if (
		function_exists('relevanssi_do_query') &&
		(
				(
						!$defaults &&
						alsp_getValue($_REQUEST, 'what_search')
						/* (
							!empty($defaults['include_get_params']) &&
							(alsp_getValue($_GET, 'what_search') || alsp_getValue($_POST, 'what_search'))
						) */
				) ||
				($defaults && isset($defaults['what_search']) && $defaults['what_search'])
		)
	) {
		return apply_filters('alsp_is_relevanssi_search', true, $defaults);
	}
}

function alsp_is_maps_used() {
	global $wpdb, $alsp_instance;
	$prefix = $wpdb->prefix;
	$table_name = $wpdb->prefix.'alsp_levels';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
		foreach ($alsp_instance->levels->levels_array as $level) {
			if ($level->map)
				return true;
		}
	}
	return false;
}
function alsp_listing_view_type() {
	global $alsp_instance;
	if ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listings')){
		$public_control = $directory_controller;
	}elseif ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)){
		$public_control = $directory_controller;
	}elseif ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing')){
		$public_control = $directory_controller;
	}else{
		$public_control = 0;
	}
	if(!is_author()){
	if(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
				$listing_style_to_show = 'show_grid_style';
				//update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($public_control->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
				$listing_style_to_show = 'show_list_style';
				//update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'list')){
				$listing_style_to_show = 'show_list_style';
				//update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($public_control->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$public_control->hash])) || (isset($_COOKIE['alsp_listings_view_'.$public_control->hash]) && $_COOKIE['alsp_listings_view_'.$public_control->hash] == 'grid')){
				$listing_style_to_show = 'show_grid_style';
				//update_option('listing_style_to_show', $listing_style_to_show);
			}else{
				$listing_style_to_show = 'show_grid_style';
			}
	return $listing_style_to_show;
	}
}

function alsp_is_field_label_on_grid() {
	global $alsp_instance;
	//$status = 'hide';
	global $wpdb;
	$field_ids = $wpdb->get_results('SELECT id, is_hide_name_on_grid FROM '.$wpdb->prefix.'alsp_content_fields');
	foreach( $field_ids as $field_id ) {
		$singlefield_id = $field_id->id;
		if($field_id->is_hide_name_on_grid == 'show_only_label'){	
			$status = 'show_only_label';
		}elseif($field_id->is_hide_name_on_grid == 'show_icon_label'){	
			$status = 'show_icon_label';
		}elseif($field_id->is_hide_name_on_grid == 'show_only_icon'){	
			$status = 'show_only_icon';
		}else{
			$status = 'hide';
		}
												
	}
	return $status;
}
function isField_on_exerpt(){
	global $alsp_instance;
	
	foreach ($alsp_instance->content_fields->content_fields_array as $content_field) {
		if ($content_field->on_exerpt_page)
			return true;
	}
	return false;
}
function isField_on_exerpt_list(){
	global $alsp_instance;
	
	foreach ($alsp_instance->content_fields->content_fields_array as $content_field) {
		if ($content_field->on_exerpt_page_list)
			return true;
	}
	return false;
}
function isField_inLine(){
	global $alsp_instance;
	
	foreach ($alsp_instance->content_fields->content_fields_array as $content_field) {
		if ($content_field->is_field_in_line)
			return true;
	}
	return false;
}
function isField_inBlock(){
	global $alsp_instance;
	
	foreach ($alsp_instance->content_fields->content_fields_array as $content_field) {
		if (!$content_field->is_field_in_line)
			return true;
	}
	return false;
}
function alsp_is_field_label_on_list() {
	global $alsp_instance;
	//$status = 'hide';
	global $wpdb;
	$field_ids = $wpdb->get_results('SELECT id, is_hide_name_on_list FROM '.$wpdb->prefix.'alsp_content_fields');
	foreach( $field_ids as $field_id ) {
		$singlefield_id = $field_id->id;
		if($field_id->is_hide_name_on_list == 'show_only_label'){	
			$status = 'show_only_label';
		}elseif($field_id->is_hide_name_on_list == 'show_icon_label'){	
			$status = 'show_icon_label';
		}elseif($field_id->is_hide_name_on_list == 'show_only_icon'){	
			$status = 'show_only_icon';
		}else{
			$status = 'hide';
		}
												
	}
	return $status;
}
function GetListingShortcodeAttr( $atts ) {
	$atts = shortcode_atts(
		array(
			'listing_post_style' => '',
		), $atts, 'alsp-listings' );

	return $atts['listing_post_style'];
}
add_shortcode( 'bartag', 'bartag_func' );

function alsp_error_log($wp_error) {
	alsp_addMessage($wp_error->get_error_message(), 'error');
	error_log($wp_error->get_error_message());
}

function alsp_country_codes() {
	$codes['Afghanistan'] = 'AF';
	$codes['Åland Islands'] = 'AX';
	$codes['Albania'] = 'AL';
	$codes['Algeria'] = 'DZ';
	$codes['American Samoa'] = 'AS';
	$codes['Andorra'] = 'AD';
	$codes['Angola'] = 'AO';
	$codes['Anguilla'] = 'AI';
	$codes['Antarctica'] = 'AQ';
	$codes['Antigua and Barbuda'] = 'AG';
	$codes['Argentina'] = 'AR';
	$codes['Armenia'] = 'AM';
	$codes['Aruba'] = 'AW';
	$codes['Australia'] = 'AU';
	$codes['Austria'] = 'AT';
	$codes['Azerbaijan'] = 'AZ';
	$codes['Bahamas'] = 'BS';
	$codes['Bahrain'] = 'BH';
	$codes['Bangladesh'] = 'BD';
	$codes['Barbados'] = 'BB';
	$codes['Belarus'] = 'BY';
	$codes['Belgium'] = 'BE';
	$codes['Belize'] = 'BZ';
	$codes['Benin'] = 'BJ';
	$codes['Bermuda'] = 'BM';
	$codes['Bhutan'] = 'BT';
	$codes['Bolivia, Plurinational State of'] = 'BO';
	$codes['Bonaire, Sint Eustatius and Saba'] = 'BQ';
	$codes['Bosnia and Herzegovina'] = 'BA';
	$codes['Botswana'] = 'BW';
	$codes['Bouvet Island'] = 'BV';
	$codes['Brazil'] = 'BR';
	$codes['British Indian Ocean Territory'] = 'IO';
	$codes['Brunei Darussalam'] = 'BN';
	$codes['Bulgaria'] = 'BG';
	$codes['Burkina Faso'] = 'BF';
	$codes['Burundi'] = 'BI';
	$codes['Cambodia'] = 'KH';
	$codes['Cameroon'] = 'CM';
	$codes['Canada'] = 'CA';
	$codes['Cape Verde'] = 'CV';
	$codes['Cayman Islands'] = 'KY';
	$codes['Central African Republic'] = 'CF';
	$codes['Chad'] = 'TD';
	$codes['Chile'] = 'CL';
	$codes['China'] = 'CN';
	$codes['Christmas Island'] = 'CX';
	$codes['Cocos (Keeling) Islands'] = 'CC';
	$codes['Colombia'] = 'CO';
	$codes['Comoros'] = 'KM';
	$codes['Congo'] = 'CG';
	$codes['Congo, the Democratic Republic of the'] = 'CD';
	$codes['Cook Islands'] = 'CK';
	$codes['Costa Rica'] = 'CR';
	$codes['Côte d\'Ivoire'] = 'CI';
	$codes['Croatia'] = 'HR';
	$codes['Cuba'] = 'CU';
	$codes['Curaçao'] = 'CW';
	$codes['Cyprus'] = 'CY';
	$codes['Czech Republic'] = 'CZ';
	$codes['Denmark'] = 'DK';
	$codes['Djibouti'] = 'DJ';
	$codes['Dominica'] = 'DM';
	$codes['Dominican Republic'] = 'DO';
	$codes['Ecuador'] = 'EC';
	$codes['Egypt'] = 'EG';
	$codes['El Salvador'] = 'SV';
	$codes['Equatorial Guinea'] = 'GQ';
	$codes['Eritrea'] = 'ER';
	$codes['Estonia'] = 'EE';
	$codes['Ethiopia'] = 'ET';
	$codes['Falkland Islands (Malvinas)'] = 'FK';
	$codes['Faroe Islands'] = 'FO';
	$codes['Fiji'] = 'FJ';
	$codes['Finland'] = 'FI';
	$codes['France'] = 'FR';
	$codes['French Guiana'] = 'GF';
	$codes['French Polynesia'] = 'PF';
	$codes['French Southern Territories'] = 'TF';
	$codes['Gabon'] = 'GA';
	$codes['Gambia'] = 'GM';
	$codes['Georgia'] = 'GE';
	$codes['Germany'] = 'DE';
	$codes['Ghana'] = 'GH';
	$codes['Gibraltar'] = 'GI';
	$codes['Greece'] = 'GR';
	$codes['Greenland'] = 'GL';
	$codes['Grenada'] = 'GD';
	$codes['Guadeloupe'] = 'GP';
	$codes['Guam'] = 'GU';
	$codes['Guatemala'] = 'GT';
	$codes['Guernsey'] = 'GG';
	$codes['Guinea'] = 'GN';
	$codes['Guinea-Bissau'] = 'GW';
	$codes['Guyana'] = 'GY';
	$codes['Haiti'] = 'HT';
	$codes['Heard Island and McDonald Islands'] = 'HM';
	$codes['Holy See (Vatican City State)'] = 'VA';
	$codes['Honduras'] = 'HN';
	$codes['Hong Kong'] = 'HK';
	$codes['Hungary'] = 'HU';
	$codes['Iceland'] = 'IS';
	$codes['India'] = 'IN';
	$codes['Indonesia'] = 'ID';
	$codes['Iran, Islamic Republic of'] = 'IR';
	$codes['Iraq'] = 'IQ';
	$codes['Ireland'] = 'IE';
	$codes['Isle of Man'] = 'IM';
	$codes['Israel'] = 'IL';
	$codes['Italy'] = 'IT';
	$codes['Jamaica'] = 'JM';
	$codes['Japan'] = 'JP';
	$codes['Jersey'] = 'JE';
	$codes['Jordan'] = 'JO';
	$codes['Kazakhstan'] = 'KZ';
	$codes['Kenya'] = 'KE';
	$codes['Kiribati'] = 'KI';
	$codes['Korea, Democratic People\'s Republic of'] = 'KP';
	$codes['Korea, Republic of'] = 'KR';
	$codes['Kuwait'] = 'KW';
	$codes['Kyrgyzstan'] = 'KG';
	$codes['Lao People\'s Democratic Republic'] = 'LA';
	$codes['Latvia'] = 'LV';
	$codes['Lebanon'] = 'LB';
	$codes['Lesotho'] = 'LS';
	$codes['Liberia'] = 'LR';
	$codes['Libya'] = 'LY';
	$codes['Liechtenstein'] = 'LI';
	$codes['Lithuania'] = 'LT';
	$codes['Luxembourg'] = 'LU';
	$codes['Macao'] = 'MO';
	$codes['Macedonia, the Former Yugoslav Republic of'] = 'MK';
	$codes['Madagascar'] = 'MG';
	$codes['Malawi'] = 'MW';
	$codes['Malaysia'] = 'MY';
	$codes['Maldives'] = 'MV';
	$codes['Mali'] = 'ML';
	$codes['Malta'] = 'MT';
	$codes['Marshall Islands'] = 'MH';
	$codes['Martinique'] = 'MQ';
	$codes['Mauritania'] = 'MR';
	$codes['Mauritius'] = 'MU';
	$codes['Mayotte'] = 'YT';
	$codes['Mexico'] = 'MX';
	$codes['Micronesia, Federated States of'] = 'FM';
	$codes['Moldova, Republic of'] = 'MD';
	$codes['Monaco'] = 'MC';
	$codes['Mongolia'] = 'MN';
	$codes['Montenegro'] = 'ME';
	$codes['Montserrat'] = 'MS';
	$codes['Morocco'] = 'MA';
	$codes['Mozambique'] = 'MZ';
	$codes['Myanmar'] = 'MM';
	$codes['Namibia'] = 'NA';
	$codes['Nauru'] = 'NR';
	$codes['Nepal'] = 'NP';
	$codes['Netherlands'] = 'NL';
	$codes['New Caledonia'] = 'NC';
	$codes['New Zealand'] = 'NZ';
	$codes['Nicaragua'] = 'NI';
	$codes['Niger'] = 'NE';
	$codes['Nigeria'] = 'NG';
	$codes['Niue'] = 'NU';
	$codes['Norfolk Island'] = 'NF';
	$codes['Northern Mariana Islands'] = 'MP';
	$codes['Norway'] = 'NO';
	$codes['Oman'] = 'OM';
	$codes['Pakistan'] = 'PK';
	$codes['Palau'] = 'PW';
	$codes['Palestine, State of'] = 'PS';
	$codes['Panama'] = 'PA';
	$codes['Papua New Guinea'] = 'PG';
	$codes['Paraguay'] = 'PY';
	$codes['Peru'] = 'PE';
	$codes['Philippines'] = 'PH';
	$codes['Pitcairn'] = 'PN';
	$codes['Poland'] = 'PL';
	$codes['Portugal'] = 'PT';
	$codes['Puerto Rico'] = 'PR';
	$codes['Qatar'] = 'QA';
	$codes['Réunion'] = 'RE';
	$codes['Romania'] = 'RO';
	$codes['Russian Federation'] = 'RU';
	$codes['Rwanda'] = 'RW';
	$codes['Saint Barthélemy'] = 'BL';
	$codes['Saint Helena, Ascension and Tristan da Cunha'] = 'SH';
	$codes['Saint Kitts and Nevis'] = 'KN';
	$codes['Saint Lucia'] = 'LC';
	$codes['Saint Martin (French part)'] = 'MF';
	$codes['Saint Pierre and Miquelon'] = 'PM';
	$codes['Saint Vincent and the Grenadines'] = 'VC';
	$codes['Samoa'] = 'WS';
	$codes['San Marino'] = 'SM';
	$codes['Sao Tome and Principe'] = 'ST';
	$codes['Saudi Arabia'] = 'SA';
	$codes['Senegal'] = 'SN';
	$codes['Serbia'] = 'RS';
	$codes['Seychelles'] = 'SC';
	$codes['Sierra Leone'] = 'SL';
	$codes['Singapore'] = 'SG';
	$codes['Sint Maarten (Dutch part)'] = 'SX';
	$codes['Slovakia'] = 'SK';
	$codes['Slovenia'] = 'SI';
	$codes['Solomon Islands'] = 'SB';
	$codes['Somalia'] = 'SO';
	$codes['South Africa'] = 'ZA';
	$codes['South Georgia and the South Sandwich Islands'] = 'GS';
	$codes['South Sudan'] = 'SS';
	$codes['Spain'] = 'ES';
	$codes['Sri Lanka'] = 'LK';
	$codes['Sudan'] = 'SD';
	$codes['Suriname'] = 'SR';
	$codes['Svalbard and Jan Mayen'] = 'SJ';
	$codes['Swaziland'] = 'SZ';
	$codes['Sweden'] = 'SE';
	$codes['Switzerland'] = 'CH';
	$codes['Syrian Arab Republic'] = 'SY';
	$codes['Taiwan, Province of China"'] = 'TW';
	$codes['Tajikistan'] = 'TJ';
	$codes['"Tanzania, United Republic of"'] = 'TZ';
	$codes['Thailand'] = 'TH';
	$codes['Timor-Leste'] = 'TL';
	$codes['Togo'] = 'TG';
	$codes['Tokelau'] = 'TK';
	$codes['Tonga'] = 'TO';
	$codes['Trinidad and Tobago'] = 'TT';
	$codes['Tunisia'] = 'TN';
	$codes['Turkey'] = 'TR';
	$codes['Turkmenistan'] = 'TM';
	$codes['Turks and Caicos Islands'] = 'TC';
	$codes['Tuvalu'] = 'TV';
	$codes['Uganda'] = 'UG';
	$codes['Ukraine'] = 'UA';
	$codes['United Arab Emirates'] = 'AE';
	$codes['United Kingdom'] = 'GB';
	$codes['United States'] = 'US';
	$codes['United States Minor Outlying Islands'] = 'UM';
	$codes['Uruguay'] = 'UY';
	$codes['Uzbekistan'] = 'UZ';
	$codes['Vanuatu'] = 'VU';
	$codes['Venezuela,  Bolivarian Republic of'] = 'VE';
	$codes['Viet Nam'] = 'VN';
	$codes['Virgin Islands, British'] = 'VG';
	$codes['Virgin Islands, U.S.'] = 'VI';
	$codes['Wallis and Futuna'] = 'WF';
	$codes['Western Sahara'] = 'EH';
	$codes['Yemen'] = 'YE';
	$codes['Zambia'] = 'ZM';
	$codes['Zimbabwe'] = 'ZW';
	return $codes;
}

function alsp_isWooActive() {
	global $ALSP_ADIMN_SETTINGS;
	if (
		$ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_woo_payment'
		&&
		in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))
	) 
		return true;
}
function alsp_isWooActiveAll() {
	if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) 
		return true;
}

function alsp_isMapBoxActive() {
	global $ALSP_ADIMN_SETTINGS;
	if (in_array('di-mapbox/di-mapbox.php', apply_filters('active_plugins', get_option('active_plugins')))
	) 
		return true;
}

function alsp_isDiTwilioActive() {
	global $ALSP_ADIMN_SETTINGS;
	if (in_array('di-twilio/di-twilio.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
	$api_details = get_option('di-twilio');
		if(is_array($api_details) AND count($api_details) != 0) {
			$TWILIO_SID = $api_details['api_sid'];
			$TWILIO_TOKEN = $api_details['api_auth_token'];
			$sender_id = $api_details['sender_id'];
			if(!empty($TWILIO_SID) && !!empty($TWILIO_TOKEN) && !empty($sender_id)){
				return true;
			}
		}	
	}
}

function alsp_isDiOtpActive() {
	global $ALSP_ADIMN_SETTINGS;
	if (in_array('di-otp/di-otp.php', apply_filters('active_plugins', get_option('active_plugins')))
	) 
		return true;
}


function alsp_getAdminNotificationEmail() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'])
		return $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'];
	else 
		return get_option('admin_email');
}

function alsp_wpmlTranslationCompleteNotice() {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress && defined('WPML_ST_VERSION')) {
		echo '<p class="description">';
		_e('After save do not forget to set completed translation status for this string on String Translation page.', 'ALSP');
		echo '</p>';
	}
}

function alsp_phpmailerInit($phpmailer) {
	$phpmailer->AltBody = wp_specialchars_decode($phpmailer->Body, ENT_QUOTES);
}
function alsp_mail($email, $subject, $body, $headers = null) {
	// create and add HTML part into emails
	add_action('phpmailer_init', 'alsp_phpmailerInit');

	if (!$headers) {
		$headers[] = "From: " . get_option('blogname') . " <" . alsp_getAdminNotificationEmail() . ">";
		$headers[] = "Reply-To: " . alsp_getAdminNotificationEmail();
		$headers[] = "Content-Type: text/html";
	}
		
	$subject = "[" . get_option('blogname') . "] " .$subject;

	$body = make_clickable(wpautop($body));
	
	$email = apply_filters('alsp_mail_email', $email, $subject, $body, $headers);
	$subject = apply_filters('alsp_mail_subject', $subject, $email, $body, $headers);
	$body = apply_filters('alsp_mail_body', $body, $email, $subject, $headers);
	$headers = apply_filters('alsp_mail_headers', $headers, $email, $subject, $body);
	
	add_action('wp_mail_failed', 'alsp_error_log');

	return wp_mail($email, $subject, $body, $headers);
}

function alsp_getListing($post) {
	$listing = new alsp_listing;
	if ($listing->loadListingFromPost($post)) {
		return $listing;
	}
}

function alsp_isListing() {
	global $alsp_instance;

	if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_LISTING_SHORTCODE)) || ($directory_controller = $alsp_instance->getShortcodeProperty('alsp-listing'))) {
		if ($directory_controller->is_single) {
			return $directory_controller->listing;
		}
	}
}
function alsp_isSingleListing() {
	global $alsp_instance;

	if ($alsp_instance->getShortcodeProperty('alsp-listing')) {
		return true;
	}else{
		return false;
	}
}
function alsp_isCategory() {
	global $alsp_instance;

	if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE))) {
		if ($directory_controller->is_category) {
			return $directory_controller->category;
		}
	}
}

function alsp_isLocation() {
	global $alsp_instance;

	if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE))) {
		if ($directory_controller->is_location) {
			return $directory_controller->location;
		}
	}
}

function alsp_isTag() {
	global $alsp_instance;

	if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE))) {
		if ($directory_controller->is_tag) {
			return $directory_controller->tag;
		}
	}
}

function alsp_getListingDirectory($listing_id) {
	global $alsp_instance;

	if (get_post_type($listing_id) == ALSP_POST_TYPE) {
		if ($directory_id = get_post_meta($listing_id, '_directory_id', true)) {
			if ($directory = $alsp_instance->directories->getDirectoryById($directory_id)) {
				return $directory;
			}
		}
	} elseif ($alsp_instance->current_directory) {
		return $alsp_instance->current_directory;
	}
	return $alsp_instance->directories->getDefaultDirectory();
}

function alsp_isDirectoryPageInAdmin() {
	global $pagenow;

	if (
		is_admin() &&
		(($pagenow == 'edit.php' || $pagenow == 'post-new.php') && ($post_type = alsp_getValue($_GET, 'post_type')) &&
				(in_array($post_type, array(ALSP_POST_TYPE, 'alsp_invoice')))
		) ||
		($pagenow == 'post.php' && ($post_id = alsp_getValue($_GET, 'post')) && ($post = get_post($post_id)) &&
				(in_array($post->post_type, array(ALSP_POST_TYPE, 'alsp_invoice', 'shop_order', 'shop_subscription')))
		) ||
		(($pagenow == 'edit-tags.php' || $pagenow == 'term.php') && ($taxonomy = alsp_getValue($_GET, 'taxonomy')) &&
				(in_array($taxonomy, array(ALSP_LOCATIONS_TAX, ALSP_CATEGORIES_TAX, ALSP_TAGS_TAX)))
		) ||
		(($page = alsp_getValue($_GET, 'page')) &&
				(in_array($page,
						array(
								'alsp_settings',
								'alsp_directories',
								'alsp_levels',
								'alsp_manage_upgrades',
								'alsp_locations_levels',
								'alsp_content_fields',
								'alsp_csv_import',
								'alsp_renew',
								'alsp_upgrade',
								'alsp_changedate',
								'alsp_raise_up',
								'alsp_upgrade',
								'alsp_upgrade_bulk',
								'alsp_process_claim'
						)
				))
		) ||
		($pagenow == 'widgets.php')
	) {
		return true;
	}
}

function alsp_isListingEditPageInAdmin() {
	global $pagenow;

	if (
		($pagenow == 'post-new.php' && ($post_type = alsp_getValue($_GET, 'post_type')) &&
				(in_array($post_type, array(ALSP_POST_TYPE)))
		) ||
		($pagenow == 'post.php' && ($post_id = alsp_getValue($_GET, 'post')) && ($post = get_post($post_id)) &&
				(in_array($post->post_type, array(ALSP_POST_TYPE)))
		)
	) {
		return true;
	}
}

function alsp_isLocationsEditPageInAdmin() {
	global $pagenow;

	if (($pagenow == 'edit-tags.php' || $pagenow == 'term.php') && ($taxonomy = alsp_getValue($_GET, 'taxonomy')) &&
				(in_array($taxonomy, array(ALSP_LOCATIONS_TAX)))) {
		return true;
	}
}

function alsp_isCategoriesEditPageInAdmin() {
	global $pagenow;

	if (($pagenow == 'edit-tags.php' || $pagenow == 'term.php') && ($taxonomy = alsp_getValue($_GET, 'taxonomy')) &&
				(in_array($taxonomy, array(ALSP_CATEGORIES_TAX)))) {
		return true;
	}
}

function alsp_isListingTypeEditPageInAdmin() {
	global $pagenow;

	if (($pagenow == 'edit-tags.php' || $pagenow == 'term.php') && ($taxonomy = alsp_getValue($_GET, 'taxonomy')) &&
				(in_array($taxonomy, array(ALSP_TYPE_TAX)))) {
		return true;
	}
}

function alsp_getCategoryIconFile($term_id) {
	//if ($icons = is_array($icons) && isset($icons[$term_id])) {
		//return $icons[$term_id];
	//}
}

function alsp_getListingTypeIconFile($term_id) {
	//if ($icons = is_array($icons) && isset($icons[$term_id])) {
		//return $icons[$term_id];
	//}
}

function alsp_getCategoryImageUrl($term_id, $size = 'full') {
	global $alsp_instance;
	
	if ($image_url = $alsp_instance->categories_manager->get_featured_image_url($term_id, $size)) {
		return $image_url;
	}
}

function alsp_getListingTypeImageUrl($term_id, $size = 'full') {
	global $alsp_instance;
	
	if ($image_url = $alsp_instance->listingtype_manager->get_featured_image_url($term_id, $size)) {
		return $image_url;
	}
}

function alsp_getLocationIconFile($term_id) {
	if (($icons = get_option('alsp_locations_icons')) && is_array($icons) && isset($icons[$term_id])) {
		return $icons[$term_id];
	}
}

function alsp_getLocationImageUrl($term_id, $size = 'full') {
	global $alsp_instance;

	if ($image_url = $alsp_instance->locations_manager->get_featured_image_url($term_id, $size)) {
		return $image_url;
	}
}

function alsp_getSearchTermID($query_var, $get_var, $default_term_id) {
	if (get_query_var($query_var) && ($category_object = alsp_get_term_by_path(get_query_var($query_var)))) {
		$term_id = $category_object->term_id;
	} elseif (isset($_GET[$get_var]) && is_numeric($_GET[$get_var])) {
		$term_id = $_GET[$get_var];
	} else {
		$term_id = $default_term_id;
	}
	return $term_id;
}

function alsp_getMapEngine() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_map_type'] == 'mapbox') {
		return 'mapbox';
	}elseif ($ALSP_ADIMN_SETTINGS['alsp_map_type'] == 'google') {
		return 'google';
	}else{
		return 'mapbox';
	}
}

function alsp_getAllMapStyles() {
	if (alsp_getMapEngine() == 'google') {
		global $alsp_google_maps_styles;
		
		return $alsp_google_maps_styles;
	} elseif (alsp_getMapEngine() == 'mapbox') {
		return alsp_getMapBoxStyles();
	}
}

function alsp_getSelectedMapStyleName() {
	global $ALSP_ADIMN_SETTINGS;
	if (alsp_getMapEngine() == 'google') {
		return $ALSP_ADIMN_SETTINGS['alsp_map_style'];
	} elseif (alsp_getMapEngine() == 'mapbox') {
		$style = 'streets-v10';
		return $style;
	}
}

function alsp_getSelectedMapStyle($map_style = false) {
	if (!$map_style) {
		$map_style = alsp_getSelectedMapStyleName();
	}
	
	if (alsp_getMapEngine() == 'google') {
		global $alsp_google_maps_styles;

		if (!empty($alsp_google_maps_styles[$map_style])) {
			return $alsp_google_maps_styles[$map_style];
		} else {
			return '';
		}
	} elseif (alsp_getMapEngine() == 'mapbox') {
		$mapbox_styles = alsp_getMapBoxStyles();
		if (in_array($map_style, $mapbox_styles)) {
			return $map_style;
		} else {
			return array_shift($mapbox_styles);
		}
	}
}

function alsp_getMapBoxStyles() {
	$styles = array(
			'Streets' => 'streets-v10',
			'OutDoors' => 'outdoors-v10',
			'Light' => 'light-v9',
			'Dark' => 'dark-v9',
			'Satellite' => 'satellite-v9',
			'Satellite streets' => 'satellite-streets-v10',
			'Navigation preview day' => 'navigation-preview-day-v2',
			'Navigation preview night' => 'navigation-preview-night-v2',
			'Navigation guidance day' => 'navigation-guidance-day-v2',
			'Navigation guidance night' => 'navigation-guidance-night-v2',
	);
	
	$styles = apply_filters('alsp_mapbox_maps_styles', $styles);
	
	return $styles;
}
function alsp_visibleSearchParam($param_text, $link) {
	$parse_url = parse_url($link, PHP_URL_QUERY);
	parse_str($parse_url, $parse_url_str);
	if (count($parse_url_str) == 1 && alsp_getValue($parse_url_str, 'alsp_action') == 'search') {
		$link = remove_query_arg('alsp_action', $link);
	} elseif ($use_advanced = alsp_getValue($_REQUEST, 'use_advanced')) {
		$link = add_query_arg('use_advanced', '1', $link);
	}
	
	return '<div class="alsp-search-param"><a class="alsp-search-param-delete" href="' . $link . '">×</a>' . $param_text . '</div>';
}

function alsp_wrapKeys(&$val) {
	$val = "`".$val."`";
}
function alsp_wrapValues(&$val) {
	$val = "'".$val."'";
}
function alsp_wrapIntVal(&$val) {
	$val = intval($val);
}
function alsp_is_woo_packages() {
	global $ALSP_ADIMN_SETTINGS;
	global $alsp_instance;

	if (
		alsp_isWooActive() &&
		($ALSP_ADIMN_SETTINGS['alsp_woocommerce_mode'] == 'both') &&
		$alsp_instance->listings_package_product->get_all_packages()
	)
		return true;
}

function alsp_is_only_woo_packages() {
	global $ALSP_ADIMN_SETTINGS;
	global $alsp_instance;

	if (
		alsp_isWooActive() &&
		$ALSP_ADIMN_SETTINGS['alsp_woocommerce_mode'] == 'packages' &&
		$alsp_instance->listings_package_product->get_all_packages()
	)
		return true;
}



// NEEDS TO REMOVE 
function alsp_is_category() {
	global $alsp_instance;

	if (($directory_controller = $alsp_instance->getShortcodeProperty(ALSP_MAIN_SHORTCODE))) {
		if ($directory_controller->is_category) {
			return $directory_controller->category;
		}
	}
}



function display_average_listing_rating( $post_id = null, $decimals = 2 ) {

	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}

	global $direviews_plugin;

	if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
		$rating = $direviews_plugin->get_average_rating( $post_id, $decimals );
	}

	//if ( empty( $rating ) ) {
		//return;
	//} ?>
	<a href="#comments" class="single-rating review_rate display-only" data-dirrater="<?php echo $rating ?>" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		<span class="rating-value">(<span itemprop="reviewCount"><?php echo get_comments_number() ?></span>)</span>
		<meta itemprop="ratingValue" content = "<?php echo $rating ?>">
	</a>
	<?php
}

function display_total_listing_rating( $post_id = null, $decimals = 2 ) {

	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}

	global $direviews_plugin;

	if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
		$rating = $direviews_plugin->get_average_rating( $post_id, $decimals );
	}

	//if ( empty( $rating ) ) {
	//	return;
	//} ?>
	
		<span class="rating-value"><span><?php echo get_comments_number() ?></span> <?php echo esc_html__('ratings', 'ALSP'); ?></span>
	<?php
}

function get_average_listing_rating( $post_id = null, $decimals = 1 ) {

	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}

	global $direviews_plugin;
	//if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
		if($direviews_plugin->get_average_rating( $post_id, $decimals )){
			return $direviews_plugin->get_average_rating( $post_id, $decimals );
		}else{
			$default = '<i class="pacz-theme-icon-star"></i>';
			return $default;
		}
	//}

	//return false;
}



if (!function_exists('alsp_merge_css')) {
  function alsp_merge_css() {
	 // header("Content-type: text/css");

// Array of css files
$css = array(
    ALSP_RESOURCES_PATH . 'css/locations.css',
	ALSP_RESOURCES_PATH . 'css/alsp-listings.css',
	ALSP_RESOURCES_PATH . 'css/alsp-widget.css',
	ALSP_RESOURCES_PATH . 'css/alsp-search.css',
	ALSP_RESOURCES_PATH . 'css/alsp-categories.css',
	ALSP_RESOURCES_PATH . 'css/single-listing.css',
	ALSP_RESOURCES_PATH . 'css/frontend.css',
);

// Prevent a notice
$css_content = '';

// Loop the css Array
foreach ($css as $css_file) {
    // Load the content of the css file 
    $css_content .= file_get_contents($css_file);
}

// print the css content
return $css_content;
  }
}
add_action('user_register', 'addMyCustomMeta');      
function addMyCustomMeta( $user_id ) {    
           update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] ); 
}
function alsp_send_sms($to, $message) {
	$api_details = get_option('di-twilio');
	if(is_array($api_details) AND count($api_details) != 0) {
        $TWILIO_SID = $api_details['api_sid'];
        $TWILIO_TOKEN = $api_details['api_auth_token'];
		$sender_id = $api_details['sender_id'];
    }

	try{
        $to = explode(',', $to);
		if(class_exists('Twilio')){
        $client = new Twilio\Rest\Client($TWILIO_SID, $TWILIO_TOKEN);
        $response = $client->messages->create($to, array('from' => $sender_id, 'body' => $message));
		$return = $response;
		}
    } 
	catch(Exception $e){
        $return = new WP_Error( 'api-error', $e->getMessage(), $e );
    }           
}
function alsp_set_html_mail_content_type() {
    return 'text/html';
}
if (version_compare(get_bloginfo('version'), '4.3.1', '>=')){
    // for wordpress version greater than or equal to 4.3.1
    if ( !function_exists('wp_new_user_notification') ) {

        function wp_new_user_notification( $user_id, $deprecated = null, $notify = 'both' ) {
			global $ALSP_ADIMN_SETTINGS;

			if ( $deprecated !== null ) {
				_deprecated_argument( __FUNCTION__, '4.3.1' );
			}

			if( isset( $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] ) && $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] != '' ) {
					$sender_email_address = $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'];
			}else {
				$sender_email_address = get_option( 'admin_email' );
			}

			$email_body = $ALSP_ADIMN_SETTINGS['alsp_newuser_notification'];

			global $wpdb, $wp_hasher;
			$user = get_userdata( $user_id );
			if ( empty ( $user ) )
				return;

			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

			$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "<br />";
			$message .= sprintf(__('Username: %s'), $user->user_login) . "<br />";
			$message .= sprintf(__('E-mail: %s'), $user->user_email) . "<br />";
			$message .= "<br /><br />";
			$message .= 'Thank you';
        
			$headers = 'Content-type: text/html' . "\r\n" . 'From:' . get_option( 'blogname' ) . ' <' . $sender_email_address . '>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        
			add_filter('wp_mail_content_type', 'alsp_set_html_mail_content_type');
			@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message, $headers);

			if ( 'admin' === $notify || empty( $notify ) ) {
				return;
			}

			// Generate something random for a password reset key.
			$key = wp_generate_password( 20, false );

			/** This action is documented in wp-login.php */
			do_action( 'retrieve_password_key', $user->user_login, $key );

			// Now insert the key, hashed, into the DB.
			if ( empty( $wp_hasher ) ) {
				require_once ABSPATH . WPINC . '/class-phpass.php';
				$wp_hasher = new PasswordHash( 8, true );
			}
			$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );
			$password_set_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');
			$patterns = array('/#blogname/', '/#username/', '/#password_set_link/');
			$replacements = array(get_option('blogname'), $user->user_login, $password_set_link);
			$message = preg_replace($patterns, $replacements, $email_body);
			$headers = "MIME-Version: 1.0\r\n" . "From: " . get_option( 'blogname' ) . " " . "<" . $sender_email_address . ">\n" . "Content-Type: text/HTML; charset=\"" . get_option('blog_charset') . "\"\r\n";
			
			add_filter('wp_mail_content_type', 'alsp_set_html_mail_content_type');
			wp_mail($user->user_email, sprintf(__('[%s] Your username and password info'), $blogname), $message, $headers );
			//$phone = get_user_meta( $user->ID, 'user_phone', true );
			$to = get_user_meta( $user->ID, 'user_phone', true );
			if(alsp_isDiTwilioActive() && !empty($to)){
				alsp_send_sms($to, $message);
			}
        }
    }
}else{
    // for wordpress version less than 4.3.1
    if( !function_exists( 'wp_new_user_notification' ) ) {
    
        function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
		global $ALSP_ADIMN_SETTINGS;
       // $options = get_option( APSL_SETTINGS );
        
        if( isset( $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] ) && $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] != '' ) {
            $sender_email_address = $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'];
        } 
        else {
            $sender_email_address = get_option( 'admin_email' );
        }
        
        $email_body = $ALSP_ADIMN_SETTINGS['alsp_newuser_notification'];
        
        $user = new WP_User( $user_id );
        
        $user_login = stripslashes( $user->user_login );
        $user_email = stripslashes( $user->user_email );
        
        $message = sprintf( __( 'New user registration on your site %s:' ), get_option( 'blogname' ) ) . "<br />";
        $message.= sprintf( __( 'Username: %s' ), $user_login ) . "<br />";
        $message.= sprintf( __( 'E-mail: %s' ), $user_email ) . "<br /><br />";
        $message.= "<br /><br />";
        $message.= 'Thank you';

        
        $headers = 'Content-type: text/html' . "\r\n" . 'From:' . get_option( 'blogname' ) . ' <' . $sender_email_address . '>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        
        add_filter('wp_mail_content_type', 'alsp_set_html_mail_content_type');
        @wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] New User Registration' ), get_option( 'blogname' ) ), $message, $headers );
        
        if( empty( $plaintext_pass ) )return;
        $patterns = array('/#blogname/', '/#username/', '/#password/');
        $replacements = array(get_option('blogname'), $user->user_login, $plaintext_pass);
        $message = preg_replace($patterns, $replacements, $email_body);
        $headers = 'Content-type: text/html' . "\r\n" . 'From:' . get_option( 'blogname' ) . ' <' . $sender_email_address . '>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        
        add_filter('wp_mail_content_type', 'alsp_set_html_mail_content_type');
        @wp_mail( $user_email, sprintf( __( '[%s] Your username and password' ), get_option( 'blogname' ) ), $message, $headers );
		$to = get_user_meta( $user->ID, 'user_phone', true );
		if(alsp_isDiTwilioActive() && !empty($to)){
			alsp_send_sms($to, $message);
		}
        }
    }
}
add_action ('alsp_redirect_home_page', 'alsp_redirect_home');
function alsp_redirect_home() {
    wp_redirect(home_url('/'));
	exit;
}  
/* 
Adds shortcodes dynamic css into footer.php
*/
if (!function_exists('alsp_dynamic_css_injection')) {
     function alsp_dynamic_css_injection()
     {

      global $alsp_style_json, $alsp_styles;  
    
    echo '<script>';
    

    $backslash_styles = str_replace('\\', '\\\\', $alsp_styles);
    $clean_styles = preg_replace('!\s+!', ' ', $backslash_styles);
    $clean_styles_w = str_replace("'", "\"", $clean_styles);
    $is_admin_bar = is_admin_bar_showing() ? 'true' : 'false';
    $alsp_json_encode = json_encode($alsp_style_json);
    echo '  
    php = {
        hasAdminbar: '.$is_admin_bar.',
        json: ('.$alsp_json_encode.' != null) ? '.$alsp_json_encode.' : "",
        styles:  \''.$clean_styles_w.'\'
      };
      
    var styleTag = document.createElement("style"),
      head = document.getElementsByTagName("head")[0];

    styleTag.type = "text/css";
    styleTag.innerHTML = php.styles;
    head.appendChild(styleTag);
    </script>';

    

     }
}

add_action('wp_enqueue_scripts', 'alsp_dynamic_css_injection');
/*-----------------*/


function alsp_clean_dynamic_styles($value) {

  $clean_styles = preg_replace('!\s+!', ' ', $value);
  $clean_styles_w = str_replace("'", "\"", $clean_styles);

  return $clean_styles_w;

}

function alsp_clean_init_styles($value) {

  $backslash_styles = str_replace('\\', '\\\\', $value);
  $clean_styles = preg_replace('!\s+!', ' ', $backslash_styles);
  $clean_styles_w = str_replace("'", "\"", $clean_styles);

  return $clean_styles_w;

}

function create_global_styles() {
    $alsp_styles = '';
    global $alsp_styles;
}
create_global_styles();
//////////////////////////////////////////////////////////////////////////
// 
//  Global JSON object to collect all DOM related data
//  todo - move here all VC shortcode settings
//
//////////////////////////////////////////////////////////////////////////

function alsp_create_global_json() {
    $alsp_style_json = array();
    global $alsp_style_json;
}
alsp_create_global_json();


function alsp_create_global_dynamic_styles() {
    $alsp_dynamic_styles = array();
    global $alsp_dynamic_styles;
}
alsp_create_global_dynamic_styles();



/* footer scripts */
add_action('wp_footer', 'alsp_footer_elements', 1);
function alsp_footer_elements() { 
global $post, $alsp_style_json;
 $post_id = global_get_post_id();


	global $alsp_dynamic_styles;

	$alsp_dynamic_styles_ids = array();
	$alsp_dynamic_styles_inject = '';
	if(!empty($alsp_dynamic_styles)){
		$alsp_styles_length = count($alsp_dynamic_styles);
	}else{
		$alsp_styles_length = 0;
	}
	if ($alsp_styles_length > 0) {
		foreach ($alsp_dynamic_styles as $key => $val) { 
			$alsp_dynamic_styles_ids[] = $val["id"]; 
			$alsp_dynamic_styles_inject .= $val["inject"];
		};
	}

?>
<script>
	window.$ = jQuery

	var dynamic_styles = '<?php echo alsp_clean_init_styles($alsp_dynamic_styles_inject); ?>';
	var dynamic_styles_ids = (<?php echo json_encode($alsp_dynamic_styles_ids); ?> != null) ? <?php echo json_encode($alsp_dynamic_styles_ids); ?> : [];

	var styleTag = document.createElement('style'),
		head = document.getElementsByTagName('head')[0];

	styleTag.type = 'text/css';
	styleTag.setAttribute('data-ajax', '');
	styleTag.innerHTML = dynamic_styles;
	head.appendChild(styleTag);


	$('.alsp-dynamic-styles').each(function() {
		$(this).remove();
	});

	function ajaxStylesInjector() {
		$('.alsp-dynamic-styles').each(function() {
			var $this = $(this),
				id = $this.attr('id'),
				commentedStyles = $this.html();
				styles = commentedStyles
						 .replace('<!--', '')
						 .replace('-->', '');

			if(dynamic_styles_ids.indexOf(id) === -1) {
				$('style[data-ajax]').append(styles);
				$this.remove();
			}

			dynamic_styles_ids.push(id);
		});
	};
</script>



<?php } 


if( !function_exists('alsp_handle_image_upload') ){
function alsp_handle_image_upload( $file, $attach_to = 0 ){
	$movefile = wp_handle_upload( $file, array( 'test_form' => false ) );

	if( !empty( $movefile['url'] ) ){
		$attachment = array(
			'guid'           => $movefile['url'],
			'post_mime_type' => $movefile['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $movefile['file'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $attach_to );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}
}
}
function ipn_token() {
	return md5(site_url() . wp_salt());
}

add_action('dashboard_panel_html', 'alsp_dashboard_panel_html');
function alsp_dashboard_panel_html(){
global $ALSP_ADIMN_SETTINGS;
$current_user = wp_get_current_user();
$authorID = $current_user->ID;
require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
	$avatar_id = get_user_meta( $authorID, 'avatar_id', true );
	$author_avatar_url = wp_get_attachment_image_src( $avatar_id, 'full' ); 
	$image_src_array = $author_avatar_url[0];
 
	$author_name = get_the_author_meta('display_name', $authorID);
		$output = '';
		
		//$image_src_array = get_the_author_meta('pacz_author_avatar_url', $authorID, true); 
		
		$output .='<div class="author-thumbnail">';
		if(!empty($image_src_array)) {
			$params = array( 'width' => 110, 'height' => 110, 'crop' => true );
			$output .= '<img src="' . bfi_thumb($image_src_array, $params) . '" alt="'.$author_name.'" />';
		}else{ 
			$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '110' );
			$output .='<img src="'.$avatar_url.'" alt="author" />';
		}
		$output .='</div>';
		

		$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
		$myaccount_address_page_id = get_option( 'woocommerce_myaccount_edit_address_endpoint' );
		$myaccount_editaccount_page_id = get_option( 'woocommerce_myaccount_edit_account_endpoint' );
		$myaccount_downloads_page_id = get_option( 'woocommerce_myaccount_downloads_endpoint' );
		$myaccount_orders_page_id = get_option( 'woocommerce_myaccount_orders_endpoint' ); 
		$myaccount_payment_method_page_id =  get_option( 'woocommerce_myaccount_payment_methods_endpoint');
		
		if ( $myaccount_page_id ) {
			$myaccount_page_url = get_permalink($myaccount_page_id);
				
		}else{
			$myaccount_page_url = ''; 
		}
		if ( $myaccount_orders_page_id ) {
			$myaccount_orders_page_url = $myaccount_orders_page_id;
				
		}else{
			$myaccount_orders_page_url = ''; 
		}
		if ( $myaccount_address_page_id ) {
			$myaccount_address_page_url = $myaccount_address_page_id;
				
		}else{
			$myaccount_address_page_url = ''; 
		}
		
	
		//$public_control = new alsp_public_control();
		//$active_tab = $public_control->init();
 ?>
 <?php 
 global $alsp_dynamic_styles;
 $id = uniqid();
$panel_menu_regular = $ALSP_ADIMN_SETTINGS['panel_link_color']['regular'];
$panel_menu_hover = $ALSP_ADIMN_SETTINGS['panel_link_color']['hover'];
$panel_menu_bg = $ALSP_ADIMN_SETTINGS['panel_link_color']['bg'];
$panel_menu_bg_hover = $ALSP_ADIMN_SETTINGS['panel_link_color']['bg-hover'];
$panel_sub_menu_regular = $ALSP_ADIMN_SETTINGS['panel_sub_link_color']['regular'];
$panel_sub_menu_hover = $ALSP_ADIMN_SETTINGS['panel_sub_link_color']['hover'];
$panel_sub_menu_bg = $ALSP_ADIMN_SETTINGS['panel_sub_link_color']['bg'];
$panel_sub_menu_bg_hover = $ALSP_ADIMN_SETTINGS['panel_sub_link_color']['bg-hover'];
$panel_bg_color = $ALSP_ADIMN_SETTINGS['panel_bg_color'];
$panel_link_border = (isset($ALSP_ADIMN_SETTINGS['panel_link_border']['rgba']))? $ALSP_ADIMN_SETTINGS['panel_link_border']['rgba']: '';
$panel_logo_bg_color = $ALSP_ADIMN_SETTINGS['panel_logo_bg_color'];
$panel_header_bg_color = $ALSP_ADIMN_SETTINGS['panel_header_bg_color'];
$panel_header_link_color_regular = $ALSP_ADIMN_SETTINGS['panel_header_link_color']['regular'];
$panel_header_link_color_hover = $ALSP_ADIMN_SETTINGS['panel_header_link_color']['hover'];
 $alsp_styles = '';
 $alsp_styles .= '
	.user-panel-main .sidebar-menu li a{
		color:'.$panel_menu_regular.';
		background-color:'.$panel_menu_bg.';
	}
	.user-panel-main .sidebar-menu li{
		border-bottom:1px solid '.$panel_link_border.';
	}
	.user-panel-main .sidebar-menu li:last-child{
		border-bottom:none;
	}
	.user-panel-main .sidebar-menu li a:hover{
		color:'.$panel_menu_hover.';
		background-color:'.$panel_menu_bg_hover.';
	}
	.user-panel-main .sidebar-menu li .treeview-menu li a{
		color:'.$panel_sub_menu_regular.';
		background-color:'.$panel_sub_menu_bg.';
	}
	.user-panel-main .sidebar-menu li .treeview-menu li a:hover{
		color:'.$panel_sub_menu_hover.';
		background-color:'.$panel_sub_menu_bg_hover.';
	}
	.user-panel-main .sidebar-menu li a{
		color:'.$panel_menu_regular.';
		background-color:'.$panel_menu_bg.';
	}
	.user-panel-main .sidebar-menu li a:hover{
		color:'.$panel_menu_hover.';
		background-color:'.$panel_menu_bg_hover.';
	}
	.user-panel-main{
		background-color:'.$panel_bg_color.' !important;
	}
	.main-header .logo{
		background-color:'.$panel_logo_bg_color.' !important;
	}
	.main-header .navbar {
		background-color:'.$panel_header_bg_color.' !important;
	}
	.main-header .navbar .nav>li>a{
		color:'.$panel_header_link_color_regular.';
	}
	.main-header .navbar .nav>li>a:hover{
		color:'.$panel_header_link_color_hover.' !important;
	}
	.skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a, .skin-blue .sidebar-menu>li.menu-open>a{
		color:'.$panel_menu_hover.';
		background-color:'.$panel_menu_bg_hover.';
	}
	.skin-blue .sidebar-menu>li>.treeview-menu {
    background-color: none;
    border-left: none;
}
';

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
echo '</div>';

// Export styles to json for faster page load
$alsp_dynamic_styles[] = array(
 'id' => 'ajax-'.$id ,
 'inject' => $alsp_styles
);
if(is_rtl()){
	$angle = '<i class="fa fa-angle-left pull-left"></i>';
	$angleUp = '<i class="fa fa-angle-up pull-left"></i>';
}else{
	$angle = '<i class="fa fa-angle-right pull-right"></i>';
	$angleDown = '<i class="fa fa-angle-down pull-right"></i>';
}
 ?>
<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
     <?php if(isset($ALSP_ADIMN_SETTINGS['user_panel_logo']['url']) && !empty($ALSP_ADIMN_SETTINGS['user_panel_logo']['url'])){ ?>  <img src="<?php echo $ALSP_ADIMN_SETTINGS['user_panel_logo']['url'];  ?>" alt="User Panel" /> <?php }else{ ?> <span><?php echo esc_html__('User Panel', 'ALSP'); ?></span> <?php } ?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
	  <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		<?php if($ALSP_ADIMN_SETTINGS['message_system'] == 'instant_messages' || $ALSP_ADIMN_SETTINGS['alsp_listing_bidding']){ ?>
          <li><a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'messages')); ?>"><span class="pacz-fic-mail-3"></span><?php if (difp_get_new_message_number()){ echo sprintf(__('<small class="label pull-right bg-red"> %s  </small>', 'ALSP'), difp_get_new_message_button() ); } ?></a></li>
		<?php } ?>
	   </ul>
      </div>
      
    </nav>
  </header>
 <aside class="user-panel-main main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image" style="">
          <?php echo $output; ?>
        </div>
        <div class="author-name-info">
          <h6><?php echo $author_name; ?></h6>
         <span><?php echo $author_log_status; ?></span>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		<li><a href="<?php echo alsp_dashboardUrl(); ?>"><i class="fa fa-dashboard"></i><span><?php _e('Dashboard', 'ALSP'); ?></span></a></li>
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_allow_edit_profile']): ?>
			<li><a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'profile')); ?>"><i class="pacz-icon-user"></i><span><?php _e('Edit Profile', 'ALSP'); ?></span></a></li>
			
		<?php endif; ?>
		
		<?php 
			if(class_exists('WooCommerce') && $ALSP_ADIMN_SETTINGS['alsp_woocommerce_frontend_links']){
				$current_page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		?>
        <li class="treeview <?php if(is_account_page()){ echo 'active'; } ?>">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span><?php _e('Packages', 'ALSP'); ?></span>
            <span class="pull-right-container">
			<?php 
				if(is_account_page()){ 
					echo $angleDown;
				}else{
					echo $angle;
				}				
			?>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_page == $myaccount_page_url){ echo 'active'; } ?>"><a href="<?php echo $myaccount_page_url; ?>"><i class="fa fa-circle-o"></i><?php _e('My Account', 'ALSP'); ?></a></li>
			<li class="<?php if($current_page == $myaccount_page_url.$myaccount_orders_page_url){ echo 'active'; } ?>"><a href="<?php echo $myaccount_page_url.$myaccount_orders_page_url; ?>"><i class="fa fa-circle-o"></i><?php _e('My Orders', 'ALSP'); ?></a></li>
			<li class="<?php if($current_page == $myaccount_page_url.$myaccount_address_page_url){ echo 'active'; } ?>"><a href="<?php echo $myaccount_page_url.$myaccount_address_page_url; ?>"><i class="fa fa-circle-o"></i><?php _e('Edit Address', 'ALSP'); ?></a></li>
			<li class="<?php if($current_page == $myaccount_page_url.$myaccount_payment_method_page_id){ echo 'active'; } ?>"><a href="<?php echo $myaccount_page_url.$myaccount_payment_method_page_id; ?>"><i class="fa fa-circle-o"></i><?php _e('Payment Methods', 'ALSP'); ?></a></li>
			<li class="<?php if($current_page == $myaccount_page_url.$myaccount_downloads_page_id){ echo 'active'; } ?>"><a href="<?php echo $myaccount_page_url.$myaccount_downloads_page_id; ?>"><i class="fa fa-circle-o"></i><?php _e('Downloads', 'ALSP'); ?></a></li>
            
          </ul>
        </li>
		<?php } ?> 
		<?php if($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment'){ ?>
			<li><a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'invoices')); ?>"><i class="pacz-icon-user"></i><span><?php _e('Invoices', 'ALSP'); ?></span></a></li>
		<?php } ?>
		<?php
			global $alsp_instance;
		if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_button']){ ?>
			<li>
				<a class="" href="<?php echo alsp_submitUrl(); ?>" rel="nofollow"><i class="pacz-icon-plus-circle"></i><span><?php echo  __('Add New Tender', 'ALSP'); ?></span></a>
			</li>
		<?php } ?>
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list']){ ?>
		<li>
			<a class="" href="<?php echo alsp_directoryUrl(array('alsp_action' => 'myfavourites')); ?>" target="_blank"> <i class="pacz-fic4-big-heart"></i>  <span><?php echo  __('Bookmarks', 'ALSP'); ?></span></a>
		</li>
		<?php } ?>
		<li>
			<a class="" href="<?php echo wp_logout_url(home_url('/')); ?>" rel="nofollow"><i class="pacz-fic4-black-male-user-symbol"></i>  <span><?php echo __('Log out', 'ALSP'); ?></span></a>
		</li>
		<li>
			<a class="" href="<?php echo home_url('/'); ?>" rel="nofollow"><i class="pacz-li-web"></i>  <span><?php echo __('Homepage', 'ALSP'); ?></span></a>
		</li>
			<?php if(current_user_can('editor')){ ?>
			<li>
				<a class="" href="<?php echo admin_url('/'); ?>" rel="nofollow"><i class="pacz-li-web"></i>  <span><?php echo __('Visit WP Admin', 'ALSP'); ?></span></a>
			</li>
		<?php } ?>
		<?php if(current_user_can('administrator')){ ?>
			<li>
				<a class="" href="<?php echo admin_url('/'); ?>" rel="nofollow"><i class="pacz-li-web"></i>  <span><?php echo __('Visit WP Admin', 'ALSP'); ?></span></a>
			</li>
				<?php } ?>
		<li><?php do_action('wpml_add_language_selector'); ?></li>
	
	
      </ul>
	  
    </section>
    <!-- /.sidebar -->
  </aside>
  <?php
}
if(!empty($ALSP_ADIMN_SETTINGS['alsp_admin_email'])){
	update_option('admin_email', $ALSP_ADIMN_SETTINGS['alsp_admin_email']);
}
function alsp_isGdUserDashboardPluginActive() {
	if (in_array('gd-user-dashboard/gd-user-dashboard.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
		return true;
	}
}
function alsp_isGdListingStylesPluginActive() {
	if (in_array('gd-listing-styles/gd-listing-styles.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
		return true;
	}
}

?>