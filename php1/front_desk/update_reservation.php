<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 
$update_reservation = json_decode($_POST["update_reservation"], true);

// $update_reservation = '{"guest_name": "sprite", "guest_type_gender": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_reservation = json_decode($update_reservation, true);
// var_dump($update_reservation);

$reservation_ref = $update_reservation["reservation_ref"];
$guest_name = $update_reservation["new_guest_name"] ? $update_reservation["new_guest_name"] : $update_reservation["guest_name"];
$phone_number = $update_reservation["new_phone_number"] ? $update_reservation["new_phone_number"] : $update_reservation["phone_number"];
$email = $update_reservation["new_email"] ? $update_reservation["new_email"] : $update_reservation["email"];
$reserved_date = $update_reservation["new_reserved_date"] ? $update_reservation["new_reserved_date"] : $update_reservation["reserved_date"];

$guest_name = mysqli_real_escape_string($dbConn, $guest_name);
$phone_number = mysqli_real_escape_string($dbConn, $phone_number);
$email = mysqli_real_escape_string($dbConn, $email);
$rooms = [];
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$check_room_sql = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref'";
$check_room = mysqli_query($dbConn, $check_room_sql);
if (mysqli_num_rows($check_room) > 0) {
	while ($rows = mysqli_fetch_assoc($check_room)) {
		$rooms[] = $rows;
	}
	$no_of_rooms = count($rooms);
} else {
	$msg_response=["ERROR", "No reservation exists with this reservation_ref " . mysqli_error($dbConn)];
	$response_message = json_encode($msg_response);
	die($response_message);
}

/*room check*/
$reservation_conflict = [];
for ($i=0; $i<$no_of_rooms; $i++) {
   $select_rooms_query = $conn->prepare("SELECT booked, booked_on, booking_expires, room_number, reserved, reservation_date, reserved_nights  FROM frontdesk_rooms WHERE room_id = ?");
   // echo $conn->error;

   $select_rooms_query->bind_param("s", $rm_id); // continue from here
    // $d = strtotime("+"."$no_of_nights days");
    // $check_out_date = date("Y-m-d", $d);
   $rm_id = $room[$i]["room_id"];
   $no_of_nights = $room[$i]["no_of_nights"];
   $room_number = $room[$i]["room_number"];
   $select_rooms_query->execute();
   $select_rooms_query->bind_result($booked, $booked_on, $booking_expires, $room_number, $reserved, $reservation_date, $reserved_nights);
   $select_rooms_query->fetch();
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
 			$reservation_conflict[] = $room_number;
 	}
   }
}
$select_rooms_query->close();

for ($i=0; $i <$no_of_rooms ; $i++) {
	$rm_id = $room[$i]["room_id"];
	$no_of_nights = $room[$i]["no_of_nights"];
	$room_number = $room[$i]["room_number"];
	$room_reservation_date = $reserved_date;
   $room_reservation_date = date_create($room_reservation_date);
   $room_reservation_out_date = $room_reservation_date;
   date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
	$select_reservations_query = $conn->prepare("SELECT reserved_date, no_of_nights FROM frontdesk_reservations WHERE room_id = ? AND reservation_ref != '$reservation_ref'");
	$select_reservations_query->bind_param("s", $rm_id);
	$select_reservations_query->execute();
	$reservation_result = $select_reservations_query->get_result();
	if (mysqli_num_rows($reservation_result) > 0) {
	  while ($row = $reservation_result->fetch_array(MYSQLI_ASSOC) {
		$compare_checkin = date_create($row["reserved_date"]);
		$compare_checkout = $compare_checkin;
		$reserved_nights = $row["no_of_nights"];
		date_add($compare_checkout, date_interval_create_from_date_string("$reserved_nights days"));
		if ((($room_reservation_date < $compare_checkin) && ($room_reservation_out_date < $compare_checkin)) || ($room_reservation_date > $compare_checkout) && ($room_reservation_out_date > $compare_checkout)) {
 	      } else {
 	  	   $reservation_conflict[] = $room_number;
 	     }
	  }
	}
}

 if (count($reservation_conflict)) {
 	    $reservation_conflicts = implode(", ", $reservation_conflict);
 	    $msg_response[0] = "ERROR";
	    $msg_response[1] = "Room(s) " . $reservation_conflicts . " have reservation conflict(s)";
	    $response_message = json_encode($msg_response);
 		die($response_message);
 }
 /*room check*/


if ($guest_name == "" || (($phone_number == "") && ($email == ""))) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'guest name', 'phone number' or 'email' are compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_reservation_query = "UPDATE frontdesk_reservations SET guest_name = '$guest_name', reserved_date = '$reserved_date', phone_number = '$phone_number', no_of_nights = $no_of_nights, email = '$email' WHERE reservation_ref = '$reservation_ref'";

$update_reservation_result = mysqli_query($dbConn, $update_reservation_query);

if($update_reservation_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG " . mysqli_error($dbConn);
}

$response_message = json_encode($msg_response);
echo $response_message;
?>