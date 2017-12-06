<?php namespace classes\Withdrawal;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Withdrawal{

	private $id;
	private $user;
	private $tokens;
	private $dolars;
	private $iban;
	private $swiftBic;
	private $ownerName;
	private $payment;
	private $dateCreated;

	function __construct($id=null){
		if(!empty($id)){
			$this->setId($id);
			$this->loadWithdrawal();
		}
	}

	function updatePayment(){
		$database = dbCon();
		$translate = new \classes\Languages\Translate($_COOKIE['lang']);
		if(!$database->update("tokens_withdrawals", ['payment' => 1], ['id' => $this->id])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
	}

	private function loadWithdrawal(){
		$database = dbCon();
		$sql = $database->select("tokens_withdrawals", '*', ['id' => $this->id]);
		$this->setTokens($sql[0]['tokens']);
		$this->setDolars($sql[0]['dolars']);
		$this->setIban($sql[0]['iban']);
		$this->setSwiftBic($sql[0]['swift_bic']);
		$this->setOwnerName($sql[0]['owner_name'] . ' ' .  $sql[0]['owner_last_name']);
		$this->setPayment($sql[0]['payment']);
		$this->setDateCreated(new \DateTime($sql[0]['date_created']));

		$user = new \classes\User\User($sql[0]['user_id']);
		$this->setUser($user);
	}


	private function setId(int $id){
		$this->id = $id;
	}

	private function setUser(\classes\User\User $user){
		$this->user = $user;
	}

	private function setTokens(int $tokens){
		$this->tokens = $tokens;
	}

	private function setDolars(int $dolars){
		$this->dolars = $dolars;
	}

	private function setIban($iban){
		$this->iban = $iban;
	}

	private function setSwiftBic(string $swiftBic){
		$this->swiftBic = $swiftBic;
	}

	private function setOwnerName(string $ownerName){
		$this->ownerName = $ownerName;
	}

	private function setPayment(int $payment){
		$this->payment = $payment;
	}

	private function setDateCreated(\DateTime $dateCreated){
		$this->dateCreated = $dateCreated;
	}

	function getId(){return $this->id;}
	function getUser(){return $this->user;}
	function getTokens(){return $this->tokens;}
	function getDolars(){return $this->dolars;}
	function getIban(){return $this->iban;}
	function getSwiftBic(){return $this->swiftBic;}
	function getOwnerName(){return $this->ownerName;}
	function getPayment(){return $this->payment;}
	function getDateCreated(){return $this->dateCreated;}


}