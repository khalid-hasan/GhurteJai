<?php
    if(!isset($_SESSION)) { session_start(); }
    include("config.php");

  $hotel_id = $_GET['hotel_id'];
  $_SESSION['hotel_id']= $hotel_id;
  
  function data_sanitization($data)
{
	$data= trim($data);
	$data= stripcslashes($data);
	$data= htmlspecialchars($data);
	return $data;
}

  $result = mysqli_query($conn, "select * from hotels WHERE hotel_id='$hotel_id' ");

  while($res = mysqli_fetch_array($result))
  {
    $hotel_title= $res['title'];
    $hotel_location= $res['location'];
    $hotel_desc= $res['hotel_desc'];
    $hotel_owner= $res['owner'];
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

    $hotel_titleUpdated=data_sanitization($_POST['hotel_title']);
    $hotel_locationUpdated=data_sanitization($_POST['hotel_location']);
    $hotel_descUpdated=data_sanitization($_POST['hotel_desc']);
    $hotel_ownerUpdated=data_sanitization($_POST['hotel_owner']);

    
   $statement="UPDATE hotels SET title= '$hotel_titleUpdated' , location='$hotel_locationUpdated', image='$image', hotel_desc='$hotel_descUpdated', owner= '$hotel_ownerUpdated', last_modified='$_SESSION[user]' where hotel_id= '$_SESSION[hotel_id]' ";


    if(mysqli_query($conn,$statement))
    {
        $update_user_role= "UPDATE users SET user_role= 'Owner' WHERE username= '$hotel_ownerUpdated' ";
        mysqli_query($conn, $update_user_role);
        $notifyMsg="Hotel Updated";
        //header("location: $uri");
    }
    else
    {
        $notifyMsg="Unable To Update Hotel";
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
  <title>Edit Hotel</title>

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
            <form role="form" name="hotels-edit" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Hotel Name</label>
                  <input type="text" class="form-control" id="hotel-title" placeholder="Hotel Name" name="hotel_title" value="<?php echo empty($hotel_titleUpdated) ? $hotel_title : $hotel_titleUpdated ?>">
                </div>
                <div class="form-group">
                  <label>Hotel Location</label>
                  <input type="text" class="form-control" id="hotel-location" placeholder="Hotel Name" name="hotel_location" value="<?php echo empty($hotel_locationUpdated) ? $hotel_location : $hotel_locationUpdated ?>">
                </div>
                <div class="form-group">
                  <label>Hotel Description</label>
                  <textarea class="form-control" rows="3" id="hotel-desc" placeholder="Hotel Description" name="hotel_desc"><?php echo empty($hotel_descUpdated) ? $hotel_desc : $hotel_descUpdated ?></textarea>
                </div>
                <div class="form-group">
                  <label>Hotel Owner</label>
                  <select class="form-control" name="hotel_owner">
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      $statement="select username from users where deletedAt is null";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            if($hotel_owner==$row[username])
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
                  <label for="user-img">Upload Hotel Photo</label>
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