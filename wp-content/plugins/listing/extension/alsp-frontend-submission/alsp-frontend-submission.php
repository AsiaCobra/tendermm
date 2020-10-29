<?php

define('ALSP_FSUBMIT_PATH', plugin_dir_path(__FILE__));

function alsp_fsubmit_loadPaths() {
	define('ALSP_FSUBMIT_TEMPLATES_PATH', ALSP_FSUBMIT_PATH . 'public/');
	define('ALSP_FSUBMIT_RESOURCES_PATH', ALSP_FSUBMIT_PATH . 'assets/');
	define('ALSP_FSUBMIT_RESOURCES_URL', plugins_url('/', __FILE__) . 'assets/');
}
add_action('init', 'alsp_fsubmit_loadPaths', 0);

define('ALSP_FSUBMIT_SHORTCODE', 'alsp-submit');
define('ALSP_DASHBOARD_SHORTCODE', 'alsp-dashboard');

include_once ALSP_FSUBMIT_PATH . 'includes/alsp_class_panel.php';
include_once ALSP_FSUBMIT_PATH . 'includes/alsp_class_submit.php';
include_once ALSP_FSUBMIT_PATH . 'includes/alsp_class_packages_table.php';
include_once ALSP_FSUBMIT_PATH . 'includes/wc/wc.php';

global $alsp_wpml_dependent_options;
$alsp_wpml_dependent_options[] = 'alsp_tospage';
$alsp_wpml_dependent_options[] = 'alsp_submit_login_page';
$alsp_wpml_dependent_options[] = 'alsp_dashboard_login_page';

class alsp_fsubmit_plugin {

	public function init() {
		global $alsp_instance, $alsp_shortcodes_init, $ALSP_ADIMN_SETTINGS;
		if (!get_option('alsp_installed_fsubmit'))
			//alsp_install_fsubmit();
			add_action('init', 'alsp_install_fsubmit', 0);
		add_action('alsp_version_upgrade', 'alsp_upgrade_fsubmit');

		// add new shortcodes for frontend submission and dashboard
		$alsp_shortcodes['alsp-submit'] = 'alsp_submit_controller';
		$alsp_shortcodes['alsp-dashboard'] = 'alsp_dashboard_controller';
		$alsp_shortcodes['alsp-levels-table'] = 'alsp_levels_table_controller';
		
		$alsp_shortcodes_init['alsp-submit'] = 'alsp_submit_controller';
		$alsp_shortcodes_init['alsp-dashboard'] = 'alsp_dashboard_controller';
		$alsp_shortcodes_init['alsp-levels-table'] = 'alsp_levels_table_controller';
		
		add_shortcode('alsp-submit', array($alsp_instance, 'renderShortcode'));
		add_shortcode('alsp-dashboard', array($alsp_instance, 'renderShortcode'));
		add_shortcode('alsp-levels-table', array($alsp_instance, 'renderShortcode'));
		
		add_action('init', array($this, 'getSubmitPage'), 0);
		add_action('init', array($this, 'getDasboardPage'), 0);

		add_filter('alsp_get_edit_advert_link', array($this, 'edit_adverts_links'), 10, 2);

		add_action('alsp_directory_frontpanel', array($this, 'add_submit_button'));
		add_action('alsp_directory_frontpanel', array($this, 'add_claim_button'));
		add_action('alsp_directory_frontpanel_claimButton', array($this, 'add_claim_button'));
		add_action('alsp_directory_frontpanel', array($this, 'add_logout_button'));

		add_action('init', array($this, 'remove_admin_bar'));
		if($ALSP_ADIMN_SETTINGS['restrict_non_admin']){
			add_action('admin_init', array($this, 'restrict_dashboard'));
		}
		
		if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment') {
			add_action('show_user_profile', array($this, 'add_user_profile_fields'));
			add_action('edit_user_profile', array($this, 'add_user_profile_fields'));
			add_action('personal_options_update', array($this, 'save_user_profile_fields'));
			add_action('edit_user_profile_update', array($this, 'save_user_profile_fields'));
		}

