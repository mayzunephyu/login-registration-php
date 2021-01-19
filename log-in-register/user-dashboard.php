<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_array'])) {
    header("location:login.php");
} else {
    if ($_SESSION['user_array']['role'] != 'user') {
        header("location:admin-dashboard.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

    //read authenticated user data

    $auth_user_id = $_SESSION['user_array']['id'];
    $auth_user_result = mysqli_query($dbconnection, "SELECT* FROM users WHERE id= $auth_user_id");
    if ($auth_user_result) {
        $auth_user_array = mysqli_fetch_array($auth_user_result);
    } else {
        die("error: " . mysqli_error($dbconnection));
    }


    //user edit

    $user_edition_form_status = false;
    if (isset($_REQUEST['user_id'])) {

        $user_edition_form_status = true;
        $user_id_to_update = $_REQUEST['user_id'];
        $query = "SELECT * FROM users WHERE id=$user_id_to_update";
        $result = mysqli_query($dbconnection, $query);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
        } else {
            die("Error: " . mysqli_error($dbconnection));
        }
    }

    //user update

    $_SESSION['expire_time'] = 0;
    $_SESSION['successMsg'] = "";

    if (isset($_POST['user_update_btn'])) {
        $id = $_POST['id'];
        $user_result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$id");
        $user_array = mysqli_fetch_assoc($user_result);
        $old_password = $user_array['password'];

        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $input_password = $_POST['password'];

        $new_password = $old_password != $input_password ? md5($input_password) : $input_password;

        $query = "UPDATE users SET name='$name',email='$email',address='$address',password='$new_password' WHERE id= $id";
        $result = mysqli_query($dbconnection, $query);
        if ($result) {
            $_SESSION['expire_time'] = time() + (0.1 * 60);
            $_SESSION['successMsg'] = "success";
            $_SESSION['successMsg'] = "<script> swal('Good job!', 'update successful!', 'success');</script>";
            //header("location:user-dashboard.php");

        } else {
            die("Error: " . mysqli_error($dbconnection));
        }
    }

    if (time() < $_SESSION['expire_time']) {
        echo  $_SESSION['successMsg'];
    } else {
        unset($_SESSION['successMsg']);
        unset($_SESSION['expire_time']);
    }



    //var_dump( $_SESSION['successMsg']);


    ?>


    <div class="container-fluid">
        <div calss="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title"><a href="admin-dashboard.php">
                                        <h6>User-Dashboard </h6>
                                    </a> </div>
                            </div>
                            <div class="col-md-6">
                                <form method="get" action="logout.php">

                                    <button class="btn btn-danger float-right btn-sm" name="logoutButton" type="submit" onclick="return confirm('Are u sure to log out??');"> Logout</button>

                                </form>


                            </div>

                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">

                                        <h5> User info </h5>
                                        <div> Name: <?php echo  $auth_user_array['name'] ?> </div>
                                        <div> Role:<span class="badge badge-success"> <?php echo  $auth_user_array['role'] ?></span> </div>
                                        <div>Password: <?php echo  $auth_user_array['password'] ?></div>
                                        <div>Email: <?php echo  $auth_user_array['email'] ?></div>
                                        <div> Address: <?php echo  $auth_user_array['address'] ?></div>
                                        <div>
                                            <a href="user-dashboard.php?user_id=<?php echo  $auth_user_array['id'] ?>" class="btn btn-success">Edit Your Profile</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <?php if ($user_edition_form_status == true) { ?>
                                    <div class="card">

                                        <div class="card-header bg-success">
                                            <div class="card-heading">User Edition form</div>
                                        </div>
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="card-body">
                                                <div class="form-group">

                                                    <input type="hidden" name="id" class="form-control" value="<?php echo $user['id']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="text" name="password" class="form-control" value="<?php echo $user['password']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea name="address" class="form-control"><?php echo $user['address']; ?></textarea>
                                                </div>


                                            </div>

                                            <div class="card-footer form-group">
                                                <button type="submit" class="btn btn-primary" name="user_update_btn">Update</button>
                                            </div>



                                        </form>

                                    </div>


                            </div>

                        <?php } ?>

                        </div>

                    </div>




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