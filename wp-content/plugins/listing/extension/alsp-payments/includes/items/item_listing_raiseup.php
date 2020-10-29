<?php

class alsp_item_listing_raiseup extends alsp_item_listing {
	public $name = 'listing_raiseup';
	
	public function getItemOptions() {
		return false;
	}

	public function complete() {
		if ($listing = $this->getItem()) {
			return $listing->processRaiseUp(false);
		}
	}
}

add_filter('alsp_listing_raiseup', 'alsp_create_raiseup_listing_invoice', 10, 3);
function alsp_create_raiseup_listing_invoice($continue, $listing, $continue_invoke_hooks) {
	if ($continue_invoke_hooks[0]) {
		if (recalcPrice($listing->level->raiseup_price) > 0) {
			if (!($invoice_id = get_post_meta($listing->post->ID, '_listing_raiseup_invoice', true))) {
				$invoice_args = array(
						'item' => 'listing_raiseup',
						'title' => sprintf(__('Invoice for raise up of listing: %s', 'ALSP'), $listing->title()),
						'is_subscription' => false,
						'price' => $listing->level->raiseup_price,
						'item_id' => $listing->post->ID,
						'author_id' => $listing->post->post_author
				);
				if ($invoice_id = call_user_func_array('alsp_create_invoice', $invoice_args)) {
					alsp_addMessage(sprintf(__('New <a href="%s">invoice</a> was created successfully, listing will be raised up after payment', 'ALSP'), alsp_get_edit_invoice_link($invoice_id, 'url')));
					update_post_meta($listing->post->ID, '_listing_raiseup_invoice', $invoice_id);
					return false;
				}
			}
		} else {
			return $continue;
		}
	}

	return $continue;
}

?>