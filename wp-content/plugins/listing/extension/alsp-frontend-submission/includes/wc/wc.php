<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php

if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_woo_payment' && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	
	add_action('vp_alsp_option_after_ajax_save', 'woo_save_option', 11, 3);
	function woo_save_option($opts, $old_opts, $status) {
		global $alsp_instance;
	
		if ($status) {
			if (get_option('alsp_woocommerce_functionality') && !get_option('alsp_woocommerce_produts_created')) {
				foreach ($alsp_instance->levels->levels_array as $level) {
					$post_id = wp_insert_post( array(
					    'post_title' => 'Listing ' . $level->name,
					    'post_status' => 'publish',
					    'post_type' => "product",
					), true);
					if (!is_wp_error($post_id)) {
						wp_set_object_terms($post_id, 'listing_single', 'product_type');
						update_post_meta($post_id, '_visibility', 'visible');
						update_post_meta($post_id, '_stock_status', 'instock');
						update_post_meta($post_id, 'total_sales', '0');
						update_post_meta($post_id, '_downloadable', 'no');
						update_post_meta($post_id, '_virtual', 'yes');
						update_post_meta($post_id, '_regular_price', '');
						update_post_meta($post_id, '_sale_price', '');
						update_post_meta($post_id, '_purchase_note', '');
						update_post_meta($post_id, '_featured', 'no');
						update_post_meta($post_id, '_weight', '');
						update_post_meta($post_id, '_length', '');
						update_post_meta($post_id, '_width', '');
						update_post_meta($post_id, '_height', '');
						update_post_meta($post_id, '_sku', '');
						update_post_meta($post_id, '_product_attributes', array());
						update_post_meta($post_id, '_sale_price_dates_from', '');
						update_post_meta($post_id, '_sale_price_dates_to', '');
						update_post_meta($post_id, '_price', '');
						update_post_meta($post_id, '_sold_individually', '');
						update_post_meta($post_id, '_manage_stock', 'no');
						update_post_meta($post_id, '_backorders', 'no');
						update_post_meta($post_id, '_stock', '');
	
						update_post_meta($post_id, '_listings_level', $level->id);
					}
				}
				add_option('alsp_woocommerce_produts_created', true);
			}
		}
	}
}

