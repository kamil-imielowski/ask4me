<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
require_once dirname(__FILE__).'/functions/cityForMap.php';

$translate = new classes\Languages\Translate();

#languages
$languages = new \classes\Languages\LanguagesFactory();
$languages = $languages->getLanguages();

#countries
$countries = new \classes\Country\CountriesFactory();
$countries = $countries->getCountries();

#countries for map
$countriesForMap = getCountriesForMap();
if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'value':
            # code...
            break;
    }
}else{
	if(isset($_SESSION['user'])){
		$user = unserialize(base64_decode($_SESSION['user']));
	}
	$mostPopularModels = new \classes\User\MostPopularFactory();
    include dirname(__FILE__).'/templates/index.html.php';
}


?>