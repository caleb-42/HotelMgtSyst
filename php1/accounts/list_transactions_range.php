<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
  //$range_details = $_POST["range_details"];
   $range_details = '{"table": "reservations", "from_date": "2018-11-24", "to_date": "2018-11-29"}';
   $range_details = json_decode($range_details, true);
   $msg_response=["OUTPUT", "NOTHING HAPPENED"];


   $table = $range_details["table"];
   $from_date = $range_details["from_date"];
   $to_date = $range_details["to_date"];

   if (($from_date == "") || ($to_date == "")) {
     $msg_response[0] = "ERROR";
     $msg_response[1] = "Please input valid dates";
     $response_message = json_encode($msg_response);
     die($response_message);
   }

   $compare_fro = date_create($from_date);
   $compare_to = date_create($to_date);

   if ($compare_fro > $compare_to) {
     $msg_response[0] = "ERROR";
     $msg_response[1] = "Please input a valid date range";
     $response_message = json_encode($msg_response);
     die($response_message);
   }
   date_add($compare_to, date_interval_create_from_date_string("1 days"));
   $date_to_sql = date_format($compare_to, "Y-m-d");

   if ($table == "frontdesk") {
     $table = "frontdesk_payments";
     $table_txn = "frontdesk_txn";
     $like = "AND frontdesk_txn LIKE '%BK_%'";
     $ref = "booking_ref";
     $pay_ref = $table_txn;
   } else if ($table == "restaurant") {
     $table = "restaurant_payments";
     $table_txn = "restaurant_txn";
     $like = "";
     $ref = "txn_ref";
     $pay_ref = $table_txn;
   } else if ($table == "reservations") {
     $table = "frontdesk_payments";
     $table_txn = "frontdesk_reservation_txn";
     $like = "AND frontdesk_txn LIKE '%RESV_%'";
     $ref = "reservation_ref";
     $pay_ref = "frontdesk_txn";
   } else {
      $msg_response=["OUTPUT", "No table requested"];
      $response_message = json_encode($msg_response);
      die($response_message);
   }

  $get_revenues_sql = "SELECT * FROM $table_txn WHERE $ref IN (SELECT DISTINCT $pay_ref FROM $table WHERE date_of_payment >= '$from_date' AND date_of_payment < '$date_to_sql' $like)";
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

  if ($_SERVER["REQUEST_METHOD"] != "POST") {
	echo $frontdesk_revenues;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>