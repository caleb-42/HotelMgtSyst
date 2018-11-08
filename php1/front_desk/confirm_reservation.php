<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $reservation_data = '{"reservation_ref":"RESV_6723", "amount_paid": 63000, "total_cost":171000, "means_of_payment":"INTERNET TRANSFER", "email":"tegogs@gmail.com", "phone_number":"08057254789","guest_id":"", "frontdesk_rep":"Ada", "total_rooms_reserved": 3, "rooms": [{"room_id": "RM_64917", "guests":3, "room_rate": 33000, "no_of_nights":2, "room_category": "deluxe", "room_total_cost" : 66000, "room_reservation_date" : "2018-11-20"}, {"room_id": "RM_66480", "guests":3, "room_rate": 15000, "no_of_nights":3, "room_category": "standard", "room_total_cost" : 45000, "room_reservation_date" : "2018-11-23"}, {"room_id": "RM_71638", "guests":3, "room_rate": 15000, "no_of_nights":4, "room_category": "standard", "room_total_cost" : 60000, "room_reservation_date" : "2018-11-22"}]}';

$reservation_data = json_decode($reservation_data, true);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_ref = $reservation_data["reservation_ref"];
$total_rooms_reserved = $reservation_data["total_rooms_reserved"];
$total_cost = $reservation_data["total_cost"];
$amount_paid = $reservation_data["amount_paid"];
$means_of_payment = $reservation_data["means_of_payment"];
$email = $reservation_data["email"];
$phone_number = $reservation_data["phone_number"];
$frontdesk_rep = $reservation_data["frontdesk_rep"];
$guest_id = $reservation_data["guest_id"];
$rooms = $reservation_data["rooms"];
$no_of_rooms = count($rooms);
$net_room_rate = 0;

for ($i=0; $i < $net_room_rate; $i++) { 
	$net_room_rate = $net_room_rate + $rooms[$i]["room_rate"];
}

if ($amount_paid > $net_room_rate) {
	$msg_response["ERROR", "Deposit must be at least equal to single nights of reserved rooms"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

 $rand_id = mt_rand(0, 100000);
 $booking_ref = "BK_" . $rand_id;

 $duplicate_id_query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking_ref'";
 $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

 while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $booking_ref = "BK_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking_ref'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

$update_reservation_query ="UPDATE frontdesk_reservations SET deposit_confirmed = 'YES' WHERE reservation_ref = '$reservation_ref'";

$update_reservation_result = mysqli_query($dbConn, $update_reservation_query);

/*Record Transaction*/
if ($deposited) {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, amount_balance, net_paid, txn_worth, guest_id, means_of_payment ,date_of_payment) VALUES('$reservation_ref', $amount_paid, $balance, $amount_paid, $total_cost, '$guest_id', '$means_of_payment', CURRENT_TIMESTAMP)";
} else {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, net_paid, amount_balance, txn_worth, guest_id) VALUES('$reservation_ref', $amount_paid, $amount_paid, $balance, $total_cost, '$guest_id')";
}

if ($balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$payment_record_result = mysqli_query($dbConn, $payment_record_query);

//var_dump($customer_ref);
$txn_insert_query = "INSERT INTO frontdesk_reservation_txn (reservation_ref, total_rooms_reserved, total_cost, deposited, balance, payment_status, frontdesk_rep) VALUES('$reservation_ref', $total_rooms_reserved, $total_cost, $amount_paid, $balance, '$payment_status', '$frontdesk_rep')";
$txn_insert_result = mysqli_query($dbConn, $txn_insert_query);


?>