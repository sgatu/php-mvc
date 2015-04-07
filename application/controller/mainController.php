<?php

	class mainController extends Controller {
		
		public function mainController($parms){
			parent::__construct($parms);
		}
		public function show($args = array()){
			$this->printView("mainView",$args);
		}
		
	}

?>