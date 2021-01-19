<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <style>
    body {
      padding-top: 5px;
    }

    a {
      color: white;
    }
  </style>

</head>

<body>

  <?php

  $error = "";
  if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $user_result = mysqli_query($dbconnection, " SELECT* FROM users where email='$email' AND  password='$password'");
    $user_count = mysqli_num_rows($user_result);
    if ($user_count == 1) {
      $user_array = mysqli_fetch_assoc($user_result);
      $_SESSION['user_array'] = $user_array;
      if ($user_array['role'] == 'admin') {
        header("location:admin-dashboard.php");
      } else {
        header("location:user-dashboard.php");
      }
    } else {
      $error = "Email or Password Invalid!!";
    }
  }



  ?>
  <div class="container-fluid">
    <div calss="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-success">
            <div class="row">
              <div class="col-md-6">
                <div class="card-title"><a href="index.php">
                    <h6>Home</h6>
                  </a> </div>
              </div>
              <div class="col-md-6">
                <a href="index.php" class="float-right ml-3">
                  << Back</a>


              </div>

            </div>


          </div>
          <form method="POST" action='login.php'>

            <div class="card-body">
              <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">


                  <div class="card">
                    <div class="card-header bg-info">
                      <div class="card-title ">Login</div>
                    </div>
                    <div class="card-body">

                      <?php if ($error != "") { ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <strong><?php echo $error; ?></strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      <?php } ?>

                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email">
                      </div>

                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                      </div>


                    </div>

                    <div class="card-footer bg-info">
                      <button class="btn btn-danger" type="submit" name="login">Log in </button>
                      <span class=" float-right"> If you don't have an account yet, <a href="register.php">register</a></span>

                    </div>

          </form>
        </div>

      </div>
      <div class="col-md-3"></div>

    </div>



  </div>


  </div>

  </div>

  </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>