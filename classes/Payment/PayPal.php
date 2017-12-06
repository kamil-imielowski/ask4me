<?php namespace classes\Payment;

class PayPal extends Payment{

	function __construct($order){
		parent::setOrder($order);

		$apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            'AVsXtDvrt8LOhdwNd7NbF2EUKRWFcf1ZsE-lzCJkhjs6lXrAGa9XpL952qd2QuO8Iw7NKLXptRVnpXhd',     // ClientID
	            'EILF32o7x9iFQ4vrsJ2lul3h9xIBeUsM82MGwfoFtVYMPcJ5TJGqkqCzP__let1Gm1VesxujmwviLTiE'      // ClientSecret
	        )
		);
		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod("paypal");

		$details = new \PayPal\Api\Details();
		$details->setTax(0);

		$amount = new \PayPal\Api\Amount();
		$amount->setCurrency("USD")
		    ->setTotal($order->getTotalPrice())
		    ->setDetails($details);

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount)
		    ->setDescription("Płatność ask4me")
		    ->setInvoiceNumber(uniqid());

		$baseUrl = "http://" . $_SERVER['SERVER_NAME'];
		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true&orderId=".$order->getId())
		    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));
		try {
		    $payment->create($apiContext);
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
		        var_dump(json_decode($ex->getData()));
    			exit(1);
		}
		$approvalUrl = $payment->getApprovalLink();

		header("Location: $approvalUrl");

		return $payment;
	}

}