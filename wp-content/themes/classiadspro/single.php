<?php

global $post;
$layout_meta = get_post_meta( $post->ID, '_layout', true );
if(isset($layout_meta) && !empty($layout_meta)){
	$layout = $layout_meta;	
}elseif(is_active_sidebar('sidebar-3')){
	$layout = 'right';	
}else{
	$layout = 'full';
}
$image_height = $pacz_settings['blog-single-image-height'];
$image_width = pacz_content_width($layout);

$padding = get_post_meta( $post->ID, '_padding', true );
$padding = ($padding == 'true') ? 'no-padding' : '';

$show_featured = get_post_meta( $post->ID, '_featured_image', true );
$show_featured = (isset($show_featured) && !empty($show_featured)) ? $show_featured  : 'true' ;

$show_meta = get_post_meta( $post->ID, '_meta', true );
$show_meta = (isset($show_meta) && !empty($show_meta)) ? $show_meta  : 'true' ;


get_header(); ?>

<div id="theme-page" class="pacz-blog-single">
	<div class="pacz-main-wrapper-holder">
		<div class="theme-page-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid <?php echo esc_attr($padding); ?>">
			<div class="theme-inner-wrapper clearfix">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post();
					$post_type = (get_post_format( get_the_id()) == '0' || get_post_format( get_the_id()) == '') ? 'image' : get_post_format( get_the_id());
					$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
					if(isset($pacz_settings['blog-image-crop']) && $pacz_settings['blog-image-crop'] == 0) {
						$image_src = $image_src_array[ 0 ];
					} else {
						$image_src = bfi_thumb( $image_src_array[ 0 ], array('width' => $image_width, 'height' => $image_height, 'crop'=>true));
					}
				?>
					<div class="theme-content <?php echo esc_attr($padding); ?> clearfix" id="blog-entry-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="mainContentOfPage">
						<div class="inner-content clearfix">
							<?php 
							if($show_featured == 'true') {
								if(isset($pacz_settings['blog-featured-image']) && $pacz_settings['blog-featured-image'] == 1) {
									if($post_type == 'image' || $post_type == 'portfolio') {
										if(has_post_thumbnail()) : ?>
											<div class="featured-image">
												<a href="<?php echo esc_url($image_src_array[ 0 ]); ?>" class="pacz-lightbox"><img alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo pacz_thumbnail_image_gen($image_src, $image_width, $image_height); ?>" height="<?php echo esc_attr($image_height); ?>" width="<?php echo esc_attr($image_width); ?>" itemprop="image" /></a>
											</div>
										<?php endif;

									} elseif($post_type == 'video') {
										
									} elseif($post_type == 'audio') {
			
									}else if($post_type == 'gallery') {
					
									}
								}
							} 
							?>
			
							<div class="blog-entry-heading">
								<h2 class="blog-title"><?php the_title() ?></h2>
							</div>
							<?php
							if($show_meta == 'true') : ?>
								<div class="entry-meta">
									<div class="item-holder clearfix">
										<time datetime="<?php the_time( 'F jS, Y' ) ?>" itemprop="datePublished" pubdate>
											<a href="<?php get_month_link( the_time( "Y" ), the_time( "m" ) ) ?>"><?php the_date() ?></a>
										</time>
										<div class="entry-categories"><?php echo esc_html__('Category : ', 'classiadspro'); ?><?php the_category( ', ' ); ?></div>
										<div class="blog-author"><?php echo esc_html__('posted by : ', 'classiadspro')?><span><?php echo get_the_author(); ?></span></div>
										<a href="#comments" class="blog-comments"><?php echo comments_number( '0', '1', '%'); ?><span><?php echo esc_html__('comments', 'classiadspro'); ?></span></a>
									</div>
								</div>
							<?php endif; ?>
							<div class="single-content">
								<?php the_content(); ?>
								<?php the_tags(); ?>
							</div>
							
						</div>
						<?php 
						$post_exist = get_next_post();
						if(!empty($post_exist)):
						?>
							<div class="inner-content">
								<div class="post-pre-next clearfix">
									<nav class="pacz-next-prev clearfix">
										<?php 
										the_post_navigation(
											array(
												'prev_text' => '<span class="previous_post"><i class="pacz-theme-icon-prev-big"></i>%title</span>',
												'next_text' => '<span class="next_post">%title<i class="pacz-theme-icon-next-big"></i></span>',
											)
										);
										?>
									</nav>
									<?php 
									wp_link_pages( array(
										'before'      => '<div class="pacz-page-links">',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
									) );
									?>
								</div>
							</div>
						<?php endif ?>
						<?php
						/* About Author section */
						$authorID = get_the_author_meta( 'ID' );
						$author_disc = get_the_author_meta('description', $authorID);
						if($pacz_settings['blog-single-about-author'] && !empty($author_disc)) :
						?>
							<div class="inner-content clearfix">
								<div class="single-blog-author">
									<div class="blog-author-bio">
										<p><?php the_author_meta('description'); ?></p>
									</div>
									<div class="blog-author-box clearfix">
										<div class="author-img">
											<?php 
											if(class_exists('alsp_plugin')){
												require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";  
												$avatar_id = get_user_meta( $authorID, 'avatar_id', true );
												$author_avatar_url = wp_get_attachment_image_src( $avatar_id, 'full' ); 
												$image_src_array = $author_avatar_url[0];
												if(!empty($image_src_array)) {
													$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
													echo '<img src="' . bfi_thumb( $image_src_array, $params ) . '"  alt="'.get_the_author_meta('display_name', $authorID).'" />';
												}
											}else{ 
													$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '70' ); 
													echo '<img src="'.esc_url($avatar_url).'" alt="author" />';

											} 
											?>
										</div>
										
										<div class="author-info">
											<div class="blog-author-name">
												<?php echo get_the_author_meta('display_name', $authorID);?>
											</div>
										</div>	
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php
						if($pacz_settings['blog-single-comments'] && comments_open($post->ID)) { ?>
							<div class="inner-content-comments clearfix">
								<?php comments_template( '', true ); ?>
							</div>
						<?php } ?>


					</div>
				<?php endwhile; ?>
				<?php  if($layout != 'full') get_sidebar();  ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
