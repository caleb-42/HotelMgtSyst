<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_sessions_sql = "SELECT * FROM account_sessions";
  $get_sessions_result = mysqli_query($dbConn, $get_sessions_sql);
  $get_sessions_array = [];

  function get_all_account_sessions($sessions_result, $sessions_array) {
    $sessions_array = [];

    if (mysqli_num_rows($sessions_result) > 0){
 	  while($rows = mysqli_fetch_assoc($sessions_result)) {
 		$sessions_array[] = $rows;
 	  }
 	  $get_sessions_json = json_encode($sessions_array);
 	  return $get_sessions_json;
    }
  }

  $account_sessions = get_all_account_sessions($get_sessions_result, $get_sessions_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    echo $account_sessions;
  } else {
  	  echo "UNAUTHORIZED ACCESS";
  }
?>