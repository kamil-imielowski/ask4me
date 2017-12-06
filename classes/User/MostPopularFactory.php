<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class MostPopularFactory{

	private $mostPopularCamModels;
	private $users;

	function getMostPopularCamModels(){
		$database = dbCon();
		$sql = $database->distinct()->select("transmissions", 
															["[>]transmission_tips"=>["id"=>"transmision_id"]],
															['transmissions.user_id'],
															["ORDER"=>["transmission_tips.amount"],
															"LIMIT"=>50]
														);
		$this->loadUsers($sql);
		return $this->users;
	}

	function getMostPopularEscortModels(){
		$database = dbCon();
		$sql = $database->select("visites_profiles", 'visited_id');
		$sql = array_count_values($sql);
		arsort($sql);
		array_slice($sql, 49);
		$users = array();
		if(!empty($sql)){
			foreach($sql as $k => $val){
				$user = new \classes\User\User($k); 
				$user->loadCountry();
				$users[] = $user;
				unset($user);
			}
		}
		return $users;
	}

	private function loadUsers($sql){
		$users = array();
		if(!empty($sql)){
			foreach($sql as $k){
				$user = new \classes\User\User($k['user_id']); 
				$user->loadCountry();
				$users[] = $user;
				unset($user);
			}
		}
		$this->users = $users;
	}
}