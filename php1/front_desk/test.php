<?php
$to = "tegogs@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: tegovon@gmail.com" . "\r\n" .
"CC: tegusmails@yahoo.com";

mail($to,$subject,$txt,$headers);
?>