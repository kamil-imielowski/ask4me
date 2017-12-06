<?php namespace classes\Languages;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class LanguagesFactory{
    private $languages;

    function __construct(){
        $this->loadLanguages();
    }

    private function loadLanguages(){
        $database = dbCon();
        $languages = array();

        $sql = $database->select("languages", '*');
        if(!empty($sql)){
            foreach($sql as $v){
                $languages[] = new Language($v['code']);
            }
        }

        $this->languages = $languages;
    }

    function getLanguages(){
        return $this->languages;
    }
}