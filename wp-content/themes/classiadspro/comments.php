<?php
if(is_single() || is_page()){
if(!function_exists('pacz_theme_comments')){
function pacz_theme_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; 
	global $post;
if( $comment->user_id === $post->post_author ) {
	$userClass = 'selfresponse';
}else{
	$userClass = 'userresponse';
}
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent-comment') ?> id="li-comment-<?php comment_ID() ?>">
	<div class="pacz-single-comment <?php echo esc_attr($userClass); ?> clearfix" id="comment-<?php comment_ID(); ?>">
		<div class="comment-content">
			<?php 
				if ($post->post_type == 'alsp_listing' || $post->post_type == 'dp_listing') {
					$rating = get_comment_meta($comment->comment_ID, 'dirrater', true );
					$dirrater_title = get_comment_meta($comment->comment_ID, 'dirrater_title', true );
					if ( !empty( $dirrater_title )  ) {
						echo '<p class="dirrater_title">' . $dirrater_title . '</p>';
					}
					if ( ! empty( $rating ) ) {
						echo '<div class="review_rate" data-dirrater="' . $rating . '"></div>';
					}
				}
				?>
			<?php comment_text() ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="unapproved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'classiadspro' );?></span>
			<?php endif; ?>	
		</div>
		<div class="comment-meta-main clearfix">
			<div class="author-img">
					<?php require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; ?>
					<?php 
					if(class_exists('alsp_plugin')){
						require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";  
						$avatar_id = get_user_meta( $comment->user_id, 'avatar_id', true );
						$author_avatar_url = wp_get_attachment_image_src( $avatar_id, 'full' ); 
						$image_src_array = $author_avatar_url[0];
						if(!empty($image_src_array)) {
							$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
							echo '<img src="' . bfi_thumb( $image_src_array, $params ) . '"  alt="'.get_the_author_meta('display_name', $comment->user_id).'" />';
						}elseif(function_exists('custom_vc_init')){
							$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $comment->user_id), $size = '70' ); 
							echo '<img src="'.esc_url($avatar_url).'" alt="author" />';
						}
					}elseif(function_exists('custom_vc_init')){ 
						$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $comment->user_id), $size = '70' ); 
						echo '<img src="'.esc_url($avatar_url).'" alt="author" />';
					}
					?>
			</div>
			<div class="comment-meta">
				<?php printf( '<span class="comment-author">%s</span>', get_comment_author_link() ); ?>	
				<time class="comment-time"><?php echo get_comment_time('F jS, Y h:i A'); ?></time>
				<span class="comment-reply">
					<?php 
					$current_user = wp_get_current_user();
					if(is_user_logged_in()) {
						$usercomment = get_comments( array (
							'user_id' => $current_user->ID,
							'post_id' => $post->ID,
						) );		
						if($current_user->display_name != get_comment_author() && $current_user->display_name == get_the_author()) {
							comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => esc_html__('reply', 'classiadspro') ) ) );
						}
					}
					?>
				</span>
			</div>	
		</div>     
	</div>	
</li>	
<?php
}


function pacz_list_pings( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>"> 
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrap comments-pings">

			<div class="comment-content">

				<div class="comment-meta">

					<?php printf( '<span class="comment_author"><b>%s</b></span>', get_comment_author_link() ) ?>

				</div>
				<div class="comment-data">
					<?php comment_text() ?>

								<time class="comment-time"><?php echo get_comment_time('F jS, Y h:i A'); ?></time>
<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="unapproved"><?php esc_html__('Your comment is awaiting moderation.', 'classiadspro'); ?></span>
<?php endif; ?>
				</div>
                <div class="clearboth"></div>
	</div>





<?php } ?>

<section id="comments">
<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'classiadspro' );?></p>
</section><!-- #comments -->
<?php
return;
endif;

if ( have_comments() ) : 
if ($post->post_type == 'alsp_listing' || $post->post_type == 'dp_listing') {
	$comments_label = esc_html__('User Reviews', 'classiadspro');
}else{
	$comments_label = esc_html__('Comments', 'classiadspro');
}
	
	?>
	<div class="single-post-fancy-title comments-heading-label"><span><?php echo esc_attr($comments_label).' <span class="comments_numbers">'. number_format_i18n( get_comments_number() ).'</span>'; ?></span></div>
	<ul class="pacz-commentlist">
		<?php
wp_list_comments( 'callback=pacz_theme_comments&type=comment' );
?>
	</ul>





<?php
if ( have_comments() ) : ?>
<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
<div class="single-post-fancy-title"><span><?php esc_html_e( 'pingbacks / trackbacks', 'classiadspro' ); ?></span></div>

<ul class="pacz-commentlist">
<?php wp_list_comments( 'callback=pacz_list_pings&type=pings' ); ?>
</ul>
<?php endif; endif; ?>

<?php else :
	if ( ! comments_open() ) :
		endif;
	endif;
?>

 <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav class="comments-navigation">
		<div class="comments-previous"><?php previous_comments_link(); ?></div>
		<div class="comments-next"><?php next_comments_link(); ?></div>
	</nav>
<?php endif;?>

	<?php if ( comments_open() ) : ?>
<div class="inner-content">
	<?php
	
		$fields =  array(
			'author'=> '<div class="comment-form-name comment-form-row"><i class="pacz-icon-user"></i><input type="text" name="author" class="text-input" id="author" tabindex="54" placeholder="'.esc_html__('FULL NAME', 'classiadspro').'"  /></div>',
			'email' => '<div class="comment-form-email comment-form-row"><i class="pacz-icon-envelope-o"></i><input type="text" name="email" class="text-input" id="email" tabindex="56" placeholder="'.esc_html__('EMAIL ADDRESS', 'classiadspro').'" /></div>',
			'url' 	=> '<div class="comment-form-website comment-form-row"><i class="pacz-icon-globe"></i><input type="text" name="url" class="text-input" id="url" tabindex="57" placeholder="'.esc_html__('WEBSITE', 'classiadspro').'" /></div>',
		);
if ($post->post_type == 'alsp_listing' || $post->post_type == 'dp_listing') {
	$comment_form_label = esc_html__('Post New Review', 'classiadspro');
	$comment_form_submit = esc_html__('Submit Review','classiadspro');
}else{
	$comment_form_label = esc_html__('Leave a Comment', 'classiadspro');
	$comment_form_submit = esc_html__('Post Comment','classiadspro');
}
		//Comment Form Args
        $comments_args = array(
			'fields' => $fields,
			'title_reply'=>'<div class="leave-comment-heading"><div>'.$comment_form_label.'</div></div>',
			'comment_field' => '<div class="comment-textarea"><textarea placeholder="'.esc_html__('Your Comment', 'classiadspro').'" class="textarea" name="comment" rows="3" id="comment" tabindex="58"></textarea></div>',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'label_submit' => $comment_form_submit,
		);
		global $current_user, $post;

if ( !is_user_logged_in() ) {
	$current_user = wp_get_current_user();
    comment_form($comments_args); 
} elseif(is_user_logged_in()) { // The user is logged in...
    $usercomment = get_comments( array (
            'user_id' => $current_user->ID,
            'post_id' => $post->ID,
    ) );
    
    if ( $usercomment ) { 
        
    } else { // Otherwise, show the comment form.
         comment_form($comments_args); 
    }
}
		
	?>
</div>
<?php endif; ?>


</section>
<?php } } ?>