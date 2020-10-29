<?php 
function alsp_upgrade_notice(){ ?>
	<div class="notice alsp-notice notice-error">
		<p><?php echo esc_html__('Listing', 'ALSP'); ?> <?php echo ALSP_VERSION ?> <?php echo esc_html__(' Required Database Upgrade, please click below to update database.', 'ALSP'); ?></p>
		<div class="">
			<form method="post" enctype="multipart/form-data">
				<button id="alsp_db_update" class="update_submit" type="submit" name="alsp_db_update"><?php echo esc_html__('Update', 'ALSP'); ?></button>
			</form>
		</div>
	</div>
<?php
}
if (get_option('alsp_installed_directory')) {
	if(!get_option('fix_1_14_11') || get_option('fix_1_14_11') != 'fixed'){
		if(isset($_POST['alsp_db_update'])){ upgrade_to_1_14_11(); }
	}
	if(!get_option('fix_2_0') || get_option('fix_2_0') != 'fixed'){
		if(isset($_POST['alsp_db_update'])){ upgrade_to_2_0(); }
	}
	if(!get_option('fix_2_0_1') || get_option('fix_2_0_1') != 'fixed'){
		if(isset($_POST['alsp_db_update'])){ upgrade_to_2_0_1(); }
	}
	if(!get_option('fix_2_0_2') || get_option('fix_2_0_2') != 'fixed'){
		if(isset($_POST['alsp_db_update'])){ 
			upgrade_to_2_0_2();
			header("Refresh:0");
		}
		add_action('admin_notices', 'alsp_upgrade_notice');
	}
	if(!get_option('fix_2_0_3') || get_option('fix_2_0_3') != 'fixed'){
		//if(isset($_POST['alsp_db_update'])){ 
			upgrade_to_2_0_3();
			header("Refresh:0");
		//}
		//add_action('admin_notices', 'alsp_upgrade_notice');
	}
}

