<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pacz_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10 );
		add_action( 'wp_ajax_pacz_install_plugin', array( $this, 'install_plugin' ) );
		add_action( 'wp_ajax_pacz_activate_plugin', array( $this, 'activate_plugin' ) );
		add_action( 'wp_ajax_pacz_deactivate_plugin', array( $this, 'deactivate_plugin' ) );
		add_action( 'wp_ajax_pacz_update_plugin', array( $this, 'update_plugin' ) );

		// Redirect to welcome page
		//add_action( 'admin_footer', array( $this, 'quick_access' ) );
	}
	
	static function dashboard_menu() {
		global $submenu;

		$menus			= $submenu['pacz-admin-classiads-settings'];
		$menu_size		= sizeof( $menus );
		$menu			= '';
		$crt_pg_name	= get_admin_page_title();
		$base			= explode( '_pacz', get_current_screen()->base);
		$base			= 'pacz' . $base[1];

		foreach ($menus as $sub_menu ) {
			$acive_page = ( $base == $sub_menu[2] ) ? ' nav-tab-active' : '' ;
			$menu .= '<a class="nav-tab' . $acive_page . '" href="' . esc_url( self_admin_url( 'admin.php?page='.$sub_menu[2] ) ) . '">' . esc_html( $sub_menu[0], 'classiadspro' ) . '</a>';
		}

		echo $menu;
	}
	static function listing_dashboard_link() {
		global $submenu;

		if(!class_exists('alsp_plugin')){
			return false;
		}
		$listing_dashboard_link = '<a href="' . esc_url( self_admin_url( 'admin.php?page=pacz-admin-listing-panel') ) . '"><i class="pacz-icon-long-arrow-left"></i>'.esc_html__('Browse to Listing Dashboard', 'classiadspro').'</a>';
		echo $listing_dashboard_link;
	}
	
	static function pacz_dashboard_link() {
		global $submenu;
		
		$theme_dashboard_link = '<a class="" href="' . esc_url( self_admin_url( 'admin.php?page=pacz-admin-theme_settings') ) . '"><i class="pacz-icon-long-arrow-left"></i>'.esc_html__('Browse to Theme Dashboard', 'classiadspro').'</a>';
		echo $theme_dashboard_link;
	}
	
	static function pacz_dashboard_header() {
		echo '<h1>'. esc_html__( 'Welcome to ', 'classiadspro' ) . Pacz_Admin::theme( 'name' ).'</h1>';
		echo '<div class="about-text">'.Pacz_Admin::theme( 'name' ) . esc_html__( ' is now installed and ready to use! Let’s convert your imaginations to real things on the web!', 'classiadspro' ).'</div>';
		echo '<div class="wp-badge">'. esc_html__( 'Version', 'classiadspro' ). Pacz_Admin::theme( 'version' ).'</div>';
			Pacz_Admin::listing_dashboard_link();
		echo '<h2 class="nav-tab-wrapper wp-clearfix">';
			Pacz_Admin::dashboard_menu();
		echo '</h2>';
		
	}
	public function tgmpa_load( $load ) {
		return true;
	}

	public function install_plugin() {
		if ( current_user_can( 'manage_options' ) ) {
			check_admin_referer( 'tgmpa-install', 'tgmpa-nonce' );
			global $tgmpa;
			$tgmpa->install_plugins_page();

			$url = wp_nonce_url(
				add_query_arg(
					array(
						'plugin'			=> urlencode( $_GET['plugin'] ),
						'tgmpa-activate'	=> 'deactivate-plugin',
					),
					$tgmpa->get_tgmpa_url()
				),
				'tgmpa-deactivate',
				'tgmpa-nonce'
			);

			echo 'paczi';
			echo htmlspecialchars_decode( $url );
		}

		// this is required to terminate immediately and return a proper response
		wp_die();		
	}

	public function activate_plugin() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			check_admin_referer( 'tgmpa-activate', 'tgmpa-nonce' );
			global $tgmpa;
			$plugins = $tgmpa->plugins;

			foreach ( $plugins as $plugin ) {
				if ( isset( $_GET['plugin'] ) && $plugin['slug'] === $_GET['plugin'] ) {
					activate_plugin( $plugin['file_path'] );

					$url = wp_nonce_url(
						add_query_arg(
							array(
								'plugin'			=> urlencode( $_GET['plugin'] ),
								'tgmpa-deactivate'	=> 'deactivate-plugin',
							),
							$tgmpa->get_tgmpa_url()
						),
						'tgmpa-deactivate',
						'tgmpa-nonce'
					);
					
					echo htmlspecialchars_decode( $url );
				}
			} // foreach
		}
		
		// this is required to terminate immediately and return a proper response
		wp_die();
	}
	
	public function deactivate_plugin() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			check_admin_referer( 'tgmpa-deactivate', 'tgmpa-nonce' );
			global $tgmpa;
			$plugins = $tgmpa->plugins;
			
			foreach ( $plugins as $plugin ) {
				if ( isset( $_GET['plugin'] ) && $plugin['slug'] === $_GET['plugin'] ) {
					deactivate_plugins( $plugin['file_path'] );

					$url = wp_nonce_url(
						add_query_arg(
							array(
								'plugin'			=> urlencode( $_GET['plugin'] ),
								'tgmpa-activate'	=> 'activate-plugin',
							),
							$tgmpa->get_tgmpa_url()
						),
						'tgmpa-activate',
						'tgmpa-nonce'
					);

					echo htmlspecialchars_decode( $url );
				}
			} // foreach
		}

		// this is required to terminate immediately and return a proper response
		wp_die();
	}

	public function update_plugin() {
		if ( current_user_can( 'manage_options' ) ) {
			check_admin_referer( 'tgmpa-update', 'tgmpa-nonce' );
			global $tgmpa;
			$tgmpa->install_plugins_page();

			$url = wp_nonce_url(
				add_query_arg(
					array(
						'plugin'			=> urlencode( $_GET['plugin'] ),
						'tgmpa-deactivate'	=> 'deactivate-plugin',
					),
					$tgmpa->get_tgmpa_url()
				),
				'tgmpa-deactivate',
				'tgmpa-nonce'
			);

			//echo 'paczi';
			echo htmlspecialchars_decode( $url );
		}
		
		// this is required to terminate immediately and return a proper response
		wp_die();
	}
	
	public function enqueue_scripts() {
		 if ( isset( $_GET['page'] ) ) :
			if ( substr( $_GET['page'], 0, 11 ) == "pacz-admin-") :

				// admin pages style
				
				wp_enqueue_style('bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
				wp_enqueue_style( 'pacz-admin-panel-styles', PACZ_THEME_CONTROL_PANEL_URI . '/assets/css/admin-panel.css', 99 );

				// install plugins scripts
				if ($_GET['page'] == 'pacz-admin-plugins' ) :
					wp_enqueue_script( 'pacz-admin-plugins', PACZ_THEME_CONTROL_PANEL_URI . '/assets/js/pacz-plugins.js', array( 'jquery' ), time(), true );
				endif;
				if ( $_GET['page'] == 'pacz-admin-icon-library' ) :
					wp_enqueue_style('pacz-icon-libs', PACZ_THEME_ADMIN_ASSETS_URI . '/css/icon-library.css');
					wp_enqueue_style('paczfont-icon', PACZ_THEME_STYLES . '/fonticon-custom.min.css');
					wp_enqueue_script('icon-libs-filter', PACZ_THEME_ADMIN_ASSETS_URI . '/js/icon-libs-filter.js',  array( 'jquery' ), time(), true);
				endif;
			endif; // substr
		endif; // isset 
	}

	public function admin_menus() {
		//$pacz_options			= pacz_options();
	//	$menu_visiblity			= ( isset($pacz_options['pacz_theme_menus']) && $pacz_options['pacz_theme_menus'] ) ? $pacz_options['pacz_theme_menus'] : '';
		//$pacz_theme_admin_logo	= ! empty( $pacz_options['pacz_theme_admin_logo']['url'] ) ? $pacz_options['pacz_theme_admin_logo']['url'] : DEEP_FREE_PLUS_ASSETS_URL . 'images/dashboard/pacz-admin-menu.png';

		// Welcome page
		/* call_user_func_array( 'add' . '_menu_' . 'page', array(
			Pacz_Admin::theme( 'name' ),
			Pacz_Admin::theme( 'name' ),
			'manage_options',
			PACZ_THEME_SETTINGS,
			array( $this, 'screen_welcome' ),
			0,
		)); */
		
			call_user_func_array( 'add' . '_menu_' . 'page', array(
				esc_html__( 'Classiads Dashboard', 'classiads' ),
				esc_html__( 'Classiads Dashboard', 'classiads' ),
				'manage_options',
				'pacz-admin-classiads-settings',
				array($this, 'screen_welcome'),
				'',
				0
			));
		 call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-classiads-settings',
			esc_html__( 'Classiads Dashboard', 'classiads' ),
			esc_html__( 'Classiads Dashboard', 'classiads' ),
			'manage_options',
			'pacz-admin-classiads-settings',
			array($this, 'screen_welcome'),
			'',
			0
		));
		// Demo Importer page
		/*  call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-classiads-settings',
			esc_html__( 'Demo Importer', 'classiadspro' ),
			esc_html__( 'Demo Importer', 'classiadspro' ),
			'manage_options',
			'pacz-admin-demo-importer',
			array( $this, 'screen_demo_importer' )
		)); */
		// Plugins page
		call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-classiads-settings',
			esc_html__( 'Plugins', 'classiadspro' ),
			esc_html__( 'Plugins', 'classiadspro' ),
			'manage_options',
			'pacz-admin-plugins',
			array( $this, 'screen_plugins' ),
			'',
			10
		));
		call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-classiads-settings',
			esc_html__( 'Icon Library', 'classiadspro' ),
			esc_html__( 'Icon Library', 'classiadspro' ),
			'manage_options',
			'pacz-admin-icon-library',
			array( $this, 'screen_icon_library' ),
			'',
			11
		));
		// Tutorials
		call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-classiads-settings',
			esc_html__( 'Tutorials', 'classiadspro' ),
			esc_html__( 'Tutorials', 'classiadspro' ),
			'manage_options',
			'pacz-admin-tutorial',
			array( $this, 'screen_tutorial' ),
			'',
			12
		));

		// Performance
		/* call_user_func_array( 'add' . '_sub' . 'menu_' . 'page', array(
			'pacz-admin-welcome',
			esc_html__( 'Performance', 'classiadspro' ),
			esc_html__( 'Performance', 'classiadspro' ),
			'manage_options',
			'pacz-admin-performance',
			array( $this, 'screen_performance' )
		)); */
	}
	
	public function screen_welcome() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		//include_once( 'index.php' );
		do_action('pacz_dashboad_panel');
	}
	
	public function screen_plugins() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once( 'templates/plugins.php' );
	}
	public function screen_icon_library() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once( 'templates/icon-library.php' );
	}
	
	public function screen_demo_importer() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once( 'templates/demo-import.php' );
	}
	
	public function screen_tutorial() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once( 'templates/tutorial.php' );
	}
	
	/* public function screen_performance() {
		// Stupid hack for Wordpress alerts and warnings
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once( '_partials/performance.php' );
	} */
	
	static function theme( $property = '' ) {

		// Gets a WP_Theme object for a theme
		$theme_data		= wp_get_theme();	
		
		if ( $theme_data->parent_theme ) {
			$theme_data = wp_get_theme( basename( get_template_directory() ) );
		}

		switch ( $property ) :
			case 'name':
				$data = $theme_data->Name;
				break;
			case 'version':
				$data = $theme_data->Version;
				break;
			default:
				$data = '';
				break;
		endswitch;

		return $data;
	}

	public function quick_access() {
		$current_scr 	= get_current_screen();
		$current_page	= $current_scr->id;
		$protocol		= is_ssl() ? 'https://' : 'http://';
		$update_btns	= '
		<li class="pacz-admin-qacs-item preview-btn">
			<a href="#">
				' . esc_html__( 'Preview page', 'classiadspro' ) . '
			</a>
		</li>
		<li class="pacz-admin-qacs-item update-btn">
			<a href="#">
				' . esc_html__( 'Update page', 'classiadspro' ) . '
			</a>
		</li>';
		?>
		
		<div class="pacz-admin-qacs-wrap">
			<div class="hamburger hamburger--spring-r">
				<div class="hamburger-box">
					<div class="hamburger-inner"></div>
				</div>
			</div>
			<ul class="pacz-admin-qacs">
				<?php

				switch ($current_page) {
					case 'post': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#pacz-post-options">
								<?php esc_html_e( 'Post options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'page': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#pacz-page-options">
								<?php esc_html_e( 'Page options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'cause': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#pacz-cause-options">
								<?php esc_html_e( 'Cause options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'gallery': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'wbf_footer':?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'portfolio': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#pacz-portfolio-options">
								<?php esc_html_e( 'Portfolio options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'sermon': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#pacz-sermon-options">
								<?php esc_html_e( 'Sermon options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'mega_menu': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;

					case 'mec-events': ?>
						<?php echo $update_btns; ?>
						<li class="pacz-admin-qacs-item">
							<a href="#mec_metabox_details">
								<?php esc_html_e( 'Event options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=MEC-settings' ); ?>" target="_blank" >
								<?php esc_html_e( 'M.E. Calendar settings', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;
					
					default: ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new post', 'classiadspro' ); ?>
							</a>
						</li>
						
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=page' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new page', 'classiadspro' ); ?>
							</a>
						</li>

						<?php if ( defined( 'GALLERY_DIR' ) ) : ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=gallery' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new gallery', 'classiadspro' ); ?>
							</a>
						</li>
						<?php endif; ?>

						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=wbf_footer' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new footer', 'classiadspro' ); ?>
							</a>
						</li>

						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=mega_menu' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new mega menu', 'classiadspro' ); ?>
							</a>
						</li>

						<?php if ( defined( 'PORTFOLIO_DIR' ) ) : ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=portfolio' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new portfolio', 'classiadspro' ); ?>
							</a>
						</li>
						<?php endif; ?>
						
						<?php if ( class_exists( 'MEC' ) ) : ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=mec-events' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new event', 'classiadspro' ); ?>
							</a>
						</li>
						<?php endif; ?>

						<?php if ( defined( 'CAUSES_DIR' ) ) : ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=cause' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new cause', 'classiadspro' ); ?>
							</a>
						</li>
						<?php endif; ?>

						<?php if ( defined( 'SERMONS_DIR' ) ) : ?>
						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'post-new.php?post_type=sermon' ); ?>" target="_blank" >
								<?php esc_html_e( 'Add new sermon', 'classiadspro' ); ?>
							</a>
						</li>
						<?php endif; ?>

						<li class="pacz-admin-qacs-item">
							<a href="<?php echo self_admin_url( 'admin.php?page=pacz_theme_options' ); ?>" target="_blank" >
								<?php esc_html_e( 'Theme options', 'classiadspro' ); ?>
							</a>
						</li>

						<li class="pacz-admin-qacs-item">
							<a href="<?php echo $protocol . 'pacztem.com/documentation/'; ?>" target="_blank" >
								<?php esc_html_e( 'Documentation', 'classiadspro' ); ?>
							</a>
						</li>
						<?php
						break;
				} ?>
			</ul>
		</div>
	<?php
	}

}
new Pacz_Admin();