<?php
class Bootstrap{
	private $controller;
	private $action;
	private $request;

	public function __construct($request){
		$this->request = $request;
		if ($this->request['action'] == "register") {
			$this->controller = 'students';
			$this->action = 'register';
		}elseif ($this->request['action'] == "login") {
			if (isset($_COOKIE['remember_me'])) {
				$this->controller = 'home';
				$this->action = 'index';
			}
		}else{
			if (!isset($_SESSION['logged_in'])){
				$this->controller = 'students';
				$this->action = 'login';
			}else {
				if($this->request['controller'] == ""){
					$this->controller = 'home';
				} else {
					$this->controller = $this->request['controller'];
				}
				if($this->request['action'] == ""){
					$this->action = 'index';
				} else {
					$this->action = $this->request['action'];
				}
			}
		}
	}

	public function createController(){
		// Check if Class exist
		if(class_exists($this->controller)){
			//check if the action exist if in the given controller
			if(method_exists($this->controller, $this->action)){
				return new $this->controller($this->action);
			} else {
				// method does not exist in the given controller
				echo '<h1>Method does not exist</h1>';
				return;
			}
		} else {
		// Controller does not exist
		echo '<h1>Controller does not exist</h1>';

		return;
	}
}
}
