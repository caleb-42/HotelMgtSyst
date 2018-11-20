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

 // $reservation_data = '{"reservation_ref":"RESV_22097", "frontdesk_rep":"Ada"}';
 $reservation_data = $_POST["reservation_data"];
 $reservation_data = json_decode($reservation_data, true);
 $msg_response = ["OUTPUT", "NOTHING HAPPENED"];

 $reservation_ref = $reservation_data["reservation_ref"];

$get_all_ref_details_sql = "SELECT * FROM frontdesk_reservations WHERE deposit_confirmed = 'YES' AND reservation_ref = '$reservation_ref'";
$get_all_ref_results = mysqli_query($dbConn, $get_all_ref_details_sql);
if (mysqli_num_rows($get_all_ref_results)) {
	$no_of_rooms = mysqli_num_rows($get_all_ref_results);
	$i = 0;
	while ($row = mysqli_fetch_assoc($get_all_ref_results)) {
		$rooms[$i]["room_id"] = $row["room_id"];
		$guest_id = $row["guest_id"];
		$guest_name = $row["guest_name"];
	}
} else {
	$msg_response=["ERROR", "This reservation has not been confirmed"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

 $reservations = [];
 $frontdesk_rep = $reservation_data["frontdesk_rep"];

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

 $get_reservations_query = $conn->prepare("SELECT no_of_nights, reserved_date, booked, cancelled, room_number, room_category, room_rate, room_total_cost FROM frontdesk_reservations WHERE reservation_ref = '$reservation_ref' AND room_id = ?");
 
 $get_reservations_query->bind_param("s", $room_id);

 $expired_reservations = [];
 $booked_reservations = [];
 $cancelled_reservations = [];

 for ($i=0; $i < $no_of_rooms ; $i++) { 
 	$room_id = $rooms[$i]["room_id"];
 	$get_reservations_query->execute();
 	$get_reservations_query->bind_result($no_of_nights, $reserved_date, $booked, $cancelled, $room_number, $room_category, $room_rate, $room_total_cost);
 	$get_reservations_query->fetch();
 	$room_reservation_date = $reserved_date;
 	$room_reservation_date = date_create($room_reservation_date);
 	$room_reservation_out_date = $room_reservation_date;
 	date_add($room_reservation_out_date, date_interval_create_from_date_string("$no_of_nights days"));
 	$rooms[$i]["reserved_out_date"] = $room_reservation_out_date;
 	$today = date("Y-m-d");
 	if ($room_reservation_out_date <= $today) {
 		$expired_reservations[] = $room_id;
 	}
 	if ($cancelled == "CANCELLED") {
 		$cancelled_reservations[] = $room_id;
 	}
 	if ($booked == "BOOKED") {
 		$booked_reservations[] = $room_id;
 	}
 	$rooms[$i]["no_of_nights"] = $no_of_nights;
 	$rooms[$i]["reserved_date"] = $reserved_date;
 	$rooms[$i]["booked"] = $booked;
 	$rooms[$i]["cancelled"] = $cancelled;
 	$rooms[$i]["room_number"] = $room_number;
 	$rooms[$i]["room_category"] = $room_category;
 	$rooms[$i]["room_rate"] = $room_rate;
 	$rooms[$i]["room_total_cost"] = $room_total_cost;
 	$rooms[$i]["guests"] = 1;
 }
 $get_reservations_query->close();


 if (count($expired_reservations) != 0) {
 	$list_expired_reservations = implode(", ", $expired_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_expired_reservations have/has expired reservations";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

  if (count($cancelled_reservations) != 0) {
 	$list_cancelled_reservations = implode(", ", $cancelled_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_cancelled_reservations have/has cancelled reservations";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

  if (count($expired_reservations) != 0) {
 	$list_booked_reservations = implode(", ", $booked_reservations);
 	$msg_response[0] = "ERROR";
	$msg_response[1] = "$list_booked_reservations have/has been booked";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
 }

 $insert_into_bookings = $conn->prepare("INSERT INTO frontdesk_bookings (booking_ref, reservation_ref, room_number, room_id, room_category, room_rate, guest_name, guest_id, no_of_nights, net_cost, guests, expected_checkout_date, expected_checkout_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, CURRENT_TIME)");

$insert_into_bookings->bind_param("ssississiiis", $tx_ref, $reserve_ref, $room_number, $room_id, $room_category, $room_rate, $client_name, $client_id, $no_of_days, $room_net_cost, $guests, $expected_checkout_date);

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
	$expected_checkout_date = date_format($expected_checkout_date, "Y-m-d");
	// var_dump($expected_checkout_date);
	// $test = date_format($expected_checkout_date, "Y-m-d");
	// var_dump($test);
	$insert_into_bookings->execute();
	echo $conn->error;
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

$get_reservation_details = "SELECT * FROM frontdesk_reservation_txn WHERE reservation_ref = '$reservation_ref'";
$reservation_details = mysqli_query($dbConn, $get_reservation_details);
$reservation_row = mysqli_fetch_assoc($reservation_details);

$total_cost = $reservation_row["total_cost"];
$deposited = $reservation_row["deposited"];
$means_of_payment = $reservation_row["means_of_payment"];

/*Print Frontdesk Receipts*/

/*Receipt printer initialization, initial parameters set*/

$fp = fopen("receipt.txt", "w+");

$highSeparator = "--------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

$receiptNo = "BOOKING REF.:" . $booking_ref ."         ";
$current_date = date("D M d, Y g:i a");
$receipt_time = "Receipt Generated on:\n" . $current_date . "\n";

$header = $biz_add . $biz_contact;

/*Receipt printer initialization, initial parameters set*/
$logo = "assets/logo.png";

function receipt_header($fprinter, $org_name, $header_msg, $receipt_no, $high_separator){
    if (!$fprinter) {
       echo "$errstr ($errno)<br />\n";
    } else {
    fwrite($fprinter, "\033\100");
    fwrite($fprinter, "\x1B\x61\x01");
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, "\n");
    fwrite($fprinter, $org_name);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, "\n");
    fwrite($fprinter, $header_msg);
    fwrite($fprinter, "\x1B\x61\x00");
    fwrite($fprinter, "\x0A");
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, $receipt_no);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, $high_separator);
   }
}

function receipt_body($fprinter, $rooms_arr, $room_arr_count, $cost_due, $paid_amount, $normal_separator, $two_line_separator, $paid_with, $time_of_issue) {
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Room(category)");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "  ");
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Cost");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "    ");
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Night(s)");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "\x0A");

	for ($i=0; $i<$room_arr_count; $i++) {
		$rm = $rooms_arr[$i]["room_number"] . " (" . $rooms_arr[$i]["room_category"] . ")";
		if(strlen($rm) < 16) {
		  fwrite($fprinter, $rm);
		  for ($x=0; $x<(16-strlen($rm)); $x++){
			fwrite($fprinter, " ");
		  }
	    } elseif (strlen($rm) < 33) {
	    	$rm = wordwrap($rm, 16, "\n", true);
	    	$array_rooms = explode("\n", $rm);
	    	fwrite($fprinter, $item);
	    	for ($x=0; $x<(17-strlen($array_rooms[count($array_rooms) - 1])); $x++){
			fwrite($fprinter, " ");
		  }
	    } elseif (strlen($rm) < 49) {
	    	$rm = wordwrap($rm, 16, "\n", true);
	    	$array_rooms = explode("\n", $rm);
	    	fwrite($fprinter, $item);
	    	for ($x=0; $x<(17-strlen($array_rooms[count($array_rooms) - 1])); $x++){
			fwrite($fprinter, " ");
		  }
	    } 

		$net_cost_of_rm = $rooms_arr[$i]["room_total_cost"];
		fwrite($fprinter,  "N" .number_format($net_cost_of_rm));

		$temp_str_len = 14 -strlen($net_cost_of_rm);
	    

	    $nights = $rooms_arr[$i]["no_of_nights"];
	    if (strlen($nights) < 5) {
	    	for ($x=0; $x<($temp_str_len -strlen($nights)); $x++){
	    		fwrite($fprinter, " ");
	    	}
	    	fwrite($fprinter, $nights);
	    	fwrite($fprinter, "\n");
	    }
	}

	$balance_amount = $cost_due - $paid_amount;
    $paid_string = "Amt. Paid: N". number_format($paid_amount) . "\n";
    $balance_string  = "Balance:   N" . number_format($balance_amount) . "\n";
    $total_rms = "Rooms Booked: " . $room_arr_count . "\n";
    $receipt_paid_with = "Paid: $paid_with\n";

    fwrite($fprinter, $normal_separator);
    fwrite($fprinter, $total_rms);
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, $paid_string);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, $receipt_paid_with);
    fwrite($fprinter, $balance_string);
    fwrite($fprinter, "\x1D\x34\x01");
    fwrite($fprinter, "Cost Total: ");
    fwrite($fprinter, "\x1D\x34\x00");
    fwrite($fprinter, "\x1D\x21\x11");
    if ($cost_due) {
	  fwrite($fprinter, "N");
    }

    if ($cost_due) {
	   fwrite($fprinter, number_format($cost_due));
    } else {
	   fwrite($fprinter, $cost_due);
    }

    fwrite($fprinter, "\x1D\x21\x00");
    fwrite($fprinter, "\x0A");
    fwrite($fprinter, $two_line_separator);
    fwrite($fprinter, $time_of_issue);
    fwrite($fprinter, "\x0A");
}

