<?php 

if(!isset($_SESSION)) { session_start(); }

function data_sanitization($data)
{
	$data= trim($data);
	$data= stripcslashes($data);
	$data= htmlspecialchars($data);
	return $data;
}

if(isset($_POST['submit'])){
    $to = "ghurtejai18@gmail.com"; // this is your Email address
    $from = data_sanitization($_POST['email']); // this is the sender's Email address
    $first_name = data_sanitization($_POST['first_name']);
    $last_name = data_sanitization($_POST['last_name']);
    $subject = data_sanitization($_POST['subject']);
    $subject2 = "Response from GhurteJai.com";
    $message = "First name:".$first_name."\n" . "Last Name: " . $last_name . "\n"."Email:".$from. "\n"." Messege:"  . data_sanitization($_POST['message']);
   // $message2 = "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    $message2 = "Dear ". $first_name . ", \nThanks for your response we will contact you shortly.";

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    $notifyMsg= "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
    else
    {
    	$notifyMsg= "";
    }
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contact</title>
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
			   	<li style="background-image: url(images/cover-img-9.jpg);">
			   		<div class="overlay"></div>
			   		<div class="container-fluid">
			   			<div class="row">
				   			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
				   				<div class="slider-text-inner text-center">
				   					<h1>Contact us</h1>
				   				</div>
				   			</div>
				   		</div>
			   		</div>
			   	</li>
			  	</ul>
		  	</div>
		</aside>

		<div id="colorlib-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 animate-box">
						<h3>Get In Touch</h3>
						<form action="" method="post">
							<div class="row form-group">
								<div class="col-md-6 padding-bottom">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="Your firstname" required pattern="^([a-zA-Z\s'-]+\.)*[a-zA-Z\s'-]+$" title="Please Enter Your First Name">
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Your lastname" required pattern="^([a-zA-Z\s'-]+\.)*[a-zA-Z\s'-]+$" title="Please Enter Your Last Name" >
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Your Email Address" required title="Enter Correct Email Address">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<label>Subject</label>
									<input type="text" name="subject" class="form-control" placeholder="Your subject of this message" required title="Write The Subject">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<label>Message</label>
									<textarea name="message" cols="30" rows="10" class="form-control" placeholder="Say Something About Us" required title="Write Your Message"></textarea>
								</div>
							</div>

				               <div class="error">
				                 <?php

				                   if (!empty($notifyMsg)) 
				                   {
				                    echo "<p><span id=\"error\">$notifyMsg</span></p>";
				                   }

				                 ?>
				              </div>
							<div class="form-group text-center">
								<input type="submit" name="submit" value="Submit" class="btn btn-primary">
							</div>

						</form>		
					</div>
					<div class="col-md-10 col-md-offset-1 animate-box">
						<h3>Contact Information</h3>
						<div class="row contact-info-wrap">
							<div class="col-md-3">
								<p><span><i class="icon-location"></i></span> 944, Silicon Malancho, <br> Flat: 5A, Road: 14, Baitul Aman Housing Society, Adabor, Dhaka</p>
							</div>
							<div class="col-md-3">
								<p><span><i class="icon-phone3"></i></span> <a href="tel://8801820570771">+8801820570771</a></p>
							</div>
							<div class="col-md-3">
								<p><span><i class="icon-paperplane"></i></span> <a href="mailto:khalid.hasan@ieee.org">khalid.hasan@ieee.org</a></p>
							</div>
							<div class="col-md-3">
								<p><span><i class="icon-globe"></i></span> <a href="http://facebook.com/iamkih">Find Me On Facebook</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
<?php include 'subscribe.php'; ?>

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

<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b82fb9aafc2c34e96e7eb01/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

	</body>
</html>
