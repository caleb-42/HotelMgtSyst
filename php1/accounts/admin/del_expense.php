<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn
$del_expenses = json_decode($_POST["del_expense"], true);
//$del_expenses = '{"expenses": [{"expense_ref": "vivian"}, {"expense_ref": "wendy"]}';

$deleted = [];

//$del_expenses = json_decode($del_expenses, true);
$del_array = $del_expenses["expenses"];
$no_of_expenses = count($del_array);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


$delete_expenses_query = $conn->prepare("DELETE FROM account_expenses WHERE expense_ref = ?");
$delete_expenses_query->bind_param("s", $expense_ref);

for ($i=0; $i < $no_of_expenses; $i++) { 
 	$expense_ref = $del_array[$i]["expense_ref"];
 	$delete_expenses_query->execute();
 	$deleted[] = $expense_ref;
}
$delete_expenses_query->close();
$deleted_expenses = json_encode($deleted);

$delete_expenses_pay_query = $conn->prepare("DELETE FROM account_expense_payments WHERE expense_ref = ?");
$delete_expenses_pay_query->bind_param("s", $expense_ref);

for ($i=0; $i < $no_of_expenses; $i++) { 
 	$expense_ref = $del_array[$i]["expense_ref"];
 	$delete_expenses_pay_query->execute();
}
$delete_expenses_pay_query->close();

if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY DELETED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>