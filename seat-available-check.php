<?php

require 'config.php';

$tour_id= $_POST['tour_id'];
$required_seat= $_POST['seat_available'];

$query = mysqli_query($conn, "SELECT capacity, available FROM tours WHERE tour_id='$tour_id' AND deletedAt is NULL ");
$result=mysqli_fetch_assoc($query);
$capacity= $result['capacity'];
$available= $result['available'];
//$result = $my_dbhandle->query($screenNameSQL); //Query database
/*$numResults = mysqli_num_rows($query); //Count number of results

$resultCount = intval($numResults);*/


if($required_seat > $available){
    echo "Sorry. No more seats available.";
}
else
{
	echo "Seats Available";
}

?>