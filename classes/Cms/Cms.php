<?php namespace classes\Cms;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Cms{
    
    private $id;
    private $name;
    private $content;
    private $languageCode;

    function __construct($id, $languageCode='pl'){
        $this->setId($id);
        $this->setLanguageCode($languageCode);
        $this->loadContent();
    }

    function saveContent($data){
        $database = dbCon();
        $languages = new \classes\Languages\LanguagesFactory();
        $translate = new \classes\Languages\Translate();
        foreach($languages->getLanguages() as $k){
            if($database->has("cms_info", ["AND" => ['language_code' => $k->getCode(), 'cms_id' => $this->id]])){
                if(!$database->update("cms_info", ['content' => $data[$k->getCode()]], ["AND" => ['language_code' => $k->getCode(), 'cms_id' => $this->id]])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }else{
                if(!$database->insert("cms_info",[
                                                    'content' => $data[$k->getCode()],
                                                    'language_code' => $k->getCode(),
                                                    'cms_id' => $this->id
                ])){
                    throw new \Exception($translate->getString("error-DBInsert"));
                }
            }
        }
    }

    private function loadContent(){
        $database = dbCon();
        if($database->has("cms_info", ["AND" => ['cms_id' => $this->id, 'language_code' => $this->languageCode]])){
            $sql = $database->select("cms_info", '*', ["AND" => ['cms_id' => $this->id, 'language_code' => $this->languageCode]]);
            $this->setName($sql[0]['name']);
            $this->setContent($sql[0]['content']);
        }
    }

    private function setId($id){$this->id = $id;}
    private function setLanguageCode($languageCode){$this->languageCode = $languageCode;}
    private function setName($name){$this->name = $name;}
    private function setContent($content){$this->content = $content;}

    function getId(){return $this->id;}
    function getLanguageCode(){return $this->languageCode;}
    function getName(){return $this->name;}
    function getContent(){return $this->content;}
}