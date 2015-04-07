<?php
	define("_ABSPATH_", __DIR__ ."/");
	require_once _ABSPATH_ ."setup.php";
	
	$routemgr = new RouteManager(unserialize(ROUTES));
	$routemgr->LoadController();
?>