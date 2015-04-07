<?php

	class T{
		private function T(){}
		private function __clone(){}
		
		private static $_instance;
		private static $lang = "english";
		public static function setLang($language){
			self::$lang = $language;
		}
		public static function l($key,$language = null){
			$instance = self::I();
			if($language == null) $language = self::$lang;
            return $instance->translate($key,$language);
		
		}
		public static function I(){
			if( !(self::$_instance instanceof self) ){
                self::$_instance = new self();           
            }
			return self::$_instance;
			
		}
		var $data = [];
		public function translate($key,$language){
			if(!isset($this->data[$language]) || count($this->data[$language]) == 0){
				if(file_exists(getAppDirectory()."lang/".$language.".ldf"))
					$this->loadData(getAppDirectory()."lang/".$language.".ldf",$language);
			}
			if(!array_key_exists($key,$this->data[$language])){
				if($language == DEFAULTLANG)
					return $key;
				else return $this->translate($key,DEFAULTLANG);
				
			}
			else return $this->data[$language][$key];
		}
		public function loadData($file,$language){
			$data = $this->readFileUTF8($file);
			$lines = explode("\n",$data);
			$this->data[$language] = [];
			foreach($lines as $line){
				$parts = explode("=",$line,2);
				$this->data[$language][trim($parts[0])] = trim($parts[1]);
			}
			
		}
		private function readFileUTF8($path){
			$content = file_get_contents($path); 
			return mb_convert_encoding($content, 'UTF-8', 
				mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); 
		}
	}

?>