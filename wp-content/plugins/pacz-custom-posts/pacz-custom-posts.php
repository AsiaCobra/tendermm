<?php
/*
Plugin Name: Pacz  Custom Posts 
Description: This plugin includes all custom post types by designinvento
Version:     2.11
Author:      DesignInvento
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// Plugin Path
define('PCPT_URL', plugins_url('/', __FILE__));
define('PCPT_PATH', plugin_dir_path(__FILE__));
define( 'PCPT_INCLUDES', PCPT_URL. 'includes/');

add_action('plugins_loaded', 'custom_vc_init');

function custom_vc_init() {
	require dirname( __FILE__ ) . '/contentfields.php';
  if ( class_exists('WPBakeryShortCode')) {
    require dirname( __FILE__ ) . '/vc-integration.php';
  }
  
	add_action('widgets_init', 'pacz_widgets');
  
  require_once dirname( __FILE__ ) . '/dynamic-helper.php';
  require_once dirname( __FILE__ ) . '/dynamic.php';
  
   if (is_admin()) {
	}
  if (class_exists('Classiadspro_Theme') && is_admin()) {
	$theme_data = wp_get_theme("classiadspro");
			wp_enqueue_script('bootstrap', PACZ_THEME_JS . '/bootstrap.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
			global $pagenow;
					wp_enqueue_script('select2', PACZ_THEME_JS . '/select2.min.js', array(
							'jquery'
					) , $theme_data['Version'], true);

						
	}
  
  add_action( 'show_user_profile', 'pacz_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'pacz_extra_user_profile_fields' );

function pacz_extra_user_profile_fields( $user ) { ?>
<h3><?php esc_html_e("Extra profile information", "pacz"); ?></h3>

<table class="form-table">
<th><label for="address"><?php esc_html_e("Address", "pacz"); ?></label></th>
<td>
<input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php esc_html_e("Please enter your address.", "pacz"); ?></span>
</td>
</tr>
<tr>
<th><label for="user_phone"><?php esc_html_e("Phone", "pacz"); ?></label></th>
<td>
<input type="text" name="user_phone" id="user_phone" value="<?php echo esc_attr( get_the_author_meta( 'user_phone', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php esc_html_e("Phone Number", "pacz"); ?></span>
</td>
</tr>
</table>
<?php }

function pacz_widgets(){
	if(defined('PACZ_THEME_SETTINGS')){
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-popular-posts.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-recent-posts.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-video.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-comments.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-custom-menu.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-image.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-about.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-flickr-feeds.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-author.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-social-networks.php';
	require_once PCPT_PATH . 'includes/custom-post/widgets/widgets-subscription.php';

	register_widget("Classiadspro_Widget_Popular_Posts");
	register_widget("Classiadspro_Widget_Recent_Posts");
	register_widget("Classiadspro_Widget_Video");
	register_widget("Classiadspro_Widget_Flickr_Feeds");
	register_widget("Classiadspro_WP_Widget_Recent_Comments");
	register_widget("Classiadspro_WP_Nav_Menu_Widget");
	register_widget("Classiadspro_Widget_Image");
	register_widget("Classiadspro_Widget_About");
	register_widget("Classiadspro_Widget_Author");
	register_widget("Classiadspro_Widget_Social");
	register_widget("Classiadspro_Widget_Subscription_Form");
	}
}

add_action( 'personal_options_update', 'pacz_save_pacz_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'pacz_save_pacz_extra_user_profile_fields' );

function pacz_save_pacz_extra_user_profile_fields( $user_id ) {

if ( current_user_can( 'edit_user', $user_id ) ) { return false; }

update_user_meta( $user_id, 'address', $_POST['address'] );
update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
update_user_meta( $user_id, 'pphoto', $_POST['pphoto'] );

}

function pacz_get_attachment_id_from_src($image_src) {

    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;

}


function pacz_add_media_upload_scripts() {
    if ( is_admin() ) {
         return;
	   }
	//nhs
    // wp_enqueue_media();
}
add_action('wp_enqueue_scripts', 'pacz_add_media_upload_scripts');

function pacz_get_avatar_url($author_id, $size){
    $get_avatar = get_avatar( $author_id, $size );
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return ( $matches[1] );
}


if ( (current_user_can('subscriber') || current_user_can('customer')) && !current_user_can('upload_files') ) {
    add_action('admin_init', 'pacz_allow_contributor_uploads');
}
function pacz_allow_contributor_uploads() {
    $contributor1 = get_role('subscriber');
    $contributor1->add_cap('upload_files');
	$contributor2 = get_role('customer');
    $contributor2->add_cap('upload_files');
}



function pacz_custom_post_author_archive( &$query )
{
    if ( $query->is_author )
        $query->set( 'post_type', 'alsp_listing' );
    remove_action( 'pre_get_posts', 'pacz_custom_post_author_archive' ); // run once!
}
add_action( 'pre_get_posts', 'pacz_custom_post_author_archive' );


/**
 * WordPress function for redirecting users on login based on user role
 */
