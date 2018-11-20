<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 // $reservation_data = '{"reservation_ref":"RESV_22097", "amount_paid": 75000, "means_of_payment":"INTERNET TRANSFER","guest_id":"", "frontdesk_rep":"Ada"}';

$reservation_data = $_POST["reservation_data"];
 $reservation_out = $reservation_data;

$reservation_data = json_decode($reservation_data, true);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_ref = $reservation_data["reservation_ref"];
$total_cost = 0;
$no_of_rooms = 0;
$rooms = [];
$net_room_rate = o;

$get_all_ref_details_sql = "SELECT * FROM frontdesk_reservations WHERE deposit_confirmed = 'NO' AND reservation_ref = '$reservation_ref'";
$get_all_ref_results = mysqli_query($dbConn, $get_all_ref_details_sql);
if (mysqli_num_rows($get_all_ref_results)) {
	$no_of_rooms = mysqli_num_rows($get_all_ref_results);
	$i = 0;
	while ($row = mysqli_fetch_assoc($get_all_ref_results)) {
		$total_cost = $total_cost + $row["room_total_cost"];
		$rooms[$i]["room_number"] = $row["room_number"];
		$rooms[$i]["room_id"] = $row["room_id"];
		$rooms[$i]["room_rate"] = $row["room_rate"];
		$net_room_rate = $net_room_rate + $rooms[$i]["room_rate"];
		$guest_id = $row["guest_id"];
		$phone_number = $row["phone_number"];
		$email = $row["email"];
	}
} else {
	$msg_response=["ERROR", "NOTHING TO CONFIRM"];
	$response_message = json_encode($msg_response);
	die($response_message);
}


$total_rooms_reserved = $no_of_rooms;
$amount_paid = $reservation_data["amount_paid"];
if ($amount_paid == "") {
	$amount_paid = 0;
}
$balance = $total_cost - $amount_paid;
$means_of_payment = $reservation_data["means_of_payment"];
$frontdesk_rep = $reservation_data["frontdesk_rep"];

if ($amount_paid < $net_room_rate) {
	$msg_response =["ERROR", "Deposit must be at least equal to single night(s) of reserved room(s)"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

$update_reservation_query ="UPDATE frontdesk_reservations SET deposit_confirmed = 'YES' WHERE reservation_ref = '$reservation_ref'";

$update_reservation_result = mysqli_query($dbConn, $update_reservation_query);

/*Record Transaction*/
if ($amount_paid) {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, amount_balance, net_paid, txn_worth, guest_id, means_of_payment ,date_of_payment) VALUES ('$reservation_ref', $amount_paid, $balance, $amount_paid, $total_cost, '$guest_id', '$means_of_payment', CURRENT_TIMESTAMP)";
} else {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, net_paid, amount_balance, txn_worth, guest_id) VALUES ('$reservation_ref', $amount_paid, $amount_paid, $balance, $total_cost, '$guest_id')";
}

if ($balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$payment_record_result = mysqli_query($dbConn, $payment_record_query);

//var_dump($customer_ref);
$txn_insert_query = "INSERT INTO frontdesk_reservation_txn (reservation_ref, total_rooms_reserved, total_cost, deposited, balance, payment_status, frontdesk_rep, means_of_payment) VALUES ('$reservation_ref', $total_rooms_reserved, $total_cost, $amount_paid, $balance, '$payment_status', '$frontdesk_rep', '$means_of_payment')";
$txn_insert_result = mysqli_query($dbConn, $txn_insert_query);

if(($txn_insert_result)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "CONFIRMED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG ". mysqli_error($dbConn);
}

$response_message = json_encode($msg_response);
echo $response_message;
?>