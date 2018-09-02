<?php

$username = $_POST['username'];

$conn=mysqli_connect("localhost","root","","travel_db");
$screenNameSQL = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username' ");
$result=mysqli_fetch_assoc($screenNameSQL);
//$result = $my_dbhandle->query($screenNameSQL); //Query database
$numResults = mysqli_num_rows($screenNameSQL); //Count number of results


if($numResults > 0){
    echo "Username already exists.";
}
else if (!preg_match("/^([a-zA-Z0-9-_])+$/", $username)) 
{
	echo "Username can contain Letters, Numbers, Hyphen and Underscore.";
}
else
{
	echo "Username Available";
}

?>