function upgrade_to_1_14_11() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	
	$fieldwidth_archive = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'fieldwidth_archive'", ARRAY_A);
	$advanced_archive_search_form = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'advanced_archive_search_form'", ARRAY_A);
	$advanced_widget_search_form = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'advanced_widget_search_form'", ARRAY_A);
	
	$listings_in_package = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'listings_in_package'", ARRAY_A);
	$change_level_id = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'change_level_id'", ARRAY_A);
	$listings_resurva = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'allow_resurva_booking'", ARRAY_A);
	$group_style = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields_groups LIKE 'group_style'", ARRAY_A);
	$checkbox = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'checkbox_icon_type'", ARRAY_A);
	
	if (empty($fieldwidth_archive)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `fieldwidth_archive` VARCHAR(255) DEFAULT NULL AFTER `fieldwidth`");
	}
	if (empty($advanced_archive_search_form)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `advanced_archive_search_form` tinyint(1) NOT NULL AFTER `advanced_search_form`");
	}
	if (empty($advanced_widget_search_form)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `advanced_widget_search_form` tinyint(1) NOT NULL AFTER `advanced_archive_search_form`");
	}
	
	if (empty($listings_in_package)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `listings_in_package` INT(11) NOT NULL DEFAULT '1' AFTER `eternal_active_period`");
	}
	if (empty($change_level_id)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `change_level_id` INT(11) NOT NULL DEFAULT '0' AFTER `eternal_active_period`");
	}
	if (empty($listings_resurva)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `allow_resurva_booking` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `featured_level`");
	}
	if (empty($group_style)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields_groups` ADD `group_style` varchar(255) NOT NULL AFTER `on_tab`");
	}
	if (empty($checkbox)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `checkbox_icon_type` varchar(255) NOT NULL AFTER `options`");
	}
	
	update_option('fix_1_14_11', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}
function upgrade_to_2_0() {
	global $wpdb, $pacz_settings, $alsp_instance;
	$pacz_options = get_option('pacz_settings');
	$ALSP_ADIMN_SETTINGS = get_option('alsp_admin_settings');
	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
	}
	
	$prefix = $wpdb->prefix;
	$users = get_users( ['fields' => ['ID'] ] );
	 include(ABSPATH . "wp-includes/pluggable.php");
	foreach ( $users as $user ) {
		$url  = get_user_meta($user->ID, "pacz_author_avatar_url", true);
		$id   = attachment_url_to_postid( $url );
		$user_update = update_user_meta($user->ID, 'avatar_id', $id);
		
	}
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$prefix."alsp_directories` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`single` varchar(255) NOT NULL,
				`plural` varchar(255) NOT NULL,
				`listing_slug` varchar(255) NOT NULL,
				`category_slug` varchar(255) NOT NULL,
				`location_slug` varchar(255) NOT NULL,
				`tag_slug` varchar(255) NOT NULL,
				`categories` text NOT NULL,
				`locations` text NOT NULL,
				`levels` text NOT NULL,
				PRIMARY KEY (`id`)
				) $collate ;");
		
	if (!$wpdb->get_var("SELECT id FROM `".$prefix."alsp_directories` WHERE name = 'Listings'")) {
		$listing_slug = $ALSP_ADIMN_SETTINGS['alsp_listing_slug'];
		$category_slug = $ALSP_ADIMN_SETTINGS['alsp_category_slug'];
		$location_slug = $ALSP_ADIMN_SETTINGS['alsp_location_slug'];
		$tag_slug = $ALSP_ADIMN_SETTINGS['alsp_tag_slug'];

		$wpdb->query("INSERT INTO `".$prefix."alsp_directories` (`name`, `single`, `plural`, `listing_slug`, `category_slug`, `location_slug`, `tag_slug`, `categories`, `locations`, `levels`) VALUES ('Listings', 'listing', 'listings', $listing_slug, $category_slug, $location_slug, $tag_slug, '', '', '')");
	}
	
	if (($widgets_array = get_option('widget_alsp_search_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_alsp_search_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_alsp_categories_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_alsp_categories_widget', $widgets_array);
	}

	if (($widgets_array = get_option('widget_alsp_locations_widget')) && is_array($widgets_array)) {
		foreach ($widgets_array AS &$widget) {
			if (isset($widget['title'])) {
				$widget['directory'] = 0;
			}
		}
		update_option('widget_alsp_locations_widget', $widgets_array);
	}
	
	$listings = $wpdb->get_results("
			SELECT ID FROM `".$prefix."posts` AS wp_posts
			LEFT JOIN `".$prefix."postmeta` AS mt1 ON (wp_posts.ID = mt1.post_id AND mt1.meta_key = '_directory_id' )
			WHERE
			wp_posts.post_type = 'alsp_listing' AND
			mt1.post_id IS NULL
	", ARRAY_A);
	
	foreach ($listings AS $row) {
		add_post_meta($row['ID'], '_directory_id', 1);
	}

	$posts_ids = $wpdb->get_col("
				SELECT
					wp_pm.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm
				WHERE
					wp_pm.meta_key = '_listing_status' AND
					wp_pm.meta_value != 'active'
			");

	foreach ($posts_ids AS $listing_id) {
		wp_update_post(array('ID' => $listing_id, 'post_status' => 'pending'));
	}

	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-dashboard', 'alsp-dashboard')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-levels-table', 'alsp-levels-table')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-listings', 'alsp-listings')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-listing', 'alsp-listing')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-categories', 'alsp-categories')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-locations', 'alsp-locations')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-search', 'alsp-search')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-slider', 'alsp-slider')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-buttons', 'alsp-buttons')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-map', 'alsp-map')");
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory-submit', 'alsp-submit')");
	
	$wpdb->query("UPDATE `".$prefix."posts` SET `post_content` = replace(post_content, 'webdirectory', 'alsp-main')");
	
	/* $change_level_map = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'google_map'", ARRAY_A);
	if(empty($change_level_map)){
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` CHANGE `google_map` `map` TINYINT(1) NOT NULL, CHANGE `google_map_markers` `map_markers` TINYINT(1) NOT NULL;");
	} */
	$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` CHANGE `google_map` `map` TINYINT(1) NOT NULL, CHANGE `google_map_markers` `map_markers` TINYINT(1) NOT NULL;");

	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `is_hide_name_on_grid` varchar(255) NOT NULL DEFAULT 'hide' AFTER `is_hide_name`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `is_hide_name_on_list` varchar(255) NOT NULL DEFAULT 'hide' AFTER `is_hide_name_on_grid`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `is_hide_name_on_search` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `is_hide_name_on_list`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `is_field_in_line` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `is_hide_name_on_search`");
	
	$wpdb->query("UPDATE `".$prefix."alsp_content_fields` SET `is_search_configuration_page`=1 WHERE `type` IN ('string','textarea')");
	
	//include(ABSPATH . "wp-content/themes/classiadspro/includes/framework/ReduxCore/inc/class.redux_api.php");
	//Redux::setOption('alsp_admin_settings','search_box_background', $pacz_options['main-searchbar-bg-color']);
	
	update_option('fix_2_0', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}
function upgrade_to_2_0_1() {
	global $wpdb, $pacz_settings, $alsp_instance;
	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
	}
	$prefix = $wpdb->prefix;
	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `on_exerpt_page_list` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `on_exerpt_page`");
	update_option('fix_2_0_1', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}
function upgrade_to_2_0_2() {
	global $wpdb, $pacz_settings, $alsp_instance;
	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
	}
	$prefix = $wpdb->prefix;
	$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` CHANGE `order_num` `order_num` int(11) NOT NULL");
	update_option('fix_2_0_2', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}

function upgrade_to_2_0_3() {
	global $wpdb, $pacz_settings, $alsp_instance;
	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
	}
	$prefix = $wpdb->prefix;
	$wpdb->query("ALTER TABLE `".$prefix."alsp_directories` ADD `listingtype_slug` varchar(255) NOT NULL AFTER `category_slug`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_directories` ADD `listingtypes` text NOT NULL AFTER `categories`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `listingtypes` text NOT NULL AFTER `categories`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `listingtype_number` tinyint(1) NOT NULL AFTER `categories_number`");
	$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `unlimited_listingtype` tinyint(1) NOT NULL AFTER `unlimited_categories`");
	if (!$wpdb->get_var("SELECT id FROM `".$prefix."alsp_content_fields` WHERE slug = 'listingtype_list'"))
			$wpdb->query("INSERT INTO `".$prefix."alsp_content_fields` (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `is_hide_name_on_grid`, `is_hide_name_on_list`, `is_hide_name_on_search`, `is_field_in_line`, `on_exerpt_page`, `on_exerpt_page_list`, `on_listing_page`, `on_search_form`, `on_map`, `advanced_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 4, 'Listing Types', 'listingtype_list', '', 'listingtypes', '', 0, 0, 0, 0, 0, 'hide', 'hide', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
	update_option('fix_2_0_3', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}

?>