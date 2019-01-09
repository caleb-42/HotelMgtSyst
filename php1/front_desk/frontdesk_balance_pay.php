<?php
include "../settings/connect.php";  //database name = $dbConn
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$printerFile = fopen("assets/printer.txt", "r");
$printName = fgets($printerFile);
fclose($printerFile);

$settings = ["shop_name", "shop_address", "shop_contact", "shop_email"];
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

//$payment_details = '{"guest_id": "BK_9989", "means_of_payment": "CASH", "amount_paid": 1000, "frontdesk_rep": "Joan", "guest_name": "Ewere"}';


$payment_details = $_POST["payment_details"];

$payment_details = json_decode($payment_details, true);
$means_of_payment = $payment_details["means_of_payment"];
$amount_paid = $payment_details["amount_paid"];

if ($amount_paid <= 0) {
  $msg_response[0] = "ERROR";
  $msg_response[1] = "Please input a valid amount";
  $response_message = json_encode($msg_response);
  $printer -> close();
  die($response_message);
}
$frontdesk_rep = $payment_details["frontdesk_rep"];
$guest_name = $payment_details["guest_name"];

$guest_id = $payment_details["guest_id"];
$guest_txn = [];

$get_outstanding = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
$outstanding_result = mysqli_query($dbConn, $get_outstanding);
$outstanding_row = mysqli_fetch_assoc($outstanding_result);
$outstanding_bal = intval($outstanding_row["room_outstanding"]);

if ($amount_paid > $outstanding_bal) {
  $msg_response[0] = "ERROR";
  $msg_response[1] = "outstanding balance is being over paid for, please adjust payment details";
  $response_message = json_encode($msg_response);
  $printer -> close();
  die($response_message);
}

$get_guest_outstanding = "SELECT * FROM frontdesk_txn WHERE guest_id = '$guest_id' AND balance != 0 ORDER BY balance DESC";
$get_guest_result = mysqli_query($dbConn, $get_guest_outstanding);
if (mysqli_num_rows($get_guest_result) == 0) {
    $msg_response[0] = "ERROR";
    $msg_response[1] = "This guest does not have an outstanding room booking balance " . mysqli_num_rows($get_guest_result);
    $response_message = json_encode($msg_response);
    $printer -> close();
    die($response_message);
} else {
  while ($rows = mysqli_fetch_assoc($get_guest_result)) {
    $guest_txn[] = $rows;
    // $msg_response[0] = "ERROR";
    // $msg_response[1] = "This guest has an outstanding room booking balance " . mysqli_num_rows($get_guest_result);
    // $response_message = json_encode($msg_response);
    // $printer -> close();
    // die($response_message);
    //var_dump($guest_txn);
  }
}
$deposit_extra = 1;

$booking_ref = $payment_details["booking_ref"];

