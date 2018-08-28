<?php


    include("config.php");

    $enquiry_id = $_GET['enquiry_id'];


    $result = mysqli_query($conn,"update tour_enquiry set status= 'calcel' where enquiry_id= '$enquiry_id';");

	
	
    header("Location:tours-show.php");

?>

