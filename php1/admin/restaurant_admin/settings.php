<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn
  //$settings_data = $_POST["settings_data"];
  $msg_response=["OUTPUT", "NOTHING HAPPENED"];

  $settings_data = '{"img_restaurant_data":"data:image/png;base64.....", "img_frontdesk_data":"data:image/png;base64.....", "shop_address":"44 Akhiobare Street", "shop_name": "Webplay Nigeria Ltd", "shop_contact":"08091953375, info@webplaynigeria.net"}';
  $settings_data = json_decode($_POST["settings_data"], true);
  $img_restaurant_data = $settings_data["img_restaurant_data"];
  $img_frontdesk_data = $settings_data["img_frontdesk_data"];
  $shop_name = $settings_data["shop_name"];
  $shop_address = $settings_data["shop_address"];
  $shop_contact = $settings_data["shop_contact"];


  if ((!empty($img_restaurant_data)) && stristr($img_restaurant_data, "data:image/png;base64,")) {
  $img = $img_restaurant_data;
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $imgFileData = base64_decode($img);
  //saving
  $imgFileName = '../restaurant_bar/assets/logo.png';
  file_put_contents($imgFileName, $imgFileData);
} else {
	$msg_response=["ERROR", "Empty image data provided"];
	$response_message = json_encode($msg_response);
	die($response_message);
}

  if ((!empty($img_frontdesk_data)) && stristr($img_frontdesk_data, "data:image/png;base64,")) {
  $img = $img_frontdesk_data;
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $imgFileData = base64_decode($img);
  //saving
  $imgFileName = '../front_desk/assets/logo.png';
  file_put_contents($imgFileName, $imgFileData);
} else {}

if ((!empty($shop_name)) && (!empty($shop_address)) && (!empty($shop_contact))) {
  $fp = fopen("../../debbie/img/shop.txt", "w+");
  fwrite($fp, $shopName);
  fwrite($fp, "\n");
  fwrite($fp, $shopAddr);
  fwrite($fp, "\n");
  fwrite($fp, $shopContact);
  fclose($fp);
}
$msg_response=["OUTPUT", "SUCCESSFUL"];
$response_message = json_encode($msg_response);
echo $response_message;

?>