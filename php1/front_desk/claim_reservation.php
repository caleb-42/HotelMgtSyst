<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $reservation_data = '{"reservation_ref":"RESV_6723", "amount_paid": 63000, "total_cost":171000, "means_of_payment":"INTERNET TRANSFER", "guest_id":"", "frontdesk_rep":"Ada", "total_rooms_reserved": 3}';

 $reservation_data = json_decode($reservation_data, true);
 $msg_response = ["OUTPUT", "NOTHING HAPPENED"];
 $reservations = [];

 $guest_id = $reservation_data["guest_id"];

 if ($guest_id == "") {
 	$rand_id = mt_rand(0, 100000);
    $guest_id = "LOD_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

    while (mysqli_num_rows($duplicate_id_result) > 0) {
	   $rand_id = mt_rand(0, 100000);
       $guest_id = "LOD_" . $rand_id;

       $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
       $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
    }
 }

 $reservation_ref = $reservation_data["reservation_ref"];

 $get_reservations = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref'";
 $get_reservations_result = mysqli_query($dbConn, $get_reservations);

 if (mysqli_num_rows($get_reservations_result) > 0){
 	  while($rows = mysqli_fetch_assoc($get_reservations_result)) {
 		$reservations[] = $rows;
 	  }
 }

$update_room_query = $conn->prepare("UPDATE frontdesk_rooms SET booked_on = CURRENT_TIMESTAMP, booked = 'YES', guests = ?, current_guest_id = ?, booking_ref = ?, booking_expires = ? WHERE room_id = ?");
$update_room_query->bind_param("issss", $guests, $current_guest_id, $bk_ref, $booking_expires, $room_id);
for ($i=0; $i <$no_of_rooms ; $i++) {
	$no_of_nights = $reservations[$i]["no_of_nights"];
	$d = strtotime("+"."$no_of_nights days");
	$booking_expires = date("Y-m-d h:i:s", $d);
	$room_id = $reservations[$i]["room_id"];
	$guests = $reservations[$i]["guests"];
	$bk_ref = $reservation_ref;
	$current_guest_id = $guest_id;
	$update_room_query->execute();
}
$update_room_query->close();
?>