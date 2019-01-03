<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_room_category = json_decode($_POST["new_room_category"], true);

$sales_rep = $new_room_category["sales_rep"];
$room_rate = $new_room_category["rate"];
$room_category = strtolower($new_room_category["category"]);
/* print_r([$sales_rep, $room_rate, $room_category]);
exit; */
$msg_response="";

if ($room_category == "" || $room_rate == "") {
	$msg_response = ["ERROR", "The fields 'Category' and 'Rate' are compulsory"];
	die(json_encode($msg_response));
}

$duplicate_check_query = "SELECT * FROM frontdesk_room_categories WHERE category = '$room_category'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);
//if($duplicate_check_result){
	if (mysqli_num_rows($duplicate_check_result) > 0) {
		$msg_response = ["ERROR", "this category already exist"];
		$row = mysqli_fetch_assoc($duplicate_check_result);
		die(json_encode($msg_response));
	}
//}
$add_item_query = "INSERT INTO frontdesk_room_categories (category, rate, sales_rep) VALUES ('$room_category', '$room_rate', '$sales_rep')";

$add_item_result = mysqli_query($dbConn, $add_item_query);

if ($add_item_result) {
	$msg_response = ["OUTPUT", "SUCCESSFUL"];
	echo json_encode($msg_response);
} 

?>