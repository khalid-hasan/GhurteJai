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
  <title>All Room Types</title>

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
              <h3 class="box-title">All Room Types</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Room Type ID</th>
                  <th>Hotel ID</th>
                  <th>Room Type</th>
                  <th>Price</th>
                  <th>Capacity</th>
                  <th>Available</th>
                  <th>Description</th>
                  <th>Last Modified By</th>
                  <th>Action</th>
                </tr>
                <?php
                    require 'config.php';

                    if($_SESSION["user_role"]=="Admin")
                    {
                      $statement="select * from room_type where deletedAt is null order by room_type_id asc";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<tr>"; 
                            echo "<td>".$row['room_type_id']."</td>";
                            echo "<td>".$row['hotel_id']."</td>";
                            echo "<td>".$row['room_name']."</td>";
                            echo "<td>".$row['price']."</td>";
                            echo "<td>".$row['capacity']."</td>";
                            echo "<td>".$row['available']."</td>";
                            echo "<td width=\"35%\">".$row['room_desc']."</td>";
                            echo "<td>".$row['last_modified']."</td>";
                            echo "<td><a href=\"delete-room-types.php?room_type_id=$row[room_type_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a> | <a href=\"edit-room-types.php?room_type_id=$row[room_type_id]\">Edit</a></td>";
                            echo "</tr>";
                          }
                      }
                      else
                      {
                          echo "Nothing found in db";
                      }                      
                    }
                    else if($_SESSION["user_role"]=="Owner")
                    {
                      $statement="SELECT * FROM hotels, room_type WHERE hotels.hotel_id=room_type.hotel_id and hotels.deletedAt is NULL and room_type.deletedAt is NULL and hotels.owner='$_SESSION[user]' order by room_type.room_type_id asc";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            echo "<tr>"; 
                            echo "<td>".$row['room_type_id']."</td>";
                            echo "<td>".$row['hotel_id']."</td>";
                            echo "<td>".$row['room_name']."</td>";
                            echo "<td>".$row['price']."</td>";
                            echo "<td>".$row['capacity']."</td>";
                            echo "<td>".$row['available']."</td>";
                            echo "<td width=\"35%\">".$row['room_desc']."</td>";
                            echo "<td>".$row['last_modified']."</td>";                            
                            echo "<td><a href=\"delete-room-types.php?room_type_id=$row[room_type_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a> | <a href=\"edit-room-types.php?room_type_id=$row[room_type_id]\">Edit</a></td>";
                            echo "</tr>";
                          }
                      }
                      else
                      {
                          echo "Nothing found in db";
                      } 
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