<?php

	// getMediaDirectory 
	function getMediaDirectory(){
		return getAppDirectory()."view/media/";
	}
	function getAppDirectory(){
		if(defined("_ABSPATH_")) return _ABSPATH_ ."application/";
		else return __DIR__ ."/../application/";
	}
	/*function RequireModels($files){
		foreach($files as $file){
			require_once getAppDirectory()."model/".$file.".php";
		}
	}*/
	function getViewDirectory(){
		return getAppDirectory()."view/";
	}
	function getViewUri(){
		$uri = "";
		if(defined("FCONTROLLER")){
			$parts = explode("/",FCONTROLLER);
			$parts[count($parts)-1] = "";
			$uri = implode("/",$parts);
		}
		$uri .= "application/view/";
		return $uri;
	}
	function _uri($path){
		if(strlen($path) == 0) $path = "/";
		if(strlen($path) > 1 && $path[0] != "/") $path = "/".$path;
		return FCONTROLLER.$path;
	}
	function isInteger($input){
		if(is_object($input)) return false;
		$result = false;
		try{
			$result = (ctype_digit(strval($input)));
		}
		catch(Exception $ex){
			$result =  false;
		}
		return $result;
	}
	function dbts($time){	
		return date("Y-m-d H:i:s", $time);
	}
	function getCurrentUri(){
		return str_replace(FCONTROLLER, "", $_SERVER['REQUEST_URI']);
	}
	function getUri($url){
		if(strpos($url,FCONTROLLER) !== false){
			return substr($url,strpos($url,FCONTROLLER)+strlen(FCONTROLLER));
		}
		return $url;
	}
	function internalUrl($url){
		if(strpos($url,"://") > 0){
			$parts = parse_url($url);
			return ($parts['host'] == DOMAIN);
		}else return true;
	}
	function getRefererUri(){
		if(isset($_SERVER['HTTP_REFERER']) && !is_null($_SERVER['HTTP_REFERER']) && internalUrl($_SERVER['HTTP_REFERER']))
			return	getUri($_SERVER['HTTP_REFERER']);
		else return null;
	}
	function fixfiles($files)
	{
		$names = array( 'name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);

		foreach ($files as $key => $part) {
			// only deal with valid keys and multiple files
			$key = (string) $key;
			if (isset($names[$key]) && is_array($part)) {
				foreach ($part as $position => $value) {
					$files[$position][$key] = $value;
				}
				// remove old key reference
				unset($files[$key]);
			}
		}
		return $files;
	}
	function validVariableName($name){
		return preg_match("/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/",$name);
	}
	spl_autoload_register("_autoload");
	function _autoload($class){
		if(file_exists(getAppDirectory()."class/".$class.".php")){
			require_once getAppDirectory()."class/".$class.".php";
		}
	}
?>