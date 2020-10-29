<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>
<h2>
	<?php _e('Listing Reset', 'ALSP'); ?>
</h2>

<h3>Are you sure you want to reset settings?</h3>
<a href="<?php echo admin_url('admin.php?page=alsp_reset&reset=settings'); ?>">Reset settings</a>

<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>