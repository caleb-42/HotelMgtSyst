<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$update_room_category = json_decode($_POST["update_room_category"], true);

// $update_room_category = '{"room": "sprite", "type": "soft-drink", "room_category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_room": "yes", "current_stock": 50}';
// $update_room_category = json_decode($update_room_category, true);
// var_dump($update_room_category);

$room_id = $update_room_category["id"];

$room_rate = $update_room_category["new_rate"] ? $update_room_category["new_rate"] : $update_room_category["rate"];

$room_category = $update_room_category["new_category"] ? $update_room_category["new_category"] : $update_room_category["category"];

$old_room_category = $update_room_category["category"];

if ($update_room_category["category"] !== $room_category) {
	$duplicate_check_query = "SELECT * FROM frontdesk_room_categories WHERE category = '$room_category'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
    	$msg_response = ["ERROR", "category name is conflicting with another"];
	    $response_message = json_encode($msg_response);
	   die($response_message);
    }
}

$update_room_category_query = "UPDATE frontdesk_rooms SET room_category = '$room_category', room_rate = '$room_rate' WHERE room_category = '$old_room_category'";

$update_room_category_result = mysqli_query($dbConn, $update_room_category_query);

$update_room_query = "UPDATE frontdesk_room_categories SET category = '$room_category', rate = '$room_rate' WHERE id = '$room_id'";

$update_room_result = mysqli_query($dbConn, $update_room_query);

if($update_room_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>