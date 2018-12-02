<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_items_sql = "SELECT * FROM account_expenses";
  $get_items_result = mysqli_query($dbConn, $get_items_sql);
  $get_items_array = [];

  function get_all_account_expenses($expense_result, $expense_array) {
    $expense_array = [];
    $expense_total = 0;
    $expense_worth = 0;
    $expense_balance = 0;

    if (mysqli_num_rows($expense_result) > 0){
    while($rows = mysqli_fetch_assoc($expense_result)) {
      $expense_array[] = $rows;    
      $expense_total = $expense_total + intval($rows["amount_paid"]);
      $expense_balance = $expense_balance + intval($rows["balance"]);
      $expense_worth = $expense_worth + intval($rows["txn_worth"]);
    } 
    $expense["expense_array"] = $expense_array;
    $expense["expense_total"] = $expense_total;
    $expense["expense_balance"] = $expense_balance;
    $expense["expense_worth"] = $expense_worth;

    $get_expense_json = json_encode($expense);
    return $get_expense_json;
    }
  }

  $account_expenses = get_all_account_expenses($get_items_result, $get_items_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $account_expenses;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>