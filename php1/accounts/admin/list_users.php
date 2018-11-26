<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_users_sql = "SELECT * FROM account_users";
  $get_users_result = mysqli_query($dbConn, $get_users_sql);
  $get_users_array = [];

  function get_all_account_items($users_result, $users_array) {
    $users_array = [];

    if (mysqli_num_rows($users_result) > 0){
 	  while($rows = mysqli_fetch_assoc($users_result)) {
 		$users_array[] = $rows;
 	  }
 	  $get_users_json = json_encode($users_array);
 	  return $get_users_json;
    }
  }

  $account_users = get_all_account_items($get_users_result, $get_users_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $account_users;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>