<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$cmsPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {
				
			case 'editContent':
				$cms = new \classes\Cms\CmsFactory($_GET['id']);
				include 'templates/cms.html.php';
				break;
			
			case 'saveContent':
				try{
					$cms = new \classes\Cms\Cms($_POST['id']);
					$cms->saveContent($_POST);
				}catch(Exception $e){
					$_SESSION['errors'][] = $e->getMessage();
				}
				header("Location: cms.php?action=editContent&id=".$_POST['id']);
				break;
			
		}		

	} else {	
		header("Location: index.php");
	}

}else{
	header("Location: login.php");
}


?>