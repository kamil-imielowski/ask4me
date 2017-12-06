<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

include_once dirname(__FILE__).'/displayErrors.php';
$cms = new \classes\Cms\Cms(2, $_COOKIE['lang']);
include dirname(__FILE__).'/templates/about.html.php';

?>