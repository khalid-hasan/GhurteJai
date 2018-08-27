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
  move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file);

  $package_name=data_sanitization($_POST['package_name']);
  $package_location=data_sanitization($_POST['package_location']);
  $package_price=data_sanitization($_POST['package_price']);
  $package_duration=data_sanitization($_POST['package_duration']);
  $package_seat=data_sanitization($_POST['package_seat']);
  $package_desc=$_POST['package_desc'];
  $package_owner=data_sanitization($_POST['package_owner']);
  $addedBy= $_SESSION['user'];

  $statement="insert into tours(title,price,days,location,description,image,capacity,addedBy) values ('$package_name','$package_price', '$package_duration', '$package_location', '$package_desc', '$target_file', '$package_seat', '$addedBy')";

  if(mysqli_query($conn,$statement))
  {
    $update_user_role= "UPDATE users SET user_role= 'Owner' WHERE username= '$package_owner' ";
    mysqli_query($conn, $update_user_role);
    $notifyMsg="New Package Added";
  }
  else
  {
    $notifyMsg="Unable to add New Package";
    mysqli_error($conn);
  }
  
  //var_dump($statement);
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
  <title>Add New Tour Package</title>

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
            <form role="form" name="package-new" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Package Name</label>
                  <input type="text" class="form-control" id="package-name" placeholder="Package Name" name="package_name" required>
                </div>
                <div class="form-group">
                  <label>Package Location</label>
                  <input type="text" class="form-control" id="package-location" placeholder="Package Location" name="package_location" required>
                </div>
                <div class="form-group">
                  <label>Package Duration</label>
                  <input type="text" class="form-control" id="package-duration" placeholder="Package Duration" name="package_duration" required>
                </div>
                <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control" id="package-price" placeholder="Price" name="package_price"required>
                </div>
                <div class="form-group">
                  <label>Seats</label>
                  <input type="text" class="form-control" id="package-seat" placeholder="Seats" name="package_seat" required>
                </div>  
                <div class="form-group">
                  <label>Package Description</label>
                  <textarea class="form-control" rows="3" id="packageDesc" placeholder="Package Description" name="package_desc" required></textarea>
                </div>   
                <div class="form-group">
                  <label>Package Owner</label>
                  <select class="form-control" name="package_owner" required>
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      $statement="select username from users where deletedAt is null";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<option value=\"$row[username]\">$row[username]</option>";
                          }
                      }
                      else
                      {
                          echo "Nothing found in db";
                      }
                      mysqli_close($conn);
                  ?>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="user-img">Upload A Photo</label>
                  <input type="file" id="user-img" name="user_img" required>
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