$partingMsg = "Thanks for staying with us.\nPls call again.\nAttendant: $frontdesk_rep\n";
if ($guest_name) {
  $customer_msg = "GUEST: " . $guest_name . "\n";
} else {
  $customer_msg = "";
}
$poweredBy = "Powered by: WEBPLAY ePOS.\nwww.epos.ng | 2348139097050\n";

function receipt_footer($fprinter, $solid_separator, $parthian, $cus_msg, $powered_msg){
    $footer = $parthian . $cus_msg . $solid_separator . $powered_msg;
	fwrite($fprinter, "\x1B\x61\x01");
    fwrite($fprinter, $footer);
    fwrite($fprinter, "\x1B\x61\x00");
    fwrite($fprinter, "\012\012\012\033\151\010\004\001");
    fclose($fprinter);
}

// function receipt_logo($fprinter, $pic){
//   try {
//     $tux = EscposImage::load($pic, false);
//     $fprinter -> setJustification(Printer::JUSTIFY_CENTER);    
//     $fprinter -> bitImageColumnFormat($tux);
//     $fprinter -> setJustification(Printer::JUSTIFY_LEFT);
//   } catch (Exception $e) {
//      /* Images not supported on your PHP, or image file not found */
//      $fprinter -> text($e -> getMessage() . "\n");
//   }
//   $fprinter -> close();
// }
//receipt_logo($printer, $logo);  //Print receipt logo
  try {
    $tux = EscposImage::load($logo, false);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);    
    $printer -> bitImageColumnFormat($tux);
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
  } catch (Exception $e) {
     /* Images not supported on your PHP, or image file not found */
     $printer -> text($e -> getMessage() . "\n");
  }
  $printer -> close();

/* Complete Receipt Printing */
receipt_header($fp, $biz_name, $header, $receiptNo, $highSeparator);
receipt_body($fp, $rooms, $no_of_rooms, $total_cost, $deposited, $separator, $doubleSeparator, $means_of_payment, $receipt_time);
receipt_footer($fp, $separatorSolid, $partingMsg, $customer_msg, $poweredBy);

$printData = file_get_contents("receipt.txt");
$print_buffer[] = $printData;
$device = "\\\\" . gethostname() . "\\" . $printName;
$filename = tempnam(sys_get_temp_dir(), "webpos");
file_put_contents($filename, $printData);

copy($filename, $device);       //Print receipt contents
unlink($filename);
/*Print Frontdesk Receipts*/

 if(!($conn->error)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY BOOKED". mysqli_error($dbConn);
 } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG". mysqli_error($dbConn);
 }

 $response_message = json_encode($msg_response);
 echo $response_message;
?>