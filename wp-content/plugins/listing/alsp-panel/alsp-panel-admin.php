<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Alsp_Admin_Panel {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	static function dashboard_menu() {
		global $submenu;

		$menus			= $submenu['pacz-admin-listing-panel'];
		$menu_size		= sizeof( $menus );
		$menu			= '';
		$crt_pg_name	= get_admin_page_title();
		if($_GET['page'] == 'pacz-admin-listing-panel'){
			$base			= explode( '_pacz', get_current_screen()->base);
			$base			= 'pacz' . $base[1];
		 }else{
			$base			= explode( '_alsp', get_current_screen()->base);
			$base			= 'alsp' . $base[1];
		} 
		foreach ($menus as $sub_menu ) {
			$acive_page = ( $base == $sub_menu[2] ) ? ' nav-tab-active' : '' ;
			$menu .= '<a class="nav-tab' . $acive_page . '" href="' . esc_url( self_admin_url( 'admin.php?page='.$sub_menu[2] ) ) . '">' . esc_html( $sub_menu[0], 'classiadspro' ) . '</a>';
		}
		echo $menu;
	}
	
	static function listing_dashboard_header() {
		echo '<h1>'. esc_html__( 'Welcome to Ads Listing System', 'ALSP' ).'</h1>';
		echo '<div class="about-text">'.esc_html__( 'Ads Listing System is now installed and ready to use! Let’s convert your imaginations to real things on the web!', 'ALSP' ).'</div>';
		echo '<div class="wp-badge">'.esc_html__( 'Version 2.1.8', 'ALSP' ).'</div>';
			Pacz_Admin::pacz_dashboard_link();
		echo '<h2 class="nav-tab-wrapper wp-clearfix">';
			Alsp_Admin_Panel::dashboard_menu();
		echo '</h2>';
		
	}
	public function enqueue_scripts() {
		 if ( isset( $_GET['page'] ) ) :
			if ($_GET['page'] == 'pacz-admin-listing-panel ' || substr( $_GET['page'], 0, 5 ) == "alsp_" || $_GET['page'] == 'alsp-admin-listing_settings') :
				//wp_enqueue_style('bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
				wp_enqueue_style( 'pacz-admin-panel-styles', ALSP_URL . 'alsp-panel/assets/css/admin-panel.css', 99 );
			endif; // substr
		endif; // isset 
	}

	public function admin_menus() {
		
			$hook = add_menu_page(
				esc_html__( 'Ads Listing System', 'ALSP' ),
				esc_html__( 'Ads Listing System', 'ALSP' ),
				'manage_options',
				'pacz-admin-listing-panel',
				array($this, 'screen_welcome'),
				'',
				15
			);
			//add_submenu_page(PACZ_THEME_SETTINGS, 'Icon Library', 'Icon Library', 'manage_options', 'icon-library', 'icon_library_submenu_page_callback', '', 30);
			add_action('admin_print_styles-' . $hook,'pacz_theme_admin_panel_scripts_styles');
	}
	
	public function screen_welcome() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		//include_once( 'index.php' );
		do_action('alsp_dashboad_panel');
	}
}
new Alsp_Admin_Panel();