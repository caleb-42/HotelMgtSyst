<?php
 include "../settings/connect.php";  //database name = $dbConn
 $msg_response=["OUTPUT", "NOTHING HAPPENED"];

 $payment_details = $_POST["payment_details"];
 //$payment_details = '{"means_of_payment":"CASH", "date_of_payment":"2018-11-27", "expense_ref":"EXP_32188", "amount_paid":500}';


 $payment_details = json_decode($payment_details, true);
 $means_of_payment = $payment_details["means_of_payment"];
 $amount_paid = $payment_details["amount_paid"];
 $expense_ref = $payment_details["expense_ref"];
 $date_of_payment = $payment_details["date_of_payment"];

 if ($amount_paid <= 0) {
  $msg_response[0] = "ERROR";
  $msg_response[1] = "Please input a valid amount";
  $response_message = json_encode($msg_response);
  die($response_message);
}

  $last_payment_id_query = "SELECT MAX(id) AS id FROM account_expense_payments WHERE expense_ref = '$expense_ref'";
  $last_payment_id_result = mysqli_query($dbConn, $last_payment_id_query);

  $payment_id_row = mysqli_fetch_array($last_payment_id_result);
  $payment_id = intval($payment_id_row["id"]);

  $last_payment = "SELECT * FROM account_expense_payments WHERE id = $payment_id";
  $last_payment_result = mysqli_query($dbConn, $last_payment);

  $last_payment_details = mysqli_fetch_assoc($last_payment_result);
  $payment_index = intval($last_payment_details["payment_index"]) + 1;

  $balance = intval($last_payment_details["balance"]);

  if ($balance == 0) {  	
    $msg_response[0] = "ERROR";
    $msg_response[1] = "This expense has been fully paid for";
    $response_message = json_encode($msg_response);
    die($response_message);
  }

  if (($amount_paid - $balance) > 0) { 
    $excess = $amount_paid - $balance;
    $msg_response[0] = "ERROR";
    $msg_response[1] = "This expense is being over paid for, excess: $excess, actual balance: $balance";
    $response_message = json_encode($msg_response);
    die($response_message);
  }

  $txn_date = $last_payment_details["txn_date"];

  $txn_worth = intval($last_payment_details["txn_worth"]);

  $new_balance = $balance - $amount_paid;
  $net_paid = intval($last_payment_details["net_paid"]) + $amount_paid;
  $udpate_payment = "INSERT INTO account_expense_payments (expense_ref, txn_date, amount_paid, date_of_payment, balance, net_paid, txn_worth, means_of_payment, payment_index) VALUES ('$expense_ref', '$txn_date', $amount_paid, '$date_of_payment', $new_balance, $net_paid, $txn_worth, '$means_of_payment', $payment_index)";

  $update_payment_result = mysqli_query($dbConn, $udpate_payment);

  $update_expense = "UPDATE account_expenses SET amount_paid = $net_paid, balance = $new_balance WHERE expense_ref ='$expense_ref'";
  $update_expense_result = mysqli_query($dbConn, $update_expense);

  if($update_expense_result && $update_payment_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "PAYMENT RECORDS SUCCESSFULLY UPDATED";
  } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
  }

  $response_message = json_encode($msg_response);
  echo $response_message;
?>