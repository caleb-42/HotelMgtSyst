<?php
sleep(2);
include "../../settings/connect.php"; //$database handler $dbConn or $conn

//$update_category = json_decode($_POST["update_category"], true);

// $update_category = '{"category": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_category": "yes", "current_stock": 50}';
// $update_category = json_decode($update_category, true);
// var_dump($update_category);

// $id = $update_category["id"];
// $old_category = $update_category["category_name"];
// $category_name = $update_category["new_category_name"] ? $update_category["new_category_name"] : $update_category["category_name"];
// $cost = $update_category["new_cost"] ? $update_category["new_cost"] : $update_category["cost"];

$old_category = "Deluxe";
$category_name = "Executive";
$cost = 30000;
$id = 1;

$category_name = mysqli_real_escape_string($dbConn, $category_name);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];


if (($category_name == "") || (!($cost))) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The field 'category name'is compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}

if ($old_category != $category_name) {
	$duplicate_check_query = "SELECT * FROM frontdesk_room_category WHERE category_name = '$category_name' AND id != $id";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
    	$msg_response[0] = "ERROR";
	    $msg_response[1] = "This name conflicts with a category name already in use";
	    $response_message = json_encode($msg_response);
	   die($response_message);
    }
}


$update_category_query = "UPDATE frontdesk_room_category SET category_name = '$category_name', cost = $cost WHERE id = $id";

$update_category_result = mysqli_query($dbConn, $update_category_query);

if($update_category_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>