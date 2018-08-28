<?php
    if(!isset($_SESSION)) { session_start(); }
	function data_sanitization($data)
    {
	  $data= trim($data);
	  $data= stripcslashes($data);
	  $data= htmlspecialchars($data);
	  return $data;
    }
    require("config.php");

  $tour_id = $_GET['tour_id'];
  $_SESSION['tour_id']= $tour_id;

  $result = mysqli_query($conn, "select * from tours WHERE tour_id='$tour_id' ");

  while($res = mysqli_fetch_array($result))
  {
    $package_title= $res['title'];
    $package_location= $res['location'];
    $package_price= $res['price'];
    $package_days= $res['days'];
    $package_days= $res['days'];
    $package_seat= $res['capacity'];
    $package_desc= $res['description'];
    $package_owner= $res['owner'];
    $image= $res['image'];

  }

  if($_SERVER['REQUEST_METHOD']== "POST")
  {
    require 'config.php';

    $uniqueID = md5(rand() * time());
    $target_dir = "dist/img/";
    $target_file = $target_dir .$uniqueID. basename($_FILES["user_img"]["name"]);
    if(move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file))
    {
      //$_SESSION['image']=$target_file;
      $image=$target_file;
    }

    $package_titleUpdated=data_sanitization($_POST['package_name']);
    $package_locationUpdated=data_sanitization($_POST['package_location']);
    $package_priceUpdated=data_sanitization($_POST['package_price']);
    $package_daysUpdated=data_sanitization($_POST['package_duration']);
    $package_seatUpdated=data_sanitization($_POST['package_seat']);
    $package_descUpdated=$_POST['package_desc'];
    $package_ownerUpdated=data_sanitization($_POST['package_owner']);

    
   $statement="UPDATE tours SET title= '$package_titleUpdated' , price= '$package_priceUpdated', days='$package_daysUpdated', location='$package_locationUpdated', description='$package_descUpdated', image='$image', capacity='$package_seatUpdated', owner='$package_ownerUpdated', last_modified='$_SESSION[user]' where tour_id= '$_SESSION[tour_id]'";


    if(mysqli_query($conn,$statement))
    {
        $update_user_role= "UPDATE users SET user_role= 'Owner' WHERE username= '$package_ownerUpdated' ";
        mysqli_query($conn, $update_user_role);
        $notifyMsg="Package Updated";
        //header("location: $uri");
    }
    else
    {
        $notifyMsg="Unable To Update Package";
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
  <title>Edit Tour Packages</title>

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
              <h3 class="box-title">Edit Tour</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="tour-edit" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Package Name</label>
                  <input type="text" class="form-control" id="package-name" placeholder="Package Name" name="package_name" value="<?php echo empty($package_titleUpdated) ? $package_title : $package_titleUpdated ?>">
                </div>
                <div class="form-group">
                  <label>Package Location</label>
                  <input type="text" class="form-control" id="package-location" placeholder="Package Location" name="package_location" value="<?php echo empty($package_locationUpdated) ? $package_location : $package_locationUpdated ?>">
                </div>
                <div class="form-group">
                  <label>Package Duration</label>
                  <input type="text" class="form-control" id="package-duration" placeholder="Package Duration" name="package_duration" value="<?php echo empty($package_daysUpdated) ? $package_days : $package_daysUpdated ?>">
                </div>
                <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control" id="package-price" placeholder="Price" name="package_price" value="<?php echo empty($package_priceUpdated) ? $package_price : $package_priceUpdated ?>" required>
                </div>
                <div class="form-group">
                  <label>Seats</label>
                  <input type="text" class="form-control" id="package-seat" placeholder="Seats" name="package_seat" value="<?php echo empty($package_seatUpdated) ? $package_seat : $package_seatUpdated ?>" required>
                </div>
                <div class="form-group">
                  <label>Package Description</label>
                  <textarea class="form-control" rows="3" id="packageDesc" placeholder="Package Description" name="package_desc"><?php echo empty($package_descUpdated) ? $package_desc : $package_descUpdated ?></textarea>
                </div>  
                <div class="form-group">
                  <label>Package Owner</label>
                  <select class="form-control" name="package_owner">
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      $statement="select username from users where deletedAt is null";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            if($package_owner==$row[username])
                            {
                              echo "<option value=\"$row[username]\" selected>$row[username]</option>";
                            }
                            else
                            {
                              echo "<option value=\"$row[username]\">$row[username]</option>";
                            }
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
                  <input type="file" id="user-img" name="user_img">
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

                <button type="submit" class="btn btn-primary">UPDATE</button>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   
<?php include 'footer.php';?>