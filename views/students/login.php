<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Student Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha256-m/h/cUDAhf6/iBRixTbuc8+Rg2cIETQtPcH9D3p2Kg0=" crossorigin="anonymous" />
    <!-- open-iconic-bootstrap (icon set for bootstrap) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style media="screen">
      :root {
        --input-padding-x: 1.5rem;
        --input-padding-y: .75rem;
      }
      body {
        background: #e9e9e9;
      }
      .card-signin {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
      }
      .card-signin .card-title {
        margin-bottom: 2rem;
        font-weight: 300;
        font-size: 1.5rem;
      }
      .card-signin .card-body {
        padding: 2rem;
      }
      .form-signin {
        width: 100%;
      }
      .form-signin .btn {
        font-size: 80%;
        border-radius: 5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        transition: all 0.2s;
      }
      .form-label-group {
        position: relative;
        margin-bottom: 1rem;
      }
      .form-label-group input {
        height: auto;
        border-radius: 2rem;
      }
      .form-label-group>input,
      .form-label-group>label {
        padding: var(--input-padding-y) var(--input-padding-x);
      }
      .form-label-group>label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
      }
      .form-label-group input::-webkit-input-placeholder {
        color: transparent;
      }
      .form-label-group input:-ms-input-placeholder {
        color: transparent;
      }
      .form-label-group input::-ms-input-placeholder {
        color: transparent;
      }
      .form-label-group input::-moz-placeholder {
        color: transparent;
      }
      .form-label-group input::placeholder {
        color: transparent;
      }
      .form-label-group input:not(:placeholder-shown) {
        padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
        padding-bottom: calc(var(--input-padding-y) / 3);
      }
      .form-label-group input:not(:placeholder-shown)~label {
        padding-top: calc(var(--input-padding-y) / 3);
        padding-bottom: calc(var(--input-padding-y) / 3);
        font-size: 12px;
        color: #777;
      }
      .btn-google {
        color: white;
        background-color: #ea4335;
        border-radius: 2rem;
        font-size: 80%;
        border-radius: 5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        transition: all 0.2s;
      }
      .btn-facebook {
        color: white;
        background-color: #3b5998;
      }
    </style>
  </head>
  <body>
    <?php
    // if (isset($_COOKIE["remember_me"])) {
    //   echo "YES";
    // }else {
    //   echo "NO";
    // }
    ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">Sign In</h5>
              <form class="form-signin" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-label-group">
                  <input type="text" id="student-id" class="form-control" placeholder="Student ID" name="student_id" required autofocus >
                  <label for="student-id">Student Id</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="student-password" class="form-control" placeholder="Student Password" name="student_password"
                  required autofocus >
                  <label for="student-password">Student Password</label>
                </div>
                <div class="custom-control custom-checkbox mb-3">
                  <input class="form-check-input" type="checkbox" value="Remember Me" id="defaultCheck1" style="padding:0px;" name="remember_me">
                  <label class="form-check-label" for="defaultCheck1">Remember Me</label>
                </div>

                <input type="submit" name="login" value="Sign in" class="btn btn-lg btn-primary btn-block text-uppercase">
                <hr class="my-4">
              </form>
              <a href="<?php echo ROOT_URL; ?>students/register" style="color:white;text-decoration:none">
                <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit">
                Sign Up</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
