<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_data = $_POST["reservation_data"];

 /* $reservation_data = '{"guest_name":"Ewere", "guest_id": "", "guest_type_gender": "male", "phone_number":"08023456789", "email":"tegogs@gmail.com", "total_rooms_reserved": 3, "total_cost": 252000, "frontdesk_rep": "Ada", "amount_paid": 200000, "rooms": [{"room_number": 402, "room_id": "RM_64917", "guests":3, "room_rate": 33000, "no_of_nights":2, "room_category": "deluxe", "room_total_cost" : 132000, "room_reservation_date" : "2018-11-20"}, {"room_number": 402, "room_id": "RM_66480", "guests":3, "room_rate": 15000, "no_of_nights":3, "room_category": "standard", "room_total_cost" : 60000, "room_reservation_date" : "2018-11-23"}, {"room_number": 402, "room_id": "RM_71638", "guests":3, "room_rate": 15000, "no_of_nights":4, "room_category": "standard", "room_total_cost" : 60000, "room_reservation_date" : "2018-11-22"}]}'; */
/*reservation_data is the json string from the front-end the keys contain aspects of the
transaction */
 // var_dump($reservation_data);
 //$reservation_data = json_decode($reservation_data, true);

 $rand_id = mt_rand(0, 100000);
 $reservation_ref = "RESV_" . $rand_id;

 $duplicate_id_query = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref'";
 $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 echo mysqli_error($dbConn);

 while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $reservation_ref = "RESV_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

 $guest_name = $reservation_data["guest_name"];
 $guest_name = mysqli_real_escape_string($dbConn, $guest_name);
 $guest_id = $reservation_data["guest_id"];
 $guest_id = mysqli_real_escape_string($dbConn, $guest_id);
 $email = $reservation_data["email"];
 $email = mysqli_real_escape_string($dbConn, $email);
 $guest_type_gender = $reservation_data["guest_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = mysqli_real_escape_string($dbConn, $reservation_data["phone_number"]);

 $total_rooms_reserved = $reservation_data["total_rooms_reserved"];
 $total_cost = $reservation_data["total_cost"];
 $frontdesk_rep = $reservation_data["frontdesk_rep"];
 $rooms = $reservation_data["rooms"];
 $no_of_rooms = count($rooms);

 /*room check*/
$select_rooms_query = $conn->prepare("SELECT booked, booked_on, booking_expires, room_number, reserved, reservation_date, reserved_nights  FROM frontdesk_rooms WHERE room_id = ?");
echo $conn->error;

$select_rooms_query->bind_param("s", $room_id); // continue from here
$reservation_conflict = [];

 for ($i=0; $i<$no_of_rooms; $i++) {
 	$no_of_nights = $rooms[$i]["no_of_nights"];
 	$room_reservation_date = $rooms[$i]["room_reservation_date"];
 	$room_reservation_date = date_create($room_reservation_date);
 	$room_reservation_out_date = $room_reservation_date;
 	date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
    // $d = strtotime("+"."$no_of_nights days");
    // $check_out_date = date("Y-m-d", $d);
 	$room_id = $rooms[$i]["room_id"];
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
	      //   $msg_response[0] = "ERROR";
	      //   $msg_response[1] = $room_number . " is already booked within reservation dates";
	      //   $response_message = json_encode($msg_response);
 		    // die($response_message);
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
 }
 
 $select_rooms_query->close();
 if (count($reservation_conflict)) {
 	    $reservation_conflicts = implode(", ", $reservation_conflict)
 	    $msg_response[0] = "ERROR";
	    $msg_response[1] = "Room(s) " . $reservation_conflicts . " have reservation conflict(s)";
	    $response_message = json_encode($msg_response);
 		die($response_message);
 }
 /*room check*/

 $insert_into_reservation = $conn->prepare("INSERT INTO frontdesk_reservations (reservation_ref, guest_name, guest_id, phone_number, email, frontdesk_rep, reserved_date, no_of_nights, room_id, room_number, room_rate, room_total_cost, room_category) VALUES('$reservation_ref', '$guest_name', '$guest_id', '$phone_number', '$email', '$frontdesk_rep', ?, ?, ?, ?, ?, ?, ?)");
 echo $conn->error;

 $insert_into_reservation->bind_param("sisiiis", $room_reservation_date, $no_of_nights, $room_id, $room_number, $room_rate, $room_total_cost, $room_category);

for ($i=0; $i <$no_of_rooms ; $i++) {
	$room_reservation_date = $rooms[$i]["room_reservation_date"];
	$room_id = $rooms[$i]["room_id"];
	$room_number = $rooms[$i]["room_number"];
	$room_category = $rooms[$i]["room_category"];
	$room_rate = $rooms[$i]["room_rate"];	
	$no_of_nights = $rooms[$i]["no_of_nights"];
	$room_total_cost = $room_rate * $no_of_nights;
	$d = strtotime("+"."$no_of_nights days");
	$insert_into_reservation->execute();
}
$insert_into_reservation->close();

if(!($conn->error)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "CONFIRM RESERVATION";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
 ?>