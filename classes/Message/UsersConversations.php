<?php namespace classes\Message;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class UsersConversations{

	private $user;
	private $UsersConversations;
	private $conversationsSomeDetails;

	function __construct(\classes\User\User $user){
		$this->setUser($user);
		$this->loadUsersConversations();
	}

	private function loadUsersConversations(){
		$database = dbCon();
		$sql = array();
		$UsersConversations = array();
		$conversationsSomeDetails = array();
		$sql = $database->distinct()->select("messages", 'user_id_to', ['user_id_from'=>$this->user->getId()]);
		$sqlq = $database->distinct()->select("messages", 'user_id_from', ['user_id_to'=>$this->user->getId()]);

		$result = array_merge($sql, $sqlq);
		$result = array_unique($result);
		
		foreach ($result as $k) {
			$user = new \classes\User\User($k);
			$conversationsSomeDetails[] = new ConversationSomeDetail($user);
			$UsersConversations[] = $user;
		}
		$this->setUsersConversations($UsersConversations);
		$this->setConversationsSomeDetails($conversationsSomeDetails);
	}

	private function setUser($user){
		$this->user = $user;
	}

	private function setUsersConversations(array $UsersConversations){
		$this->UsersConversations = $UsersConversations;
	}

	private function setConversationsSomeDetails(array $conversationsSomeDetails){
		$this->conversationsSomeDetails = $conversationsSomeDetails;
	}

	function getUsersConversations(){
		return $this->UsersConversations;
	}

	function getConversationsSomeDetails(){
		return $this->conversationsSomeDetails;
	}

	function getCountUnreadedMessages(){
		$countUnreadedMessages = 0;
		foreach ($this->conversationsSomeDetails as $conversation) {
			if($conversation->getReaded()==0){
	            $countUnreadedMessages++;
	        }
		}
		return $countUnreadedMessages;
	}
}