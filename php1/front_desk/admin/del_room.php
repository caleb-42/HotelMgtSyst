<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn
$del_rooms = json_decode($_POST["del_rooms"], true);
//$del_rooms = '{"rooms": [{"room_id": "RM_98889", "room_number": "101"}, {"room_id": "RM_78773", "room_number": "102"}]}';

$deleted = [];

//$del_rooms = json_decode($del_rooms, true);
$del_array = $del_rooms["rooms"];
$no_of_rooms = count($del_array);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


$delete_rooms_query = $conn->prepare("DELETE FROM frontdesk_rooms WHERE room_id = ?");
$delete_rooms_query->bind_param("s", $room_id);

for ($i=0; $i < $no_of_rooms; $i++) { 
 	$room_id = $del_array[$i]["room_id"];
 	$room_number = $del_array[$i]["room_number"];
 	$delete_rooms_query->execute();
 	$deleted[] = $room_number;
}
$delete_rooms_query->close();
$deleted_rooms = json_encode($deleted);

if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = $deleted_rooms;
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>