<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_bookings_sql = "SELECT * FROM frontdesk_bookings";
  $get_bookings_result = mysqli_query($dbConn, $get_bookings_sql);
  $get_bookings_array = [];

  function get_all_frontdesk_bookings($bookings_result, $bookings_array) {
    $bookings_array = [];

    if (mysqli_num_rows($bookings_result) > 0){
 	  while($rows = mysqli_fetch_assoc($bookings_result)) {
 		$bookings_array[] = $rows;
 	  }
 	  $get_bookings_json = json_encode($bookings_array);
 	  return $get_bookings_json;
    }
  }

  $frontdesk_bookings = get_all_frontdesk_bookings($get_bookings_result, $get_bookings_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_bookings;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>