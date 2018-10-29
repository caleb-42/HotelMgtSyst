<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$printerFile = fopen("assets/printer.txt", "r");
$printName = fgets($printerFile);
fclose($printerFile);

$shop_name_file = fopen("assets/shop_name.txt", "r");
$shop_name = fgets($shop_name_file);
fclose($shop_name_file);

$shop_address_file = fopen("assets/shop_address.txt", "r");
$shop_address = fgets($shop_address_file);
fclose($shop_address_file);

$shop_contact_file = fopen("assets/shop_contact.txt", "r");
$shop_contact = fgets($shop_contact_file);
fclose($shop_contact_file);

$biz_name = $shop_name;
$biz_add = $shop_address . "\n";
$biz_contact = $shop_contact . "\n";

$connector = new WindowsPrintConnector($printName);
$printer = new Printer($connector);

 $checkout_data = '{"booking_ref":"BK_9989", "guest_name":"Ewere", "guest_type_gender": "male", "guest_id":"LOD_5464", "room_outstanding": 4000, "total_rooms_booked": 3, "frontdesk_rep": "Ada", "restaurant_outstanding": 4000, "rooms": [{"room_id": "RM_64917"}, {"room_id": "RM_66480"}, {"room_id": "RM_71638"}]}';

 // $checkout_data = $_POST["checkout_data"];

$checkout_data = json_decode($checkout_data, true);

$guest_name = $checkout_data["guest_name"];
$guest_id = $checkout_data["guest_id"];
$rooms = $checkout_data["rooms"];
$no_of_rooms = count($rooms);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$check_outstanding_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
$check_outstanding_result = mysqli_query($dbConn, $check_outstanding_query);
$outstanding_row = mysqli_fetch_assoc($check_outstanding_result);

if ($outstanding_row["room_outstanding"] != 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "This guest has a booking outstanding balance";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
}

if ($outstanding_row["restaurant_outstanding"] != 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "This guest has a restaurant outstanding balance";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
}

$checkout_bookings_query = "UPDATE frontdesk_bookings SET checked_out ='YES', check_out_time = CURRENT_TIMESTAMP";
$checkout_bookings_result = mysqli_query($dbConn, $checkout_bookings_query);

$checkout_guest_query = "UPDATE frontdesk_guests SET checked_out ='YES', checked_in = 'NO', visit_count = visit_count + 1";
$checkout_guest_result = mysqli_query($dbConn, $checkout_guest_query);

$update_room_query = $conn->prepare("UPDATE frontdesk_rooms SET booked_on = '0', booked = 'NO', guests = 0, current_guest_id = '', booking_ref = '', booking_expires = '0' WHERE room_id = ?");
$update_room_query->bind_param("s", $room_id);
for ($i=0; $i <$no_of_rooms ; $i++) {
	$room_id = $rooms[$i]["room_id"];
	$update_room_query->execute();
}
$update_room_query->close();
$msg_response[0] = "OUTPUT";
$msg_response[1] = "CHECKED OUT";
$response_message = json_encode($msg_response);
?>