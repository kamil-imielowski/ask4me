<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);
include_once dirname(__FILE__).'/displayErrors.php';
if(!isset($_SESSION['user'])){
	header("Location: /home");
}
$user = unserialize(base64_decode($_SESSION['user']));

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {

	}
}else{
	$usersConversations = new \classes\Message\UsersConversations($user);
	include dirname(__FILE__).'/templates/messages.html.php';
}

?>