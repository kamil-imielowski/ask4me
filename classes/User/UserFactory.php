<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class UserFactory{
	private $users;

	function __construct($type=null){
		$this->loadUsers($type);
	}

	private function loadUsers($type){
		$database = dbCon();

		switch($type){

			case null:
				$sql = $database -> select("customers", '*');
				break;

			case 1:
				$sql = $database -> select("customers", '*', ["type" => 1]);
				break;

			case 2:
				$sql = $database -> select("customers", '*', ["type" => 2]);
				break;

		}

		if(!empty($sql)){
			foreach($sql as $v){
				$users[] = new User($v['id']);
			}
		}

		$this->users = $users;
	}


	function getStandardUsersByString(string $string){
		$database = dbCon();
		$users = array();
		$sql = array();

		$sql = $database->select("customers", 'id', ["AND #1" => ["OR #2" => [
																'login[~]' => $string,
																'name[~]' => $string,
																'surname[~]' => $string
		]], 'type' => 1]);

		foreach ($sql as $k) {
			$users[] = new User($k);
		}
		return $users;
	}

	function getModelUsersByString(string $string){
		$database = dbCon();
		$users = array();
		$sql = array();

		$sql = $database->select("customers", 'id', ["AND #1" => ["OR #2" => [
																'login[~]' => $string,
																'name[~]' => $string,
																'surname[~]' => $string
		]], 'type' => 2]);
 
		foreach ($sql as $k) {
			$user = new \classes\User\ModelUser($k);
            $user->loadCountry();
            $users[] = $user;
            unset($user);
		}

		return $users;
	}

	function getUsers(){
		return $this->users;
	}
}