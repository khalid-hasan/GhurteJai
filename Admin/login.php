<?php 
    require 'config.php';
    //session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['form_login']))
    //if(isset($_POST['submit']))
    {
        $username= $_POST['uname'];
        $password= $_POST['pwd'];
        $error="";
        $sql = "select * from users where username= '$username' and password= '$password' ";
        $res = mysqli_query($conn, $sql);
        $row= mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);

        if ($count==1)
        {
          $_SESSION['user']= $username;
          $_SESSION['full_name']= $row['name'];
          $_SESSION['image_path']= $row['image'];
          $_SESSION['user_role']= $row['user_role'];
          $_SESSION['login_status']= "LOGGEDIN";
          header("location: Admin/index.php");
        }
        else
        {
		  $notifyMsg="Wrong User Name or Password";
		  mysqli_error($conn);
        }
    }


?>

<div id="id01" class="modal">
 <?php
   if (!empty($notifyMsg)) 
	 {
	 echo "<div class=\"alert alert-primary\" role=\"alert\">";
	 echo "<p><span id=\"error\">$notifyMsg</span></p>";
	 echo "</div>";
	}
 ?>	
  <form class="modal-content animate" method="post" action="">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <h3>Ghurte Jai</h3>
    </div>


    <div class="container login-panel">	
      <label for="uname"><b>Username</b></label>
      <input type="text" id="uname" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" id="pwd" placeholder="Enter Password" name="pwd" required>

      <input type="hidden" name="form_login" value="1"/>
        
      <button type="submit" name="login_form" class="login-button" value="Login">Login</button>

    </div>

    <div class="container login-panel">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
  

</div>

