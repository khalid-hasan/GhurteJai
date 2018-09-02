<?php
  session_start();

  $addedBy = $_SESSION['user'];

if($_SESSION['redirect'] != "redirect" )
{
  header("Location: hotels.php");
}

  extract($_SESSION['post']);

include 'functions.php';

if(empty($_SESSION['currency']) || $_SESSION['currency']=="USD")
{
	$_SESSION['currency']="USD";
	$_SESSION['c_from']= "BDT";
	$_SESSION['c_to']= "USD";
	$_SESSION['c_symbol']= "$";
}
else if($_SESSION['currency']=="BDT")
{
	$_SESSION['c_from']= "USD";
	$_SESSION['c_to']= "BDT";
    $_SESSION['c_symbol']= "৳";
}

  date_default_timezone_set("Asia/Dhaka");

function data_sanitization($data)
{
	$data= trim($data);
	$data= stripcslashes($data);
	$data= htmlspecialchars($data);
	return $data;
}


if($_SERVER['REQUEST_METHOD']== "POST")
{
  require 'config.php';
  $hotel_name_query=mysqli_query($conn, "SELECT title from hotels where hotel_id= $_SESSION[hotel_id]");
  $hotel_name= mysqli_fetch_assoc($hotel_name_query);
  $hotel_title= $hotel_name['title'];
  
 
  $hotel_room_price_query=mysqli_query($conn, "SELECT price from room_type where hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' ");
  $room_price= mysqli_fetch_assoc($hotel_room_price_query);
  $price= $room_price['price'];
  
  $room_name_query=mysqli_query($conn, "SELECT room_name from room_type where room_type_id= $_SESSION[room_type_id]");
  $room_name= mysqli_fetch_assoc($room_name_query);
  $room_title= $room_name['room_name'];	
  
  $tid= 'TRX'.rand(100000, 999999);
  $to = "ghurtejai18@gmail.com"; // this is your Email address
  $from = $enq_hotel_email; // this is the sender's Email address
  $subject = "Confirmation Booking ";
  $subject2 = "Response from " .$hotel_title. " for booking by GhurteJai.com";
  $message = " Name: ".$enq_hotel_name. "\n Hotel name: ".$hotel_title."\n User Name: ".$enq_hotel_name." \n Room Type: ".$room_title."\n User email: ".$enq_hotel_email."\n User Phone Number: ".$enq_hotel_phone."\n User Check-In date : ".$enq_hotel_checkin."\n User Check-Out date: ".$enq_hotel_checkout."\n Numbers Of Room: ".$enq_hotel_room."\n Adults: ".$enq_hotel_adult."\n Per Room price $: ".$price."/day\n Payment Method: ".$_POST['options']." \n Transaction ID: ".$tid." \n Total Ammount: $".$enq_hotel_room*$price."";
  $message2 = "Dear ".$enq_hotel_name. ", \n Thanks for your Booking at ".$hotel_title."\n Name: ".$enq_hotel_name." \n Phone Number: ".$enq_hotel_phone."\n Room Type: ".$room_title."\n Check-In date: ".$enq_hotel_checkin."\n Check-Out date: ".$enq_hotel_checkout."\n Numbers Of Room: ".$enq_hotel_room."\n Adults: ".$enq_hotel_adult."\n Payment Method: ".$_POST['options']." \n Transaction ID: ".$tid." \n Per Room price: $".$price."/Day\n Total Ammount: $".$enq_hotel_room*$price." \n\n Thanks for booking at ".$hotel_title.".\n\n For Further query contact with us.";

  $headers = "From:" . $from;
  $headers2 = "From:" . $to;
  mail($to,$subject,$message,$headers);
  mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
  //$notifyMsg= "Mail Sent. Thank you " .$enq_hotel_name . ", we will contact you shortly.";
  // You can also use header('Location: thank_you.php'); to redirect to another page.


  $statement="insert into hotel_enquiry(hotel_id, room_type_id, name, email, phone, checkin, checkout, total_room, child, adult, message, count, addedBy) values ('$_SESSION[hotel_id]', '$_SESSION[room_type_id]', '$enq_hotel_name', '$enq_hotel_email', '$enq_hotel_phone', '$enq_hotel_checkin', '$enq_hotel_checkout', '$enq_hotel_room', '$enq_hotel_child', '$enq_hotel_adult', '$enq_hotel_message', '$enq_hotel_room', '$addedBy')";

$room_available_query=mysqli_query($conn, "SELECT * FROM room_type WHERE hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' and deletedAt is NULL ");

$room_available= mysqli_fetch_assoc($room_available_query);
$available= $room_available['available'];
$favailable= $room_available['favailable'];



  if(mysqli_query($conn,$statement))
  {
    $notifyMsg="Enquiry Sent";
  }
  else
  {
    $notifyMsg="Unable to send Enquiry";
    mysqli_error($conn);
  }	
  
  $update_available_room= $available-$enq_hotel_room;
  $update_available_room_f= $favailable+$enq_hotel_room;


  
  $statement1="SELECT * FROM hotel_enquiry WHERE hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' and checkout='$_SESSION[enq_hotel_checkin]' and deletedAt is NULL";

  $result = mysqli_query($conn, $statement1);

  if (mysqli_num_rows($result) > 0)
   {
         while($row = mysqli_fetch_assoc($result))
		 {
		  $checkout_time= $row['checkout'];

    	 	//$update_available= $row['available'] + $row['count'];
		//var_dump($checkout_time);
		if($available<=0 && $checkout_time=$_SESSION['enq_hotel_checkin'] )
         {
             $update_available_room_query= "UPDATE room_type,hotel_enquiry SET room_type.available='$update_available_room',room_type.favailable= '$update_available_room_f',hotel_enquiry.flag='1' WHERE room_type.hotel_id= '$_SESSION[hotel_id]' and room_type.room_type_id= '$_SESSION[room_type_id]' and hotel_enquiry.hotel_id= '$_SESSION[hotel_id]' and hotel_enquiry.room_type_id= '$_SESSION[room_type_id]' and hotel_enquiry.checkout='$_SESSION[enq_hotel_checkin]' "; 	
  	         mysqli_query($conn, $update_available_room_query);  
         }
    	 	 // $flag= 0;

       	     // $update_flag= "UPDATE hotel_enquiry SET flag= '$flag' WHERE hotel_id= '$row[hotel_id]' and room_type_id= '$row[room_type_id]' "; 	
  		     // mysqli_query($conn, $update_flag); 

    	 // if($_SESSION['enq_hotel_checkin']== $checkout_time)
    	 // {
    	 	//$update_available= $row['available'] + $row['count'];

    	 	//$count= 0;
			// $flag=1;

       	    // $update_flag= "UPDATE hotel_enquiry SET flag='$flag' WHERE hotel_id= '$row[hotel_id]' and room_type_id= '$row[room_type_id]' "; 	
  		    // mysqli_query($conn, $update_count);     	 		


    	 	// if($update_available <= $row['capacity'])
    	 	// {
      	 		// $update_available_room_query= "UPDATE room_type SET available= '$update_available' WHERE hotel_id= '$row[hotel_id]' and room_type_id= '$row[room_type_id]' "; 	
  				// mysqli_query($conn, $update_available_room_query);   	 		
    	 	// }
    	 // }			
		 }
   }

  

  if($available>=0)
   {  
     $update_available_room_query= "UPDATE room_type SET available= '$update_available_room' WHERE hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' "; 	
  	 mysqli_query($conn, $update_available_room_query);
   }
  // elseif($available<=0 && $checkout_time=$_SESSION['enq_hotel_checkin'] )
   // {
     // $update_available_room_query= "UPDATE room_type SET available='$update_available_room',favailable= '$update_available_room_f' WHERE hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' "; 	
  	 // mysqli_query($conn, $update_available_room_query);  
   // }
  }