		add_action('transition_post_status', array($this, 'on_listing_approval'), 10, 3);
		add_action('alsp_post_status_on_activation', array($this, 'post_status_on_activation'), 10, 2);
		
		add_filter('no_texturize_shortcodes', array($this, 'alsp_no_texturize'));

		add_action('alsp_render_template', array($this, 'check_custom_template'), 10, 2);
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
	}
	
	public function alsp_no_texturize($shortcodes) {
		$shortcodes[] = 'alsp-submit';
		$shortcodes[] = 'alsp-dashboard';

		return $shortcodes;
	}
	
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/alsp-plugin/public/alsp-frontend-submission
	 * - plugins/alsp/public/alsp-frontend-submission
	 * 
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
			
			if ($template_path == ALSP_FSUBMIT_TEMPLATES_PATH && ($fsubmit_template = alsp_isTemplate('alsp-frontend-submission/' . $template_file))) {
				return $fsubmit_template;
			}
		}
		return $template;
	}

	public function getSubmitPage() {
		global $alsp_instance, $wpdb, $ALSP_ADIMN_SETTINGS;
		
		$alsp_instance->submit_pages_all = array();

		if ($pages = $wpdb->get_results("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_FSUBMIT_SHORTCODE . "]%' OR post_content LIKE '%[" . ALSP_FSUBMIT_SHORTCODE . " %') AND post_status = 'publish' AND post_type = 'page'", ARRAY_A)) {

			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				foreach ($pages AS $key=>&$cpage) {
					if ($tpage = apply_filters('wpml_object_id', $cpage['id'], 'page')) {
						$cpage['id'] = $tpage;
						$cpage['slug'] = get_post($cpage['id'])->post_name;
					} else {
						unset($pages[$key]);
					}
				}
			}
			
			$pages = array_unique($pages, SORT_REGULAR);
			
			$submit_pages = array();
			
			$shortcodes = array(ALSP_FSUBMIT_SHORTCODE);
			foreach ($pages AS $page_id) {
				$page_id = $page_id['id'];
				$pattern = get_shortcode_regex($shortcodes);
				if (preg_match_all('/'.$pattern.'/s', get_post($page_id)->post_content, $matches) && array_key_exists(2, $matches)) {
					foreach ($matches[2] AS $key=>$shortcode) {
						if (in_array($shortcode, $shortcodes)) {
							if (($attrs = shortcode_parse_atts($matches[3][$key]))) {
								if (isset($attrs['directory']) && is_numeric($attrs['directory']) && ($directory = $alsp_instance->directories->getDirectoryById($attrs['directory']))) {
									$submit_pages[$directory->id]['id'] = $page_id;
									break;
								} elseif (!isset($attrs['id'])) {
									$submit_pages[$alsp_instance->directories->getDefaultDirectory()->id]['id'] = $page_id;
									break;
								}
							} else {
								$submit_pages[$alsp_instance->directories->getDefaultDirectory()->id]['id'] = $page_id;
								break;
							}
						}
					}
				}
			}

			foreach ($submit_pages AS &$page) {
				$page_id = $page['id'];
				$page['url'] = get_permalink($page_id);
				$page['slug'] = get_post($page_id)->post_name;
			}
			
			$alsp_instance->submit_pages_all = $submit_pages;
		}

		if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_button'] && empty($alsp_instance->submit_pages_all) && is_admin())
			alsp_addMessage(sprintf(__("You enabled <b>Ads Listing System Frontend submission addon</b>: sorry, but there isn't any page with [alsp-submit] shortcode. Create new page with [alsp-submit] shortcode or disable Frontend submission addon in settings.", 'ALSP')));
	}

	public function getDasboardPage() {
		global $alsp_instance, $wpdb, $wp_rewrite;
		
		$alsp_instance->dashboard_page_url = '';
		$alsp_instance->dashboard_page_slug = '';
		$alsp_instance->dashboard_page_id = 0;

		if ($dashboard_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE post_content LIKE '%[" . ALSP_DASHBOARD_SHORTCODE . "]%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)) {
			$alsp_instance->dashboard_page_id = $dashboard_page['id'];
			$alsp_instance->dashboard_page_slug = $dashboard_page['slug'];
			
			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tpage = apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page')) {
					$alsp_instance->dashboard_page_id = $tpage;
					$alsp_instance->dashboard_page_slug = get_post($alsp_instance->dashboard_page_id)->post_name;
				}
			}
			
			if ($wp_rewrite->using_permalinks())
				$alsp_instance->dashboard_page_url = get_permalink($alsp_instance->dashboard_page_id);
			else
				$alsp_instance->dashboard_page_url = add_query_arg('page_id', $alsp_instance->dashboard_page_id, home_url('/'));
		}
	}
	
	public function add_submit_button($buttons_view) {
		
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if ($buttons_view->isButton('submit') && $ALSP_ADIMN_SETTINGS['alsp_fsubmit_button'] && !empty($alsp_instance->submit_pages_all)) {
			$page_id = get_the_ID();
			
			$submit_pages = array();
			foreach ($alsp_instance->submit_pages_all AS $page) {
				$submit_pages[] = $page['id'];
			}

			$directories = $buttons_view->getDirectories();

			foreach ($directories AS $directory) {
				$href = alsp_submitUrl(array('directory' => $directory->id));
					
				$href = apply_filters('alsp_submit_button_href', $href, $directory, $buttons_view);
					
				echo '<a class="alsp-submit-listing-link btn btn-primary" href="' . $href . '" rel="nofollow" ' . $buttons_view->tooltipMeta(sprintf(__('Submit new %s', 'ALSP'), $directory->single), true) . '><span class="glyphicon glyphicon-plus"></span> ' . ((!$buttons_view->hide_button_text) ? sprintf(__('Submit new %s', 'ALSP'), $directory->single) : "") . '</a> ';
			}
		}
	}

	public function add_claim_button($buttons_view) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		if ($buttons_view->isButton('claim')) {
			if ($listing = alsp_getListing($buttons_view->getListingId())) {
				
				if ($listing && $listing->is_claimable && $alsp_instance->dashboard_page_url && $ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && $listing->post->post_author != get_current_user_id()){
						$href = alsp_dashboardUrl(array('listing_id' => $listing->post->ID, 'alsp_action' => 'claim_listing'));
					
						$href = apply_filters('alsp_claim_button_href', $href, $buttons_view);
						if ($alsp_instance->getShortcodeProperty('alsp-listing', 'is_single') && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2){
							echo '<li><a class="alsp-claim-listing-link" href="' . $href . '" rel="nofollow" data-toggle="tooltip" title="'.esc_html__('Is this your ad?', 'ALSP').'"><span class="glyphicon glyphicon-flag"></span></a><li>';
						}elseif ($alsp_instance->getShortcodeProperty('alsp-listing', 'is_single') && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 4){
							echo '<a class="alsp-claim-listing-link" href="' . $href . '" rel="nofollow"><span class="glyphicon glyphicon-flag"></span>'.esc_html__('Claim Listing', 'ALSP').'</a>';
						}else{
							echo '<div class="cz-btn-wrap"><a class="alsp-claim-listing-link" href="' .$href . '" rel="nofollow" data-toggle="tooltip" title="'.esc_html__('Is this your ad?', 'ALSP').'"><span class="glyphicon glyphicon-flag"></span></a></div>';
						}
				}
				
			}
		}
	}

	public function add_logout_button($buttons_view) {
		if ($buttons_view->isButton('logout')) {
			echo '<a class="alsp-logout-link btn btn-primary" href="' . wp_logout_url(alsp_directoryUrl()) . '" rel="nofollow" ' . $buttons_view->tooltipMeta(__('Log out', 'ALSP'), true) . '><span class="glyphicon glyphicon-log-out"></span> ' . ((!$buttons_view->hide_button_text) ? __('Log out', 'ALSP') : "") . '</a>';
		}
	}
	
	
	public function remove_admin_bar() {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_hide_admin_bar']) {
			if (current_user_can('manage_options') || current_user_can('editor')) {
				show_admin_bar(true);
				add_filter('show_admin_bar', '__return_true', 99999);
			}else{
				show_admin_bar(false);
				add_filter('show_admin_bar', '__return_false', 99999);
			}
		}
		
	}

	public function restrict_dashboard() {
		global $alsp_instance, $pagenow;

		if ($pagenow != 'admin-ajax.php' && $pagenow != 'async-upload.php')
			if ((!current_user_can('administrator') && !current_user_can('editor')) && is_admin()) {
				alsp_addMessage(__('You can not see dashboard!', 'ALSP'), 'error');
				wp_redirect(alsp_dashboardUrl());
				die();
			}
	}

	public function edit_adverts_links($url, $post_id) {
		global $alsp_instance;

		if (!is_admin() && $alsp_instance->dashboard_page_url && ($post = get_post($post_id)) && $post->post_type == ALSP_POST_TYPE)
			return alsp_dashboardUrl(array('alsp_action' => 'edit_advert', 'listing_id' => $post_id));
	
		return $url;
	}
	
	/* public function listing_activation_post_status($listing, $is_renew) {
		if (!$is_renew) {
			if ($listing->post->post_status != 'publish') {
				if (get_option('alsp_fsubmit_default_status') == 1) {
					$post_status = 'pending';
					$message = __('Listing awaiting moderators approval.', 'ALSP');
				} elseif (get_option('alsp_fsubmit_default_status') == 2) {
					$post_status = 'draft';
					$message = __('Listing was saved successfully as draft! Contact site manager, please.', 'ALSP');
				} elseif (get_option('alsp_fsubmit_default_status') == 3) {
					$post_status = 'publish';
					$message = false;
				}
				wp_update_post(array('ID' => $listing->post->ID, 'post_status' => $post_status));
				if ($message)
					alsp_addMessage($message);
			}
		}
	} */
	
	public function add_user_profile_fields($user) { ?>
		<h3><?php _e('Directory billing information', 'ALSP'); ?></h3>
	
		<table class="form-table">
			<tr>
				<th><label for="alsp_billing_name"><?php _e('Full name', 'ALSP'); ?></label></th>
				<td>
					<input type="text" name="alsp_billing_name" id="alsp_billing_name" value="<?php echo esc_attr(get_the_author_meta('alsp_billing_name', $user->ID)); ?>" class="regular-text" /><br />
				</td>
			</tr>
			<tr>
				<th><label for="alsp_billing_address"><?php _e('Full address', 'ALSP'); ?></label></th>
				<td>
					<textarea name="alsp_billing_address" id="alsp_billing_address" cols="30" rows="3"><?php echo esc_textarea(get_the_author_meta('alsp_billing_address', $user->ID)); ?></textarea>
				</td>
			</tr>
		</table>
<?php }

	public function save_user_profile_fields($user_id) {
		if (!current_user_can('edit_user', $user_id))
			return false;

		update_user_meta($user_id, 'alsp_billing_name', $_POST['alsp_billing_name']);
		update_user_meta($user_id, 'alsp_billing_address', $_POST['alsp_billing_address']);
	}

	public function on_listing_approval($new_status, $old_status, $post) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if ($ALSP_ADIMN_SETTINGS['alsp_approval_notification']) {
			if (
				$post->post_type == ALSP_POST_TYPE &&
				'publish' == $new_status &&
				'pending' == $old_status &&
				($listing = $alsp_instance->listings_manager->loadListing($post)) &&
				($author = get_userdata($listing->post->post_author))
			) {
				$headers[] = "From: " . get_option('blogname') . " <" . alsp_getAdminNotificationEmail() . ">";
				$headers[] = "Reply-To: " . alsp_getAdminNotificationEmail();
				$headers[] = "Content-Type: text/html";
					
				$subject = "[" . get_option('blogname') . "] " . __('Approval of listing', 'ALSP');
					
				$body = str_replace('[author]', $author->display_name,
						str_replace('[listing]', $listing->post->post_title,
						str_replace('[link]', alsp_dashboardUrl(),
				$ALSP_ADIMN_SETTINGS['alsp_approval_notification'])));
					
				wp_mail($author->user_email, $subject, $body, $headers);
			}
		}
	}
	public function post_status_on_activation($status, $listing) {
		$is_moderation = get_post_meta($listing->post->ID, '_requires_moderation', true);
		$is_approved = get_post_meta($listing->post->ID, '_listing_approved', true);
		if (!$is_moderation || ($is_moderation && $is_approved)) {
			return 'publish';
		} elseif ($is_moderation && !$is_approved) {
			return 'pending';
		}
		return $status;
	}
	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $post, $alsp_instance, $alsp_fsubmit_enqueued;
		if(empty(global_get_post_id())){
			$post_id = $post->ID;
		}else{
			$post_id = global_get_post_id();
		}
		
		if (($alsp_instance->public_controls || $load_scripts_styles) && !$alsp_fsubmit_enqueued) {
			if(!is_author() && !is_404() && !is_search()){
				if (has_shortcode($post->post_content, 'alsp-dashboard') || (alsp_isWooActive() && is_account_page())){
					wp_register_style('alsp_user_panel', ALSP_FSUBMIT_RESOURCES_URL . 'css/user_panel.css');
					wp_register_script('alsp_js_userpanel', ALSP_RESOURCES_URL . 'js/min/alsp_userpanel.min.js', array('jquery'), false, true);
					wp_enqueue_style('alsp_user_panel');
					wp_enqueue_script('alsp_js_userpanel');
				}
			}
			wp_register_style('alsp_fsubmit', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting.css');
			wp_enqueue_style('alsp_fsubmit');
			
			
			if ($fsubmit_custom = alsp_isResource('css/submitlisting-custom.css')) {
				wp_register_style('alsp_fsubmit-custom', $fsubmit_custom, array(), ALSP_VERSION);
				//wp_register_style('alsp_fsubmit-custom', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting-custom.css');
				wp_enqueue_style('alsp_fsubmit-custom');
			}
			
			if (function_exists('is_rtl') && is_rtl())
				wp_register_style('alsp_fsubmit_rtl', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting-rtl.css');
				wp_enqueue_style('alsp_fsubmit_rtl');

			$alsp_fsubmit_enqueued = true;
		}
	} 
	
	public function enqueue_login_scripts_styles() {
		global $action;
		$action = 'login';
		do_action('login_enqueue_scripts');
		do_action('login_head');
	}
}

