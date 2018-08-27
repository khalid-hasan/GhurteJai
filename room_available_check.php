<?php

require 'config.php';

$hotel_id= $_POST['hotel_id'];
$room_type_id= $_POST['room_type_id'];
$required_room= $_POST['room_available'];

$query = mysqli_query($conn, "SELECT capacity, available FROM room_type WHERE hotel_id='$hotel_id' and room_type_id='$room_type_id' and deletedAt is NULL ");
$result=mysqli_fetch_assoc($query);
$capacity= $result['capacity'];
$available= $result['available'];
//$result = $my_dbhandle->query($screenNameSQL); //Query database
/*$numResults = mysqli_num_rows($query); //Count number of results

$resultCount = intval($numResults);*/


if($required_room > $available){
    echo "Sorry. No more rooms available.";
}
else
{
	echo "Room Available";
}

?>