<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_items_sql = "SELECT * FROM account_expense_payments";
  $get_items_result = mysqli_query($dbConn, $get_items_sql);
  $get_items_array = [];

  function get_all_account_expenses($expense_payments_result, $expense_payments_array) {
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

  $account_expenses = get_all_account_expenses($get_items_result, $get_items_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $account_expenses;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>