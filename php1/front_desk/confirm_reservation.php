<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $reservation_data = '{"reservation_ref":"RESV_6723", "amount_paid": 63000, "total_cost":171000, "room_id":"tegogs@gmail.com", "total_rooms_reserved": 3, "total_cost": 252000, "rooms": [{"room_id": "RM_64917", "guests":3, "room_rate": 33000, "no_of_nights":2, "room_category": "deluxe", "room_total_cost" : 66000, "room_reservation_date" : "2018-11-20"}, {"room_id": "RM_66480", "guests":3, "room_rate": 15000, "no_of_nights":3, "room_category": "standard", "room_total_cost" : 45000, "room_reservation_date" : "2018-11-23"}, {"room_id": "RM_71638", "guests":3, "room_rate": 15000, "no_of_nights":4, "room_category": "standard", "room_total_cost" : 60000, "room_reservation_date" : "2018-11-22"}]}';

$reservation_data = json_decode($reservation_data, true);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_ref = $reservation_data["reservation_ref"];
$amount_paid = $reservation_data["amount_paid"];
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

?>