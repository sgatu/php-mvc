<?php
	require_once _ABSPATH_ ."config.php";
	require_once _ABSPATH_ ."routes.php";
	require_once _ABSPATH_ ."core/errorhandler.php";
	require_once _ABSPATH_ ."core/class/translator.php";
	require_once _ABSPATH_ ."core/class/route.php";
	require_once _ABSPATH_ ."core/class/routemanager.php";
	require_once _ABSPATH_ ."core/lib/medoo.php";
	require_once _ABSPATH_ ."core/class/controller.php";
	require_once _ABSPATH_ ."core/class/model.php";
	require_once _ABSPATH_ ."core/functions.php";
	
	error_reporting(E_ALL);
	if(DEBUG)
		ini_set('display_errors', "1");  
	else
		ini_set('display_errors', "0");
	
	T::setLang(DEFAULTLANG);
	

	//T::setLang("english");
?>