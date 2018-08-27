<?php
  session_start();

  $addedBy = $_SESSION['user'];

if($_SESSION['redirect'] != "redirect" )
{
  header("Location: tours.php");
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

$tour_name_query=mysqli_query($conn, "SELECT title from tours where tour_id= '$_SESSION[tour_id]' ");
$tour_name= mysqli_fetch_assoc($tour_name_query);
$tour_title= $tour_name['title'];		                    

$tour_price_query=mysqli_query($conn, "SELECT price from tours where tour_id= '$_SESSION[tour_id]' ");
$tour_price= mysqli_fetch_assoc($tour_price_query);
$price= $tour_price['price'];
  
  $tid= 'TRX'.rand(100000, 999999);
  $to = "ghurtejai18@gmail.com"; // this is your Email address
  $from = $enq_tour_email; // this is the sender's Email address
  $subject = "Confirmation Booking ";
  $subject2 = "Response from GhurteJai.com for Tour Booking";
  $message = " Name: ".$enq_tour_name. "\n User email: ".$enq_tour_email."\n User Phone Number: ".$enq_tour_phone."\n Number of Days: ".$enq_tour_days." day\n Payment Method: ".$_POST['options']." \n Transaction ID: ".$tid."  Total Ammount: $".($enq_tour_child+$enq_tour_adult)*$price."";
  $message2 = " Name: ".$enq_tour_name. "\n User Phone Number: ".$enq_tour_phone."\n Number of Days: ".$enq_tour_days." day\n Payment Method: ".$_POST['options']." \n Transaction ID: ".$tid."\n Total Ammount: $".($enq_tour_child+$enq_tour_adult)*$price." \n\n Thanks for booking at ".$tour_title."\n\n For Further query contact with us.";

  $headers = "From:" . $from;
  $headers2 = "From:" . $to;
  mail($to,$subject,$message,$headers);
  mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
  //$notifyMsg= "Mail Sent. Thank you " .$enq_hotel_name . ", we will contact you shortly.";
  // You can also use header('Location: thank_you.php'); to redirect to another page.


  $statement="insert into tour_enquiry(tour_id, name, email, phone, days, child, adult, message, addedBy) values ('$_SESSION[tour_id]', '$enq_tour_name', '$enq_tour_email', '$enq_tour_phone', '$enq_tour_days', '$enq_tour_child', '$enq_tour_adult', '$enq_tour_message', '$addedBy')";

$seat_available_query=mysqli_query($conn, "SELECT available FROM tours WHERE tour_id= '$_SESSION[tour_id]' and deletedAt is NULL ");
$seat_available= mysqli_fetch_assoc($seat_available_query);
$available= $seat_available['available'];

  if(mysqli_query($conn,$statement))
  {
    $notifyMsg="Enquiry Sent";
  }
  else
  {
    $notifyMsg="Unable to send Enquiry";
    mysqli_error($conn);
  }	
  
  $update_available_room= $available-($enq_tour_child+$enq_tour_adult);

  if($available>=0)
  {
  	$update_available_room_query= "UPDATE tours SET available= '$update_available_room' WHERE tour_id= '$_SESSION[tour_id]' "; 	
  	mysqli_query($conn, $update_available_room_query);
  }
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

							    $tour_name_query=mysqli_query($conn, "SELECT title from tours where tour_id= '$_SESSION[tour_id]' ");
			                    $tour_name= mysqli_fetch_assoc($tour_name_query);
			                    $tour_title= $tour_name['title'];		                    

							    $tour_price_query=mysqli_query($conn, "SELECT price from tours where tour_id= '$_SESSION[tour_id]' ");
			                    $tour_price= mysqli_fetch_assoc($tour_price_query);
			                    $price_tour= $tour_price['price'];

									echo "<div class=\"col-md-12 col-md-offset-0 heading2 animate-box\">";
										echo "<h2>$tour_title - Confirm Booking</h2>";
									echo "</div>";
									echo "<div class=\"row\">";
								

								if($_SESSION['currency']=="USD")
								{
									$price= $price_tour;
								}
								else if($_SESSION['currency']=="BDT")
								{
									$price= convertCurrency($price_tour, $_SESSION['c_from'], $_SESSION['c_to']);
								}

			                    mysqli_close($conn);
								?>			
										<div class="col-md-12 animate-box">
											<div class="room-wrap">
												<div class="row">
            									  <form role="form" name="hotels-enq" method="post" action="">

								                    <div class="form-group">
								                        <label>Name:</label> <?php echo $enq_tour_name; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Email:</label> <?php echo $enq_tour_email; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Phone:</label> <?php echo $enq_tour_phone; ?>
								                    </div>
								                    <div class="form-group">
								                        <label>Number Of Days:</label> <?php echo $enq_tour_days; ?>
								                    </div>								                    					
								                    <div class="form-group">
								                        <label>Number Of Children:</label> <?php echo $enq_tour_child; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Number Of Adults:</label> <?php echo $enq_tour_adult; ?>
								                    </div>	
								                    <div class="form-group">
								                        <label>Your Message:</label> <?php echo $enq_tour_message; ?>
								                    </div>	


												    <div class="text-center">
												        <h1>Receipt</h1>
												    </div>
												    </span>
												    <table class="table table-hover">
												        <thead>
												            <tr>
												                <th>Details</th>
												                <th class="text-center">Seat(s)</th>
												                <th class="text-center">Price</th>
												            </tr>
												        </thead>
												        <tbody>
												            <tr>
												                <td class="col-md-9"><em><?php echo $tour_title ?></em></h4></td>
												                <td class="col-md-1 text-center"> <?php echo $enq_tour_child+$enq_tour_adult; ?> </td>
												                <td class="col-md-1 text-center"><?php echo $_SESSION['c_symbol'].$price; ?></td>
												            </tr>
												            <tr>
												                <td>   </td>
												                <td class="text-right"><h4><strong>Total: </strong></h4></td>
												                <td class="text-center text-danger"><h4><strong><?php echo $_SESSION['c_symbol'].($enq_tour_child+$enq_tour_adult)*$price; ?></strong></h4></td>
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