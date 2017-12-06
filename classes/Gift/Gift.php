<?php namespace classes\Gift;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';


class Gift{

	private $id;
	private $userId;
	private $description;
	private $dateCreated;
	private $tokenAmount;
	private $fileName;
	private $product;
	private $type;
	private $receivedUser;
	private $senderUser;

	function __construct($id=null, $userId=null){
		if($userId!=null){
			$this->setUserId($userId);
		}

		if($id!=null){
			$this->setId($id);
			$this->loadGift();
		}

	}

	function sendProductAsGift($data){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();
		$product = new \classes\Product\Product($data['productId']);
		$user = new \classes\User\User($this->userId);
		
		if($product->getPrice() > $user->getTokens()){
			throw new \Exception($translate->getString('tooLittleTokens'));
		}

		if(!$database->insert("gifts", [
										'sender_user_id' => $this->userId,
										'receiving_user_id' => $data['userId'],
										'description' => $data['description'],
										'type' => 2,
										'date_created' => $date
		])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$this->setId($database->id());
		if(!$database->insert("gift_product", ['gift_id' => $this->id, 'product_id' => $product->getId()])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$tokensFinally = $user->getTokens() - $product->getPrice();
		if(!$database->update("customers", ['tokens' => $tokensFinally], ['id' => $this->userId])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}

		//notification
        $data = array("user_id"=>$this->userId, 'receiving_user_id' => $data['userId']);
        $notification = new \classes\Notification\NotificationGift();
        $notification->saveToDB($data);
	}

	function sendTokensAsGift($data){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();
		$user = new \classes\User\User($this->userId);
		if(empty($data['tokenAmount']) || $data['tokenAmount'] == " "){
			throw new \Exception($translate->getString('tokenAmountIsEmpty'));
		}
		if($data['tokenAmount'] > $user->getTokens()){
			throw new \Exception($translate->getString('tooLittleTokens'));
		}
		if(!$database->insert("gifts", [
										'sender_user_id' => $this->userId,
										'receiving_user_id' => $data['userId'],
										'description' => $data['description'],
										'type' => 3,
										'date_created' => $date
		])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$this->setId($database->id());
		if(!$database->insert("gift_tokens", ['gift_id' => $this->id, 'amount' => $data['tokenAmount']])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$tokensFinally = $user->getTokens() - $data['tokenAmount'];
		if(!$database->update("customers", ['tokens' => $tokensFinally], ['id' => $this->userId])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}

		$user = new \classes\User\User($data['userId']);
		$tokensFinally = $user->getTokens() + $data['tokenAmount'];
		if(!$database->update("customers", ['tokens' => $tokensFinally], ['id' => $user->getId()])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}

		//notification
        $data = array("user_id"=>$this->userId, 'receiving_user_id' => $data['userId']);
        $notification = new \classes\Notification\NotificationGift();
        $notification->saveToDB($data);

	}

	function sendFileAsGift($data, $file){
		$database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(isset($file['file']) && !empty($file['file']['name'])){
            switch ($file['file']['type']) {
                case 'video/mp4':
                    $fileGift = new \classes\Video\Video();
                    $fileGift -> upload($file['file'], '/gift_file/');
                    break;
                
                default:
                    $fileGift = new \classes\Photo\Photo();
                    $fileGift -> upload($file['file'], '/gift_file/');
                    break;
            }
        }
        if(!$database->insert("gifts", [
										'sender_user_id' => $this->userId,
										'receiving_user_id' => $data['userId'],
										'description' => $data['description'],
										'type' => 1,
										'date_created' => $date
		])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$this->setId($database->id());
		if(!$database->insert("gift_file", ['gift_id' => $this->id, 'file_name' => $fileGift->getName()])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}

		//notification
        $data = array("user_id"=>$this->userId, 'receiving_user_id' => $data['userId']);
        $notification = new \classes\Notification\NotificationGift();
        $notification->saveToDB($data);
	}

	private function loadGift(){
		$database = dbCon();
		$sql = $database->select("gifts", '*', ['id' => $this->id]);
		$this->setDescription($sql[0]['description']);
		$this->setDateCreated(new \DateTime($sql[0]['date_created']));
		$this->setType($sql[0]['type']);
		$user = new \classes\User\User($sql[0]['receiving_user_id']);
		$this->setReceivedUser($user);
		$user = new \classes\User\User($sql[0]['sender_user_id']);
		$this->setSenderUser($user);
		switch ($sql[0]['type']){
			case 1:
				if($database->has("gift_file", ['gift_id' => $this->id])){
					$sql = $database->select("gift_file", 'file_name', ['gift_id' => $this->id]);
					$this->setFileName($sql[0]);
				}
				break;
			
			case 2:
				if($database->has("gift_product", ['gift_id' => $this->id])){
					$sql = $database-> select("gift_product", 'product_id' ,['gift_id' => $this->id]);
					$product = new \classes\Product\Product($sql[0]);
					$this->setProduct($product);
				}
				break;

			case 3:
				if($database->has("gift_tokens", ['gift_id' => $this->id])){
					$sql = $database->select("gift_tokens", 'amount', ['gift_id' => $this->id]);
					$this->setTokenAmount($sql[0]);
				}
				break;
		}

	}

	private function setUserId($userId){$this->userId = $userId;}
	private function setId($id){$this->id = $id;}
	private function setDescription($description){$this->description = $description;}
	private function setDateCreated(\DateTime $dateCreated){$this->dateCreated = $dateCreated;}
	private function setFileName($fileName){$this->fileName = $fileName;}
	private function setProduct($product){$this->product = $product;}
	private function setTokenAmount($tokenAmount){$this->tokenAmount = $tokenAmount;}
	private function setType($type){$this->type = $type;}
	private function setReceivedUser($receivedUser){$this->receivedUser = $receivedUser;}
	private function setSenderUser($senderUser){$this->senderUser = $senderUser;}

	function getUserId(){return $this->userId;}
	function getId(){return $this->id;}
	function getDescription(){return $this->description;}
	function getDateCreated(){return $this->dateCreated;}
	function getFileName(){return $this->fileName;}
	function getProduct(){return $this->product;}
	function getTokenAmount(){return $this->tokenAmount;}
	function getType(){return $this->type;}
	function getReceivedUser(){return $this->receivedUser;}
	function getSenderUser(){return $this->senderUser;}
}