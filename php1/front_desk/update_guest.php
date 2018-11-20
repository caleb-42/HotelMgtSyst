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
$category = $update_guest["new_category"] ? $update_guest["new_category"] : $update_guest["category"];
$description = $update_guest["new_description"] ? $update_guest["new_description"] : $update_guest["description"];
$current_price = $update_guest["new_current_price"] ? $update_guest["new_current_price"] : $update_guest["current_price"];
/* $discount_rate = !$update_guest["new_discount_rate"] ? $update_guest["new_discount_rate"] : $update_guest["discount_rate"];
$discount_criteria = !$update_guest["new_discount_criteria"] ? $update_guest["new_discount_criteria"] : $update_guest["discount_criteria"];
$discount_available = !$update_guest["new_discount_available"] ? $update_guest["new_discount_available"] : $update_guest["discount_available"]; */
$shelf_item = $update_guest["new_shelf_item"] ? $update_guest["new_shelf_item"] : $update_guest["shelf_item"];
$current_stock = $update_guest["new_current_stock"] ? $update_guest["new_current_stock"] : $update_guest["current_stock"];

$guest_name = mysqli_real_escape_string($dbConn, $guest_name);
$guest_type_gender = mysqli_real_escape_string($dbConn, $guest_type_gender);
$category = mysqli_real_escape_string($dbConn, $category);
$description = mysqli_real_escape_string($dbConn, $description);
$shelf_item = mysqli_real_escape_string($dbConn, $shelf_item);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];


if ($guest_name == "" || $guest_type_gender == "" || $category == "" || $description == "" || $current_price == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'guest name', 'guest_type_gender', 'Category', 'Description' and 'Current Price' are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}


	$update_guest_query = "UPDATE frontdesk_guests SET guest_name = '$guest_name', guest_type_gender = '$guest_type_gender', category = '$category', description = '$description', current_price = $current_price, shelf_item = '$shelf_item' WHERE id = $id";

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