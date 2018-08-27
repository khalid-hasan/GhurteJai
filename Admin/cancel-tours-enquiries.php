<?php

//including the database connection file
    include("config.php");
    //connect_db();
//getting id of the data from url
    $enquiry_id = $_GET['enquiry_id'];

	$query=mysqli_query($conn, "SELECT * from tour_enquiry where enquiry_id= '$enquiry_id' ");
    $res= mysqli_fetch_assoc($query);
    $tour_id= $res['tour_id'];
    $child= $res['child'];
    $adult= $res['adult'];
    $total= $child+$adult;

	$query_available=mysqli_query($conn, "SELECT capacity, available from tours where tour_id= '$tour_id' ");
    $result_available= mysqli_fetch_assoc($query_available);
    $capacity= $result_available['capacity'];
    $available= $result_available['available'];

    $update_available_seat= $total+$available;

    if($available<=$capacity)
    {
	   	$update_available_room_query= "UPDATE tours SET available= '$update_available_seat' WHERE tour_id= '$tour_id' "; 	
	  	mysqli_query($conn, $update_available_room_query);   	
    }

//deleting the row from table // actually not deleting it just unlinking from the result
    //$result = mysqli_query($conn,"delete from test WHERE id='$id'");
    $result = mysqli_query($conn,"update tour_enquiry set deletedAt= CURRENT_TIMESTAMP where enquiry_id= '$enquiry_id';");
	//close_db();
//redirecting to the display page (listdata.php in our case)
    header("Location:all-tours-enquiry.php");

?>

