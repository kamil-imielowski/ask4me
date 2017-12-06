<?php namespace classes\Categories;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class Category{ 
    private $id;
    private $createdDate;
    private $categoryInfo; // obiekt z informacjami wybranego jezyka
    private $categoryInfoAll; // lista obiektow ze wszystimi jezykami - ladowana tylko w PA

    function __construct($id = null, $allInfo = false){
        if(!empty($id)){
            $this->id = $id;
            if($allInfo){
                $this->setCategoryInfoAll();
            }else{
                $this->loadCategory();
            }
        }
    }  

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if(!empty($this->id)){
            #update
            if(!$database->update("categories", ["date_updated" => $date], ['id' => $this->id])){
                throw new \Exception($translate->getString('error-DBUpdate'));
            }
        }else{
            #insert
            if(!$database->insert("categories", ["date_created" => $date, "date_updated" => $date])){
                throw new \Exception($translate->getString('error-DBInsert'));
            }
            $this->id = $database->id();
        }

        foreach($data['language'] as $code => $arr){
            $CI = new CategoryInfo($this->id, $code);
            $CI->saveToDB($arr);
        }
    }

    private function loadCategory(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $sql = $database->select("categories", '*', ['id' => $this->id]);
        if(empty($sql)){
            throw new \Exception($translate->getString('nExist'));
        }
        $this->setCreatedDate($sql[0]['date_created']);
        $this->setCategoryInfo(new CategoryInfo($this->id, $_COOKIE['lang']));
    }

    function deleteFromDB(){
        $database = dbCon();
        if(!$database->has("categories", ['id' => $this->id])){
            throw new \Exception($translate->getString('nExist'));
        }
        if($database->has("categories_info", ["category_id" => $this->id])){
            if(!$database->delete("categories_info", ["category_id" => $this->id])){
                throw new \Exception($translate->getString('delete-error'));
            }
        }
        if(!$database->delete("categories", ['id' => $this->id])){
            throw new \Exception($translate->getString('delete-error'));
        }
    }

    function getId(){
        return $this->id;
    }
    function getCategoryInfo(){
        return $this->categoryInfo;
    }
    function getCategoryInfoLang($lang){
        return $this->categoryInfoAll[$lang];
    }
    function getCreatedDate(){
        return $this->createdDate;
    }

    private function setCategoryInfo(CategoryInfo $categoryInfo){
        $this->categoryInfo = $categoryInfo;
    }
    private function setCategoryInfoAll(){
        $database = dbCon();
        $sql = $database->select("languages", '*');
        $categoryInfoAll = array();
        foreach($sql as $v){
            $categoryInfoAll[$v['code']] = new CategoryInfo($this->id, $v['code']);
        }
        $this->categoryInfoAll = $categoryInfoAll;
    }
    private function setCreatedDate($createdDate){
        $this->createdDate = $createdDate;
    }
}