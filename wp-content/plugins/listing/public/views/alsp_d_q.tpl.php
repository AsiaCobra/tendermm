<?php alsp_renderTemplate('views/alsp_header.tpl.php'); ?>

<h2>
	<?php echo $heading; ?>
</h2>

<form action="" method="POST">
	<p>
		<?php echo $question; ?>
	</p>

	<?php submit_button(__('Delete', 'ALSP')); ?>
</form>

<?php alsp_renderTemplate('views/alsp_footer.tpl.php'); ?>