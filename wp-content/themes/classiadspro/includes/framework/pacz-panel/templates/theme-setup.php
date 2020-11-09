<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$Pacz_Admin = new Pacz_Admin();
$template_Admin = new Designinvento_Templates();
?>
<div class="wrap about-wrap pacz-admin-wrap theme-setup-page">
	<?php Pacz_Admin::pacz_dashboard_header(); ?>
	<div class="pacz-plugins pacz-theme-browser-wrap">
		<div class="theme-browser rendered">
			<div class="pacz-box">
				<div class="pacz-box-head">
					<?php esc_html_e('Theme Setup','classiadspro'); ?>
				</div>
				<div class="pacz-box-content">
					<div class="pacz-setup-content">
						<img src="<?php echo PACZ_THEME_DIR_URI .'/screenshot.jpg'; ?>" alt="classiadspro" />
						<?php if(class_exists('Designinvento_Templates') && $template_Admin->is_active()): ?>
							<a class="btn btn-primary btn-block" href="<?php echo DESIGNINVENTO_TEMPLATES_PAGE; ?>"><?php echo esc_html__('Start Theme Setup', 'classiadspro'); ?></a>
						<?php else: ?>
							<a class="btn btn-primary btn-block" href="<?php echo admin_url( 'admin.php?page=pacz-admin-registration'); ?>"><?php echo esc_html__('Setup Rquired Registration', 'classiadspro'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>