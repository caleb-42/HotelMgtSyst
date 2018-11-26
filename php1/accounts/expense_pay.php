<?php
 include "../settings/connect.php";  //database name = $dbConn
 $msg_response=["OUTPUT", "NOTHING HAPPENED"];

 $payment_details = $_POST["payment_details"];

 $payment_details = json_decode($payment_details, true);
 $means_of_payment = $payment_details["means_of_payment"];
 $amount_paid = $payment_details["amount_paid"];
 $expense_ref = $payment_details["expense_ref"];

 if ($amount_paid <= 0) {
  $msg_response[0] = "ERROR";
  $msg_response[1] = "Please input a valid amount";
  $response_message = json_encode($msg_response);
  $printer -> close();
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

  $txn_date = $last_payment_details["txn_date"];

  $txn_worth = intval($last_payment_details["txn_worth"]);
?>