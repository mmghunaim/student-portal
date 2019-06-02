<?php
class Students extends Controller{

  protected function register(){
		$viewmodel = new StudentModel();
		$this->returnView($viewmodel->register(), false);
	}

	protected function login(){
		$viewmodel = new StudentModel();
    if (!isset($_SESSION['logged_in'])) {
      $this->returnView($viewmodel->login(), false);
    }else {
      header('Location: '.ROOT_URL.'home/index');
    }
	}

	protected function logout(){
		unset($_SESSION['logged_in']);
		unset($_SESSION['student_data']);
		session_destroy();

    unset($_COOKIE["newcookie"]);
    setcookie("newcookie", "", time() - 3600, '/');
    unset($_COOKIE["remember_me"]);
    setcookie("remember_me", "", time() - 3600, '/');
		header('Location: '.ROOT_URL);
	}
}

?>