if (alsp_isWooActive()) {
	
	include_once ALSP_FSUBMIT_PATH . 'includes/wc/advert_single_product.php';
	
	global $alsp_instance;

	$alsp_instance->listing_single_product = new alsp_listing_single_product;

	// Remove listings products from the Shop
	add_action('woocommerce_product_query', 'alsp_exclude_products_from_shop');
	function alsp_exclude_products_from_shop($q) {
		$tax_query = (array) $q->get('tax_query');

		$tax_query[] = array(
			'taxonomy' => 'product_type',
			'field' => 'slug',
			'terms' => array('listing_single'),
			'operator' => 'NOT IN'
		);
		
		$q->set('tax_query', $tax_query);
	}
	
	function alsp_format_price($price) {
		if ($price == 0) {
			$out = '<span class="alsp-payments-free">' . __('FREE', 'ALSP') . '</span>';
		} else {
			$out = wc_price($price);
		}
		return $out;
	}
	
	function alsp_recalcPrice($price) {
		global $ALSP_ADIMN_SETTINGS;
		// if any services are free for admins - show 0 price
		if ($ALSP_ADIMN_SETTINGS['alsp_payments_free_for_admins'] && current_user_can('manage_options')) {
			return 0;
		} else
			return $price;
	}


	// WC Dashboard
	add_filter('woocommerce_account_menu_items', 'alsp_account_dashboard_menu');
	function alsp_account_dashboard_menu($items) {
		global $alsp_instance;

		if (isset($alsp_instance->dashboard_page_url) && $alsp_instance->dashboard_page_url) {
			$directory_dashboard['directory_dashboard'] = __('Listings dashboard', 'ALSP');
			array_splice($items, 1, 0, $directory_dashboard);
		}
		
		return $items;
	}
	add_filter('woocommerce_get_endpoint_url', 'alsp_account_dashboard_menu_url', 10, 2);
	function alsp_account_dashboard_menu_url($url, $endpoint) {
		global $alsp_instance;

		if (isset($alsp_instance->dashboard_page_url) && $alsp_instance->dashboard_page_url)
			if ($endpoint == 'directory_dashboard')
				return alsp_dashboardUrl();
		
		return $url;
	}

	add_action('woocommerce_account_dashboard', 'alsp_account_dashboard_content');
	function alsp_account_dashboard_content() {
		global $alsp_instance, $alsp_fsubmit_instance;

		?>
		<?php if (!empty($alsp_instance->submit_pages_all)): ?>
		<p>
			<?php _e("You can submit directory listings.", "ALSP"); ?>
			<br />
			<?php
			if ($alsp_instance->directories->isMultiDirectory()) {
				foreach ($alsp_instance->directories->directories_array AS $directory) {
					echo '<a href="' . alsp_submitUrl(array('directory' => $directory->id)) . '" rel="nofollow">' . sprintf(__('Submit new %s', 'ALSP'), $directory->single) . '</a><br />';
				}
			} else {
				$directory = $alsp_instance->directories->getDefaultDirectory();
				echo '<a href="' . alsp_submitUrl(array('directory' => $directory->id)) . '" rel="nofollow">' . sprintf(__('Submit new %s', 'ALSP'), $directory->single) . '</a>';
			}
			?>
		</p>
		<?php endif; ?>
		<?php 
	}
	
	function alsp_get_last_order_of_listing($listing_id, $actions = array('activation', 'renew', 'upgrade', 'raiseup')) {
		global $wpdb;

		$orders = alsp_get_all_orders_of_listing($listing_id, $actions);
		
		return array_pop($orders);
	}

	function alsp_get_all_orders_of_listing($listing_id, $actions = array('activation', 'renew', 'upgrade', 'raiseup')) {
		global $wpdb;
		
		$sql_meta_actions = '';
		if (!is_array($actions)) {
			$actions = array($actions);
		}
		if ($actions) {
			$sql_meta_actions = "AND woo_meta2.meta_key = '_alsp_action' AND (";
			$meta_actions = array();
			foreach ($actions AS $action) {
				$meta_actions[] = "woo_meta2.meta_value = '" . $action . "'";
			}
			$sql_meta_actions .= implode(' OR ', $meta_actions);
			$sql_meta_actions .= ")";
		}

		$results = $wpdb->get_results(
			$wpdb->prepare("
				SELECT woo_meta.order_item_id AS last_item_id, woo_orders.order_id AS order_id
				FROM {$wpdb->prefix}woocommerce_order_itemmeta AS woo_meta
				LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS woo_orders ON woo_meta.order_item_id = woo_orders.order_item_id
				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS woo_meta2 ON woo_meta.order_item_id = woo_meta2.order_item_id
				WHERE woo_meta.meta_key = '_alsp_listing_id'
				" . $sql_meta_actions . "
				AND woo_meta.meta_value = %d
				GROUP BY order_id
				", $listing_id),
		ARRAY_A);

		$orders = array();
		foreach ($results AS $row) {
			$order = wc_get_order($row['order_id']);
			if (is_object($order) && get_class($order) == 'WC_Order') {
				$orders[] = $order;
			}
		}

		return $orders;
	}
	
	function alsp_get_last_subscription_of_listing($listing_id) {
		global $wpdb;

		$results = $wpdb->get_results($wpdb->prepare("SELECT woo_meta.order_item_id AS last_item_id, woo_orders.order_id AS order_id FROM {$wpdb->prefix}woocommerce_order_itemmeta AS woo_meta LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS woo_orders ON woo_meta.order_item_id = woo_orders.order_item_id WHERE woo_meta.meta_key = '_alsp_listing_id' AND woo_meta.meta_value = %d", $listing_id), ARRAY_A);
		$orders = array();
		foreach ($results AS $row) {
			$order = wc_get_order($row['order_id']);
			if (is_object($order) && get_class($order) == 'WC_Subscription') {
				$orders[] = wc_get_order($row['order_id']);
			}
		}
	
		return array_pop($orders);
	}

	function alsp_set_order_address($order, $user_id) {
		$address = array(
			'first_name' => get_user_meta($user_id, 'billing_first_name', true),
			'last_name'  => get_user_meta($user_id, 'billing_last_name', true),
			'company'    => get_user_meta($user_id, 'billing_company', true),
			'email'      => get_user_meta($user_id, 'billing_email', true),
			'phone'      => get_user_meta($user_id, 'billing_phone', true),
			'address_1'  => get_user_meta($user_id, 'billing_address_1', true),
			'address_2'  => get_user_meta($user_id, 'billing_address_2', true),
			'city'       => get_user_meta($user_id, 'billing_city', true),
			'state'      => get_user_meta($user_id, 'billing_state', true),
			'postcode'   => get_user_meta($user_id, 'billing_postcode', true),
			'country'    => get_user_meta($user_id, 'billing_country', true),
		);
		$order->set_address($address, 'billing');
	}
	
	add_action('alsp_dashboard_links', 'woo_add_orders_dashboard_link');
	function woo_add_orders_dashboard_link() {
		$orders_page_endpoint = get_option('woocommerce_myaccount_orders_endpoint', 'orders');
		$myaccount_page = get_option('woocommerce_myaccount_page_id');
		if ($orders_page_endpoint && $myaccount_page && ($orders_url = wc_get_endpoint_url($orders_page_endpoint, '', get_permalink($myaccount_page)))) {
			$args = array(
			    	'post_status' => 'any',
			    	'post_type' => 'shop_order',
					'posts_per_page' => -1,
					'meta_key' => '_customer_user',
					'meta_value' => get_current_user_id()
			);
			$orders_query = new WP_Query($args);
			wp_reset_postdata();

			echo '<li><a href="' . $orders_url . '">' . __('My orders', 'ALSP'). ' (' . $orders_query->found_posts . ')</a></li>';
		}
	}
	add_filter( 'woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3 );
	function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
		if( ! WC()->cart->is_empty())
			WC()->cart->empty_cart();
		return $passed;
	}
	// Pay order link in listings table
	
	add_action('alsp_listing_status_option', 'woo_pay_order_link');
	function woo_pay_order_link($listing) {
		global $alsp_instance;

		if ($listing->post->post_author == get_current_user_id() && ($listing->status == 'unpaid' || $listing->status == 'expired')) {
			if (($order = alsp_get_last_order_of_listing($listing->post->ID)) && !$order->is_paid() && $order->get_status() != 'trash') {
				if ($alsp_instance->listings_packages->can_user_create_listing_in_level($listing->level->id)) {
					echo '<span><a class="label label-primary" href="' . add_query_arg('apply_listing_payment', $listing->post->ID) . '">' . __('apply payment', 'ALSP') . '</a></span>';
				} else {
					$order_url = $order->get_checkout_payment_url();

					echo '<span><a class="label label-primary" href="' . $order_url . '">' . __('pay order', 'ALSP') . '</a></span>';
				}
			} else {
				if ($alsp_instance->listings_packages->can_user_create_listing_in_level($listing->level->id)) {
					echo '<br /><a href="' . add_query_arg('apply_listing_payment', $listing->post->ID) . '">' . __('apply payment', 'ALSP') . '</a>';
				}
			}
		}
	}
	
	add_action('init', 'woo_apply_payment');
	function woo_apply_payment() {
		global $alsp_instance;

		if (isset($_GET['apply_listing_payment']) && is_numeric($_GET['apply_listing_payment'])) {
			$listing_id = alsp_getValue($_GET, 'apply_listing_payment');
			if ($listing_id && alsp_current_user_can_edit_advert($listing_id)) {
				$listing = alsp_getListing($listing_id);
				if ($listing->status == 'unpaid' || $listing->status == 'expired') {
					if ($alsp_instance->listings_packages->can_user_create_listing_in_level($listing->level->id)) {
						$listing->processActivate(false);
						$alsp_instance->listings_packages->process_listing_creation_for_user($listing->level->id);
						if ($listing->status == 'unpaid')
							alsp_addMessage(__("Listing was successfully activated.", "ALSP"));
						elseif ($listing->status == 'expired')
							alsp_addMessage(__("Listing was successfully renewed and activated.", "ALSP"));
						
						wp_redirect(remove_query_arg('apply_listing_payment'));
						die();
					}
				}
			}
		}
	}
	
	add_action('alsp_listing_info_metabox_html', 'alsp_last_order_listing_link');
	function alsp_last_order_listing_link($listing) {
		if ($order = alsp_get_last_order_of_listing($listing->post->ID)) {
			?>
			<div class="misc-pub-section">
				<?php _e('WC order', 'ALSP'); ?>:
				<?php echo "<a href=". get_edit_post_link($order->get_id()) . ">" . sprintf(__("Order #%d details", "ALSP"), $order->get_id()) . "</a>"; ?>
			</div>
			<?php
		}
	}
	
	// hide meta fields in html-order-item-meta.php
	add_filter('woocommerce_hidden_order_itemmeta', 'alsp_hide_directory_itemmeta');
	function alsp_hide_directory_itemmeta($itemmeta) {
		$itemmeta[] = '_alsp_listing_id';
		$itemmeta[] = '_alsp_action';
		$itemmeta[] = '_alsp_do_subscription';
	
		return $itemmeta;
	}
}

?>