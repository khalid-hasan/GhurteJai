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

  $room_type_id = $_GET['room_type_id'];
  $_SESSION['room_type_id']= $room_type_id;

  $result = mysqli_query($conn, "select * from room_type WHERE room_type_id='$room_type_id' ");

  while($res = mysqli_fetch_array($result))
  {
    $room_type_id= $res['room_type_id'];
    $hotel_id= $res['hotel_id'];
    $room_name= $res['room_name'];
    $room_desc= $res['room_desc'];
    $price= $res['price'];
    $capacity= $res['capacity'];
    $available= $res['available'];
    $image= $res['image'];
  }

  if($_SERVER['REQUEST_METHOD']== "POST")
  {
    require 'config.php';

    $uniqueID = md5(rand() * time());
    $target_dir = "dist/img/";
    $target_file = $target_dir . $uniqueID. basename($_FILES["user_img"]["name"]);
    
    if(move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file))
    {
      $image=$target_file;
    }

  
    $hotel_idUpdated=data_sanitization($_POST['hotel_id']);
    $room_nameUpdated=data_sanitization($_POST['room_type']);
    $room_descUpdated=data_sanitization($_POST['room_desc']);
    $room_priceUpdated=data_sanitization($_POST['room_price']);
    $room_capacityUpdated=data_sanitization($_POST['room_capacity']);
    $room_availableUpdated=data_sanitization($_POST['room_available']);

    
   $statement="UPDATE room_type SET hotel_id= '$hotel_idUpdated' , room_name='$room_nameUpdated', room_desc='$room_descUpdated', price='$room_priceUpdated', capacity= '$room_capacityUpdated', available='$room_availableUpdated', image='$image', last_modified='$_SESSION[user]' where room_type_id= '$_SESSION[room_type_id]' ";


  if(mysqli_query($conn,$statement))
  {
    $notifyMsg="New Room Type Updated";
  }
  else
  {
    $notifyMsg="Unable to update New Room Type";  
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
  <title>Add New Room Type</title>

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
            <form role="form" name="room-type-new" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Hotel Name</label>
                  <select class="form-control" name="hotel_id">
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      if($_SESSION['user_role']== "Admin")
                      {
                        $statement="select hotel_id, title from hotels where deletedAt is null order by hotel_id asc";
                        $result = mysqli_query($conn, $statement);

                        if (mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                              if($hotel_id==$row[hotel_id])
                              {
                                echo "<option value=\"$row[hotel_id]\" selected>$row[title]</option>";
                              }
                              else
                              {
                                echo "<option value=\"$row[hotel_id]\" disabled>$row[title]</option>";
                              }
                            }
                        }
                        else
                        {
                            echo "Nothing found in db";
                        }                        
                      }
                      else if($_SESSION['user_role']== "Owner")
                      {
                        $statement="select hotel_id, title from hotels where owner='$_SESSION[user]' and deletedAt is null order by hotel_id asc";
                        $result = mysqli_query($conn, $statement);

                        if (mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                              if($hotel_id==$row[hotel_id])
                              {
                                echo "<option value=\"$row[hotel_id]\" selected>$row[title]</option>";
                              }
                              else
                              {
                                echo "<option value=\"$row[hotel_id]\" disabled>$row[title]</option>";
                              }
                            }
                        }
                        else
                        {
                            echo "Nothing found in db";
                        }
                      }

                      mysqli_close($conn);
                  ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Room Type</label>
                  <select class="form-control" name="room_type">
                    <option value="">-SELECT-</option>
                    <option value="Single" <?php echo empty($room_nameUpdated) ? ($room_name=="Single" ? "selected" : "disabled") : ($room_nameUpdated=="Single" ? "selected" : "disabled")  ?> >Single</option>
                    <option value="Double" <?php echo empty($room_nameUpdated) ? ($room_name=="Double" ? "selected" : "disabled") : ($room_nameUpdated=="Double" ? "selected" : "disabled")  ?>>Double</option>
                    <option value="Triple" <?php echo empty($room_nameUpdated) ? ($room_name=="Triple" ? "selected" : "disabled") : ($room_nameUpdated=="Triple" ? "selected" : "disabled")  ?>>Triple</option>
                    <option value="Quad" <?php echo empty($room_nameUpdated) ? ($room_name=="Quad" ? "selected" : "disabled") : ($room_nameUpdated=="Quad" ? "selected" : "disabled")  ?>>Quad</option>
                    <option value="Presidential" <?php echo empty($room_nameUpdated) ? ($room_name=="Presidential" ? "selected" : "disabled") : ($room_nameUpdated=="Presidential" ? "selected" : "disabled")  ?>>Presidential</option>
                    <option value="Family" <?php echo empty($room_nameUpdated) ? ($room_name=="Family" ? "selected" : "disabled") : ($room_nameUpdated=="Family" ? "selected" : "disabled")  ?>>Family</option>Triple
                  </select>
                </div>
                <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control" id="room-price" placeholder="Price" name="room_price" value="<?php echo empty($room_priceUpdated) ? $price : $room_priceUpdated ?>" required>
                </div>
                <div class="form-group">
                  <label>Capacity</label>
                  <input type="text" class="form-control" id="room-capacity" placeholder="Capacity" name="room_capacity" value="<?php echo empty($room_capacityUpdated) ? $capacity : $room_capacityUpdated ?>" required>
                </div>
                <div class="form-group">
                  <label>Available</label>
                  <input type="text" class="form-control" id="room-capacity" placeholder="Available" name="room_available" value="<?php echo empty($room_availableUpdated) ? $available : $room_availableUpdated ?>" required>
                </div>
                <div class="form-group">
                  <label>Room Description</label>
                  <textarea class="form-control" rows="3" placeholder="Room Description" name="room_desc"><?php echo empty($room_descUpdated) ? $room_desc : $room_descUpdated ?></textarea>
                </div> 
                <div class="form-group">
                  <label for="user-img">Upload Room Photo</label>
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