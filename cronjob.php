<?php

require 'config.php';

date_default_timezone_set("Asia/Dhaka");

$statement="SELECT * FROM hotel_enquiry, room_type where hotel_enquiry.hotel_id= room_type.hotel_id and hotel_enquiry.room_type_id= room_type.room_type_id and room_type.deletedAt is NULL";

$result = mysqli_query($conn, $statement);

if (mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
    	 $checkout_time= $row['checkout'] . "01:42:00";
    	 $checkout= strtotime($checkout_time);

    	 if(time() > $checkout)
    	 {
    	 	$update_available= $row['available'] + $row['count'];

    	 	$count= 0;

       	    $update_count= "UPDATE hotel_enquiry SET count= '$count' WHERE hotel_id= '$row[hotel_id]' and room_type_id= '$row[room_type_id]' "; 	
  		    mysqli_query($conn, $update_count);     	 		


    	 	if($update_available <= $row['capacity'])
    	 	{
      	 		$update_available_room_query= "UPDATE room_type SET available= '$update_available' WHERE hotel_id= '$row[hotel_id]' and room_type_id= '$row[room_type_id]' "; 	
  				mysqli_query($conn, $update_available_room_query);   	 		
    	 	}
    	 }
    }
}
else
{
    echo "Nothing found in db";
}
mysqli_close($conn);    

?>