/*function classiadspro_login_redirect( $url, $request, $user ){
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' )) {
        if( $user->has_cap( 'administrator' ) ) {
            $url = esc_url(admin_url('/'));
        } else {
            $url = esc_url(home_url('/my-dashboard/'));
        }
    }
    return $url;
}
add_filter('login_redirect', 'classiadspro_login_redirect',10,3);
*/
/*********************************************************
 * Limit the number of tags displayed by Tag Cloud widget *
 *********************************************************/
add_filter( 'widget_tag_cloud_args', 'pacz_tag_cloud_limit' );
function pacz_tag_cloud_limit($args){ 
	// Check if taxonomy option of the widget is set to tags
	if ( isset($args['taxonomy']) && $args['taxonomy'] == 'alsp-tag' ){
		$args['number'] = 8; // Number of tags to show
 	}
	return $args;
}
  
}

function classiadspro_load_plugin_textdomain() {
    load_plugin_textdomain( 'pacz', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'after_setup_theme', 'classiadspro_load_plugin_textdomain' );

/**
 * Register a custom menu page.
 */
/*function pacz_admin_menus(){
    add_menu_page( 
        esc_html__( 'Import Demo', 'pacz' ),
        'Import Demo',
        'manage_options',
        'demo-importer',
        'demo_importer_page',
        6
    ); 
}
add_action( 'admin_menu', 'pacz_admin_menus' );
 */
/**
 * Display a custom menu page
 */
 /*
function demo_importer_page(){
    require_once (plugin_dir_path( __FILE__ ) .'/includes/demo-importer/engine/index.php'); 
}
*/



/*-----------------------------------------------------------------------------------*/
/* Register Custom Post Types - Clients */
/*-----------------------------------------------------------------------------------*/
function register_clients_post_type(){
	register_post_type('clients', array(
		'labels' => array(
			'name' => __('Clients','pacz'),
			'singular_name' => __('Client','pacz'),
			'add_new' => __('Add New Client','pacz'),
			'add_new_item' => __('Add New Client', 'pacz' ),
			'edit_item' => __('Edit Client','pacz'),
			'new_item' => __('New Client','pacz'),
			'view_item' => __('View Client','pacz'),
			'search_items' => __('Search Clients','pacz'),
			'not_found' =>  __('No Clients found','pacz'),
			'not_found_in_trash' => __('No Clients found in Trash','pacz'),
			'parent_item_colon' => '',
			
		),
		'singular_label' => 'clients',
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'menu_icon'=> 'dashicons-businessman',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => false,
		'menu_position' => 100,
		'query_var' => false,
		'show_in_nav_menus' => false,
		'supports' => array('title', 'thumbnail', 'page-attributes', 'revisions')
	));
}
add_action('init','register_clients_post_type');

function clients_context_fixer() {
	if ( get_query_var( 'post_type' ) == 'clients' ) {
		global $wp_query;
		$wp_query->is_home = false;
		$wp_query->is_404 = true;
		$wp_query->is_single = false;
		$wp_query->is_singular = false;
	}
}
add_action( 'template_redirect', 'clients_context_fixer' );


/*-----------------------------------------------------------------------------------*/
/* Manage Client's columns */
/*-----------------------------------------------------------------------------------*/

function edit_clients_columns($clients_columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		'title' => __('Client Name', 'pacz'),
		"thumbnail" => __('Thumbnail', 'pacz' ),
	);

	return $columns;
}
add_filter('manage_edit-clients_columns', 'edit_clients_columns');

