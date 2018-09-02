<?php

$email = $_POST['email'];

$conn=mysqli_connect("localhost","root","","travel_db");
$screenNameSQL = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email' ");
$result=mysqli_fetch_assoc($screenNameSQL);
//$result = $my_dbhandle->query($screenNameSQL); //Query database
$numResults = mysqli_num_rows($screenNameSQL); //Count number of results


if($numResults > 0){
    echo "Email already exists.";
}
else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) 
{
	echo "Invalid Email Adress.";
}
else
{
	echo "Valid Email";
}

?>