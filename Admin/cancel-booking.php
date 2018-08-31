<?php

    include("config.php");

    $enquiry_id = $_GET['enquiry_id'];

	$query=mysqli_query($conn, "SELECT * from hotel_enquiry where enquiry_id= '$enquiry_id' ");
    $res= mysqli_fetch_assoc($query);
    $hotel_id= $res['hotel_id'];
    $room_type_id= $res['room_type_id'];
    $total= $res['total_room'];

	$query_available=mysqli_query($conn, "SELECT capacity, available from room_type where room_type_id= '$room_type_id' ");
    $result_available= mysqli_fetch_assoc($query_available);
    $capacity= $result_available['capacity'];
    $available= $result_available['available'];

    $update_available_room= $total+$available;

    if($available<=$capacity)
    {
	   	$update_available_room_query= "UPDATE room_type SET available= '$update_available_room' WHERE hotel_id= '$hotel_id' and room_type_id= '$room_type_id' "; 	
	  	mysqli_query($conn, $update_available_room_query);   	
    }

    $result = mysqli_query($conn,"update hotel_enquiry set deletedAt= CURRENT_TIMESTAMP where enquiry_id= '$enquiry_id';");

	
	
    header("Location:booking-show.php");

?>

