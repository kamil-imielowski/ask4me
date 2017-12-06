<?php namespace classes\Message;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Conversation{

	private $recipient;
	private $sender;
	private $conversation;

	function __construct(int $sender=null, int $recipient=null){
		if(!empty($sender) && !empty($recipient)){
			$this->setSender($sender);
			$this->setRecipient($recipient);
			$this->loadConversation();
		}
	}

	function markAsRead(){
		$database = dbCon();
		$sql = array();
		
		$sql = $database->select("messages", 'id', [
													"OR #1" => [
														"AND #2" => [
															'user_id_from' => $this->sender,
															'user_id_to' => $this->recipient,
															'readed' => 0
														],
														"AND #3" => [
															'user_id_from' => $this->recipient,
															'user_id_to' => $this->sender,
															'readed' => 0
														]
													]
												]);

		foreach($sql as $k){
			$message = new Message($k);
			$message->markAsRead();
		}
	}

	private function loadConversation(){
		$database = dbCon();
		$sql = array();
		$conversation = array();
		
		$sql = $database->select("messages", '*', [
													"OR #1" => [
														"AND #2" => [
															'user_id_from' => $this->sender,
															'user_id_to' => $this->recipient
														],
														"AND #3" => [
															'user_id_from' => $this->recipient,
															'user_id_to' => $this->sender
														]
													]
												]);
		$sql = array_slice($sql, -50);

		foreach($sql as $k){
			$sender = new \classes\User\User($k['user_id_from']);
			$recipient = new \classes\User\User($k['user_id_to']);

			$dateCreated = new \DateTime($k['date_created']);
			$conversation[] = new \classes\Message\Message($k['id'], array("user_from"=>$sender, "user_to"=>$recipient, "date_created"=>$dateCreated, "message"=>$k['message'], "readed"=>$k['readed']));
		}
		$this->conversation = $conversation;
	}

	private function setSender(int $sender){
		$this->sender = $sender;
	}

	private function setRecipient(int $recipient){
		$this->recipient = $recipient;
	}

	private function setConversation(array $conversation){
		$this->conversation = $conversation;
	}

	function getConversation(){return $this->conversation;}
}
