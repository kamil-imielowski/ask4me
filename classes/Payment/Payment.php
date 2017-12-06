<?php namespace classes\Payment;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Payment{

	protected $order;

	function __construct($orderId=null){
		if($orderId != null){
			$order = new \classes\Order\Order(null, $orderId);
			$this->setOrder($order);
		}
	}



	function uploadPaymentStatus(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();
		if(!$database->has("orders", ['id'=> $this->order->getId()])){
			throw new \Exception($translate->getString("nExist"));
		}
		//if(!$database->update("orders", ['payment' => 1], ['id' => $this->order->getId()])){
		//	throw new \Exception($translate->getString("error-DBUpdate"));
		//}

		$sql = $database->select("order_info",'product_id',['order_id' => $this->order->getId()]);
		foreach ($sql as $k) {
			$product = new \classes\Product\Product($k);
			switch ($product->getType()) {
				case '1'://basic
					if($database->has("memberships", ['user_id' => $this->order->getUserId()])){
						if(!$database->update("memberships",[
														
														'type' => 1,
														'valid_to' => date("Y-m-d H:i:s", strtotime("+1 month", strtotime($date))),
														'date_created' => $date

						],['user_id' => $this->order->getUserId()])){
							throw new \Exception($translate->getString("error-DBUpdate"));
						}
					}else{
						if(!$database->insert("memberships",[
														'user_id' => $this->order->getUserId(),
														'type' => 1,
														'valid_to' => date("Y-m-d H:i:s", strtotime("+1 month", strtotime($date))),
														'date_created' => $date

						])){
							throw new \Exception($translate->getString("error-DBInsert"));
						}
						if(!$database->update("customers", ['membership' => $database->id()], ['id' => $this->order->getUserId()])){
							throw new \Exception($translate->getString("error-DBUpdate"));
						}
					}
					
					break;

				case '2'://vip
					if($database->has("memberships", ['user_id' => $this->order->getUserId()])){
						if(!$database->update("memberships",[
														
														'type' => 2,
														'valid_to' => date("Y-m-d H:i:s", strtotime("+1 month", strtotime($date))),
														'date_created' => $date

						],['user_id' => $this->order->getUserId()])){
							throw new \Exception($translate->getString("error-DBUpdate"));
						}
					}else{
						if(!$database->insert("memberships",[
														'user_id' => $this->order->getUserId(),
														'type' => 2,
														'valid_to' => date("Y-m-d H:i:s", strtotime("+1 month", strtotime($date))),
														'date_created' => $date

						])){
							throw new \Exception($translate->getString("error-DBInsert"));
						}
						if(!$database->update("customers", ['membership' => $database->id()], ['id' => $this->order->getUserId()])){
							throw new \Exception($translate->getString("error-DBUpdate"));
						}
					}
					break;

				case 3://tokens
					$sql = $database->select("tokens", 'tokens', ['product_id' => $product->getId()]);
					break;
			}
		}
	}

	protected function setOrder(\classes\Order\Order $order){
		$this->order = $order;
	}
}