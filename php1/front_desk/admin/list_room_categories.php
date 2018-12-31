<?php
 include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_rooms_category_sql = "SELECT * FROM frontdesk_room_categories";
  $get_rooms_category_result = mysqli_query($dbConn, $get_rooms_category_sql);
  $get_rooms_category_array = [];

  function get_all_frontdesk_rooms_category($rooms_category_result, $rooms_category_array, $connDB) {
    $rooms_category_array = [];

    if (mysqli_num_rows($rooms_category_result) > 0){
 	  while($rows = mysqli_fetch_assoc($rooms_category_result)) {
        $rooms_category_array[] = $rows;
 	  }
 	  $get_rooms_category_json = json_encode($rooms_category_array);
 	  return $get_rooms_category_json;
    }
  }

  $frontdesk_rooms_category = get_all_frontdesk_rooms_category($get_rooms_category_result, $get_rooms_category_array, $dbConn);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_rooms_category;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>