<?php 
require_once dirname(dirname(__FILE__)).'/config/config.php';

function getCountriesForMap(){
	$database = dbCon();
	$sql = $database->select("user_model_services_location", 'country_iso_code_2');

	return $sql;
}