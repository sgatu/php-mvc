<?php


define("CONFIG_DB",serialize([
	'database_type' => 'mysql',
	'database_name' => 'database',
	'server' => 'localhost',
	'username' => 'user',
	'password' => '*******',
	'charset' => 'utf8',
	'prefix' => 'my_',
]));
define("DEBUG", true);
define("FCONTROLLER", "/projects/php-mvc/trunk/front.php");
define("DEFAULTLANG","spanish");
define("DOMAIN", "localhost");
?>