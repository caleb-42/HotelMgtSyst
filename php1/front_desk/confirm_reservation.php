<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn
 require '../settings/PHPMailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;

 // $reservation_data = '{"reservation_ref":"RESV_22097", "amount_paid": 75000, "means_of_payment":"INTERNET TRANSFER","guest_id":"", "frontdesk_rep":"Ada"}';
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

$reservation_data = $_POST["reservation_data"];
 $reservation_out = $reservation_data;

$reservation_data = json_decode($reservation_data, true);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_ref = $reservation_data["reservation_ref"];
$total_cost = 0;
$no_of_rooms = 0;
$rooms = [];
$net_room_rate = 0;

$get_all_ref_details_sql = "SELECT * FROM frontdesk_reservations WHERE deposit_confirmed = 'NO' AND reservation_ref = '$reservation_ref' AND cancelled != 'YES'";
$get_all_ref_results = mysqli_query($dbConn, $get_all_ref_details_sql);
if (mysqli_num_rows($get_all_ref_results)) {
	$no_of_rooms = mysqli_num_rows($get_all_ref_results);
	$i = 0;
	while ($row = mysqli_fetch_assoc($get_all_ref_results)) {
		$total_cost = $total_cost + $row["room_total_cost"];
		$rooms[$i]["room_number"] = $row["room_number"];
		$rooms[$i]["room_id"] = $row["room_id"];
		$rooms[$i]["room_rate"] = $row["room_rate"];
		$net_room_rate = $net_room_rate + $rooms[$i]["room_rate"];
		$guest_id = $row["guest_id"];
		$phone_number = $row["phone_number"];
		$email = $row["email"];
        $reserved_date = $row["reserved_date"];
        $guest_name = $row["guest_name"];
	}
} else {
	$msg_response=["ERROR", "Already confirmed or cancelled reservation"];
	$response_message = json_encode($msg_response);
	die($response_message);
}


$total_rooms_reserved = $no_of_rooms;
$amount_paid = $reservation_data["amount_paid"];
if ($amount_paid == "") {
	$amount_paid = 0;
}
$balance = $total_cost - $amount_paid;
$means_of_payment = $reservation_data["means_of_payment"];
$frontdesk_rep = $reservation_data["frontdesk_rep"];

