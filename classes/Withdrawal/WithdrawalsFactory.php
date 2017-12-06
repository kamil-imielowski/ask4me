<?php namespace classes\Withdrawal;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class WithdrawalsFactory{

	private $withdrawals;

	function __construct($userId=null){
		if(!empty($userId)){
			$this->loadUserWithdrawals($userId);
		}else{
			$this->loadWithdrawals();
		}
	}

	private function loadUserWithdrawals($userId){
		$database = dbCon();
		$sql = array();
		$withdrawals = array();
		$sql = $database->select("tokens_withdrawals", 'id', ['user_id' => $userId]);

		$this->setWithdrawals($sql);
	}

	private function loadWithdrawals(){
		$database = dbCon();
		$sql = array();
		$withdrawals = array();
		$sql = $database -> select("tokens_withdrawals", 'id');

		$this->setWithdrawals($sql);
	}

	private function setWithdrawals($sql){
		$withdrawals = array();
		if(!empty($sql)){
			foreach($sql as $k){
				$withdrawals[] = new \classes\Withdrawal\Withdrawal($k); 
			}
		}
		$this->withdrawals = $withdrawals;
	}

	function getWithdrawals(){
		return $this->withdrawals;
	}

	function getLastWithdrawal(){
		return end($this->withdrawals);
	}
}