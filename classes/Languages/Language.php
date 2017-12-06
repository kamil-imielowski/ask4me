<?php namespace classes\Languages;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class Language{
    private $id;
    private $name;
    private $code;
    private $proficiency;

    function __construct($code = null){
        if(!empty($code)){
            $this->code = $code;
            $this->loadLanguage();
        }
    }

    private function loadLanguage(){
        $database = dbCon();
        $sql = $database->select("languages", '*', ["code" => $this->code]);
        if(empty($sql)){
            throw new \Exception($translate->getString('nExist'));
        }
        foreach($sql as $v){
            $this->setId($v['id']);
            $this->setName($v['name']);
        }
    }

    function loadProficiency($userId){
        $database = dbCon();
        $proficiency = new LanguageProficiency($userId, $this->code);
        $this->setProficiency($proficiency);
    }

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getCode(){
        return $this->code;
    }
    function getProficiency(){
        return $this->proficiency;
    }

    private function setProficiency($proficiency){
        $this->proficiency = $proficiency;
    }
    private function setId($id){
        $this->id = $id;
    }
    private function setName($name){
        $this->name = $name;
    }
    private function setCode($code){
        $this->code = $code;
    }
}