<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
  //$settings_data = $_POST["settings_data"];
  $msg_response=["OUTPUT", "NOTHING HAPPENED"];

  $settings_data = '{"shop_address":"44 Akhiobare Street", "shop_name": "Webplay Nigeria Ltd", "shop_contact":"08091953375, info@webplaynigeria.net"}';
  $settings_data = json_decode($_POST["settings_data"], true);
  $shop_name = $settings_data["shop_name"];
  $shop_address = $settings_data["shop_address"];
  $shop_contact = $settings_data["shop_contact"];

if ((!empty($shop_name))) {
  $fp = fopen("'../front_desk/assets/shop.txt", "w+");
  fwrite($fp, $shopName);
  fwrite($fp, "\n");
  fwrite($fp, $shopAddr);
  fwrite($fp, "\n");
  fwrite($fp, $shopContact);
  fclose($fp);
} else {
  $msg_response=["ERROR", "Emp"];
  $response_message = json_encode($msg_response);
  die($response_message); 
}
$msg_response=["OUTPUT", "SUCCESSFUL"];
$response_message = json_encode($msg_response);
echo $response_message;

?>