function alsp_install_fsubmit() {
	add_option('alsp_fsubmit_default_status', 3);
	add_option('alsp_fsubmit_login_mode', 1);

	alsp_upgrade_fsubmit('1.5.0');
	alsp_upgrade_fsubmit('1.5.4');
	alsp_upgrade_fsubmit('1.6.2');
	alsp_upgrade_fsubmit('1.8.3');
	alsp_upgrade_fsubmit('1.8.4');
	alsp_upgrade_fsubmit('1.9.0');
	alsp_upgrade_fsubmit('1.9.7');
	alsp_upgrade_fsubmit('1.10.0');
	alsp_upgrade_fsubmit('1.12.7');
	alsp_upgrade_fsubmit('1.13.0');
	
	add_option('alsp_installed_fsubmit', 1);
}

function alsp_upgrade_fsubmit($new_version) {
	if ($new_version == '1.5.0') {
		add_option('alsp_fsubmit_edit_status', 3);
		add_option('alsp_fsubmit_button', 1);
		add_option('alsp_hide_admin_bar', 0);
		add_option('alsp_newuser_notification', 'Hello [author],

your listing "[listing]" was successfully submitted.

You may manage your listing using following credentials:
login: [login]
password: [password]');
	}
	
	if ($new_version == '1.5.4')
		add_option('alsp_allow_edit_profile', 1);

	if ($new_version == '1.6.2')
		add_option('alsp_enable_frontend_translations', 1);

	if ($new_version == '1.8.3') {
		add_option('alsp_claim_functionality', 0);
		add_option('alsp_claim_approval', 1);
		add_option('alsp_after_claim', 'active');
		add_option('alsp_hide_claim_contact_form', 0);
		add_option('alsp_claim_notification', 'Hello [author],

your listing "[listing]" was claimed by [claimer].

You may approve or reject this claim at
[link]

[message]');
		add_option('alsp_claim_approval_notification', 'Hello [claimer],

congratulations, your claim for listing "[listing]" was successfully approved.

Now you may manage your listing at the dashboard
[link]');
		add_option('alsp_newlisting_admin_notification', 'Hello,

user [user] created new listing "[listing]".

You may manage this listing at
[link]');
	}
	
	if ($new_version == '1.8.4') {
		add_option('alsp_enable_tags', 1);
	}

	if ($new_version == '1.9.0') {
		add_option('alsp_tospage', '');
	}

	if ($new_version == '1.9.7') {
		add_option('alsp_hide_claim_metabox', 0);
	}

	if ($new_version == '1.10.0') {
		add_option('alsp_submit_login_page', '');
		add_option('alsp_dashboard_login_page', '');
	}

	if ($new_version == '1.12.7') {
		add_option('alsp_approval_notification', 'Hello [author],

your listing "[listing]" was successfully approved.
				
Now you may manage your listing at the dashboard
[link]');
		add_option('alsp_claim_decline_notification', 'Hello [claimer],

your claim for listing "[listing]" was declined.');
	}
	
	if ($new_version == '1.13.0') {
		add_option('alsp_woocommerce_functionality', 0);
		add_option('alsp_woocommerce_mode', 'both');
	}
}

function alsp_submitUrl($path = '') {
	global $alsp_instance;
	
	$submit_page_url = '';

	if (!empty($path['directory'])) {
		if (($directory = $alsp_instance->directories->getDirectoryById($path['directory'])) && isset($alsp_instance->submit_pages_all[$directory->id])) {
			$submit_page_url = $alsp_instance->submit_pages_all[$directory->id]['url'];
			unset($path['directory']);
		}
	} else {
		if (isset($alsp_instance->submit_pages_all[$alsp_instance->current_directory->id])) {
			$submit_page_url = $alsp_instance->submit_pages_all[$alsp_instance->current_directory->id]['url'];
		}
	}
	if (!$submit_page_url) {
		if (isset($alsp_instance->submit_pages_all[$alsp_instance->directories->getDefaultDirectory()->id])) {
			$submit_page_url = $alsp_instance->submit_pages_all[$alsp_instance->directories->getDefaultDirectory()->id]['url'];
		}
	}
		
	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$submit_page_url = remove_query_arg('lang', $submit_page_url);
		}
	}

	if (!is_array($path)) {
		if ($path) {
			// found that on some instances of WP "native" trailing slashes may be missing
			$url = rtrim($submit_page_url, '/') . '/' . rtrim($path, '/') . '/';
		} else
			$url = $submit_page_url;
	} else
		$url = add_query_arg($path, $submit_page_url);

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$url = $sitepress->convert_url($url);
	}

	return $url;
}

function alsp_dashboardUrl($path = '') {
	global $alsp_instance;
	
	if ($alsp_instance->dashboard_page_url) {
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_option('language_negotiation_type') == 3) {
				// remove any previous value.
				$alsp_instance->dashboard_page_url = remove_query_arg('lang', $alsp_instance->dashboard_page_url);
			}
		}
	
		if (!is_array($path)) {
			if ($path) {
				// found that on some instances of WP "native" trailing slashes may be missing
				$url = rtrim($alsp_instance->dashboard_page_url, '/') . '/' . rtrim($path, '/') . '/';
			} else
				$url = $alsp_instance->dashboard_page_url;
		} else
			$url = add_query_arg($path, $alsp_instance->dashboard_page_url);
	
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$url = $sitepress->convert_url($url);
		}
	} else
		$url = alsp_directoryUrl();

	return $url;
}

global $alsp_fsubmit_instance;

$alsp_fsubmit_instance = new alsp_fsubmit_plugin();
$alsp_fsubmit_instance->init();

?>
