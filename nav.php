<nav class="colorlib-nav" role="navigation">
	<div class="top-menu">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-2">
					<div id="colorlib-logo"><a href="index.php">Ghurte Jai</a></div>
				</div>
				<div class="col-xs-10 text-right menu-1">
					<ul>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="index.php" ? "active" : "" ?>"><a href="index.php">Home</a></li>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="tours.php" ? "active" : "" ?>"><a href="tours.php">Tours</a></li>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="hotels.php" ? "active" : "" ?>"><a href="hotels.php">Hotels</a></li>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="blog.php" ? "active" : "" ?>"><a href="blog.php">Blog</a></li>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="about.php" ? "active" : "" ?>"><a href="about.php">About</a></li>
						<li class="<?php echo basename($_SERVER['PHP_SELF'])=="contact.php" ? "active" : "" ?>"><a href="contact.php">Contact</a></li>
						<?php
			            //  $login= "<li id=\"id01\"><a href=\"#\" onclick=\"document.getElementById('id01').style.display='block'\" style=\"width:auto;\" >Login</a></li>";
			                $login= "<li id=\"id01\"><a href=\"login.php\">Login</a></li>";
			                $logout= "<li><a href=\"Admin/logout.php\">Logout</a></li>";

        					echo isset($_SESSION['user']) ? $logout : $login;
    					?>

    					<?php

    						$className= (basename($_SERVER['PHP_SELF'])=="register.php" ? "active" : "") ;

    						$register= "<li class=". "\"$className\"". "><a href=\"register.php\">Register</a></li>";
			                $admin= "<li><a href=\"Admin\">Admin</a></li>";

        					echo isset($_SESSION['user']) ? $admin : $register;
						?>

						<li class="has-dropdown">
							<a href="#">Your Currency</a>
							<ul class="dropdown">
								<li class="<?php echo $_SESSION['currency']=="USD" ? "active" : "" ?>"><a href="currency.php?currency=USD">USD</a></li>
								<li class="<?php echo $_SESSION['currency']=="BDT" ? "active" : "" ?>"><a href="currency.php?currency=BDT">BDT</a></li>

							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>