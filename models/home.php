<?php
class HomeModel extends Model{
  public function Index(){
    $stdid = 	$_SESSION['student_data']['id'];
    $this->query("SELECT * FROM student WHERE id=:id");
    $this->bind(":id",$stdid);
    $result = $this->resultSet();


    $this->query("SELECT pc.grade FROM precourses pc WHERE pc.studentid=:studentId");
    $this->bind(':studentId',$stdid);
    $ifExist = $this->execute();
    $sum = 0 ;$count=0;

    $overallGpa = $this->resultSet();
    foreach ($overallGpa as $key => $value) {
      foreach ($value as $key => $value) {
        $sum=$sum+$value;
        $count++;
      }
    }
    if ($count!=0) {
      $_POST['overallGpa']=$sum/$count;
    }else{
      $_POST['overallGpa']=0;
    }


    return $result;
  }

  public function editProfile(){
    $updateInfo = array();
    $checks = array();
    $response = array("changed"=>false,"checks"=>$checks,"updateInfo"=>$updateInfo);
    $this->query("SELECT * FROM student WHERE id=:stdid");
    $this->bind(":stdid",$_SESSION['student_data']['id']);
    $result = $this->resultSet();
    if ($result[0]["name"]!=$_POST['name'] || $result[0]["lname"]!=$_POST['lname'] || $result[0]["email"]!=$_POST['email'] ||
        $result[0]["phone"]!=$_POST['phone'] || $result[0]["address"]!=$_POST['address']) {
          $response["changed"]=true;
          if ($result[0]["email"]!=$_POST['email']) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
              $response["checks"]["validEmail"]=true;
            }else{
              $response["checks"]["validEmail"]=false;
            }
          }else {
            $response["checks"]["validEmail"]=true;
          }

          if ($result[0]["phone"]!=$_POST['phone']) {
            $phoneREG = "/^\+?([0-9]{3})[5]{1}([9]{1})([0-9]{7})$/";
            if (preg_match($phoneREG,$_POST['phone'])) {
              $response["checks"]["validPhone"]=true;
            }else{
              $response["checks"]["validPhone"]=false;
            }
          }else{
            $response["checks"]["validPhone"]=true;
          }

          if ($response["checks"]["validEmail"]==true && $response["checks"]["validPhone"]==true) {
            $this->query("UPDATE student SET name=:name ,lname=:lname,email=:email,phone=:phone,address=:address WHERE id=:stdid");
            $this->bind(":name",$_POST['name']);
            $this->bind(":lname",$_POST['lname']);
            $this->bind(":email",$_POST['email']);
            $this->bind(":phone",$_POST['phone']);
            $this->bind(":address",$_POST['address']);
            $this->bind(":stdid",$_SESSION['student_data']['id']);
            $this->execute();
          }
    }
    echo json_encode($response);
  }
}
?>
