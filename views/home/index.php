<div class="row">
  <div class="col-md-6">
    <div class="card card-user">
      <div class="image">
        <img src="../assets/img/damir-bosnjak.jpg" alt="..."
        onError="this.onerror=null;this.src='assets/img/damir-bosnjak.jpg';">
      </div>
      <div class="card-body">
        <div class="author">
          <img class="avatar border-gray" src="../assets/img/default-avatar.png" alt="..."
          onError="this.onerror=null;this.src='assets/img/default-avatar.png';">
          <h5 class="title" id="username"><?php echo substr($modelResult[0]['name'],0,1).$modelResult[0]['lname']; ?></h5>
          <p class="description">
            <?php echo $modelResult[0]['id']; ?>
          </p>
        </div>
        <p class="description text-center">
             Student Portal
            <br>Allow Students to
            <br> Add , Update , Delete Courses
          </p>
      </div>

      <div class="card-footer">
        <hr>
        <div class="button-container">
          <div class="row">
            <div class="col-lg-12 mr-auto">
              <h5><?php echo round($_POST['overallGpa'],2);?>
                <br>
                <small>GPA</small>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Edit Profile</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Student ID (disabled)</label>
                <input type="text" class="form-control" disabled="" placeholder="Company" value="<?php echo $modelResult[0]['id']; ?>" name="id">
              </div>
            </div>
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="Company" value="<?php echo substr($modelResult[0]['name'],0,1).$modelResult[0]['lname']; ?>"disabled id="inputUsername">
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Company" value="<?php echo $modelResult[0]['name']; ?>"
                name="name">
              </div>
            </div>
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" value="<?php echo $modelResult[0]['lname']; ?>"
                name="lname">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Home Address" value="<?php echo $modelResult[0]['address']; ?>"
                name="address">
              </div>
            </div>
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" placeholder="Phone" value="<?php echo $modelResult[0]['phone']; ?>"
                name="phone">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 pr-1">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" placeholder="Email" value="<?php echo $modelResult[0]['email']; ?>"
                name="email">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round" id="subbtn">Update Profile</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var preData = {}
    $('input[name="email"]').on('focusin', function(){
      preData.email=$(this).val()
    });
    $('input[name="phone"]').on('focusin', function(){
      preData.phone=$(this).val()
    });

    $("#subbtn").click(function(e){
      e.preventDefault();
      var profileInfo = {
        "name":$('input[name="name"]').val(),
        "lname":$('input[name="lname"]').val(),
        "email":$('input[name="email"]').val(),
        "address":$('input[name="address"]').val(),
        "phone":$('input[name="phone"]').val()
      }
      $.ajax({
        url : "<?php echo ROOT_URL; ?>home/editProfile",
        data : profileInfo,
        method : "POST",
        dataType:"JSON",
        success:function(data){
          if (data.changed) {
            if (!data.checks.validEmail) {
              swal("ERROR", "Invalid Email Address", "error");
              $('input[name="email"]').val(preData.email)
            }else if (!data.checks.validPhone) {
              swal("ERROR", "Invalid Phone Number", "error");
              $('input[name="phone"]').val(preData.phone)
            }else{
              swal("SUCCESS", "Profile Updated Successfully", "success");
              $('#username').text(profileInfo['name'].substring(0,1)+profileInfo['lname']);
              $('#inputUsername').val(profileInfo['name'].substring(0,1)+profileInfo['lname']);
            }
          }else{
            swal("ERROR", "Nothing changed to update", "error");
          }
        },
        error:function(){
        }
      })
    })
  })
</script>
