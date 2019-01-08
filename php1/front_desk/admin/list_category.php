<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_categories_sql = "SELECT * FROM frontdesk_room_category";
  $get_categories_result = mysqli_query($dbConn, $get_categories_sql);
  $get_categories_array = [];

  function get_all_categories($categories_result, $categories_array) {
    $categories_array = [];

    if (mysqli_num_rows($categories_result) > 0){
 	  while($rows = mysqli_fetch_assoc($categories_result)) {
 		$categories_array[] = $rows;
 	  }
 	  $get_categories_json = json_encode($categories_array);
 	  return $get_categories_json;
    }
  }

  $customer_list = get_all_categories($get_categories_result, $get_categories_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $customer_list;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>