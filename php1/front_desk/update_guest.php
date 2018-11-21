<?php
sleep(2);
include "../settings/connect.php"; //$database handler $dbConn or $conn

$update_guest = json_decode($_POST["update_guest"], true);

// $update_guest = '{"guest_name": "sprite", "guest_type_gender": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_guest = json_decode($update_guest, true);
// var_dump($update_guest);

$id = $update_guest["id"];
$guest_name = $update_guest["new_guest_name"] ? $update_guest["new_guest_name"] : $update_guest["guest_name"];
$guest_type_gender = $update_guest["new_guest_type_gender"] ? $update_guest["new_guest_type_gender"] : $update_guest["guest_type_gender"];
$phone_number = $update_guest["new_phone_number"] ? $update_guest["new_phone_number"] : $update_guest["phone_number"];
$contact_address = $update_guest["new_contact_address"] ? $update_guest["new_contact_address"] : $update_guest["contact_address"];

$guest_name = mysqli_real_escape_string($dbConn, $guest_name);
$phone_number = mysqli_real_escape_string($dbConn, $phone_number);
$contact_address = mysqli_real_escape_string($dbConn, $contact_address);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];


if ($guest_name == "" || $phone_number == "" || $contact_address == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'guest name', 'phone number', 'contact address' are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_guest_query = "UPDATE frontdesk_guests SET guest_name = '$guest_name', guest_type_gender = '$guest_type_gender', phone_number = '$phone_number', contact_address = '$contact_address' WHERE id = $id";

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