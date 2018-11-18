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

 // $reservation_data = '{"reservation_ref":"RESV_6723", "guest_id":"", "frontdesk_rep":"Ada", "guest_name":"James Baldwin", "rooms":[{"room_id":"RM_23454"}, {"room_id":"RM_23454"}, {"room_id":"RM_23454"}]}';

 $reservation_data = json_decode($reservation_data, true);
 $msg_response = ["OUTPUT", "NOTHING HAPPENED"];
 $reservations = [];
 $rooms = $reservation_data["rooms"];
 $no_of_rooms = count($rooms);
 $guest_name = $reservation_data["guest_name"];

 $reservation_ref = $reservation_data["reservation_ref"];

 $check_confirmed_query = "SELECT * FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref' AND deposit_confirmed = 'YES'";
 $check_confirmed_result = mysqli_query($dbConn, $check_confirmed_query);
 if (!(mysqli_num_rows($check_confirmed_result))) {
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "This reservation has not been confirmed";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

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


 $guest_id = $reservation_data["guest_id"];

 if ($guest_id == "") {
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
 }

 $get_reservations_query = $conn->prepare("SELECT no_of_nights, reserved_date, booked, cancelled, room_number, room_category, room_rate, room_total_cost, guests FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref' AND room_id = ?");
 $get_reservations_query->bind_param("s", $room_id);

 $expired_reservations = [];
 $booked_reservations = [];
 $cancelled_reservations = [];

 for ($i=0; $i < $no_of_rooms ; $i++) { 
 	$room_id = $rooms[$i]["room_id"];
 	$get_reservations_query->execute();
 	$get_reservations_query->bind_result($no_of_nights, $reserved_date, $booked, $cancelled, $room_number, $room_category, $room_rate, $room_total_cost, $guests);
 	$get_reservations_query->fetch();
 	$room_reservation_date = $rooms[$i]["reserved_date"];
 	$room_reservation_date = date_create($room_reservation_date);
 	$room_reservation_out_date = $room_reservation_date;
 	date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
 	$rooms[$i]["reserved_out_date"] = $room_reservation_out_date;
 	$today = date("Y-m-d");
 	if ($room_reservation_out_date <= $today) {
 		$expired_reservations[] = $room_id;
 	}
 	if ($cancelled == "CANCELLED") {
 		$cancelled_reservations[] = $room_id
 	}
 	if ($booked == "BOOKED") {
 		$booked_reservations[] = $room_id
 	}
 	$rooms[$i]["no_of_nights"] = $no_of_nights;
 	$rooms[$i]["reserved_date"] = $reserved_date;
 	$rooms[$i]["booked"] = $booked;
 	$rooms[$i]["cancelled"] = $cancelled;
 	$rooms[$i]["room_number"] = $room_number;
 	$rooms[$i]["room_category"] = $room_category;
 	$rooms[$i]["room_rate"] = $room_rate;
 	$rooms[$i]["room_total_cost"] = $room_total_cost;
 	$rooms[$i]["guests"] = $guests;
 }


 if (count($expired_reservations) == 0) {
 	$list_expired_reservations = implode(", ", $expired_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_expired_reservations have/has expired reservations";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

  if (count($cancelled_reservations) == 0) {
 	$list_cancelled_reservations = implode(", ", $cancelled_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_cancelled_reservations have/has cancelled reservations";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

  if (count($expired_reservations) == 0) {
 	$list_booked_reservations = implode(", ", $booked_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_booked_reservations have/has been booked";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

 $insert_into_bookings = $conn->prepare("INSERT INTO frontdesk_bookings (booking_ref, reservation_ref, room_number, room_id, room_category, room_rate, guest_name, guest_id, no_of_nights, net_cost, guests, expected_checkout_date, expected_checkout_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, CURRENT_TIME)");

$insert_into_bookings->bind_param("sississiiis", $tx_ref, $reserve_ref, $room_number, $room_id, $room_category, $room_rate, $client_name, $client_id, $no_of_days, $room_net_cost, $guests, $expected_checkout_date);

for ($i=0; $i <$no_of_rooms; $i++) { 
	$tx_ref = $booking_ref;
	$reserve_ref = $reservation_ref;
	$room_number = $rooms[$i]["room_number"];
	$room_id = $rooms[$i]["room_id"];
	$room_category = $rooms[$i]["room_category"];
	$room_rate = $rooms[$i]["room_rate"];
	$guests = $rooms[$i]["guests"];
	$client_name = $guest_name;
	$client_id = $guest_id;	
	$no_of_days = $rooms[$i]["no_of_nights"];
	$room_net_cost = $room_rate * $no_of_days;
	$rooms[$i]["room_total_cost"] = $room_net_cost;
	$expected_checkout_date =  $rooms[$i]["reserved_out_date"];
	$insert_into_bookings->execute();
}
$insert_into_bookings->close();

$update_room_query = $conn->prepare("UPDATE frontdesk_rooms SET booked_on = CURRENT_TIMESTAMP, booked = 'YES', guests = ?, current_guest_id = ?, booking_ref = ?, booking_expires = ? WHERE room_id = ?");
$update_room_query->bind_param("issss", $guests, $current_guest_id, $bk_ref, $booking_expires, $room_id);
for ($i=0; $i <$no_of_rooms ; $i++) {
	$no_of_nights = $rooms[$i]["no_of_nights"];
	$d = strtotime("+"."$no_of_nights days");
	$booking_expires = date("Y-m-d h:i:s", $d);
	$room_id = $rooms[$i]["room_id"];
	$guests = $rooms[$i]["guests"];
	$bk_ref = $booking_ref;
	$current_guest_id = $guest_id;
	$update_room_query->execute();
}
$update_room_query->close();
?>