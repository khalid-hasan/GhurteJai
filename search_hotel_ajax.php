<?php
    //$key=$_GET['key'];
    $array = array();
    $con=mysqli_connect("localhost","root","","travel_db");
    //$query=mysqli_query($con, "select * from hotels where location LIKE '%{$key}%'");
    $query=mysqli_query($con, "select location from hotels deletedAt is NULL");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] = $row['location'];
    }
    echo json_encode($array);
    mysqli_close($con);


/*$connect = mysqli_connect("localhost", "root", "", "travel_db");
$request = mysqli_real_escape_string($connect, $_POST["query"]);
$query = "
 SELECT * FROM hotels WHERE location LIKE '%".$request."%' and deletedAt is NULL";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = $row["location"];
 }
 echo json_encode($data);
}
*/
?>
