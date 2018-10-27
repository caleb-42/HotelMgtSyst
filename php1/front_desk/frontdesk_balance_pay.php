<?php
include "../settings/connect.php";  //database name = $dbConn
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

$payment_details = '{"booking_ref": "BK_9989", "means_of_payment": "CASH", "amount_paid": 1000, "frontdesk_rep": "Joan", "guest_name": "Ewere"}';


// $payment_details = $_POST["payment_details"];

$payment_details = json_decode($payment_details, true);

$booking_ref = $payment_details["booking_ref"];
$means_of_payment = $payment_details["means_of_payment"];
$amount_paid = $payment_details["amount_paid"];
$frontdesk_rep = $payment_details["frontdesk_rep"];
$guest_name = $payment_details["guest_name"];

$last_payment_id_query = "SELECT MAX(id) AS id FROM frontdesk_payments WHERE frontdesk_txn = '$booking_ref'";
$last_payment_id_result = mysqli_query($dbConn, $last_payment_id_query);

$payment_id_row = mysqli_fetch_array($last_payment_id_result);
$payment_id = intval($payment_id_row["id"]);

$last_payment = "SELECT * FROM frontdesk_payments WHERE id = $payment_id";
$last_payment_result = mysqli_query($dbConn, $last_payment);

$last_payment_details = mysqli_fetch_assoc($last_payment_result);
$new_balance = intval($last_payment_details["amount_balance"]) - $amount_paid;
$payment_index = intval($last_payment_details["payment_index"]) + 1;

$txn_date = $last_payment_details["txn_date"];
$net_paid = intval($last_payment_details["net_paid"]) + $amount_paid;

$txn_worth = intval($last_payment_details["txn_worth"]);
$guest_id = $last_payment_details["guest_id"];
$total_cost = $last_payment_details["txn_worth"];
if ($last_payment_details["amount_balance"] == 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "This transaction has already been fully paid for";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
}

if ($new_balance < 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "This transaction is being over paid for, please adjust payment details";
	$response_message = json_encode($msg_response);
	$printer -> close();
 	die($response_message);
}

// echo $guest_id;
// exit;


$udpate_payment = "INSERT INTO frontdesk_payments (frontdesk_txn, txn_date, amount_paid, date_of_payment, amount_balance, net_paid, txn_worth, guest_id, means_of_payment, frontdesk_rep, payment_index) VALUES ('$booking_ref', '$txn_date', $amount_paid, CURRENT_TIMESTAMP, $new_balance, $net_paid, $txn_worth, '$guest_id', '$means_of_payment', '$frontdesk_rep', $payment_index)";

$update_payment_result = mysqli_query($dbConn, $udpate_payment);

if (!($new_balance)) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$update_txn = "UPDATE frontdesk_txn SET payment_status = '$payment_status', deposited = $net_paid, balance = $new_balance WHERE booking_ref ='$booking_ref'";
$update_txn_result = mysqli_query($dbConn, $update_txn);
echo mysqli_error($dbConn);

$update_guest_outstanding = "UPDATE frontdesk_guest SET room_outstanding = room_outstanding - $amount_paid WHERE guest_id  = '$guest_id'";
$update_outstanding_result = mysqli_query($dbConn, $update_guest_outstanding);


$fp = fopen("new_pay.txt", "w+");

$highSeparator = "--------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

$receiptNo = "BOOKING REF.:" . $booking_ref ."            ";
$no_of_payments = "PAYMENT INDEX: " . $payment_index . "\n";
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

function receipt_body($fprinter, $cost_due, $paid_amount, $balance_amount, $normal_separator, $two_line_separator, $paid_with, $time_of_issue, $payment_no) {
    $paid_string = "Amt. Paid: N". number_format($paid_amount) . "\n";
    $balance_string  = "Balance:   N" . number_format($balance_amount) . "\n";
    $receipt_paid_with = "Paid: $paid_with\n";

    fwrite($fprinter, $normal_separator);
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, $paid_string);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, $receipt_paid_with);
    fwrite($fprinter, $balance_string);
    fwrite($fprinter, $payment_no);
    fwrite($fprinter, "\x1D\x34\x01");
    fwrite($fprinter, "Cost Total: ");
    fwrite($fprinter, "\x1D\x34\x00");
    fwrite($fprinter, "\x1D\x21\x11");
    if ($cost_due) {
	  fwrite($fprinter, "N");
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

  receipt_header($fp, $biz_name, $header, $receiptNo, $highSeparator);
  receipt_body($fp, $total_cost, $amount_paid, $new_balance, $separator, $doubleSeparator, $means_of_payment, $receipt_time, $no_of_payments);
  receipt_footer($fp, $separatorSolid, $partingMsg, $customer_msg, $poweredBy);

  $printData = file_get_contents("new_pay.txt");
  $print_buffer[] = $printData;
  $device = "\\\\" . gethostname() . "\\" . $printName;
  $filename = tempnam(sys_get_temp_dir(), "webpos");
  file_put_contents($filename, $printData);

  copy($filename, $device);       //Print receipt contents
  unlink($filename);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];

if($update_txn_result && $update_payment_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "PAYMENT RECORDS SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}
var_dump($update_txn_result);
var_dump($update_payment_result);

$response_message = json_encode($msg_response);
echo $response_message;
?>