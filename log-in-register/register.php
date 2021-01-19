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
  include "connect.php";
  $nameErr = "";
  $emailErr = "";
  $addressErr = "";
  $passwordErr = "";
  $confirmPasswordErr = "";
  $name = $email = $address = $password = $confirm_password = "";



  if (isset($_POST['register_button'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if (empty($name)) {
      $nameErr = "The name field is required";
    }
    if (empty($email)) {
      $emailErr = "The email field is required";
    }
    if (empty($address)) {
      $addressErr = "The address field is required";
    }
    if (empty($password)) {
      $passwordErr = "The password field is required";
    }
    if (empty($confirm_password)) {
      $confirmPasswordErr = "The confirm password field is required";
    }
    if ($confirm_password != $password) {
      $confirmPasswordErr = "The  password doesn't match";
    }



    if (!empty($name) && !empty($email) && !empty($address) && !empty($password) && $confirm_password == $password) {
      $encrypt_pwd = md5($password);

      $query = "INSERT INTO users(name, email, address, password) VALUES('$name','$email','$address','$encrypt_pwd')";
      $result = mysqli_query($dbconnection, $query);
      if ($result == true) {
        echo "<script>alert('Registration successfull');</script>";
        header("location:login.php");
      } else {
        die("Error : " . mysqli_error($query));
      }
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
          <div class="card-body">
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">


                <div class="card">
                  <div class="card-header bg-info">
                    <div class="card-title ">Register</div>
                  </div>
                  <form method="POST" action="register.php">
                    <div class="card-body">

                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control 
                   <?php if ($nameErr != '') { ?> is-invalid  <?php  } ?>
                   " name="name" value="<?php echo $name; ?>">
                        <i class="text-danger"><?php echo $nameErr; ?></i>
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control 
                   <?php if ($emailErr != '') { ?> is-invalid  <?php  } ?>
                   " name="email" value="<?php echo $email; ?>">
                        <i class="text-danger"><?php echo $emailErr; ?></i>
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea type="text" class="form-control 
                   <?php if ($addressErr != '') { ?> is-invalid  <?php  } ?>
                   " row="3" name="address"><?php echo $address; ?></textarea>
                        <i class="text-danger"><?php echo $addressErr; ?></i>
                      </div>
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control 
                   <?php if ($passwordErr != '') { ?> is-invalid  <?php  } ?>
                   " name="password" value="<?php echo $password; ?>">
                        <i class="text-danger"><?php echo $passwordErr; ?></i>
                      </div>
                      <div class="form-group">
                        <label>Confirm Passowrd</label>
                        <input type="password" class="form-control 
                   <?php if ($confirmPasswordErr != '') { ?> is-invalid  <?php  } ?>
                   " name="confirm-password" value="<?php echo $confirm_password; ?>">
                        <i class="text-danger"><?php echo $confirmPasswordErr; ?></i>
                      </div>



                    </div>
                    <div class="card-footer bg-info">
                      <button class="btn btn-danger" type="submit" name="register_button">Register</button>
                      <span class=" float-right"> If you already have an account, <a href="login.php">Log in here</a></span>

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