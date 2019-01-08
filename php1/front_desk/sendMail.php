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

$reservation_data = json_decode($reservation_data, true);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

$reservation_ref = $reservation_data["reservation_ref"];
$total_cost = 0;
$no_of_rooms = 0;
$net_room_rate = 0;
$guest_id = '';
$phone_number = '';
$email = '';
$reserved_date = '';
$guest_name = '';

$get_all_ref_details_sql = "SELECT * FROM frontdesk_reservations WHERE  reservation_ref = '$reservation_ref' AND cancelled != 'YES'";
$get_all_ref_results = mysqli_query($dbConn, $get_all_ref_details_sql);

$no_of_rooms = mysqli_num_rows($get_all_ref_results);
$i = 0;
while ($row = mysqli_fetch_assoc($get_all_ref_results)) {
    $total_cost = $total_cost + $row["room_total_cost"];
    $net_room_rate = $net_room_rate + $row["room_rate"];
    $guest_id = $row["guest_id"];
    $phone_number = $row["phone_number"];
    $email = $row["email"];
    $reserved_date = $row["reserved_date"];
    $guest_name = $row["guest_name"];
}


$total_rooms_reserved = $no_of_rooms;

$get_all_ref_details_sql = "SELECT * FROM frontdesk_reservation_txn WHERE reservation_ref = '$reservation_ref'";
$get_all_ref_results = mysqli_query($dbConn, $get_all_ref_details_sql);
$arr = mysqli_fetch_assoc($get_all_ref_results);


/* print_r([$reservation_ref, $arr]);
exit; */

$amount_paid = $arr["deposited"];
$balance =  $arr["balance"];
$means_of_payment = $arr["means_of_payment"];

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
    <div class="reservation" style="width:400px; min-height:600px; padding: 0 0 20px;background: #fff; border:#333 solid 1px;">
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
            <div style = "clear:both;"></div>
        </div>
        
        <div class="Address" style = "text-align:center;width: 100%;">
            <p style="font-size:12px;text-decoration:underline; color:rgba(0,0,0,.7);">Address</p>
            <p style="margin:0;font-size:11px;width:90%;text-align:center;display:inline-block;">'.$shop_address.'</p>
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
//echo $email;
$mail->addReplyTo($shop_email, 'Information');
$mail->addCC($email);
$mail->addBCC('ewere.chukwuma@webplayglobal.co.uk');
/* $mail->addCC($email);
$mail->addBCC('ewiscobaba@gmail.com'); */

$mail->WordWrap = 60;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $shop_name . ' reservation';
$mail->Body    = $message_mail;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 if(!$mail->send()) {
     $msg_response =["ERROR", "FAILED"];
     /* echo '';
     echo 'Mailer Error: ' . $mail->ErrorInfo; */
 } else {
     $msg_response[0] = "OUTPUT";
     $msg_response[1] = "SENT";
 }

$response_message = json_encode($msg_response);
echo $response_message;
?>