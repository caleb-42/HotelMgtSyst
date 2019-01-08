<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

include "../settings/connect.php"; //$database handler $dbConn or $conn
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$printerFile = fopen("assets/printer.txt", "r");
$printName = fgets($printerFile);
fclose($printerFile);

$settings = ["shop_name", "shop_address", "shop_contact", "frontdesk_bottom_msg", "frontdesk_top_msg"];
$select_settings_query = $conn->prepare("SELECT property_value FROM admin_settings WHERE shop_settings = ?");
$select_settings_query->bind_param("s", $settings_shop);
foreach ($settings as $shop_settings) {
	$settings_shop = $shop_settings;
	$select_settings_query->execute();
	$settings_result = $select_settings_query->get_result();
	$row = $settings_result->fetch_array(MYSQLI_ASSOC);
	${"$settings_shop"} = $row["property_value"];
}
$select_settings_query->close();

$biz_name = $shop_name;
$biz_add = $shop_address . "\n";
$biz_contact = $shop_contact . "\n";

$connector = new WindowsPrintConnector($printName);
$printer = new Printer($connector);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$print_data = json_decode($_POST['reprint'], true);


 $guest_name = mysqli_real_escape_string($dbConn, $print_data['guest']["guest_name"]);
 $guest_type_gender = $print_data['guest']["guest_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = $print_data['guest']["phone_number"];
 $contact_address = $print_data['guest']["contact_address"];
 $room_outstanding = 0;
 $guest_id = $print_data['guest']["guest_id"];

 $total_rooms_booked = $print_data['guest']["total_rooms_booked"];


/* start get booking */
$booking_no = $print_data['booking']['booking_ref'];

$query = "SELECT * FROM frontdesk_bookings WHERE booking_ref = '$booking_no'";
$result = mysqli_query($dbConn, $query);
$arr = [];
if (mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)) {
        $arr[] = $rows;
    }
}

$room_booking = $arr;
print_r($arr);
/* end get booking */

/* start get payment */
$query = "SELECT MAX(id) AS id FROM frontdesk_payments WHERE frontdesk_txn = '$booking_no'";
$result = mysqli_query($dbConn, $query);
$arr = mysqli_fetch_assoc($result);
$id = intval($arr['id']);

$query = "SELECT * FROM frontdesk_payments WHERE id = $id";
$result = mysqli_query($dbConn, $query);
$last_payment = mysqli_fetch_assoc($result);

print_r($last_payment);
/* end get payment */
 $total_cost = $last_payment['txn_worth'];
 $deposited = $last_payment['net_paid'];

 if ($deposited == "") {
 	$deposited = 0;
 }

 $balance = $last_payment['amount_balance'];
 $room_outstanding = $room_outstanding + $balance ;
 $means_of_payment = $last_payment["means_of_payment"];
 $frontdesk_rep = $last_payment["frontdesk_rep"];



 $rooms = $room_booking;
 $no_of_rooms = count($rooms);

 if (($no_of_rooms == 0) || ($no_of_rooms == "")) {
 	$msg_response[0] = "ERROR";
    $msg_response[1] = "No room selected";
    $response_message = json_encode($msg_response);
    die($response_message);
 }
 
if ($balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

/*Print Frontdesk Receipts*/
//exit;
/*Receipt printer initialization, initial parameters set*/

$fp = fopen("receipt.txt", "w+");

$highSeparator = "--------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

$receiptNo = "BOOKING REF.:" . $booking_no ."            ";
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

	    $net_cost_of_rm = $rooms_arr[$i]["net_cost"];
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

$partingMsg = $frontdesk_bottom_msg ."\nPls call again.\nAttendant: $frontdesk_rep\n";
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

