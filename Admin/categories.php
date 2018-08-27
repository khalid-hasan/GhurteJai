<?php if(!isset($_SESSION)) { session_start(); } ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>All Categories</title>

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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Categories</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Categories</th>
                  <th>Action</th>
                </tr>
                <?php
                    require 'config.php';

                    $statement="select * from categories where deletedAt is null order by cat_id asc";
                    $result = mysqli_query($conn, $statement);

                    if (mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                          echo "<tr>"; 
                          echo "<td>".$row['cat_id']."</td>";
                          echo "<td>".$row['title']."</td>";
                          echo "<td><a href=\"delete-categories.php?cat_id=$row[cat_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a> | <a href=\"edit-categories.php?cat_id=$row[cat_id]\">Edit</a></td>";
                          echo "</tr>";
                        }
                    }
                    else
                    {
                        echo "Nothing found in db";
                    }
                    mysqli_close($conn);
                ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php';?>