<?php
require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

$pv = new classes\PageView\PageView();
$pv -> wyswietlenia();
$dane = $pv -> views;

//$json = json_encode($dane);
$numItems = count($dane);
$i = 0;
foreach($dane as $k => $v){
	echo "[\"".$k."\",".$v."]";
	if(++$i !== $numItems) {
		echo ",";
	}
}
	
//echo($json);