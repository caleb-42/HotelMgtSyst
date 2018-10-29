<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_rooms_sql = "SELECT * FROM frontdesk_rooms";
  $get_rooms_result = mysqli_query($dbConn, $get_rooms_sql);
  $get_rooms_array = [];

  function get_all_frontdesk_rooms($rooms_result, $rooms_array, $connDB) {
    $rooms_array = [];

    if (mysqli_num_rows($rooms_result) > 0){
 	  while($rows = mysqli_fetch_assoc($rooms_result)) {
      $room_id = $rows["room_id"];
      $reservation_query = "SELECT * FROM frontdesk_reservations WHERE room_id = '$room_id'";
      $get_reservations_result = mysqli_query($connDB, $reservation_query);
      if (mysqli_num_rows($get_reservations_result) > 0) {
        $reservations_rows = [];
        while ($rows_reservations = mysqli_fetch_assoc($get_reservations_result)) {
           $reservations_rows[] = $rows_reservations;
         }
         $rows["reservations"] = $reservations_rows;
      }
      $rooms_array[] = $rows;
 	  }
 	  $get_rooms_json = json_encode($rooms_array);
 	  return $get_rooms_json;
    }
  }

  $frontdesk_rooms = get_all_frontdesk_rooms($get_rooms_result, $get_rooms_array, $dbConn);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_rooms;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>