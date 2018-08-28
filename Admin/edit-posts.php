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

  $post_id = $_GET['post_id'];
  $_SESSION['post_id']= $post_id;

  $result = mysqli_query($conn, "select * from posts WHERE post_id='$post_id' ");

  while($res = mysqli_fetch_array($result))
  {
    $package_title= $res['title'];

    $package_desc= $res['description'];

    $cat_id= $res['cat_id'];

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

    $cat_idUpdated=data_sanitization($_POST['cat_id']);

    $package_descUpdated=mysqli_real_escape_string($conn, $_POST['package_desc']);

   $statement="UPDATE posts SET title= '$package_titleUpdated' , cat_id='$cat_idUpdated', description='$package_descUpdated', image='$image', last_modified='$_SESSION[user]' where post_id= '$_SESSION[post_id]'";


    if(mysqli_query($conn,$statement))
    {
        $notifyMsg="Post Updated";
        //header("location: $uri");
    }
    else
    {
        $notifyMsg="Unable To Update Post";
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
  <title>Edit Blog Post</title>

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
            <form role="form" name="tour-edit" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" id="package-name" placeholder="Package Name" name="package_name" value="<?php echo empty($package_titleUpdated) ? $package_title : $package_titleUpdated ?>" required>
                </div>
                
                <div class="form-group">
                   <label>Categoroy</label>
                  <select class="form-control" name="cat_id">
                    <option value="">-SELECT-</option>
                  <?php
                      require 'config.php';

                      $statement="select cat_id, title from categories where deletedAt is NULL order by cat_id asc";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            if($cat_id==$row[cat_id])
                            {
                              echo "<option value=\"$row[cat_id]\" selected>$row[title]</option>";
                            }
                            else
                            {
                              echo "<option value=\"$row[cat_id]\">$row[title]</option>";
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
                  <label>Package Description</label>
                  <textarea class="form-control" rows="3" id="packageDesc" placeholder="Package Description" name="package_desc"><?php echo empty($package_descUpdated) ? $package_desc : $package_descUpdated ?></textarea>
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