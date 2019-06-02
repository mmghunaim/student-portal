<!DOCTYPE html>
<html lang="en">
<body class="">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" id="h4lickedCourseName">Registered Courses</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <?php if($_POST['nullRegList']!=0) {?>
                  <table class="table" id="showTable">
                    <thead class=" text-primary">
                      <th>Course Name</th>
                      <th>Time</th>
                      <th>Section Number</th>
                      <th>Lab</th>
                      <th>Instructor Name</th>
                      <th>Days</th>
                  </thead>
                    <tbody>
                      <?php
                      foreach($modelResult as $registerList) {
                      echo "<tr><td>".$registerList['coursename']."</td>";
                      echo "<td>".$registerList['starttime']." - " .$registerList['endtime']."</td>";
                      echo "<td>".$registerList['sectionnumber']."</td>";
                      echo "<td>".$registerList['lab']."</td>";
                      echo "<td>".$registerList['instructor']."</td>";
                      echo "<td>".$registerList['days']."</td></tr>";
                      }?>
                    </tbody>
                  </table>
                <?php }else{echo "<div style='margin-top:10%'><h3>There is no registered Courses to show</h3></div>";} ?>
                </div>
              </div>
            </div>
          </div>
        </div>
</body>
</html>
