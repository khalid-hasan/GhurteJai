<?php
  if(!isset($_SESSION)) { session_start(); }

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

  $hotel_id = $_GET['hotel_id'];
  $_SESSION['hotel_id']= $hotel_id;

  if(!isset($hotel_id))
  {
  	header("Location: hotels.php");
  }
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hotel Rooms</title>
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
			   	<li style="background-image: url(images/cover-img-17.jpg);">
			   		<div class="overlay"></div>
			   		<div class="container-fluid">
			   			<div class="row">
				   			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
				   				<div class="slider-text-inner text-center">
				   					<h1>Hotel Details</h1>
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

							    $hotel_name_query=mysqli_query($conn, "SELECT title from hotels where hotel_id= $_SESSION[hotel_id]");
			                    $hotel_name= mysqli_fetch_assoc($hotel_name_query);
			                    $hotel_title= $hotel_name['title'];

									echo "<div class=\"col-md-12 col-md-offset-0 heading2 animate-box\">";
										echo "<h2>$hotel_title</h2>";
									echo "</div>";
									echo "<div class=\"row\">";
								


			                    $statement="select * from room_type where deletedAt is null and hotel_id= '$_SESSION[hotel_id]' order by hotel_id asc";

			                    $result = mysqli_query($conn, $statement);

			                    if (mysqli_num_rows($result) > 0)
			                    {
			                        while($row = mysqli_fetch_assoc($result))
			                        {
										if($_SESSION['currency']=="USD")
										{
											$price= $row['price'];
										}
										else if($_SESSION['currency']=="BDT")
										{
											$price= convertCurrency($row['price'], $_SESSION['c_from'], $_SESSION['c_to']);
										}
			                        	
										echo "<div class=\"col-md-12 animate-box\">";
											echo "<div class=\"room-wrap\">";
												echo "<div class=\"row\">";
													echo "<div class=\"col-md-6 col-sm-6\">";
														echo "<div class=\"room-img\" style=\"background-image: url(Admin/$row[image]);\"></div>";
													echo "</div>";
													echo "<div class\"col-md-6 col-sm-6\">";
														echo "<div class=\"desc\">";
															echo "<h2>$row[room_name]</h2>";
															echo "<p class=\"price\"><span>$_SESSION[c_symbol]$price</span> <small>/ night</small></p>";
															echo" <p>$row[room_desc]</p>";
															echo "<p><a href=\"hotel-booking.php?hotel_id=$_SESSION[hotel_id]&room_type_id=$row[room_type_id]\" class=\"btn btn-primary\">Book Now!</a></p>";
														echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";
										echo "</div>";
									}
								}
								else
			                    {
			                        echo "Nothing found in db";
			                    }
			                    mysqli_close($conn);
								?>			
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

