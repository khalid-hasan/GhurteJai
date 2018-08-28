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

  $cat_id=data_sanitization($_POST['cat_id']);
  $post_title=data_sanitization($_POST['post_title']);
  $post_desc= mysqli_real_escape_string($conn, $_POST['post_desc']);
  $addedBy= $_SESSION['user'];
 
  $statement="insert into posts(cat_id,title,description,addedBy,image) values ('$cat_id','$post_title', '$post_desc', '$addedBy', '$target_file')";
  
  if(mysqli_query($conn,$statement))
  {
    $notifyMsg="New Post Added";
  }
  else
  {
    $notifyMsg="Unable to add New Post";
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
  <title>Add New Post</title>

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
                  <label>Title</label>
                  <input type="text" class="form-control" id="post_title" placeholder="Post Title" name="post_title" required>
                </div>
			          <div class="form-group">
                  <label>Categoroy</label>
                  <select class="form-control" name="cat_id">
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      $statement="select cat_id, title from categories where deletedAt is NULL";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<option value=\"$row[cat_id]\">$row[title]</option>";
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
                  <label>Post Description</label>
                  <textarea class="form-control" rows="3" id="packageDesc" placeholder="Post Description" name="post_desc"></textarea>
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

                <button type="submit" class="btn btn-primary">ADD</button>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php';?>