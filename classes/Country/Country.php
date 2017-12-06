<?php namespace classes\Country;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Country{
    private $id;
    private $name;
    private $isoCode1; # eg. 616
    private $isoCode2; # eg. "PL"
    private $isoCode3; # eh. "POL"
    private $languageCode;
    private $cityOrRegion;

    function __construct($isoCode2 = null){
        if(!empty($isoCode2)){
            $this->setIsoCode2($isoCode2);
            $this->loadCountry();
        }
    }

    private function loadCountry(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $sql = $database->select("countries", '*', ["iso_code_2" => $this->getIsoCode2()]);
        if(empty($sql)){
            throw new \Exception($translate->getString("nExist"));
        }
        foreach($sql as $v){
            $this->setId($v['id']);
            $this->setName($v['name']);
            $this->setIsoCode1($v['iso_code_1']);
            $this->setIsoCode2($v['iso_code_2']);
            $this->setIsoCode3($v['iso_code_3']);
            $this->setLanguageCode($v['language_code']);
        }
    }

    function loadCityOrRegion($userId){
        $database = dbCon();
        $sql = $database -> select("user_model_services_location", 'city_or_region', ["AND"=>['user_id' => $userId, 'country_iso_code_2' => $this->getIsoCode2()]]);
        $this -> setCityOrRegion($sql[0]);
    }

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getIsoCode1(){
        return $this->isoCode1;
    }
    function getIsoCode2(){
        return $this->isoCode2;
    }
    function getIsoCode3(){
        return $this->isoCode3;
    }
    function getLanguageCode(){
        return $this->languageCode;
    }
    function getCityOrRegion(){
        return $this->cityOrRegion;
    }

    private function setId($id){
        $this->id = $id;
    }
    private function setName($name){
        $this->name = $name;
    }
    private function setIsoCode1($isoCode1){
        $this->isoCode1 = $isoCode1;
    }
    private function setIsoCode2($isoCode2){
        $this->isoCode2 = $isoCode2;
    }
    private function setIsoCode3($isoCode3){
        $this->isoCode3 = $isoCode3;
    }
    private function setLanguageCode($languageCode){
        $this->languageCode = $languageCode;
    }
    private function setCityOrRegion($cityOrRegion){
        $this->cityOrRegion = $cityOrRegion;
    }

}