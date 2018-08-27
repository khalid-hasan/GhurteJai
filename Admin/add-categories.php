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



  if($_SERVER['REQUEST_METHOD']== "POST")
  {
    require 'config.php';

    $cat_title=data_sanitization($_POST['cat_title']);



    
  $statement="insert into categories(title) values ('$cat_title')";

    if(mysqli_query($conn,$statement))
    {
        $notifyMsg="Catagories Updated";
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
  <title>Add Categories</title>

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
                  <label>Category Name</label>
                  <input type="text" class="form-control" id="cat-title" placeholder="Category Name" name="cat_title" required>
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