for ($i=0; $deposit_extra > 0; $i++) { 
  $booking_ref = $guest_txn[$i]["booking_ref"];
  $last_payment_id_query = "SELECT MAX(id) AS id FROM frontdesk_payments WHERE frontdesk_txn = '$booking_ref'";
  $last_payment_id_result = mysqli_query($dbConn, $last_payment_id_query);
  if ($i == 100) {
    $msg_response[0] = "ERROR";
    $msg_response[1] = "endlesloop";
    $response_message = json_encode($msg_response);
    $printer -> close();
    die($response_message);
  }

  $payment_id_row = mysqli_fetch_array($last_payment_id_result);
  $payment_id = intval($payment_id_row["id"]);

  $last_payment = "SELECT * FROM frontdesk_payments WHERE id = $payment_id";
  $last_payment_result = mysqli_query($dbConn, $last_payment);

  $last_payment_details = mysqli_fetch_assoc($last_payment_result);
  $payment_index = intval($last_payment_details["payment_index"]) + 1;

  $txn_date = $last_payment_details["txn_date"];

  $txn_worth = intval($last_payment_details["txn_worth"]);
  $guest_id = $last_payment_details["guest_id"];
  $total_cost = $last_payment_details["txn_worth"];

  if ((intval($last_payment_details["amount_balance"]) - $amount_paid) >= 0) {
    $new_balance = intval($last_payment_details["amount_balance"]) - $amount_paid;
    $net_paid = intval($last_payment_details["net_paid"]) + $amount_paid;
    $udpate_payment = "INSERT INTO frontdesk_payments (frontdesk_txn, txn_date, amount_paid, date_of_payment, amount_balance, net_paid, txn_worth, guest_id, means_of_payment, frontdesk_rep, payment_index) VALUES ('$booking_ref', '$txn_date', $amount_paid, CURRENT_TIMESTAMP, $new_balance, $net_paid, $txn_worth, '$guest_id', '$means_of_payment', '$frontdesk_rep', $payment_index)";

    $update_payment_result = mysqli_query($dbConn, $udpate_payment);
    $deposit_extra = 0;

    $guest_txn[$i]["booking_ref"] = $booking_ref;
    $guest_txn[$i]["new_balance"] = $new_balance;
    $guest_txn[$i]["payment_index"] = $new_balance;

    if (!($new_balance)) {
       $payment_status = "PAID FULL";
    } else {
       $payment_status = "UNBALANCED";
    }

    $update_txn = "UPDATE frontdesk_txn SET payment_status = '$payment_status', deposited = $net_paid, balance = $new_balance WHERE booking_ref ='$booking_ref'";
    $update_txn_result = mysqli_query($dbConn, $update_txn);

    $update_guest_outstanding = "UPDATE frontdesk_guests SET room_outstanding = room_outstanding - $amount_paid WHERE guest_id  = '$guest_id'";
    $update_outstanding_result = mysqli_query($dbConn, $update_guest_outstanding);
  } else {
      $net_paid = intval($last_payment_details["txn_worth"]);
      $new_pay = intval($last_payment_details["amount_balance"]);
      $new_balance = 0;
      $udpate_payment = "INSERT INTO frontdesk_payments (frontdesk_txn, txn_date, amount_paid, date_of_payment, amount_balance, net_paid, txn_worth, guest_id, means_of_payment, frontdesk_rep, payment_index) VALUES ('$booking_ref', '$txn_date', $new_pay, CURRENT_TIMESTAMP, $new_balance, $net_paid, $txn_worth, '$guest_id', '$means_of_payment', '$frontdesk_rep', $payment_index)";

      $update_payment_result = mysqli_query($dbConn, $udpate_payment);
      $deposit_extra = 1;

      $guest_txn[$i]["booking_ref"] = $booking_ref;
      $guest_txn[$i]["new_balance"] = $new_balance;
      $guest_txn[$i]["payment_index"] = $new_balance;

      if (!($new_balance)) {
           $payment_status = "PAID FULL";
      } else {
           $payment_status = "UNBALANCED";
      }

      $update_txn = "UPDATE frontdesk_txn SET payment_status = '$payment_status', deposited = $net_paid, balance = $new_balance WHERE booking_ref ='$booking_ref'";
      $update_txn_result = mysqli_query($dbConn, $update_txn);

      $update_guest_outstanding = "UPDATE frontdesk_guests SET room_outstanding = room_outstanding - $new_pay WHERE guest_id  = '$guest_id'";
      $update_outstanding_result = mysqli_query($dbConn, $update_guest_outstanding);

      $amount_paid = $amount_paid - intval($last_payment_details["amount_balance"]);
  }
}

$fp = fopen("new_pay.txt", "w+");

$highSeparator = "--------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

// $receiptNo = "BOOKING REF.:" . $booking_ref ."            ";
// $no_of_payments = "PAYMENT INDEX: " . $payment_index . "\n";
$current_date = date("D M d, Y g:i a");
$receipt_time = "Receipt Generated on:\n" . $current_date . "\n";

$header = $biz_add . $biz_contact;

/*Receipt printer initialization, initial parameters set*/
$logo = "assets/logo.png";

function receipt_header($fprinter, $org_name, $header_msg, $high_separator){
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
    fwrite($fprinter, $high_separator);
   }
}

function receipt_body($fprinter, $cost_due, $paid_amount, $balance_amount, $normal_separator, $two_line_separator, $paid_with, $time_of_issue) {
    $paid_string = "Amt. Paid: N". number_format($paid_amount) . "\n";
    $balance_string  = "Balance:   N" . number_format($balance_amount) . "\n";
    $receipt_paid_with = "Paid: $paid_with\n";

    fwrite($fprinter, $normal_separator);
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

  receipt_header($fp, $biz_name, $header, $highSeparator);
  receipt_body($fp, $total_cost, $amount_paid, $outstanding_bal, $separator, $doubleSeparator, $means_of_payment, $receipt_time);
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
//var_dump($update_txn_result);
//var_dump($update_payment_result);

$response_message = json_encode($msg_response);
echo $response_message;
?>