<!DOCTYPE html>
<html lang="en">
<body class="">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="h4lickedCourseName">Grades</h4>
        </div>
        <div class="card-body">

          <form class="form-inline" action="<?php echo ROOT_URL; ?>courses/grades" method="post" style="margin-top:3%;">
            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="semester">
              <option selected value="0">Choose Semester...</option>
              <option value="1">First Semester of 2017/2018</option>
              <option value="2">Second Semester of 2017/2018</option>
              <option value="3">First Semester of 2018/2019</option>
              <option value="4">Second Semester of 2018/2019</option>
            </select>
            <input type="hidden" name="overallGpa" value="">
            <input type="hidden" name="semesterGpa" value="">
            <input type="hidden" name="isnull" value="">
            <button type="submit" name="showgrades" class="btn btn-primary my-1">Show</button>
          </form>


            <?php if (isset($_POST['showgrades'])) {
              if (($_POST['semester'])!=0) {
                if(($_POST['isnull'])==0){ ?>
              <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>Course Name</th>
                <th>Course Grade</th>
            </thead>
              <tbody>
                <?php
                  $count = 0 ; $sum = 0 ;
                  foreach($modelResult as $courseGrades) {
                      echo "<tr><td>".$courseGrades['courseid']."</td>";
                      echo "<td>".$courseGrades['grade']."</td></tr>";
                      $count++;
                      $sum=$sum+$courseGrades['grade'];
                  };
                  $_POST['semesterGpa']=round($sum/$count,2);
                ?>
              </tbody>
              <tfoot >
                  <th><?php echo "Semester GPA : ".$_POST['semesterGpa']; ?></th>
                  <th><?php echo "Overall GPA : ".$_POST['overallGpa']; ?></th>
              </tfoot>
            </table>
            </div>
          <?php }else {
            echo "<h3><br>The Grades of this semester not document yet</h3>";
          }
        }
      } ?>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