function manage_clients_columns($column) {
	global $post;
	
	if ($post->post_type == "clients") {
		switch($column){
			
			case 'thumbnail':
				echo the_post_thumbnail('thumbnail');
				break;
		}
	}
}
add_action('manage_posts_custom_column', 'manage_clients_columns', 10, 2);




/*-----------------------------------------------------------------------------------*/
/* Manage Employee's columns */
/*-----------------------------------------------------------------------------------*/

function edit_employees_columns($employee_columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		'title' => __('Employee Name', 'pacz'),
		"position" => __('Position', 'pacz' ),
		//"desc" => __('Description', 'pacz' ),
		"thumbnail" => __('Thumbnail', 'pacz' ),
	);

	return $columns;
}
add_filter('manage_edit-employees_columns', 'edit_employees_columns');

function manage_employees_columns($column) {
	global $post;
	
	if ($post->post_type == "employees") {
		switch($column){
			case "position":
				echo get_post_meta($post->ID, '_position', true);
				break;
			//case "desc":
				//echo get_post_meta($post->ID, '_desc', true);
				//break;
			
			case 'thumbnail':
				echo the_post_thumbnail('thumbnail');
				break;
		}
	}
}
add_action('manage_posts_custom_column', 'manage_employees_columns', 10, 2);



/*-----------------------------------------------------------------------------------*/
/* Register Custom Post Types - Eployees */
/*-----------------------------------------------------------------------------------*/
function register_employees_post_type(){
	register_post_type('employees', array(
		'labels' => array(
			'name' => __('Employees','pacz'),
			'singular_name' => __('Team Member','pacz'),
			'add_new' => __('Add New Member','pacz'),
			'add_new_item' => __('Add New Team Member', 'pacz' ),
			'edit_item' => __('Edit Team Member','pacz'),
			'new_item' => __('New Team Member','pacz'),
			'view_item' => __('View Team Member','pacz'),
			'search_items' => __('Search Team Members','pacz'),
			'not_found' =>  __('No Team Member found','pacz'),
			'not_found_in_trash' => __('No Team Members found in Trash','pacz'),
			'parent_item_colon' => '',
			
		),
		'singular_label' => 'employees',
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'menu_icon'=> 'dashicons-groups',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => false,
		'menu_position' => 100,
		'query_var' => false,
		'show_in_nav_menus' => false,
		'supports' => array('title', 'thumbnail', 'page-attributes', 'revisions')
	));
}
add_action('init','register_employees_post_type');

function employees_context_fixer() {
	if ( get_query_var( 'post_type' ) == 'employees' ) {
		global $wp_query;
		$wp_query->is_home = false;
		$wp_query->is_404 = true;
		$wp_query->is_single = false;
		$wp_query->is_singular = false;
	}
}
add_action( 'template_redirect', 'employees_context_fixer' );



/*-----------------------------------------------------------------------------------*/
/* Manage Testimonial's columns */
/*-----------------------------------------------------------------------------------*/

function edit_testimonial_columns( $testimonial_columns ) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		'title' => __( 'Testimonial Name', 'pacz_framework' ),
		"quote_author" => __( 'Author', 'pacz_framework' ),
		"desc" => __( 'Description', 'pacz_framework' ),
		"thumbnail" => __( 'Thumbnail', 'pacz_framework' ),
	);

	return $columns;
}
add_filter( 'manage_edit-testimonial_columns', 'edit_testimonial_columns' );

function manage_testimonials_columns( $column ) {
	global $post;

	if ( $post->post_type == "testimonial" ) {
		switch ( $column ) {
		case "quote_author":
			echo get_post_meta( $post->ID, '_author', true );
			break;
		case "desc":
			echo get_post_meta( $post->ID, '_desc', true );
			break;

		case 'thumbnail':
			echo the_post_thumbnail( 'thumbnail' );
			break;
		}
	}
}
add_action( 'manage_posts_custom_column', 'manage_testimonials_columns', 10, 2 );



