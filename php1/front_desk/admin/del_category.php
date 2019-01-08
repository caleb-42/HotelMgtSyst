<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$category = json_decode($_POST["del_category"], true);
//$del_category = '{"category": [{"category": "sprite", "id": 5}, {"category": "hot-dog", "id": 4}]}';
//$category = json_decode($del_category, true);

$deleted = [];

$del_array = $category["categories"];
$no_of_category = count($del_array);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


$delete_category_query = $conn->prepare("DELETE FROM frontdesk_room_category WHERE category_name = ? AND id = ?");
$delete_category_query->bind_param("si", $category, $category_id);
print_r($del_array);
for ($i=0; $i < $no_of_category; $i++) { 
 	$category = $del_array[$i]["category_name"];
 	$category_id = $del_array[$i]["id"];
 	$delete_category_query->execute();
 	$deleted[] = $category;
}
$deleted_category = json_encode($deleted);

if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY DELETED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>