<?php namespace classes\Settings;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Setting{

	private $key;
	private $value;

	function __construct($key=null){
		if(!empty($key)){
			$this->setKey($key);
			$this->loadSetting();
		}
	}

	function saveSetting($value){
		$database = dbCon();
		echo $value;
		if(!$database->update("settings",['value' => $value], ['setting_key' => $this->key])){
			throw new \Exception("Błąd podczas aktualizacji");
		}
	}

	private function loadSetting(){
		$database = dbCon();
		$sql = $database->select("settings", 'value', ['setting_key' => $this->key]);
		if(!empty($sql)){
			$this->setValue($sql[0]);
		}
	}

	private function setKey($key){
		$this->key = $key;
	}

	private function setValue($value){
		$this->value = $value;
	}

	function getKey(){
		return $this->key;
	}

	function getValue(){
		return $this->value;
	}
}