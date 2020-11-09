<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$theme_data = wp_get_theme("classiadspro");
?>

<div class="wrap about-wrap pacz-admin-wrap">
	<?php Pacz_Admin::pacz_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<?php
			$tgmpa_list_table	= new TGMPA_List_Table;
			$plugins			= TGM_Plugin_Activation::$instance->plugins;
		?>
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php esc_html_e('Plugins Management','classiadspro'); ?>
				</div>
				<div class="pacz-box-content">
					<?php
					foreach( $plugins as $plugin ) :

						$plugin_status				= '';
						
						if( $plugin['required'] ){
							$plugin_type = esc_html__('Required', 'classiadspro');
							$badge_class = 'badge-danger';
						}else{
							$plugin_type = esc_html__('Recommended', 'classiadspro');
							$badge_class = 'badge-success';
						}
						
						$plugin['sanitized_plugin']	= $plugin['name'];

						$plugin_action = $tgmpa_list_table->actions_plugin( $plugin );

						if ( is_plugin_active( $plugin['file_path'] ) ) {
							$plugin_status = 'active';
						}

						//$category = $plugin['category']

						?>

						<div class="plugin-item <?php echo esc_attr( $plugin_status ); ?>">
							<div class="plugin-status badge"><?php echo esc_attr($plugin['version']); ?></div>
							<div class="plugin-status badge <?php echo esc_attr($badge_class); ?>"><?php echo $plugin_type; ?></div>
							<h3 class="theme-name"><?php echo esc_html( $plugin['name'] ); ?></h3>
							<div class="theme-actions"><?php echo '' . $plugin_action; ?></div>

						</div>

					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

</div> <!-- end wrap -->