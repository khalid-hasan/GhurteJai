<?php
    if(!isset($_SESSION)) { session_start(); }
//including the database connection file
    include("config.php");
    //connect_db();
//getting id of the data from url
    $room_type_id = $_GET['room_type_id'];

//deleting the row from table // actually not deleting it just unlinking from the result
    //$result = mysqli_query($conn,"delete from test WHERE id='$id'");
    $result = mysqli_query($conn,"update room_type set deletedBy='$_SESSION[user]', deletedAt= CURRENT_TIMESTAMP where room_type_id= '$room_type_id';");
	//close_db();
//redirecting to the display page (listdata.php in our case)
    header("Location:all-room-types.php");

?>

