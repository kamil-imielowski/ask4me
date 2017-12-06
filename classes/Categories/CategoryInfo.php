<?php namespace classes\Categories;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class CategoryInfo{ 
    private $id;
    private $categoryId;
    private $languageCode;
    private $language;
    private $name;

    function __construct($categoryId, $languageCode){
        $database = dbCon();
        $this->categoryId = $categoryId;
        $this->languageCode = $languageCode;
        if($database->has("categories_info", ["AND" => ["category_id" => $categoryId, "language_code" => $languageCode]])){
            $this->loadCategoryInfo();
        }
    }

    private function loadCategoryInfo(){
        $database = dbCon();
        $sql = $database->select("categories_info", '*', ["AND" => ["category_id" => $this->categoryId, "language_code" => $this->languageCode]]);
        foreach($sql as $v){
            $this->setId($v['id']);
            $this->setLanguage(new \classes\Languages\Language($this->languageCode));
            $this->setName($v['name']);
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if(!empty($this->id)){
            #update
            if(!$database->update("categories_info", ["name" => $data['name'], "date_updated" => $date], ['id' => $this->id])){
                throw new \Exception($translate->getString('error-DBUpdate'));
            }
        }else{
            #insert
            if(!$database->insert("categories_info", ["language_code" => $this->languageCode, "category_id" => $this->categoryId, "name" => $data['name'], "date_created" => $date, "date_updated" => $date])){
                throw new \Exception($translate->getString('error-DBInsert'));
            }
            $this->id = $database->id();
        }
    }

    function getId(){
        return $this->id;
    }
    function getCategoryId(){
        return $this->categoryId;
    }
    function getLanguageCode(){
        return $this->languageCode;
    }
    function getLanguage(){
        return $this->language;
    }
    function getName(){
        return $this->name;
    }

    private function setId($id){
        $this->id = $id;
    }
    private function setLanguage(\classes\Languages\Language $language){
        $this->language = $language;
    }
    private function setName($name){
        $this->name = $name;
    }

}