/*-----------------------------------------------------------------------------------*/
/* Register Custom Post Types - Gallerys */
/*-----------------------------------------------------------------------------------*/
function register_testimonials_post_type() {
	register_post_type( 'testimonial', array(
			'labels' => array(
				'name' => __( 'Testimonials', 'pacz_framework' ),
				'singular_name' => __( 'Testimonial', 'pacz_framework' ),
				'add_new' => __( 'Add New Testimonial', 'pacz_framework' ),
				'add_new_item' => __( 'Add New Testimonial', 'pacz_framework'),
				'edit_item' => __( 'Edit Testimonial', 'pacz_framework' ),
				'new_item' => __( 'New Testimonial', 'pacz_framework' ),
				'view_item' => __( 'View Testimonials', 'pacz_framework' ),
				'search_items' => __( 'Search Testimonials', 'pacz_framework' ),
				'not_found' =>  __( 'No Testimonials found', 'pacz_framework' ),
				'not_found_in_trash' => __( 'No Testimonials found in Trash', 'pacz_framework' ),
				'parent_item_colon' => '',

			),
			'singular_label' => 'Testimonials',
			'public' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'menu_icon'=> 'dashicons-awards',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'menu_position' => 100,
			'query_var' => false,
			'show_in_nav_menus' => false,
			'supports' => array('title', 'thumbnail', 'page-attributes', 'revisions')
		) );
}
add_action( 'init', 'register_testimonials_post_type' );

function testimonials_context_fixer() {
	if ( get_query_var( 'post_type' ) == 'testimonial' ) {
		global $wp_query;
		$wp_query->is_home = false;
		$wp_query->is_404 = true;
		$wp_query->is_single = false;
		$wp_query->is_singular = false;
	}
}
add_action( 'template_redirect', 'testimonials_context_fixer' );

/*
 * Contact Form ajax function
 */

add_action('wp_ajax_nopriv_pacz_contact_form', 'pacz_contact_form');
add_action('wp_ajax_pacz_contact_form', 'pacz_contact_form');

if (!function_exists('pacz_contact_form')) {
      function pacz_contact_form()
      {
            $sitename = get_bloginfo('name');
            $siteurl  = esc_url(home_url('/'));
            
            $to      = isset($_POST['to']) ? trim($_POST['to']) : '';
            $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
            $phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';
            
            
            $error = false;
            if ($to === '' || $email === '' || $content === '' || $name === '') {
                  $error = true;
            }
            if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)) {
                  $error = true;
            }
            if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to)) {
                  $error = true;
            }
            
            if ($error == false) {
                  $subject = sprintf(esc_html__('%1$s\'s message from %2$s', 'pacz'), $sitename, $name);
                  $body    = esc_html__('Site: ', 'pacz') . $sitename . ' (' . $siteurl . ')' . "\n\n";
                  $body .= esc_html__('Name: ', 'pacz') . $name . "\n\n";
                  $body .= esc_html__('Email: ', 'pacz') . $email . "\n\n";
                  if (!empty($phone)) {
                    $body .= esc_html__('Phone: ', 'pacz') . $phone . "\n\n";
                  }
                  $body .= esc_html__('Messages: ', 'pacz') . $content;
                  $headers = "From: $name <$email>\r\n";
                  $headers .= "Reply-To: $email\r\n";
                  
                  if (wp_mail($to, $subject, $body, $headers)) {
                        echo 'Message sent successfully';
                  } else {
                        echo 'Message Could not be sent';
                  }
                  die();
            }
      }
}


/*
 * Adds Schema.org tags
 */
if (!function_exists('pacz_html_tag_schema')) {
      function pacz_html_tag_schema()
      {
            $schema = 'http'.((is_ssl()) ? 's' : '').'://schema.org/';
            if (is_single()) {
                  $type = "Article";
            } elseif (is_author()) {
                  $type = 'ProfilePage';
            } elseif (is_search()) {
                  $type = 'SearchResultsPage';
            } else {
                  $type = 'WebPage';
            }
            
            echo 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
      }
}

/**
 * Shortode friendly Text Widgets
 *
 * Generates shortcodes used in Text Widget.
 *
 * @param string  holds the content to be passed to do_shortcode
 */
