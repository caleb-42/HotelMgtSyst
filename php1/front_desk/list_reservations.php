<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_reservations_sql = "SELECT * FROM frontdesk_reservations";
  $get_reservations_result = mysqli_query($dbConn, $get_reservations_sql);
  $get_reservations_array = [];

  function get_all_frontdesk_reservations($reservations_result, $reservations_array) {
    $reservations_array = [];

    if (mysqli_num_rows($reservations_result) > 0){
 	  while($rows = mysqli_fetch_assoc($reservations_result)) {
 		$reservations_array[] = $rows;
 	  }
 	  $get_reservations_json = json_encode($reservations_array);
 	  return $get_reservations_json;
    }
  }

  $frontdesk_reservations = get_all_frontdesk_reservations($get_reservations_result, $get_reservations_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_reservations;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>