<?php
require_once 'Medoo.php';

function dbCon(){
	$database = new Medoo([
		'database_type' => 'mysql',
		'database_name' => 'ask4me',
		'server' => 'localhost',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',

		/* 'database_type' => 'mysql',
		'database_name' => 'ask4me',
		'server' => 'localhost',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8', */
		
	 
		// [optional]
		'port' => 3306,
	 
		// [optional] Table prefix
		'prefix' => '',
	 
		// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
		'option' => [
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		]
	]);	
	
	return $database;
}
?>
