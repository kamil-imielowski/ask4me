<?php 
require_once dirname(dirname(__FILE__)).'/config/config.php';

function getCountriesForMap(){
	$database = dbCon();
	$result = array();
	$sql = $database->select("user_model_services_location", 'country_iso_code_2');
	$countryCount = array_count_values($sql);
	foreach($sql as $isoCode){
		$sqlq = $database->select("countries", 'name', ['iso_code_2'=>$isoCode]);
		$result[] = array("iso_code"=>$isoCode, "country_name"=>$sqlq[0], "country_count"=>$countryCount[$isoCode]);
	}
	return $result;
}