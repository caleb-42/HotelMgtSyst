<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_settings_sql = "SELECT * FROM admin_settings";
  $get_settings_result = mysqli_query($dbConn, $get_settings_sql);
  $get_settings_array = [];

  function get_all_settings($settings_result, $settings_array) {
    $settings_array = [];

    if (mysqli_num_rows($settings_result) > 0){
 	  while($rows = mysqli_fetch_assoc($settings_result)) {
 		$settings_array[] = $rows;
 	  }
 	  $get_settings_json = json_encode($settings_array);
 	  return $get_settings_json;
    }
  }

  $settings_list = get_all_settings($get_settings_result, $get_settings_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $settings_list;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>