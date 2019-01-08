<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn
$new_category = '{"category_name":"deluxe", "cost": 30000}';
//$new_category = $_POST["new_category"];
$new_category = json_decode($new_category, true);

$category_name = $new_category["category_name"];
$cost = $new_category["cost"];

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$rand_id = mt_rand(0, 100000);
$category_id = substr($category_name, 0, 3) . "_" . $rand_id;

$duplicate_id_query = "SELECT * FROM restaurant_item_category WHERE category_id = '$category_id'";
$duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $category_id = substr($category_name, 0, 3) . "_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM restaurant_item_category WHERE category_id = '$category_id'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

$duplicate_name_query = "SELECT * FROM restaurant_item_category WHERE category_name = '$category_name'";
$duplicate_name_result = mysqli_query($dbConn, $duplicate_name_query);

if (mysqli_num_rows($duplicate_name_result) > 0) {
	$msg_response = ["ERROR", "$category_name category already exists"];
	$response_message = json_encode($msg_response);
    die($response_message);
 }

$add_new_category_sql = "INSERT INTO restaurant_item_category (category_name, category_id, cost) VALUES('$category_name', '$category_id', $cost)";
$add_new_category_result = mysqli_query($dbConn, $add_new_category_sql);

 if($add_new_category_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
 } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG". mysqli_error($dbConn);
 }

 $response_message = json_encode($msg_response);
 echo $response_message;
?>