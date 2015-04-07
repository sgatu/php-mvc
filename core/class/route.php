<?php

	class Route{
		private $controller;
		private $vars;
		private $parts;
		private static $VTYPES = array("alphanumeric","numeric","alpha","static","string");
		public function Route($route){
			$this->vars = array();
			$this->parts = array();
			if(is_array($route)){
				$this->controller = $route["controller"];
				$vars = explode("/",$route['url']);
				while(count($vars) > 0 ) {
					$change = false;
					if(trim($vars[0]) == ''){
						array_shift($vars); 
						$change = true;
					}
					if(trim($vars[count($vars)-1]) == '')
					{
						array_pop($vars);
						$change = true;
					}
					if(!$change) break;
				}
				for($x=0;$x<count($vars);$x++){
					if(preg_match("/^\{(.*)\}/i",$vars[$x],$matches)){
						$vtype = "alphanumeric";
						if(isset($route['vtypes']) && isset($route['vtypes'][$matches[1]])){
							if(in_array($route['vtypes'][$matches[1]],self::$VTYPES)) 
								$vtype = $route['vtypes'][$matches[1]];
						}
						$this->vars[] = array("name"=>$matches[1],"vtype"=>$vtype);
					}
					else
						$this->vars[] = array("name"=>$vars[$x],"vtype"=>'static');
				}
			
			}
		
		}
		public function getController(){
			return $this->controller;
		}
		public function matches($vars){

			if(count($vars) != count($this->vars)) return false;
			for($x=0;$x<count($vars);$x++){
				if(!$this->matchVtype($vars[$x],$this->vars[$x]))
					return false;
			}
			return true;
		}
		public function getVars(){
			$vars = explode("/",substr($_SERVER['REQUEST_URI'],strlen(FCONTROLLER)));
			$vars2 = [];
			for($x=0;$x < count($vars);$x++){
				if(strlen(trim($vars[$x])) != 0) { array_push($vars2,$vars[$x]); };
			}
			$vars = $vars2;
			if(count($vars) > 0 && $vars[count($vars)-1][0] == "!") array_pop($vars);
			if(count($vars) != count($this->vars)) return false;
			$v = array();
			$x = 0;
			foreach($this->vars as $var){
				if($var['vtype'] != 'static')
					$v[$var['name']] = $vars[$x];
				$x++;
			}

			return $v;
		}
		private function matchVtype($value,$var){
			switch($var['vtype']){
				default:
				case "static":
				{
					if($value == $var['name'])
						return true;
					break;
				}
				case "alphanumeric":
				{
					if(ctype_alnum($value))
						return true;
					break;
				}
				case "numeric":
				{
					if(is_numeric($value))
						return true;
					break;
				}
				case "alpha":
				{
					if(ctype_alpha($value))
						return true;
					break;
				}
				case "string":
					if(preg_match('/^[a-z0-9 .\-_\+\!\;]+$/i', $value))
						return true;
					return false;
				break;
			}
			return false;
		}
	}
?>