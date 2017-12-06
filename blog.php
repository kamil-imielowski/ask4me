<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

//echo $_GET['title'];

try{
    $blog = new classes\Blog\Blog($_GET['id']);
    if($_GET['title'] !== $blog->getURLTitle()){
        throw new Exception($translate->getString("nExist"));
    }
}catch(Exception $e){
    $_SESSION['errors'][] = $e->getMessage();
    if(isset($_SERVER['HTTP_REFERER'])){
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location: /home");
    }
    exit();
}

include dirname(__FILE__).'/templates/blog-entry.html.php';

?>