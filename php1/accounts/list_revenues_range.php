<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
  //$range_details = $_POST["range_details"];
   $range_details = '{"table": "frontdesk", "from_date": "2018-11-26", "to_date": "2018-11-27"}';
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
   } else if ($table = "restaurant") {
     $table = "restaurant_payments";
   } else {
      $msg_response=["OUTPUT", "No table requested"];
      $response_message = json_encode($msg_response);
      die($response_message);
   }

  $get_revenues_sql = "SELECT * FROM $table WHERE date_of_payment >= '$from_date' AND date_of_payment < '$date_to_sql'";
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

  if ($_SERVER["REQUEST_METHOD"] != "POST") {
	echo $frontdesk_revenues;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>