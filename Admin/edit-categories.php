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

  $cat_id = $_GET['cat_id'];
  $_SESSION['cat_id']= $cat_id;

  $result = mysqli_query($conn, "select * from categories WHERE cat_id='$cat_id' ");

  while($res = mysqli_fetch_array($result))
  {
    $cat_title= $res['title'];
  }

  if($_SERVER['REQUEST_METHOD']== "POST")
  {
    require 'config.php';


    $cat_titleUpdated=data_sanitization($_POST['cat_title']);

    
   $statement="UPDATE categories SET title= '$cat_titleUpdated', last_modified='$_SESSION[user]' WHERE cat_id= '$cat_id' ";


    if(mysqli_query($conn,$statement))
    {
        $notifyMsg="Categories Updated";
        //header("location: $uri");
    }
    else
    {
        $notifyMsg="Unable To Update Categories";
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
  <title>Edit Categories</title>

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
            <form role="form" name="categories-edit" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label>Categories Name</label>
                  <input type="text" class="form-control" id="cat-title" placeholder="Category Name" name="cat_title" value="<?php echo empty($cat_titleUpdated) ? $cat_title : $cat_titleUpdated ?>" required>
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