if ($amount_paid < $net_room_rate) {
	$msg_response =["ERROR", "Deposit must be at least equal to single night(s) of reserved room(s)"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

$update_reservation_query ="UPDATE frontdesk_reservations SET deposit_confirmed = 'YES' WHERE reservation_ref = '$reservation_ref'";

$update_reservation_result = mysqli_query($dbConn, $update_reservation_query);

/*Record Transaction*/
if ($amount_paid) {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, amount_balance, net_paid, txn_worth, guest_id, means_of_payment ,date_of_payment) VALUES ('$reservation_ref', $amount_paid, $balance, $amount_paid, $total_cost, '$guest_id', '$means_of_payment', CURRENT_TIMESTAMP)";
} else {
	$payment_record_query = "INSERT INTO frontdesk_payments (frontdesk_txn, amount_paid, net_paid, amount_balance, txn_worth, guest_id) VALUES ('$reservation_ref', $amount_paid, $amount_paid, $balance, $total_cost, '$guest_id')";
}

if ($balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$payment_record_result = mysqli_query($dbConn, $payment_record_query);

//var_dump($customer_ref);
$txn_insert_query = "INSERT INTO frontdesk_txn (booking_ref, total_rooms_booked, total_cost, deposited, balance, payment_status, frontdesk_rep, means_of_payment, guest_id, transaction_type) VALUES ('$reservation_ref', $total_rooms_reserved, $total_cost, $amount_paid, $balance, '$payment_status', '$frontdesk_rep', '$means_of_payment', '$guest_id', 'RESERVATION')";
$txn_insert_result = mysqli_query($dbConn, $txn_insert_query);

if(($txn_insert_result)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "CONFIRMED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG ". mysqli_error($dbConn);
}

$message_mail = '<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
</head>
<style>
    h3,
    h4 {
        margin-top: 0 !important;
    }
    h6 {
        opacity:.6;
    }
    h4 {
        margin-bottom: 5px !important;
    }
    h6, p{
        margin-bottom: 5px !important;
    }
    h5{
        margin-bottom: 10px !important;
    }
</style>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="reservation" style="width:400px; height:500px; padding: 0 0 20px;background: #fff; border:#333 solid 1px;">
        <div style="width:100%;text-align:center;background:rgb(42, 138, 98);color:#fff;padding: 2px">
            <p style="font-size:12px;margin: 0;">'.$shop_name.'</p>
        </div>
        <h1 style="text-align:center;">RESERVATION</h1>
        <div style="width:100%;text-align:center;background:rgb(226, 149, 25);;color:#fff;padding:1px 0;">
            <h5>Name</h5>
            <h3>'.$guest_name.'</h3>
        </div>
        <div style="padding:0 10px 20px">
            <div style="width:30%;float:left;text-align:center;">
                <h6>Reservation Date</h6>
                <h4>'.$reserved_date.'</h4>
            </div>
            <div style="width:40%; float:left; text-align:center;">
                <h6>Reservation ID</h6>
                <h4>'.$reservation_ref.'</h4>
            </div>
            <div style="width:30%;float:right;text-align:center;">
                <h6>Phone Number</h6>
                <h4>'.$phone_number.'</h4>
            </div>
            <div style="width:30%;float:left;text-align:center;">
                <h6>Total</h6>
                <h4>'.$total_cost.'</h4>
            </div>
            <div style="width:40%; float:left; text-align:center;">
                <h6>Paid</h6>
                <h4>'.$amount_paid.'</h4>
            </div>
            <div style="width:30%;float:right;text-align:center;">
                <h6>Balance</h6>
                <h4>'.$balance.'</h4>
            </div>
            <div style="width:45%;float:left;text-align:center;margin-bottom:10px;">
                <h6>Means Of Payment</h6>
                <h4>'.$means_of_payment.'</h4>
            </div>
            <div style="width:45%;float:right;text-align:center;margin-bottom:10px;">
                <h6>Rooms</h6>
                <h4>'.$total_rooms_reserved.'</h4>
            </div>
<<<<<<< HEAD
=======
            <div style = "clear:both;"></div>
>>>>>>> refs/remotes/origin/tego
        </div>
        
        <div class="Address" style = "text-align:center;width: 100%;">
            <p style="font-size:12px;text-decoration:underline; color:rgba(0,0,0,.7);">'.$shop_address.'</p>
            <p style="margin:0;font-size:11px;width:90%;text-align:center;display:inline-block;"></p>
        </div>
        <div class="Phone" style = "text-align:center;">
            <p style="font-size:12px;text-decoration:underline; color:rgba(0,0,0,.7);">Phone Number</p>
            <p style="margin:0;font-size:12px;width:90%;text-align:center;display:inline-block;">'.$shop_contact.'</p>
        </div>
    </div>
    
    <script src="" async defer></script>
</body>

</html>';
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'eweteg@gmail.com';                 // SMTP username
$mail->Password = 'webplaynigeria';                           // SMTP password
$mail->SMTPSecure = 'tls';                    // Enable encryption, 'ssl' also accepted

$mail->From = 'eweteg@gmail.com';
$mail->FromName = $shop_name;
//$mail->addAddress('tegogs@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress($email);               // Name is optional

$mail->addReplyTo($shop_email, 'Information');
$mail->addCC($shop_email);
$mail->addBCC('ewiscobaba@gmail.com');

$mail->WordWrap = 60;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $shop_name . ' reservation';
$mail->Body    = $message_mail;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    $msg_response =["ERROR", $mail->ErrorInfo];
    // echo '';
    // echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    $msg_response[0] = "OUTPUT";
    $msg_response[1] = "CONFIRMED";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>