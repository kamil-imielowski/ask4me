<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'value':
            # code...
            break;
    }
}else{
    include dirname(__FILE__).'/templates/index.html.php';
}


?>