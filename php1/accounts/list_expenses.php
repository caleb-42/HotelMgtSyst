<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_items_sql = "SELECT * FROM account_expenses";
  $get_items_result = mysqli_query($dbConn, $get_items_sql);
  $get_items_array = [];

  function get_all_account_expenses($items_result, $items_array) {
    $items_array = [];

    if (mysqli_num_rows($items_result) > 0){
 	  while($rows = mysqli_fetch_assoc($items_result)) {
 		$items_array[] = $rows;
 	  }
 	  $get_items_json = json_encode($items_array);
 	  return $get_items_json;
    }
  }

  $account_expenses = get_all_account_expenses($get_items_result, $get_items_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $account_expenses;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>