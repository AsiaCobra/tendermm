<?php

class alsp_stripe extends alsp_payment_gateway
{
	public $secret_key;
	public $publishable_key;

    /**
	 * Initialize the Stripe gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct() {
        parent::__construct();
		global $ALSP_ADIMN_SETTINGS;
        $this->secret_key = $ALSP_ADIMN_SETTINGS['alsp_stripe_live_secret'];
        $this->publishable_key = $ALSP_ADIMN_SETTINGS['alsp_stripe_live_public'];
        
        if ($ALSP_ADIMN_SETTINGS['alsp_stripe_test'])
        	$this->enableTestMode();
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode() {
		global $ALSP_ADIMN_SETTINGS;
        $this->secret_key = $ALSP_ADIMN_SETTINGS['alsp_stripe_test_secret'];
        $this->publishable_key = $ALSP_ADIMN_SETTINGS['alsp_stripe_test_public'];
    }
    
    public function name() {
    	return __('Stripe', 'ALSP');
    }

    public function description() {
    	return __('One time payment by Stripe. After successful transaction listing will become active and raised up.', 'ALSP');
    }
    
    public function buy_button() {
    	return '<img src="' . ALSP_PAYMENTS_RESOURCES_URL . 'images/stripe.png" />';
    }
    
    public function submitPayment($invoice) {
    	include_once ALSP_PAYMENTS_PATH . 'includes/gateways/stripe/init.php';

		\Stripe\Stripe::setApiKey($this->secret_key);

		$token = $_POST['stripe_token'];

		$customer = \Stripe\Customer::create(array(
				'email' => $_POST['stripe_email'],
				'card' => $token
		));

		try {
			$charge = \Stripe\Charge::create(array(
					'customer' => $customer->id,
					'amount' => $invoice->taxesPrice(false)*100,
					'currency' => $ALSP_ADIMN_SETTINGS['alsp_payments_currency']
			));
		} catch(\Stripe\CardErrorTest $e) {
			$body = $e->getJsonBody();
			$err = $body['error'];
			$invoice->logMessage($err['message']);
			return false;
		} catch (\Stripe\InvalidRequestErrorTest $e) {
			$invoice->logMessage("Invalid parameters were supplied to Stripe's API");
			return false;
		} catch (\Stripe\AuthenticationErrorTest $e) {
			$invoice->logMessage("Authentication with Stripe's API failed");
			return false;
		} catch (\Stripe\ApiRequestorTest $e) {
			$invoice->logMessage("Network communication with Stripe failed");
			return false;
		} catch (\Stripe\ErrorTest $e) {
			$invoice->logMessage("Transaction failed");
			return false;
		} catch (Exception $e) {
			$invoice->logMessage("Transaction failed");
			return false;
		}

		if (alsp_create_transaction(
				$this->name(),
				$invoice->post->ID,
				'Completed',
				$charge->id,
				$charge->amount/100,
				0,
				$charge->currency,
				1,
				$charge
		)) {
			if ($invoice->item_object->complete()) {
				$invoice->setStatus('paid');
				$transaction_data = array();
				$keys = $charge->keys();
				foreach ($keys AS $k)
					if (is_string($charge->offsetGet($k)))
						$transaction_data[] = $k . ' = ' . esc_attr($charge->offsetGet($k));
				$invoice->logMessage(sprintf(__('Payment successfully completed. Transaction data: %s', 'ALSP'), implode('; ', $transaction_data)));
			}
		}
	}
}