if (!function_exists('pacz_theme_widget_text_shortcode')) {
      function pacz_theme_widget_text_shortcode($content)
      {
            $content          = do_shortcode($content);
            $new_content      = '';
            $pattern_full     = '{(\[raw\].*?\[/raw\])}is';
            $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
            $pieces           = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
            
            foreach ($pieces as $piece) {
                  if (preg_match($pattern_contents, $piece, $matches)) {
                        $new_content .= $matches[1];
                  } else {
                        $new_content .= do_shortcode($piece);
                  }
            }
            
            return $new_content;
      }
}
add_filter('widget_text', 'pacz_theme_widget_text_shortcode');
add_filter('widget_text', 'do_shortcode');


function pacz_purge_cache_actions() {
    global $wpdb;
    
    $wpdb->query($wpdb->prepare("
                 DELETE FROM $wpdb->postmeta
                 WHERE meta_key = %s
                ", '_dynamic_styles'));
    $static = new Pacz_Static_Files(false);
    $static->DeleteThemeOptionStyles();
}

// clear cache on theme save options
add_action ('redux/options/pacz_settings/saved', 'pacz_purge_cache_actions');
add_action ('redux/options/alsp_admin_settings/saved', 'pacz_purge_cache_actions');

/*-----------------*/

// update plugin

include_once PCPT_PATH. 'pacz-update-checker/pacz-update-checker.php';

$cptpUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/cptp-update.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'pacz-custom-posts'
); 
if (file_exists(plugin_dir_path( __DIR__ ).'js_composer/js_composer.php')) {
	$vcUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/vc-update.json',
		plugin_dir_path( __DIR__ ).'js_composer/js_composer.php',
		'js_composer'
	);  
}
if (file_exists(plugin_dir_path( __DIR__ ).'listing/alsp.php')) {
	$listingUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/alsp-update.json',
		plugin_dir_path( __DIR__ ).'listing/alsp.php',
		'listing'
	); 
}
if (file_exists(plugin_dir_path( __DIR__ ).'AccessPress_Social_Login/accesspress-social-login.php')) {
	$accesspressSocialLoginUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/apsl-update.json',
		plugin_dir_path( __DIR__ ).'AccessPress_Social_Login/accesspress-social-login.php',
		'AccessPress_Social_Login'
	); 
}
if (file_exists(plugin_dir_path( __DIR__ ).'Ultimate_VC_Addons/Ultimate_VC_Addons.php')) {
	$ultimateVcAddonUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/uvc-update.json',
		plugin_dir_path( __DIR__ ).'Ultimate_VC_Addons/Ultimate_VC_Addons.php',
		'Ultimate_VC_Addons'
	); 
}
if (file_exists(plugin_dir_path( __DIR__ ).'dhvc-form/dhvc-form.php')) {
	$dhvcUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/dhvc-update.json',
		plugin_dir_path( __DIR__ ).'dhvc-form/dhvc-form.php',
		'dhvc-form'
	); 
}
if (file_exists(plugin_dir_path( __DIR__ ).'all-in-one-wp-migration-di-templates/all-in-one-wp-migration-di-templates.php')) {
	$dhvcUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/ditemplate-update.json',
		plugin_dir_path( __DIR__ ).'all-in-one-wp-migration-di-templates/all-in-one-wp-migration-di-templates.php',
		'all-in-one-wp-migration-di-templates'
	);
}
if (file_exists(plugin_dir_path( __DIR__ ).'revslider/revslider.php')) {
	$revolutionUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://assets.designinvento.net/plugins/classiadspro/5-5-7/update/revolution-update.json',
		plugin_dir_path( __DIR__ ).'revslider/revslider.php',
		'revslider'
	);
}
/*-----------------*/
/*
Removes version paramerters from scripts and styles.
*/
if (!function_exists('pacz_remove_wp_ver_css_js')) {
      function pacz_remove_wp_ver_css_js($src)
      {
            global $pacz_settings;
            if ($pacz_settings['remove-js-css-ver']) {
                  if (strpos($src, 'ver='))
                        $src = remove_query_arg('ver', $src);
            }
            return $src;
      }
}
add_filter('style_loader_src', 'pacz_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'pacz_remove_wp_ver_css_js', 9999);

function pacz_cpt_rewrite_flush() {
	custom_vc_init();
	register_clients_post_type();
	register_employees_post_type();
	register_testimonials_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pacz_cpt_rewrite_flush' );



