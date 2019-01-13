<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
   $table = $_POST["table"];
   if ($table == "frontdesk") {
     $table = "frontdesk_txn WHERE booking_ref LIKE '%BK_%'";
   } else if ($table == "restaurant") {
     $table = "restaurant_txn";
   } else if ($table == "reservations") {
     $table = "frontdesk_txn WHERE booking_ref LIKE '%RESV_%'";
   } else {
      $msg_response=["OUTPUT", "No table requested"];
      $response_message = json_encode($msg_response);
      die($response_message);
   }

  $get_revenues_sql = "SELECT * FROM $table";
  $get_revenues_result = mysqli_query($dbConn, $get_revenues_sql);
  $get_revenues_array = [];

  function get_all_revenues($revenues_result, $revenues_array) {
    $revenues_array = [];
    $revenue_total = 0;
    $revenue_worth = 0;
    $revenue_balance = 0;

    if (mysqli_num_rows($revenues_result) > 0){
 	  while($rows = mysqli_fetch_assoc($revenues_result)) {
 		  $revenues_array[] = $rows; 	  
      $revenue_total = $revenue_total + intval($rows["deposited"]);
      $revenue_balance = $revenue_balance + intval($rows["balance"]);
      $revenue_worth = $revenue_worth + intval($rows["total_cost"]);
    } 
    $revenues["revenues_array"] = $revenues_array;
    $revenues["revenue_total"] = $revenue_total;
    $revenues["revenue_balance"] = $revenue_balance;
    $revenues["revenue_worth"] = $revenue_worth;

 	  $get_revenues_json = json_encode($revenues);
 	  return $get_revenues_json;
    }
  }

  $frontdesk_revenues = get_all_revenues($get_revenues_result, $get_revenues_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_revenues;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>