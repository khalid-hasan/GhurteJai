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
  <title>All Tour bookings</title>

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
              <h3 class="box-title">All Tour Booking</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Tour ID</th>
                  <th>Package Name</th>
      	          <th>Days</th> 
				          <th>Child</th>
				          <th>Adult</th>
                  <th>Action</th>
                </tr>
                <?php
                    require 'config.php';

                    
					            $usern = $_SESSION['user'];
                      $statement="select * from tour_enquiry where addedBy ='$usern' and deletedAt is NULL ";
                      $result = mysqli_query($conn, $statement);

                      if (mysqli_num_rows($result) > 0)
                      {
                          while($row = mysqli_fetch_assoc($result))
                          {
                            $tour_name_query=mysqli_query($conn, "SELECT title from tours where tour_id= $row[tour_id]");
                            $tour_name= mysqli_fetch_assoc($tour_name_query);
                            $tour_title= $tour_name['title'];

                            echo "<tr>"; 
                            echo "<td>".$row['tour_id']."</td>";
                            echo "<td>".$tour_title."</td>";
							              echo "<td>".$row['days']."</td>";							
                            echo "<td>".$row['child']."</td>";
                            echo "<td>".$row['adult']."</td>";
                         //   echo "<td>".$row['description']."</td>";
                            echo "<td><a href=\"cancel-tour.php?enquiry_id=$row[enquiry_id]\" onClick=\"return confirm('Are you sure you want to cancel?')\">Cancel</a> ";
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