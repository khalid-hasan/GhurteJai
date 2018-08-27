<?php
if(!isset($_SESSION)) { session_start(); }

$currency= $_GET['currency'];
$_SESSION['currency']= $currency;

if(isset($_SERVER['HTTP_REFERER'])) 
{
    $redirect= $_SERVER['HTTP_REFERER'];
}
else
{
	$redirect= "index.php";
}

header("LOCATION: $redirect");

?> 