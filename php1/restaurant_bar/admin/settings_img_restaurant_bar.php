<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn
  //$settings_data = $_POST["settings_data"];
  $msg_response=["OUTPUT", "NOTHING HAPPENED"];

  $settings_data = '{"img_restaurant_data":"data:image/png;base64....."}';
  $settings_data = json_decode($_POST["settings_data"], true);
  $img_restaurant_data = $settings_data["img_restaurant_data"];


  if ((!empty($img_restaurant_data)) && stristr($img_restaurant_data, "data:image/png;base64,")) {
  $img = $img_restaurant_data;
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $imgFileData = base64_decode($img);
  //saving
  $imgFileName = '../assets/logo.png';
  file_put_contents($imgFileName, $imgFileData);
} else {
	$msg_response=["ERROR", "Empty image data provided"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

$msg_response=["OUTPUT", "SUCCESSFUL"];
$response_message = json_encode($msg_response);
echo $response_message;

?>