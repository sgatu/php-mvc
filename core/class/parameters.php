<?php

	class Parameters{
		var $parms;
		public function Parameters($data){
			$this->parms = [];
			if(is_array($data)){
				foreach($data as $key=>$value){
					if(validVariableName($key)) $this->parms[$key] = $value;
				}
			}
		}
		public function __get($varname){
			if(isset($this->parms[$varname])) return $this->parms[$varname];
			else return null;
		}
		public function __set($varname,$varvalue){
			if(validVariableName($varname))
				$this->parms[$varname] = $varvalue;
		}
		public function __unset($varname){
			if(validVariableName($varname) && isset($this->parms[$varname]))
				unset($this->parms[$varname]);
		}
		public function __isset($varname){
			if(validVariableName($varname))
				return isset($this->parms[$varname]);
			return false;
		}
		public function GenerateParms(){
			$return = "!";
			foreach($this->parms as $key=>$value){
				$return .= $key."!".$value.";";
			}
			substr($return,-1);
			return $return;
		}
		public function CreateUrl($url){
			$urlparts = explode("/",$url);
			if($urlparts[count($urlparts)-1] == "") array_pop($urlparts);
			if($urlparts[count($urlparts)-1][0] == "!") array_pop($urlparts);
			$url = implode("/",$urlparts)."/";
			return $url.$this->GenerateParms();
		}
		public static function FromUrl($url){
			$urlparts = explode("/",$url);
			$parmstring = array_pop($urlparts);
			$parameters = [];
			if($parmstring[0] == '!') {
				$parms = explode(";",substr($parmstring,1));
				foreach($parms as $parm){
					$parts = explode("!",$parm);
					if(validVariableName($parts[0])){
						$parameters[$parts[0]] = $parts[1];
					}
				}
			}
			return new Parameters($parameters);
		}
		
	}




?>