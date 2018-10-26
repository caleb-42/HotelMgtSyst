<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $new_guest = $_POST["new_guest"];

 // $new_guest = '{"guest_name":"Ewere", "guest_type_gender": "male", "phone_number":"08023456789", "contact_address":"webplay nigeria ltd", "total_rooms_booked":9, "room_outstanding": 4000}';

 $checkin_data = $_POST["checkin_data"];

 $checkin_data = json_encode($checkin_data, true);

 $checkin_data = '{"total_rooms_booked": 3, "total_cost": 63000, "deposited": 54000, "balance": 9000, "means_of_payment": "POS", "frontdesk_rep": "Ada", "rooms": [{"room_id": "RM_64917", "guests":3, "room_rate": 33000, "check_out_date":"2018-10-31"}, {"room_id": "RM_66480", "guests":3, "room_rate": 15000, "check_out_date":"2018-10-31"}, {"room_id": "RM_71638", "guests":3, "room_rate": 15000, "check_out_date":"2018-10-31"}]}';
/*sales_details is the json string from the front-end the keys contain aspects of the
transaction */

 $new_guest = json_decode($new_guest, true);

 $guest_name = mysqli_real_escape_string($dbConn, $new_guest["guest_name"]);
 $guest_type_gender = $new_guest["guest_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = $new_guest["phone_number"];
 $contact_address = $new_guest["contact_address"];
 $total_rooms_booked = $new_guest["total_rooms_booked"];
 $no_of_nights = $new_guest["no_of_nights"];
 $d = strtotime("+"."$no_of_nights days");
 $check_out_date = date("Y-m-d", $d);
 //var_dump($check_out_date);
 $room_outstanding = $new_guest["room_outstanding"];

 $rand_id = mt_rand(0, 100000);
 $guest_id = "LOD_" . $rand_id;

 $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
 $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

 while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $guest_id = "LOD_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

 $add_new_guest_query = "INSERT INTO frontdesk_guests (guest_id, guest_name, guest_type_gender, phone_number, contact_address, room_outstanding, check_out_date, check_out_time, total_rooms_booked) VALUES('$guest_id', '$guest_name', '$guest_type_gender', '$phone_number', '$contact_address', $room_outstanding, '$check_out_date', CURRENT_TIME, $total_rooms_booked)";
 $add_new_guest_result = mysqli_query($dbConn, $add_new_guest_query);

 $rand_id = mt_rand(0, 100000);
 $booking_ref = "BK_" . $rand_id;

 $duplicate_id_query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking_ref'";
 $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

 while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $booking_ref = "BK_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking_ref'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

/* frontdesk recordings */
$select_rooms_query = $conn->prepare("SELECT current_stock, room_no, shelf_room_no, id FROM restaurant_rooms WHERE room_no = ?");

$select_rooms_query->bind_param("s", $room_no); // continue from here

 for ($i=0; $i<$no_of_rooms; $i++) { 
 	$room_no = $room_no_list[$i]["room_no"];
 	$room_no_qty = $room_no_list[$i]["quantity"];
 	$select_rooms_query->execute();
 	$select_rooms_query->bind_result($room_no_stock, $room_no_room_no, $room_no_shelf, $room_no_id);
 	$select_rooms_query->fetch();
 	if (($room_no_list[$i]["quantity"] > intval($room_no_stock)) && ($room_no_shelf == "yes")) {
 		$select_rooms_query->close();
 		die("The quantity of " . $room_no . " requested is more than stock quantity");
 	} else if (($room_no_list[$i]["quantity"] <= intval($room_no_stock)) && ($room_no_shelf == "yes")) {
 		$room_no_list[$i]["new_stock"] = intval($room_no_stock) - $room_no_qty;
 	}
 }
 $select_rooms_query->close();
 /* stock check*/

/*Record sales of individual rooms*/
$insert_into_sales = $conn->prepare("INSERT INTO restaurant_sales (sales_ref, room_no, type, quantity, unit_cost, net_cost, discount_rate, discounted_net_cost, discount_amount, sold_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$insert_into_sales->bind_param("sssiiiiiis", $tx_ref, $room_no, $type, $room_no_qty, $unit_cost, $net_cost, $discount_rate, $discounted_net_cost, $discount_amount, $sold_by);

for ($i=0; $i <$no_of_rooms ; $i++) { 
	$tx_ref = $txn_ref;
	$room_no = $room_no_list[$i]["room_no"];
	$type = $room_no_list[$i]["type"];
	$room_no_qty = $room_no_list[$i]["quantity"];
	$unit_cost = $room_no_list[$i]["current_price"];
	$net_cost = $room_no_list[$i]["net_cost"];
	$discount_rate = $room_no_list[$i]["discount_rate"];
	$discounted_net_cost = $room_no_list[$i]["discounted_net_cost"];
	$discount_amount = $room_no_list[$i]["discount_amount"];
	$sold_by = $room_no_list[$i]["sold_by"];
	$insert_into_sales->execute();
}
$insert_into_sales->close();

$update_stock_query = $conn->prepare("UPDATE restaurant_rooms SET current_stock = ? WHERE room_no = ? AND shelf_room_no = 'yes'");
$update_stock_query->bind_param("is", $new_stock, $room_no);
for ($i=0; $i <$no_of_rooms ; $i++) {
	$room_no = $room_no_list[$i]["room_no"];
	$room_no_qty = $room_no_list[$i]["quantity"];
	$shelf_room_no = $room_no_list[$i]["shelf_room_no"];
	if ($shelf_room_no == "yes") {
		$new_stock = $room_no_list[$i]["new_stock"];
		$update_stock_query->execute();
	}
}
$update_stock_query->close();
/* frontdesk recordings */

 if($add_new_guest_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
 } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG". mysqli_error($dbConn);
 }

 $response_message = json_encode($msg_response);
 echo $response_message;
?>