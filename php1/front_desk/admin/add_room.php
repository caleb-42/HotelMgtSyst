<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_room = json_decode($_POST["new_room"], true);

//$new_room = '{"room_number": 202, "room_rate": 4000, "room_category": "deluxe"}';
//$new_room = json_decode($new_room, true);
// var_dump($new_room);

$room_number = $new_room["room_number"];
$room_rate = $new_room["room_rate"];
$room_category = $new_room["room_category"];
$features = $new_room["features"];
$occupancy = 0;
$current_guest_id = "";
$extra_guests = 0;

$rand_id = mt_rand(0, 100000);
$room_id = "RM_" . $rand_id;


$msg_response=["OUTPUT", "NOTHING HAPPENED"];

if ($room_number == "" || $room_rate == "") {
	$msg_response = ["ERROR","The fields 'Room number' and 'Room rate' are compulsory"];
	$response_msg = json_encode($msg_response);
	die($response_msg);
}

$room_category_check = "SELECT * FROM frontdesk_room_category WHERE category_name = '$room_category'";
$room_category_result = mysqli_query($dbConn, $room_category_check);
if (mysqli_num_rows($room_category_check) > 0) {
	$msg_response = ["ERROR", "This Category name is not among listed category"];
	$response_msg = json_encode($msg_response);
	die($response_msg);
}

$duplicate_check_query = "SELECT * FROM frontdesk_rooms WHERE room_number = '$room_number' AND room_category = '$room_category'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response = ["ERROR", "A listed room_number already exist with the same number and room_category"];
	$response_msg = json_encode($msg_response);
	$row = mysqli_fetch_assoc($duplicate_check_result);
	die($response_msg);
}

	$add_item_query = "INSERT INTO frontdesk_rooms (room_number, room_rate, room_category, room_id, features) VALUES ($room_number, $room_rate, '$room_category', '$room_id', '$features')";

$add_item_result = mysqli_query($dbConn, $add_item_query);

if ($add_item_result) {
	$msg_response = ["OUTPUT", "$room_number  was successfully added as a hotel room"];
	$response_msg = json_encode($msg_response);
} 

echo $response_msg;
?>