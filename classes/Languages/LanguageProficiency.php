<?php namespace classes\Languages;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class LanguageProficiency{

    private $userId;
    private $code;
    private $proficiencyId;
    private $proficiencyName;


    function __construct($user_id, $code){
        $this->setUserId($user_id);
        $this->setCode($code);
        $this->loadProficiency();
    } 

    private function loadProficiency(){
        $database = dbCon();
        $sql = $database -> select("user_model_languages", 'id_proficiency_language', ["AND" => ['user_id' => $this->userId, 'language_code' => $this->code]]);

        if(!empty($sql)){
            $this->setProficiencyID($sql[0]);
            $sql = $database -> select("proficiency_language", 'name', ['id' => $this->proficiencyId]);
            $this->setProficiencyName($sql[0]);
        }
    }

    private function setUserId($userId){$this->userId = $userId;}
    private function setCode($code){$this->code = $code;}
    private function setProficiencyId($proficiencyId){$this->proficiencyId = $proficiencyId;}
    private function setProficiencyName($proficiencyName){$this->proficiencyName = $proficiencyName;}


    function getProficiencyId(){return $this->proficiencyId;}
    function getProficiencyName(){return $this->proficiencyName;}
}