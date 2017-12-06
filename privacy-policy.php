<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

include_once dirname(__FILE__).'/displayErrors.php';
$cms = new \classes\Cms\Cms(6, $_COOKIE['lang']);
include dirname(__FILE__).'/templates/privacy-policy.html.php';

?>