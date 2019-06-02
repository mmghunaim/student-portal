<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="h4lickedCourseName">Available Courses</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <a href="<?php echo ROOT_URL; ?>courses/currentCourses" style="display:block;margin-top:0%;"><i class="fa fa-arrow-circle-left" style="font-size:230%;"></i></a>
          <table class="table" id="showTable">
            <thead class=" text-primary">
              <th>Course Id</th>
              <th>Course Name</th>
          </thead>
            <tbody>
              <?php
                foreach($modelResult as $keys):?>
                <tr id="<?php echo $keys['name'] ?>">
                  <td><?php echo $keys['id']; ?></td>
                  <td><?php echo $keys['name'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('tr').css('cursor', 'pointer');
      $("tr").click(function(e){
        e.preventDefault();
        var courseInfo = { clickedCourse : $(this).attr('id') }
        $.ajax({
          url : "<?php echo ROOT_URL; ?>courses/showSections",
          data: courseInfo,
          type: 'POST',
          success:function(data){
            $("#h4lickedCourseName").html(courseInfo["clickedCourse"])
            $("#showTable").html(data);
            //var mainData = data;
            $(".btn.btn-primary.sectionButton").click(function(e){
              e.preventDefault();
              var data = {clickedSection : $(this).val().split(",")}
              swal({
                title: "ADD THIS SECTION",
                text: data['clickedSection'][0]+" - "+data['clickedSection'][1],
                icon: "info",
                buttons: ["CANCEL", "YES"],
              })
              .then((add) => {
                if (add) {
                  $.ajax({
                    url: "<?php echo ROOT_URL; ?>courses/addSection" ,
                    data:data,
                    type:'POST',
                    dataType:'JSON',
                    success:function(data){
                      if (data.state.conflictExist) {
                        swal("ERROR", "Conflict Exist", "error");
                      }else if (data.state.alreadyExist) {
                        swal({
                          title: "SECTION ALREADY EXIST",
                          text: "DO YOU WANT TO UPDATE SECTION ??",
                          icon: "warning",
                          buttons: ["CANCEL", "YES"],
                          dangerMode: true,
                        })
                        .then((update) => {
                          if (update) {
                            var clickedSectionNumber  = data.sectionInfo.sectionNumber
                            var clickedSectionName    = data.sectionInfo.sectionName
                            var update = {
                              "clickedSectionNumber"  : clickedSectionNumber,
                              "clickedSectionName"  : clickedSectionName
                            }
                            $.ajax({
                              url: "<?php echo ROOT_URL; ?>courses/updateSection" ,
                              data:update,
                              type:'POST',
                              dataType:'JSON',
                              success:function(data){
                                var previousSectionNumber    = data.sectionInfo.preSectionNumber
                                clickedSectionName=clickedSectionName.replace(/\s/g, '')

                                $('.btn.btn-primary.sectionButton.'+clickedSectionName+'.'+previousSectionNumber).show()
                                $('.btn.btn-danger.sectionButton.'+clickedSectionName+'.'+previousSectionNumber).hide()

                                $('.btn.btn-primary.sectionButton.'+clickedSectionName+'.'+clickedSectionNumber).hide()
                                $('.btn.btn-danger.sectionButton.'+clickedSectionName+'.'+clickedSectionNumber).show()
                                swal("SUCCESS", "Section Updated Successfully", "success");
                              },
                              error:function(data){
                              }
                            });
                          }
                        });
                      }else {
                        var sectionName = data.sectionInfo.sectionName
                        var sectionNumber = data.sectionInfo.sectionNumber
                        sectionName=sectionName.replace(/\s/g, '')
                        $('.btn.btn-primary.sectionButton.'+sectionName+'.'+sectionNumber).hide()
                        $('.btn.btn-danger.sectionButton.'+sectionName+'.'+sectionNumber).show()
                        swal("SUCCESS", "Section Added Successfully", "success");
                      }
                    },
                    error:function(data){
                    }
                  });
                }
              });
            });

            $(".btn.btn-danger.sectionButton").click(function(e){
              e.preventDefault();
              var data = { clickedSection : $(this).val().split(",") }
              swal({
                title: "DELETE THIS SECTION",
                text: data['clickedSection'][0]+" - "+data['clickedSection'][1],
                icon: "warning",
                buttons: ["CANCEL", "YES"],
              })
              .then((remove) => {
                if (remove) {
                  $.ajax({
                    url: "<?php echo ROOT_URL; ?>courses/deleteSection" ,
                    data:data,
                    type:'POST',
                    dataType:'JSON',
                    success:function(data){
                      var sectionName = data.sectionInfo.sectionName
                      var sectionNumber = data.sectionInfo.sectionNumber
                      sectionName=sectionName.replace(/\s/g, '')
                      $('.btn.btn-primary.sectionButton').show()
                      $('.btn.btn-danger.sectionButton.'+sectionName+'.'+sectionNumber).hide()
                      swal("SUCCESS", "Section Removed Successfully", "success");
                    },
                    error:function(data){
                    }
                  });
                }
              });
            });
            },
            error:function(data){
              console.log(data);
            }
        });
      });

    })
  </script>

</body>

</html>
