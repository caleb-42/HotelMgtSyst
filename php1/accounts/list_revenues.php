<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
   $table = $_POST["table"];
   if ($table == "frontdesk") {
     $table = "frontdesk_payments";
   } else if ($table = "restaurant") {
     $table = "restaurant_payments";
   } else {
      $msg_response=["OUTPUT", "No table requested"];
      $response_message = json_encode($msg_response);
      die($response_message);
   }

  $get_revenues_sql = "SELECT * FROM $table";
  $get_revenues_result = mysqli_query($dbConn, $get_revenues_sql);
  $get_revenues_array = [];

  function get_all_revenues($revenues_result, $revenues_array) {
    $revenues_array = [];

    if (mysqli_num_rows($revenues_result) > 0){
 	  while($rows = mysqli_fetch_assoc($revenues_result)) {
 		$revenues_array[] = $rows;
 	  }
 	  $get_revenues_json = json_encode($revenues_array);
 	  return $get_revenues_json;
    }
  }

  $frontdesk_revenues = get_all_revenues($get_revenues_result, $get_revenues_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_revenues;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>