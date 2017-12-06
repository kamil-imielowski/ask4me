<?php namespace classes\Categories;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class CategoriesFactory{ 
    private $categories;

    function __construct(){
        $this->loadCategories();
    }

    private function loadCategories(){
        $database = dbCon();
        $categories = array();
        $sql = $database->select("categories", '*');
        if(!empty($sql)){
            foreach($sql as $v){
                $categories[] = new Category($v['id']);
            }
        }

        usort($categories, array($this, "sortByName"));
        $this->categories = $categories;
    }

    function getCategories(){
        return $this->categories;
    }

    private function sortByName($a, $b){
        return strcmp($a->getCategoryInfo()->getName(), $b->getCategoryInfo()->getName());
    }
    
}