?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Confirm Your Booking</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link rel="stylesheet" href="Admin/dist/css/public.css" />

	<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="css/flexslider.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	
	<!-- Date Picker -->
	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>

<?php include 'Admin/login.php'; ?>

	<div class="colorlib-loader"></div>

	<div id="page">

<?php include 'nav.php'; ?>

		<aside id="colorlib-hero">
			<div class="flexslider">
				<ul class="slides">
			   	<li style="background-image: url(images/cover-img-18.jpg);">
			   		<div class="overlay"></div>
			   		<div class="container-fluid">
			   			<div class="row">
				   			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
				   				<div class="slider-text-inner text-center">
				   					<h1>Confirm Your Booking</h1>
				   				</div>
				   			</div>
				   		</div>
			   		</div>
			   	</li>
			  	</ul>
		  	</div>
		</aside>

		<div class="colorlib-wrap">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12">
								<div class="wrap-division">	
								<?php
							    require 'config.php';

							    $hotel_name_query=mysqli_query($conn, "SELECT title from hotels where hotel_id= '$_SESSION[hotel_id]' ");
			                    $hotel_name= mysqli_fetch_assoc($hotel_name_query);
			                    $hotel_title= $hotel_name['title'];

							    $room_name_query=mysqli_query($conn, "SELECT room_name from room_type where room_type_id= $_SESSION[room_type_id]");
			                    $room_name= mysqli_fetch_assoc($room_name_query);
			                    $room_title= $room_name['room_name'];			                    

							    $hotel_room_price_query=mysqli_query($conn, "SELECT price from room_type where hotel_id= '$_SESSION[hotel_id]' and room_type_id= '$_SESSION[room_type_id]' ");
			                    $room_price= mysqli_fetch_assoc($hotel_room_price_query);
			                    $price_room= $room_price['price'];

									echo "<div class=\"col-md-12 col-md-offset-0 heading2 animate-box\">";
										echo "<h2>$hotel_title - Confirm Booking</h2>";
									echo "</div>";
									echo "<div class=\"row\">";

								if($_SESSION['currency']=="USD")
								{
									$price= $price_room;
								}
								else if($_SESSION['currency']=="BDT")
								{
									$price= convertCurrency($price_room, $_SESSION['c_from'], $_SESSION['c_to']);
								}
								
			                    mysqli_close($conn);
								?>			
										<div class="col-md-12 animate-box">
											<div class="room-wrap">
												<div class="row">
            									  <form role="form" name="hotels-enq" method="post" action="">

								                    <div class="form-group">
								                        <label>Name:</label> <?php echo $enq_hotel_name; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Email:</label> <?php echo $enq_hotel_email; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Phone:</label> <?php echo $enq_hotel_phone; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Check-In Time:</label> <?php echo $enq_hotel_checkin; ?>
								                    </div>								                    					
								                    <div class="form-group">
								                        <label>Check-Out Time:</label> <?php echo $enq_hotel_checkout; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Number Of Rooms:</label> <?php echo $enq_hotel_room; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Number Of Children:</label> <?php echo $enq_hotel_child; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Number Of Adults:</label> <?php echo $enq_hotel_adult; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Your Message:</label> <?php echo $enq_hotel_message; ?>
								                    </div>	


												    <div class="text-center">
												        <h1>Receipt</h1>
												    </div>
												    </span>
												    <table class="table table-hover">
												        <thead>
												            <tr>
												                <th>Details</th>
												                <th class="text-center">Room(s)</th>
												                <th class="text-center">Price</th>
												            </tr>
												        </thead>
												        <tbody>
												            <tr>
												                <td class="col-md-9"><em><?php echo $hotel_title . "- ". $room_title ?></em></h4></td>
												                <td class="col-md-1 text-center"> <?php echo $enq_hotel_room; ?> </td>
												                <td class="col-md-1 text-center"><?php echo $_SESSION['c_symbol'].$price; ?></td>
												            </tr>
												            <tr>
												                <td>   </td>
												                <td class="text-right"><h4><strong>Total: </strong></h4></td>
												                <td class="text-center text-danger"><h4><strong><?php echo $_SESSION['c_symbol'].$enq_hotel_room*$price; ?></strong></h4></td>
												            </tr>
												        </tbody>
												    </table>

													<div class="paymentCont">
													    <div class="headingWrap">
													            <h3 class="headingTop text-center">Select Your Payment Method</h3>  
													    </div>
													    <div class="paymentWrap">
													        <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
													            <label class="btn paymentMethod active">
													                <div class="method visa"></div>
													                <input type="radio" name="options" value="Visa" required> 
													            </label>
													            <label class="btn paymentMethod">
													                <div class="method master-card"></div>
													                <input type="radio" name="options" value="Master-Card"> 
													            </label>
													            <label class="btn paymentMethod">
													                <div class="method bkash"></div>
													                <input type="radio" name="options" value="bKash">
													            </label>
													             <label class="btn paymentMethod">
													                <div class="method cod"></div>
													                <input type="radio" name="options" value="Cash-On-Booth"> 
													            </label>
													        </div>        
													    </div>
													</div>


									                 <?php

									                   if (!empty($notifyMsg)) 
									                   {
									                   	echo "<div class=\"alert alert-primary\" role=\"alert\">";
									                    echo "<p><span id=\"error\">$notifyMsg</span></p>";
									                    echo "</div>";
									                   }

									                 ?>	

                  									<button type="submit" name="submit" class="btn btn-primary">Pay Now</button>
                  								   </form>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>

<?php include 'sidebar.php'; ?>

				</div>
			</div>
		</div>
	</div>

	
		<div id="colorlib-subscribe" style="background-image: url(images/img_bg_2.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center colorlib-heading animate-box">
						<h2>Sign Up for a Newsletter</h2>
						<p>Sign up for our mailing list to get latest updates and offers.</p>
						<form class="form-inline qbstp-header-subscribe">
							<div class="row">
								<div class="col-md-12 col-md-offset-0">
									<div class="form-group">
										<input type="text" class="form-control" id="email" placeholder="Enter your email">
										<button type="submit" class="btn btn-primary">Subscribe</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<?php include 'footer.php'; ?>

	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
	</div>

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- Owl carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Date Picker -->
	<script src="js/bootstrap-datepicker.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>

	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>