<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_txn_sql = "SELECT * FROM frontdesk_txn";
  $get_txn_result = mysqli_query($dbConn, $get_txn_sql);
  $get_txn_array = [];

  function get_all_frontdesk_txn($txn_result, $txn_array) {
    $txn_array = [];

    if (mysqli_num_rows($txn_result) > 0){
 	  while($rows = mysqli_fetch_assoc($txn_result)) {
 		$txn_array[] = $rows;
 	  }
 	  $get_txn_json = json_encode($txn_array);
 	  return $get_txn_json;
    }
  }

  $frontdesk_txn = get_all_frontdesk_txn($get_txn_result, $get_txn_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_txn;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>