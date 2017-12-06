<?php
session_start();
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();
$translate->change_lang($_POST['langID']);
if(!empty($_SERVER['HTTP_REFERER'])){
    header("Location: ".$_SERVER['HTTP_REFERER']);
}else{
    header('Location: /index.php');
}