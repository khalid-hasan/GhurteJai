<?php
    if(!isset($_SESSION)) { session_start(); }
//including the database connection file
    include("config.php");
    //connect_db();
//getting id of the data from url
    $cat_id = $_GET['cat_id'];

//deleting the row from table // actually not deleting it just unlinking from the result
    //$result = mysqli_query($conn,"delete from test WHERE id='$id'");
    $result = mysqli_query($conn,"update categories set deletedBy='$_SESSION[user]', deletedAt= CURRENT_TIMESTAMP where cat_id= '$cat_id';");
	//close_db();
//redirecting to the display page (listdata.php in our case)
    header("Location:categories.php");

?>

