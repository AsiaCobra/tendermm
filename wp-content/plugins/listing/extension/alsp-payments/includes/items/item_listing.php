<?php

class alsp_item_listing {
	public $name = 'listing';
	public $item_id;
	
	public function __construct($item_id) {
		$this->item_id = $item_id;
	}
	
	public function getItem() {
		$listing_id = $this->item_id;

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$listing_id = apply_filters('wpml_object_id', $listing_id, ALSP_POST_TYPE, true);
		}
		
		$listing = new alsp_listing();
		if ($listing->loadListingFromPost($listing_id)) {
			return $listing;
		} else {
			return false;
		}
	}
	
	public function getItemLink() {
		if (($listing = $this->getItem()) && alsp_current_user_can_edit_advert($listing->post->ID)) {
			if (current_user_can('edit_published_posts')) {
				return '<a href="' . alsp_get_edit_advert_link($listing->post->ID) . '">' . $listing->title() . '</a>';
			} else { 
				return $listing->title();
			}
		} else {
			return __('N/A', 'ALSP');
		}
	}

	public function getItemEditLink() {
		if ($listing = $this->getItem()) {
			$listing_id = $listing->post->ID;
			return '<a href="' . apply_filters('alsp_get_edit_advert_link', get_edit_post_link($listing_id), $listing_id) . '">' . $listing->title() . '</a>';
		} else {
			return __('N/A', 'ALSP');
		}
	}
	
	public function getItemOptions() {
		if ($listing = $this->getItem()) {
			return array('active_interval' => $listing->level->active_interval, 'active_period' => $listing->level->active_period);
		} else {
			return __('N/A', 'ALSP');
		}
	}
	
	public function getItemOptionsString() {
		if ($listing = $this->getItem()) {
			return __('Active period - ', 'ALSP') . $listing->level->getActivePeriodString();
		} else {
			return __('N/A', 'ALSP');
		}
	}

	public function complete() {
		if ($listing = $this->getItem()) {
			return $listing->processActivate(false);
		}
	}
}

function getInvoicesByListingId($listing_id) {
	$listing = new alsp_listing();
	if (!$listing->loadListingFromPost($listing_id)) {
		return false;
	}

	$children = get_children(array('post_parent' => $listing_id, 'post_type' => ALSP_INVOICE_TYPE, 'post_status' => 'publish'));

	$invoices = array();
	if (is_array($children) && count($children) > 0)
		foreach ($children as $child) {
		$invoice = new alsp_invoice();
		$invoice->post = $child;
		$invoice->listing = $listing;
		$invoice->init();
		$invoices[] = $invoice;
	}
	return $invoices;
}

function getLastInvoiceByListingId($listing_id) {
	if ($invoices = getInvoicesByListingId($listing_id)) {
		return array_shift($invoices);
	} else {
		return false;
	}
}

add_action('alsp_listing_status_option', 'alsp_pay_invoice_link');
function alsp_pay_invoice_link($listing) {
	if ($listing->status == 'unpaid') {
		if (($invoice = getLastInvoiceByListingId($listing->post->ID)) && alsp_current_user_can_edit_advert($invoice->post->ID) && current_user_can('edit_published_posts'))
			echo '<span><a class="label label-primary" href="' . alsp_get_edit_invoice_link($invoice->post->ID) . '" title="' . esc_attr($invoice->post->post_title) . '">' . __('pay invoice', 'ALSP') . '</a></span>';
	}
}

add_filter('alsp_listing_creation', 'alsp_create_new_listing_invoice');
add_filter('alsp_listing_creation_front', 'alsp_create_new_listing_invoice');
function alsp_create_new_listing_invoice($listing) {
	if ($listing) {
		if (recalcPrice($listing->level->price) > 0) {
			$invoice_args = array(
					'item' => 'listing',
					'title' => sprintf(__('Invoice for activation of listing: %s', 'ALSP'), $listing->title()),
					'is_subscription' => ($listing->level->eternal_active_period) ? false : true,
					'price' => $listing->level->price,
					'item_id' => $listing->post->ID,
					'author_id' => $listing->post->post_author
			);
			if ($invoice_id = call_user_func_array('alsp_create_invoice', $invoice_args)) {
				alsp_addMessage(__('New invoice was created successfully, listing become active after payment', 'ALSP'));
				update_post_meta($listing->post->ID, '_listing_status', 'unpaid');
				wp_update_post(array('ID' => $listing->post->ID, 'post_status' => 'pending'));
	
				if (is_user_logged_in() && alsp_current_user_can_edit_advert($invoice_id) && $edit_invoice_link = alsp_get_edit_invoice_link($invoice_id, 'url')) {
					wp_redirect(apply_filters('redirect_post_location', $edit_invoice_link, $invoice_id));
					die();
				}
			}
		}
	}
	return $listing;
}

add_filter('alsp_listing_renew', 'alsp_renew_listing_invoice', 10, 3);
function alsp_renew_listing_invoice($continue, $listing, $continue_invoke_hooks) {
	if ($continue_invoke_hooks[0]) {
		if (($invoice = getLastInvoiceByListingId($listing->post->ID)) && $invoice->status == 'unpaid') {
			if (is_user_logged_in() && alsp_current_user_can_edit_advert($invoice->post->ID) && !is_admin()) {
				wp_redirect(apply_filters('redirect_post_location', alsp_get_edit_invoice_link($invoice->post->ID, 'url'), $invoice->post->ID));
				die();
			}
			return false;
		} else {
			if (recalcPrice($listing->level->price) > 0) {
				$invoice_args = array(
						'item' => 'listing',
						'title' => sprintf(__('Invoice for renewal of listing: %s', 'ALSP'), $listing->title()),
						'is_subscription' => ($listing->level->eternal_active_period) ? false : true,
						'price' => $listing->level->price,
						'item_id' => $listing->post->ID,
						'author_id' => $listing->post->post_author
				);
				if ($invoice_id = call_user_func_array('alsp_create_invoice', $invoice_args)) {
					if (is_user_logged_in()) {
						alsp_addMessage(sprintf(__('New <a href="%s">invoice</a> was created successfully, listing become active after payment', 'ALSP'), alsp_get_edit_invoice_link($invoice_id, 'url')));
					}
	
					if ($listing->status == 'expired') {
						update_post_meta($listing->post->ID, '_listing_status', 'unpaid');
					}
	
					return false;
				}
			} else
				return $continue;
		}
	}

	return $continue;
}

?>