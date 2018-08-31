<?php
    if(!isset($_SESSION)) { session_start(); }
//including the database connection file
    include("config.php");
    //connect_db();
//getting id of the data from url
    $user = $_GET['user'];

//deleting the row from table // actually not deleting it just unlinking from the result
    //$result = mysqli_query($conn,"delete from test WHERE id='$id'");
    $result = mysqli_query($conn,"update users set deletedBy='$_SESSION[user]',deletedAt= CURRENT_TIMESTAMP where username= '$user';");
	//close_db();
//redirecting to the display page (listdata.php in our case)
    header("Location:all-users.php");

?>

