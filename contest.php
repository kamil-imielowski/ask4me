<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

include_once dirname(__FILE__).'/displayErrors.php';

include dirname(__FILE__).'/templates/contest.html.php';

?>