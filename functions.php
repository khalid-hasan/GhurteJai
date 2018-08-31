<?php
error_reporting(0);

function convertCurrency($amount, $from, $to)
{
  $conv_id = "{$from}_{$to}";
  $string = file_get_contents("http://free.currencyconverterapi.com/api/v3/convert?q=$conv_id&compact=ultra");
  $json_a = json_decode($string, true);

 if(!empty($string))
 {
 	$result= $amount * round($json_a[$conv_id], 4);
 }
 else
 {
 	$result= $amount * 83;
 }

  return $result;
}

?>