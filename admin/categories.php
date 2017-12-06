<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$categoriesPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {
				
			case 'add':
                $LF = new classes\Languages\LanguagesFactory();
                $languages = $LF->getLanguages();
                include dirname(__FILE__).'/templates/category-add.html.php';
			break;		

            case 'edit':
                try{
                     $category = new classes\Categories\Category($_GET['id'], true);
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                    header("Location: categories.php");
                    break;
                }
                $LF = new classes\Languages\LanguagesFactory();
                $languages = $LF->getLanguages();
                include dirname(__FILE__).'/templates/category-edit.html.php';
            break;

            case 'delete':
                try{
                    $category = new classes\Categories\Category($_GET['id']);
                    $category->deleteFromDB();
                    $_SESSION['ok'] = "";
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: categories.php");
            break;

            case 'form-edit-add':
                try{
                    if(isset($_POST['id'])){
                        $category = new classes\Categories\Category($_POST['id']);
                    }else{
                        $category = new classes\Categories\Category();
                    }
                    $category->saveToDB($_POST);
                    $_SESSION['ok'] = $translate->getString('insert');
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                    if(isset($_POST['id'])){
                        header("Location: categories.php?action=edit&id=".$_POST['id']);
                    }else{
                        $_SESSION['data'] = $_POST;
                        header("Location: categories.php?action=add");
                    }
                    break;
                }
                header("Location: categories.php");
            break;
			
		}		

	} else {	
        if(isset($_SESSION['data'])){
            unset($_SESSION['data']);
        }
        $CF = new classes\Categories\CategoriesFactory();
        $categories = $CF->getCategories();
		include 'templates/categories.html.php';
	}

}else{
	header("Location: login.php");
}


?>