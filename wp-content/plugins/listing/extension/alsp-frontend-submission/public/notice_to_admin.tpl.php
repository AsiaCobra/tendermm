<h3>
	<?php echo esc_html__('Do you have a query?', 'ALSP'); ?>
</h3>
<div class="alert alert-info"><?php _e('Feel free to contact us if you have a special query regarding this listing.', 'ALSP'); ?></div>
<?php 
if(metadata_exists('post', $alsp_instance->current_listing->post->ID, '_notice_to_admin' ) ) {
    $content = get_post_meta( $alsp_instance->current_listing->post->ID, '_notice_to_admin', true );
}else{
	 $content = esc_html__('Your comment here!', 'ALSP');
}
?>
<form action="" method="POST">
	<div class="alsp-submit-section">
		<div class="alsp-submit-section-inside">
			<?php wp_editor($content, '_notice_to_admin', array('media_buttons' => false, 'editor_class' => 'alsp-editor-class')); ?>
			<br>
			<input class="btn btn-primary" name="notice_to_admin_submit" type="submit" value="<?php _e('Send', 'ALSP'); ?>"/>
		</div>
	</div>
</form>
