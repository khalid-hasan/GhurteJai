<?php
    if(!isset($_SESSION)) { session_start(); }
	function data_sanitization($data)
{
	$data= trim($data);
	$data= stripcslashes($data);
	$data= htmlspecialchars($data);
	return $data;
}
    include("config.php");

  $user = $_GET['user'];

  $result = mysqli_query($conn, "select * from users WHERE username='$user' ");

  while($res = mysqli_fetch_array($result))
  {
    $username= $res['username'];
    $name= $res['name'];
    $email= $res['email'];
    $phone= $res['phone'];
    $user_role= $res['user_role'];
    $image= $res['image'];
    //$_SESSION['image']=$image;
  }

  if($_SERVER['REQUEST_METHOD']== "POST")
  {
    require 'config.php';
    $target_dir = "dist/img/";
    $target_file = $target_dir . basename($_FILES["user_img"]["name"]);
    if(move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file))
    {
      //$_SESSION['image']=$target_file;
      $image=$target_file;
    }
   
    $usernameUpdated=data_sanitization($_POST['username']);
    $passwordUpdated=data_sanitization($_POST['password']);
    $nameUpdated=data_sanitization($_POST['name']);
    $emailUpdated=data_sanitization($_POST['email']);
    $phoneUpdated=data_sanitization($_POST['phone']);
    $roleUpdated=data_sanitization($_POST['user_role']);

    if (empty($passwordUpdated)) 
    {
        $statement="UPDATE users SET username= '$usernameUpdated' , name='$nameUpdated', email='$emailUpdated', phone='$phoneUpdated', user_role='$roleUpdated', image='$image', last_modified='$_SESSION[user]' where username= '$usernameUpdated'";
    }
    else
    {
        $statement="UPDATE users SET username= '$usernameUpdated' , name='$nameUpdated', password= '$passwordUpdated', email='$emailUpdated', phone='$phoneUpdated', user_role='$roleUpdated', image='$image', last_modified='$_SESSION[user]' where username= '$usernameUpdated'";
    }

    if(mysqli_query($conn,$statement))
    {
        $notifyMsg="Profile Updated";
        //header("location: $uri");
    }
    else
    {
        $notifyMsg="Unable To Update Profile";
        mysqli_error($conn);
    }

    mysqli_close($conn);   
  }
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit Profile</title>

<?php include 'header.php';?>

<?php include 'sidebar.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Welcome!</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add New</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="profile-edit" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php echo empty($usernameUpdated) ? $username : $usernameUpdated ?> " required>
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Your Full Name" name="name" value="<?php echo empty($nameUpdated) ? $name : $nameUpdated ?> "required>
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="<?php echo empty($emailUpdated) ? $email : $emailUpdated ?> "required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="phone" value="<?php echo empty($phoneUpdated) ? $phone : $phoneUpdated ?> ">
                </div>

<?php if($_SESSION["user_role"]=="Admin")
{?>
                <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control" name="user_role">
                    <option value="">-SELECT-</option>
                    <option value="Admin" <?php echo empty($roleUpdated) ? ($user_role=="Admin" ? "selected" : "") : ($roleUpdated=="Admin" ? "selected" : "")  ?> >Admin</option>
                    <option value="user" <?php echo empty($roleUpdated) ? ($user_role=="user" ? "selected" : "") : ($roleUpdated=="user" ? "selected" : "")  ?> >user</option>
                    <option value="Owner" <?php echo empty($roleUpdated) ? ($user_role=="Owner" ? "selected" : "") : ($roleUpdated=="Owner" ? "selected" : "")  ?> >Owner</option>
                  </select>
                </div>
<?php }?>
                <div class="form-group">
                  <label for="user-img">Upload Your Photo</label>
                  <input type="file" id="user-img" name="user_img">

                  <p class="help-block">Image Dimension should 160x160.</p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">

              <div class="error">
                 <?php

                   if (!empty($notifyMsg)) 
                   {
                    echo "<p><span id=\"error\">$notifyMsg</span></p>";
                   }

                 ?>
              </div>

                <button type="submit" class="btn btn-primary">ADD</button>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php';?>