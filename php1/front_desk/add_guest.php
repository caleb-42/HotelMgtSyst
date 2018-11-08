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

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

  $checkin_data = $_POST["checkin_data"];

 /* $checkin_data = '{"guest_name":"Ewere", "guest_type_gender": "male", "phone_number":"08023456789", "contact_address":"webplay nigeria ltd", "room_outstanding": 4000, "total_rooms_booked": 3, "total_cost": 63000, "deposited": 54000, "balance": 9000, "means_of_payment": "POS", "frontdesk_rep": "Ada", "rooms": [{"room_number": 102, "room_id": "RM_64917", "guests":3, "room_rate": 33000, "no_of_nights":4, "room_category": "deluxe"}, {"room_number": 102, "room_id": "RM_66480", "guests":3, "room_rate": 15000, "no_of_nights":4, "room_category": "standard"}, {"room_number": 102, "room_id": "RM_71638", "guests":3, "room_rate": 15000, "no_of_nights":4, "room_category": "standard"}]}'; */
/*checkin_data is the json string from the front-end the keys contain aspects of the
transaction */
 // var_dump($checkin_data);
 $checkin_data = json_decode($checkin_data, true);
  //var_dump($checkin_data);

 $guest_name = mysqli_real_escape_string($dbConn, $checkin_data["guest_name"]);
 $guest_type_gender = $checkin_data["guest_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = $checkin_data["phone_number"];
 $contact_address = $checkin_data["contact_address"];
 $room_outstanding = $checkin_data["room_outstanding"];

 $total_rooms_booked = $checkin_data["total_rooms_booked"];
 $total_cost = $checkin_data["total_cost"];
 $deposited = $checkin_data["deposited"];
 $balance = $checkin_data["balance"];
 $means_of_payment = $checkin_data["means_of_payment"];
 $frontdesk_rep = $checkin_data["frontdesk_rep"];
 $rooms = $checkin_data["rooms"];
 $no_of_rooms = count($rooms);

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

 $add_new_guest_query = "INSERT INTO frontdesk_guests (guest_id, guest_name, guest_type_gender, phone_number, contact_address, room_outstanding,  total_rooms_booked) VALUES('$guest_id', '$guest_name', '$guest_type_gender', '$phone_number', '$contact_address', $room_outstanding, $total_rooms_booked)";
 $add_new_guest_result = mysqli_query($dbConn, $add_new_guest_query);
 echo $add_new_guest_query;

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

 /*room check*/
$select_rooms_query = $conn->prepare("SELECT booked, room_number, reserved, reservation_date FROM frontdesk_rooms WHERE room_id = ?");
// var_dump($select_rooms_query);

$select_rooms_query->bind_param("s", $room_id); // continue from here

 for ($i=0; $i<$no_of_rooms; $i++) {
 	$no_of_nights = $rooms[$i]["no_of_nights"];
    $d = strtotime("+"."$no_of_nights days");
    $check_out_date = date("Y-m-d", $d);
 	$room_id = $rooms[$i]["room_id"];
 	$select_rooms_query->execute();
 	$select_rooms_query->bind_result($booked, $room_number, $reserved, $reservation_date);
 	$select_rooms_query->fetch();
 	$rooms[$i]["room_number"] = $room_number;
 	// echo $room_id;
 	// echo mysqli_error($conn);
 	if ($booked == "YES") {
 		$select_rooms_query->close();
	    $msg_response[0] = "ERROR";
	    $msg_response[1] = $room_number . " is already booked";
	    $printer -> close();
	    $response_message = json_encode($msg_response);
 		die($response_message);
 	}
 	$compare_date = date_create($reservation_date);
 	if ($reserved == "YES") {
 	  if ($check_out_date > $compare_date) {
 		$select_rooms_query->close();
	    $msg_response[0] = "ERROR";
	    $msg_response[1] = $room_number . " has checkout date after room reservaton date";
	    $printer -> close();
	    $response_message = json_encode($msg_response);
 		die($response_message);
 	  }
 	}
 }
 $select_rooms_query->close();
 /*room check*/

/*Record sales of individual rooms*/
$insert_into_bookings = $conn->prepare("INSERT INTO frontdesk_bookings (booking_ref, room_number, room_id, room_category, room_rate, guest_name, guest_id, no_of_nights, net_cost, guests, expected_checkout_date, expected_checkout_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, CURRENT_TIME)");
 echo $conn->error;
 var_dump($insert_into_bookings);

$insert_into_bookings->bind_param("sississiiis", $tx_ref, $room_number, $room_id, $room_category, $room_rate, $client_name, $client_id, $no_of_days, $room_net_cost, $guests, $expected_checkout_date);

for ($i=0; $i <$no_of_rooms ; $i++) { 
	$tx_ref = $booking_ref;
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
	$d = strtotime("+"."$no_of_nights days");
	$expected_checkout_date = date("Y-m-d", $d);
	$insert_into_bookings_result = $insert_into_bookings->execute();
	var_dump($insert_into_bookings_result);
	echo $conn->error;
}
$insert_into_bookings->close();

$update_room_query = $conn->prepare("UPDATE frontdesk_rooms SET booked_on = CURRENT_TIMESTAMP, booked = 'YES', guests = ?, current_guest_id = ?, booking_ref = ?, booking_expires = ? WHERE room_id = ?");
$update_room_query->bind_param("issss", $guests, $current_guest_id, $bk_ref, $booking_expires, $room_id);
for ($i=0; $i <$no_of_rooms ; $i++) {
	$no_of_nights = $rooms[$i]["no_of_nights"];
	var_dump($no_of_nights);
	$d = strtotime("+"."$no_of_nights days");
	$booking_expires = date("Y-m-d h:i:s", $d);
	$room_id = $rooms[$i]["room_id"];
	$guests = $rooms[$i]["guests"];
	$bk_ref = $booking_ref;
	$current_guest_id = $guest_id;
	$update_room_query->execute();
}
$update_room_query->close();
/* frontdesk recordings */

/*Record Transaction*/
if ($deposited) {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, amount_balance, net_paid, txn_worth, guest_id, means_of_payment ,date_of_payment) VALUES('$booking_ref', $deposited, $balance, $deposited, $total_cost, '$guest_id', '$means_of_payment', CURRENT_TIMESTAMP)";
} else {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, net_paid, amount_balance, txn_worth, guest_id) VALUES('$booking_ref', $deposited, $deposited, $balance, $total_cost, '$guest_id')";
}

