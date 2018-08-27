<?php

//including the database connection file
    include("config.php");
    //connect_db();
//getting id of the data from url
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


//deleting the row from table // actually not deleting it just unlinking from the result
    //$result = mysqli_query($conn,"delete from test WHERE id='$id'");
    $result = mysqli_query($conn,"update hotel_enquiry set deletedAt= CURRENT_TIMESTAMP where enquiry_id= '$enquiry_id';");
	//close_db();
//redirecting to the display page (listdata.php in our case)
    header("Location:all-hotels-enquiry.php");

?>

