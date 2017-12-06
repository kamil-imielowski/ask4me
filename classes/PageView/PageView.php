<?php namespace classes\PageView;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PageView 
{
	public $views;

	function wyswietlenia(){
		$od = array();
		$database = dbCon();
		$sql = $database -> select("pageview", "*" , ["ORDER" => "data"]);
		foreach($sql as &$v){
			if(isset($od[$v['data']]))
				$od[$v['data']]++;
			else
				$od[$v['data']] = 1;
		}
		$this->views = $od;
		return $this->views;
	}
	
	function searchForId($id, $array) {
		//$key = searchForId($v['data'], $od); - wywolanie przy funkcji wyswietlenia
	   foreach ($array as $key => $val) {
		   if ($array[$key]['data'] == $id) {
			   return true;
		   }
	   }
	   return false;
	}
	
	function addUniqueUserIP(){
		$database = dbCon();
		
		$user_ip=$_SERVER['REMOTE_ADDR'];
		
		$sql = $database -> select("pageview", ["user_ip", "data"], ["user_ip" => $user_ip]);
		
		$insert = true;
		foreach($sql as &$v){
			if($v['data'] == date("Y-m-d")){
				$insert = false;
			}
		}
		
		if($insert == false){
			
		}else{
			$database -> insert("pageview",["user_ip" => $user_ip, "data" => date("Y-m-d")]);
		}
		
		$_SESSION['sprawdzony'] = true; //zeby nie powielac wykonania funkcji
	}
}