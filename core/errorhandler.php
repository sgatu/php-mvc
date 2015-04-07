<?php
	set_exception_handler('exception_handler');
	function exception_handler($exception){
		if(defined("DEBUG") && DEBUG){
			echo "<pre>";
			var_dump($exception);
			echo "</pre>";
		}
		else{
			switch($exception->getCode()){
				
				case 404:
					http_response_code(404);
					echo "404 - Not found";
				break;
				default:
					http_response_code($exception->getCode());
					echo "An {$exception->getCode()} error has occurred, please contact administrator.";
				break;
			}
		}
	}
	function isLocal(){
		if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1'))){
			return false;
		}
	    return true;
	}

?>