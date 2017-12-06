<?php namespace classes\Country;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class CountriesFactory{
    private $countries;

    function __construct(){
        $this->loadCountries();
    }

    private function loadCountries(){
        $database = dbCon();
        $countries = array();
        $sql = $database->select("countries", '*');

        if(!empty($sql)){
            foreach($sql as $v){
                $countries[] = new Country($v['iso_code_2']);
            }
        }

        $this->countries = $countries;
    }

    function getCountries(){
        return $this->countries;
    }
}