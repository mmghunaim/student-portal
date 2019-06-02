<?php
class StudentModel extends Model{
  public function register(){
    if (isset($_POST['singup'])) {
      $this->query("SELECT * FROM student WHERE id=:id");
      $this->bind(':id',$_POST['student_id']);
      $row = $this->single();
      if ($row) {
        echo '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto text-center"><div class="alert alert-danger">STUDENT IS ALREADY EXIST</div></div>';
      }else {
        $password = md5($_POST['student_password']);
        $this->query("INSERT INTO student(id,name,phone,address,password) VALUES(:id,:name,:phone,:address,:password)");
        $this->bind(':id',$_POST['student_id']);
        $this->bind(':name',$_POST['student_name']);
        $this->bind(':phone',$_POST['student_phone']);
        $this->bind(':address',$_POST['student_address']);
        $this->bind(':password',$password);
        $this->execute();
        $_SESSION['isInsertedd'] = true;
  			header('Location: '.ROOT_URL.'students/login');
      }
    }
		return;
	}

	public function login(){
    if (isset($_SESSION['isInsertedd'])) {
      echo '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto text-center"><div class="alert alert-success">STUDENT CREATED SUCCESSFULLY</div></div>';
      unset($_SESSION['isInsertedd']);
    }
    if (isset($_POST['login'])) {
      $password = md5($_POST['student_password']);

      $this->query("SELECT * FROM student WHERE id = :id AND password = :password");
      $this->bind(':id',$_POST['student_id']);
      $this->bind(':password',$password);
      $get_student_info = $this->single();
      if ($get_student_info) {
        $_SESSION['logged_in'] = true;
				$_SESSION['student_data'] = array(
					"id"	=> $get_student_info['id'],
					"name"	=> $get_student_info['name'],
          "phone"	=> $get_student_info['phone'],
          "address"	=> $get_student_info['address']
				);
        if (isset($_POST['remember_me'])) {
          setcookie("newcookie", "Hello", time() + (86400 * 30), "/");
          setcookie("remember_me", $get_student_info['id'], time() + (86400 * 30), "/");
        }
				header('Location: '.ROOT_URL.'home/index');
      }else {
        echo '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto text-center"><div class="alert alert-danger">WRONG STUDENT INFORMATION</div></div>';
      }
    }
		return;
	}
}
?>
