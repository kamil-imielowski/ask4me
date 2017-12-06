<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

#languages
$languages = new \classes\Languages\LanguagesFactory();
$languages = $languages->getLanguages();

#countries
$countries = new \classes\Country\CountriesFactory();
$countries = $countries->getCountries();

#categories
$categories = new \classes\Categories\CategoriesFactory();

#escorts
$TF = new \classes\Transmissions\TransmissionsFactory();
$transmissions = $TF->getTransmissions();

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}

#categories
$categories = new \classes\Categories\CategoriesFactory();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {

		case 'getEscortWithFilters':
			$TF = new \classes\Transmissions\TransmissionsFactory($_POST);
			$transmissions = $TF->getTransmissions();
			$filters = $_POST;
			include dirname(__FILE__).'/templates/live-cams.html.php';
			break;
	}
}else{
	include dirname(__FILE__).'/templates/live-cams.html.php';
}
