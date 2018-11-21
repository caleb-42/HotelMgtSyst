<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 $reservation_refs = $_POST["reservation_ref"];

 //$reservation_refs = '{"reservations":[{"reservation_ref" : "RESV_90880", "room_id": "RM_98976"}, {"reservation_ref" : "RESV_90880", "room_id": "RM_98976"}]}';

 $del_reservations = json_decode($reservation_refs, true);

//$del_reservations = json_decode($_POST["del_users"], true);
//$del_users = '{"users": [{"user_name": "vivian", "id": 1}, {"user_name": "wendy", "id": 2}]}';

$deleted = [];

//$del_users = json_decode($del_users, true);
$del_array = $del_reservations["reservations"];
$no_of_reservations = count($del_array);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


$del_reservations_query = $conn->prepare("DELETE FROM frontdesk_resevations WHERE reservation_ref = ? AND room_id = ?");
$del_reservations_query->bind_param("s", $reservation_ref);

for ($i=0; $i < $no_of_reservations; $i++) { 
 	$reservation_ref = $del_array[$i]["reservation_ref"];
 	$room_id = $del_array[$i]["room_id"];
 	$del_reservations_query->execute();
 	$deleted[] = $reservation_ref;
}
$del_reservations_query->close();
$deleted_reservations = json_encode($deleted);

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