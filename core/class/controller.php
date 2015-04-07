<?php
	require_once _ABSPATH_ ."core/class/parameters.php";
	abstract class Controller{
		
		private $parameters;
		public function Controller($parms){
			$_FILES = fixfiles($_FILES);
			$this->parameters = new Parameters($parms);	
		}
		protected function getParameters(){
			return $this->parameters;
		}
		protected function printView($view,$args){
			if($this->checkViewArgs($args)){
				extract($args);
			}
			include_once _ABSPATH_ ."application/view/".$view.".php";
		}
		protected function printText($text){ echo $text; }
		protected function checkViewArgs($args){
			if(!is_array($args)) return false;
			$keys = array_keys($args);
			foreach($keys as $key) if(!validVariableName($key)) return false;
			return true;
		}
		protected function Redirect($path){
			if(strlen($path > 1) && $path[0] != "/") $path = "/".$path;
			header("Location: ".FCONTROLLER.$path);
			exit;
		}
		public static function Dispense($controller,$parms = []){
			include_once _ABSPATH_ ."application/controller/".$controller.".php";
			return new $controller($parms);
		}
	}


?>