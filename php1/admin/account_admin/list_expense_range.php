<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
  $range_details = $_POST["range_details"];
  // $range_details = '{"from_date": "2018-09-23", "to_date": "2018-11-29"}';
  $range_details = json_decode($range_details, true);
  $msg_response=["OUTPUT", "NOTHING HAPPENED"];
//print_r($_POST);
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

  $get_expense_payments_sql = "SELECT * FROM account_expense_payments WHERE date_of_payment >= '$from_date' AND date_of_payment < '$date_to_sql'";
  $get_expense_payments_result = mysqli_query($dbConn, $get_expense_payments_sql);
  $get_expense_payments_array = [];

  function get_all_expense_payments($expense_payments_result, $expense_payments_array) {
    $expense_payments_array = [];
    $expense_total = 0;
    $expense_worth = 0;
    $expense_balance = 0;

    if (mysqli_num_rows($expense_payments_result) > 0){
 	  while($rows = mysqli_fetch_assoc($expense_payments_result)) {
 		  $expense_payments_array[] = $rows; 	  
      $expense_total = $expense_total + intval($rows["amount_paid"]);
      $expense_balance = $expense_balance + intval($rows["balance"]);
      $expense_worth = $expense_worth + intval($rows["txn_worth"]);
    } 
    $expense_payments["expense_payments_array"] = $expense_payments_array;
    $expense_payments["expense_total"] = $expense_total;
    $expense_payments["expense_balance"] = $expense_balance;
    $expense_payments["expense_worth"] = $expense_worth;

 	  $get_expense_payments_json = json_encode($expense_payments);
 	  return $get_expense_payments_json;
    }
  }

  $frontdesk_expense_payments = get_all_expense_payments($get_expense_payments_result, $get_expense_payments_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_expense_payments;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>