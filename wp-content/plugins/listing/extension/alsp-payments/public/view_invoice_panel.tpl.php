<div class="alsp-directory-frontpanel">
			<script>
				var window_width = 860;
				var window_height = 800;
				var leftPosition, topPosition;
				(function($) {
					"use strict";

					leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
					topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
				})(jQuery);
			</script>
			<input type="button" class="alsp-print-listing-link btn btn-primary" onclick="window.open('<?php echo esc_url(add_query_arg('invoice_id', $public_control->invoice->post->ID, alsp_directoryUrl(array('alsp_action' => 'alsp_print_invoice')))); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');" value="<?php esc_attr_e('Print invoice', 'ALSP'); ?>" />
			
			<?php if ($public_control->invoice->gateway): ?>
			<input type="button" class="alsp-reset-link btn btn-primary" onclick="window.location='<?php echo esc_url(add_query_arg('invoice_action', 'reset_gateway', alsp_get_edit_invoice_link($public_control->invoice->post->ID))); ?>';" value="<?php esc_attr_e('Reset gateway', 'ALSP'); ?>" />
			<?php endif; ?>
		</div>
		<br>
		<div class="alsp-submit-section alsp-submit-section-invoice-info">
			<h4 class="alsp-submit-section-label"><?php _e('Invoice Info', 'ALSP'); ?></h4>
			<div class="alsp-submit-section-inside">
				<?php alsp_renderTemplate(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $public_control->invoice)); ?>
			</div>
		</div>

		<?php if ($public_control->invoice->isPaymentMetabox()): ?>
		<div class="alsp-submit-section alsp-submit-section-payments">
			<h3 class="alsp-submit-section-label"><?php _e('Select a payment gateway', 'ALSP'); ?></h3>
			<div class="alsp-submit-section-inside">
				<?php alsp_renderTemplate(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'payment_metabox.tpl.php'), array('invoice' => $public_control->invoice, 'paypal' => $public_control->paypal, 'paypal_subscription' => $public_control->paypal_subscription, 'bank_transfer' => $public_control->bank_transfer, 'stripe' => $public_control->stripe)); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="alsp-submit-section alsp-submit-section-invoice-log">
			<h3 class="alsp-submit-section-label"><?php _e('Invoice Log', 'ALSP'); ?></h3>
			<div class="alsp-submit-section-inside">
				<?php alsp_renderTemplate(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $public_control->invoice)); ?>
			</div>
		</div>

		<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'invoices')); ?>" class="btn btn-primary"><?php _e('View all invoices', 'ALSP'); ?></a>