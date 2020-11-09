<?php
/**
 * Template name: ALSP Dashboard Template
 *
 * @package WordPress
 * @subpackage Classiads
 * @since Classiads 5.5
 */

global $post;
if(empty(global_get_post_id())){
	$post_id = $post->ID;
}else{
	$post_id = global_get_post_id();
}

get_header();
?>
	<div id="theme-page">
		<div class="pacz-main-wrapper-holder clearfix">
			<div class="pacz-user-panel theme-page-wrapper pacz-main-wrapper vc_row-fluid clearfix">
				<?php apply_filters('dashboard_panel_html', 'alsp_dashboard_panel_html'); ?>
				<div class="pacz-panel content-wrapper clearfix">
					<div id="panel-content-wrapper" class="alsp-content clearfix">
						<div class="alsp-dashboard-tabs-content">
							<div class="clearfix"></div>
							<div class="tab-content">
								<?php do_action('page_add_before_content'); ?>

								<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
									<?php the_content();?>
									<div class="clearboth"></div>
								<?php endwhile; ?>
								<?php do_action('page_add_after_content'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>