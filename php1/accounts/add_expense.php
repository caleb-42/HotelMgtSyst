<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 //$add_expense = $_POST["add_expense"];
 /* $add_expense = '{"expense":"Electricity", "expense_description":"February", "expense_cost": 5000, "amount_paid": 5000, "balance": 0, "date": "2018-09-23", "means_of_payment": "CASH"}'; */
 $add_expense = json_encode($add_expense, true);

 $msg_response=["OUTPUT", "NOTHING HAPPENED"];

 $expense = $add_expense["expense"];
 if ($expense == "") {
 	$msg_response=["ERROR", "Expense Field can't be empty"];
	$response_message = json_encode($msg_response);
	die($response_message);
 }

 $expense_description = $add_expense["expense_description"];

 if ($expense_description != "") {
 	$duplicate_expense_query = "SELECT * FROM account_expenses WHERE expense = '$expense' AND expense_description = 'expense_description'";
    $duplicate_expense_result = mysqli_query($dbConn, $duplicate_expense_query);
    if (mysqli_num_rows($duplicate_expense_result)) {
    	$msg_response=["ERROR", "An expense exist with the same description"];
	    $response_message = json_encode($msg_response);
	    die($response_message);
    }
 }



 $expense_cost = $add_expense["expense_cost"];
 if ($expense_cost == "") {
 	$msg_response=["ERROR", "Expense cost Field can't be empty"];
	$response_message = json_encode($msg_response);
	die($response_message);
 }

 $expense_date = $add_expense["date"];
 if ($expense_date == "") {
 	$msg_response=["ERROR", "Please input a valid expense date"];
	$response_message = json_encode($msg_response);
	die($response_message);
 }

$expense_date = date_create($expense_date);

$amount_paid = $add_expense["amount_paid"];
$balance = $add_expense["balance"];

$rand_ref = mt_rand(0, 100000);
$exp_ref = "EXP_" . $rand_ref;

$duplicate_ref_query = "SELECT * FROM account_expenses WHERE expense_ref = '$exp_ref'";
$duplicate_ref_result = mysqli_query($dbConn, $duplicate_ref_query);

while (mysqli_num_rows($duplicate_ref_result) > 0) {
	$rand_ref = mt_rand(0, 100000);
    $exp_ref = "EXP_" . $rand_ref;

    $duplicate_ref_query = "SELECT * FROM account_expenses WHERE expense_ref = '$exp_ref'";
    $duplicate_ref_result = mysqli_query($dbConn, $duplicate_check_query);
}

$insert_into_expense = "INSERT INTO account_expenses (expenses, expense_ref, expense_description, expense_cost, amount_paid, balance) VALUES ('$expenses', '$exp_ref', '$expense_description', $expense_cost, $amount_paid, $balance)";
$insert_expense_result = mysqli_query($dbConn, $insert_into_expense);

$insert_into_payments = "INSERT INTO account_expenses_payments (expense_ref, txn_date, amount_paid, date_of_payment, balance, net_paid, txn_worth, means_of_payment) VALUES ('$expense_ref', '$expense_date', $amount_paid, '$expense_date', $balance, $amount_paid, $expense_cost, '$means_of_payment')";
$insert_into_payments_result = mysqli_query($dbConn, $insert_into_payments);

if($insert_expense_result && $insert_into_payments_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}
$response_message = json_encode($msg_response);
echo $response_message;

?>