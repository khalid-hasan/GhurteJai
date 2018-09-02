<?php
if(!isset($_SESSION)) { session_start(); }
function data_sanitization($data)
{
	$data= trim($data);
	$data= stripcslashes($data);
	$data= htmlspecialchars($data);
	return $data;
}
if($_SERVER['REQUEST_METHOD']== "POST")
{
  require 'config.php';

  $uniqueID = md5(rand() * time());
  $target_dir = "dist/img/";
  $target_file = $target_dir .$uniqueID. basename($_FILES["user_img"]["name"]);
  //move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file);
  
  $username=($_POST['username']);
  $password=($_POST['password']);
  $name=($_POST['name']);
  $email=($_POST['email']);
  $phone=($_POST['phone']);
  $role=($_POST['user_role']);
  

  $duplicate_check=mysqli_query($conn, "SELECT username from users where username='$username' and deletedAt is NULL ");
  $duplicate_count= mysqli_num_rows($duplicate_check);

  $statement="insert into users(username,name,password,email,phone,user_role,image) values ('$username','$name', '$password', '$email', '$phone', '$role', '$target_file')";


  if($duplicate_count>0)
  {
    $notifyMsg="Duplicate Entry";
  }
  else
  {
    if(mysqli_query($conn,$statement) && $duplicate_count==0 )
    {
      move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file);
      $notifyMsg="New User Added";
    }
    else
    {
      $notifyMsg="Unable to add New User"; 
    }
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
  <title>Add New User</title>

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
            <form role="form" name="user-new" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" id="username" placeholder="Username" name="username" required pattern="^([a-zA-Z0-9-_])+$" title="Please Enter Your  Username">
                </div>

                <div class="alert alert-primary username-unavailable" role="alert"></div>

                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Your Full Name" name="name" required pattern="^([a-zA-Z\s'-]+\.)*[a-zA-Z\s'-]+$" title="Please Enter Your Name">
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                </div>
                <div class="alert alert-primary email-unavailable" role="alert"></div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" name="password" required >
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="phone"required pattern="^[0-9]{3,15}$" title="Enter Your Phone Number">
                </div>

                <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control" name="user_role">
                    <option value="">-SELECT-</option>
                    <option value="Admin">Admin</option>
                    <option value="user">User</option>
                    <option value="Owner">Owner</option>
                  </select>
                </div>
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