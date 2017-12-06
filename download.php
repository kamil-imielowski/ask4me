<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'download':
            if(isset($_GET['file']) && !empty($_GET['file'])){
            	$fileName = $_GET['nick'] . '-' . $_GET['file'];
            	$file = $_GET['dir'] . $_GET['file'];
            	if(!$file){ // file does not exist
				    die('file not found');
				} else {

					header("Cache-Control: public");
				    header("Content-Description: File Transfer");
				    header("Content-Disposition: attachment; filename=$fileName");
				    header("Content-Type: application/zip");
				    header("Content-Transfer-Encoding: binary");

				    // read the file from disk*/
				    readfile($file);
				}
            }
            break;

    }
}else{
    header("Location: /home");
}


?>