<?php
	class RouteManager{
		
		private $routes;
		public function RouteManager($_routes){
			$this->routes = array();
			foreach($_routes as $route){
				$this->routes[] = new Route($route);
			}
		}
		public function getCurrentParameters(){
			$vars = array_slice(explode("/",$_SERVER['REQUEST_URI']), array_search(basename($_SERVER['SCRIPT_FILENAME']),explode("/",$_SERVER['REQUEST_URI']),true)+1);
			if(count($vars) > 0 && trim($vars[count($vars)-1]) != ""){
				if($vars[count($vars)-1][0] == '!'){
					$vars[count($vars)-1] = substr($vars[count($vars)-1],1);
					$parms = explode(";",$vars[count($vars)-1]);
					
					$parameters = [];
					foreach($parms as $parm){
						if(strpos($parm,"!") !== false){
							$parts = explode("!",$parm,2);
							$parameters[$parts[0]] = $parts[1];
						}
						
					}
					return $parameters;
				}
			}
			return [];
		}
		public function getCurrentRoute(){
			$vars = array_slice(explode("/",$_SERVER['REQUEST_URI']), array_search(basename($_SERVER['SCRIPT_FILENAME']),explode("/",$_SERVER['REQUEST_URI']),true)+1);

			//if(count($vars) == 1 && trim($vars[0]) == "") $vars = array();
			if(count($vars) > 0){
				if(strlen($vars[count($vars)-1]) > 0){ // fix in page url
					$pos = strpos($vars[count($vars)-1],"#");
					if($pos === 0)
						array_pop($vars); 
					else if($pos > 0){
						$vars[count($vars)-1] = substr($vars[count($vars)-1],0,$pos+1);
					}
				}
				if(trim($vars[count($vars)-1]) == "") array_pop($vars); // remove empty var if exists
				if(count($vars) > 0 && $vars[count($vars)-1][0] == '!') array_pop($vars); // remove parameters before route matching. 
			}
			foreach($this->routes as $route){
				if($route->matches($vars))
					return $route;
			}
			throw new Exception("Cannot find controller for request.[".$_SERVER['REQUEST_URI']."]",404);
		}
		public function getController($route = null){
			if($route == null)
				return $this->getCurrentRoute()->getController();
			return $route->getController();

		}
		public function LoadController($route = null){
			$controller = $this->getController($route);
			if($route == null) $route = $this->getCurrentRoute();
			$c = Controller::Dispense($controller[0],$this->getCurrentParameters());
			$c->show($route->getVars());
		}
	}
	

?>