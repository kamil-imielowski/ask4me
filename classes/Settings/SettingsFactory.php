<?php namespace classes\Settings;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class SettingsFactory{

	function getPriceForToken(){
		$database = dbCon();
		$sql = $database->select("settings", 'value', ['setting_key' => 'price_for_token']);
		return $sql[0];
	}

}