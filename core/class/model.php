<?php
	require_once _ABSPATH_ ."core/class/database.php";
	class Model extends Database{
		protected function Model(){
			parent::__construct();
		}
		public static function Dispense($models){
			if(is_array($models)){
				$m = [];
				foreach($models as $model){
					if(file_exists(_ABSPATH_."application/model/".$model.".php")){
						require_once _ABSPATH_ ."application/model/".$model.".php";
						$m[$model] = new $model;
					}
					else $m[$model] = false;
				}
				return $m;
			}
			else{
				if(file_exists(_ABSPATH_."application/model/".$models.".php")){
					require_once _ABSPATH_ ."application/model/".$models.".php";
					return new $models;
				}
				else return false;
			}
		}
		public static function Load($models){
			if(!is_array($models)){
				$models = [$models];
			}
			foreach($models as $model){
				if(file_exists(_ABSPATH_."application/model/".$model.".php"))
					require_once _ABSPATH_ ."application/model/".$model.".php";
			}
			
		}
	}

?>