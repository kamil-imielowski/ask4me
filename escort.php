<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
require_once dirname(__FILE__).'/functions/cityForMap.php';
$translate = new classes\Languages\Translate();
if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}
#languages
$languages = new \classes\Languages\LanguagesFactory();
$languages = $languages->getLanguages();

#countries
$countries = new \classes\Country\CountriesFactory();
$countries = $countries->getCountries();

#categories
$categories = new \classes\Categories\CategoriesFactory();

#countries for map
$countriesForMap = getCountriesForMap();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'getEscortWithFilters':
			$EF = new classes\User\EscortFactory($_POST);
			$escorts = $EF->getUsers();
			$filters = $_POST;
			include dirname(__FILE__).'/templates/escort.html.php';
			break;

		case 'addCountryToFilters':
			$filters = array("country" => $_GET['country'],
								"sex" => 'all',
								"partner_preferences" => 'all',
								"looks_age" => 'all',
								"language" => 'all',
								"skin_color" => 'all',
								"body_build" => 'all',
								"eyes_color" => 'all',
								"hair_color" => 'all',
								"category" => 'all'
			);
			$EF = new classes\User\EscortFactory($filters);
			$escorts = $EF->getUsers();
			include dirname(__FILE__).'/templates/escort.html.php';
			break;

	}
}else{
	
	#escorts
	$EF = new classes\User\EscortFactory();
	$escorts = $EF->getUsers();

	include dirname(__FILE__).'/templates/escort.html.php';
}


?>