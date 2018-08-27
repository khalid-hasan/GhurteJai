<?php
  session_start();

if(empty($_SESSION['login_status']))
{
  $_SESSION["login_redirect"] = $_SERVER['HTTP_REFERER'];
  header("location: login.php");
}

  $tour_id = $_GET['tour_id'];
  //$_SESSION['tour_id']= $tour_id;

  if(!isset($tour_id))
  {
  	header("Location: tours.php");
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
  
  

  $_SESSION['enq_tour_name']=data_sanitization($_POST['enq_tour_name']);
  $_SESSION['enq_tour_email']=data_sanitization($_POST['enq_tour_email']);
  $_SESSION['enq_tour_phone']=data_sanitization($_POST['enq_tour_phone']);
  $_SESSION['enq_tour_days']=data_sanitization($_POST['enq_tour_days']);
  $_SESSION['enq_tour_child']=data_sanitization($_POST['enq_tour_child']);
  $_SESSION['enq_tour_adult']=data_sanitization($_POST['enq_tour_adult']);
  $_SESSION['enq_tour_message']=data_sanitization($_POST['enq_tour_message']);
  $_SESSION['tour_id']= $tour_id;
  $_SESSION['redirect']= "redirect";

  foreach ($_POST as $key => $value) 
  {
    $_SESSION['post'][$key] = $value;
  }


$seat_available_query=mysqli_query($conn, "SELECT available FROM tours WHERE tour_id= '$_SESSION[tour_id]' ");
$seat_available= mysqli_fetch_assoc($seat_available_query);
$available= $seat_available['available'];


if(($_SESSION['enq_tour_child']+$_SESSION['enq_tour_adult']) <= $available)
{
    header("Location: booking-confirm-tour.php");
}
else
{
	$notifyMsg="Sorry. No Rooms available";
}

  mysqli_close($conn);
}

?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Book Package</title>
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
			   	<li style="background-image: url(images/cover-img-16.jpg);">
			   		<div class="overlay"></div>
			   		<div class="container-fluid">
			   			<div class="row">
				   			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
				   				<div class="slider-text-inner text-center">
				   					<h1>Book Package</h1>
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

							    $tour_name_query=mysqli_query($conn, "SELECT title from tours where tour_id= $_SESSION[tour_id]");
			                    $tour_name= mysqli_fetch_assoc($tour_name_query);
			                    $tour_title= $tour_name['title'];

									echo "<div class=\"col-md-12 col-md-offset-0 heading2 animate-box\">";
										echo "<h2>$tour_title</h2>";
									echo "</div>";
									echo "<div class=\"row\">";
								
			                    mysqli_close($conn);
								?>			
										<div class="col-md-12 animate-box">
											<div class="room-wrap">
												<div class="row">
            									  <form role="form" name="tour-enq" method="post" action="">
									                <div class="form-group">
									                  <label>Name</label>
									                  <input type="text" class="form-control" id="enq-input" placeholder="Your Name" name="enq_tour_name" value=""required pattern="^([a-zA-Z\s'-]+\.)*[a-zA-Z\s'-]+$" title="Please Enter Your Name">
									                </div>
									                <div class="form-group">
									                  <label>Email</label>
									                  <input type="email" class="form-control" id="enq-input" placeholder="Your Email" name="enq_tour_email" value="">
									                </div>
									                <div class="form-group">
									                  <label>Phone</label>
									                  <input type="text" class="form-control" id="enq-input" placeholder="Your Phone Number" name="enq_tour_phone" value=""required pattern="^[0-9]{3,15}$" title="Enter Your Phone Number">
									                </div>
									                <div class="form-group">
									                  <label>Number Of Days</label>
									                  <input type="number" class="form-control" id="enq-input" placeholder="Number Of Days" name="enq_tour_days" value="">
									                </div>									                					
									                <div class="form-group">
									                  <label>Child</label>
									                  <input type="number" class="form-control total" id="enq-child" placeholder="Number Of Child" name="enq_tour_child" value=""required pattern="^[0-9]{0,15}$" title="Enter Child Number">
									                </div>
									                <div class="form-group">
									                  <label>Adult</label>
									                  <input type="number" class="form-control total" id="enq-adult" placeholder="Number Of Adult" name="enq_tour_adult" value=""required pattern="^[0-9]{0,15}$" title="Enter Adult Number">
									                </div>
									                <div class="form-group">
									                  <label>Total</label>
									                  <input type="number" readonly class="form-control" id="enq-total" placeholder="Total People" name="total" value="">
									                </div>									              

													<div class="alert alert-primary seat-unavailable" role="alert"></div>										                
									                <div class="form-group">
									                  <label>Message</label>
                  									  <textarea class="form-control" rows="3" id="enq-textarea" placeholder="Write Your Message" name="enq_tour_message" required></textarea>
                  									</div>				

                  									<div class="error">
									                 <?php

									                   if (!empty($notifyMsg)) 
									                   {
									                    echo "<p><span id=\"error\">$notifyMsg</span></p>";
									                   }

									                 ?>
										            </div>		
                  									<button type="submit" class="btn btn-primary">SUBMIT</button>
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
$(document).ready(function() {

$('.total').change(function() {
    var total = 0;

    $('.total').each(function() {
        if( $(this).val() != '' )
            total += parseInt($(this).val());
    });

    $('input[name=total]').val(total);
});

  $(".seat-unavailable").css("display", "none");
  $('#enq-total').click(function() {
    var value = $(this).val();
    var tour_id= <?php echo $tour_id; ?>;

    $.ajax({
      type: 'post',
      url: 'seat-available-check.php',
      data: {
      	'seat_available' : value,
      	'tour_id' : tour_id
      },
      success: function(r) {
        $('.seat-unavailable').html(r);
        $(".seat-unavailable").css("display", "");
      }
    });
  });
});
</script>

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

