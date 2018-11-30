<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
   $table = $_POST["table"];
   if ($table == "bookings") {
     $table = "frontdesk_payments";
     $like = "WHERE frontdesk_txn LIKE 'BK_'";
   } else if ($table = "restaurant") {
     $table = "restaurant_payments";
     $like = "";
   } else if ($table == "reservations") {
      $table = "frontdesk_payments";
      $like = "WHERE frontdesk_txn LIKE 'RESV_'";
   } else if ($table == "frontdesk") {
       $table = "frontdesk_payments";
       $like = "";
   } else {
      $msg_response=["OUTPUT", "No table requested"];
      $response_message = json_encode($msg_response);
      die($response_message);
   }

  $get_revenues_sql = "SELECT * FROM $table $like";
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
      $revenue_total = $revenue_total + intval($rows["amount_paid"]);
      $revenue_balance = $revenue_balance + intval($rows["amount_balance"]);
      $revenue_worth = $revenue_worth + intval($rows["txn_worth"]);
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