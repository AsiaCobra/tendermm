<?php
/**
 * Template name: Gd User Dashboard Template
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 5.8
 */


global $post, $ALSP_ADIMN_SETTINGS;
if(empty(global_get_post_id())){
	$post_id = $post->ID;
//}elseif(class_exists('GeoDirectory')){
	//$gd_settings = get_option('geodir_settings');
	//if(isset($gd_settings['page_details'])){
		//$post_id = $gd_settings['page_details'];
		//define("GD_SINGLE_PAGE_TEMP_ID", $post_id);
		
	//}else{
		//$post_id = global_get_post_id();
	//}
}else{
	$post_id = global_get_post_id();
}


$layout = 'full';


$padding = ($padding == 'true') ? 'no-padding' : '';

get_header();
?>
	<div id="theme-page">
		<div class="pacz-main-wrapper-holder clearfix">
			<div class="theme-page-wrapper pacz-main-wrapper vc_row-fluid clearfix">
				<?php apply_filters('dashboard_panel_html', 'gdud_dashboard_panel_html'); ?>
				<div class="gdud-panel content-wrapper-main clearfix">
					<div id="panel-content=wrapper" class="content-wrapper clearfix">
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
<?php get_footer(); ?>