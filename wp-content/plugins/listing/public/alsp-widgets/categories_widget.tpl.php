<?php
$scroll = 0;
 ?>

<?php echo $args['before_widget']; ?>
<?php if (!empty($title)){
	if (isset($style) && $style == 1){
		echo '<div class="alsp_category_widget_inner">'.$args['before_title'] . $title . $args['after_title'].'</div>';
	}else{
		echo '<div class="alsp_category_widget_inner style2">'.$args['before_title'] . $title . $args['after_title'].'</div>';
	}
	
}
?>
<div class="alsp-widget alsp-categories-widget">
	<?php
		if ($style == 1){
			echo '<div class="alsp_category_widget_inner">';
		}else{
			echo '<div class="alsp_category_widget_inner style2">';
		}
			/* echo alsp_renderAllCategories(
				$id,
				$parent,
				$depth,
				1, // column
				$counter,
				$subcats,
				1, // cat style
				$cat_icon_type, //icon type
				0, // scroll
				3,
				3,
				2,
				false,
				false,
				false,
				1000,
				1000,
				30,
				array(),
				array()
			);  */
			$controller = new alsp_categories_controller();
			$controller->init($instance);
			echo $controller->display();
		echo '<div>';
	 ?>
</div>
<?php echo $args['after_widget']; ?>