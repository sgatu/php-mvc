<?php

	class ExampleModel extends Database{
		
		public function ExampleModel(){
			parent::__construct();
		}
		public function GetBar(){
			return "Bar";
		}
		public function GetFromDatabase(){
			$result = $this->db->select("my_table","*",["id"=>1]);
			return $result;
		}
		
		
	}


?>