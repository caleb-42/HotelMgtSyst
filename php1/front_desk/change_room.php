<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn


/*change room no in booking */
$room_data = json_decode($_POST['change_room'], true);

$current_room = intval($room_data['current_room']);
$new_room = intval($room_data['new_room']);
$booking = $room_data['booking_ref'];

$query = "SELECT * FROM frontdesk_rooms WHERE room_number = $current_room";
$result = mysqli_query($dbConn, $query);
$arr = mysqli_fetch_assoc($result);

$current_guest_id = $arr['current_guest_id'];
$booked_on = $arr['booked_on'];
$booking_expires = $arr['booking_expires'];

$query = "SELECT * FROM frontdesk_rooms WHERE room_number = $new_room";
$result = mysqli_query($dbConn, $query);
$arr = mysqli_fetch_assoc($result);

$new_room_id = $arr['room_id'];

//exit;

$query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking' AND room_number = $current_room";
$result = mysqli_query($dbConn, $query);
$arr = mysqli_fetch_assoc($result);

$id = intval($arr['id']);


$query = "UPDATE `frontdesk_bookings` SET room_number = $new_room, room_id = '$new_room_id' WHERE id = $id";
$result = mysqli_query($dbConn, $query);

$query = "SELECT * FROM frontdesk_reservations WHERE booking_ref = '$booking' AND room_number = $current_room";
$result = mysqli_query($dbConn, $query);
$arr = mysqli_fetch_assoc($result);


$id = intval($arr['id']);

$query = "UPDATE `frontdesk_reservations` SET room_number = '$new_room', room_id = '$new_room_id' WHERE id = $id";
$result = mysqli_query($dbConn, $query);

$query = "UPDATE `frontdesk_rooms` SET current_guest_id = '', booking_ref = '', booked = 'NO', booked_on = '', booking_expires = '' WHERE room_number = $current_room";
$result = mysqli_query($dbConn, $query);

$query = "UPDATE `frontdesk_rooms` SET current_guest_id = '$current_guest_id', booking_ref = '$booking', booked = 'YES', booked_on = '$booked_on', booking_expires = '$booking_expires' WHERE room_number = $new_room";
$result = mysqli_query($dbConn, $query);

$msg_response = [];

if($result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "ROOM CHANGED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

echo json_encode($msg_response);

?>