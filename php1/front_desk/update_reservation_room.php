<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 
$update_reservation = json_decode($_POST["update_reservation"], true);

// $update_reservation = '{"guest_name": "sprite", "guest_type_gender": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_reservation = json_decode($update_reservation, true);
// var_dump($update_reservation);

$reservation_ref = $update_reservation["reservation_ref"];
$room_id = $update_reservation["room_id"];
$new_room_id = $update_reservation["new_room_id"];
$reserved_date = $update_reservation["reserved_date"];
$no_of_nights = $update_reservation["new_no_of_nights"] ? $update_reservation["new_no_of_nights"] : $update_reservation["no_of_nights"];

$reservation_conflict = [];

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

if (($new_room_id != $room_id) AND ($new_room_id != "")) {
	$check_duplicate_room_sql = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref' AND room_id = '$new_room_id'";
	$check_duplicate_room = mysqli_query($dbConn, $check_duplicate_room_sql);
	if (mysqli_num_rows($check_duplicate_room) > 0) {
		$msg_response=["ERROR", "The new room already has a reservation with this reservation_ref "];
		$response_message = json_encode($msg_response);
		die($response_message);
	}

	$check_conflict_sql = "SELECT * FROM frontdesk_reservations WHERE reservation_ref != '$reservation_ref' AND room_id = '$new_room_id'";
	$conflict_room = mysqli_query($dbConn, $check_conflict_sql);
	if (mysqli_num_rows($conflict_room) > 0) {
		$room_reservation_date = $reserved_date;
        $room_reservation_date = date_create($room_reservation_date);
        $room_reservation_out_date = $room_reservation_date;
        date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
		while ($row = mysqli_fetch_assoc($conflict_room)) {
			$compare_checkin = date_create($row["reserved_date"]);
		    $compare_checkout = $compare_checkin;
		    $reserved_nights = $row["no_of_nights"];
		   date_add($compare_checkout, date_interval_create_from_date_string("$reserved_nights days"));
		   if ((($room_reservation_date < $compare_checkin) && ($room_reservation_out_date < $compare_checkin)) || ($room_reservation_date > $compare_checkout) && ($room_reservation_out_date > $compare_checkout)) {
 	       } else {
 	  	       $reservation_conflict[] = $row["reservation_ref"];
 	       }
		}
	}
}

if ($new_room_id == "") {
	$new_room_id = $room_id;
}

$room_details_sql = "SELECT * FROM frontdesk_rooms WHERE room_id = '$new_room_id'";
$room_details = mysqli_query($dbConn, $room_details_sql);
$room = mysqli_fetch_assoc($room_details);
$room_number = $room["room_number"];
$room_rate = $room["room_rate"];
$room_category = $room["room_category"];
$booked = $room["booked"];
$booked_on = $room["booked_on"];
$booking_ref = $room["booking_ref"];
$booking_expires = $room["booking_expires"];

   $room_reservation_date = $reserved_date;
   $room_reservation_date = date_create($room_reservation_date);
   $room_reservation_out_date = $room_reservation_date;
   date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
 	// echo $room_id;
 	// echo mysqli_error($conn);
   if ($booked == "YES") {
	$compare_checkin = date_create($booked_on);
	$compare_checkout = date_create($booking_expires);
 		//remove if statement to prevent booked rooms from being reserved at all, for cases of booking extension
	if ((($room_reservation_date < $compare_checkin) && ($room_reservation_out_date < $compare_checkin)) || ($room_reservation_date > $compare_checkout) && ($room_reservation_out_date > $compare_checkout)) {
    } else {
 			$reservation_conflict[] = $booking_ref;
 	}
   }

 if (count($reservation_conflict)) {
 	    $reservation_conflicts = implode(", ", $reservation_conflict);
 	    $msg_response[0] = "ERROR";
	    $msg_response[1] = "Room " . $reservation_conflicts . " conflicts with a booking";
	    $response_message = json_encode($msg_response);
 		die($response_message);
 }

$room_total_cost = intval($room_rate) * $no_of_nights;

if ($room_id == "" || $no_of_nights == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'room number', 'nights', are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_reservation_query = "UPDATE frontdesk_reservations SET no_of_nights = $no_of_nights, room_rate = $room_rate, room_number = $room_number, room_category = '$room_category', room_total_cost = $room_total_cost, room_id = '$new_room_id' WHERE reservation_ref = '$reservation_ref' AND room_id = '$room_id'";

$update_reservation_result = mysqli_query($dbConn, $update_reservation_query);

if($update_reservation_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED ";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG ". " halo " . mysqli_error($dbConn);
}

$response_message = json_encode($msg_response);
echo $response_message;
?>