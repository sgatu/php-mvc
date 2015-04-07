<?php
	class exController extends ExtendedController{
		
		public function exController($parms){
			parent::__construct($parms);
		}
		public function show($args = array()){
			echo $this->Foo();
		}
	}

?>