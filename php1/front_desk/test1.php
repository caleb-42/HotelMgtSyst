<?php
require '../settings/PHPMailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;

$message = '<!DOCTYPE html>
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
            <p style="font-size:12px;margin: 0;">COMPANY NAME</p>
        </div>
        <h1 style="text-align:center;">RESERVATION</h1>
        <div style="width:100%;text-align:center;background:rgb(226, 149, 25);;color:#fff;padding:1px 0;">
            <h5>Name</h5>
            <h3>Paul Akhigbe</h3>
        </div>
        <div style="padding:0 10px 20px">
            <div style="width:30%;float:left;text-align:center;">
                <h6>Reservation Date</h6>
                <h4>23/07/2019</h4>
            </div>
            <div style="width:40%; float:left; text-align:center;">
                <h6>Reservation ID</h6>
                <h4>RESV_4575</h4>
            </div>
            <div style="width:30%;float:right;text-align:center;">
                <h6>Phone Number</h6>
                <h4>4567654323</h4>
            </div>
            <div style="width:30%;float:left;text-align:center;">
                <h6>Total</h6>
                <h4>92000</h4>
            </div>
            <div style="width:40%; float:left; text-align:center;">
                <h6>Paid</h6>
                <h4>60000</h4>
            </div>
            <div style="width:30%;float:right;text-align:center;">
                <h6>Balance</h6>
                <h4>32000</h4>
            </div>
            <div style="width:45%;float:left;text-align:center;margin-bottom:10px;">
                <h6>Means Of Payment</h6>
                <h4>CASH</h4>
            </div>
            <div style="width:45%;float:right;text-align:center;margin-bottom:10px;">
                <h6>Rooms</h6>
                <h4>8</h4>
            </div>
        </div>
        
        <div class="Address" style = "text-align:center;width: 100%;">
            <p style="font-size:12px;text-decoration:underline; color:rgba(0,0,0,.7);">Address</p>
            <p style="margin:0;font-size:11px;width:90%;text-align:center;display:inline-block;">Message could not be sent.Mailer Error: Could not instantiate mail function</p>
        </div>
        <div class="Phone" style = "text-align:center;">
            <p style="font-size:12px;text-decoration:underline; color:rgba(0,0,0,.7);">Phone Number</p>
            <p style="margin:0;font-size:12px;width:90%;text-align:center;display:inline-block;">345475477447</p>
        </div>
    </div>
    
    <script src="" async defer></script>
</body>

</html>';

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'tegovona@gmail.com';                 // SMTP username
$mail->Password = '@steeled#';                           // SMTP password
$mail->SMTPSecure = 'tls';                    // Enable encryption, 'ssl' also accepted

$mail->From = 'tegovona@gmail.com';
$mail->FromName = 'Tegogo';
//$mail->addAddress('tegogs@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('tegogs@gmail.com');               // Name is optional
$mail->addReplyTo('tegovona@gmail.com', 'Information');
$mail->addCC('tegusmails@yahoo.com');
$mail->addBCC('seanglock@yahoo.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}