if ($balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$payment_record_result = mysqli_query($dbConn, $payment_record_query);

//var_dump($customer_ref);
$txn_insert_query = "INSERT INTO frontdesk_txn (booking_ref, total_rooms_booked, total_cost, deposited, balance, means_of_payment, payment_status, frontdesk_rep) VALUES('$booking_ref', $total_rooms_booked, $total_cost, $deposited, $balance, '$means_of_payment', '$payment_status', '$frontdesk_rep')";
$txn_insert_result = mysqli_query($dbConn, $txn_insert_query);


/*Print Frontdesk Receipts*/

/*Receipt printer initialization, initial parameters set*/

$fp = fopen("receipt.txt", "w+");

$highSeparator = "--------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

$receiptNo = "RECEIPT NO.:" . $booking_ref ."            ";
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
    fwrite($fprinter, "\x1B\x61\x01");
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, "ROOM BOOKINGS\n");
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, "\x1B\x61\x00");
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
	    	fwrite($fprinter, $rm);
	    	for ($x=0; $x<(17-strlen($array_rooms[count($array_rooms) - 1])); $x++){
			fwrite($fprinter, " ");
		  }
	    } elseif (strlen($rm) < 49) {
	    	$rm = wordwrap($rm, 16, "\n", true);
	    	$array_rooms = explode("\n", $rm);
	    	fwrite($fprinter, $rm);
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