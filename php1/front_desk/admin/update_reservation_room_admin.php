<?php
 include "../../settings/connect.php"; //$database handler $dbConn or $conn
 
$update_reservation = json_decode($_POST["update_reservation"], true);

// $update_guest = '{"guest_name": "sprite", "guest_type_gender": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_guest = json_decode($update_guest, true);
// var_dump($update_guest);

$reservation_ref = $update_reservation["reservation_ref"];
$room_id = $update_reservation["room_id"];
$new_room_id = $update_reservation["new_room_id"];
$no_of_nights = $update_guest["new_no_of_nights"] ? $update_guest["new_no_of_nights"] : $update_guest["no_of_nights"];

$guest_name = mysqli_real_escape_string($dbConn, $guest_name);
$phone_number = mysqli_real_escape_string($dbConn, $phone_number);
$email = mysqli_real_escape_string($dbConn, $email);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

if ($new_room_id != $room_id) {
	$check_duplicate_room_sql = "SELECT * FROM frontdesk_reservation WHERE reservation_ref = '$reservation_ref' AND room_id = '$new_room_id'";
	$check_duplicate_room = mysqli_query($dbConn, $check_duplicate_room_sql);
	if (mysqli_num_rows($check_duplicate_room) > 0) {
		$msg_response=["ERROR", "The new room already has a reservation with this reservation_ref"];
		$response_message = json_encode($msg_response);
		die($response_message);
	}
}

$room_details_sql = "SELECT * FROM frontdesk_rooms WHERE room_id = '$new_room_id'";
$room_details = mysqli_query($dbConn, $room_details_sql);
$room = mysqli_fetch_assoc($room_details);
$room_number = $room["room_number"];
$room_rate = $room["room_rate"];
$room_category = $room["room_category"];
$room_total_cost = intval($room_rate) * $no_of_nights;

if ($room_id == "" || $no_of_nights == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'room number', 'nights', are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_reservation_query = "UPDATE frontdesk_reservations SET no_of_nights = $no_of_nights, room_rate = $room_rate, room_number = $room_number, room_category = '$room_category', room_total_cost = $room_total_cost, room_id = '$new_room_id' WHERE reservation_ref = '$reservation_ref' AND room_id = '$room_id'";

$update_guest_result = mysqli_query($dbConn, $update_guest_query);

if($update_guest_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>