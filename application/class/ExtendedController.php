<?php
class ExtendedController extends Controller{
	public function ExtendedController($parms){
		parent::__construct($parms);
	}
	public function Foo(){
		return "Foo";
	}
}
	
?>