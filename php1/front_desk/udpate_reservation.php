<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 
$update_reservation = json_decode($_POST["update_reservation"], true);

// $update_guest = '{"guest_name": "sprite", "guest_type_gender": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_guest = json_decode($update_guest, true);
// var_dump($update_guest);

$reservation_ref = $update_reservation["reservation_ref"];
$room_id = $update_reservation["room_id"];
$new_room_id = $update_reservation["new_room_id"];
$no_of_nights = $update_guest["new_no_of_nights"] ? $update_guest["new_no_of_nights"] : $update_guest["no_of_nights"];
$guest_name = $update_guest["new_guest_name"] ? $update_guest["new_guest_name"] : $update_guest["guest_name"];
$phone_number = $update_guest["new_phone_number"] ? $update_guest["new_phone_number"] : $update_guest["phone_number"];
$email = $update_guest["new_email"] ? $update_guest["new_email"] : $update_guest["email"];
$reserved_date = $update_guest["new_reserved_date"] ? $update_guest["new_reserved_date"] : $update_guest["reserved_date"];

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

 /*room check*/
$select_rooms_query = $conn->prepare("SELECT booked, booked_on, booking_expires, room_number, reserved, reservation_date, reserved_nights  FROM frontdesk_rooms WHERE room_id = ?");
// echo $conn->error;

$select_rooms_query->bind_param("s", $rm_id); // continue from here
$reservation_conflict = [];

$room_reservation_date = $reserved_date;
$room_reservation_date = date_create($room_reservation_date);
$room_reservation_out_date = $room_reservation_date;
date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
    // $d = strtotime("+"."$no_of_nights days");
    // $check_out_date = date("Y-m-d", $d);
$rm_id = $new_room_id;
$select_rooms_query->execute();
$select_rooms_query->bind_result($booked, $booked_on, $booking_expires, $room_number, $reserved, $reservation_date, $reserved_nights);
$select_rooms_query->fetch();
 	// echo $room_id;
 	// echo mysqli_error($conn);
if ($booked == "YES") {
	$compare_checkin = date_create($booked_on);
	$compare_checkout = date_create($booking_expires);
 		//remove if statement to prevent booked rooms from being reserved at all, for cases of booking extension
	if ((($room_reservation_date < $compare_checkin) && ($room_reservation_out_date < $compare_checkin)) || ($room_reservation_date > $compare_checkout) && ($room_reservation_out_date > $compare_checkout)) {
    } else {
 			$reservation_conflict[] = $room_number;
 	}
}

if ($reserved == "YES") {
 	   $compare_checkin = date_create($reservation_date);
 	   $compare_checkout = $compare_checkin;
 	   date_add($compare_checkout, date_interval_create_from_date_string("$reserved_nights days"));
 	   if ((($room_reservation_date < $compare_checkin) && ($room_reservation_out_date < $compare_checkin)) || ($room_reservation_date > $compare_checkout) && ($room_reservation_out_date > $compare_checkout)) {
 	   } else {
 	  	   $reservation_conflict[] = $room_number;
	     //   $msg_response[0] = "ERROR";
	     //   $msg_response[1] = $room_number . " has a reservation during the selected check-in and check-out";
	     //   $response_message = json_encode($msg_response);
 		   // die($response_message);
 	  }
} 
 
$select_rooms_query->close();
 if (count($reservation_conflict)) {
 	    $reservation_conflicts = implode(", ", $reservation_conflict);
 	    $msg_response[0] = "ERROR";
	    $msg_response[1] = "Room(s) " . $reservation_conflicts . " have reservation conflict(s)";
	    $response_message = json_encode($msg_response);
 		die($response_message);
 }
 /*room check*/



if ($guest_name == "" || $phone_number == "" || $email == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'guest name', 'phone number', 'email' are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_reservation_query = "UPDATE frontdesk_reservations SET guest_name = '$guest_name', reserved_date = '$reserved_date', phone_number = '$phone_number', no_of_nights = $no_of_nights, email = '$email' WHERE reservation_ref = '$reservation_ref', room_id = '$room_id', room_rate = $room_rate, room_number = $room_number, room_category = '$room_category', room_total_cost = $room_total_cost";

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