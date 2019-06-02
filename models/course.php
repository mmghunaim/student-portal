<?php
class CourseModel extends Model{

  public function currentCourses(){
    $year= date("Y");
    $month = date("m");
    $getSemester = 0 ;
    if ($month<6) {
      $getSemester = 2 ;
    }else {
      $getSemester=1;
    }
    $this->query("SELECT c.name,c.id FROM section s
      JOIN semester sm ON s.semesterid=sm.id AND sm.number='$getSemester'AND sm.year='$year'
      AND s.sectionnumber='101'
      JOIN course c ON s.coursename=c.name
      ORDER BY c.name");

    $result = $this->resultSet();
    return $result;
  }


  public function showSections(){

    $this->query("SELECT * FROM section s,instructor i WHERE coursename=:coursename AND s.instructorid=i.id");
    $this->bind(':coursename',$_POST['clickedCourse']);
    $result = $this->resultSet();

    $studentId = $_SESSION['student_data']["id"];

    $this->query("SELECT * FROM regcourses WHERE coursename=:coursename AND sectionnumber=:sectionnumber AND studentid=:studentId");
    ?>

    <thead>
      <tr>
        <th>Section NO.</th>
        <th>Days & Time</th>
        <th>Lab</th>
        <th>Section Instructor</th>
        <th>State</th>
      </tr>
    </thead>

    <tbody>
    <?php foreach ($result as $key => $value) {
      echo "<tr><td>".$value['sectionnumber']."</td>";
      echo "<td>".$value['days']." - ".substr($value['starttime'],0,5)." - ".substr($value['endtime'],0,5)."</td>";
      echo "<td>".$value['lab']."</td>";
      echo "<td>".$value['name']."</td>";?>
      <td>
        <?php
          $this->bind(':coursename',$_POST['clickedCourse']);
          $this->bind(':sectionnumber',$value['sectionnumber']);
          $this->bind(':studentId',$studentId);
          $isExist = $this->single();
          if ($isExist) {
            ?>
            <button class='btn btn-danger sectionButton <?php echo preg_replace('/\s+/', '', $value["coursename"])." ".$value["sectionnumber"]?>'
               value="<?php echo $value['coursename'].','.$value['sectionnumber']?>">DELETE</button>
            <button class='btn btn-primary sectionButton <?php echo preg_replace('/\s+/', '', $value["coursename"])." ".$value["sectionnumber"]?>'
             value="<?php echo $value['coursename'].','.$value['sectionnumber']?>" style="display:none;">ADD</button>
            <?php
          }else {
            ?>
            <button class='btn btn-primary sectionButton <?php echo preg_replace('/\s+/', '', $value["coursename"])." ".$value["sectionnumber"]?>'
              value="<?php echo $value['coursename'].','.$value['sectionnumber']?>">ADD</button>
            <button class='btn btn-danger sectionButton <?php echo preg_replace('/\s+/', '', $value["coursename"])." ".$value["sectionnumber"]?>'
              value="<?php echo $value['coursename'].','.$value['sectionnumber']?>" style="display:none;">DELETE</button>
            <?php
          }
        ?>
      </td></tr>;
    <?php
    }
    echo "</tbody>";
  }



  public function addSection(){
    $sectionInfo = array();
    $state = array("isAdded"=>false,"conflictExist"=>false,"alreadyExist"=>false);
    $response = array("state"=>$state,"sectionInfo"=>$sectionInfo);

    $sectionName='';$sectionNumber=0;
    foreach ($_POST as $key => $value) {
      $sectionName=$value[0];
      $sectionNumber=$value[1];
    }
    $this->query("SELECT * FROM section s,instructor i WHERE coursename=:sectionName AND sectionnumber=:sectionnumber AND s.instructorid=i.id");
    $this->bind(':sectionName',$sectionName);
    $this->bind(':sectionnumber',$sectionNumber);
    $result = $this->resultSet();
    $instructorid = $result[0]['name'];
    $starttime = $result[0]['starttime'];
    $endtime = $result[0]['endtime'];
    $days = $result[0]['days'];
    $lab = $result[0]['lab'];
    $studentId = $_SESSION['student_data']["id"];

    $this->query("SELECT * FROM regcourses WHERE starttime=:starttime AND endtime=:endtime AND days=:days AND studentid=:studentId");
    $this->bind(':starttime',$starttime);
    $this->bind(':endtime',$endtime);
    $this->bind(':days',$days);
    $this->bind(':studentId',$studentId);
    $conflictExist = $this->single();
    if ($conflictExist) {
      $response["state"]["isAdded"]=false;
      $response["state"]["alreadyExist"]=false;
      $response["state"]["conflictExist"]=true;
      $response["sectionInfo"]["sectionName"]=$sectionName;
      $response["sectionInfo"]["sectionNumber"]=$sectionNumber;
      echo json_encode($response);
    }else{
      $this->query("SELECT * FROM regcourses WHERE coursename=:coursename AND studentid=:studentId");
      $this->bind(':coursename',$sectionName);
      $this->bind(':studentId',$studentId);
      $courseExist = $this->single();
      if ($courseExist) {
        $response["state"]["isAdded"]=false;
        $response["state"]["alreadyExist"]=true;
        $response["state"]["conflictExist"]=false;
        $response["sectionInfo"]["sectionName"]=$sectionName;
        $response["sectionInfo"]["sectionNumber"]=$sectionNumber;
        echo json_encode($response);
      }else{
        $year= date("Y");
        $month = date("m");
        $getSemester = 0 ;
        if ($month<6) {
          $getSemester = 2 ;
        }else {
          $getSemester=1;
        }
        $this->query("INSERT INTO regcourses VALUES('$studentId','$sectionName','$starttime','$endtime','$sectionNumber','$instructorid','$lab','$days','$getSemester','$year')");
        $this->execute();
        $response["state"]["isAdded"]=true;
        $response["state"]["conflictExist"]=false;
        $response["state"]["alreadyExist"]=false;
        $response["sectionInfo"]["sectionName"]=$sectionName;
        $response["sectionInfo"]["sectionNumber"]=$sectionNumber;
        echo json_encode($response);
      }
    }
  }


  public function updateSection(){
    $sectionInfo = array();
    $response = array("isUpdated"=>false,"sectionInfo"=>$sectionInfo);

    $clickedSectionName=$_POST['clickedSectionName'];
    $clickedSectionNumber=$_POST['clickedSectionNumber'];
    $studentId = $_SESSION['student_data']["id"];

    $this->query("SELECT sectionnumber FROM regcourses WHERE coursename=:sectionName AND studentid=:studentId");
    $this->bind(':sectionName',$clickedSectionName);
    $this->bind(':studentId',$studentId);
    $result = $this->resultSet();
    $preSectionNumber = $result[0]['sectionnumber'];

    $this->query("DELETE FROM regcourses WHERE coursename=:sectionName AND studentid=:studentId");
    $this->bind(':sectionName',$clickedSectionName);
    $this->bind(':studentId',$studentId);
    $this->execute();

    $this->query("SELECT * FROM section s,instructor i WHERE coursename=:sectionName AND sectionnumber=:sectionnumber AND s.instructorid=i.id");
    $this->bind(':sectionName',$clickedSectionName);
    $this->bind(':sectionnumber',$clickedSectionNumber);
    $result = $this->resultSet();
    $instructorid = $result[0]['name'];
    $starttime = $result[0]['starttime'];
    $endtime = $result[0]['endtime'];
    $days = $result[0]['days'];
    $lab = $result[0]['lab'];

    $year= date("Y");
    $month = date("m");
    $getSemester = 0 ;
    if ($month<6) {
      $getSemester = 2 ;
    }else {
      $getSemester=1;
    }

    $this->query("INSERT INTO regcourses
     VALUES('$studentId','$clickedSectionName','$starttime','$endtime','$clickedSectionNumber','$instructorid','$lab','$days','$getSemester','$year')");

    $this->execute();
    $response["isUpdated"]=true;
    $response["sectionInfo"]["preSectionNumber"]=$preSectionNumber;
    $response["sectionInfo"]["sectionNumber"]=$clickedSectionNumber;
    $response["sectionInfo"]["sectionName"]=$clickedSectionName;
    echo json_encode($response);
  }



  public function deleteSection(){
    $sectionInfo = array();
    $response = array("isRemoved"=>false,"sectionInfo"=>$sectionInfo);
    $sectionName='';$sectionNumber=0;

    foreach ($_POST as $key => $value) {
      $sectionName=$value[0];
      $sectionNumber=$value[1];
    }

    $studentId = $_SESSION['student_data']["id"];

    $this->query("DELETE FROM regcourses WHERE coursename=:sectionName AND sectionnumber=:sectionnumber AND studentid=:studentId");
    $this->bind(':sectionName',$sectionName);
    $this->bind(':sectionnumber',$sectionNumber);
    $this->bind(':studentId',$studentId);
    $this->execute();
    $response["isRemoved"]=true;
    $response["sectionInfo"]["sectionName"]=$sectionName;
    $response["sectionInfo"]["sectionNumber"]=$sectionNumber;
    echo json_encode($response);
  }


  public function registeredCourses(){

    $year= date("Y");
    $month = date("m");
    $getSemester = 0 ;
    if ($month<6) {
      $getSemester = 2 ;
    }else {
      $getSemester=1;
    }

    $studentId = $_SESSION['student_data']["id"];

    $this->query("SELECT * FROM regcourses r
      WHERE studentid=:studentId AND  r.semesternumber = '$getSemester' AND r.semesteryear = '$year'");

    $this->bind(':studentId',$studentId);

    if ($this->getStatement()->rowCount()<=0) {
      $_POST['nullRegList']=1;
    }

    $registeredCourses = $this->resultSet();
    return $registeredCourses;
  }


  public function grades(){

    if (isset($_POST['showgrades'])) {
      $year = 0 ;$semesternumber = 0 ;
      $selected_semester = $_POST['semester'];
      if ($selected_semester==1) {
        $year='2017';
        $semesternumber = 1 ;
      }elseif ($selected_semester==2) {
        $year='2018';
        $semesternumber = 2 ;
      }elseif ($selected_semester==3) {
        $year='2018';
        $semesternumber = 1 ;
      }elseif ($selected_semester==4) {
        $year='2019';
        $semesternumber = 2 ;
      }

      $studentId = $_SESSION['student_data']["id"];

      $this->query("SELECT pc.courseid ,pc.grade FROM precourses pc , semester sm WHERE pc.studentid=:studentId AND pc.semesterid=sm.id AND sm.year=:year AND sm.number=:semesternumber");
      $this->bind(':studentId',$studentId);
      $this->bind(':semesternumber',$semesternumber);
      $this->bind(':year',$year);
      $result = $this->resultSet();

      if ($this->getStatement()->rowCount() <=0) {
        $_POST['isnull']=1;
      }else {
        $_POST['isnull']=0;
        $this->query("SELECT pc.grade FROM precourses pc WHERE pc.studentid=:studentId");
        $this->bind(':studentId',$studentId);
        $overallGpa = $this->resultSet();
        $sum = 0 ;$count=0;

        foreach ($overallGpa as $key => $value) {
          foreach ($value as $key => $value) {
            $sum=$sum+$value;
            $count++;
          }
        }

        $_POST['overallGpa']=round($sum/$count,2);
        return $result;
      }
    }else {
      return;
    }
  }

}
?>
