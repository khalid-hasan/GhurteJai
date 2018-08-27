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

  $hotel_title=data_sanitization($_POST['hotel_title']);
  $hotel_location=data_sanitization($_POST['hotel_location']);
  $hotel_desc=data_sanitization($_POST['hotel_desc']);
  $hotel_owner=data_sanitization($_POST['hotel_owner']);
  $addedBy= $_SESSION['user'];

  $statement="insert into hotels(title,location,image,hotel_desc,owner,addedBy) values ('$hotel_title','$hotel_location', '$target_file', '$hotel_desc', '$hotel_owner', '$addedBy')";

  if(mysqli_query($conn,$statement))
  {
    $update_user_role= "UPDATE users SET user_role= 'Owner' WHERE username= '$hotel_owner' ";
    mysqli_query($conn, $update_user_role);
    $notifyMsg="New Hotel Added";
  }
  else
  {
    $notifyMsg="Unable to add New Hotel";
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
  <title>Add New Hotel</title>

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
            <form role="form" name="hotels-new" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Hotel Name</label>
                  <input type="text" class="form-control" id="hotel-title" placeholder="Hotel Name" name="hotel_title" required >
                </div>
                <div class="form-group">
                  <label>Hotel Location</label>
                  <input type="text" class="form-control" id="hotel-location" placeholder="Hotel Name" name="hotel_location" required>
                </div>
                <div class="form-group">
                  <label>Hotel Description</label>
                  <textarea class="form-control" rows="3" id="hotel-desc" placeholder="Hotel Description" name="hotel_desc" required></textarea>
                </div>  
                <div class="form-group">
                  <label>Hotel Owner</label>
                  <select class="form-control" name="hotel_owner" required>
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
                  <label for="user-img">Upload Hotel Photo</label>
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